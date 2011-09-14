<?php $this->load->view('includes/header_view'); ?>
	
	<?php if(isset($signup_success)): ?>
	
		<div id="sign_up-wrapper">
			<div id="content">
			<h2>Signup Success</h2>
			
			<p>You may login and start bidding on user stories.</p>
			
			</div>
		</div>

	<?php else: ?>
	
	<div id="sign_up-wrapper">
		<div id="content">
		<h2>Register Now!</h2>
		
		<?php if(validation_errors()) { ?>
		<div class="val-error">
			<?php echo validation_errors(); ?>
		</div>
		<?php } ?>
		
		<?php echo form_open('signup'); ?>
		
  		<ul>
    		<li><label>Username:</label><input type="text" name="username" value="<?php echo $this->input->post('username'); ?>" id="username" size="40"/></li>
    		<li><label>Password:</label><input type="password" name="password" value="" id="password" size="40"/></li>
    		<li><label>Email:</label><input type="email" name="email" value="<?php echo $this->input->post('email'); ?>" id="email" size="40"/></li>
    		<li>
      			<input type="submit" name="submit" value="Submit" id="submit" />
      			<input type="reset" />
    		</li>
  		</ul>
		
		<?php echo form_close(); ?>
		
		</div>
	</div>
	
	<?php endif; ?>
	
<?php $this->load->view('includes/footer_view'); ?>