<?php $this->load->view('includes/CAHeader.php'); ?>
<div id="Register_productowner_MainContent" class="MainContent">
  <div id="dialog-holder">
    <div id="dialog-title"></div>
    <div id="dialog">
      <div class="title">Oh really?</div>
      <div class="text">
        <p>"So you own a project and need an Ar.my do ya?</p>
        <p>Well then let enter your verification code below" </p>
      </div>
      <div id="terminal">
        <p>Enter verification code here </p>
        <input name="voucher" id="voucher" value="" /><br><em class="error"></em>
      </div>
      <div id="submit-holder"> <a href="javascript: void(0)" id="submit" class="CAbutton">Report for duty</a> </div>
    </div>
  </div>
  <div id="po" style="display:none">Don't have a code ? <a href="/register/request_productowner">Click here!</a></div>
</div>
<div id="dialog-message" class="dialog" style="padding-top: 137px">
  <p style="line-height:22px;"> "Well my 5 year old grandson could work this out, <br />but we'll take anyone who's breathing so </p>
  <p style="font-size:24pt; margin-top:10px;"> You're in!" </p>
  <div class="medal-message"> <img src="/public/images/codeArmy/badges/html5.png" alt="html5 badge" align="left" />
    <div style="padding:35px">
      <p style="font-size:18pt">You've been promoted to</p>
      <p style="font-size:24pt; margin-top:10px;"><img src="/public/images/codeArmy/badges/private1star.png" alt="private 1 star" /></p>
    </div>
    <div style="margin-top:58px"><a class="CAbutton" href="javascript: void(0);" onclick="proceed()" id="medal-message-continue">Continue</a></div>
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
		window.location = '/profile'	
	}
	
	$('#submit').click(function(){
			data = $('#voucher').val();
			if($.trim(data)!="")
			$.post(
			'/register/Ajax_voucher',
			{ 'code': data, 'csrf_workpad': getCookie('csrf_workpad') },
			function(msg){
				console.log(msg);
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