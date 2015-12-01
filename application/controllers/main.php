<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Main extends Site_controller {

  public function index () {
    return $this
                ->add_js (base_url ('resource', 'javascript', 'imgLiquid_v0.9.944', 'imgLiquid-min.js'))
                ->load_view (array (
                  ));
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
