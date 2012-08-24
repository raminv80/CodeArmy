<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<?php
$intTotalFields = 23;
$intTotalCount = 0;

if($myProfile["full_name"] != "") $intTotalCount++;
if($myProfile["contact"] != ""){ 
	$contact = json_decode($myProfile["contact"]);
	if(isset($contact->country) && $contact->country != "") $intTotalCount++;
	if(isset($contact->address) && $contact->address != "") $intTotalCount++;
	if(isset($contact->phone) && $contact->phone != "") $intTotalCount++;
}
if($myProfile["birthdate"] != "") $intTotalCount++;
if($mySkills && isset($mySkills[0])) $intTotalCount++;
if($mySkills && isset($mySkills[1])) $intTotalCount++;
if($mySkills && isset($mySkills[2])) $intTotalCount++;
if($me["email"] != "") $intTotalCount++;
if($myProfile["urls"] != ""){
	$urls = json_decode($myProfile["urls"]);
	if(isset($urls->skype) && $urls->skype != "") $intTotalCount++;
	if(isset($urls->facebook) && $urls->facebook != "") $intTotalCount++;
	if(isset($urls->twitter) && $urls->twitter != "") $intTotalCount++;
	if(isset($urls->linkedin) && $urls->linkedin != "") $intTotalCount++;
	if(isset($urls->github) && $urls->github != "") $intTotalCount++;
	if(isset($urls->portfolio) && $urls->portfolio != "") $intTotalCount++;
	if(isset($urls->blog) && $urls->blog != "") $intTotalCount++;
}
if($myProfile["paypal_acc"] != "") $intTotalCount++;
if($myProfile["bank_country"] != "") $intTotalCount++;
if($myProfile["bank_name"] != "") $intTotalCount++;
if($myProfile["bank_swift"] != "") $intTotalCount++;
if($myProfile["bank_lastname"] != "") $intTotalCount++;
if($myProfile["bank_firstname"] != "") $intTotalCount++;
if($myProfile["bank_acc"] != "") $intTotalCount++;

$intCountProgress = round(($intTotalCount / $intTotalFields) * 100);
?>

