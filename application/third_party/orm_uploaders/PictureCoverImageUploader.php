<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class PictureCoverImageUploader extends OrmImageUploader {

  public function getVirtualVersions () {
    return array (
        '1200x630c' => array ('adaptiveResizeQuadrant', 1200, 630, 'c'),
        '600x315c' => array ('adaptiveResizeQuadrant', 600, 315, 'c'),
        '600x314c' => array ('adaptiveResizeQuadrant', 600, 314, 'c'),
        '600x600c' => array ('adaptiveResizeQuadrant', 600, 600, 'c'),
        '200x200c' => array ('adaptiveResizeQuadrant', 200, 200, 'c'),
      );
  }
  public function getVersions () {
    return array (
        '' => array (),
        '640x640c' => array ('adaptiveResizeQuadrant', 640, 640, 'c'),
      );
  }
}