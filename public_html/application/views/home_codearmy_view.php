<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CodeAr.my</title>
<link rel="icon" type="image/png" href="/favicon.png" />
<link href='http://fonts.googleapis.com/css?family=Ruda' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Black+Ops+One' rel='stylesheet' type='text/css' />
<link href="/public/css/reset.css" media="all" rel="stylesheet" type="text/css" />
<link href="/public/css/v4/tipsy.css" media="all" rel="stylesheet" type="text/css" />
<link type="text/css" href="/public/css/CodeArmyV1/ui-army/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="/public/js/codeArmy/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=2.0.6" type="text/css" media="screen" />
<link rel="stylesheet" href="/public/js/codeArmy/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.2" type="text/css" media="screen" />
<link rel="stylesheet" href="/public/js/codeArmy/fancybox/source/jquery.fancybox.css?v=2.0.6" type="text/css" media="screen" />
<script type="text/javascript" src="/public/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="/public/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="/public/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/public/js/v4/jquery.tipsy.js"></script>
<script type="text/javascript" src="/public/js/codeArmy/modernize.js"></script>
<script type="text/javascript" src="/public/js/codeArmy/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="/public/js/codeArmy/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="/public/js/codeArmy/fancybox/source/jquery.fancybox.pack.js?v=2.0.6"></script>
<script type="text/javascript" src="/public/js/codeArmy/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
<script type="text/javascript" src="/public/js/codeArmy/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.0"></script>
<script type="text/javascript" src="/public/js/codeArmy/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=2.0.6"></script>
<script type="text/javascript" src="/public/js/v4/jquery.scrollTo-1.4.2-min.js"></script>
<script type="text/javascript" src="/public/js/v4/jquery.localscroll-1.2.7-min.js"></script>
<script type="text/javascript" src="/public/js/codeArmy/header.js"></script>
<link media="all" rel="stylesheet" type="text/css" href="/public/css/CodeArmyV1/all.css" />
</head>
<body>
<div id="header">
  <div class="inner">
    <div class="top"> <a href="javascript: void(0);" class="contact contact_button">Contact us</a> | <a href="/blog" class="contact" target="_blank">Blog</a>
      <ul class="social-networks">
        <li><a href="http://www.facebook.com/CodeArmyHQ" class="facebook" target="_blank">Facebook</a></li>
        <li><a href="http://www.linkedin.com/company/code_army" class="linkedin" target="_blank">LinkedIn</a></li>
        <li><a href="https://twitter.com/#!/Code_Army" class="twitter" target="_blank">Twitter</a></li>
      </ul>
    </div>
    <div class="holder">
      <h1 class="logo"><a href="#">CODEAR.MY BETA</a></h1>
      <ul class="main-nav">
        <li><a href="#overview">Overview</a></li>
        <li><a href="#owner">Startups</a></li>
        <li><a href="#talent">talent</a></li>
        <li><a href="javascript: void(0);" class="register">sign up</a></li>
        <li><a href="javascript: void(0);" id="login">log in</a></li>
      </ul>
    </div>
  </div>
