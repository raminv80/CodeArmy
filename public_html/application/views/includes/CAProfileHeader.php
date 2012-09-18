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

.topnav {margin-top:20px;text-align:center;}
.topnav li {width:19.5%; float:left; }
.topnav li:last-child {position:relative;}
.topnav li a {
	color:#ff8000; font-size:1em; height: 40px; padding:10px 0;margin-left:3px; 
	text-shadow:0 1px 1px black; box-shadow:inset 0 1px 1px #666;
	border-radius:5px; border:1px solid #111;
	background: rgb(69,72,77); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(69,72,77,1) 0%, rgba(0,0,0,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(69,72,77,1)), color-stop(100%,rgba(0,0,0,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#45484d', endColorstr='#000000',GradientType=0 ); /* IE6-9 */}
.topnav li a:hover, .topnav li a.active {
	background: rgb(255,128,0); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(255,128,0,1) 0%, rgba(147,88,0,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,128,0,1)), color-stop(100%,rgba(147,88,0,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(255,128,0,1) 0%,rgba(147,88,0,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(255,128,0,1) 0%,rgba(147,88,0,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(255,128,0,1) 0%,rgba(147,88,0,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(255,128,0,1) 0%,rgba(147,88,0,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff8000', endColorstr='#935800',GradientType=0 ); /* IE6-9 */
	color:black; text-shadow: 0 -1px 1px #ff8000
	}	
.topnav li a i {font-size:1.6em}
.topnav li:first-child {margin-left:0}
.topnav li a.mid {height:50px; padding-top:20px; margin-top:-10px;}
.topnav li a.mid:hover {
	background: rgb(18,88,158); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(18,88,158,1) 0%, rgba(53,106,160,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(18,88,158,1)), color-stop(100%,rgba(53,106,160,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(18,88,158,1) 0%,rgba(53,106,160,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(18,88,158,1) 0%,rgba(53,106,160,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(18,88,158,1) 0%,rgba(53,106,160,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(18,88,158,1) 0%,rgba(53,106,160,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#12589e', endColorstr='#356aa0',GradientType=0 ); /* IE6-9 */	color:white; text-shadow: 0 1px 1px black;
}
.topnav li a.mid i {font-size:2.4em}
.topnav li a.profile-setting {
	position:absolute; width: 30px; right:0; top:0; border-left:1px solid rgba(255,255,255,.1); 
	background: rgb(69,72,77); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(69,72,77,1) 0%, rgba(0,0,0,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(69,72,77,1)), color-stop(100%,rgba(0,0,0,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#45484d', endColorstr='#000000',GradientType=0 ); /* IE6-9 */ 
	border-radius:0;
	-webkit-border-top-right-radius: 5px;
	-webkit-border-bottom-right-radius: 5px;
	-moz-border-radius-topright: 5px;
	-moz-border-radius-bottomright: 5px;
	border-top-right-radius: 5px;
	border-bottom-right-radius: 5px;
	color: #ff8000 !important;
	}
.topnav li a.profile-setting:hover {
	background: rgb(0,0,0); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(0,0,0,1) 0%, rgba(69,72,77,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,1)), color-stop(100%,rgba(69,72,77,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(0,0,0,1) 0%,rgba(69,72,77,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(0,0,0,1) 0%,rgba(69,72,77,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(0,0,0,1) 0%,rgba(69,72,77,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(0,0,0,1) 0%,rgba(69,72,77,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#45484d',GradientType=0 ); /* IE6-9 */color:#ff8000;
}
.topnav li .avatar {
	width:50px; height:50px; margin-top:-5px; overflow:hidden; border-radius:25%; margin-left:25%; border:1px solid rgba(255,255,255,.1); box-shadow: 0 -1px 1px black}
.topnav li .avatar img {width:105%}

.topnav .child {
	width:805px;
	margin-top:20px;
	display:none;
	position:absolute; right:20px;
}
.topnav .child ul {
    float: left;
    text-align: center;
}
.topnav .child ul li {
    float: left;
}
.topnav .child ul li a {
    display: block;
	background:black;
	color: orange;
	text-shadow:0 1px 1px black;
    padding: 10px 20px;
	height: 20px;
	line-height:20px;
}
.topnav .child ul li a:hover {
    background: orange;
	color: black;
	text-shadow:none;
}

.topnav .arrow_box {
	position: absolute;
	background: #111;
	border: 2px solid #333;
	width:110px;
	top:68px;
	right:-40px;
	padding:2px 5px;
	text-align:left !important;
	display:none;
	z-index:9266;
}
.topnav .arrow_box i {font-size:.9em}
.topnav .arrow_box a, .topnav .arrow_box a:hover, .topnav .arrow_box a.active {background:none; border:none; text-shadow:none; box-shadow:none; font-size:.85em; border-radius:0; text-transform: uppercase}
.topnav .arrow_box a {color:#ff8000 !important}
.topnav .arrow_box a:hover {color:orange !important}
.topnav .arrow_box:after, .topnav .arrow_box:before {
	bottom: 100%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	position: absolute;
	pointer-events: none;
}

.topnav .arrow_box:after {
	border-color: rgba(17, 17, 17, 0);
	border-bottom-color: #111;
	border-width: 5px;
	left: 50%;
	margin-left: -5px;
}
.topnav .arrow_box:before {
	border-color: rgba(85, 85, 85, 0);
	border-bottom-color: #333;
	border-width: 8px;
	left: 50%;
	margin-left: -8px;
}

.logo {background: url(/public/images/codeArmy/mymission/fillter-toolbar.png); height:134px; width:142px; background-position:-16px 0px; margin: 10px 0 0 10px; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px}

hr {border-top-color:black; border-bottom-color:#444}

.profile-header .alert {margin-top:5px; margin-bottom:5px; background:none; border:none; color:orange; text-shadow:none; display:none}
.profile-header .alert .close {color:white; text-shadow:0 1px 1px black}
</style>
<div id="inner">
<?php if($me['role']=='po' || $me['role']=='admin'){?>
<a href="/missions/tallent_map"><div title="Close" class="fancybox-item fancybox-close" style="position: fixed;right: 150px;top: 7px;"></div></a>
<?php }?>
<div id="container" style="background:none" class="container-fluid">

    <div class="profile-header" > 
	
		<div class="row-fluid">
			<div class="span2">
				<a href="/profile"><div class="logo"></div></a>
			</div>
			<div class="span10">
				<ul class="nav topnav">
					<li><a href="/messages/inbox" rel=""><i class="icon-envelope-alt"></i> <br />Messages</a>
						<nav class="child">
							<ul class="childnav">
								<li><a href="/messages/inbox">Inbox</a></li>
								<li><a href="/messages/compose">Compose</a></li>
								<li><a href="/messages/sent">Sent</a></li>
								<li><a href="/messages/archive">Archive</a></li>
								<li><a href="/messages/trash">Trash</a></li>
							</ul>
						</nav>
					</li>
					<li><a href="/messages/notifications" ><i class="icon-bullhorn"></i> <br />Notifications</a></li>
					<li>
						<?php if(($this->session->userdata('role')=='po'||$this->session->userdata('role')=='admin')){?>
				          <a href="/missions/create"><i class="icon-globe"></i><br />Create Mission</a>
				          <?php }else{?>
				          <a href="/missions" class="mid"><i class="icon-globe"></i><br />Find Missions</a>
				          <?php }?>
					</li>
					<li><a href="/missions/my_missions"><i class="icon-folder-open"></i> <br />My Mission</a>
						<nav class="child">
							<ul class="childnav">
								<li><a href="/missions/bid">Bidded</a></li>
								<li><a href="/missions/completed">Completed</a></li>
							</ul>
						</nav>
					</li>
					<li>
						<a href="/profile">
							<div class="avatar"><img src="http://avatars.io/auto/demo" alt="" /></div>
						</a>
						<a href="#" class="profile-setting"><i class="icon-caret-down"></i></a>
						<div class="arrow_box">
							<a href="/about"><i class="icon-briefcase"></i> About Us</a> <br />
							<a href="/faq"><i class="icon-info-sign"></i> FAQ's</a> <br />
							<a href="/login/logout"><i class="icon-signout"></i> Log Out</a> <br />
							<a href="/invite"><i class="icon-share"></i> Invite Friends</a>
						</div>
					</li>
				</ul>
				<div class="clearfix"></div>
				
			</div>
		</div>
		
		<div class="row-fluid" style="background:#222; margin-top:10px; box-shadow: inset 0 1px 3px black">
			<div class="alert alert-error span10 offset1">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Oh snap!</strong> Change a few things up and try submitting again.
			</div>
		</div>
		
      <!-- Old main nav 
		<ul id="header-links">
        <li><a href="/messages" id="Messages">
          <div id="messages-holder">
            <div class="notification <?=isset($myActiveMessages)&&$myActiveMessages>0?'':'hidden' ?>" id="messages-notification"><?=isset($myActiveMessages)?$myActiveMessages:'?' ?></div>
            Messages </div>
          </a> </li>
        <li><a href="/messages/notifications" id="Notifications">
          <div id="notifications-holder">
            <div class="notification <?=isset($myActiveNotifications)&&$myActiveNotifications>0?'':'hidden' ?>" id="notifications-notification"><?=$myActiveNotifications?></div>
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
      </ul> -->

    <div id="dropdown">
        <ul>
         <!-- <li><a href="#">Account settings</a></li> -->
          <li><a href="/faq">FAQ's</a></li>
          <li><a href="/about">About us</a></li>
        </ul>
        <a style="margin-top:0;" href="/login/logout" id="logout">Log out</a>
	</div>
    <!-- <div id="live-feed">Welcome back <?=$me['username']?></div> -->
    </div>
	
	<hr />
    <?php if(in_array($page_is,array('Profile','Missions','Achievements','Leaderboard','Invite'))):?>
	<!-- Left block -->
	<div id="left-block" style="top:10px">
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
	
	<!-- Left block -->
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
    <div id="main-content" style="margin-top:0; overflow:hidden; padding-top:10px">
	
	<script src="../../../public/js/codeArmy/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../../../public/js/codeArmy/horizontalNav.js" type="text/javascript" charset="utf-8"></script>
	<script src="../../../public/js/codeArmy/cookie.js" type="text/javascript" charset="utf-8"></script>
	
	<script type="text/javascript">
	$(function(){
		
		var now = $.cookie("active");
		if (now != 2) {
			$('.topnav > li').eq(now).find('a').addClass('active');
		}
		$('.topnav > li').eq(now).find('.child').fadeIn('fast');
		
		$('.child').horizontalNav();
		$('.topnav li').on('click',function(){
			
			var self   = $(this),
			    index  = self.index();
		    $.cookie("active", index, { expires : 1, path: '/' } );
			
			$('.topnav li a').removeClass('active');
			$('a', this).addClass('active');
			$('.child').not($('.child', this)).hide();
			$('.child', this).stop().slideToggle();
			//alert( $.cookie("active") );	
		});
		$('a.profile-setting').click(function(){
			$('.arrow_box').slideToggle('fast');
		});
		
		$('.logo').click(function(){
			$.cookie("active", 2, { expires : 1, path: '/' } );
		});
		
		//For notifications or announcements, just edit .alert text and enable it 
	})
	</script>