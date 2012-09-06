<?php $this->load->view('includes/CAHeader.php'); ?>
<style>
.blur{-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";filter: alpha(opacity=50);-moz-opacity: 0.5;-khtml-opacity: 0.5;opacity: 0.5;}
.hidden{display:none}
<?php if($me['role']=='po' || $me['role']=='admin'){?>
#main-content{margin-top:15px;}
#left-block{top:45px;}
.profile-header{display:none}
#container{background:none; margin:30px auto;border:1px solid #333;}
<?php }?>
</style>
<div id="inner">
<?php if($me['role']=='po' || $me['role']=='admin'){?>
<a href="/missions/tallent_map"><div title="Close" class="fancybox-item fancybox-close" style="position: fixed;right: 150px;top: 7px;"></div></a>
<?php }?>
<div id="container">

    <div class="profile-header"> <a href="/profile">
      <div id="logo"></div>
      </a>
      <ul id="header-links">
        <li><a href="/messages" id="Messages">
          <div id="messages-holder">
            <div class="notification <?=isset($myActiveMessages)&&$myActiveMessages>0?'':'hidden' ?>" id="messages-notification"><?=isset($myActiveMessages)?$myActiveMessages:'?' ?></div>
            Messages </div>
          </a> </li>
        <li><a href="/messages/notifications" id="Notifications">
          <div id="notifications-holder">
            <div class="notification <?=isset($myActiveNotifications)&&$myActiveNotifications>0?'':'hidden' ?>"" id="notifications-notification"><?=$myActiveNotifications?></div>
            Notifications</div>
          </a></li>
        <li>
          <?php if(($this->session->userdata('role')=='po'||$this->session->userdata('role')=='admin')){?>
          <a href="/missions/create" class="fancybox" id="FindMissions"><div id="findmission-holder">Create Mission</div></a>
          <?php }else{?>
          <a href="/missions" id="FindMissions"><div id="findmission-holder">Find Missions</div></a>
          <?php }?>
          </li>
        <li><a href="/missions/my_missions" id="MyMissions">
          <div id="mymissions-holder">
            <div class="notification <?=isset($myActiveMissions)&&$myActiveMissions>0?'':'hidden'?>" id="mymissions-notification"><?=isset($myActiveMissions)?$myActiveMissions:'?'?></div>
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
      <div id="live-feed">Welcome back <?=$me['username']?></div>
    </div>
    <?php if(in_array($page_is,array('Profile','Missions','Achievements','Leaderboard','Invite'))):?>
    <div id="left-block">
		<div id="left-menu">
        	<ul>
            	<li<?php if($page_is=='Profile'){?> class="active"<?php }?>><a href="/profile"><?=($me['role']=='user')?'My Profile':'Headquarter'?></a></li>
                <li<?php if($page_is=='Missions'){?> class="active"<?php }?>><a id="missions-toggle" href="javascript:void(0)">Missions</a></li>
                <ul id="mission-submenue" <?php if($page_is!="Missions"){?>style="display:none"<?php }?>>
                    <li<?php if($action_is=='my_missions'){?> class="active"<?php }?>><a href="/missions/my_missions">My Missions</a></li>
                    <?php if($this->session->userdata('role')=='po' || $this->session->userdata('role')=='admin'){?>
                    <li<?php if($action_is=='hq'){?> class="active"<?php }?>><a href="/missions/tallent_map">World Map</a></li>
                    <?php }else{?>
                    <li><a href="/missions">Find Mission</a></li>
                    <?php }?>
                    <li<?php if($action_is=='bid'){?> class="active"<?php }?>><a href="/missions/bid">Bid</a></li>
                    <li<?php if($action_is=='completed'){?> class="active"<?php }?>><a href="/missions/completed">Completed</a></li>
                </ul>
                <li<?php if($page_is=='Achievements'){?> class="active"<?php }?>><a href="/achievements">Achievements</a></li>
                <li<?php if($page_is=='Leaderboard'){?> class="active"<?php }?>><a href="/leaderboard">Leaderboard</a></li>
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
            <img onclick="document.search_form.submit();" style="margin:30px; cursor:pointer; display:block" src="/public/images/codeArmy/messages/temp_srch.png"/>
            <?php echo form_open('messages/search', array('name'=>'search_form')); ?>
            <?php if (isset($form_error)){ ?>
            <div id="msg-search-err"><?=form_error("msg-search")?></div>
            <input type="text" name="msg-search" id="msg-search" value="<?=set_value('msg-search')?>" />
            <?php } else { ?>
            <input onfocus="this.value=''" onblur="if(this.value=='')this.value='Search message'" type="text" name="msg-search" id="msg-search" value="Search message"/>
            <?php } ?>
            </form>
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