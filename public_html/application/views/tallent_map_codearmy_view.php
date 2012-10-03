<?php $this->load->view('includes/CAHeader.php'); ?>
<script src="/public/js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
<script src="/public/js/codeArmy/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/public/js/codeArmy/horizontalNav.js" type="text/javascript" charset="utf-8"></script>
<script src="/public/js/codeArmy/cookie.js" type="text/javascript" charset="utf-8"></script>

<style type="text/css">

	.topnav {margin-top:10px;text-align:center;}
	.topnav li {width:19.5%; float:left; cursor:pointer}
	.topnav li:last-child {position:relative;}
	.topnav li a {
		color:#ff8000; font-size:1em; height: 40px; padding:10px 0;margin-left:3px; 
		text-shadow:0 1px 1px black; box-shadow:inset 0 1px 1px #666; position:relative;
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
	.topnav li a.mid {height:40px; padding-top:15px; margin-top:-3px;}
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
		width:776px;
		margin-top:5px;
		display:none;
		position:absolute; right:40px;
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
	    padding: 8px 20px;
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
	.topnav .arrow_box hr {margin:2px 0; border-top:1px solid #333; border-bottom:none}

	.logo {background: url(/public/images/codeArmy/mymission/fillter-toolbar.png); height:100px; width:142px; background-position:-16px -15px; margin: 10px 0 0 10px; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; border:2px solid #111}

	hr {border-top-color:black; border-bottom-color:#444}

	.profile-header .alert {margin-top:5px; margin-bottom:5px; background:none; border:none; color:orange; text-shadow:none; display:none}
	.profile-header .alert .close {color:white; text-shadow:0 1px 1px black}

	span.notification {
		position: absolute;
		top: 0px;
		right: 60px;
		background: red;
		width: 15px;
		height: 15px;
		line-height: 15px;
		border-radius: 50%;
		box-shadow: 0 1px 2px black;
		color:white;
		text-shadow:0 1px 1px black;
		font-size:.8em;
	}
	
	.topselectwrap {position:relative}
	.topselectwrap div {position:absolute; color:white; top:9px; right:10px}
	
	.topnav select {background:black; -webkit-appearance: none; border:none; height:35px; line-height:35px; width:180px; padding:0 0 0 10px; margin:0; text-shadow:0 1px 1px black; box-shadow:inset 0 1px 1px #666; color:orange; }
	
	.topnav input {margin:0; padding:5px}
	
	.topnav li a.cmission {
		background:#2f9cad !important; /* Old browsers */
		color:white !important;		
	}
	.topnav a#search-submit {position:absolute; background:none; border:none; box-shadow:none; top:2px; right:-10px; color:black; text-shadow:none}
	
	.topnav .filter div {background:black; height:36px; line-height:36px; text-shadow:0 1px 1px black; box-shadow:inset 0 1px 1px #666; color:orange}
	.topnav .filter .filterwrap {display:none}
	
	/* PO style */
	.stickynav {width:1000px; margin:0 auto; position:relative; z-index:99999999; padding-bottom:10px; border-bottom:1px solid black}
	.ajax-frame {display:none}
</style>

<!--TODO: add ajax loader icons -->
<div id="wrapper">
	
  <div id="find-mission-area">
	
	<!-- New nav -->
	<div class="stickynav">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span2">
					<a href="/missions/tallent_map"><div class="logo"></div></a>
				</div>
				<div class="span10">
					<ul class="nav topnav">
						<li class="first">
							<a rel="/messages/inbox"><i class="icon-envelope-alt"></i> <br />Messages
							<span class="notification <?=isset($myActiveMessages)&&$myActiveMessages>0?'':'hidden' ?>" id="messages-notification"><?=isset($myActiveMessages)?$myActiveMessages:'?' ?></span>
							</a>

							<nav class="child">
								<ul class="childnav">
									<li><a rel="/messages/inbox">Inbox</a></li>
									<li><a rel="/messages/compose">Compose</a></li>
									<li><a rel="/messages/sent">Sent</a></li>
									<li><a rel="/messages/archive">Archive</a></li>
									<li><a rel="/messages/trash">Trash</a></li>
								</ul>
							</nav>
						</li>
						<li class="first">
							<a rel="/messages/notifications" ><i class="icon-bullhorn"></i> <br />Notifications
							<span class="notification <?=isset($myActiveNotifications)&&$myActiveNotifications>0?'':'hidden' ?>" id="notifications-notification"><?=$myActiveNotifications?></span>
							</a>
						</li>
						<li class="first">
							<a rel="/missions/tallent_map" class="mid"><i class="icon-globe"></i><br />Find Talent</a>
							<nav class="child">
								<ul class="childnav">
									<!-- <li class="void">
										<div class="topselectwrap">
											<div><i class="icon-chevron-down"></i></div>
											<select name="select" id="">
												<option value="#">Level (All)</option>
												<option value="1">1-20</option>
												<option value="20">20-40</option>
												<option value="40">40-60</option>
												<option value="60">60-80</option>
												<option value="80-100">80-99</option>
											</select>
										</div>
									</li> 
									<li class="void">
										<div class="topselectwrap">
											<div><i class="icon-chevron-down"></i></div>
											<select name="select" id="filter">
												<option value="#">Skill (All)</option>
												<option value="mobile-app">Mobile App Dev</option>
												<option value="social-network">Social Network Dev</option>
												<option value="website-design">Website Design</option>
												<option value="online-store">Online Store</option>
												<option value="blog">Blog</option>
												<option value="content-writing">Content Writing</option>
											</select>
											
										</div>
									</li> -->
									<li>
										<div class="filter">
											<div class="all" onClick="javascript:allusers()">All User</div>
											<div class="filterwrap">
												<div onClick="javascript:latest()">Contractors</div>
												<div onClick="javascript:po()">Product Owners</div>
												<div onClick="javascript:skills()">Skills</div>
												<div onClick="javascript:classification()">Division</div>
											</div>
										</div>
									</li>
									<li><a rel="/missions/createnew" class="cmission">Create Mission</a></li>
									<!-- <li><div><input type="search" /></div></li> -->
									<li>
										<div id="search-bar" style="position:relative">
									    <input type="text" name="search" id="search" value="Find missions" style="width:90%"/>
									    <a title="Search for missions" href="#" id="search-submit">
											<i class="icon-search"></i>
											<img id="search-loader" title="Notifications" src="/public/images/newloader.gif" />
										</a>
									  </div>
									</li>
								</ul>
							</nav>
						</li>
						<li class="first"><a rel="/missions/my_missions"><i class="icon-folder-open"></i> <br />My Mission
							<span class="notification <?=isset($myActiveMissions)&&$myActiveMissions>0?'':'hidden'?>" id="mymissions-notification"><?=isset($myActiveMissions)?$myActiveMissions:'?'?></span>
							</a>
							<nav class="child">
								<ul class="childnav">
									<li><a rel="/missions/bid">Bidded</a></li>
									<li><a rel="/missions/completed">Completed</a></li>
								</ul>
							</nav>
						</li>
						<li class="first">
							<a rel="/profile">
								<div class="avatar"><img src="/public/images/codeArmy/profile/avatar.png" border="0"></div>
							</a>
							<a class="profile-setting"><i class="icon-caret-down"></i></a>
							<div class="arrow_box">
								<a rel="/about"><i class="icon-briefcase"></i> About Us</a> <br />
								<a rel="/faq"><i class="icon-info-sign"></i> FAQ's</a> <br />
								<a rel="/invite"><i class="icon-share"></i> Invite Friends</a>
								<hr />
								<a href="/login/logout"><i class="icon-signout"></i> Log Out</a>
							</div>
						</li>
					</ul>
					<div class="clearfix"></div>

				</div>
			</div>
		</div>
	</div>
	<!-- Ends new nav -->
	
	<div class="ajax-frame"></div>
	
    <div id="world-map" style="background:url(/public/images/codeArmy/mymission/world-map.png) no-repeat;width:999px;height:532px; "> <!--<img id="world-map-img" src="/public/images/codeArmy/mymission/world-map.png" width="999" height="532" />-->
	 
      <!-- project list -->
      <div id="dialog-project-list" class="dialog">
        <div class="container">
          <div class="dialog-close-button"></div>
          <div class="log"></div>
      	</div>
      </div>
      <!-- end of project list --> 
      
      <!-- chat box
      <div class="chat-box toolbar" style="position:absolute;left:10px;top:370px;width:250px;height:200px;background:rgba(60,60,60,0.6);z-index:2">
      	<div style="border-bottom:1px solid black"><span id="count">0</span> users in chatroom</div>
        <div class="nano-chat nano">
        	<div id="chat-message-list" class="content"></div>
        </div>
        <div class="chat-box-form" style="height:25px; border-top:1px solid black;">
        <input type="text" name="msg" id="public-message-textarea" style="width:201px;height:25px;background:none;border:none;padding:0 3px 0 3px;margin:0;color:white">
        <input type="button" id="public-message-submit" value="send" disabled="disabled" style="width:40px;height:25px;border:none;padding:0;margin:0;">
        </div>
      </div>
       end of chat box -->
    </div>
  </div>
</div>
<?php //$this->load->view('includes/duck.php'); ?>
<?php $this->load->view('includes/CAMapFooter.php'); ?>
<!-- dialogs -->

<!-- <div id="filter-toolbar" class="toolbar"> <a href="/profile" id="filter-toolbar-logo"></a>
  	<ul>
		<li><a href = "javascript:void(0)" class="create_mission create">Create Mission <i class="icon-plus"></i></a></li>
	</ul>
	<div id="search-bar">
    <input type="text" name="search" id="search" value="Find missions" />
    <a title="Search for missions" href="#" id="search-submit">
		<i class="icon-search"></i>
		<img id="search-loader" title="Notifications" src="/public/images/newloader.gif" />
	</a>
  </div>
  <ul>
  	<li><a id="allusers" class="menu first selected" href="javascript:allusers()">All users <i class="icon-chevron-right"></i></a></li>
  	<li><a id="latest" class="menu first" href="javascript:latest()">Contractors <i class="icon-chevron-right"></i></a></li>
    <li><a id="po" class="menu first" href="javascript:po()">Product owners <i class="icon-chevron-right"></i></a></li>
  	<li><a id="skills" class="menu first" href="javascript:skills();">Skills <i class="icon-chevron-right"></i></a></li>
    <li><a id="classification" class="menu first" href="javascript:classification();">Divisions <i class="icon-chevron-right"></i></a></li>
  </ul>
</div> -->

<!-- <div id="profile-toolbar" class="toolbar">
  <a href="/login/logout" class="logout" title="Logout"><span class="icon-off"></span></a>
  <div id="avatar-block"> <a href="/profile"><img src="/public/images/codeArmy/mymission/profile_toolbar/avatar.png" id="avatar" alt="avatar" /></a>
    <ul id="status-icons">
      <li><a href="/missions/my_missions"><img title="Missions" src="/public/images/codeArmy/mymission/profile_toolbar/mission-status.png" /></a>
        <?php if($myActiveMissions){?><div class="status"><?=$myActiveMissions?></div><?php }?>
      </li>
      <li><a href="/messages/inbox"><img title="Messages" src="/public/images/codeArmy/mymission/profile_toolbar/message-status.png" /></a>
        <?php if($myActiveMessages){?><div class="status"><?=$myActiveMessages?></div><?php }?>
      </li>
      <li><a href="/messages/notifications"><img title="Notifications" src="/public/images/codeArmy/mymission/profile_toolbar/notification-status.png" /></a>
        <?php if($myActiveNotifications){?><div class="status"><?=$myActiveNotifications?></div><?php }?>
      </li>
    </ul>
  </div>
  <div id="experience-block">
    <ul>
      <li>Level <?=$myLevel?></li>
      <li><?=$me["exp"];?></li>
    </ul>
    <div id="experience-meter" style="width:<?=round(121*$expProgress)?>px;"></div>
  </div>
  <div style="margin:0 7px;">
    <?php if ($mySkills) foreach($mySkills as $skill):?>
    <div class="skill-block" id="myskill_<?=$skill["id"]?>">
      <div class="icon" title="<?=$skill["name"]?>"><?=substr($skill["name"],0,3)?></div>
      <div class="level"><?=$skill["point"]?></div>
      <div class="skill-meter" style="width:<?=round($skill["point"]*92/100)?>px;"></div>
    </div>
    <?php endforeach;?>
    <div id="finishing-section"> </div>
  </div>
</div>
<div id="mission_creator" class="dialog">
	<div class="header">Create Mission</div>
    <div class="content">
    	<div class="class1">What do you want done?</div>
        <div class="selection">
        <select id="category" name="category">
        <option value="" selected="selected">--- Please select ---</option>
      <?php foreach($main_category as $value): ?>
        <option value="<?=$value['category_id']?>"><?=$value['category']?></option>
      <?php endforeach; ?>
        </select>
        </div>
    </div>
</div> -->

<div id="mission-creator" class="theframe">
	<div class="thebox small">
		<h1>Create Mission</h1>
		<div class="liner"></div>
		<p>What do you want done?</p>
		<select id="category" name="category">
	    <option value="" selected="selected">- Please select -</option>
	  <?php foreach($main_category as $value): ?>
	    <option value="<?=$value['category_id']?>"><?=$value['category']?></option>
	  <?php endforeach; ?>
	    </select>
	<div class="closeme"><i class="icon-remove"></i></div>
	</div>
</div>

<div class="mission-frame" style="width:800px; height:550px; display:none;"><div class="closeme"><i class="icon-remove"></i></div></div>

<!-- marker template -->
<div id="marker-template" class="marker" style="display:none;">
  <div class="marker-icon">#</div>
  <div class="arrow-desc">12<br/>
    PHP</div>
  <div class="arrow-down-container">
    <div class="arrow-down"> </div>
  </div>
</div>
<!-- end of marker template -->
<!-- folder contents -->
<div id="folder-wrapper"><div class="content"><img src="/public/images/ajax-loader.gif" /></div><div class="arrow"></div></div>
<!-- end of folder contents -->
<style>
	* {
		transform-style: preserve-3d;
		backface-visibility: hidden;
		/* -moz-transform-style: preserve-3d;
		-moz-backface-visibility: hidden; */
		-o-transform-style: preserve-3d;
		-o-backface-visibility: hidden;
	}
	.nano-chat{height:153px;}
	.nano-chat .content{padding:5px;color:white;}
	.logout{
		color:#800;font-size: 15pt;position: absolute;right: 12px;top: 6px;
		transition: font-size .15s ease-in-out,color .15s ease-in-out,border .15s ease-in-out,color .15s ease-in-out;
	   -moz-transition: font-size .15s ease-in-out,color .15s ease-in-out,border .15s ease-in-out,color .15s ease-in-out;
	   -webkit-transition: font-size .15s ease-in-out,color .15s ease-in-out,border .15s ease-in-out,color .15s ease-in-out;
	 }
	.logout:hover{color:red;}
	#folder-wrapper{
		display:none;
		position: absolute;
		bottom: 110px;
		left: 50%;
		margin-left:-400px;
		width: 800px;
		z-index:10001;
	}
	#folder-wrapper .content{
		border: 1px solid black;
		clear:both;
		background: rgba(10, 10, 10, 0.9);
		width: 100%;
		border-radius: 10px; 
		-moz-border-radius: 10px; 
		-webkit-border-radius: 10px;
	}
	#folder-wrapper .arrow{
		color:white;
		clear:both;
		position:absolute;
		top:100%;
		left:475px;
		width:0;
		height:0;
		border-color: black transparent transparent transparent; 
		border-style: solid;
		border-width: 10px;
	}
	.mission-icon div{font-size:30pt;padding:10px 10px 5px 5px;text-align: center;}
	.mission-icon:hover{
		background: rgb(0, 176, 255); /* The Fallback */
		background: rgba(0, 176, 255, 0.1);
		border-color:white;
	}
	.mission-icon{
		color:white;
		width:104px;
		margin:8px 10px;
		height:100px;
		float:left;
		padding:2px;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		border:1px solid #333;
		transition: background .15s ease-in-out,color .15s ease-in-out,border .15s ease-in-out,color .15s ease-in-out;
	   -moz-transition: background .15s ease-in-out,color .15s ease-in-out,border .15s ease-in-out,color .15s ease-in-out;
	   -webkit-transition: background .15s ease-in-out,color .15s ease-in-out,border .15s ease-in-out,color .15s ease-in-out;
	}
	.mission-icon span{
		background:gray;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		font-size:8pt;
	}
	.mission-icon-more{
		color:white;
		width:104px;
		margin:8px 10px;
		height:100px;
		float:left;
		padding:2px;
		-webkit-border-radius: 50px;
		-moz-border-radius: 50px;
		border-radius: 50px;
		transition: text-shadow .15s ease-in-out,color .15s ease-in-out;
	   -moz-transition: text-shadow .15s ease-in-out,color .15s ease-in-out;
	   -webkit-transition: text-shadow .15s ease-in-out,color .15s ease-in-out;
	}
	.mission-icon-more div{font-size:38pt; padding:20px 30px;
		transition: font-size .15s ease-in-out,color .15s ease-in-out;
	   -moz-transition: font-size .15s ease-in-out,color .15s ease-in-out;
	   -webkit-transition: font-size .15s ease-in-out,color .15s ease-in-out;
	}
	.mission-icon-more:hover div{
		font-size:43pt;
	}
	.mission-icon-more:hover{text-shadow:0 0px 2px white;}
	#MissionCreateDetail{
		background:url(/public/images/codeArmy/mission/create_mission_detail_bg.png) no-repeat;
		width:750px;
		height:773px;
	}
	#mission_creator{
	width: 460px;
	height: 260px;
	padding:4px;
	background:url(/public/images/codeArmy/mission/create_mission__dialog_bg.png) no-repeat;
	}
	#mission_creator .header{
		font-size:12pt;
		text-align:center;
		height:32px;
		margin-top:17px;
		width:456px;
		color:white;
		text-shadow:0 0 2px #FFF;
	}
	#mission_creator .class1{font-size:11pt; color:white; text-align:center; margin-top:40px;}
	#mission_creator .selection{
		margin: 44px 124px;
		height: 27px;
		padding:0 5px;
		display: block;
		width: 203px;	
	}
	#mission_creator select{	
		display: block;
		width: 203px;
	}
	#search-loader{margin:4px 3px; display:none;}
	#profile-toolbar .skill-block{
		background:url(/public/images/codeArmy/mymission/profile_toolbar/skill_block_bg.png) no-repeat -37px 0;
		height:32px;
		position:relative;
	}
	#profile-toolbar .skill-block .icon{
		position:absolute; width:21px;height:21px;top:8px;left:12px;
		background:url(/public/images/codeArmy/mymission/profile_toolbar/skill-icon.png) no-repeat;
		text-transform:capitalize;
		text-align:center;
		font-weight:bold;
		font-size:6pt;
	}
	#profile-toolbar .skill-block .icon:first-letter{font-size:9pt;}
	#profile-toolbar .skill-block .level{position:absolute;font-size:6pt;top:5px;left:42px;}
	#profile-toolbar .skill-block .skill-meter{
		position:absolute; background:url(/public/images/codeArmy/mymission/profile_toolbar/meter-exp.png);
		height:5px;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		top:21px;left:41px;
	}
	#profile-toolbar #experience-block{
		background:url(/public/images/codeArmy/mymission/profile_toolbar/exp_block_bg.png) no-repeat;
		height:43px;
	}
	#profile-toolbar #experience-block #experience-meter{
		background:url(/public/images/codeArmy/mymission/profile_toolbar/meter.png);
		height:7px;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		position:relative;
		top:17px;left:18px;
	}
	#profile-toolbar #experience-block ul{color:white;width:113px;margin:0 0 0 21px;padding:4px 0;}
	#profile-toolbar #experience-block li{float:left;}
	#profile-toolbar #experience-block li:first-child{width:50%; font-size:7pt;}
	#profile-toolbar #experience-block li:last-child{width:50%;color:#ffcc33; font-size:5pt;text-align:right;margin-top:1px;}
	#profile-toolbar #avatar-block #status-icons{
		width:25px;
		float:left;
		margin-top:37px;
	}
	#profile-toolbar #avatar-block #status-icons li{
		position:relative;
		margin-top:11px;
	}
	#profile-toolbar #avatar-block .status{
		position:absolute;
		top:-15px;
		left:+8px;
		font-size:6pt;
		background:url(/public/images/codeArmy/mymission/profile_toolbar/notification-icon.png) no-repeat 0 3px;
		width:13px;
		height:17px;
		text-align:center;
		color:black;
	}
	#profile-toolbar #avatar-block #avatar{
		float:left;
		width:129px;height:140px;
		margin:0 0 0 1px;
	}
	#profile-toolbar{
		position:absolute;
		/*background:url(/public/images/codeArmy/mymission/profile-toolbar-temp.png) no-repeat;*/
		width:160px;
		top:10px;right:20px;
		z-index:10000;
		margin-right:10px;
	}
	#profile-toolbar #finishing-section{
		background:url(/public/images/codeArmy/mymission/profile_toolbar/finishing_block_bg.png) no-repeat;
		height:23px;
	}
	#profile-toolbar #avatar-block{
		background:url(/public/images/codeArmy/mymission/profile_toolbar/avatar_block_bg.png) no-repeat 0px 16px;
		height:140px;
	}
	
	/* New styling filter-toolbar */
	#filter-toolbar {
		width:142px;
		position:absolute;
		top:10px;left:20px;
		z-index:10001;
		overflow:hidden;
		background: -moz-linear-gradient(top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.6) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0.6)), color-stop(100%,rgba(0,0,0,0.6))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(0,0,0,0.6) 0%,rgba(0,0,0,0.6) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(0,0,0,0.6) 0%,rgba(0,0,0,0.6) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, rgba(0,0,0,0.6) 0%,rgba(0,0,0,0.6) 100%); /* IE10+ */
		background: linear-gradient(to bottom, rgba(0,0,0,0.6) 0%,rgba(0,0,0,0.6) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#99000000', endColorstr='#99000000',GradientType=0 ); /* IE6-9 */;
		font-size:.85em;
		border: 2px solid rgba(255,255,255,.15);
		border-bottom: none;
		
	}
	a#filter-toolbar-logo {
		width:100%;
		height:142px;
		background:url(/public/images/codeArmy/mymission/fillter-toolbar.png) no-repeat;
		background-position:-15px 0;
		display:block;
	}
	#filter-toolbar ul li {position:relative}
	#filter-toolbar ul li a {
		width:122px;
		display:block;
		padding: 5px 10px;
		border-bottom: 2px solid rgba(255, 255, 255, .2);
		clear:both;
		text-shadow: 0 1px 1px black;
	}
	#filter-toolbar .create {
		background: rgb(45,146,155); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(45,146,155,1) 0%, rgba(55,165,190,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(45,146,155,1)), color-stop(100%,rgba(55,165,190,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(45,146,155,1) 0%,rgba(55,165,190,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(45,146,155,1) 0%,rgba(55,165,190,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, rgba(45,146,155,1) 0%,rgba(55,165,190,1) 100%); /* IE10+ */
		background: linear-gradient(to bottom, rgba(45,146,155,1) 0%,rgba(55,165,190,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2d929b', endColorstr='#37a5be',GradientType=0 ); /* IE6-9 */;
		color:white;
		border-bottom: 2px solid #333;
	}
	#filter-toolbar .create:hover {
		background: rgb(57,180,191); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(57,180,191,1) 0%, rgba(45,131,158,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(57,180,191,1)), color-stop(100%,rgba(45,131,158,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(57,180,191,1) 0%,rgba(45,131,158,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(57,180,191,1) 0%,rgba(45,131,158,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, rgba(57,180,191,1) 0%,rgba(45,131,158,1) 100%); /* IE10+ */
		background: linear-gradient(to bottom, rgba(57,180,191,1) 0%,rgba(45,131,158,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#39b4bf', endColorstr='#2d839e',GradientType=0 ); /* IE6-9 */;
		border-bottom:2px solid #333;
	}
	#filter-toolbar ul li a:hover {
		background:black;
		border-bottom: 2px solid rgba(255, 255, 255, .3);
	}
	#filter-toolbar ul li a i {
		position:absolute; right:10px;
	}
	#filter-toolbar ul li a.selected {
		background: -moz-linear-gradient(top, rgba(69,72,77,0.6) 0%, rgba(0,0,0,0.6) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(69,72,77,0.6)), color-stop(100%,rgba(0,0,0,0.6))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(69,72,77,0.6) 0%,rgba(0,0,0,0.6) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(69,72,77,0.6) 0%,rgba(0,0,0,0.6) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, rgba(69,72,77,0.6) 0%,rgba(0,0,0,0.6) 100%); /* IE10+ */
		background: linear-gradient(to bottom, rgba(69,72,77,0.6) 0%,rgba(0,0,0,0.6) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9945484d', endColorstr='#99000000',GradientType=0 ); /* IE6-9 */
		color:orange;
	}
	#filter-toolbar #search-bar {position:relative}
	#filter-toolbar input {
		border:none; width:102px;
		padding: 0 5px;
		height:32px; line-height:32px;
		color:#999;
		border-radius:0;
		font-size:1em;
	}
	#filter-toolbar input:focus {color:black}
	#filter-toolbar #search-submit {
		width:30px;
		height:32px;
		display:block;
		position:absolute;
		top:0; right:0;
		line-height:32px; 
		text-align:center;
		color:black;
		font-size:1.4em;
		background:white;
	}
	#filter-toolbar #search-loader {
		position:absolute;
		top:3px; right:4px;
	}
	
	/* End new arrow */
	
	#dialog-project-list{
		width:0;
		height:0;
		background:rgba(0,0,0,0.8);
		display:none;
		position:absolute;
		top:16px;
		left:100px;
		z-index:1;
		overflow:auto;
	}
	.dialog{padding:0}
	.dialog .container{
		position:relative;
		width:100%;
		height:100%;
	}
	.dialog .dialog-close-button{
		position:absolute;
		top:8px;right:5px;
		width:36px;
		cursor:pointer;
		height:36px;
		background-image: url('/public/js/codeArmy/fancybox/source/fancybox_sprite.png');
		z-index:1;
	}
	#world-map{position:relative;}
	.marker-icon{
		background: black;
		width: 40px;
		margin-bottom: 2px;
		padding: 2px 0;
		font-size: 20pt;
	}
	.arrow-desc {
		background: black;
		width: 40px;
		margin-bottom: 2px;
		font-size: 12px;
		padding: 2px 0;
		color:white;
		font-style:italic;
	}
	.arrow-down-container {
		width: 0px;
		height: 0;
		border-left: 22px solid transparent;
		border-right: 20px solid transparent;
		border-top: 20px solid black;
		position: relative;
	}
	.arrow-down {
		width: 0;
		height: 0;
		border-left: 10px solid transparent;
		border-right: 10px solid transparent;
		border-top: 10px solid red;
		position: absolute;
		top: -16px;
		left: -10px;
	}
	.marker{
		display:none;
		position:absolute;
		top:200px;
		left:200px;
		-webkit-transform-style: preserve-3d;
		-webkit-backface-visibility: hidden;
		text-align:center;
	}
	#find-mission-area{
		position:relative; 
		margin:5px auto;
		background:url(/public/images/codeArmy/mymission/FindMissionsBG.jpg);
		width:999px;
		margin:0 auto;
	}
	.cell{
		background:#09dbe0;
		width:<?=$cell_size?>px;height:<?=$cell_size?>px;
		position:absolute;
		top:0;
		left:0;
	}
	
