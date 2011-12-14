<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?=(isset($window_title))? $window_title: 'Workpad'?></title>
	<link href="/public/css/v4/style.css" media="all" rel="stylesheet" type="text/css">
	<link href="/public/css/v4/workpad.css" media="all" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="/public/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<link type="text/css" href="/public/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="css/ie.css" /><![endif]-->
    
    <!--
    <script src='http://jquery-star-rating-plugin.googlecode.com/svn/trunk/jquery.js' type="text/javascript"></script>
	<script type="text/javaScript" src="http://www.fyneworks.com/jquery/project/chili/jquery.chili-2.0.js"></script>
    <script src='http://jquery-star-rating-plugin.googlecode.com/svn/trunk/jquery.MetaData.js' type="text/javascript" language="javascript"></script>
    <script src='http://jquery-star-rating-plugin.googlecode.com/svn/trunk/jquery.rating.js' type="text/javascript" language="javascript"></script>
    <link href='/public/css/jquery.rating.css' type="text/css" rel="stylesheet"/>
    -->
    
    
	<script type="text/javascript" src="/public/js/jquery-1.7.min.js"></script>
	<script type="text/javascript" src="/public/js/jquery.main.js"></script>
	<script type="text/javascript" src="/public/js/script.js"></script>
    <script type="text/javascript" src="/public/js/jquery.carouFredSel-4.4.1-packed.js" language="javascript"></script>
	<script type="text/javascript" src="/public/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="/public/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="/public/js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="/public/js/v4/jquery.scrollTo-1.4.2-min.js"></script>
	<script type="text/javascript" src="/public/js/v4/jquery.localscroll-1.2.7-min.js"></script>
    <script type="text/javascript" src="/public/js/v4/jquery.colorbox.js"></script>
   	<script type="text/javascript" src="/public/js/v4/main.js"></script> 
    <script type="text/javascript">
    	$(document).ready(function(){
		   $('.WP-profile-header').hover(function(){
		   		$(this).animate({marginTop: "-16px"},500);
		   },function(){
		   		$(this).animate({marginTop: "-90px"},500);
		   });
 		});
    </script> 
</head>
<body>        
    <header>
      <div class="WP-header">
        <div class="WP-header-placeholder">
          <div id="MW_logo"><a href="/">MOTIONWORKS LOGO</a></div>
          <div id="WP-navigation">
            <ul>
              <li <?php if($page_is=='Home'){?>class="active"<?php }?>><a href="<?=($page_is=='Home')? '#pitch' : '/'?>">home</a></li>
              <li <?php if($page_is=='Browse'){?>class="active"<?php }?>><a href="/stories/browse">browse</a></li>
           	  <li <?php if($page_is=='Browse'){?>class="active"<?php }?>><a href="/myoffice">Myoffice</a></li>
              <li <?php if($page_is=='About'){?>class="active"<?php }?>><a href="/about">about</a></li>
              <!--<li <?php if($page_is=='Leaderboard'){?>class="active"<?php }?>><a href="#leaderboard">Leaderboard</a></li>-->
              <li class="last <?php if($page_is=='contact'){?>active<?php }?>"><a href="/contact">Contact US</a></li>
            </ul>
          </div>
          <?php if(isset($username)){?>
          <div class="WP-profile-header"><ul><li><a href="/login/logout">Logout</a></li></ul><ul><li><a href="/myoffice">My Office</a></li></ul><ul><li>Edit <a href="/profile/edit">Profile</a> | <a href="/profile/edit_password">Password</a></li></ul><ul style="border-bottom:0"><li class="last"><img src="/public/<?php echo $myProfile['avatar']? $myProfile['avatar']: "images/img7.png";?>" style="float:left" width="35px" height="35px"/><p style="text-transform:uppercase;padding-left:5px;float:left;"><?php echo $myProfile['full_name'];?></p><br /><p style="padding-left:5px;float:left;">Level <?php $level = floor($me['exp'] / points_per_level)+1;echo ($level>99) ? 99 : $level;?></p><div id="levelmeter"><div id="level" style="width:<?php echo round (($me['exp'] % points_per_level)/points_per_level*80);?>px;"></div></div><?=($level>99) ? 99: $level+1?></li></ul></div>
          <?php }?>
        </div>
      </div>
    </header>