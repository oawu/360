<?php
  if (isset ($pic)) { ?>
    <div class='map'>
      <i></i><i></i><i></i><i></i>
      <div id='map' data-cover='<?php echo $pic->cover->url ('640x640c');?>' data-lat='<?php echo $pic->latitude;?>' data-lng='<?php echo $pic->longitude;?>'></div>
    </div>
<?php
  } else { ?>
    <div id='warning' class='icon-warning'>
      當案不存在<br/>或者您的權限不夠喔！
    </div>
<?php
  }
