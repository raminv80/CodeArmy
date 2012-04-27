<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CodeArmy</title>

<style type="text/css">
*{margin:0}
body {
 background-color: #fff;
 background:url(/public/images/codeArmy/background.jpg);
 margin: 40px;
 font-family: Helvetica, Arial, Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}
#welcome-title{
	background: url(/public/images/codeArmy/title_03.png);
	width:916px;
	height:155px;
	margin:0 auto;
}
#content{width: 100%;}
.welcome-subtitle{
	text-align: center;
	font-size: 57px;
	font-weight: bold;
	font-family: arial;
}
#subtitle{ color:white; text-shadow: white 0px 0px 2px;}
#subtitle1{ margin-top: 50px; color:#3d4a4e}
#subtitle2{font-size:25px; color:#3d4a4e}
#subtitle4{ font-size:18px; color:white; text-align:center; margin-top: 50px;}
#subtitle5{ font-size:18px; color:white; text-align:center; margin-top: 25px;}

.transparent_class {
  /* IE 8 */
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
  /* IE 5-7 */
  filter: alpha(opacity=70);
  /* Netscape */
  -moz-opacity: 0.7;
  /* Safari 1.x */
  -khtml-opacity: 0.7;
  /* Good browsers */
  opacity: 0.7;
}
.edit{
	margin:5px auto;
	width: 428px;
	height:51px;
	background:url(/public/images/codeArmy/edit_07.png);
}
.edit input{
	border:none;
	background:none;
	text-align:center;
	width: 428px;
	height:51px;
	font-size:25px;
	color:#464646;
	/*text-shadow: #333 0px 0px 2px;*/
}
.report{
	background:url(/public/images/codeArmy/report_11.png);
	width: 431px;
	height: 51px;
	margin: 5px auto;
}
.report:hover{
	background:url(/public/images/codeArmy/report_11_11.png);
}
.footer{
	color: white;
	font-size:20px;
	text-align:center;
	position:absolute;
	bottom: 10px;
	width: 100%;
	margin-left:-45px;
	text-shadow: white 0px 0px 4px;
}
#error{
	text-align:center;
	color:#930;
	color:
}
</style>
</head>
<body>
	<div id="content">
		<div id="welcome-title"></div>
        <?php if(isset($email) && $email!=''){?>
		<div class="welcome-subtitle transparent_class" id="subtitle">Reporting for Duty, Sir!</div>
        <div class="subtitle" id="subtitle4"><span class="transparent_class">&lt;p&gt;</span> Thank you, an email has been sent to your registered address. <span class="transparent_class">&lt;/p&gt;</span></div>
        <div class="subtitle" id="subtitle5"><span class="transparent_class">&lt;div&gt;</span> Commander-in-chief <span class="transparent_class">&lt;/div&gt;</span></div>
        <?php }else{?>
        <div class="welcome-subtitle transparent_class" id="subtitle">Work is Play</div>
        <div class="welcome-subtitle transparent_class" id="subtitle1">Enlist Now!</div>
        <div class="welcome-subtitle transparent_class" id="subtitle2">for updates on Code Ar.my</div>
        <div id="error"><?php echo validation_errors(); ?></div>
        <div class="edit">
			<?php echo form_open('welcome', array('id'=>'reg')); ?>
				<input id="edit" name="email" value="Enter email address">
            </form>
        <?php echo form_close();?>
        <div class="report"></div>
        <?php }?>
        <div class="push"></div>
    </div>
    <div class="footer transparent_class">Motionworks</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script>
		$('#edit').focus(function(){
				$(this).val('');
			});
		$('#edit').blur(function(){
			if($(this).val()==''){$(this).val('Enter email address');}
			});
		$('.report').click(function(){$('#reg').submit()});
		$(function(){
			setInterval(function(){
					b = Math.round(Math.random()*4);
					x = Math.round(Math.random()*2)-1;
					y = Math.round(Math.random()*2)-1;
					$('#error').css('text-shadow','#900 '+x+'px '+y+'px '+b+'px');
				}, 33);
			})
	</script>
</body>
</html>