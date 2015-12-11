<form action='<?php echo base_url ('platform', 'login');?>' method='post' class='login'>
  <h2>登入</h2>
  <div>
    <input type='text' name='account' value='<?php echo $posts['account'] ? $posts['account'] : '';?>' placeholder='帳號..' pattern='.{1,}' required title='請輸入帳號!'/>
  </div>
  <div>
    <input type='password' name='password' value='<?php echo $posts['password'] ? $posts['password'] : '';?>' placeholder='密碼..' pattern='.{1,}' required title='請輸入密碼!'/>
  </div>
  <div>
    <a href='<?php echo base_url ('platform', 'register');?>'>註冊</a>
    <button type='submit'>登入</button>
  </div>
</form>
