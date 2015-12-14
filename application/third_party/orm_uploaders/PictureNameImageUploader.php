<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class PictureNameImageUploader extends OrmImageUploader {

  public function getVirtualVersions () {
    return array (
        '4096w' => array ('resize', 4096, 4096, 'width'),
      );
  }
  public function getVersions () {
    return array (
        '' => array (),
      );
  }
}