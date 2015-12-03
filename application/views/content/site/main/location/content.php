<?php
  if (isset ($pic)) { ?>
    <div class='map'>
      <i></i><i></i><i></i><i></i>
      <div id='map' data-lat='<?php echo $pic->latitude;?>' data-lng='<?php echo $pic->longitude;?>'></div>
    </div>
<?php
  } else { ?>
    <div class='error'>
      <div>當案不存在，或者您的權限不夠喔！</div>
    </div>
<?php
  }
