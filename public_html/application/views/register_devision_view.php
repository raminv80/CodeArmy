<?php $this->load->view('includes/CAHeader.php'); ?>

<div id="Register_division_MainContent" class="MainContent">
  <div id="dialog">
  	<p style="font-size:18px;">Well well well,</p>
    <p>what have we got ourselves here.</p>
    <p>You think you are good enough for the Ar.my?</p>
    <p style="font-family: 'Black Ops One', cursive;font-size: 24pt;color: #86E144; margin-top:30px;">What is your division recruite?</p> 
    <div class="buttons">
      <div id="designer_button" class="division_button"></div>
      <div id="developer_button" class="division_button"></div>
      <div id="copywriter_button" class="division_button"></div>
    </div>
  </div>
  <div id="po" style="display:none">or maybe you want to <a href="/register/productowner">create a mission ?</a></div>
</div>
<script type="text/javascript">
	$('#designer_button').click(function(){LoadTest('designer')});
	$('#developer_button').click(function(){LoadTest('developer')});
	$('#copywriter_button').click(function(){LoadTest('copywriter')});
	function preload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        (new Image()).src = this;
		});
	}
    function loadEffect(){
        $('#Register_division_MainContent').fadeIn('slow',function(){
                                                            $('#dialog').slideDown(function(){
																	$('#po').show('fast');
																});
                                                          });
    }
    preload([
        '/public/images/codeArmy/registration_division/designer_button_hover.png',
		'/public/images/codeArmy/registration_division/developer_button_hover.png',
		'/public/images/codeArmy/registration_division/copywriter_button_hover.png',
		'/public/images/codeArmy/button_hover.png',
		'/public/images/codeArmy/button.png',
    ]);
	function LoadTest(test){
		switch(test){
			case 'designer': window.location='/register/designer';break;
			case 'developer': window.location='/register/developer';break;
			case 'copywriter': window.location='/register/copywriter';break;
		}
	}
    </script>
<?php $this->load->view('includes/CAFooter.php'); ?>
