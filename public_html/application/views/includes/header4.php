<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!--stops search engine from crawling to site while in beta -->
    <meta name="robots" content="noindex" />
    <title>
    <?=(isset($window_title))? $window_title: 'Workpad'?>
    </title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link href="/public/css/v4/style.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/css/v4/workpad.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/css/v4/sidemenu.css" media="all" rel="stylesheet" type="text/css">
    <link href="/public/css/v4/jquery.countdown.css" media="all" rel="stylesheet" type="text/css">
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
    <script type="text/javascript" src="/public/js/v4/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="/public/js/v4/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="/public/js/v4/jquery.mCustomScrollbar.js"></script>
    <script type="text/javascript" src="/public/js/v4/sidemenu.js"></script>
    <script type="text/javascript" src="/public/js/v4/main.js"></script>
    <script type="text/javascript" src="/public/js/v4/jquery.countdown.min.js"></script>
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
                  <?php $level = $this->gamemech->get_level($me['exp']); echo $level;?>
                </p>
            <div id="levelmeter">
                  <div id="level" style="width:<?php echo round ($this->gamemech->get_progress_bar($me['exp'])*80);?>px;"></div>
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
$query = $this->stories->get_my_works($user_id,'In progress');
$header_tasks = $query->result_array();
?>
<!-- start side menu -->
<div id="side_menu" class="sidemenu_inactive">
      <div id="sidemenubutton" class="sideopen"></div>
      <div id="scroll_container">
    <div class="customScrollBox">
          <div class="container">
        <div class="content"> 
              <!-- Slider Content Start -->
              <div id="taskheader"></div>
              <?php foreach($header_tasks as $task): ?>
              <script type="text/javascript">
							$(function(){
								var e = "<?=$task['deadline']?>";
								var liftoffTime=new Date(e.substr(0,4),e.substr(5,2)-1,e.substr(8,2));
								$('#count_<?=$task['work_id']?>').countdown({until: liftoffTime, format: 'dHMS', compact: true, layout: '{dn} {dl} {hnn}{sep}{mnn}{sep}{snn}'});
								});
					        </script>
              <div class="projectblock">
            <div id="task_<?=$task['work_id']?>" class="projecttitle">
                  <?=ucfirst(substr($task['title'],0,19))?>
                  <span id="count_<?=$task['work_id']?>"></span></div>
            <div class="projectmenu">
                  <ul>
                <li><a href="/story/<?=$task['work_id']?>">Story Details</a></li>
                <li><a href="/project/<?=$task['project_id']?>">Project Details</a></li>
                <li><a href="/project/scrum_board/<?=$task['project_id']?>">Scrum Board</a></li>
                <?php echo form_open('story/submission');?>
                <input type="hidden" name="id" value="<?php echo $task['work_id']; ?>" />
                <input type="hidden" name="csrf" value="<?php echo md5('storyDone'); ?>" />
                <!--<input type="submit" name="submit" value="Job Done!" />-->
                <li> <a href="javascript: void(0)" onclick="$(this).parent().parent().submit();">Job Done!</a> </li>
                <?php echo form_close(); ?>
              </ul>
                </div>
          </div>
              <?php endforeach;?>
              <div id="projectheader"></div>
              <?php foreach($header_projects as $project): ?>
              <div class="projectblock">
            <div id="project_<?=$project['project_id']?>" class="projecttitle">
                  <?=ucfirst($project['project_name'])?>
                  <span>
              <?=$this->projects_model->get_percentage($project['project_id'])?>
              %</span></div>
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
              <!-- Slider Content End --> 
            </div>
      </div>
          <div class="dragger_container">
        <div class="dragger">&#9618;</div>
      </div>
        </div>
  </div>
    </div>

<!-- end side menu --> 

