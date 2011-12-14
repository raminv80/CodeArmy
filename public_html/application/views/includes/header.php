<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Motionworks</title>
	<link media="all" type="text/css" rel="stylesheet" href="/public/css/style.css" />
	<link media="all" type="text/css" rel="stylesheet" href="/public/css/autocomplete.css" />
	<link rel="stylesheet" type="text/css" href="/public/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<link type="text/css" href="/public/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="css/ie.css" /><![endif]-->
    
	<script type="text/javascript" src="/public/js/jquery-1.7.min.js"></script>
	<script type="text/javascript" src="/public/js/jquery.main.js"></script>
	<script type="text/javascript" src="/public/js/script.js"></script>
    <script type="text/javascript" src="/public/js/jquery.carouFredSel-4.4.1-packed.js" language="javascript"></script>
	<script type="text/javascript" src="/public/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="/public/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="/public/js/fancybox/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="/public/js/jquery-ui-1.8.16.custom.min.js"></script>

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