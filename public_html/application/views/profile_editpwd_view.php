<?php $this->load->view('includes/header4'); ?>
<link media="all" type="text/css" rel="stylesheet" href="/public/css/style.css" />
<style>
.row {width: 100%;}

#n_pwd, #o_pwd, #r_pwd {width:290px !important;}
#submit {margin-top:0 !important;}
#wrapper .contents form div.row label { width:190px; }
</style>
<div id="wrapper">
<div class="contents" style="margin-top:100px">
	<?php echo form_open('profile/edit_password'); ?>

	<div id="profile_form">
	<span class="header">
		<!--<h2>Password</h2>-->
	</span>
	
	<?php if(validation_errors()) { ?>
	<div class="val-error">
		<?php echo validation_errors(); ?>
	</div>
	<?php } ?>
	
	<div class="edit_info">
	<div class="holder">
		<div class="frame">
			<div class="content">
				<div class="heading">
					<strong class="title">Password</strong>
				</div>
				<fieldset>
                	<?php
					$msg = $this->session->flashdata('msg');
					if($msg){?>
                	<div class="row" style="color:#F90;">
                    	Your Password is Successfully updated.
                    </div>
                    <?php }?>
					<div class="row">
						<label for="o_pwd">
							Old Password 
							</label>
								<div class="text">
									<input type="password" name="o_pwd" id="o_pwd" placeholder="Old Password" />
								</div>
					</div>
					<div class="row">
						<label for="n_pwd">
							New Password 
							</label>
								<div class="text">
									<input type="password" name="n_pwd" id="n_pwd" placeholder="New Password" />
								</div>
					</div>
					<div class="row">
						<label for="r_pwd">
							Repeat New Password 
							</label>
								<div class="text">
									<input type="password" name="r_pwd" id="r_pwd" placeholder="Repeat Password" />
								</div>
					</div>
					<div class="row">
						<label for="submit">
							&nbsp;
						</label>
						<div class="text">
							<input type="submit" name="submit2" value="Submit" id="submit" />
						</div>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</div>
		<!--
		<dl>
		<dt><label for="o_pwd">Old Password : <label></dt><dd><input type="password" name="o_pwd" id="o_pwd" placeholder="Old Password" /></dd>
		<dt><label for="n_pwd">New Password : <label></dt><dd><input type="password" name="n_pwd" id="n_pwd" placeholder="New Password" /></dd>
		<dt><label for="r_pwd">Repeat New Password : <label></dt><dd><input type="password" name="r_pwd" id="r_pwd" placeholder="Repeat Password" /></dd>
		<dt><label for="submit">&nbsp;</label></dt>
		<dd><input type="submit" name="submit2" value="Submit" id="submit" /></dd>
		</dl>
		-->
	</div>
	
	<?php echo form_close(); ?>	

	</div>
</div>
<?php $this->load->view('includes/footer4'); ?>