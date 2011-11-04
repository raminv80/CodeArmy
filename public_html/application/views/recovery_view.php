<?php $this->load->view('includes/header'); ?>

<div id="wrapper">
  <div id="content">
    <div class="popup" style="position:relative; margin:0 auto" id="login">
      <div class="holder">
        <div class="frame">
          <div class="content">
            <div class="heading"> <strong class="title">Reset</strong> </div>
            <?php echo form_open('login/recovery' , array('class'=>'login-form')); ?>
            <fieldset>
              <?php if(isset($login_error)&& $login_error!=""): ?>
              <div class="row"> <span style="color:#F60"><?php echo $login_error;?></span> </div>
              <?php endif; ?>
              <div class="row">
                <label for="username">Username</label>
                <div class="text">
                  <input type="text" id="username" name="username" value="<?php echo $this->input->post('username'); ?>"  />
                </div>
              </div>
              <div class="row"> 
                <!--TODO: password reset 
													<a class="forgot" href="#">Forgot your password?</a>
                                                    -->
                <input type="submit" class="submit" value="Reset Pass" name="submit" />
              </div>
            </fieldset>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('includes/footer'); ?>
