<?php $this->load->view('includes/CAHeader.php'); ?>
<!--TODO: add ajax loader icons -->
<div id="wrapper">
  <div id="find-mission-area">
    <div id="world-map" style="background:url(/public/images/codeArmy/mymission/world-map.png);width:999px;height:532px;"> <!--<img id="world-map-img" src="/public/images/codeArmy/mymission/world-map.png" width="999" height="532" />-->

      <!-- project list -->
      <div id="dialog-project-list" class="dialog">
        <div class="container">
          <div class="dialog-close-button"></div>
          <div class="log"></div>
      	</div>
      </div>
      <!-- end of project list --> 
      
      <!-- chat box -->
      <div class="chat-box toolbar" style="position:absolute;left:10px;top:370px;width:250px;height:200px;background:rgba(60,60,60,0.6);">
      	<div style="border-bottom:1px solid black"><span id="count">0</span> users in chatroom</div
        ><div id="chat-message-list" style="height:143px;padding:5px;color:white; overflow:scroll"></div>
        <div class="chat-box-form" style="height:25px; border-top:1px solid black;">
        <input type="text" name="msg" id="public-message-textarea" style="width:201px;height:25px;background:none;border:none;padding:0 3px 0 3px;margin:0;color:white">
        <input type="button" id="public-message-submit" value="send" disabled="disabled" style="width:40px;height:25px;border:none;padding:0;margin:0;">
        </div>
      </div>
      <!-- end of chat box -->
    </div>
  </div>
</div>
<?php $this->load->view('includes/CAMapFooter.php'); ?>
<!-- dialogs -->
<div id="filter-toolbar" class="toolbar"> <a href="/profile" id="filter-toolbar-logo"></a>
  <div id="search-bar">
    <input type="text" name="search" id="search" value="Find missions" />
    <a title="Search for missions" href="#" id="search-submit"><img id="search-loader" title="Notifications" src="/public/images/ajax-loader.gif" width="32" height="32" /></a> </div>
  <ul>
    <li><a id="latest" class="menu first selected" href="javascript:latest()">Latest</a></li>
    <li><a id="classification" class="menu first" href="javascript:classification();">Classification</a></li>
    <li><a id="skills" class="menu first" href="javascript:skills();">Skills</a></li>
    <li><a id="estimation" class="menu first" href="javascript:estimation();">Time Estimation</a></li>
    <li><a id="payout" class="menu first" href="javascript:payout();">Payout</a></li>
  </ul>
</div>
<div id="profile-toolbar" class="toolbar">
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
<!-- end of dialogs --> 

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
<div id="dialog-accept" class="dialog" title="Proposal Accepted">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Your proposal is accepted. Hurry up and be the first one to report to captain before someone else takes the mission.</p>
</div>
<style>
	* {
		transform-style: preserve-3d;
		backface-visibility: hidden;
		-moz-transform-style: preserve-3d;
		-moz-backface-visibility: hidden;
		-o-transform-style: preserve-3d;
		-o-backface-visibility: hidden;
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
	.logout{
		color:#800;font-size: 15pt;position: absolute;right: 12px;top: 6px;
		transition: font-size .15s ease-in-out,color .15s ease-in-out,border .15s ease-in-out,color .15s ease-in-out;
	   -moz-transition: font-size .15s ease-in-out,color .15s ease-in-out,border .15s ease-in-out,color .15s ease-in-out;
	   -webkit-transition: font-size .15s ease-in-out,color .15s ease-in-out,border .15s ease-in-out,color .15s ease-in-out;
	 }
	.logout:hover{color:red;}
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
	#filter-toolbar{
		background:url(/public/images/codeArmy/mymission/fillter-toolbar.png) no-repeat;
		width:176px; height:359px;
		position:absolute;
		top:10px;left:20px;
		z-index:10001;
	}
	#filter-toolbar ul{font-size:8pt; color:e5e5e5;}
	#filter-toolbar ul li a{display:block;width:120px; height:22px;padding:7px 0 0 18px;margin:1px 0 0 18px;}
	#filter-toolbar ul li a:hover, #filter-toolbar ul li a.selected{ background:url(/public/images/codeArmy/mymission/fillter-toolbar-highlight.png) no-repeat 16px 4px; text-shadow:0 0 3px #FFF;}
	#search-bar #search-submit{width: 32px; height:34px; float:left;}
	#search-bar input{width:100px; height:32px; background:none; font-style:italic; float:left; color:#999; font-size:9pt; text-align:center; border:none;}
	#search-bar{display:block;height:36px; margin:0 0 4px 18px;width:140px;}
	a#filter-toolbar-logo{
		width:142px;height:133px;
		margin:0 15px 10px 15px;
		display:block;
	}
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
	.arrow-desc{
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
		cursor:pointer;
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
		width:10px;height:10px;
		position:absolute;
		top:0;
		left:0;
	}
