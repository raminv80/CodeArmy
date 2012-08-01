<?php $this->load->view('includes/CAHeader.php'); ?>
<!--TODO: add ajax loader icons -->
<div id="wrapper">
  <div id="find-mission-area">
    <div id="world-map"> <img id="world-map-img" src="/public/images/codeArmy/mymission/world-map.png" width="999" height="532" /> 
      <!-- project list -->
      <div id="dialog-project-list" class="dialog">
        <div class="container">
          <div class="dialog-close-button"></div>
          List of projects
          <div class="log"></div>
      	</div>
      </div>
      <!-- end of project list --> 
    </div>
  </div>
</div>
<?php $this->load->view('includes/duck.php'); ?>
<?php $this->load->view('includes/CAMapFooter.php'); ?>
<!-- dialogs -->
<div id="filter-toolbar" class="toolbar"> <a href="#" id="filter-toolbar-logo"></a>
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
  <div id="avatar-block"> <a href="/profile"><img src="/public/images/codeArmy/mymission/profile_toolbar/avatar.png" id="avatar" alt="avatar" /></a>
    <ul id="status-icons">
      <li><a href="#"><img title="Missions" src="/public/images/codeArmy/mymission/profile_toolbar/mission-status.png" /></a>
        <div class="status"><?=$myActiveMissions?></div>
      </li>
      <li><a href="#"><img title="Messages" src="/public/images/codeArmy/mymission/profile_toolbar/message-status.png" /></a>
        <div class="status">3</div>
      </li>
      <li><a href="#"><img title="Notifications" src="/public/images/codeArmy/mymission/profile_toolbar/notification-status.png" /></a>
        <div class="status">2</div>
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
      <div class="level">Level <?=$skill["point"]?></div>
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
        	<option value="" selected="selected">Please select one</option>
            <option value="web">Website</option>
            <option value="spa">Web Application</option>
            <option value="mob">Mobile App</option>
            <option value="win">Windows App</option>
            <option value="mac">MAC OS App</option>
            <option value="game">Game</option>
        </select>
        </div>
    </div>
</div>
<div id="MissionCreateDetail" class="dialog">
	<!--TODO for Reza-->
</div>
<!-- end of dialogs --> 

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
<style>
	* {
		transform-style: preserve-3d;
		backface-visibility: hidden;
		-moz-transform-style: preserve-3d;
		-moz-backface-visibility: hidden;
		-o-transform-style: preserve-3d;
		-o-backface-visibility: hidden;
	}
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
		background:#F00;
		color:#FFF;
		display:none;
		position:absolute;
		top:16px;
		left:100px;
		z-index:10002;
	}
	.dialog{padding:0}
	.dialog .container{
		position:relative;
		width:100%;
		height:100%;
	}
	.dialog .dialog-close-button{
		position:absolute;
		top:0;right:0;
		width:25px;
		height:25px;
		background:#0F0;
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
		width:<?=$cell_size?>px;height:<?=$cell_size?>px;
		position:absolute;
		top:0;
		left:0;
	}
</style>
<script>
	function loadEffect(){}
	
	var oldValue, jobs = <?php echo json_encode($works); ?>;
	
	$(function(){
		//create some markers
		/*randMarkers();
		var loc = geoToPixel({'lat':3.152480, 'lng': 101.717270});
		addMarker(loc.x,loc.y,'t1','*','12<br/>Ramin','#0ff',0.5,0);
		var loc = geoToPixel({'lat':70, 'lng': 0});
		addMarker(loc.x,loc.y,'t3','*','12<br/>top','#0ff',0.5,0);*/
		renderMarkers();
		$('#world-map .marker').fadeIn('slow');
		$('.toolbar').draggable({ containment: '#wrapper' });
		$('.toolbar [title]').tipsy();
		initializeEvents();
		$('select').selectmenu({'width':'202', 'style':'popup'});
		//run window resize
		$(window).resize();
	});
	
	function renderMarkers(){
		var loc;
		for(i=0; i<jobs.length;i++){
			loc = geoToPixel({'lat':jobs[i].lat, 'lng': jobs[i].lng});
			var desc = jobs[i].num+(jobs[i].skill?"<br/>"+ucfirst(jobs[i].skill.substring(0,3)):'')+(jobs[i].days?"<br/>"+(jobs[i].days<1?"<1d":jobs[i].days+"d"):'')+(jobs[i].payout?"<br />"+(jobs[i].payout<1?"<10$":(jobs[i].payout<100?jobs[i].payout+'$':((jobs[i].payout/1000).toFixed(1)+'k$'))):'');
			addMarker(loc.x,loc.y,'marker_'+i,catToIcon(jobs[i].class),desc,'grey',0.75,500,jobs[i]);
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
				default: icon = cat;
			}
		}
		return icon;
	}
	
	function initializeEvents(){
		$('select').bind("change", function(){      
    		MissionCreate($('select').val());
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
					$('#dialog-project-list').css({
						'top':$(this).data().y,
						'left':$(this).data().x,
						'transform-origin': '0% 0%',
						'-webkit-transform-origin': '0% 0%',
						'-o-transform-origin': '0% 0%',
						'-moz-transform-origin': '0% 0%',
						}).show().animate({top:16, left:100, width:800, height:500, opacity:1},'fast').data($(this).data());
					$('#dialog-project-list .log').html(JSON.stringify($('#dialog-project-list').data(), null, 4));
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
		var y = Math.round(($(window).height()-40-$('#world-map-img').attr('height'))/2);
		if(y<0)y=0;
		$('#world-map').css('top',y);
	});
	
	
	//******************************Helpers************************************/
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
		height = $('#world-map-img').height();
		width = $('#world-map-img').width();
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
<script type="text/javascript" src="/public/js/codeArmy/duck.js"></script>
<?php $this->load->view('includes/CAFooter.php'); ?>