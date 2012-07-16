<?php $this->load->view('includes/CAHeader.php'); ?>

<div id="Register_developer_MainContent" class="MainContent">
  <div id="dialog-holder">
    <div id="dialog-title"></div>
    <div id="timer"><span id="counter">60</span> <span style="font-size:18pt">sec</span></div>
    <div id="dialog">
      <div class="title">Oh really?</div>
      <div class="text">
        <p>"So you're a keyboard geek, well we need lots of you in the<br />
          field killing bugs and writing good code. </p>
        <p>This test is easier than spotting a commie at Macy's.<br />
          So get it done and get promoted!</p>
        <p>you got 60 seconds!</p>
      </div>
      <div id="terminal">
        <p>CodeAr.my Test Terminal</p>
        <input name="test" id="test" value="var last name = &quot;smitth&quot;" />
      </div>
      <div id="submit-holder"> <a href="javascript: void(0)" id="submit-button">Submit</a> </div>
    </div>
  </div>
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
	var finished=1;
	var timer1;
	var pause = false;
	$(window).focus(function(){pause=false;});
	$(window).blur(function(){pause=true;});
	$('#test').focus(function(){enableCounter();});
	$('#submit-button').mouseover(function(){ if(timer1)clearInterval(timer1); $('#submit-button').stop(true,true);});
	
	//preload images function
	function preload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        (new Image()).src = this;
		});
	}
	
	//the effect to be executed once page load.
    function loadEffect(){
        $('#Register_developer_MainContent').fadeIn('slow',function(){
                                                            $('#dialog').slideDown();
                                                          });
    }
	
	//list of images to be preloaded
    preload([
		'/public/images/codeArmy/designer_test/submit_hover.png',
	]);
	
	//things happen when continue button on modal dialog is pressed
	function proceed(){
		$.ajax({
			type: 'POST',
			url: '/register/Ajax_reg_div_developer',
			data: {'ci_csrf_token': getCookie('ci_csrf_token') },
			success: function(msg){
				if(msg=="success"){
					$.fancybox.close();
				}else{
					alert("Error: registering designer division.");
					console.log(msg);
				}
			}
		});
	}
	
	function nextStep(){
		window.location = '/my-profile';
	}
	
	//counter 
	var counter = 'disable', counterID;
	function enableCounter(){
		if(counter=='disable'){
			$('#sketch').fadeOut(120000);
			counter = 60;
			counterID = setInterval(counterFN, 1000);
			$('#submit-button').hide().css({opacity:1}).fadeIn('fast');
			$('#submit-button').click(function(){check(this)});
		}
	}

	function counterFN(){
		if(counter>0){
			counter = counter-1;
			$('#counter').html(counter);
		}else{
			counter='timeout';
			$('#test').attr('disabled','disabled');
			clearInterval(counterID);
			check(null);
		}
	}
	
	//check submission
	function check(el){
		if(finished==1){
			$('#sketch2').show();
			$('#timer').html('Checking');
		}
		if(el){
			finished = 'submit';
			counter='timeout';
			$('#timer').html('Done');
			//TODO: submit
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
			finished = 'jump';
			$('#timer').html('Done');
			timer1 = setInterval("jumping()", 3000);
			jumping();
		}
	}
	
	function jumping(){
		if(!pause)$('#submit-button').stop(true,false).effect("bounce", {times:2, distance: 10}, 200);
	}
	
</script>
<?php $this->load->view('includes/CAFooter.php'); ?>
