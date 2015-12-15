<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */
class Pictures extends Delay_controller {

  public function update_name_virtual_versions_color () {
    if (!(($id = OAInput::post ('id')) && ($picture = Picture::find_by_id ($id, array ('select' => 'id, name, color_r, color_g, color_b')))))
      return ;

    $picture->update_color ();

    foreach ($picture->name->getVirtualVersions () as $key => $version)
      $picture->name->save_as ($key, $version);

    if (ENVIRONMENT == 'production')
      $picture->name->compressor ();
  }
  public function update_cover_virtual_versions_color () {
    if (!(($id = OAInput::post ('id')) && ($picture = Picture::find_by_id ($id, array ('select' => 'id, cover')))))
      return ;

    foreach ($picture->cover->getVirtualVersions () as $key => $version)
      $picture->cover->save_as ($key, $version);

    if (ENVIRONMENT == 'production')
      $picture->cover->compressor ();
  }
}
