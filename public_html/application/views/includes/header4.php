<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>
    <?=(isset($window_title))? $window_title: 'Workpad'?>
    </title>
    <link href="/public/css/v4/style.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/css/v4/workpad.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/css/v4/sidemenu.css" media="all" rel="stylesheet" type="text/css">
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
    <script type="text/javascript" src="/public/js/v4/sidemenu.js"></script>
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
              <li <?php if($page_is=='Browse'){?>class="active"<?php } if($page_is=='Home'){?>class="hint_dev_step1"<?php }?>><a href="/stories/browse">browse</a></li>
              <li <?php if($page_is=='Browse'){?>class="active"<?php } if($page_is=='Home'){?>class="hint_dev_step4"<?php }?>><a href="/myoffice">Myoffice</a></li>
              <li <?php if($page_is=='About'){?>class="active"<?php }?>><a href="/about">about</a></li>
              <!--<li <?php if($page_is=='Leaderboard'){?>class="active"<?php }?>><a href="#leaderboard">Leaderboard</a></li>-->
              <li class="last <?php if($page_is=='contact'){?>active<?php }?>"><a href="/contact">Contact US</a></li>
            </ul>
      </div>
          <?php 
		  	if(isset($username)){
				$avatar = ($myProfile['avatar'])? '/public/'.$myProfile['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $me['email'] ) ) );
			  ?>
          <div class="WP-profile-header">
        <ul>
              <li><a href="/login/logout">Logout</a></li>
            </ul>
        <ul>
              <li><a href="/myoffice">My Office</a></li>
            </ul>
        <ul>
              <li>Edit <a href="/profile/edit">Profile</a> | <a href="/profile/edit_password">Password</a></li>
            </ul>
        <ul style="border-bottom:0">
              <li class="last"><a href="/myoffice/index/tab_7"><img src="<?=$avatar?>" style="float:left" width="35px" height="35px"/>
                <p style="width: 155px;text-transform:uppercase;padding-left:5px;float:left;"><?php echo substr(($myProfile['full_name']? $myProfile['full_name']:$me['username']),0,20);?></p>
                </a><br />
            <p style="padding-left:5px;float:left;">Level
                  <?php $level = floor($me['exp'] / points_per_level)+1;echo ($level>99) ? 99 : $level;?>
                </p>
            <div id="levelmeter">
                  <div id="level" style="width:<?php echo round (($me['exp'] % points_per_level)/points_per_level*80);?>px;"></div>
                </div>
            <?=($level>99) ? 99: $level+1?>
          </li>
            </ul>
      </div>
          <?php }?>
        </div>
  </div>
    </header>
<a id="feedbackbtn" href="#feedbackbox"><img class="feedback-button" src="/public/images/feedback.png" style="position:fixed; right: -20px; margin-top: 90px;"></a> 
<script>
	$(document).ready(function(){
		   $("#regbtn").colorbox({inline:true, fixed:true, opacity:0.7});
		   $("#loginbtn").colorbox({inline:true, fixed:true, opacity:0.7});
		   $(".close").click(function(){
				$.colorbox.close()
			});
		   $("#logintoreg").colorbox({inline:true, fixed:true, opacity:0.7});
		   
		   $("#feedbackbtn").colorbox({inline:true, fixed:true, opacity:0.7});
 		});
	</script>
<link href="/public/css/v4/colorbox.css" media="all" rel="stylesheet" type="text/css">
<div style="display:none">
      <div id="feedbackbox"> <a class="close" href="#1"><img src="/public/images/close.png" /></a> <?php echo form_open('/home/feedback', array('class'=>'register-form')); ?>
    <div class="row">
          <div class="text">
        <input id="name" name="name" value="" type="text">
      </div>
        </div>
    <div class="row">
          <div class="text">
        <input id="email" name="email" value="" type="text">
      </div>
        </div>
    <div class="row">
          <div class="text">
        <textarea id="feedbacktext" name="desc"></textarea>
      </div>
        </div>
    <div class="row">
          <div class="text">
        <input type="hidden" name="action" value="feedback" />
        <input class="feedback-submit" name="submit" value="Submit" type="submit">
      </div>
        </div>
    <?php echo form_close(); ?> 
    <script type="text/javascript">
    	$(document).ready(function(){
		   $('.feedback-button').hover(function(){
		   		$(this).animate({marginRight: "10"},200);
		   },function(){
		   		$(this).animate({marginRight: "0px"},200);
		   });
		   
			//Date picker
			$(".datepicker").each(function() {
				val = $(this).val().substring(0,10);
				$(this).datepicker()
					   .datepicker("option", "dateFormat", "yy-mm-dd")
					   .datepicker("setDate" , val );
			});
 		});
    </script> 
  </div>
    </div>

<?php
$user_id = $this->session->userdata('user_id');
if($user_id){
	$header_projects = $this->projects_model->get_my_projects($user_id);
	?>
    <!-- start side menu -->
    <div id="side_menu" class="sidemenu_inactive">
          <div id="sidemenubutton" class="sideopen"></div>
          <div id="sidemenucontent" style="overflow-y:scroll">
        <div id="projectheader"></div>
        <?php foreach($header_projects as $project): ?>
        <div class="projectblock">
              <div class="projecttitle">
            <?=ucfirst($project['project_name'])?>
            <span><?=$this->projects_model->get_percentage($project['project_id'])?>%</span></div>
              <div class="projectmenu">
            <ul>
                  <li><a href="/project/<?=$project['project_id']?>">Project Detail</a></li>
                  <li><a href="/project/story_management/<?=$project['project_id']?>">Task List</a></li>
                  <li><a href="/project/burndown_chart/<?=$project['project_id']?>">Burndown Chart</a></li>
                  <li><a href="/project/sprint_planner/<?=$project['project_id']?>">Sprint Plan</a></li>
                  <li><a href="/project/scrum_board/<?=$project['project_id']?>">Scrum Board</a></li>
                </ul>
          </div>
            </div>
        <?php endforeach;?>
      </div>
     </div>
     <!-- end side menu -->
<?php } ?>