<?php $this->load->view('includes/header_view'); ?>

	<?php if(isset($profile_update_success)): ?>
	
	<!-- signup successful message start -->	
	<div>
		Success! Redirect yo!
	</div><!-- / signup successful message end -->
		
	<?php else: ?>
	<div id="prof_edit-wrapper">
	<div id ="content">
<?php echo form_open_multipart('profile/edit'); ?>
<span id="error"><?php echo $message;?></span>
<?php 
		$contact = json_decode($profile["contact"]);
		$urls = json_decode($profile["urls"]);
?>

	<!-- profile content container start -->

	<div class="profile_form">
	<span class="header"><h2>General Details</h2></span>

<div id="perso_info">
<fieldset>
<legend>Personal Information</legend>
	<dl>
	<dt><label for="full_name">Full Name</label></dt>
		<dd><input type="text" size="30" name="full_name" value="<?php echo $profile["full_name"]; ?>" placeholder="Full Name" id="full_name" /></dd>
		<dt><label for="mobile_no">Mobile No.</label></dt>
		<dd><input type="text" size="30" name="mobile_no" value="<?php if(isset($contact->mobile_no)) { echo $contact->mobile_no; } ?>" placeholder="Mobile Number" id="mobile_no" /></dd>
		<dt><label for="location">City</label></dt>
		<dd><input type="text" size="30" name="city" value="<?php if(isset($contact->city)) { echo $contact->city; } ?>" placeholder="City" id="city" />
		<dt><label for="country">Country</label></dt>
		<dd><?php echo country_dropdown('country', array('MY','US','GB','DE','BR','IT','ES','AU','NZ','HK'));?> </dd>
        <dt><label for="lan_speak">Language (speak)</label></dt>
        <dd><select name="lan_speak">
        		<option value="en">English</option>
                <option value="bm">Bahsa Malay</option>
                <option value="ch">Chinese</option>
            </select>
        </dd>
        <dt><label for="lan_rw">Language (read/write)</label></dt>
        <dd><select name="lan_rw">
        		<option value="en">English</option>
                <option value="bm">Bahsa Malay</option>
                <option value="ch">Chinese</option>
            </select>
        </dd>
	</dl>
    </fieldset>
</div>
	
<div id="perso_info">
<fieldset>
<legend>Avatar</legend>		
	<dl>
		<dt><label for="bank_name">Avatar Pic</label></dt>
		<dd><?php 
			$Fdata = array('name' => 'user_avatar', 'class' => 'file');
			echo form_upload($Fdata);
		?></dd>
	</dl>
</fieldset>
</div>
    
<div id="bank_info">
<fieldset>
<legend>Bank Information</legend>		
	<dl>
		<dt><label for="bank_name">Bank Name</label></dt>
		<dd><input type="text" size="35" name="bank_name" value="<?php echo $profile["bank_name"]; ?>" placeholder="Bank Name" id="bank_name" /></dd>
		<dt><label for="bank_acc">Bank Account No</label></dt>
		<dd><input type="text" size="35" name="bank_acc" value="<?php echo $profile["bank_acc"]; ?>" placeholder="Bank Acc" id="bank_acc" /></dd>
		<dt><label for="paypal">Paypal</label></dt>
		<dd><input type="text" size="35" name="paypal" value="<?php echo $profile["paypal_acc"]; ?>" placeholder="Paypal Account Email" id="paypal" /></dd>
	</dl>
</fieldset>
</div>

<div id="cont_info">
<fieldset>
<legend>Contact Information</legend>
	<dl>	
		<dt><label for="fb_url">Facebook</label></dt>
		<dd><input type="text" size="35" name="fb_url" value="<?php if(isset($urls->facebook)) { echo $urls->facebook; } ?>" placeholder="Facebook Username" id="fb_url" /></dd>
		<dt><label for="twit">Twitter Handler</label></dt>
		<dd><input type="text" size="35" name="twit" value="<?php if(isset($urls->twitter)) { echo $urls->twitter; } ?>" placeholder="Twitter Username" id="twit" /></dd>
		<dt><label for="linkedin">LinkedIn</label></dt>
		<dd><input type="text" size="35" name="linkedin" value="<?php if(isset($urls->linkedin)) { echo $urls->linkedin; } ?>" placeholder="LinkedIn Username" id="linkedin" /></dd>
		<dt><label for="github">Github URL</label></dt>
		<dd><input type="text" size="35" name="github" value="<?php if(isset($urls->github)) { echo $urls->github; } ?>" placeholder="Github Username" id="github" /></dd>
		<dt><label for="github">Portfolio URL</label></dt>
		<dd><input type="text" size="35" name="portfolio" value="<?php if(isset($urls->portfolio)) { echo $urls->portfolio; } ?>" placeholder="Portfolio URL" id="portfolio" /></dd>
	</dl>
</fieldset>
</div>
	<div id="submit">
		<dt><label for="submit">&nbsp;</label></dt>
		<dd><input type="submit" name="submit" value="Submit" id="submit" /></dd>
	</div>

	<?php echo form_close(); ?>	
	</div>
		
	</div>
	<!-- / profile content container ends -->
		
	<?php echo form_close(); ?>	
	<?php endif; ?>
	</div>
	</div>
<?php $this->load->view('includes/footer_view'); ?>