</style>
<script>

	//Nav script by MHN
	$(function(){
		
		var now = $.cookie("active");
		$('.topnav > li').eq(now).find('a').addClass('active');
		console.log(now);
		if (now != 2) {
			$('.topnav > li').eq(now).find('a').addClass('active');
		}
		$('.topnav > li').eq(now).find('.child').fadeIn('fast');
		
		$('.child').horizontalNav();
		
		$('a.profile-setting').click(function(){
			$('.arrow_box').stop().slideToggle('fast');
		});
		
		$('.logo').click(function(){
			$.cookie("active", 2, { expires : 1, path: '/' } );
		});
		
		$('.topnav li a.mid').click(function(){
			$('.ajax-frame').hide();
			$('#world-map').show();
		});
		
		$('.filter .all').mouseenter(function(){
			$('.filterwrap').slideDown('fast');
		});
		$('.filter').mouseleave(function(){
			$('.filterwrap').slideUp();
		})
		
		loadFrame();
		loadChild();
		//For notifications or announcements, just edit .alert text and enable it 
	})
	
	function loadFrame(){
		$('.topnav li.first a').not('.profile-setting').not('#search-submit').not('.mid').click(function(){
			var links = $(this).attr('rel');
			var height = $(window).height()-140;
			
			$('.arrow_box').stop().slideUp('fast');
			$('#world-map').hide();
			$('.ajax-frame').html();
			$('.ajax-frame').show().html('<iframe onload="this.contentWindow.scrollTo(0,0)" src="'+links+'" width="100%" height="'+height+'" scrollable="no" frameborder="0"></iframe>')
		});
	}
	
	function loadChild(){
		$('.topnav li.first').click(function(){
			/* var self   = $(this),
			    index  = self.index();
		    $.cookie("active", index, { expires : 1, path: '/' } ); */
			
			$('.topnav li a').removeClass('active');
			$('a', this).addClass('active');
			$('.child').not($('.child', this)).hide();
			$('.child', this).stop().slideDown();
		});
	}
	
	function loadEffect(){}
	
	var oldValue, jobs = <?php echo json_encode($tallents); ?>;
	
	$(function(){
		//create some markers
		/*randMarkers();
		var loc = geoToPixel({'lat':3.152480, 'lng': 101.717270});
		addMarker(loc.x,loc.y,'t1','*','12<br/>Ramin','#0ff',0.5,0);
		var loc = geoToPixel({'lat':70, 'lng': 0});
		addMarker(loc.x,loc.y,'t3','*','12<br/>top','#0ff',0.5,0);*/
		renderMarkers();
		
		$('#world-map .marker').fadeIn('slow');
		
		if(BrowserDetect.browser != 'Firefox') {
			$('.toolbar').draggable({ containment: '#wrapper' });
		} else {
			$('.chat-box.toolbar').draggable({ containment: '#wrapper' });
		};
		
		$('.chat-box.toolbar input').focus();
		$('.toolbar [title]').tipsy();
		initializeEvents();
		//run window resize
		$(window).resize();
		
		//fixed popup
		$('.create_mission').live('click',function(e){
			MissionCreate(1);
			e.preventDefault();
		});
		
	});
	
	function renderMarkers(){
		var loc;
		for(i=0; i<jobs.length;i++){
			loc = geoToPixel({'lat':jobs[i].lat, 'lng': jobs[i].lng});
			var desc = jobs[i].num+(jobs[i].skill?"<br/><div title='"+jobs[i].skill+"' href='javascript:void(0)'>"+ucfirst(jobs[i].skill.substring(0,3))+'</div>':'')+(jobs[i].days?"<br/>"+(jobs[i].days<1?"<1d":jobs[i].days+"d"):'')+(jobs[i].payout?"<br />"+(jobs[i].payout<1?"<10$":(jobs[i].payout<100?jobs[i].payout+'$':((jobs[i].payout/1000).toFixed(1)+'k$'))):'');
			addMarker(loc.x,loc.y,'marker_'+i,catToIcon(jobs[i].class),desc,'grey',0.75,500,jobs[i]);
		}
		$('div [title]').tipsy();
	}
	
	function ucfirst(string)
	{
		return string.charAt(0).toUpperCase() + string.slice(1);
	}
	
	function catToIcon(cat){
		var icon = null;
		if(cat!== undefined){
			switch(cat){
				case '1':icon = '#';break;
				case '4':icon = '@';break;
				case 'designer': icon = '<div title="Designer">ds</div>';break;
				case 'developer': icon = '<div title="Development">dv</div>';break;
				case 'copywriter': icon = '<div title="Copy writer">cp</div>';break;
				case 'unknown': icon = '?';break;
				case 'employer': icon = '<div title="Product owner">po</div>';break;
				case 'product owner': icon = '<div title="Product ownerr">po</div>';break;
				case 'admin': icon = '<div title="Product owner">Po</div>';break;
				default: icon = cat;
			}
		}
		return icon;
	}
	
	function initializeEvents(){
		$('#search').focus(function(){oldVal = $(this).val(); $(this).val(' ');});
		$('#search').blur(function(){if($.trim($(this).val())=='')$(this).val(oldVal);});
		$("#search").keypress(function() {
		  if(event.which==13){
			 $('#search-submit').click(); 
		  }
		});
		$('#search-submit').click(function(){
			var type = $('#filter-toolbar .selected').attr('id');
			var val = $('#search').val();
			if(val!='Find contrators'){
				if($.trim(val)=='')val = 'all';
				$('#search-loader').show();
				clearMarkers();
				$.ajax({
					type: 'POST',
					dataType: "json",
					url:'/missions/ajax_tallent_map_search',
					data:{'csrf_workpad': getCookie('csrf_workpad'),'search':val, 'type' : type},
					success:function(msg){
						jobs = msg;
						renderMarkers();
						$('#search-loader').hide();
					}
				});
			}
		});
		
		$('#world-map').on('mouseenter','.marker',
			function(){
					//mouse in
					$(this).css({
					'transform': 'scale(1,1)',
					'-webkit-transform': 'scale(1,1)',
					'-o-transform': 'scale(1,1)',
					'-moz-transform': 'scale(1,1)',
					'transform-origin': '50% 100%',
					'-webkit-transform-origin': '50% 100%',
					'-o-transform-origin': '50% 100%',
					'-moz-transform-origin': '50% 100%',
					'top':$(this).data().y,
					'left':$(this).data().x,
					'transition': '0.05s ease-out',
					'-o-transition': '0.05s ease-out',
					'-moz-transition': '0.05s ease-out',
					'-webkit-transition': '0.05s ease-out',
					'z-index':1
					});
			}
		);
		$('#world-map').on('mouseleave','.marker',
			function(){
					//mouse out
					$(this).css({
					'transform': 'scale('+$(this).data().scale+','+$(this).data().scale+')',
					'-webkit-transform': 'scale('+$(this).data().scale+','+$(this).data().scale+')',
					'-o-transform': 'scale('+$(this).data().scale+','+$(this).data().scale+')',
					'-moz-transform': 'scale('+$(this).data().scale+','+$(this).data().scale+')',
					'transform-origin': '50% 100%',
					'-webkit-transform-origin': '50% 100%',
					'-o-transform-origin': '50% 100%',
					'-moz-transform-origin': '50% 100%',
					'top':$(this).data().y,
					'left':$(this).data().x,
					'transition': '0.05s ease-out',
					'-o-transition': '0.05s ease-out',
					'-moz-transition': '0.05s ease-out',
					'-webkit-transition': '0.05s ease-out',
					'z-index':0
					})
				}
		);
	}
	
	$(window).resize(function() {
		//vertical cenerlise world map
		$('#find-mission-area').css('height',$(window).height()-40);
		//var y = Math.round(($(window).height()-40-$('#world-map-img').attr('height'))/2);
		var y = Math.round(($(window).height()-150-$('#world-map').height())/2);
		if(y<0)y=0;
		$('#world-map').css('top',y);
	});
	
	//*******************Start of marker filtering options******************/
	function allusers(){
		$('#allusers-loader').show();
		var type = 'allusers';
		$('#filter-toolbar .selected').removeClass('selected');
		$('#filter-toolbar #allusers').addClass('selected');
		$('#search').val('');
		clearMarkers();
		$.ajax({
			type: 'POST',
			dataType: "json",
			url:'/missions/ajax_tallent_map_search',
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'type': type},
			success:function(msg){
				jobs = msg;
				renderMarkers();
				$('#allusers-loader').hide();
			}
		});
	}
	
	function latest(){
		$('#latest-loader').show();
		var type = 'latest';
		$('#filter-toolbar .selected').removeClass('selected');
		$('#filter-toolbar #latest').addClass('selected');
		$('#search').val('');
		clearMarkers();
		$.ajax({
			type: 'POST',
			dataType: "json",
			url:'/missions/ajax_tallent_map_search',
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'type': type},
			success:function(msg){
				jobs = msg;
				renderMarkers();
				$('#latest-loader').hide();
			}
		});
	}
	
	function po(){
		$('#po-loader').show();
		var type = 'po';
		$('#filter-toolbar .selected').removeClass('selected');
		$('#filter-toolbar #po').addClass('selected');
		$('#search').val('');
		clearMarkers();
		$.ajax({
			type: 'POST',
			dataType: "json",
			url:'/missions/ajax_tallent_map_search',
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'type': type},
			success:function(msg){
				jobs = msg;
				renderMarkers();
				$('#po-loader').hide();
			}
		});
	}
	
	function classification(){
		$('#classification-loader').show();
		var type = 'classification';
		$('#filter-toolbar .selected').removeClass('selected');
		$('#filter-toolbar #classification').addClass('selected');
		$('#search').val('');
		clearMarkers();
		$.ajax({
			type: 'POST',
			dataType: "json",
			url:'/missions/ajax_tallent_map_search',
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'type':type},
			success:function(msg){
				jobs = msg;
				renderMarkers();
				$('#classification-loader').hide();
			}
		});
	}
	
	function skills(){
		$('#skills-loader').show();
		var type = 'skills';
		$('#filter-toolbar .selected').removeClass('selected');
		$('#filter-toolbar #skills').addClass('selected');
		$('#search').val('');
		clearMarkers();
		$.ajax({
			type: 'POST',
			dataType: "json",
			url:'/missions/ajax_tallent_map_search',
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'type':type},
			success:function(msg){
				jobs = msg;
				renderMarkers();
				$('#skills-loader').hide();
			}
		});
	}
	
	//*******************Start of rendering functions******************/
	function geoToPixel(geo){
		//TODO: change the map to google map style so lat and lng will remain in straight lines
		var x=0,y=0, width, height,lngS=-180,lngE=180,latS=-60,latE=70;
		//height = $('#world-map-img').height();
		//width = $('#world-map-img').width();
		height = $('#world-map').height();	
		width = $('#world-map').width();
		var wt = lngE - lngS;
		var ht = latE - latS;
		var wd = geo.lng-lngS;
		var hd = geo.lat-latS;
		x = Math.round(wd/wt*width);
		y = height-Math.round(hd/ht*height);
		return {'x':x,'y':y}
	}
	
	function clearMarkers(){
		$('#world-map .marker').fadeOut('fast',function(){$(this).remove();});
	}
	
	function addMarker(x,y,id,icon,desc,color,scale,speed,data){
		var template = $('#marker-template').clone();
		var container = $('#world-map');
		template.attr('id',id);
		if(icon){template.find('.marker-icon').html(icon);}else{template.find('.marker-icon').hide();}
		if(desc){template.find('.arrow-desc').html(desc);}else{template.find('.arrow-desc').hide();}
		template.find('.arrow-down').css({'border-top': '10px solid '+color});
		template.css({
				'transform': 'scale('+scale+','+scale+')',
				'-webkit-transform': 'scale('+scale+','+scale+')',
				'-o-transform': 'scale('+scale+','+scale+')',
				'-moz-transform': 'scale('+scale+','+scale+')',
				'transform-origin': '50% 100%',
				'-webkit-transform-origin': '50% 100%',
				'-o-transform-origin': '50% 100%',
				'-moz-transform-origin': '50% 100%',
			});
		container.append(template);
		x=x-Math.round(template.width()/2);
		y=y-template.height();
		template.css({
				'top':y,
				'left':x
			}).fadeIn(speed);
		template.data({'scale':scale,'x':x,'y':y,'color':color, 'ref':data});	
	}
	//*******************End of rendering functions******************/
