<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Main extends Site_controller {

  public function content ($token = 0) {
    if (!($pic = Picture::find_by_token ($token)))
      return redirect_message (array (''), array (
          '_flash_message' => ''
        ));

    $tags = array (
        '1200x630c' => 'larger',
        '600x315c' => 'small',
        '600x314c' => 'non-stoty',
        '600x600c' => 'story',
        '200x200c' => 'mini',
      );
    foreach ($pic->cover->virtualVersions () as $key => $version) {
      $size = count (array_filter ($size = preg_split ('/[xX]/', preg_replace ('/[^\dx]/', '', '1200x630c')), function ($t) { return is_numeric ($t); })) == 2 ? $size : array ();

      if (!preg_match ('/^data:/', $og_img = $pic->cover->url ($key)))
        $this->add_meta (array ('property' => 'og:image', 'tag' => $tags[$key], 'content' => $og_img, 'alt' => $pic->made_at->format ('Y-m-d H:i:s') . ' - ' . Cfg::setting ('site', 'main', 'title')))
             ->add_meta (array ('property' => 'og:image:type', 'tag' => $tags[$key], 'content' => 'image/' . pathinfo ($og_img, PATHINFO_EXTENSION)));
      if ($size)
        $this->add_meta (array ('property' => 'og:image:width', 'tag' => $tags[$key], 'content' => $size[0]))
             ->add_meta (array ('property' => 'og:image:height', 'tag' => $tags[$key], 'content' => $size[1]));
    }

    return $this->add_js (base_url ('resource', 'javascript', 'thetaview', 'async.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'three.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'OrbitControls.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'theta-viewer.js'))
                ->load_view (array (
                    'pic' => $pic
                  ));
  }

  public function index ($offset = 0) {
    $columns = array ();
    $configs = array ('%s');
    $conditions = array (implode (' AND ', conditions ($columns, $configs, 'Picture', OAInput::get ())));
    if (Session::getData ('user') !== 'oa') Picture::addConditions ($conditions, 'is_visibled = ?', 1);

    $limit = 12;
    $total = Picture::count (array ('conditions' => $conditions));
    $offset = $offset < $total ? $offset : 0;
    $pictures = Picture::find ('all', array (
        'order' => 'id DESC',
        'limit' => $limit,
        'offset' => $offset,
        'conditions' => $conditions
      ));

    $this->load->library ('pagination');
    $configs['uri_segment'] = 1;
    $pagination = $this->pagination->initialize (array_merge (array ('total_rows' => $total, 'num_links' => 3, 'per_page' => $limit, 'uri_segment' => 0, 'page_query_string' => false, 'first_link' => '第一頁', 'last_link' => '最後頁', 'prev_link' => '上一頁', 'next_link' => '下一頁', 'full_tag_open' => '<ul class="pagination">', 'full_tag_close' => '</ul>', 'first_tag_open' => '<li class="f">', 'first_tag_close' => '</li>', 'prev_tag_open' => '<li class="p">', 'prev_tag_close' => '</li>', 'num_tag_open' => '<li>', 'num_tag_close' => '</li>', 'cur_tag_open' => '<li class="active"><a href="#">', 'cur_tag_close' => '</a></li>', 'next_tag_open' => '<li class="n">', 'next_tag_close' => '</li>', 'last_tag_open' => '<li class="l">', 'last_tag_close' => '</li>'), $configs))->create_links ();

    return $this->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox.css'))
                ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.css'))
                ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.css'))
                ->add_css (base_url ('resource', 'css', 'fancyBox_v2.1.5', 'my.css'))
                ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox.js'))
                ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-buttons.js'))
                ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-thumbs.js'))
                ->add_js (base_url ('resource', 'javascript', 'fancyBox_v2.1.5', 'jquery.fancybox-media.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'async.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'three.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'OrbitControls.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'theta-viewer.js'))
                ->load_view (array (
                    'pictures' => $pictures,
                    'pagination' => $pagination
                  ));
  }

  public function location ($token = 0) {
    $this->set_frame_path ('frame', 'pure');

    if (!($pic = Picture::find_by_token ($token)))
      return $this->load_view (array (), false);
    else
      return $this->add_js ('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=zh-TW')
                  ->load_view (array (
                      'pic' => $pic
                    ), false);
  }
  public function cover ($token = 0) {
    if (!$this->is_ajax ())
      return $this->output_json (array ('status' => false, 'message' => '存取檔案方式錯誤！'));

    if (!($pic = Picture::find_by_token ($token, array ('select' => 'id, cover'))))
      return $this->output_json (array ('status' => false, 'message' => '當案不存在，或者您的權限不夠喔！'));
    
    $cover = OAInput::post ('cover', false);
    $cover = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $cover));
    $file = FCPATH . implode (DIRECTORY_SEPARATOR, Cfg::system ('orm_uploader', 'uploader', 'temp_directory')) . DIRECTORY_SEPARATOR . uniqid (rand () . '_');
    file_put_contents ($file, $cover);
    
    $update = Picture::transaction (function () use ($pic, $file) {
      if (!$pic->cover->put ($file))
        return false;
      
      delay_job ('pictures', 'update_cover_virtual_versions_color', array ('id' => $pic->id));
      return true;
    });

    if ($update)
      return $this->output_json (array ('status' => true));
    else
      return $this->output_json (array ('status' => false, 'message' => '上傳失敗！'));
  }
}