</div>
<div id="wrapper">
  <div id="main">
  <!--sponsor block-->
      <div class="sponsor">
        <div class="holder">
          <h2 style="color: #333333; font-size:34px; text-shadow:none; text-transform:none; margin:35px 0 10px 0; background:#FFFFFF;">Proud Sponsor of <img src="/public/images/codeArmy/home/gsummit-logo.png" alt="Gsummit Logo" /></h2>
          <p style="margin:10px 0 30px 0;">San Francisco, June 19-21, 2012</p>
          <div class="video-holder" style="float:left;">
            <?php if(isset($email) && ($email!='')){?>
            <div style="background:#CFF; text-align:center;">
              <?= $email ?>
            </div>
            <?php }?>
            <!--<img src="/public//public/images/codeArmy/home/codeArmy/home/video.gif" alt="video" width="640" height="390" />-->
            <iframe class="youtube-player" type="text/html" width="640" height="360" src="http://www.youtube.com/embed/tC5XYY-WJ04?wmode=opaque" frameborder="0"></iframe>
          </div>
          <div style="float:right; width:30%;">
            <div style="width:275px; float:left">
              <h2 style="text-align:left; float:left; width:200px; text-shadow:none; text-transform:none; line-height:0.9;">Drop by <font style="color:#000000">and</font> Say Hi</h2>
              <img src="/public/images/codeArmy/home/logo-pic.png" style="float:right" /></div>
            <p style="text-align:left; margin-top:85px;">Make your way to GSummit</p>
            <img width="290" src="/public/images/codeArmy/home/sep-bg.png" style=" float:left;" />
            <p style="text-align:left; margin:25px 0; font-size:16px; line-height:1.1; color:#333333;"> Follow and ReTweet <a href="https://twitter.com/#!/@Code_Army" target="_blank">@Code_Army</a> and stand a chance to win ONE 
              COMPLIMENTARY PASS to the 
              Gamification Summit 2012. </p>
            <a href="http://www.gsummit.com/register/" target="_blank"><img src="/public/images/codeArmy/home/gs-ticket.jpg" style="float:left; margin-left:-20px;" /></a> </div>
        </div>
      </div>
     <!--concept block-->
      <div class="opening" id="overview">
        <div class="holder">
          <h2 style="text-transform:none; margin-bottom:20px; color:#000; text-shadow:none;">Putting Back <font style=" color:#FF6600;">'Work'</font> into <font style=" color:#FF6600;">'Fun'</font></h2>
          <div class="video-holder">
            <?php if(isset($email) && ($email!='')){?>
            <div style="background:#CFF; text-align:center;">
              <?= $email ?>
            </div>
            <?php }?>
            <iframe class="youtube-player" type="text/html" width="640" height="360" src="http://www.youtube.com/embed/zFNb8j3YAd4?wmode=opaque" frameborder="0"></iframe>
          </div>
          <div class="text-holder">
            <h2>You Are <img src="/public/images/codeArmy/home/logo-name.png" alt="CodeAr.my" title="CodeAr.my" /></h2>
            <p>Simply speaking –  the right people, the right time, the right price, who can actually do the job!</p>
          </div>
        </div>
      </div>
    <!--start up block-->
      <div class="owner-block">
        <div class="holder" id="owner">
          <div class="frame">
            <h2>STARTUPS <span>Assemble &amp; Manage Your Army</span></h2>
            <div class="sign-block">
              <div class="text">
                <h3>Talent available for hire <span class="mark">24/7</span></h3>
                <p style="width:400px">List your project. Identify job scope, timeframes needed, 
                  desired outcomes. Pinpoint suitable people from our global talent pool</p>
              </div>
              <div style="float:right; width:288px;"> <a href="javascript: void(0);" class="login"><img src="/public/images/codeArmy/home/beta-signup.png" alt="Beta Sign Up" /></a> </div>
            </div>
            <div class="img-row">
              <div class="img-holder"><img src="/public/images/codeArmy/home/img1.png" alt="image description" width="115" height="100" /></div>
              <div class="img-holder"><img src="/public/images/codeArmy/home/img2.png" alt="image description" width="183" height="100" /></div>
              <div class="img-holder"><img src="/public/images/codeArmy/home/img3.png" alt="image description" width="92" height="100" /></div>
            </div>
            <div class="text-row">
              <div class="block">
                <h4 style="text-align:center;">Talent &amp; Skill Rating</h4>
                <p>CodeAr.my test and verifies each members skill level and assigns a ranking based on what they can actually do.</p>
              </div>
              <div class="block center">
                <h4>Assemble &amp; Disband Ar.my</h4>
                <p style="text-align:center;">Manage the project and
                  communication process through CodeAr.my platform. Once your is successfully completed, disband your platoon to give them a 
                  well deserved leave of
                  absence.</p>
              </div>
              <div class="block">
                <h4 style="width:250px;text-align:center;">Manage Relationships</h4>
                <p style="text-align:justify;width: 260px;">Use CodeAr.my to manage relationships through ongoing communication, build understanding through collaboration, and control procedures with our easy to use interface.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!--talent block-->
      <div class="talent-block">
        <div class="holder" id="talent">
          <div class="frame">
            <h2>Talent <span>We've got you covered!</span></h2>
            <div class="row">
              <div class="sign-block">
                <div class="text">
                  <h3 style="font-size:32px; margin-top:20px;">Freedom to work on what you want!</h3>
                </div>
                <div style="float:right; width:288px;"> <a href="javascript: void(0);" class="login"><img src="/public/images/codeArmy/home/beta-signup.png" alt="Beta Sign Up" /></a> </div>
              </div>
              <div class="text-block">
                <div class="img-holder" style="margin-bottom: -20px; text-align:center;"> <img src="/public/images/codeArmy/home/icon-control.png" alt="image description" /> </div>
                <h4 style="text-align:center;">Be In Control</h4>
                <p>You control your workload and the jobs that you accept. Take on a whole contract, or a sub-section of it relevant to your skills.</p>
              </div>
            </div>
            <div class="text-row">
              <div class="block">
                <div class="img-holder" style="top:-10px"> <img src="/public/images/codeArmy/home/icon-submit.png" alt="image description" /> </div>
                <h4 style="text-align:center;">Submit Your Bid</h4>
                <p>Be the best that you can. Work alongside other high-performers. Continually challenge and develop your abilities.</p>
              </div>
              <div class="block center">
                <div class="img-holder"> <img src="/public/images/codeArmy/home/icon-level.png" alt="image description" width="149" height="85" /> </div>
                <h4>Build Your Profile</h4>
                <p style="text-align:center;">Create your virtual CV. Prove your skills through various tasks. Upgrade your skills with our self-development activities</p>
              </div>
              <div class="block">
                <div class="img-holder" style="top:-10px"> <img src="/public/images/codeArmy/home/icon-reward.png" alt="image description" /> </div>
                <h4 style="text-align:center;">Reward</h4>
                <p>Each basic training project 
                  completed successfully earns you. The more badges you have, the higher your chances of getting more advanced work. </p>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div id="footer">
      <div class="nav-holder">
        <div class="frame">
          <ul>
            <li>Copyright 2012 CODEAR.My</li>
            <li><a href="javascript:void(0);" class="contact_button">contact us</a></li>
            <li><a href="/blog" class="contact" target="_blank">Blog</a></li>
            <li>
              <ul class="social-networks">
                <li><a href="http://www.facebook.com/CodeArmyHQ" class="facebook" target="_blank">Facebook</a></li>
                <li><a href="http://www.linkedin.com/company/code_army" class="linkedin" target="_blank">LinkedIn</a></li>
                <li><a href="https://twitter.com/#!/Code_Army" class="twitter" target="_blank">Twitter</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