</script>
<!-- chat box -->
<script>
$(function(){
	$('#public-message-submit').click(function(){
		var msg = $.trim(removeTags($('#public-message-textarea').val()));
		if(msg.length>0)
			$.ajax({
				type: 'post',
				url: '/messages/chat_send',
				data: {'id': '<?=$me['user_id']?>', 'name': '<?=$me['username']?>', 'email':'<?=$me['email']?>', 'message': msg, 'csrf_workpad': getCookie('csrf_workpad')},
				success: function(msg){
					$('#public-message-textarea').val('');
				}
			});
	});
	var no_chat_msg = 0;
	Pusher.channel_auth_endpoint = '/pusher/auth';
	var public_chat_channel = pusher.subscribe('presence-chat-public');
	
	public_chat_channel.bind('incomming-message', function(data) {
	  no_chat_msg++;
	  var username = (data.username=='<?=$me['username']?>')? 'me':data.username;
	  $('#chat-message-list').prepend('<div id="msg-'+no_chat_msg+'" style="display:none"><span style="color:orange">'+username+': </span>'+data.message+'</div>');
	  $('#msg-'+no_chat_msg).slideDown();
	  $(".nano-chat").nanoScroller();
	});
	
	pusher.connection.bind('state_change', function(states) {
	  // states = {previous: 'oldState', current: 'newState'}
	  $('div#status').text("Pusher's state changed from "+states.previous+" to " + states.current);
	  if(states.current=='connected')
	  $('#public-message-submit').removeAttr('disabled');
	  else $('#public-message-submit').attr('disabled',true);
	});
	
	public_chat_channel.bind('pusher:subscription_succeeded', function(members) {	
	  members.each(function(member) {
		add_member(member);
	  });
	});
	public_chat_channel.bind('pusher:member_added', function(member) {
		add_member(member);
	});
	public_chat_channel.bind('pusher:member_removed', function(member) {
	  remove_member(member);
	});
	
	$('#public-message-textarea').keyup(function(e){
	  e = e || event;
	  if (e.keyCode === 13) {
		$('#public-message-submit').click();
		$('#public-message-textarea').val('');
	  }
	  return true;
	 });

});

