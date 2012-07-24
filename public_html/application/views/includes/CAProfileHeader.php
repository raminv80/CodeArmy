<?php $this->load->view('includes/CAHeader.php'); ?>

<div id="inner">
<div id="container">

    <div class="profile-header"> <a href="/profile">
      <div id="logo"></div>
      </a>
      <ul id="header-links">
        <li><a href="/messages" id="Messages">
          <div id="messages-holder">
            <div class="notification" id="messages-notification">4</div>
            Messages </div>
          </a> </li>
        <li><a href="/messages/notifications" id="Notifications">
          <div id="notifications-holder">
            <div class="notification" id="notifications-notification">10</div>
            Notifications</div>
          </a></li>
        <li><a href="/missions" id="FindMissions">
          <div id="findmission-holder"> Find Missions </div>
          </a></li>
        <li><a href="/missions/my_missions" id="MyMissions">
          <div id="mymissions-holder">
            <div class="notification" id="mymissions-notification"><?=isset($myActiveMissions)?$myActiveMissions:'?'?></div>
            My Missions</div>
          </a></li>
        <li> <a href="/profile" id="Profile">
          <div id="avatar-holder"> <img src="/public/images/codeArmy/profile/avatar.png" border="0"> </div>
          </a> <div id="dropdown-button"></div></li>
      </ul>
      <div id="dropdown">
        <ul>
         <!-- <li><a href="#">Account settings</a></li> -->
          <li><a href="/faq">FAQ's</a></li>
          <li><a href="/about">About us</a></li>
        </ul>
        <a style="margin-top:0;" href="/login/logout" id="logout">Log out</a> </div>
      <div id="live-feed"> 25.05.2012&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Web design for KLIA website&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;30bids&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Due: 5 hours </div>
    </div>
    <?php if(in_array($page_is,array('Profile','Missions','Achievements','Leaderboard','Invite'))):?>
    <div id="left-block">
		<div id="left-menu">
        	<ul>
            	<li<?php if($page_is=='Profile'){?> class="active"<?php }?>><a href="/profile">Military ID</a></li>
                <li<?php if($page_is=='Missions'){?> class="active"<?php }?>><a id="missions-toggle" href="javascript:void(0)">Missions</a></li>
                <ul id="mission-submenue" <?php if($page_is!="Missions"){?>style="display:none"<?php }?>>
                    <li<?php if($action_is=='my_missions'){?> class="active"<?php }?>><a href="/missions/my_missions">My Missions</a></li>
                    <li<?php if($action_is=='bid'){?> class="active"<?php }?>><a href="/missions/bid">Bid</a></li>
                    <li<?php if($action_is=='completed'){?> class="active"<?php }?>><a href="/missions/completed">Completed</a></li>
                </ul>
                <li<?php if($page_is=='Achievements'){?> class="active"<?php }?>><a href="/achievements">Achievements</a></li>
                <li<?php if($page_is=='Leaderboard'){?> class="active"<?php }?>><a href="leaderboard">Leaderboard</a></li>
                <li<?php if($page_is=='Invite'){?> class="active"<?php }?>><a href="/invite">Invite friends</a></li>
            </ul>
        </div>
    </div>
    <?php endif;?>
    <?php if(in_array($page_is,array('Messages'))):?>
    <div id="left-block">
		<div id="left-menu">
        	<ul>
            	<li<?php if($action_is=='compose'){?> class="active"<?php }?>><a href="/messages/compose">Compose</a></li>
                <li<?php if(in_array($action_is,array('inbox','read'))){?> class="active"<?php }?>><a href="/messages/inbox">Inbox</a></li>
                <li<?php if($action_is=='important'){?> class="active"<?php }?>><a href="/messages/important">Important</a></li>
                <li<?php if($action_is=='sent'){?> class="active"<?php }?>><a href="/messages/sent">Sent</a></li>
                <li<?php if($action_is=='archive'){?> class="active"<?php }?>><a href="/messages/archive">Archive</a></li>
                <li<?php if($action_is=='trash'){?> class="active"<?php }?>><a href="/messages/trash">Trash</a></li>
            </ul>
            <img style="margin-top:30px" src="/public/images/codeArmy/messages/temp_srch.png"/>
        </div>
    </div>
    <?php endif;?>
    <?php if(in_array($page_is,array('About','FAQ','Contact', 'Term'))):?>
    <div id="left-block">
		<div id="left-menu">
        	<ul>
            	<li<?php if($page_is=='About'){?> class="active"<?php }?>><a href="/about">About us</a></li>
                <li<?php if($page_is=='Contact'){?> class="active"<?php }?>><a href="/contact">Contact us</a></li>
                <li<?php if($page_is=='FAQ'){?> class="active"<?php }?>><a href="/faq">FAQ's</a></li>
                <li<?php if($action_is=='Term'){?> class="active"<?php }?>><a href="/term">T&amp;C</a></li>
            </ul>
        </div>
    </div>
    <?php endif;?>
    <div id="main-content">