</div>
<div id="login-box"> <?php echo form_open('login/validate_credentials' , array('id'=>'login-form')); ?> <span id="error" class="error" style="position:absolute;left:167px; top:67px;"></span> <span style="position:absolute; right:414px; top:94px;">Email or username</span>
  <input type="text" name="username" id="user" style="position:absolute;top:89px;left:167px;" />
  <span style="position:absolute; right:414px; top:129px;">Password</span>
  <input type="password" name="password" id="pass" style="position:absolute;top:124px; left:167px;" />
  <a href="/login/recovery" style="color:#65caff; position:absolute; right:262px;top:217px;">Forgot your password?</a>
  <input style="position:absolute; right:180px; top:160px;" type="checkbox" name="remember" id="remember" value="remember" />
  <label style="position:absolute; right:90px; top:162px;" for="remember">Remember me</label>
  <a href="javascript: void(0)" id="login-submit" class="CAbutton" style="position:absolute; right:85px; top:202px;">Login</a> <img src="/public/images/codeArmy/loader4.gif" style="position:absolute; top:42px; right:463px;display:none" id="login-ajax" /> <?php echo form_close(); ?> </div>
<div id="register-box"> <?php echo form_open('signup', array('id'=>'register-form')); ?> <img src="/public/images/codeArmy/loader4.gif" style="position:absolute; top:42px; right:451px; display:none" id="reg-ajax" /> <span id="reg-error" class="error" style="position:absolute;left:167px; top:67px;"></span> <span style="position:absolute; right:414px; top:94px;">Username</span>
  <input type="text" name="name" id="name" style="position:absolute;top:89px;left:167px; width:292px;" />
  <!--<input type="text" name="family" id="family" style="position:absolute;top:89px;left:324px; width:134px;" />-->
  <!--<span style="position:absolute; right:414px; top:129px;">Date of birth</span>
    <input type="text" name="dob" class="datepicker" id="dob" style="position:absolute;top:124px;left:167px; width:134px;" />
    <a href="javascript: void(0);" style="position:absolute;left:322px; top:124px;">
	<style>
	.ui-datepicker-trigger{ cursor:pointer; position:absolute; left:322px; top:124px;}
	</style>
	</a>
    -->
  <span style="position:absolute; right:414px; top:129px;">Email</span>
  <input type="text" name="email" id="email" style="position:absolute;top:124px;left:166px; width:292px;" />
  <span style="position:absolute; right:414px; top:165px;">Password</span>
  <input type="password" name="password" id="password" style="position:absolute;top:160px;left:166px; width:292px;" />
  <!--<input type="checkbox" name="tc" id="tc" value="tc" style="position:absolute;left:163px; top:232px;" />
    <label for="tc" style="position:absolute;left:181px; top:234px;">I acknowledge terms and conditions are agreed upon.</label>-->
  <a href="javascript: void(0)" id="register-submit" class="CAbutton" style="position:absolute; right:85px; top:198px; color:#CCC">Sign up</a> <?php echo form_close(); ?> </div>
  
