<div class='ps'>
  <?php
  foreach ($pics as $pic) { ?>
    <div class='p'>
<?php if ((string)$pic->cover) { ?>
        <img class='i_c' src='<?php echo $pic->cover->url ();?>' />
<?php } else { ?>
        <div class='b' data-cover='<?php echo $pic->cover;?>' data-cover_url='<?php echo base_url ('cover', $pic->token);?>' data-position='<?php echo json_encode ($pic->position ());?>' data-url='<?php echo $pic->name->url ('1024w');?>' data-color='<?php echo str_replace ('#', '', $pic->color ('hex'));?>'></div>
<?php }?>
      <a href='<?php echo base_url ($pic->token);?>'></a>
  <?php if (Session::getData ('user') === 'oa') { ?>
          <a title='編輯檢視角度' class='icon-pencil2 edit l' data-url='<?php echo base_url ('edit', $pic->token);?>'></a>
          <a title='刪除' class='icon-bin delete l' data-url='<?php echo base_url ($pic->token);?>'></a>
    <?php if ($pic->is_visibled) { ?>
            <a title='目前公開' class='icon-eye l' href='<?php echo base_url ('eye', $pic->token);?>' data-method='post'></a>
    <?php } else { ?>
            <a title='目前非公開' class='icon-eye-blocked l' href='<?php echo base_url ('eye', $pic->token);?>' data-method='put'></a>
    <?php }?>
  <?php } ?>
      <a title='取得鏈結網址' class='icon-link link' data-url='<?php echo base_url ('link', $pic->token);?>'></a>
      <a title='分享至臉書' class='icon-share2 share' data-url='<?php echo base_url ($pic->token);?>'></a>
      <a title='檢視地圖位置' class='icon-location location' data-url='<?php echo base_url ('location', $pic->token);?>'></a>
    </div>
  <?php
  } ?>
</div>

<div id='link_panel'>
  <div class='c'></div>
  <div class='pl'>
    <div class='l'>
      <div>
        <input type='text' class='url' value='<?php echo base_url ($pic->token);?>' />
        <button class='copy'>複製</button>
      </div>
      <div class='m'></div>
    </div>
    <div class='icon-x d'></div>
  </div>
</div>