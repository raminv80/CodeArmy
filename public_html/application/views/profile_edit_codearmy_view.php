<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<style>
#profile-wrapper {
	height:1750px;
	background: url("/public/images/codeArmy/profile/profile-edit-bg.jpg") no-repeat;
}
</style>
<div id="profile-edit-content-area">
	<?php
    $msg = $this->session->flashdata('msg');
    if($msg){?>
    <div class="row" style="color:#F90;">
        <label style="width: 250px;"><?=$msg?></label>
    </div>
    <?php
	}
	if (validation_errors()){
	echo validation_errors();
	}
    ?>
    
  <?php echo form_open('profile/edit_profile'); ?>
    
    <!-- START - Save Profile + Profile Completion Block - Dev. by Reza  -->
    <div class="block-save-profile">
      <div id="save-profile">
        <input class="lnkimg" type="submit" value="Save Profile" />
        &nbsp;&nbsp;<a href="/profile"> or Cancel</a> </div>
      <div id="profile-completion"> Profile Completion: 45%
        <div id="profile-completion-bar">
          <div id="profile-completion-progress"> </div>
        </div>
      </div>
    </div>
    <br />
    <hr style="margin-top:50px" />
    
    <!-- START - Level Block - Dev. by Reza  -->
    <div id="block-level">Level <?=$myLevel?></div>
    
    <!-- START - Avatar Block - Dev. by Reza  -->
    <div id="block-avatar">
      <div id="avatar-pic">
        <div id="avatar-left-arrow"><a href="#">
          <p>Prev</p>
          </a></div>
        <div id="avatar-right-arrow"><a href="#">
          <p>Next</p>
          </a> </div>
      </div>
      <div id="profile-desc"> What's on your mind soldier? </div>
    </div>
    
    <!-- START - Contact Info Block - Dev. by Reza  -->
    <?php
	if ($myProfile["urls"] != "") {
		$urls = json_decode($myProfile["urls"]);
	} else {
		$urls = false;
	}
	if ($myProfile["contact"] != "") { 
		$contact = json_decode($myProfile["contact"]);
		$countries = config_item('country_list');
		$myCountry = $contact->country;
		foreach($countries as $key=>$value):
			if ($key == $myCountry){
				$myCountry = $value;
			}
		endforeach;
	} else {
		$countries = config_item('country_list');
		$myCountry = false;
	}
	?>
    <div id="edit-contact-info">
      <div class="block-header">
        <h3>Contact Information</h3>
      </div>
      <div id="contact-boxes">
        <div id="input-row">
          <label class="email"></label>
          <input type="text" id="email" name="email" value="<?=$me["email"]?>" />
        </div>
        <div id="input-row">
          <label class="skype"></label>
          <input type="text" id="skype" name="skype" value="<?php if($urls) echo $urls->skype;?>" />
        </div>
        <div id="input-row">
          <label class="facebook"></label>
          <input type="text" id="facebook" name="facebook" value="<?php if($urls) echo $urls->facebook;?>" />
        </div>
        <div id="input-row">
          <label class="twitter"></label>
          <input type="text" id="twitter" name="twitter" value="<?php if($urls) echo $urls->twitter;?>" />
        </div>
        <div id="input-row">
          <label class="linkedin"></label>
          <input type="text" id="linkedin" name="linkedin" value="<?php if($urls) echo $urls->linkedin;?>" />
        </div>
      </div>
    </div>
    
    <!-- START - Basic Info Block - Dev. by Reza  -->
    <div id="block-basic-info">
      <div id="input-row">
        <input type="text" id="name" name="name" value="<?=$me["username"]?>" readonly="readonly" />
      </div>
      <div id="input-row">
        <input type="text" id="title" name="title" value="<?=ucfirst($myProfile["specialization"])?>" readonly="readonly" />
        <!--<input type="text" id="location" name="location" value="<?php if($myCountry) echo $myCountry?>" />-->
          <select name="country">
            <option value="">--- Select a country ---</option>
          <?php foreach($countries as $key=>$value): ?>
            <option value="<?=$key?>"<?php if($myCountry) if ($key == $contact->country){ echo " selected"; } ?>><?=ucfirst($value)?></option>
          <?php endforeach; ?>
          </select>
      </div>
    </div>
    
    <!-- START - Personal Info Block - Dev. by Reza  -->
    <div id="block-personal-info">
      <div class="block-header">
        <h3>Personal Information</h3>
      </div>
      <div id="personal-info-boxes">
        <div id="input-row">
          <label class="name">Full Name</label>
          <input type="text" id="fullname" name="fullname" value="<?=$myProfile["full_name"]?>" />
        </div>
        <div id="input-row">
          <label class="address">Address</label>
          <input type="text" id="address" name="address" value="<?php if($myCountry) echo $contact->address;?>" />
        </div>
        <div id="input-row">
          <label class="phone">Phone</label>
          <input type="text" id="phone" name="phone" value="<?php if($myCountry) echo $contact->phone;?>" />
        </div>
