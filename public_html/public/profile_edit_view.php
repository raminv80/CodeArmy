<?php $this->load->view('includes/header'); ?>

<?php if(isset($profile_update_success)): ?>

<!-- signup successful message start -->
<div>
	Success! Redirect yo!
</div><!-- / signup successful message end -->

<?php else: ?>
<div id="wrapper">
	<div class="contents">
		<?php echo form_open_multipart('profile/edit'); ?>
		<span id="error"><?php echo $message;?></span>
		<?php
		$contact = json_decode($profile["contact"]);
		$urls = json_decode($profile["urls"]);
		?>

		<!-- profile content container start -->

		<div id="profile_form">
			<span class="header">
				<!--<h2>General Details</h2>-->
			</span>

			<div class="edit_info">
				<div class="holder">
					<div class="frame">
						<div class="content">
							<div class="heading">
								<strong class="title">Edit Profile</strong>
							</div>
							<fieldset>
                            	<?php
								$msg = $this->session->flashdata('msg');
								if($msg){?>
								<div class="row" style="color:#F90;">
									Your Profile is Successfully updated.
								</div>
								<?php }?>
								<div class="row">
									<label style="width:160px;" for="full_name">
										Full Name
									</label>
									<div class="text">
										<input type="text" size="30" name="full_name" value="<?php echo $profile["full_name"]; ?>" placeholder="Full Name" id="full_name" />
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="gender">
										Gender
									</label>
									<div class="text">
										<select name="gender">
											<option <?php if($profile['gender']=='male'){?>selected="selected"<?php }?> value="male">Male</option>
											<option <?php if($profile['gender']=='female'){?>selected="selected"<?php }?> value="female">Female</option>
										</select>
									</div>
								</div>
								<div class="row">
									<label style="width:160px;">
										Birth Date
									</label>
									<div class="text">
										<?=$formdate_birth->selectDay()?>
										<?=$formdate_birth->selectMonth()?>
										<?=$formdate_birth->selectYear()?>
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="mobile_no">
										Mobile No.
									</label>
									<div class="text">
										<input type="text" size="30" name="mobile_no" value="<?php if(isset($contact->mobile_no)) { echo $contact->mobile_no; } ?>" placeholder="Mobile Number" id="mobile_no" />
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="location">
										City
									</label>
									<div class="text">
										<input type="text" size="30" name="city" value="<?php if(isset($contact->city)) { echo $contact->city; } ?>" placeholder="City" id="city" />
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="country">
										Country
									</label>
									<div class="text">
										<?php echo country_dropdown('country', array('MY','US','GB','DE','BR','IT','ES','AU','NZ','HK'));?>
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="lan_speak">
										Language (speak)
									</label>
									<div class="text">
										<select name="lan_speak">
											<option <?php if($profile['lan_speak']=='English'){?>selected="selected"<?php }?> value="English">English</option>
											<option <?php if($profile['lan_speak']=='Bahasa Malay'){?>selected="selected"<?php }?> value="Bahasa Malay">Bahsa Malay</option>
											<option <?php if($profile['lan_speak']=='Chinese'){?>selected="selected"<?php }?> value="Chinese">Chinese</option>
										</select>
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="lan_rw">
										Language (read/write)
									</label>
									<div class="text">
										<select name="lan_rw">
											<option <?php if($profile['lan_rw']=='English'){?>selected="selected"<?php }?> value="English">English</option>
											<option <?php if($profile['lan_rw']=='Bahasa Malay'){?>selected="selected"<?php }?> value="Bahasa Malay">Bahsa Malay</option>
											<option <?php if($profile['lan_rw']=='Chinese'){?>selected="selected"<?php }?> value="Chinese">Chinese</option>
										</select>
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="specialization">
										Specialization
									</label>
									<div class="text">
										<input type="text" name="specialization" value="<?php echo $profile['specialization'];?>" placeholder="specialization" id="specialization" />
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="">
										Avatar Pic
									</label>
									<div class="text">
										<?php $Fdata = array('name' => 'user_avatar', 'class' => 'file'); echo form_upload($Fdata);?>
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="fb_url">
										Facebook
									</label>
									<div class="text">
										<input type="text" size="35" name="fb_url" value="<?php if(isset($urls->facebook)) { echo $urls->facebook; } ?>" placeholder="Facebook Username" id="fb_url" />
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="twit">
										Twitter Handler
									</label>
									<div class="text">
										<input type="text" size="35" name="twit" value="<?php if(isset($urls->twitter)) { echo $urls->twitter; } ?>" placeholder="Twitter Username" id="twit" />
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="linkedin">
										LinkedIn
									</label>
									<div class="text">
										<input type="text" size="35" name="linkedin" value="<?php if(isset($urls->linkedin)) { echo $urls->linkedin; } ?>" placeholder="LinkedIn Username" id="linkedin" />
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="github">
										Github URL
									</label>
									<div class="text">
										<input type="text" size="35" name="github" value="<?php if(isset($urls->github)) { echo $urls->github; } ?>" placeholder="Github Username" id="github" />
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="github">
										Portfolio URL
									</label>
									<div class="text">
										<input type="text" size="35" name="portfolio" value="<?php if(isset($urls->portfolio)) { echo $urls->portfolio; } ?>" placeholder="Portfolio URL" id="portfolio" />
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="bank_name">
										Bank Name
									</label>
									<div class="text">
										<input type="text" size="35" name="bank_name" value="<?php echo $profile["bank_name"]; ?>" placeholder="Bank Name" id="bank_name" />
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="bank_acc">
										Bank Account No
									</label>
									<div class="text">
										<input type="text" size="35" name="bank_acc" value="<?php echo $profile["bank_acc"]; ?>" placeholder="Bank Acc" id="bank_acc" />
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="paypal">
										Paypal
									</label>
									<div class="text">
										<input type="text" size="35" name="paypal" value="<?php echo $profile["paypal_acc"]; ?>" placeholder="Paypal Account Email" id="paypal" />
									</div>
								</div>
								<div class="row">
									<label style="width:160px;" for="submit">
										&nbsp;
									</label>
									<input type="submit" name="submit" value="Save" id="submit" />
								</div>

							</fieldset>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!-- / profile content container ends -->

		<?php echo form_close(); ?>
		<?php endif; ?>
	</div>
</div>
<?php $this->load->view('includes/footer'); ?>