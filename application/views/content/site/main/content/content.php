<?php
  if (isset ($pic)) { ?>
    <div id='ball'
        data-cover='<?php echo $pic->cover;?>'
        data-token='<?php echo $pic->token;?>'
        data-position='<?php echo json_encode ($pic->position ());?>'
        data-url='<?php echo $pic->name->url ('4096w');?>'
        data-rotated='<?php echo $pic->is_rotated;?>'
        data-color='<?php echo str_replace ('#', '', '000000');?>'>
    </div>
<?php
    if ($pic->prev (Session::getData ('user') === 'oa')) { ?><a href='<?php echo base_url ($pic->prev (Session::getData ('user') === 'oa')->token);?>' id='prev' class='icon-chevron-left' title='上一張'></a><?php }
    if ($pic->next (Session::getData ('user') === 'oa')) { ?><a href='<?php echo base_url ($pic->next (Session::getData ('user') === 'oa')->token);?>' id='next' class='icon-chevron-right' title='下一張'></a><?php } ?>
    <div id='move' class='icon-move'>試著用拖拉變更視角</div>
    <div id='views' class='icon-eye2'><?php echo $pic->pv;?></div>
    <button id='share' class='icon-share2' title='分享至臉書' data-url='<?php echo base_url ($pic->token);?>'></button>
    <a href='<?php echo $pic->name->url ();?>' download='<?php echo $pic->name;?>' id='download' class='icon-download' title='下載照片'></a>
<?php
    if (Session::getData ('user') === 'oa') { ?>
      <label for='visibled'><input type='checkbox' id='visibled' data-token='<?php echo $pic->token;?>'<?php echo $pic->is_visibled ? ' checked' : '';?> /><span></span> <div><?php echo $pic->is_visibled ? '公開' : '不公開';?></div></label>
      <label for='rotated'><input type='checkbox' id='rotated' data-token='<?php echo $pic->token;?>'<?php echo $pic->is_rotated ? ' checked' : '';?> /><span></span> <div><?php echo $pic->is_rotated ? '旋轉' : '不旋轉';?></div></label>
      <button id='cover' title='確認視角'>確認視角</button>
<?php
    }
  } else { ?>
    <div id='warning' class='icon-warning'>
      當案不存在<br/>或者您的權限不夠喔！
    </div>
<?php
  }
