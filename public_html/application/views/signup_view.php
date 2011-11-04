<?php $this->load->view('includes/header'); ?>
<?php if(isset($signup_success)): ?>

<div id="wrapper">
  <div id="content">
    <h2>Signup Success</h2>
    <p>You may <a href="/login">login</a> and start bidding on user stories.</p>
  </div>
</div>
<?php else: ?>
<div id="wrapper">
  <div id="content">
    <div class="popup" style="position:relative; margin:0 auto" id="register">
      <div class="holder">
        <div class="frame">
          <div class="content">
            <div class="heading"><strong class="title">Regisration</strong> </div>
            <?php echo form_open('signup', array('class'=>'register-form')); ?>
            <fieldset>
              <div class="row">
                <?php if($form_error) { ?>
                <div class="val-error" style="color:#F93">
                <?php
					$display = '<div id="errors">';
					$display .= '<p>Sorry, we had some trouble with your registration:</p>';
					$display .= '<ul>';
					foreach ($this->form_validation->_error_array as $this_error){
						$display .= '<li>' . $this_error . '</li>';
					}
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
                  <input id="name" name="username" type="text" value="<?php echo $this->input->post('username'); ?>"  />
                </div>
              </div>
              <div class="row">
                <label for="email">Email</label>
                <div class="text">
                  <input id="email" type="text" name="email" value="<?php echo $this->input->post('email'); ?>"  />
                </div>
              </div>
              <div class="row">
                <label for="password2">Password</label>
                <div class="text">
                  <input id="password2" name="password" type="password" value=""  />
                </div>
              </div>
              <div class="row">
                <label for="password3">Re-type Password</label>
                <div class="text">
                  <input id="password3" name="passconf" type="password" value=""  />
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
<?php endif; ?>
<?php $this->load->view('includes/footer'); ?>
