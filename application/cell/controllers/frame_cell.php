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
  public function nav () {
    return $this->load_view ();
  }
}