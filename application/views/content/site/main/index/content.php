<div class='balls'>
<?php
  foreach ($pics as $pic) { ?>
    <div class='ball'>
<?php if (!(string)$pic->cover) { ?>
        <div class='obj'
             data-cover='<?php echo $pic->cover;?>' 
             data-cover_url='<?php echo base_url ('cover', $pic->token);?>' 
             data-position='<?php echo json_encode ($pic->position ());?>' 
             data-url='<?php echo $pic->name->url ('1024w');?>' 
             data-color='<?php echo str_replace ('#', '', $pic->color ('hex'));?>'></div>
        <a href='http://dev.360.ioa.tw/e24fce3f67d948efe1335d5bfc26a840' class='border'></a>
<?php } else {?>
        <a href='http://dev.360.ioa.tw/e24fce3f67d948efe1335d5bfc26a840' class='border i_c'>
          <img class='cover' src="<?php echo $pic->cover->url ();?>" />
        </a>
<?php }?>
      <div class='btns'>
        <a title='取得鏈結網址' class='l icon-link' data-url='<?php echo base_url ('link', $pic->token);?>'></a>
        <a title='檢視地圖位置' class='c icon-location' data-url='<?php echo base_url ('location', $pic->token);?>'></a>
        <a title='分享至臉書' class='r icon-mail-forward' data-url='<?php echo base_url ($pic->token);?>'></a>
      </div>
    </div>
<?php 
  }?>
</div>

<div id='link_panel'>
  <div class='c'></div>
  <div class='pl'>
    <div class='l'>
      <div>
        <input type='text' class='url' value='' />
        <button class='copy'>複製</button>
      </div>
      <div class='m'></div>
    </div>
    <div class='icon-x d'></div>
  </div>
</div> 
