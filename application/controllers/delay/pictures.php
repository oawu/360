<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */
class Pictures extends Delay_controller {

  public function update_name_virtual_versions_color () {
    if (!(($id = OAInput::post ('id')) && ($picture = Picture::find_by_id ($id, array ('select' => 'id, name, color_r, color_g, color_b, is_compressor')))))
      return ;

    $picture->update_color ();

    foreach ($picture->name->getVirtualVersions () as $key => $version)
      $picture->name->save_as ($key, $version);

    if (ENVIRONMENT == 'production')
      $this->_compressor ($picture, array ('4096w'), 'name', 'is_compressor');
  }
  public function update_cover_virtual_versions_color () {
    if (!(($id = OAInput::post ('id')) && ($picture = Picture::find_by_id ($id, array ('select' => 'id, cover, is_compressor')))))
      return ;

    foreach ($picture->cover->getVirtualVersions () as $key => $version)
      $picture->cover->save_as ($key, $version);

    if (ENVIRONMENT == 'production')
      echo $this->_compressor ($picture, array ('640x640c'), 'cover', 'is_compressor');
  }

  private function _compressor ($picture, $sizes = array (), $column, $flog_column, $limit = 10) {
    require_once ('vendor/autoload.php');

    foreach ($sizes as $size) {
      @S3::getObject (Cfg::system ('orm_uploader', 'uploader', 's3', 'bucket'), implode (DIRECTORY_SEPARATOR, $picture->$column->path ($size)), $path = FCPATH . 'temp' . DIRECTORY_SEPARATOR . $size . '_' . $picture->$column);

      if (!file_exists ($path)) return 'Download Error!';
      if (!$key = keys ('tinypngs', Cfg::setting ('tinypng', 'psw'))) return 'No any key Error!';

      try {
        \Tinify\setKey ($key);
        \Tinify\validate ();

        if (!(($source = \Tinify\fromFile ($path)) && ($source->toFile ($path)))) return 'Tinify toFile Error!';
      } catch (Exception $e) { return $e->toMessage () . 'Tinify try catch Error!'; }

      $s3_path = implode (DIRECTORY_SEPARATOR, array_merge ($picture->$column->getBaseDirectory (), $picture->$column->getSavePath ())) . DIRECTORY_SEPARATOR . $size . '_' . $picture->$column;
      $bucket = Cfg::system ('orm_uploader', 'uploader', 's3', 'bucket');

      if (!($source->store (array ('service' => 's3', 'aws_access_key_id' => Cfg::system ('s3', 'buckets', $bucket, 'access_key'), 'aws_secret_access_key' => Cfg::system ('s3', 'buckets', $bucket, 'secret_key'), 'region' => Cfg::system ('s3', 'buckets', $bucket, 'region'), 'path' => $bucket . DIRECTORY_SEPARATOR . $s3_path)))) return 'Put s3 Error!';
      @unlink ($path);
    }

    $picture->$flog_column = 1;
    if (!$picture->save ()) return 'Save Error!';
    return '';
  }
}
