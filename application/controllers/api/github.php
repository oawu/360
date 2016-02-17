<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Github extends Site_controller {
  private $url;

  public function __construct () {
    parent::__construct ();

    header ('Content-type: text/html');
    if (ENVIRONMENT == 'production')
      header ('Access-Control-Allow-Origin: ' . ($this->url = 'http://comdan66.github.io'));
    else
      header ('Access-Control-Allow-Origin: ' . ($this->url = 'http://dev.comdan66.github.io'));
  
  }
  public function location () {
    if (!(($token = OAInput::get ('token')) && ($pic = Picture::find_by_token ($token, array ('select' => 'id, cover, latitude, longitude')))))
      return $this->output_json (array ('status' => false, 'msg' => '當案不存在，或者您的權限不夠喔！'));

    return $this->output_json (array ('status' => true, 'picture' => array (
        'latitude' => $pic->location () ? $pic->latitude : 25.04, 
        'longitude' => $pic->location () ? $pic->longitude : 121.55,
        'zoom' => $pic->location () ? 16 : 12,
        'cover' => $pic->cover->url ('640x640c')
      )));
  }
  public function picture () {
    if (!(($token = OAInput::get ('token')) && ($pic = Picture::find_by_token ($token))))
      return $this->output_json (array ('status' => false, 'msg' => '當案不存在，或者您的權限不夠喔！'));

    $pic->pv += 1;
    $pic->save ();

    return $this->output_json (array ('status' => true, 'picture' => array (
        'token' => $pic->token,
        'url' => $pic->name->url ('4096w'),
        'position' => $pic->position (),
        'pv' => $pic->pv,
        'rotated' => $pic->is_rotated,
        'next' => $pic->next () ? $pic->next ()->token : '',
        'prev' => $pic->prev () ? $pic->prev ()->token : '',
      )));
  }
  public function pictures ($offset = 0) {
    $columns = array ();
    $configs = array ('api', $this->get_class (), $this->get_method (), '%s');
    $conditions = array (implode (' AND ', conditions ($columns, $configs, 'Picture', OAInput::get ())));
    Picture::addConditions ($conditions, 'is_visibled = ?', 1);
    Picture::addConditions ($conditions, 'cover != ?', '');

    $limit = 12;
    $total = Picture::count (array ('conditions' => $conditions));
    $offset = $offset < $total ? $offset : 0;
    $pics = Picture::find ('all', array (
        'select' => 'id, token, cover, pv, x, y, z, is_rotated, latitude, longitude',
        'order' => 'id DESC',
        'limit' => $limit,
        'offset' => $offset,
        'conditions' => $conditions
      ));

    $this->load->library ('pagination');
    $configs['uri_segment'] = 4;
    $pagination = $this->pagination->initialize (array_merge (array ('total_rows' => $total, 'num_links' => 3, 'per_page' => $limit, 'uri_segment' => 0, 'page_query_string' => false, 'first_link' => '第一頁', 'last_link' => '最後頁', 'prev_link' => '上一頁', 'next_link' => '下一頁', 'full_tag_open' => '<ul class="pagination">', 'full_tag_close' => '</ul>', 'first_tag_open' => '<li class="f">', 'first_tag_close' => '</li>', 'prev_tag_open' => '<li class="p">', 'prev_tag_close' => '</li>', 'num_tag_open' => '<li>', 'num_tag_close' => '</li>', 'cur_tag_open' => '<li class="active"><a href="#">', 'cur_tag_close' => '</a></li>', 'next_tag_open' => '<li class="n">', 'next_tag_close' => '</li>', 'last_tag_open' => '<li class="l">', 'last_tag_close' => '</li>'), $configs))->create_links ();

    return $this->output_json (array (
        'status' => true,
        'pictures' => array_map (function ($pic) {
            return array (
                'token' => $pic->token,
                'cover' => $pic->cover->url ('640x640c'),
                'pv' => $pic->pv,
                'rotated' => $pic->is_rotated,
                'location' => $pic->location ()
              );
          }, $pics),
        'pagination' => $pagination
      ));
  }
}
