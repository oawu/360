<?php
  if (isset ($pic)) { ?>
    <div id='ball'
        data-cover='<?php echo $pic->cover;?>'
        data-cover_url='<?php echo base_url ('cover', $pic->token);?>'
        data-position='<?php echo json_encode ($pic->position ());?>'
        data-url='<?php echo $pic->name->url ('4096w');?>'
        data-color='<?php echo str_replace ('#', '', $pic->color ('hex'));?>'>
    </div>
    <a href='' id='prev' class='icon-chevron-left' title='上一張'></a>
    <a href='' id='next' class='icon-chevron-right' title='下一張'></a>
    <div id='move' class='icon-move'>試著用拖拉變更視角</div>
<?php
  } else { ?>
    <div id='warning' class='icon-warning'>
      當案不存在<br/>或者您的權限不夠喔！
    </div>
<?php
  }
