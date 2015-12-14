<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Modify extends Site_controller {

  public function __construct () {
    parent::__construct ();
    if (Session::getData ('user') !== 'oa')
      return redirect_message (array ('login'), array (
          '_flash_message' => '請先登入！'
        ));
  }

  public function edit ($token = '') {
    if (!($pic = Picture::find_by_token ($token)))
      return redirect_message (array (''), array (
          '_flash_message' => ''
        ));

    return $this->add_js (base_url ('resource', 'javascript', 'thetaview', 'async.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'three.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'OrbitControls.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'theta-viewer.js'))
                ->load_view (array (
                    'footer' => false,
                    'pic' => $pic
                  ));
  }
  
  private function _validation_rotated_posts (&$posts) {
    if (!(isset ($posts['is_rotated']) && is_numeric ($posts['is_rotated']) && in_array ($posts['is_rotated'], array (0, 1)))) return '參數錯誤！';

    return '';
  }
  private function _validation_visibled_posts (&$posts) {
    if (!(isset ($posts['is_visibled']) && is_numeric ($posts['is_visibled']) && in_array ($posts['is_visibled'], array (0, 1)))) return '參數錯誤！';

    return '';
  }
  private function _validation_position_posts (&$posts) {
    if (!(isset ($posts['x']) && is_numeric ($posts['x']))) return 'Position 格式錯誤！';
    if (!(isset ($posts['y']) && is_numeric ($posts['y']))) return 'Position 格式錯誤！';
    if (!(isset ($posts['z']) && is_numeric ($posts['z']))) return 'Position 格式錯誤！';

    return '';
  }
  public function cover_position ($token = 0) {
    if (!$this->is_ajax ())
      return $this->output_json (array ('status' => false, 'message' => '存取檔案方式錯誤！'));

    if (!($pic = Picture::find_by_token ($token, array ('select' => 'id, cover, x, y, z'))))
      return $this->output_json (array ('status' => false, 'message' => '當案不存在，或者您的權限不夠喔！'));
    
    $posts = OAInput::post ('position');
    $cover = OAInput::post ('cover', false);
    $cover = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $cover));
    $file = FCPATH . implode (DIRECTORY_SEPARATOR, Cfg::system ('orm_uploader', 'uploader', 'temp_directory')) . DIRECTORY_SEPARATOR . uniqid (rand () . '_');
    file_put_contents ($file, $cover);

    if ($msg = $this->_validation_position_posts ($posts))
      return $this->output_json (array ('status' => false, 'message' => $msg));

    if ($columns = array_intersect_key ($posts, $pic->table ()->columns))
      foreach ($columns as $column => $value)
        $pic->$column = $value;

    $update = Picture::transaction (function () use ($pic, $file) {
      if (!$pic->save ())
        return false;

      if (is_file ($file) && $pic->cover->put ($file))
        delay_job ('pictures', 'update_cover_virtual_versions_color', array ('id' => $pic->id));

      return true;
    });

    if ($update)
      return $this->output_json (array ('status' => true, 'message' => '更新成功！'));
    else
      return $this->output_json (array ('status' => false, 'message' => '更新失敗！'));
  }
  public function visibled ($token = 0) {
    if (!($pic = Picture::find_by_token ($token, array ('select' => 'id, is_visibled'))))
      return $this->output_json (array ('status' => false, 'message' => '當案不存在，或者您的權限不夠喔！'));
    
    $posts = OAInput::post ();

    if ($msg = $this->_validation_visibled_posts ($posts))
      return $this->output_json (array ('status' => false, 'message' => $msg, 'content' => $pic->is_visibled ? '公開' : '不公開'));

    if ($columns = array_intersect_key ($posts, $pic->table ()->columns))
      foreach ($columns as $column => $value)
        $pic->$column = $value;

    $update = Picture::transaction (function () use ($pic) {
      if (!$pic->save ())
        return false;

      return true;
    });

    if ($update)
      return $this->output_json (array ('status' => true, 'message' => '更新成功！', 'content' => $pic->is_visibled ? '公開' : '不公開'));
    else
      return $this->output_json (array ('status' => false, 'message' => '更新失敗！', 'content' => $pic->is_visibled ? '公開' : '不公開'));
  }
  public function rotated ($token = 0) {
    if (!($pic = Picture::find_by_token ($token, array ('select' => 'id, is_rotated'))))
      return $this->output_json (array ('status' => false, 'message' => '當案不存在，或者您的權限不夠喔！'));
    
    $posts = OAInput::post ();

    if ($msg = $this->_validation_rotated_posts ($posts))
      return $this->output_json (array ('status' => false, 'message' => $msg, 'content' => $pic->is_rotated ? '旋轉' : '不旋轉'));

    if ($columns = array_intersect_key ($posts, $pic->table ()->columns))
      foreach ($columns as $column => $value)
        $pic->$column = $value;

    $update = Picture::transaction (function () use ($pic) {
      if (!$pic->save ())
        return false;

      return true;
    });

    if ($update)
      return $this->output_json (array ('status' => true, 'message' => '更新成功！', 'content' => $pic->is_rotated ? '旋轉' : '不旋轉'));
    else
      return $this->output_json (array ('status' => false, 'message' => '更新失敗！', 'content' => $pic->is_rotated ? '旋轉' : '不旋轉'));
  }
  public function destroy ($token = 0) {
    if (!($pic = Picture::find_by_token ($token, array ('select' => 'id, name'))))
      return redirect_message (array (''), array (
          '_flash_message' => '當案不存在，或者您的權限不夠喔！'
        ));
    
    $delete = Picture::transaction (function () use ($pic) {
      return $pic->destroy ();
    });
    
    return redirect_message (array (''), array (
        '_flash_message' => $delete ? '刪除成功！' : '刪除失敗！'
      ));
  }
}
