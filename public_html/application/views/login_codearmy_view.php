<?php $this->load->view('includes/CAHeader.php'); ?>
<div id="login-content" class="content">
    <div id="login-box" style="display:block; margin:0 auto; position:relative; top:333px;">
        <?php echo form_open('login/validate_credentials' , array('id'=>'login-form')); ?>
        <span id="error" class="error" style="position:absolute;left:167px; top:67px;"></span>
        <span style="position:absolute; right:414px; top:94px;">Email or username</span>
        <input type="text" name="username" id="user" style="position:absolute;top:89px;left:167px;" />
        <span style="position:absolute; right:414px; top:129px;">Password</span>
        <input type="password" name="password" id="pass" style="position:absolute;top:124px; left:167px;" />
        <a href="/login/recovery" style="color:#65caff; position:absolute; right:262px;top:217px;">Forgot your password?</a>
        <input style="position:absolute; right:180px; top:160px;" type="checkbox" name="remember" id="remember" value="remember" /><label style="position:absolute; right:90px; top:162px;" for="remember">Remember me</label>
        <a href="javascript: void(0)" id="login-submit" class="CAbutton" style="position:absolute; right:85px; top:202px;">Login</a>
        <img src="/public/images/codeArmy/loader4.gif" style="position:absolute; top:42px; right:463px;display:none" id="login-ajax" />
        <?php echo form_close(); ?>
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
</script>
<?php $this->load->view('includes/CAFooter.php'); ?>