<!-- start bids menu -->
<div id="bid_side_menu" class="sidemenu_inactive">
	<?php $bid_inbox=$this->inbox_model->get_bids($this->session->userdata('user_id')); ?>
      <div id="bid_side_menu_button" class="sideopen"><?=$bid_inbox[0]!=0?$bid_inbox[0]:''?></div>
      <div id="scroll_container3">
    <div class="customScrollBox">
          <div class="container">
        <div class="content"> 
              <!-- Slider Content Start --> 
              <span class="title">Bidding Messages</span>
              <div class="list">
              <?php foreach($bid_inbox[1] as $message):?>
              <?php $avatar = ($message['avatar'])? '/public/'.$message['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $message['email'] ) ) );?>
              <div id="msg_<?=$message['id']?>" class="message_buble <?=$message['status']?>"> <a href="/user/<?=$message['target_id']?>"><img width="39px" height="40px" align="left" src="<?=$avatar?>" /></a>
            <p class="summary">
                  <?=(strlen(strip_tags($message['message']))>50) ? substr(strip_tags($message['message']),0,50).'...' : strip_tags($message['message']);?>
                  <?php
				  $d1=time();
				  $d2=strtotime($message['created_at']);
				  $diff = abs($d2-$d1);
				  if($diff>0 && $diff<(60*60*24)){
					//hour
					$hour = floor($diff/(60*60));
					$min = floor(($diff - $hour * (60*60))/60);
					$str="";
					if($hour>0)$str = $hour.' hours and ';
					$str.=$min.' mins ago';
				  }elseif(($diff>=(60*60*24)) && ($diff<(60*60*24*30))){
					//days
					$day = floor($diff/(60*60*24));
					if($day=1){
						$str = $day.' day ago';
					}else{
						$str = $day.' days ago';
					}
				  }else{
					//date
					$str = date('d F Y',strtotime($message['created_at']));
				  }
				  ?>
                  <span style="float:right; color:#999;"><?=$str?></span>
                </p>
            <div class="desc">
                  <?=$message['message']?>
                  <span style="float:right; color:#999;"><?=$str?></span>
                </div>
          </div>
              <?php endforeach;?>
              </div>
<!-- bid Content End --> 
            </div>
      </div>
          <div class="dragger_container">
        <div class="dragger">&#9618;</div>
      </div>
        </div>
  </div>
    </div>

<!-- end side menu for bid--> 

<!-- start message menu -->
<div id="message_side_menu" class="sidemenu_inactive">
	<?php $message_inbox=$this->inbox_model->get_messages($this->session->userdata('user_id')); ?>
      <div id="message_side_menu_button" class="sideopen"><?=$message_inbox[0]!=0? $message_inbox[0]:''?></div>
      <div id="scroll_container1">
    <div class="customScrollBox">
          <div class="container">
        <div class="content"> 
              <!-- Slider Content Start --> 
              <span class="title">Messages</span>
              <div class="list">
              <?php foreach($message_inbox[1] as $message):?>
              <?php $avatar = ($message['avatar'])? '/public/'.$message['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $message['email'] ) ) );?>
              <div id="msg_<?=$message['id']?>" class="message_buble <?=$message['status']?>"> <a href="/user/<?=$message['target_id']?>"><img width="39px" height="40px" align="left" src="<?=$avatar?>" /></a>
            <p class="summary">
                  <?=(strlen(strip_tags($message['message']))>50) ? substr(strip_tags($message['message']),0,50).'...' : strip_tags($message['message']);?>
                  <?php
				  $d1=time();
				  $d2=strtotime($message['created_at']);
				  $diff = abs($d2-$d1);
				  if($diff>0 && $diff<(60*60*24)){
					//hour
					$hour = floor($diff/(60*60));
					$min = floor(($diff - $hour * (60*60))/60);
					$str="";
					if($hour>0)$str = $hour.' hours and ';
					$str.=$min.' mins ago';
				  }elseif(($diff>=(60*60*24)) && ($diff<(60*60*24*30))){
					//days
					$day = floor($diff/(60*60*24));
					if($day=1){
						$str = $day.' day ago';
					}else{
						$str = $day.' days ago';
					}
				  }else{
					//date
					$str = date('d F Y',strtotime($message['created_at']));
				  }
				  ?>
                  <span style="float:right; color:#999;"><?=$str?></span>
                </p>
            <div class="desc">
                  <?=$message['message']?>
                  <span style="float:right; color:#999;"><?=$str?></span>
                </div>
          </div>
              <?php endforeach;?>
              </div>
			<!-- message Content End --> 
</div>
      </div>
          <div class="dragger_container">
        <div class="dragger">&#9618;</div>
      </div>
        </div>
  </div>
    </div>

<!-- end side menu for message --> 

<!-- start jobs menu -->
<div id="job_side_menu" class="sidemenu_inactive">
	<?php $job_inbox=$this->inbox_model->get_jobs($this->session->userdata('user_id')); ?>
      <div id="job_side_menu_button" class="sideopen"><?=$job_inbox[0]!=0? $job_inbox[0]:''?></div>
      <div id="scroll_container2">
    <div class="customScrollBox">
          <div class="container">
        <div class="content"> 
              <!-- Slider Content Start --> 
              <span class="title">Job Messages</span>
              <div class="list">
              <?php foreach($job_inbox[1] as $message):?>
              <?php $avatar = ($message['avatar'])? '/public/'.$message['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $message['email'] ) ) );?>
              <div id="msg_<?=$message['id']?>" class="message_buble <?=$message['status']?>"> <a href="/user/<?=$message['target_id']?>"><img width="39px" height="40px" align="left" src="<?=$avatar?>" /></a>
            <p class="summary">
                  <?=(strlen(strip_tags($message['message']))>50) ? substr(strip_tags($message['message']),0,50).'...' : strip_tags($message['message']);?>
                  <?php
				  $d1=time();
				  $d2=strtotime($message['created_at']);
				  $diff = abs($d2-$d1);
				  if($diff>0 && $diff<(60*60*24)){
					//hour
					$hour = floor($diff/(60*60));
					$min = floor(($diff - $hour * (60*60))/60);
					if($hour>0)$str = $hour.' hours and ';
					$str="";
					$str.=$min.' mins ago';
				  }elseif(($diff>=(60*60*24)) && ($diff<(60*60*24*30))){
					//days
					$day = floor($diff/(60*60*24));
					if($day=1){
						$str = $day.' day ago';
					}else{
						$str = $day.' days ago';
					}
				  }else{
					//date
					$str = date('d F Y',strtotime($message['created_at']));
				  }
				  ?>
                  <span style="float:right; color:#999;"><?=$str?></span>
                </p>
            <div class="desc">
                  <?=$message['message']?>
                  <span style="float:right; color:#999;"><?=$str?></span>
                </div>
          </div>
              <?php endforeach;?>
              </div>
			<!-- message Content End --> 
</div>
      </div>
          <div class="dragger_container">
        <div class="dragger">&#9618;</div>
      </div>
        </div>
  </div>
    </div>

<!-- end side menu for jobs --> 
<?php } ?>