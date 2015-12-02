<?php
  if (isset ($pic)) { ?>
    <div id='ball'
         data-position='<?php echo json_encode ($pic->position ());?>'
         data-url='<?php echo $pic->name->url ('4096w');?>'
         data-color='<?php echo str_replace ('#', '', $pic->color ('hex'));?>'></div>
<?php
  } else { ?>
    <div class='error'>
      <div>當案不存在，或者您的權限不夠喔！</div>
    </div>
<?php
  } ?>
<div id='loading'>更新中..</div>
