<?php
  if (isset ($pic)) { ?>
    <div id='ball'
        data-cover='<?php echo $pic->cover;?>'
        data-cover_url='<?php echo base_url ('cover', $pic->token);?>'
        data-cover_position_url='<?php echo base_url ('modify', 'cover_position', $pic->token);?>'
        data-position='<?php echo json_encode ($pic->position ());?>'
        data-url='<?php echo $pic->name->url ('4096w');?>'
        data-color='<?php echo str_replace ('#', '', '000000');?>'>
    </div>
    <button id='cover' title='確認視角'>確認視角</button>
    <div id='move' class='icon-move'>試著用拖拉變更視角</div>
<?php
  } else { ?>
    <div id='warning' class='icon-warning'>
      當案不存在<br/>或者您的權限不夠喔！
    </div>
<?php
  }
