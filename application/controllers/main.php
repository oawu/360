<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Main extends Site_controller {

  public function index () {
    $pic = Picture::create (array (
            'name' => 'xxx',
        ));
    $pic->name->put_url ('http://images.all-free-download.com/images/graphiclarge/daisy_pollen_flower_220533.jpg');
    echo $pic->name->url ();;
  }
}
