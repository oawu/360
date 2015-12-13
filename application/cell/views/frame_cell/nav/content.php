<nav>
  <a href='<?php echo base_url ();?>'>首頁</a>
<?php
    if (Session::getData ('user') !== 'oa') {?>
      <a href='<?php echo base_url ('platform', 'login');?>'>登入</a>
<?php
    } else { ?>
      <a<?php echo $this->CI->get_class () == 'uploads' ? ' class="active"' : '';?> href='<?php echo base_url ('uploads', 'single');?>'>上傳圖檔</a>
      <a href='<?php echo base_url ('platform', 'logout');?>' data-method='delete'>登出</a>
<?php
    }?>
</nav>