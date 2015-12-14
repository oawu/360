<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class CompressorIo {
  const URL = 'https://compressor.io/server/Lossy.php';
  static $tempDir = array ('temp');
  const CURLOPT_TIMEOUT = 300;
  const CURLOPT_USERAGENT = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.80 Safari/537.36';

  public function __construct () {}
  
  private static function _getCurlValue ($filename, $postname = '') {
    $contentType = 'image/' . pathinfo ($filename, PATHINFO_EXTENSION);
    $postname = $postname ? $postname : (uniqid (rand () . '_') . '.' . pathinfo ($filename, PATHINFO_EXTENSION));

    if (function_exists ('curl_file_create') && $contentType) {
      return curl_file_create ($filename, $contentType, $postname);
    }
 
    $value = '@' . $filename . ';filename=' . $postname;
    if ($contentType)
      $value .= ';type=' . $contentType;
 
    return $value;
  }
  
  private static function _getFile ($url, $cookies = array (), $fileName = null) {
    array_walk ($cookies, function (&$value, $key) {$value = $key . '=' . $value;});

    $options = array (
      CURLOPT_URL => $url,
      CompressorIo::CURLOPT_TIMEOUT => 120,
      CURLOPT_COOKIE => implode ($cookies, ';'),
      CURLOPT_HEADER => false,
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_AUTOREFERER => true,
      CURLOPT_CONNECTTIMEOUT => 30,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_USERAGENT => CompressorIo::CURLOPT_USERAGENT
    );

    $ch = curl_init ($url);
    curl_setopt_array ($ch, $options);
    $data = curl_exec ($ch);
    curl_close ($ch);

    if (!$fileName) return $data;

    $write = fopen ($fileName, 'w');
    fwrite ($write, $data);
    fclose ($write);

    $oldmask = umask (0);
    @chmod ($fileName, 0777);
    umask ($oldmask);

    return filesize ($fileName) ?  $fileName : null;
  }

  private static function _curl ($posts, &$cookies) {
    if (!$posts)
      return array ();

    $options = array (
      CURLOPT_URL => CompressorIo::URL, 
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => $posts,
      CompressorIo::CURLOPT_TIMEOUT => 120, 
      CURLOPT_HEADER => 1, 
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_AUTOREFERER => true, 
      CURLOPT_CONNECTTIMEOUT => 30, 
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_USERAGENT => CompressorIo::CURLOPT_USERAGENT
    );

    $ch = curl_init (CompressorIo::URL);
    curl_setopt_array ($ch, $options);
    $data = curl_exec ($ch);
    $header_size = curl_getinfo ($ch, CURLINFO_HEADER_SIZE);
    curl_close ($ch);


    $header = substr ($data, 0, $header_size);
    $body = substr ($data, $header_size);
    
    preg_match_all ('/^Set-Cookie:\s*([^;]*)/mi', $header, $matches);
    $cookies = array ();
    foreach ($matches[1] as $item) {
      parse_str ($item, $cookie);
      $cookies = array_merge ($cookies, $cookie);
    }

    $data = (($body = json_decode ($body, true)) && isset ($body['files']) && count ($body['files'])) ? $body['files'] : array ();

    $data = array_combine (array_map (function ($t) {
      return $t['name'];
    }, $data), array_map (function ($t) {
      return $t['url'];
    }, $data));

    return $data;
  }

  public static function post ($oriFiles, &$cookies) {
    $files = is_string ($oriFiles) ? $files = array ($oriFiles) : array_splice ($oriFiles, 0);
    $files = array_combine ($files, array_map (function ($oriFile) { return array (
        'postname' => $postname = uniqid (rand () . '_') . '.' . pathinfo ($oriFile, PATHINFO_EXTENSION),
        'realpath' => $realpath = realpath ($oriFile),
        'curl' => $realpath ? self::_getCurlValue (realpath ($oriFile), $postname) : array ()
      ); }, $files));

    $i = count ($posts = array ());
    foreach ($files as $file)
      if ($file['curl'])
        $posts['files[' . $i++ . ']'] = $file['curl'];
    
    $data = self::_curl ($posts, $cookies);

    if (!$data)
      return is_string ($oriFiles) ? '' : array_map (function () {
        return '';
      }, $files);
    
    foreach ($files as $key => &$file)
      $file = isset ($data[$file['postname']]) ? $data[$file['postname']] : '';
   
    return is_string ($oriFiles) ? isset ($files[$oriFiles]) ? $files[$oriFiles] : '' : $files;
  }

  public static function download ($datas, $cookies, $originName = false) {
    $result = array ();
    foreach ($datas as $key => $value)
      $result[$key] = $value ? self::_getFile ($value, $cookies, $originName ? ($key) : (FCPATH . implode (DIRECTORY_SEPARATOR, CompressorIo::$tempDir) . DIRECTORY_SEPARATOR . uniqid (rand () . '_') . '.' . pathinfo ($key, PATHINFO_EXTENSION))) : '';
    return $result;
  }

  public static function postAndDownload ($oriFiles, $originName = false) {
    $cookies = array ();

    $files = is_string ($oriFiles) ? $files = array ($oriFiles) : array_splice ($oriFiles, 0);
    $result = self::download (self::post ($files, $cookies), $cookies, $originName);

    return is_string ($oriFiles) ? isset ($result[$oriFiles]) ? $result[$oriFiles] : '' : $result;
  }
}
