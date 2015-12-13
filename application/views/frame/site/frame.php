<!DOCTYPE html>
<html lang="zh">
  <head>
    <?php echo isset ($meta_list) ? $meta_list : ''; ?>

    <title><?php echo isset ($title) ? $title : ''; ?></title>

<?php echo isset ($css_list) ? $css_list : ''; ?>

<?php echo isset ($js_list) ? $js_list : ''; ?>

  </head>
  <body lang="zh-tw">
    <?php echo isset ($hidden_list) ? $hidden_list : ''; ?>
    
    <?php echo render_cell ('frame_cell', 'nav', isset ($back) ? $back : false);?>
    
    <div id='container'>
<?php if ($_flash_message = Session::getData ('_flash_message', true)) { ?>
        <div class='_m icon-warning'><?php echo $_flash_message;?></div>
<?php }?>
      <?php echo isset ($content) ? $content : ''; ?>

      <?php echo !(isset ($footer) && $footer) ? render_cell ('frame_cell', 'footer') : '';?>
    </div>

  </body>
</html>