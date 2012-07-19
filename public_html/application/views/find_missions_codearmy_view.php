<?php $cell_size=5;$cell_pad=1;?>
<?php $this->load->view('includes/CAHeader.php'); ?>
    <div id="find-mission-area">
    	<div id="world-map">
 	   		<img id="world-map-img" src="/public/images/codeArmy/mymission/world-map.png" width="999" height="532" />
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
		randMarkers();
		addMarker(100,100,'test','*','12<br/>CSS','#0ff',0.5,0);
		addMarker(500,200,'test','#','4<br/>PHP MySQL HTML CSS JQuery','#f00',0.7,0);
		$('.toolbar').draggable({ containment: '#wrapper' });
		$(window).resize();
	});
	$(window).resize(function() {
		$('#find-mission-area').css('height',$(window).height()-40);
		var y = Math.round(($(window).height()-40-$('#world-map-img').attr('height'))/2);
		if(y<0)y=0;
		$('#world-map').css('top',y);
	});
	
	function randMarkers(){
		var icons = new Array('#','@','!','$','%','&','*');
		var skills = new Array('php','CSS','MySQL','Rubby','PSD','Doc','PDF','Html','Java','C++');
		for(i=0; i< 20; i++){
			r = Math.round(Math.random()*255);
			g = Math.round(Math.random()*255);
			b = Math.round(Math.random()*255);
			addMarker(Math.round(Math.random()*$('#world-map-img').width()),Math.round(Math.random()*$('#world-map-img').height()),'test'+i,icons[Math.round(Math.random()*icons.length)],'4<br/>'+skills[Math.round(Math.random()*skills.length)],'rgb('+r+','+g+','+b+')',0.7,0);
		}
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
				'top':y,
				'left':x
			}).fadeIn(speed);
		template.data({'scale':scale,'x':x,'y':y,'color':color});
		container.append(template);
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
				'-webkit-transition': '0.05s ease-out'
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
				'-webkit-transition': '0.05s ease-out'
				})
			});
	}
	/*var canvas,cell_size=<?=$cell_size?>, cell_pad=<?=$cell_pad?>;
	function loadEffect(){}
	$(function(){$(window).resize();});
	$(window).resize(function() {
		$('#find-mission-area').css('height',$(window).height()-40);
		$('#find-mission-area').css('width',$(window).width()-10);
		//$('#find-mission-area').attr({'width':$('#find-mission-area').width(),'height':$('#find-mission-area').height()})
		//renderMap();
		renderDivs();
	});
	var s='';
	function renderDivs(){
		for(var col=0; (col*(cell_size+cell_pad))<($('#find-mission-area').width()-cell_size-cell_pad+1); col++){
			for(var row=0; (row*(cell_size+cell_pad))<($('#find-mission-area').height()-cell_size-cell_pad+1); row++){
				s=s+'<div id="cell_col_'+col+'_row_'+row+'" class="cell" style="left:'+col*(cell_size+cell_pad)+'px;top:'+row*(cell_size+cell_pad)+'px;"></div>';
			}
		}
		$('#find-mission-area').html(s);
		$('.cell').click(function(){$(this).hide();});
	}
	
	function renderMap(){
		var c=document.getElementById("find-mission-area");
		canvas = c.getContext("2d");
		canvas.width = canvas.width;
		canvas.fillStyle="#09dbe0";
		for(var i=0; i<$('#find-mission-area').height(); i=i+6)
			for(var j=0; j<$('#find-mission-area').width(); j=j+6){
				canvas.fillRect(j,i,5,5);	
			}
	}*/
</script>
<?php $this->load->view('includes/CAFooter.php'); ?>