<?php $this->load->view('includes/CAHeader.php'); ?>

<div id="profile-wrapper">
    <div class="profile-header"> <a href="/profile">
      <div id="logo"></div>
      </a>
      <ul id="header-links">
        <li><a href="#" id="Messages">
          <div id="messages-holder">
            <div class="notification" id="messages-notification">4</div>
            Messages </div>
          </a> </li>
        <li><a href="#" id="Notifications">
          <div id="notifications-holder">
            <div class="notification" id="notifications-notification">10</div>
            Notofocations</div>
          </a></li>
        <li><a href="#" id="FindMissions">
          <div id="findmission-holder"> Find Missions </div>
          </a></li>
        <li><a href="#" id="MyMissions">
          <div id="mymissions-holder">
            <div class="notification" id="mymissions-notification">2</div>
            My Missions</div>
          </a></li>
        <li> <a href="javascript:void(0)" id="Profile">
          <div id="avatar-holder"> <img src="/public/images/codeArmy/profile/avatar.png" border="0"> </div>
          </a> </li>
      </ul>
      <div id="dropdown">
        <ul>
          <li><a href="#">Account settings</a></li>
          <li><a href="#">FAQ's</a></li>
          <li><a href="#">About us</a></li>
        </ul>
        <a href="/login/logout" id="logout">Log out</a> </div>
      <div id="live-feed"> 25.05.2012&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Web design for KLIA website&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;30bids&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Due: 5 hours </div>
    </div>
    <div id="left-block">
		<div id="left-menu">
        	<ul>
            	<li<?php if($page_is=='Profile'){?> class="active"<?php }?>><a href="/profile">Compose</a></li>
                <li<?php if($page_is=='Missions'){?> class="active"<?php }?>><a href="/missions">Inbox</a></li>
                <li<?php if($page_is=='Achievements'){?> class="active"<?php }?>><a href="/achievements">Important</a></li>
                <li<?php if($page_is=='Leaderboard'){?> class="active"<?php }?>><a href="leaderboard">Sent</a></li>
                <li<?php if($page_is=='Invite'){?> class="active"<?php }?>><a href="/invite">Archive</a></li>
                <li<?php if($page_is=='Invite'){?> class="active"<?php }?>><a href="/invite">Trash</a></li>
            </ul>
        </div>
    </div>
    <div id="main-content">