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

  public function destroy ($token = 0) {
    if (!($pic = Picture::find_by_token ($token, array ('select' => 'id, name'))))
      return $this->output_json (array ('status' => false, 'message' => '當案不存在，或者您的權限不夠喔！'));
    
    $delete = Picture::transaction (function () use ($pic) {
      return $pic->destroy ();
    });
    
    if ($delete)
      return $this->output_json (array ('status' => true, 'message' => '刪除成功！'));
    else
      return $this->output_json (array ('status' => false, 'message' => '刪除失敗！'));
  }

  public function edit ($token = 0) {
    $this->set_frame_path ('frame', 'pure');

    if (!($pic = Picture::find_by_token ($token)))
      return $this->load_view (array (), false);
    else
      return $this->add_hidden (array ('id' => 'update_url', 'value' => base_url ($pic->token)))
                  ->add_js (base_url ('resource', 'javascript', 'thetaview', 'async.js'))
                  ->add_js (base_url ('resource', 'javascript', 'thetaview', 'three.js'))
                  ->add_js (base_url ('resource', 'javascript', 'thetaview', 'OrbitControls.js'))
                  ->add_js (base_url ('resource', 'javascript', 'thetaview', 'theta-viewer.js'))
                  ->load_view (array (
                      'pic' => $pic
                    ), false);
  }

  public function update ($token = 0) {
    if (!($pic = Picture::find_by_token ($token, array ('select' => 'id, x, y, z'))))
      return $this->output_json (array ('status' => false, 'message' => '當案不存在，或者您的權限不夠喔！'));
    
    $posts = OAInput::post ('position');

    if ($msg = $this->_validation_position_posts ($posts))
      return $this->output_json (array ('status' => false, 'message' => $msg));

    if ($columns = array_intersect_key ($posts, $pic->table ()->columns))
      foreach ($columns as $column => $value)
        $pic->$column = $value;

    $update = Picture::transaction (function () use ($pic) {
      if (!$pic->save ())
        return false;
      return true;
    });

    if ($update)
      return $this->output_json (array ('status' => true, 'message' => '更新成功！'));
    else
      return $this->output_json (array ('status' => false, 'message' => '更新失敗！'));
  }
  public function eye ($token = 0) {
    if (!($pic = Picture::find_by_token ($token, array ('select' => 'id, is_visibled'))))
      return redirect_message (array (), array (
          '_flash_message' => '當案不存在，或者您的權限不夠喔！'
        ));
    
    $pic->is_visibled ^= 1;

    $update = Picture::transaction (function () use ($pic) {
      if (!$pic->save ())
        return false;
      return true;
    });

    if ($update)
      return redirect_message (array (), array (
          '_flash_message' => '檢視權限設定成功，(' . ($pic->is_visibled ? '公開' : '非公開') . ')！'
        ));
    else
      return redirect_message (array (), array (
          '_flash_message' => '檢視權限設定失敗！'
        ));
  }

  public function upload () {
    if (!$this->has_post ())
      return $this->output_json (array ('status' => false, 'message' => '非 POST 方法，錯誤的頁面請求！'));

    if (!($picture = OAInput::file ('picture')))
      return $this->output_json (array ('status' => false, 'message' => '上傳檔案失敗！'));

    $info = exif_read_data ($picture['tmp_name']);
    $posts = array_merge (OAInput::post (), read_gps_location ($info), array ('made_at' => convertExifToTimestamp ($info)));

    if ($msg = $this->_validation_upload_posts ($posts))
      return $this->output_json (array ('status' => false, 'message' => $msg));

    $create = Picture::transaction (function () use ($posts, $picture) {
      if (!(verifyCreateOrm ($pic = Picture::create (array_intersect_key ($posts, Picture::table ()->columns))) && $pic->name->put ($picture)))
        return false;

      $pic->token = md5 ($pic->id . '_' . uniqid (rand () . '_'));

      if (!$pic->save ())
        return false;

      delay_job ('pictures', 'update_virtual_versions_color', array ('id' => $pic->id));
      return true;
    });

    if ($create)
      return $this->output_json (array ('status' => true, 'message' => '新增成功！'));
    else
      return $this->output_json (array ('status' => false, 'message' => '新增失敗！'));
  }

  private function _validation_position_posts (&$posts) {
    if (!(isset ($posts['x']) && is_numeric ($posts['x']))) return '格式錯誤！';
    if (!(isset ($posts['y']) && is_numeric ($posts['y']))) return '格式錯誤！';
    if (!(isset ($posts['z']) && is_numeric ($posts['z']))) return '格式錯誤！';

    return '';
  }
  private function _validation_upload_posts (&$posts) {
    if (!isset ($posts['name'])) $posts['name'] = '';
    if (!isset ($posts['made_at'])) $posts['made_at'] = '2011-10-10 10:10:10';
    if (!isset ($posts['token'])) $posts['token'] = md5 (uniqid (rand () . '_'));

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
