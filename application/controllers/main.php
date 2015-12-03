<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Main extends Site_controller {

  public function index ($token = 0) {
    $pics = Picture::find ('all', array (
        'order' => 'id DESC',
        'limit' => 20,
        'conditions' => Session::getData ('user') === 'oa' ? array () : array ('is_visibled = ?', 1)
      ));

    $pic = Picture::find_by_token ($token, array ('select' => 'token'));

    return $this->add_hidden (array ('id' => 'content_url', 'value' => $pic ? base_url ('content', $pic->token) : ''))

                ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox.css'))
                ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.css'))
                ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.css'))
                ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'my.css'))

                ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox.js'))
                ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.js'))
                ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.js'))
                ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-media.js'))

                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'async.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'three.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'OrbitControls.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'theta-viewer.js'))
                ->load_view (array (
                    'pics' => $pics
                  ));
  }
  public function location ($token = 0) {
    $this->set_frame_path ('frame', 'pure');

    if (!($pic = Picture::find_by_token ($token)))
      return $this->load_view (array (), false);
    else
      return $this->add_js ('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=zh-TW')
                  ->load_view (array (
                      'pic' => $pic
                    ), false);
  }
  public function content ($token = 0) {
    $this->set_frame_path ('frame', 'pure');

    if (!($pic = Picture::find_by_token ($token)))
      return $this->load_view (array (), false);
    else
      return $this->add_js (base_url ('resource', 'javascript', 'thetaview', 'async.js'))
                  ->add_js (base_url ('resource', 'javascript', 'thetaview', 'three.js'))
                  ->add_js (base_url ('resource', 'javascript', 'thetaview', 'OrbitControls.js'))
                  ->add_js (base_url ('resource', 'javascript', 'thetaview', 'theta-viewer.js'))
                  ->load_view (array (
                      'pic' => $pic
                    ), false);
  }
  public function login () {
    $posts = Session::getData ('posts', true);
    return $this->load_view (array (
                    'posts' => $posts
                  ));
  }
  public function signin () {
    if (!$this->has_post ())
      return redirect_message (array ('login'), array (
          '_flash_message' => '非 POST 方法，錯誤的頁面請求。'
        ));
    
    $posts = OAInput::post ();

    if ($msg = $this->_validation_login_posts ($posts))
      return redirect_message (array ('login'), array (
          '_flash_message' => $msg,
          'posts' => $posts
        ));

    if (($posts['account'] == 'oa') && (md5 ($posts['password']) == '9015d0e6bab8a3563146ce54392f39b4')) {
      Session::setData ('user', 'oa');
      return redirect_message (array (''), array (
          '_flash_message' => '登入成功！',
        )); 
    } else {
      return redirect_message (array ('login'), array (
          '_flash_message' => '帳號或密碼錯誤！',
          'posts' => $posts
        ));      
    }
  }
  private function _validation_login_posts (&$posts) {
    if (!(isset ($posts['account']) && ($posts['account'] = trim ($posts['account']))))
      return '沒有填寫帳號！';
    if (!(isset ($posts['password']) && ($posts['password'] = trim ($posts['password']))))
      return '沒有填寫密碼！';

    return '';
  }
  public function logout () {
    Session::setData ('user', null);

    return redirect_message (array (''), array (
        '_flash_message' => '登出成功！'
      ));
  }
  public function register () {
    return $this->load_view (array (
                  ));
  }
}