<div id="profile-edit-content-area">
    
  <?php echo form_open('profile/edit_profile'); ?>
    
    <!-- START - Save Profile + Profile Completion Block - Dev. by Reza  -->
    <div class="block-save-profile">
      <div id="save-profile">
        <input class="lnkimg" type="submit" value="Save Profile" />
        &nbsp;&nbsp;<a href="/profile"> or Cancel</a> </div>
      <div id="profile-completion"> Profile Completion: <?=$intCountProgress?>%
        <div id="profile-completion-bar">
          <div style="width:<?=$intCountProgress - 1?>%" id="profile-completion-progress"> </div>
        </div>
      </div>
    </div>
    <br />
    <hr style="margin-top:50px" />
    
    <div id="edit-profile-left-col">
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
      <div id="profile-desc">
      <?php if (isset($form_error)){ ?>
      <textarea title="What's in your mind?" name="status-msg" id="status-msg" rows="3"><?=set_value('status-msg')?></textarea>
      <div style="font-size:14px;font-weight:bold;margin-bottom:10px;float:right"><?=form_error("status-msg")?></div>
      <?php } else { ?>
      <textarea title="What's in your mind?" name="status-msg" id="status-msg" rows="3"><?=$myProfile["status_msg"]?></textarea>
      <?php } ?>
     <p style="font-size:9px"> Limited to 255 Characters</p>
      </div>
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
          <?php if (isset($form_error)){ ?>
          <input title="Please enter a valid email" type="text" id="email" name="email" value="<?=set_value('email')?>" />
          <div style="font-size:14px;font-weight:bold;margin-bottom:10px;float:right"><?=form_error("email")?></div>
          <?php } else { ?>
          <input title="Enter your email" type="text" id="email" name="email" value="<?=$me["email"]?>" />
          <?php } ?>
        </div>
        <div id="input-row">
          <label class="skype"></label>
          <?php if (isset($form_error)){ ?>
          <input title="Please eneter a valid skype account" type="text" id="skype" name="skype" value="<?=set_value('skype')?>" />
          <?php } else { ?>
          <input title="Enter your Skype account" type="text" id="skype" name="skype" value="<?php if($urls) echo $urls->skype;?>" />
          <?php } ?>
        </div>
        <div id="input-row">
          <label class="facebook"></label>
          <?php if (isset($form_error)){ ?>
          <input title="Please neter a valid facebook account" type="text" id="facebook" name="facebook" value="<?=set_value('facebook')?>" />
          <?php } else { ?>
          <input title="Enter your facebook account" type="text" id="facebook" name="facebook" value="<?php if($urls) echo $urls->facebook;?>" />
          <?php } ?>
        </div>
        <div id="input-row">
          <label class="twitter"></label>
          <?php if (isset($form_error)){ ?>
          <input title="Please enter a valid twitter account" type="text" id="twitter" name="twitter" value="<?=set_value('twitter')?>" />
          <?php } else { ?>
          <input title="Enter your twitter account" type="text" id="twitter" name="twitter" value="<?php if($urls) echo $urls->twitter;?>" />
          <?php } ?>
        </div>
        <div id="input-row">
          <label class="linkedin"></label>
          <?php if (isset($form_error)){ ?>
          <input title="Please enter a valid linkedin account" type="text" id="linkedin" name="linkedin" value="<?=set_value('linkedin')?>" />
          <?php } else { ?>
          <input title="Enter your linkedin account" type="text" id="linkedin" name="linkedin" value="<?php if($urls) echo $urls->linkedin;?>" />
          <?php } ?>
        </div>
      </div>
    </div>
    
    </div>
    
    
    
    <!-- START - Basic Info Block - Dev. by Reza  -->
    <div id="block-basic-info">
      <div id="input-row">
        <input title="Your Username in CodeArmy" type="text" style="color:#CCC" id="name" name="name" value="<?=$me["username"]?>" readonly="readonly" />
      </div>
      <div id="input-row">
        <input title="Your Division in CodeArmy" type="text" style="color:#CCC" id="title" name="title" value="<?=ucfirst($myProfile["specialization"])?>" readonly="readonly" />
        <!--<input type="text" id="location" name="location" value="<?php if($myCountry) echo $myCountry?>" />-->
          <select title="Enter your country" name="country">
            <option value="">--- Select a country ---</option>
			<?php foreach($countries as $key=>$value): ?>
            <?php if (isset($form_error)){ ?>
            <option value="<?=$key?>"<?php if ($key == set_value('country')){ echo " selected"; } ?>><?=ucfirst($value)?></option>
            <?php } else { ?>
            <option value="<?=$key?>"<?php if($myCountry) if ($key == $contact->country){ echo " selected"; } ?>><?=ucfirst($value)?></option>
            <?php } ?>
            <?php endforeach; ?>
          </select>
          <?php if (isset($form_error)){ ?>
                      <div id="errmsg1"><?=form_error("country")?></div>
          <?php } ?>
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
          <?php if (isset($form_error)){ ?>
          <input title="What is your real name?" type="text" id="fullname" name="fullname" value="<?=set_value('fullname')?>" />
          <div id="errmsg2"><?=form_error("fullname")?></div>
          <?php } else { ?>
          <input title="What is your name?" type="text" id="fullname" name="fullname" value="<?=$myProfile["full_name"]?>" />
          <?php } ?>
        </div>
        <div id="input-row">
          <label class="address">Address</label>
          <?php if (isset($form_error)){ ?>
          <input title="Please enter your address" type="text" id="address" name="address" value="<?=set_value('address')?>" />
          <div id="errmsg2"><?=form_error("address")?></div>
          <?php } else { ?>
          <input title="May i know your address please?" type="text" id="address" name="address" value="<?php if($myCountry) echo $contact->address;?>" />
          <?php } ?>
        </div>
        <div id="input-row">
          <label class="phone">Phone</label>
          <?php if (isset($form_error)){ ?>
          <input title="What's you phone number?" type="text" id="phone" name="phone" value="<?=set_value('phone')?>" />
          <div id="errmsg2"><?=form_error("phone")?></div>
          <?php } else { ?>
          <input title="Contact number" type="text" id="phone" name="phone" value="<?php if($myCountry && isset($contact->phone)) echo $contact->phone;?>" />
          <?php } ?>
        </div>
