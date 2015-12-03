<?php
  if (isset ($pic)) { ?>
    <div class='link'>
      <div>
        <input type='text' class='url' value='<?php echo base_url ($pic->token);?>' />
        <button class='copy'>複製</button>
      </div>
      <div class='m'></div>
    </div>
<?php
  } else { ?>
    <div class='error'>
      <div>當案不存在，或者您的權限不夠喔！</div>
    </div>
<?php
  }
