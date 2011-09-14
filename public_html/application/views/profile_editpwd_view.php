<?php $this->load->view('includes/header_view'); ?>

<div id="pwd_edit-wrapper">
<div id="content">
	<?php echo form_open('profile/edit_password'); ?>

	<div class="password_form">
	<span class="header"><h2>Password</h2></span>
	
	<?php if(validation_errors()) { ?>
	<div class="val-error">
		<?php echo validation_errors(); ?>
	</div>
	<?php } ?>
	
		<dl>
		<dt><label for="o_pwd">Old Password : <label></dt><dd><input type="password" name="o_pwd" id="o_pwd" placeholder="Old Password" /></dd>
		<dt><label for="n_pwd">New Password : <label></dt><dd><input type="password" name="n_pwd" id="n_pwd" placeholder="New Password" /></dd>
		<dt><label for="r_pwd">Repeat New Password : <label></dt><dd><input type="password" name="r_pwd" id="r_pwd" placeholder="Repeat Password" /></dd>
		<dt><label for="submit">&nbsp;</label></dt>
		<dd><input type="submit" name="submit2" value="Submit" id="submit" /></dd>
		</dl>
	</div>
	
	<?php echo form_close(); ?>	

	</div>
</div>
<?php $this->load->view('includes/footer_view'); ?>