<script>
$(function() {
	$( "#birthday" ).datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true, yearRange: "1950:<?=date('Y')-5?>" });
});
</script>
        <div id="input-row">
          <label class="birthday">Birthday</label>
          <?php if (isset($form_error)){ ?>
          <input title="What is your birthdate?" type="text" id="birthday" name="birthday" value="<?=set_value('birthday')?>" />
          <div id="errmsg2"><?=form_error("birthday")?></div>
          <?php } else { ?>
          <input title="Are you old enough to be at CodeArmy? DOB please..." type="text" id="birthday" name="birthday" value="<?=$myProfile["birthdate"]?>" />
          <?php } ?>
        </div>
      </div>
    </div>
    
    <!-- START - Skill Progression Block - Dev. by Reza  -->
    <div id="block-skill-progression">
      <div class="block-header">
        <h3 title="You have one time oppurtunity to declare your 3 highest skill set.">Skill Progression</h3>
      </div>
      <div id="personal-info-boxes">
        <div id="input-row">
          <select title="What is your best skill?" name="skill1"<?php if (isset($mySkills[0])) echo " disabled"; ?>>
            <option value=""></option>
          <?php foreach($allSkills as $value): ?>
          <?php if (isset($form_error)){ ?>
            <option value="<?=$value["id"]?>"<?php if ($value["id"] == set_value('skill1')){ echo " selected"; } ?>><?=ucfirst($value["name"])?></option>
          <?php } else { ?>
            <option value="<?=$value["id"]?>"<?php if (isset($mySkills[0])) if ($value["id"] == $mySkills[0]["id"]){ echo " selected"; } ?>><?=ucfirst($value["name"])?></option>
          <?php } ?>
          <?php endforeach; ?>
          </select>
          <?php if (isset($form_error)){ ?>
          <div id="errmsg2"><?=form_error("skill1")?></div>
          <?php } ?>
          <?php if (isset($mySkills[0])){ ?>
          <input type="hidden" name="skill1" value="<?=$mySkills[0]["id"]?>" />
          <?php } ?>
        </div>
        <div id="input-row">
          <select title="What is your second skill?" name="skill2"<?php if (isset($mySkills[1])) echo " disabled"; ?>>
            <option value=""></option>
          <?php foreach($allSkills as $value): ?>
          <?php if (isset($form_error)){ ?>
            <option value="<?=$value["id"]?>"<?php if ($value["id"] == set_value('skill2')){ echo " selected"; } ?>><?=ucfirst($value["name"])?></option>
          <?php } else { ?>
            <option value="<?=$value["id"]?>"<?php if (isset($mySkills[1])) if ($value["id"] == $mySkills[1]["id"]){ echo " selected"; } ?>><?=ucfirst($value["name"])?></option>
          <?php } ?>
          <?php endforeach; ?>
          </select>
          <?php if (isset($form_error)){ ?>
          <div id="errmsg2"><?=form_error("skill2")?></div>
          <?php } ?>
          <?php if (isset($mySkills[1])){ ?>
          <input type="hidden" name="skill2" value="<?=$mySkills[1]["id"]?>" />
          <?php } ?>
        </div>
        <div id="input-row">
          <select title="What is your third skill?" name="skill3"<?php if (isset($mySkills[2])) echo " disabled"; ?>>
            <option value=""></option>
          <?php foreach($allSkills as $value): ?>
          <?php if (isset($form_error)){ ?>
            <option value="<?=$value["id"]?>"<?php if ($value["id"] == set_value('skill3')){ echo " selected"; } ?>><?=ucfirst($value["name"])?></option>
          <?php } else { ?>
            <option value="<?=$value["id"]?>"<?php if (isset($mySkills[2])) if ($value["id"] == $mySkills[2]["id"]){ echo " selected"; } ?>><?=ucfirst($value["name"])?></option>
          <?php } ?>
          <?php endforeach; ?>
          </select>
          <?php if (isset($form_error)){ ?>
          <div id="errmsg2"><?=form_error("skill3")?></div>
          <?php } ?>
          <?php if (isset($mySkills[2])){ ?>
          <input type="hidden" name="skill3" value="<?=$mySkills[2]["id"]?>" />
          <?php } ?>
        </div>
      </div>
    </div>
    
    <!-- START - Links and Portfolios Block - Dev. by Reza  -->
    <div id="block-links-portfolios">
      <div class="block-header">
        <h3>Links and Portfolios</h3>
      </div>
      <div class="links-portfolios-boxes">
        <div id="input-row">
          <input class="links-portfolios-boxes1" type="text" id="github" name="github" value="Github" readonly="readonly" />
          <?php if (isset($form_error)){ ?>
          <input title="What is your Github account?" type="text" id="github-address" name="github-address" value="<?=set_value('github-address')?>" />
          <?php } else { ?>
          <input title="Your Github account?" type="text" id="github-address" name="github-address" value="<?php if ($urls) echo $urls->github;?>" />
          <?php } ?>
        </div>
        <div id="input-row">
          <input class="links-portfolios-boxes1" type="text" id="portfolio" name="portfolio" value="Portfolio" readonly="readonly" />
          <?php if (isset($form_error)){ ?>
          <input title="What is your Portfolio address?" type="text" id="portfolio-address" name="portfolio-address" value="<?=set_value('portfolio-address')?>" />
          <?php } else { ?>
          <input title="URL to your portfolio?" type="text" id="portfolio-address" name="portfolio-address" value="<?php if ($urls) echo $urls->portfolio;?>" />
          <?php } ?>
        </div>
        <div id="input-row">
          <input class="links-portfolios-boxes1" type="text" id="blog" name="blog" value="Blog" readonly="readonly" />
          <?php if (isset($form_error)){ ?>
          <input title="Do you have a blog?" type="text" id="blog-address" name="blog-address" value="<?=set_value('blog-address')?>" />
          <?php } else { ?>
          <input title="Your blog address?" type="text" id="blog-address" name="blog-address" value="<?php if ($urls) echo $urls->blog;?>" />
          <?php } ?>
        </div>
        <div id="input-row">
          <?php if (isset($form_error)){ ?>
          <input title="Extra link title 1" class="links-portfolios-boxes1" type="text" id="extra1" name="extra1" value="<?=set_value('extra1')?>" />
          <?php } else { ?>
          <input title="Extra link title 1" class="links-portfolios-boxes1" type="text" id="extra1" name="extra1" value="<?php if ($urls) echo $urls->extra1;?>" />
          <?php } ?>
          <?php if (isset($form_error)){ ?>
          <input title="Extra link 1" type="text" id="extraaddress1" name="extraaddress1" value="<?=set_value('extraaddress1')?>" />
          <?php } else { ?>
          <input title="Extra link 1" type="text" id="extraaddress1" name="extraaddress1" value="<?php if ($urls) echo $urls->extraaddress1;?>" />
          <?php } ?>
        </div>
        <div id="input-row">
          <?php if (isset($form_error)){ ?>
          <input title="Extra link title 2" class="links-portfolios-boxes1" type="text" id="extra2" name="extra2" value="<?=set_value('extra2')?>" />
          <?php } else { ?>
          <input title="Extra link title 2" class="links-portfolios-boxes1" type="text" id="extra2" name="extra2" value="<?php if ($urls) echo $urls->extra2;?>" />
          <?php } ?>
          <?php if (isset($form_error)){ ?>
          <input title="Extra link 2" type="text" id="extraaddress2" name="extraaddress2" value="<?=set_value('extraaddress2')?>" />
          <?php } else { ?>
          <input title="Extra link 2" type="text" id="extraaddress2" name="extraaddress2" value="<?php if ($urls) echo $urls->extraaddress2;?>" />
          <?php } ?>
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
          <?php if (isset($form_error)){ ?>
            <input title="What is your paypal email?" type="text" id="paypal-email" name="paypal-email" value="<?=set_value('paypal-email')?>" />
             <div id="errmsg3"><?=form_error("paypal-email")?></div>
          <?php } else { ?>
            <input title="Your Paypal email" type="text" id="paypal-email" name="paypal-email" value="<?=$myProfile["paypal_acc"]?>" />
          <?php } ?>
          </div>
        </div>
        <div id="bank-account">
          <h4>Bank Account Details</h4>
          <div id="input-row">
            <label title="What is the country of your bank?" class="bank-country">Country of Bank</label>
            <!--<input type="text" id="bank-country" name="bank-country" value="<?=$myProfile["bank_country"]?>" />-->
          <select title="Country of your bank" name="bank-country">
            <option value="">--- Select a country ---</option>
          <?php foreach($countries as $key=>$value): ?>
          <?php if (isset($form_error)){ ?>
            <option value="<?=$key?>"<?php if ($key == set_value('bank-country')){ echo " selected"; } ?>><?=ucfirst($value)?></option>
          <?php } else { ?>
            <option value="<?=$key?>"<?php if($myProfile["bank_country"]!='') if ($key == $myProfile["bank_country"]){ echo " selected"; } ?>><?=ucfirst($value)?></option>
          <?php } ?>
          <?php endforeach; ?>
          </select>
          <?php if (isset($form_error)){ ?>
          <div id="errmsg3"><?=form_error("bank-country")?></div>
          <?php } ?>
          </div>
          <div id="input-row">
            <label class="bank-country">Bank Name</label>
          <?php if (isset($form_error)){ ?>
            <input title="What is the bank name?" type="text" id="bank-name" name="bank-name" value="<?=set_value('bank-name')?>" />
            <div id="errmsg3"><?=form_error("bank-name")?></div>
          <?php } else { ?>
            <input title="Bank name" type="text" id="bank-name" name="bank-name" value="<?=$myProfile["bank_name"]?>" />
          <?php } ?>
          </div>
          <div id="input-row">
            <label class="bank-country">SWIFT Code</label>
          <?php if (isset($form_error)){ ?>
            <input title="What is your bank's swift number?" type="text" id="bank-swift" name="bank-swift" value="<?=set_value('bank-swift')?>" />
            <div id="errmsg3"><?=form_error("bank-swift")?></div>
          <?php } else { ?>
            <input title="Bank swift number" type="text" id="bank-swift" name="bank-swift" value="<?=$myProfile["bank_swift"]?>" />
          <?php } ?>
          </div>
          <div id="input-row">
            <label class="bank-country">Last Name</label>
          <?php if (isset($form_error)){ ?>
            <input title="What is your last name?" type="text" id="bank-lastname" name="bank-lastname" value="<?=set_value('bank-lastname')?>" />
            <div id="errmsg3"><?=form_error("bank-lastname")?></div>
          <?php } else { ?>
            <input title="Your last name" type="text" id="bank-lastname" name="bank-lastname" value="<?=$myProfile["bank_lastname"]?>" />
          <?php } ?>
          </div>
          <div id="input-row">
            <label class="bank-country">First Name</label>
          <?php if (isset($form_error)){ ?>
            <input title="What is your first name?" type="text" id="bank-firstname" name="bank-firstname" value="<?=set_value('bank-firstname')?>" />
            <div id="errmsg3"><?=form_error("bank-firstname")?></div>
          <?php } else { ?>
            <input title="Your first name" type="text" id="bank-firstname" name="bank-firstname" value="<?=$myProfile["bank_firstname"]?>" />
          <?php } ?>
          </div>
          <div id="input-row">
            <label class="bank-country">Account Number</label>
          <?php if (isset($form_error)){ ?>
            <input title="What is your account number?" type="text" id="bank-accountno" name="bank-accountno" value="<?=set_value('bank-accountno')?>" />
            <div id="errmsg3"><?=form_error("bank-accountno")?></div>
          <?php } else { ?>
            <input title="account number" type="text" id="bank-accountno" name="bank-accountno" value="<?=$myProfile["bank_acc"]?>" />
          <?php } ?>
          </div>
          <div id="input-row">
            <label class="bank-country">Re-type Account Number</label>
          <?php if (isset($form_error)){ ?>
            <input title="Retype your account number" type="text" id="bank-accountno2" name="bank-accountno2" value="<?=set_value('bank-accountno2')?>" />
            <div id="errmsg3"><?=form_error("bank-accountno2")?></div>
          <?php } else { ?>
            <input title="retype your account number" type="text" id="bank-accountno2" name="bank-accountno2" value="<?=$myProfile["bank_acc"]?>" />
          <?php } ?>
          </div>
        </div>
      </div>
      <hr style="position:relative; width:780px; float:left;" />
      <div class="block-save-profile">
        <div id="save-profile">
          <input class="lnkimg" type="submit" value="Save Profile" />
          &nbsp;&nbsp;<a href="/profile"> or Cancel</a> </div>
      </div>
    </div>
  </form>
</div>
<script type="text/javascript">
	$('#profile-edit-content-area [title]').tipsy({trigger: 'hover', gravity: 'e'});
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