<script>
$(function() {
	$( "#birthday" ).datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true, yearRange: "1950:2010" });
});
</script>
        <div id="input-row">
          <label class="birthday">Birthday</label>
          <input type="text" id="birthday" name="birthday" value="<?=$myProfile["birthdate"]?>" />
        </div>
      </div>
    </div>
    
    <!-- START - Skill Progression Block - Dev. by Reza  -->
    <?php if($mySkills == false){ ?>
    <div id="block-skill-progression">
      <div class="block-header">
        <h3>Skill Progression</h3>
      </div>
      <div id="personal-info-boxes">
        <div id="input-row">
          <select name="skill1">
            <option value=""></option>
          <?php foreach($allSkills as $value): ?>
            <option value="<?=$value["id"]?>"><?=ucfirst($value["name"])?></option>
          <?php endforeach; ?>
          </select>
        </div>
        <div id="input-row">
          <select name="skill2">
            <option value=""></option>
          <?php foreach($allSkills as $value): ?>
            <option value="<?=$value["id"]?>"><?=ucfirst($value["name"])?></option>
          <?php endforeach; ?>
          </select>
        </div>
        <div id="input-row">
          <select name="skill3">
            <option value=""></option>
          <?php foreach($allSkills as $value): ?>
            <option value="<?=$value["id"]?>"><?=ucfirst($value["name"])?></option>
          <?php endforeach; ?>
          </select>
        </div>
      </div>
    </div>
    <?php } ?>
    
    <!-- START - Links and Portfolios Block - Dev. by Reza  -->
    <div id="block-links-portfolios">
      <div class="block-header">
        <h3>Links and Portfolios</h3>
      </div>
      <div class="links-portfolios-boxes">
        <div id="input-row">
          <input class="links-portfolios-boxes1" type="text" id="github" name="github" value="Github" />
          <input type="text" id="github-address" name="github-address" value="<?php if ($urls) echo $urls->github;?>" />
        </div>
        <div id="input-row">
          <input class="links-portfolios-boxes1" type="text" id="portfolio" name="portfolio" value="Portfolio" />
          <input type="text" id="portfolio-address" name="portfolio-address" value="<?php if ($urls) echo $urls->portfolio;?>" />
        </div>
        <div id="input-row">
          <input class="links-portfolios-boxes1" type="text" id="blog" name="blog" value="Blog" />
          <input type="text" id="blog-address" name="blog-address" value="" />
        </div>
        <div id="input-row">
          <input class="links-portfolios-boxes1" type="text" id="" name="" readonly="readonly" />
          <input type="text" id="" name="" readonly="readonly" />
        </div>
        <div id="input-row">
          <input class="links-portfolios-boxes1" type="text" id="" name="" readonly="readonly" />
          <input type="text" id="" name="" readonly="readonly" />
        </div>
      </div>
    </div>
    
    <!-- START - Send Pay Block - Dev. by Reza  -->
    <div id="block-send-pay">
      <div class="block-header">
        <h3>Where do we send your pay?</h3>
      </div>
      <div id="send-pay-boxes">
        <div id="paypal-account">
          <h4>Paypal Account Details</h4>
          <div id="input-row">
            <label class="paypal-email">Paypal Email</label>
            <input type="text" id="paypal-email" name="paypal-email" value="<?=$myProfile["paypal_acc"]?>" />
          </div>
        </div>
        <div id="bank-account">
          <h4>Bank Account Details</h4>
          <div id="input-row">
            <label class="bank-country">Country of Bank</label>
            <!--<input type="text" id="bank-country" name="bank-country" value="<?=$myProfile["bank_country"]?>" />-->
          <select name="bank-country">
            <option value="">--- Select a country ---</option>
          <?php foreach($countries as $key=>$value): ?>
            <option value="<?=$key?>"<?php if($myProfile["bank_country"]!='') if ($key == $myProfile["bank_country"]){ echo " selected"; } ?>><?=ucfirst($value)?></option>
          <?php endforeach; ?>
          </select>
          </div>
          <div id="input-row">
            <label class="bank-country">Bank Name</label>
            <input type="text" id="bank-name" name="bank-name" value="<?=$myProfile["bank_name"]?>" />
          </div>
          <div id="input-row">
            <label class="bank-country">SWIFT Code</label>
            <input type="text" id="bank-swift" name="bank-swift" value="<?=$myProfile["bank_swift"]?>" />
          </div>
          <div id="input-row">
            <label class="bank-country">Last Name</label>
            <input type="text" id="bank-lastname" name="bank-lastname" value="<?=$myProfile["bank_lastname"]?>" />
          </div>
          <div id="input-row">
            <label class="bank-country">First Name</label>
            <input type="text" id="bank-firstname" name="bank-firstname" value="<?=$myProfile["bank_firstname"]?>" />
          </div>
          <div id="input-row">
            <label class="bank-country">Account Number</label>
            <input type="text" id="bank-accountno" name="bank-accountno" value="<?=$myProfile["bank_acc"]?>" />
          </div>
          <div id="input-row">
            <label class="bank-country">Re-type Account Number</label>
            <input type="text" id="bank-accountno2" name="bank-accountno2" value="<?=$myProfile["bank_acc"]?>" />
          </div>
        </div>
      </div>
      <hr style="margin:550px 0 30px 0" />
      <div class="block-save-profile">
        <div id="save-profile">
          <input class="lnkimg" type="submit" value="Save Profile" />
          &nbsp;&nbsp;<a href="/profile"> or Cancel</a> </div>
      </div>
    </div>
  </form>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
