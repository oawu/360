<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class PictureCoverImageUploader extends OrmImageUploader {

  public function getVersions () {
    return array (
        '' => array (),
        '640w' => array ('resize', 640, 640, 'width'),
        '1200x630c' => array ('adaptiveResizeQuadrant', 1200, 630, 'c')
      );
  }
}