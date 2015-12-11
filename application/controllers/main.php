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

    if (!preg_match ('/^data:/', $og_img = $pic->cover->url ('1200x630c')))
      $this->add_meta (array ('property' => 'og:image', 'content' => $og_img, 'alt' => $pic->made_at->format ('Y-m-d H:i:s') . ' - ' . Cfg::setting ('site', 'main', 'title')))
           ->add_meta (array ('property' => 'og:image:type', 'content' => 'image/' . pathinfo ($og_img, PATHINFO_EXTENSION)))
           ->add_meta (array ('property' => 'og:image:width', 'content' => '1200'))
           ->add_meta (array ('property' => 'og:image:height', 'content' => '630'));

    return $this->add_js (base_url ('resource', 'javascript', 'thetaview', 'async.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'three.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'OrbitControls.js'))
                ->add_js (base_url ('resource', 'javascript', 'thetaview', 'theta-viewer.js'))
                ->load_view (array (
                    'pic' => $pic
                  ));
  }

  public function index () {
    $pics = Picture::find ('all', array (
        'order' => 'id DESC',
        'limit' => 20,
        'conditions' => array ('is_visibled = ?', 1)
      ));

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
                    'pics' => $pics
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
    if (!($pic = Picture::find_by_token ($token, array ('select' => 'id, cover'))))
      return $this->output_json (array ('status' => false, 'message' => '當案不存在，或者您的權限不夠喔！'));
    
    $cover = OAInput::post ('cover', false);
    $cover = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $cover));
    $file = FCPATH . implode (DIRECTORY_SEPARATOR, Cfg::system ('orm_uploader', 'uploader', 'temp_directory')) . DIRECTORY_SEPARATOR . uniqid (rand () . '_');
    file_put_contents ($file, $cover);
    
    $update = Picture::transaction (function () use ($pic, $file) {
      if (!$pic->cover->put ($file))
        return false;
      return true;
    });

    if ($update)
      return $this->output_json (array ('status' => true));
    else
      return $this->output_json (array ('status' => false, 'message' => '上傳失敗！'));
  }
}
