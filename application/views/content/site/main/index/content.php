<div class='ps'>
  <?php
  foreach ($pics as $pic) { ?>
    <div class='p'>
      <div class='b' data-position='<?php echo json_encode ($pic->position ());?>' data-url='<?php echo $pic->name->url ('1024w');?>' data-color='<?php echo str_replace ('#', '', $pic->color ('hex'));?>'></div>
      <a href='<?php echo base_url ($pic->id);?>'></a>
      <?php if (Session::getData ('user') === 'oa') { ?>
        <a class='icon-pencil2 edit'></a>
        <a class='icon-bin delete'></a>
      <?php } ?>
      <a class='icon-share2 share'></a>
      <a class='icon-location location'></a>
    </div>
  <?php
  } ?>
</div>
