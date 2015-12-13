<?php
  if (isset ($pic)) { ?>
    <div id='ball'
        data-cover='<?php echo $pic->cover;?>'
        data-token='<?php echo $pic->token;?>'
        data-position='<?php echo json_encode ($pic->position ());?>'
        data-url='<?php echo $pic->name->url ('4096w');?>'
        data-color='<?php echo str_replace ('#', '', '000000');?>'>
    </div>
    <a href='' id='prev' class='icon-chevron-left' title='上一張'></a>
    <a href='' id='next' class='icon-chevron-right' title='下一張'></a>
    <div id='move' class='icon-move'>試著用拖拉變更視角</div>
<?php
    if (Session::getData ('user') === 'oa') { ?>
      <button id='cover' title='確認視角'>確認視角</button>
      <label for='visibled'><input type='checkbox' id='visibled' data-token='<?php echo $pic->token;?>'<?php echo $pic->is_visibled ? ' checked' : '';?> /><span></span> <div><?php echo $pic->is_visibled ? '公開' : '不公開';?></div></label>
<?php
    }
  } else { ?>
    <div id='warning' class='icon-warning'>
      當案不存在<br/>或者您的權限不夠喔！
    </div>
<?php
  }
