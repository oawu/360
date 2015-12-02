<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class PictureNameImageUploader extends OrmImageUploader {

  public function virtualVersions () {
    return array (
        '256w' => array ('resize', 256, 256, 'width'),
        '512w' => array ('resize', 512, 512, 'width'),
        '1024w' => array ('resize', 1024, 1024, 'width'),
        '2048w' => array ('resize', 2048, 2048, 'width'),
        '4096w' => array ('resize', 4096, 4096, 'width'),
      );
  }
  public function getVersions () {
    return array (
        '' => array ()
      );
  }
}