<?php $this->load->view('includes/header_view'); ?>

	<div id="login-wrapper">
		<div id="content">
		<h2>Login</h2>
		
		<?php if(isset($login_error)): ?>

		<div class="val-error">
			<p>Login error, please try again.</p>
		</div>
		
		<?php endif; ?>
		
	    <?php echo form_open('login/validate_credentials'); ?>
		
  		<ul>
    		<li><label>Username:</label><input type="text" name="username" value="<?php echo $this->input->post('username'); ?>" id="username" size="40"/></li>
    		<li><label>Password:</label><input type="password" name="password" value="" id="password" size="40"/></li>
    		<li>
      			<input type="submit" name="submit" value="Submit" id="submit" />
    		</li>
  		</ul>
		
		<?php echo form_close(); ?>
		
		<ul class="not-a_user">
			<li>NOT A USER? <a href="/signup"> Signup</a></li>
		</ul>
		
		</div>
	</div>
	
<?php $this->load->view('includes/footer_view'); ?>