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

  public function single () {
    return $this->load_view ();
  }
  private function _error ($status, $redirect, $msg) {
    return $this->is_ajax () ? $this->output_json (array ('status' => $status, 'message' => $msg)) : redirect_message ($redirect, array ('_flash_message' => $msg));;
  }
  public function upload () {
    if (!$this->has_post ())
      return $this->_error (false, array ('uploads', 'single'), '非 POST 方法，錯誤的頁面請求！');

    if (!($picture = OAInput::file ('picture')))
      return $this->_error (false, array ('uploads', 'single'), '上傳檔案失敗！');

    $info = exif_read_data ($picture['tmp_name']);
    $posts = array_merge (OAInput::post (), read_gps_location ($info), array ('made_at' => convertExifToTimestamp ($info)));

    if ($msg = $this->_validation_upload_posts ($posts))
      return $this->_error (false, array ('uploads', 'single'), $msg);

    $create = Picture::transaction (function () use ($posts, $picture) {
      if (!(verifyCreateOrm ($pic = Picture::create (array_intersect_key ($posts, Picture::table ()->columns))) && $pic->name->put ($picture)))
        return false;

      $pic->token = md5 ($pic->id . '_' . uniqid (rand () . '_'));

      if (!$pic->save ())
        return false;

      delay_job ('pictures', 'update_name_virtual_versions_color', array ('id' => $pic->id));
      return true;
    });

    if ($create)
      return $this->_error (true, array (''), '新增成功！');
    else
      return $this->_error (false, array ('uploads', 'single'), '新增失敗！');
  }
  private function _validation_upload_posts (&$posts) {
    if (!isset ($posts['name'])) $posts['name'] = '';
    if (!isset ($posts['made_at'])) $posts['made_at'] = '2011-10-10 10:10:10';
    if (!isset ($posts['token'])) $posts['token'] = md5 (uniqid (rand () . '_'));

    return '';
  }
}
