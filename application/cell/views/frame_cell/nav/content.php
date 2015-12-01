<nav>
  <a href='<?php echo base_url ();?>'>首頁</a>
<?php
    if (Session::getData ('user') !== 'oa') {?>
      <a href='<?php echo base_url ('login');?>'>登入</a>
<?php
    } else { ?>
      <a href='<?php echo base_url ('logout');?>' data-method='delete'>登出</a>
<?php
    }?>
</nav>