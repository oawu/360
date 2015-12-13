<div class='balls'>
<?php
  foreach ($pictures as $picture) { ?>
    <div class='ball'>
<?php if (!(string)$picture->cover) { ?>
        <div class='obj'
             data-cover='<?php echo $picture->cover;?>' 
             data-token='<?php echo $pic->token;?>'
             data-position='<?php echo json_encode ($picture->position ());?>' 
             data-url='<?php echo $picture->name->url ('1024w');?>' 
             data-color='<?php echo str_replace ('#', '', '000000');?>'></div>
        <a href='<?php echo base_url ($picture->token);?>' class='border'></a>
<?php } else {?>
        <a href='<?php echo base_url ($picture->token);?>' class='border i_c'>
          <img class='cover' src="<?php echo $picture->cover->url ('350w');?>" />
        </a>
<?php }
      if (Session::getData ('user') === 'oa') { ?>
        <div class='btns n5'>
          <a title='編輯' class='icon-pencil2' href='<?php echo base_url ('modify', $picture->token);?>'></a>
          <a title='刪除' class='icon-bin' href='<?php echo base_url ('modify', $picture->token);?>' data-method='delete'></a>
<?php } else { ?>
        <div class='btns n3'>
<?php } ?>
        <a title='取得鏈結網址' class='icon-link' data-url='<?php echo base_url ($picture->token);?>'></a>
        <a title='檢視地圖位置'<?php echo !$picture->location () ? ' disabled': '';?> class='icon-location' data-url='<?php echo base_url ('location', $picture->token);?>'></a>
        <a title='分享至臉書' class='icon-mail-forward' data-url='<?php echo base_url ($picture->token);?>'></a>
      </div>
      <div class='views icon-eye2'><?php echo $picture->pv;?></div>
<?php if (!$picture->is_visibled) { ?>
        <div class='lock icon-lock'></div>
<?php } ?>
    </div>
<?php 
  }?>
</div>

<?php echo render_cell ('frame_cell', 'pagination', $pagination);?>

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