function add_member(member){
	var found = false;
	$('.chat-member').each(function(){if($(this).attr('id').split('-')[2]==member.id)found=true;});
	if(!found){
		var el = $('#count');
		el.html(parseInt(el.html())+1);
		$('#public-message-users').append('<div style="display:none" class="chat-member" id="chat-member-'+member.id+'">'+member.info.username+'</div>');
		$('#chat-member-'+member.id).slideDown();
	}
}

function remove_member(member){
	$('#public-message-user #chat-member-'+member.id).remove();
	var el = $('#count');
	el.html(parseInt(el.html())-1);
}
 
 var tagBody = '(?:[^"\'>]|"[^"]*"|\'[^\']*\')*';

var tagOrComment = new RegExp(
    '<(?:'
    // Comment body.
    + '!--(?:(?:-*[^->])*--+|-?)'
    // Special "raw text" elements whose content should be elided.
    + '|script\\b' + tagBody + '>[\\s\\S]*?</script\\s*'
    + '|style\\b' + tagBody + '>[\\s\\S]*?</style\\s*'
    // Regular name
    + '|/?[a-z]'
    + tagBody
    + ')>',
    'gi');
function removeTags(html) {
  var oldHtml;
  do {
    oldHtml = html;
    html = html.replace(tagOrComment, '');
  } while (html !== oldHtml);
  return html.replace(/</g, '&lt;');
}

</script>
<!-- end of chat box -->
<!-- <script type="text/javascript" src="/public/js/codeArmy/duck.js"></script> -->
<?php $this->load->view('includes/CAFooter.php'); ?>