</style>
<script>
	
	function loadEffect(){}
	
	var oldValue, jobs = <?php echo json_encode($works); ?>;
	
	$(function(){
		//$('.dialog').jScrollPane();
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
		
		$('.toolbar [title]').tipsy();
		initializeEvents();
		//run window resize
		$(window).resize();
		var channel = pusher.subscribe('map-channel');
		channel.bind('map-new', function(data) {
		  checkMarker(data.lat,data.lng,1);
		});
	});
	
	function renderMarkers(){
		var loc;
		for(i=0; i<jobs.length;i++){
			
			loc = geoToPixel({'lat':jobs[i].lat, 'lng': jobs[i].lng});
			var desc = jobs[i].num+(jobs[i].skill?"<br/>"+ucfirst(jobs[i].skill.substring(0,3)):'')+(jobs[i].days?"<br/>"+(jobs[i].days<1?"<1d":jobs[i].days+"d"):'')+(jobs[i].payout?"<br />"+(jobs[i].payout<1?"<10$":(jobs[i].payout<100?jobs[i].payout+'$':((jobs[i].payout/1000).toFixed(1)+'k$'))):'');
			addMarker(loc.x,loc.y,'marker_'+i,catToIcon(jobs[i].class),desc,'grey',0.75,500,jobs[i]);
			//if (typeof console == "object") console.log(loc.x,loc.y,'marker_'+i,catToIcon(jobs[i].class),desc,'grey',0.75,500,jobs[i]);
		}
	}
	
	function ucfirst(string)
	{
		return string.charAt(0).toUpperCase() + string.slice(1);
	}
	
	function catToIcon(cat){
		var icon = null;
		if(cat!== undefined){
			switch(cat){
				case 'a':icon = '#';break;
				case '1':icon = '<span class="icon-globe"></span>';break;
				default: icon = cat;
			}
		}
		return icon;
	}
	
	function gotoMission(){
		var mission_id=$(this).attr('id').split('-')[1];
		window.location="/mission/view/"+mission_id;
	}
	
	function controlMissionList(){
		if($(this).hasClass('selected')){
			$(this).removeClass('selected');
			$(this).siblings('.detail-row').slideUp();
		}else{
			$(this).addClass('selected').siblings('.summary-row').removeClass('selected');
			$(this).siblings('.detail-row').slideUp(); 
			$(this).next('.detail-row').slideToggle();
		}
	}
	
	function initializeEvents(){
		$("a[rel=missions]").fancybox({
				'transitionIn'      : 'fade',
                'transitionOut'     : 'fade',
                'type'              : 'iframe',
            });
		//initial dialog close button
		$('.dialog-close-button').click(function(){
			var dialog = $(this).parents('.dialog');
			dialog.animate({top:dialog.data().y, left:dialog.data().x, width:0, height:0, opacity:0},'fast',function(){$(this).hide()});
		});
		
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
			if(val!='Find missions'){
				if($.trim(val).length<3)val = 'all';
				$('#search-loader').show();
				clearMarkers();
				$.ajax({
					type: 'POST',
					dataType: "json",
					url:'/missions/ajax_mission_map_search',
					data:{'csrf_workpad': getCookie('csrf_workpad'),'search':val, 'type' : type},
					success:function(msg){
						jobs = msg;
						renderMarkers();
						$('#search-loader').hide();
					}
				});
			}
		});
		
		$('#world-map').on('click','.marker',function(){
					//TODO: open project list
					var me = this;
					$.fancybox.showLoading();
					$.fancybox.close();
					$.get(
						'/missions/mission_list/'+$(this).data().ref.lat+'/'+$(this).data().ref.lng,
						function(msg){
							$('#dialog-project-list').css({
								'top':$(me).data().y,
								'left':$(me).data().x,
								'transform-origin': '0% 0%',
								'-webkit-transform-origin': '0% 0%',
								'-o-transform-origin': '0% 0%',
								'-moz-transform-origin': '0% 0%',
								}).show().animate({top:16, left:100, width:752, height:500, opacity:1},'fast').data($(me).data());
							$('#dialog-project-list .log').html(msg);
						}
					);
					$.fancybox.hideLoading();
			});
			
		$('#dialog-project-list').on('click','.summary-row',controlMissionList);
		//$('#dialog-project-list').on('click','.detail-row',gotoMission);
		
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
		var y = Math.round(($(window).height()-40-$('#world-map').height())/2);
		if(y<0)y=0;
		$('#world-map').css('top',y);
	});
	
	function randMarkers(){
		var icons = new Array('#','@','!','$','%','&','*');
		var skills = new Array('php','CSS','MySQL','Rubby','PSD','Doc','PDF','Html','Java','C++');
		var lat,lng;
		for(i=0; i< 20; i++){
			lat = Math.round(Math.random()*120)-60;
			lng = Math.round(Math.random()*360)-180;
			loc = geoToPixel({'lat':lat, 'lng': lng});
			r = Math.round(Math.random()*255);
			g = Math.round(Math.random()*255);
			b = Math.round(Math.random()*255);
			addMarker(loc.x,loc.y,'test'+i,icons[Math.round(Math.random()*(icons.length-1))],'4<br/>'+skills[Math.round(Math.random()*(skills.length-1))],'rgb('+r+','+g+','+b+')',Math.random()*0.45+0.5,0);
		}
	}
	
	//*******************Start of marker filtering options******************/
	function latest(){
		$('#latest-loader').show();
		var type = 'latest';
		$('#filter-toolbar .selected').removeClass('selected');
		$('#filter-toolbar #latest').addClass('selected');
		$('#search').val('Find missions');
		clearMarkers();
		$.ajax({
			type: 'POST',
			dataType: "json",
			url:'/missions/ajax_mission_map_search',
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'type': type},
			success:function(msg){
				jobs = msg;
				renderMarkers();
				$('#latest-loader').hide();
			}
		});
	}
	
	function classification(){
		$('#classification-loader').show();
		var type = 'classification';
		$('#filter-toolbar .selected').removeClass('selected');
		$('#filter-toolbar #classification').addClass('selected');
		$('#search').val('Find missions');
		clearMarkers();
		$.ajax({
			type: 'POST',
			dataType: "json",
			url:'/missions/ajax_mission_map_classification',
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
		$('#search').val('Find missions');
		clearMarkers();
		$.ajax({
			type: 'POST',
			dataType: "json",
			url:'/missions/ajax_mission_map_skills',
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'type':type},
			success:function(msg){
				jobs = msg;
				renderMarkers();
				$('#skills-loader').hide();
			}
		});
	}
	
	function estimation(){
		$('#estimation-loader').show();
		var type = 'estimation';
		$('#filter-toolbar .selected').removeClass('selected');
		$('#filter-toolbar #estimation').addClass('selected');
		$('#search').val('Find missions');
		clearMarkers();
		$.ajax({
			type: 'POST',
			dataType: "json",
			url:'/missions/ajax_mission_map_estimation',
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'type':type},
			success:function(msg){
				jobs = msg;
				renderMarkers();
				$('#estimation-loader').hide();
			}
		});
	}
	
	function payout(){
		$('#payout-loader').show();
		var type = 'payout';
		$('#filter-toolbar .selected').removeClass('selected');
		$('#filter-toolbar #payout').addClass('selected');
		$('#search').val('Find missions');
		clearMarkers();
		$.ajax({
			type: 'POST',
			dataType: "json",
			url:'/missions/ajax_mission_map_payout',
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'type':type},
			success:function(msg){
				jobs = msg;
				renderMarkers();
				$('#payout-loader').hide();
			}
		});
	}
	//*******************End of marker filtering options******************/
	
	//*******************Start of rendering functions******************/
	function geoToPixel(geo){
		//TODO: change the map to google map style so lat and lng will remain in straight lines
		var x=0,y=0, width, height,lngS=-180,lngE=180,latS=-60,latE=70;
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
	
	function checkMarker(lat,lng,num)
	{
		var status = false;
		var marker = $('.marker');
		marker.each(function(){
			data = $(this).data().ref;
			if(data)
				if (data.lat == lat && data.lng == lng){
					status = true;
					elem = $(this).find('.arrow-down-container').css('border-top-color','green');
					setTimeout(function(){ elem.css('border-top-color','black'); },250);
						
					var el = $(this).find('.arrow-desc');
					var num = parseInt(el.text());
					el.text(num+1);
					
				}
		})
		if (!status) {
			renderMarker(lat,lng,num);
		}
	}
	
	function renderMarker(lat,lng,num){
		var loc;
		newid = $('.marker').size() - 1;
			
			loc = geoToPixel({'lat':jobs.lat, 'lng': jobs.lng});
			if (typeof console == "object") console.log(lat,lng);
			
			//var desc = jobs.num+(jobs.skill?"<br/>"+ucfirst(jobs.skill.substring(0,3)):'')+(jobs.days?"<br/>"+(jobs.days<1?"<1d":jobs.days+"d"):'')+(jobs.payout?"<br />"+(jobs.payout<1?"<10$":(jobs.payout<100?jobs.payout+'$':((jobs.payout/1000).toFixed(1)+'k$'))):'');
			//addMarker(loc.x,loc.y,'marker_'+i,catToIcon(jobs.class),desc,'grey',0.75,500,jobs);
			addMarker(lat,lng,'marker_'+newid,catToIcon(jobs.class),'1','orange',0.75,500,jobs);

	}
	
	//*******************End of rendering functions******************/
</script>
<!-- chat box-->
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
<!-- end of chat box-->
<script type="text/javascript" src="/public/js/jscrollpane.js"></script>
<script type="text/javascript" src="/public/js/codeArmy/duck.js"></script>
<?php $this->load->view('includes/CAFooter.php'); ?>