<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Uploads extends Site_controller {

  public function __construct () {
    parent::__construct ();
    if (Session::getData ('user') !== 'oa')
      return redirect_message (array ('login'), array (
          '_flash_message' => '請先登入！'
        ));
  }

  public function upload () {
    if (!$this->has_post ())
      return $this->output_json (array ('status' => false));

    if (!($picture = OAInput::file ('picture')))
      return $this->output_json (array ('status' => false));

    $info = exif_read_data ($picture['tmp_name']);
    $posts = array_merge (OAInput::post (), read_gps_location ($info), array ('made_at' => convertExifToTimestamp ($info)));

    if ($msg = $this->_validation_upload_posts ($posts))
      return $this->output_json (array ('status' => false));

    $create = Picture::transaction (function () use ($posts, $picture) {
      if (!(verifyCreateOrm ($pic = Picture::create (array_intersect_key ($posts, Picture::table ()->columns))) && $pic->name->put ($picture)))
        return false;

      delay_job ('pictures', 'update_virtual_versions_color', array ('id' => $pic->id));
      return true;
    });

    return $this->output_json (array ('status' => $create ? true : false));
  }
  private function _validation_upload_posts (&$posts) {
    if (!isset ($posts['name'])) $posts['name'] = '';
    if (!isset ($posts['made_at'])) $posts['made_at'] = '2011-10-10 10:10:10';

    return '';
  }
  public function index () {
    $this
    ->add_hidden (array ('id' => 'upload_url', 'value' => base_url ($this->get_class ())))
    ->add_css (base_url ('resource', 'css', 'jquery-file-upload_v3.1.0', 'uploadfile.css'))
    ->add_js (base_url ('resource', 'javascript', 'jquery-file-upload_v3.1.0', 'jquery.form.js'))
    ->add_js (base_url ('resource', 'javascript', 'jquery-file-upload_v3.1.0', 'jquery.uploadfile.js'))
    ->load_view (array ());
  }
}
