<?php $this->load->view('includes/CAHeader.php'); ?>
    <div id="find-mission-area">
    	<div id="world-map">
 	   		<img id="world-map-img" src="/public/images/codeArmy/mymission/world-map.png" width="999" height="532" />
            <!-- dialogs -->
            <!-- project list -->
            <div id="dialog-project-list" class="dialog">
            	<div class="container">
                    <div class="dialog-close-button"></div>
                    List of projects
                </div>
            </div>
            <!-- end of project list -->
            <!-- end of dialogs -->
        </div>
    </div>
    <div id="filter-toolbar" class="toolbar">
    </div>
    <div id="profile-toolbar" class="toolbar">
    </div>
    <!-- marker template -->
    <div id="marker-template" class="marker" style="display:none;">
        	<div class="marker-icon">#</div>
        	<div class="arrow-desc">12<br/>PHP</div>
        	<div class="arrow-down-container">
            	<div class="arrow-down">
	            </div>
            </div>
    </div>
    <!-- end of marker template -->
<style>
	#dialog-project-list{
		width:800px;
		height:500px;
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
		position:absolute;
		top:200px;
		left:200px;
		cursor:pointer;
		-webkit-transform-style: preserve-3d;
		-webkit-backface-visibility: hidden;
		transform-style: preserve-3d;
		backface-visibility: hidden;
		-moz-transform-style: preserve-3d;
		-moz-backface-visibility: hidden;
		-o-transform-style: preserve-3d;
		-o-backface-visibility: hidden;
	}
	#filter-toolbar{
		position:absolute;
		background:url(/public/images/codeArmy/mymission/fillter-toolbar-temp.jpg);
		width:141px;height:322px;
		top:10px;left:30px;
		z-index:10001;
	}
	#profile-toolbar{
		position:absolute;
		background:url(/public/images/codeArmy/mymission/profile-toolbar-temp.png) no-repeat;
		width:160px;height:329px;
		top:10px;right:30px;
		z-index:10000;
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
	$(function(){
		//create some markers
		randMarkers();
		var loc = geoToPixel({'lat':3.152480, 'lng': 101.717270});
		addMarker(loc.x,loc.y,'t1','*','12<br/>Ramin','#0ff',0.5,0);
		var loc = geoToPixel({'lat':70, 'lng': 0});
		addMarker(loc.x,loc.y,'t3','*','12<br/>top','#0ff',0.5,0);
		var loc = geoToPixel({'lat':-60, 'lng': 0});
		addMarker(loc.x,loc.y,'t2','#','4<br/>PHP MySQL HTML CSS JQuery','#f00',0.7,0);
		$('.toolbar').draggable({ containment: '#wrapper' });
		
		//initial dialog close button
		$('.dialog-close-button').click(function(){
			$(this).parents('.dialog').hide();
		});
		
		//run window resize
		$(window).resize();
	});
	$(window).resize(function() {
		//vertical cenerlise world map
		$('#find-mission-area').css('height',$(window).height()-40);
		var y = Math.round(($(window).height()-40-$('#world-map-img').attr('height'))/2);
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
	function addMarker(x,y,id,icon,desc,color,scale,speed){
		var template = $('#marker-template').clone();
		var container = $('#world-map');
		template.attr('id',id);
		template.find('.marker-icon').html(icon);
		template.find('.arrow-desc').html(desc);
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
		console.log()
		template.css({
				'top':y,
				'left':x
			}).fadeIn(speed);
		template.data({'scale':scale,'x':x,'y':y,'color':color});
		$('.marker').hover(function(){
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
				})
			},function(){
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
			});
		$('.marker').click(function(){
			//TODO: open project list
			console.log($(this).data());
			$('#dialog-project-list').show();
		});
			
	}
</script>
<?php $this->load->view('includes/CAFooter.php'); ?>