<?php $this->load->view('includes/header4'); ?>
<link href="/public/css/v4/login.css" media="all" rel="stylesheet" type="text/css">
<div id="wrapper">
  <div class="WP-main" style="margin-top:200px;">
    <div class="popup" style="position:relative; margin:0 auto" id="login">
      <div class="holder">
        <div class="frame">
          <div class="content">
            <div class="heading"> <strong class="title">LOGIN</strong> </div>
            <?php echo form_open('login/validate_credentials' , array('class'=>'login-form')); ?>
            <fieldset id="loginform">
              <?php if(isset($login_error)): ?>
              <div class="row"> <span style="color:#F60">Login Error: please check your username or password.</span> </div>
              <?php endif; ?>
              <div class="">
                <label for="username">Username</label>
                <div class="text">
                  <input type="text" id="username-loginpage" name="username" value="<?php echo $this->input->post('username'); ?>"  />
                </div>
              </div>
              <div class="row">
                <label for="password1">Password</label>
                <div class="text">
                  <input type="password" name="password" id="password1-loginpage" value=""  />
                </div>
              </div>
              <div class="row">  
				<a class="forgot" href="/login/recovery">Forgot your password?</a>
                <input type="submit" class="submit" value="Yeah!" name="submit" />
              </div>
            </fieldset>
            <?php echo form_close(); ?>
            <ul class="not-a_user">
              <li>NOT A USER? <a href="/signup" style="color:#09F"> Signup</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('includes/footer4'); ?>
