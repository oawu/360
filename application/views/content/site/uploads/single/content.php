<form id='form' action='<?php echo base_url ('uploads');?>' method='POST' enctype='multipart/form-data'>
  <label for='picture' class='img' data-loading='圖片讀取中..'>
    <img id='img' src='' />
  </label>
  <label for='picture' class='pic'>
    <input type='file' name='picture' id='picture' />
  </label>
  <div class='btns'>
    <button type='submit'>確認上傳</button>
    <button type='reset'>重新選擇</button>
  </div>
</form>