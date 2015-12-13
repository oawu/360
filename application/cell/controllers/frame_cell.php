<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Frame_cell extends Cell_Controller {

  /* render_cell ('frame_cell', 'nav', var1, ..); */
  // public function _cache_nav () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function nav ($back = false) {
    if ($back && ($back_url = Session::getData ('back_url')))
      Session::setData ('back_url', $back_url);
    else if ($back && isset ($_SERVER['HTTP_REFERER']) && preg_match ('#^' . base_url ('[0-9]?') . '$#', $back_url = $_SERVER['HTTP_REFERER']))
      Session::setData ('back_url', $back_url);
    else
      Session::setData ('back_url', $back_url = '');

    return $this->load_view (array (
        'back_url' => $back_url
      ));
  }

  /* render_cell ('frame_cell', 'pagination', $pagination); */
  // public function _cache_pagination () {
  //   return array ('time' => 60 * 60, 'key' => null);
  // }
  public function pagination ($pagination) {
    return $this->setUseCssList (true)
                ->load_view (array ('pagination' => $pagination));
  }
}