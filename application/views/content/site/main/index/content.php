<div class='ps'>
  <?php
  foreach (Picture::all () as $pic) { ?>
    <div class='p' data-url='<?php echo $pic->name->url ('1024w');?>' data-color='<?php echo str_replace ('#', '', $pic->color ('hex'));?>'></div>
  <?php
  } ?>
  
</div>
