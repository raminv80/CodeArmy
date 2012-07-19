<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<style>
#profile-wrapper {
	height:1750px;
	background: url("/public/images/codeArmy/profile/profile-edit-bg.jpg") no-repeat;
}
</style>
<div id="profile-edit-content-area">
  <form action="" method="post">
    
    <!-- START - Save Profile + Profile Completion Block - Dev. by Reza  -->
    <div class="block-save-profile">
      <div id="save-profile">
        <input class="lnkimg" type="submit" value="Save Profile" />
        &nbsp;&nbsp;<a href="#"> or Cancel</a> </div>
      <div id="profile-completion"> Profile Completion: 45%
        <div id="profile-completion-bar">
          <div id="profile-completion-progress"> </div>
        </div>
      </div>
    </div>
    <br />
    <hr style="margin-top:50px" />
    
    <!-- START - Level Block - Dev. by Reza  -->
    <div id="block-level"> Level 1 </div>
    
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
    <div id="edit-contact-info">
      <div class="block-header">
        <h3>Contact Information</h3>
      </div>
      <div id="contact-boxes">
        <div id="input-row">
          <label class="email"></label>
          <input type="text" id="email" id="email" value="harish@gmail.com" />
        </div>
        <div id="input-row">
          <label class="skype"></label>
          <input type="text" id="skype" name="skype" value="harishskype" />
        </div>
        <div id="input-row">
          <label class="facebook"></label>
          <input type="text" id="facebook" name="facebook" value="harishfb" />
        </div>
        <div id="input-row">
          <label class="twitter"></label>
          <input type="text" id="twitter" name="twitter" value="harishtw" />
        </div>
        <div id="input-row">
          <label class="linkedin"></label>
          <input type="text" id="linkedin" name="linkedin" value="http://my.linkedin.com/harish" />
        </div>
      </div>
    </div>
    
    <!-- START - Basic Info Block - Dev. by Reza  -->
    <div id="block-basic-info">
      <div id="input-row">
        <input type="text" id="name" name="name" value="Harish" />
      </div>
      <div id="input-row">
        <input type="text" id="title" name="title" value="Web Developer" />
        <input type="text" id="location" name="location" value="Malaysia" />
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
          <input type="text" id="fullname" name="fullname" />
        </div>
        <div id="input-row">
          <label class="address">Address</label>
          <input type="text" id="address" name="address" />
        </div>
        <div id="input-row">
          <label class="phone">Phone</label>
          <input type="text" id="phone" name="phone" />
        </div>
        <div id="input-row">
          <label class="birthday">Birthday</label>
          <input type="text" id="birthday" name="birthday" />
        </div>
      </div>
    </div>
    
    <!-- START - Skill Progression Block - Dev. by Reza  -->
    <div id="block-skill-progression">
      <div class="block-header">
        <h3>Skill Progression</h3>
      </div>
      <div id="personal-info-boxes">
        <div id="input-row">
          <select name="skill1">
            <option value="Photoshop">Photoshop</option>
            <option value="Illustrator">Illustrator</option>
            <option value="JavaScript">JavaScript</option>
          </select>
        </div>
        <div id="input-row">
          <select name="skill2">
            <option value="JavaScript">JavaScript</option>
            <option value="Illustrator">Illustrator</option>
            <option value="Photoshop">Photoshop</option>
          </select>
        </div>
        <div id="input-row">
          <select name="skill3">
            <option value="Illustrator">Illustrator</option>
            <option value="Photoshop">Photoshop</option>
            <option value="JavaScript">JavaScript</option>
          </select>
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
          <input class="links-portfolios-boxes1" type="text" id="github" name="github" value="Github" />
          <input type="text" id="github-address" name="github-address" value="http://" />
        </div>
        <div id="input-row">
          <input class="links-portfolios-boxes1" type="text" id="portfolio" name="portfolio" value="Portfolio" />
          <input type="text" id="portfolio-address" name="portfolio-address" value="www.behance.harish.net" />
        </div>
        <div id="input-row">
          <input class="links-portfolios-boxes1" type="text" id="blog" name="blog" value="Blog" />
          <input type="text" id="blog-address" name="blog-address" value="www.harishblog.com" />
        </div>
        <div id="input-row">
          <input class="links-portfolios-boxes1" type="text" id="" name="" />
          <input type="text" id="" name="" />
        </div>
        <div id="input-row">
          <input class="links-portfolios-boxes1" type="text" id="" name="" />
          <input type="text" id="" name="" />
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
            <input type="text" id="paypal-email" name="paypal-email" />
          </div>
        </div>
        <div id="bank-account">
          <h4>Bank Account Details</h4>
          <div id="input-row">
            <label class="bank-country">Country of Bank</label>
            <input type="text" id="bank-country" name="bank-country" />
          </div>
          <div id="input-row">
            <label class="bank-country">Bank Name</label>
            <input type="text" id="bank-country" name="bank-country" />
          </div>
          <div id="input-row">
            <label class="bank-country">SWIFT Code</label>
            <input type="text" id="bank-country" name="bank-country" />
          </div>
          <div id="input-row">
            <label class="bank-country">Last Name</label>
            <input type="text" id="bank-country" name="bank-country" />
          </div>
          <div id="input-row">
            <label class="bank-country">First Name</label>
            <input type="text" id="bank-country" name="bank-country" />
          </div>
          <div id="input-row">
            <label class="bank-country">Account Number</label>
            <input type="text" id="bank-country" name="bank-country" />
          </div>
          <div id="input-row">
            <label class="bank-country">Re-type Account Number</label>
            <input type="text" id="bank-country" name="bank-country" />
          </div>
        </div>
      </div>
      <hr style="margin:550px 0 30px 0" />
      <div class="block-save-profile">
        <div id="save-profile">
          <input class="lnkimg" type="submit" value="Save Profile" />
          &nbsp;&nbsp;<a href="#"> or Cancel</a> </div>
      </div>
    </div>
  </form>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
