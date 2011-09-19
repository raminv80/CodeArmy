<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Motionworks</title>
	<link media="all" type="text/css" rel="stylesheet" href="/public/css/all.css" />
	<link media="all" type="text/css" rel="stylesheet" href="/public/css/autocomplete.css" />
	<script type="text/javascript" src="/public/js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="/public/js/jquery.main.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>public/scripts/script.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url() ?>public/js/jquery.carouFredSel-4.4.1-packed.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>public/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>public/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="css/ie.css" /><![endif]-->
</head>
<body>
	<div id="wrapper" class="home">
		<div id="header">
			<h1 class="logo"><a href="#">Motionworks</a></h1>
			<div id="nav">
				<ul>
					<li <?php if($page_is=='Home'){?>class="active"<?php }?>><a href="/home"><span class="left">Home</span></a></li>
					<li><a href="#"><span class="left">Browse Job</span></a></li>
					<li <?php if($page_is=='Myoffice'){?>class="active"<?php }?>><a href="/myoffice"><span class="left">MyOffice</span></a></li>
                    <li <?php if($page_is=='About'){?>class="active"<?php }?>><a href="/about"><span class="left">About</span></a></li>
					<li><a href="#"><span class="left">Leaderboard</span></a></li>
				</ul>
			</div>
		</div>