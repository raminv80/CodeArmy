    
    </div>
    
	<div id="footer">
        <div id="social-links">
            <div style="display:block; width:75px;float:left">Follow us on</div> <a target="_blank" id="facebook" href="http://www.facebook.com/CodeArmyHQ">Facebook</a> <a id="twitter" target="_blank" href="https://twitter.com/#!/Code_Army">Twitter</a>
        </div>
        <ul id="footer_links">
            <li><a href="/contact">Contact us</a></li>
            <?php if($this->uri->segment(1)!='contact'){?>
            <li><a class="contact_button" href="javascript:void(0)">Feedback</a></li>
            <?php }?>
            <li><a href="/faq">FAQ's</a></li>
            <li><a href="/blog" target="_blank">Blog</a></li>
            <li><a href="/term">T&amp;C</a></li>
            <!--<li><a href="javascript:var firebug=document.createElement('script');firebug.setAttribute('src','http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js');document.body.appendChild(firebug);(function(){if(window.firebug.version){firebug.init();}else{setTimeout(arguments.callee);}})();void(firebug);">Firebug Lite</a></li>-->
        </ul>
        <div id="copywrite">COPYRIGHT &copy; 2012 CodeArmy All rights reserved</div>
    </div>
<div id="debugger" style="background: rgba(20,40,0,0.9); position:absolute;top:0;left:0;text-align:left;display:none;">
	<h2>Console:</h2>
	<?php echo "<pre style=\"border: 1px solid #000; overflow: auto; margin: 2em;\">"; ?>
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++++++Session Values++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    <?php echo nl2br(var_export($this->session->userdata,true)); ?>
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++++++PASSED Variables++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	<?php echo nl2br(var_export($this->_ci_cached_vars,true)); ?>
    <?php echo "</pre>\n";?>
</div>
    </div>
    <!-- <div id="bg-inner">
    <img src="/public/images/codeArmy/profile/bg.jpg" />
    </div> -->
</div>
<div id="dialog-accept" class="dialog" title="Proposal Accepted">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Your proposal is accepted. Hurry up and be the first one to report to captain before someone else takes the mission.</p>
</div>
<div id="contact">
  <div class="contact_info">
    <p style="font-size:10pt">
      169, 11st Street<br />
      San Francisco, CA 94103,<br />
      United States of America.</p>
    <ul class="contact_details" style="font-size:10pt; left:-14px; top:140px;">
      <!--<li><span class="label">Tel:</span><span class="value">603 2282 5060</span></li>
      <li><span class="label">Fax:</span><span class="value">603 2284 5060</span></li>-->
      <li><span class="label"><span class="icon-envelope-alt" style="font-size:11pt; margin:0 20px 0 10px;"></span></span><span class="value">contact@codearmy.com</span></li>
    </ul>
    <ul class="social_links">
      <li><span class="label"></span><a class="value" href="http://www.facebook.com/CodeArmyHQ">www.facebook.com/CodeArmyHQ</a></li>
      <li><span class="label"></span><a class="value" href="https://twitter.com/#!/Code_Army">www.twitter.com/Code_Army</a></li>
    </ul>
  </div>
  <?php echo form_open('contact', array('id'=>'contact-form')); ?> <img src="/public/images/codeArmy/loader4.gif" style="position:absolute; top:28px; right:331px; display:none;" id="contact-ajax" /> <span style="position:absolute; left:373px; top:60px;">Name</span>
  <input type="text" name="name" id="contact-name" style="top: 55px;left: 450px;" />
  <span style="position:absolute; left:373px; top:95px;">Email</span>
  <input type="text" name="email" id="contact-email" style="top: 90px;left: 450px;" />
  <span style="position:absolute; left:373px; top:130px;">Phone</span>
  <input type="text" name="phone" id="contact-phone" style="top: 125px;left: 450px;" />
  <span style="position:absolute; left:373px; top:165px;">Subject</span>
  <select name="subject" id="contact-subject" style="top:163px;left:450px;display:block;width:315px;height:22px;position:absolute;border:none;">
    <option value="General">General</option>
    <option value="Sponsership">Sponsorship</option>
    <option value="Development">Development</option>
    <option value="Tallents">Talents</option>
    <option value="Start ups">Startups</option>
    <option value="Projects">Projects</option>
    <option value="Gamification">Gamification</option>
  </select>
  <span style="position:absolute; left:373px; top:220px;">Message</span>
  <textarea name="message" id="contact-message" style="position:absolute; display:block; width:309px; height:79px; top:201px; left:450px; background:none; border:none; color:white; font-size:9pt; font-family:'Ruda', sans-serif;"></textarea>
  <?php echo form_close(); ?> <a href="javascript: void(0)" id="contact-submit" class="CAbutton" style="position:absolute; right:5px; top:300px; color:#CCC">Submit</a> </div>

<script>
	$('#dropdown-button').click(function(){$('#dropdown').slideToggle('fast');})
	$('#logo').click(function(){window.location="/profile"});
	$('#missions-toggle').click(function(){$('#mission-submenue').slideToggle();});
	function loadEffect(){}
	var messages_channel = pusher.subscribe('message-<?=$me['user_id']?>');
    messages_channel.bind('new-message', function(data) {
	  var el = $('#messages-notification');
	  el.html(parseInt(el.html())+1).removeClass('hidden').removeClass('blur');
    });
	var contacting = false;
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
	$('.contact_button').click(function(){
			$.fancybox.open({
				href : '#contact',
				type : 'inline',
				padding : 0,
				margin: 0,
				autoSize: true,
				//modal: true,
				helpers:{
					overlay : {
						speedIn  : 0,
						speedOut : 300,
						opacity  : 0.5,
						css      : {
							cursor : 'pointer'
						},
						closeClick: true
					}
				},
				scrolling: 'no'
			});
		});
</script>
<?php $this->load->view('includes/CAFooter.php'); ?>