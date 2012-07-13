<?php if(isset($signup_success)): ?>
<?php $this->load->view('includes/header4'); ?>
<style type="text/css">
#login-link {
	width: 55px;
	display: inline-block;
	color: #39F;
	background-color: #333;
	height: 25px;
	border-radius: 5px;
	font-weight: bold;
}
#login-link:hover {
color: white;
}

</style>
<link href="/public/css/v4/login.css" media="all" rel="stylesheet" type="text/css">
<div id="wrapper">
  <div class="WP-main">
  <div class="popup" style="position:relative; margin:100px auto" id="register">
      <div class="holder">
        <div class="frame">
          <div class="content">
          <div class="heading"><strong style="padding: 15px 30px 12px 8px !important;font-size: 23px;" class="title">Signup Success</strong> </div>
             <fieldset id="signupform">
             
    			<div class="row"><p id="signup-valid">You may <a href="/login" id="login-link">login</a> and start bidding on user stories.</p>
              </div>
              
            </fieldset>
            </div>
        </div>
      </div>
    </div>
  
  <!--<br /><br /><br /><br />
    -->
  </div>
</div>
<?php $this->load->view('includes/footer5'); ?>
<?php else: ?>
<?php $this->load->view('includes/header4'); ?>
<link href="/public/css/v4/login.css" media="all" rel="stylesheet" type="text/css">
<div id="wrapper">
  <div class="WP-main" style="margin-top:140px;">
    <div class="popup" style="position:relative; margin:0 auto" id="register">
      <div class="holder">
        <div class="frame">
          <div class="content">
            <div class="heading"><strong style="padding: 15px 47px 9px 12px !important;" class="title">Regisration</strong> </div>
            <?php echo form_open('signup', array('class'=>'register-form')); ?>
            <fieldset id="signupform">
              <div class="row">
                <?php if($form_error) { ?>
                <div class="val-error" style="font-size: 15px;margin: -25px 0 10px 0;color:#F93">
                <?php
					$display = '<div id="errors">';
					$display .= '<p>Sorry, we had some trouble with your registration:</p>';
					$display .= '<ul>';
					foreach ($this->form_validation->_error_array as $this_error){
						$display .= '<li>' . $this_error . '</li>';
					}
					if(isset($captcha_error))$display .= "<li>".$captcha_error."</li>";
					$display .= '</ul>';
					$display .= '</div>';
					echo $display;
				?>
                </div>
                <?php }?>
              </div>
              <div class="row">
                <label for="name">Username</label>
                <div class="text">
                  <input id="name-signup" name="username" type="text" value="<?php echo $this->input->post('username'); ?>"  />
                </div>
              </div>
              <div class="row">
                <label for="email">Email</label>
                <div class="text">
                  <input id="email-signup" type="text" name="email" value="<?php echo $this->input->post('email'); ?>"  />
                </div>
              </div>
              <div class="row">
                <label for="password2">Password</label>
                <div class="text">
                  <input id="password2-signup" name="password" type="password" value=""  />
                </div>
              </div>
              <div class="row">
                <label for="password3">Re-type Pass</label>
                <div class="text">
                  <input id="password3-signup" name="passconf" type="password" value=""  />
                </div>
              </div>
              <div class="row">
              Please re-enter following Phrase...
              </div>
              <div class="row">
                <label for="captcha"><?=$captcha;?></label>
                <div class="text">
                  <input id="captcha" name="captcha" type="text" value=""  />
                </div>
              </div>
              <div class="row">
                <input type="submit" class="submit" name="submit" value="Submit" />
              </div>
            </fieldset>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('includes/footer5'); ?>
<?php endif; ?>
