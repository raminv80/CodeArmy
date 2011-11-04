<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Motionworks</title>
	<link media="all" type="text/css" rel="stylesheet" href="/public/css/style.css" />
	<link media="all" type="text/css" rel="stylesheet" href="/public/css/autocomplete.css" />
	<link rel="stylesheet" type="text/css" href="/public/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	
	<script type="text/javascript" src="/public/js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="/public/js/jquery.main.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>public/js/script.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url() ?>public/js/jquery.carouFredSel-4.4.1-packed.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>public/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>public/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>public/js/jquery.easing.1.3.js"></script>
    <link href="/uploadify/uploadify.css" type="text/css" rel="stylesheet" />

    <script type="text/javascript" src="<?php echo base_url() ?>uploadify/swfobject.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>uploadify/jquery.uploadify.v2.1.4.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#file_upload').uploadify({
        'uploader'  : '/uploadify/uploadify.swf',
        'script'    : '/uploadify/uploadify.php',
        'cancelImg' : '/uploadify/cancel.png',
        'folder'    : '/uploads',
		'fileExt'     : '*.jpg;*.gif;*.png;*.zip',
		'onAllComplete' : function(event,data) {
		  alert('Your files are successfully uploaded');
		  $('#submit_form').submit();
		},
		'onError': function (a, b, c, d) {
			 if (d.status == 404)
				alert('Could not find upload script. Use a path relative to: '+'<?= getcwd() ?>');
			 else if (d.type === "HTTP")
				alert('error '+d.type+": "+d.status);
			 else if (d.type ==="File Size")
				alert(c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
			 else
				alert('error '+d.type+": "+d.text);
		},
		'onComplete'  : function(event, ID, fileObj, response, data) {
		  //alert('There are ' + data.fileCount + ' files remaining in the queue.');
		}
      });
    });
    </script>
    <!--<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>public/js/bxSlider/jquery.bxSlider.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>public/js/bxSlider/jquery.bxSlider.min.js" type="text/javascript"></script>-->
	
	<!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="css/ie.css" /><![endif]-->
</head>
<body>
	<div id="container" class="clearfix">
		<div id="header">
			<div class="header-holder">
				<h1 class="logo"><a href="/">Motionworks</a></h1>
				<div id="nav">
					<ul>
						<li <?php if($page_is=='Home'){?>class="active"<?php }?>><a href="/home"><span class="left">home</span></a></li>
						<li <?php if($page_is=='Browse'){?>class="active"<?php }?>><a href="/stories/browse"><span class="left">browse jobs</span></a></li>
						<li <?php if($page_is=='Myoffice'){?>class="active"<?php }?>><a href="/myoffice"><span class="left">my office</span></a></li>
						<li <?php if($page_is=='Leaderboard'){?>class="active"<?php }?>><a href="/leaderboard"><span class="left">leaderboard</span></a></li>
						<li <?php if($page_is=='About'){?>class="active"<?php }?>><a href="/about"><span class="left">about us</span></a></li>
					</ul>
				</div>
			</div><!-- End of the header-holder -->
			</div><!-- End of the header -->