<div id='ball'
     data-position='<?php echo json_encode ($pic->position ());?>'
     data-url='<?php echo $pic->name->url ('1024w');?>'
     data-color='<?php echo str_replace ('#', '', $pic->color ('hex'));?>'></div>
