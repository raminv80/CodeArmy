<?php $this->load->view('includes/CAHeader.php'); ?>

<div id="Recovery_MainContent" class="MainContent">
  <div id="dialog-holder">
  	<div class="content">
    	<?php echo form_open('/login/recovery', array('id'=>'recovery_form')); ?>
        <?php if(isset($login_error)&& $login_error!=""){ ?>
              <div style="position:absolute; top:70px; left:33px; width:492px; line-height:20px;"> <span style="color:#F60"><?php echo $login_error;?></span> </div>
        <span style="position:absolute; top:163px; left:100px;">Email</span>
        <input type="text" name="email" id="email" value="<?php echo $this->input->post('email'); ?>" autofocus />
        <div style="position:absolute;top:207px;left:334px;"><a class="CAbutton" href="javascript: void(0);" onclick="proceed()" id="submit-button">Try Again</a></div>
        <?php }else{ ?>
        <p style=" position:absolute; top:70px; left:33px; width:492px; line-height:20px;">Well, aren't we a little forgetful now, lucky you that the commander isn't in. Give me your email address and i send you the new password.</p>
        <p style="position:absolute; top:120px; left:33px; width:492px; line-height:20px;">Quick before we get into trouble! </p>
        <span style="position:absolute; top:163px; left:100px;">Email</span>
        <input type="text" name="email" id="email" value="<?php echo $this->input->post('email'); ?>" autofocus />
        <div style="position:absolute;top:207px;left:334px;"><a class="CAbutton" href="javascript: void(0);" onclick="proceed()" id="submit-button">Confirm</a></div>
        <?php }?>
        <?php echo form_close(); ?>
    </div>
  </div>
</div>
<div id="dialog-message" class="dialog" style="padding-top: 137px">

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
		$('#recovery_form').submit();
	}
	
</script>
<?php $this->load->view('includes/CAFooter.php'); ?>