<div id="contact">
    <div class="contact_info">
      <p>Code Gamification Sdn Bhd<br />
        Suite 29-6, Boulevard Office, <br />
        Mid Valley City, Lingkaran Syed Putra,<br />
        59200 Kuala Lumpur, Malaysia.</p>
      <ul class="contact_details">
        <li><span class="label">Tel:</span><span class="value">603 2282 5060</span></li>
        <li><span class="label">Fax:</span><span class="value">603 2284 5060</span></li>
        <li><span class="label">Email:</span><span class="value">contact@codearmy.com</span></li>
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
    <?php echo form_close(); ?>
    <a href="javascript: void(0)" id="contact-submit" class="CAbutton" style="position:absolute; right:5px; top:300px; color:#CCC">Submit</a> </div>
<script type="text/javascript">
//preload images function
	function preload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        (new Image()).src = this;
		});
	}
	
	//the effect to be executed once page load.
    function loadEffect(){
		$.localScroll();
        $('#Register_productowner_MainContent').fadeIn('slow',function(){
                                                            $('#dialog').slideDown(function(){
																	$('#po').show('fast');
																});
                                                          });
    }
	
	//list of images to be preloaded
    preload([
		'/public/images/codeArmy/designer_test/submit_hover.png',
	]);
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
			{'name': name, 'email':email, 'phone': phone, 'subject':subject, 'message': message, 'ci_csrf_token': getCookie('ci_csrf_token')},
			function(msg){
				contacting = false;
				$('#contact-ajax').fadeOut('fast',function(){$.fancybox.close();});
			}
		);
	});
	
	$('.register').click(function(){
			$.fancybox.open({
				href : '#register-box',
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
	
		$('#login').click(function(){
			$.fancybox.open({
				href : '#login-box',
				type : 'inline',
				padding : 0,
				margin: 0,
				autoSize: true,
				closeBtn: true,
				closeClick: false,
				//modal: true,
				helpers:{
					overlay : {
						speedIn  : 300,
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
		
	$("#user").keyup(function(event){
		if(event.keyCode == 13){
			$("#login-submit").click();
		}
		$(this).css({border:'none'});
		$('#error').hide();
	});
	$("#pass").keyup(function(event){
		if(event.keyCode == 13){
			$("#login-submit").click();
		}
		$(this).css({border:'none'});
		$('#error').hide();
	});
	
	$('#login-submit').click(function(){
			//check user
			$('#error').hide();
			$('#user').stop(true,false).css({border:'none'});
			$('#pass').stop(true,false).css({border:'none'});
			data = $('#user').val();
			if($.trim(data)!=""){
				$('#login-ajax').fadeIn();
				$.post(
					'/login/Ajax_checkUser',
					{ 'user': data, 'ci_csrf_token': getCookie('ci_csrf_token') },
					function(msg){
						if(msg=="success"){
							//check pass
							data1 = $('#pass').val();
							if($.trim(data1)!="")
							$.post(
								'login/Ajax_checkPass',
								{'username': data,'password':data1,'ci_csrf_token': getCookie('ci_csrf_token') },
								function(msg){
									if(msg=="success"){
										//submit the form
										$('#login-form').submit();
									}else{
										//pass is invalid
										$('#login-ajax').fadeOut();
										$('#error').html('You password is incorrect!').show();
										$('#pass').stop(true,false).css({border:'1px solid red'}).effect("bounce", {times:2, distance: 10}, 200);
									}
								}
							);
						}else{
							//username or emial is invalid
							$('#login-ajax').fadeOut();
							$('#error').html('Entered email or username is not recognised!').show();
							$('#user').stop(true,false).css({border:'1px solid red'}).effect("bounce", {times:2, distance: 10}, 200);
						}
					}
				);
			}
		});
		
		function isValidEmailAddress(emailAddress) {
			var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
			return pattern.test(emailAddress);
		};
		
		$('#register-submit').click(function(){
			var name = $('#name').val();
			//var family = $('#family').val();
			var email = $('#email').val();
			//var dob = $('#dob').val();
			var password = $('#password').val();
			//var tc = $('#tc').attr('checked');
			var tc = true;
			var error = new Array();
			if(tc){
				if($.trim(name)!=""){
					if(isValidEmailAddress(email)){
						$('#reg-ajax').fadeIn();
						$.ajax({
							type:'POST',
							url:'register/Ajax_checkEmail',
							data:{'email': email,'ci_csrf_token': getCookie('ci_csrf_token') },
							success:function(msg){
								if(msg=="success"){
									$('#reg-ajax').show();
									$.ajax({
										type: 'POST',
										url: 'register/Ajax_checkUsername',
										data: {'username': name, 'ci_csrf_token': getCookie('ci_csrf_token') },
										success:function(msg){
											if(msg=="success"){
												if(password.length>6){
													//submit the form.
													console.log('submitting the form...');
													$.ajax({
														type: 'POST',
														url: 'register/Ajax_signup',
														data: {'username': name, 'password': password, 'email':email, 'ci_csrf_token': getCookie('ci_csrf_token')},
														success:function(msg){
															$('#reg-ajax').fadeOut();
															if(msg=="success"){
																//register done
																console.log('Signup success. Redirecting...');
																window.location="/register"
															}else{
																//register error
																console.log('Signup error.',msg);
																text=msg;
																$('#reg-error').html(text).stop(true,false).show().effect("bounce", {times:2, distance: 10}, 200);
															}
														}
													});
												}else{
													text='Password should include more than 6 character';
													$('#reg-error').html(text).stop(true,false).show().effect("bounce", {times:2, distance: 10}, 200);
												}
											}else{
												$('#reg-ajax').fadeOut();
												text='Username is taken.';
												$('#reg-error').html(text).stop(true,false).show().effect("bounce", {times:2, distance: 10}, 200);
											}
										}
									});
								}else{
									$('#reg-ajax').fadeOut();
									text='This email is already registered.';
									$('#reg-error').html(text).stop(true,false).show().effect("bounce", {times:2, distance: 10}, 200);
								}
							}
						});
					}else{
						error.push('Please provide a valid email address.');
					}
				}else{
					error.push('Type a unique username.');
				}
			}else{
				error.push('You need to acknowledge terms and conditions');
			}
			if(error.length>0){
				text = error[0];
				$('#reg-error').html(text).stop(true,false).show().effect("bounce", {times:2, distance: 10}, 200);;
			}else{
				$('#reg-error').hide();
			}
		});
</script>
<script type="text/javascript" src="/public/js/codeArmy/footer.js"></script>
<div id="homebg-left"><img src="/public/images/codeArmy/home/bghome-twitter.jpg" /></div>

</body>
</html>
