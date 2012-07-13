<?php $this->load->view('includes/CAHeader.php'); ?>
<div id="Register_productowner_MainContent" class="MainContent">
  <div id="dialog-holder">
    <div id="dialog-title"></div>
    <div id="dialog">
      <div class="title">No Verification code ?</div>
      <div id="terminal">
        <p>Enter your email address and we'll contact you soon</p>
        <input name="email" id="email" value="" />
      </div>
      <div id="submit-holder" style="width:260px"><a href="/register" id="cancel" style="float:left;" class="CAbutton">Cancel</a> <a style="float:left" href="javascript: void(0)" id="submit" class="CAbutton">Request for code</a> </div>
    </div>
  </div>
</div>
<div id="dialog-message" class="dialog" style="padding-top: 137px">
  <p style="line-height:22px;"> "Your request is sent to higher authoriries.</p>
  <p style="font-size:24pt; margin-top:10px;"> We will contact you soon." </p>
  <div class="medal-message"> <img src="/public/images/codeArmy/badges/html5.png" alt="html5 badge" align="left" />
    <div style="padding:35px">
      <p style="font-size:18pt">You've been promoted to</p>
      <p style="font-size:24pt; margin-top:10px;"><img src="/public/images/codeArmy/badges/private1star.png" alt="private 1 star" /></p>
    </div>
    <div style="margin-top:85px"><a class="CAbutton" href="javascript: void(0);" onclick="proceed()" id="medal-message-continue">Continue</a></div>
  </div>
</div>
<script type="text/javascript">
//preload images function
	function preload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        (new Image()).src = this;
		});
	}
	
	//the effect to be executed once page load.
    function loadEffect(){
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
	
	//things happen when continue button on modal dialog is pressed
	function proceed(){
		$.fancybox.close();
	}
	
	function nextStep(){
		window.location = '/register'	
	}
	
	$('#submit').click(function(){
			data = $('#email').val();
			if($.trim(data)!="")
			$.post(
			'/register/Ajax_req_voucher',
			{ 'email': data, 'ci_csrf_token': getCookie('ci_csrf_token') },
			function(msg){
				msg = msg.split('~');
				if(msg[0]=="success"){
					$.fancybox.open({
						href : '#dialog-message',
						type : 'inline',
						padding : 0,
						margin: 0,
						autoSize: true,
						closeBtn: false,
						closeClick: false,
						modal: true,
						'overlayShow': true,
						'overlayOpacity': 0.5, 
						afterClose: function(){nextStep()},
						openMethod : 'dropIn',
						openSpeed : 250,
						closeMethod : 'dropOut',
						closeSpeed : 150,
						nextMethod : 'slideIn',
						nextSpeed : 250,
						prevMethod : 'slideOut',
						prevSpeed : 250,
						scrolling: 'no'
					});
				}else{
					$('.error').html(msg[1])
					$('.error').show();
				}
			});
		});
	
</script>
<?php $this->load->view('includes/CAFooter.php'); ?>