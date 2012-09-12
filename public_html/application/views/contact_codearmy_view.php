<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<div class="contact-us-container">

<div class="contact-us-left">
  <div class="block-header">
    <h3>Contact Us</h3>
  </div>
  
  <div class="contact-left-content">
  <p>
  169, 11st Street<br />
      San Francisco, CA 94103,<br />
      United States of America.</p><br />
	 <div><span class="label"><span class="icon-envelope-alt" style="font-size:11pt; margin-right:20px;"></span></span><span class="value">contact@codearmy.com</span></div>
<br />
	   <img src="/public/images/codeArmy/profile/contact-fb-icon.png" /> <a href="http://www.facebook.com/CodeArmyHQ" target="_blank">www.facebook.com/CodeArmyHQ</a><br />
	 <img src="/public/images/codeArmy/profile/contact-twitter-icon.png" />  <a href="http://www.twitter.com/Code_Army" target="_blank">www.twitter.com/Code_Army</a><br />
  </div>
</div>
  
<div class="contact-us-right">
 <div class="block-header">
    <h3>Enquiry</h3>
  </div>
  
  <div class="contact-right-content">
  <div class="input-row"><label>Name:</label> <input type="text" name="name" id="contact-name" /></div>
  <div class="input-row"><label>Email:</label>  <input type="text" name="email" id="contact-email" /></div>
  <div class="input-row"><label>Phone:</label> <input type="text" name="phone" id="contact-phone" /></div>
  <div class="input-row"><label>Subject:</label> <select name="subject" id="contact-subject">
    <option value="General">General</option>
    <option value="Sponsership">Sponsorship</option>
    <option value="Development">Development</option>
    <option value="Tallents">Talents</option>
    <option value="Start ups">Startups</option>
    <option value="Projects">Projects</option>
    <option value="Gamification">Gamification</option>
  </select></div>
  <div class="input-row"><label>Message:</label>  <textarea name="message" id="contact-message"></textarea></div>
  <input type="submit" value="Submit" class="lnkimg" id="contact-submit" />
  </div>
  
</div>

<img class="contact-map" src="/public/images/codeArmy/profile/contact-map.jpg" />

</div>

<script>
$('#contact-submit').click(function(){
		$('#contact-ajax').fadeIn();
		contacting = true;
		var message = $('#contact-message').val();
		var name = $('#contact-name').val();
		var email = $('#contact-email').val();
		var subject = $('#contact-subject').val();
		var phone = $('#contact-phone').val();
		$.post(
			'/home/Ajax_contact',
			{'name': name, 'email':email, 'phone': phone, 'subject':subject, 'message': message, 'csrf_workpad': getCookie('csrf_workpad')},
			function(msg){
				contacting = false;
				$('#contact-ajax').fadeOut('fast',function(){$.fancybox.close();});
			}
		);
	});
</script>

<?php $this->load->view('includes/CAProfileFooter.php'); ?>