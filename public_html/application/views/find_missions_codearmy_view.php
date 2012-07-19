<?php $cell_size=5;$cell_pad=1;?>
<?php $this->load->view('includes/CAHeader.php'); ?>
    <div id="find-mission-area" style="width:800px;height:600px; border:1px solid red;">
    	<img id="world-map" src="/public/images/codeArmy/mymission/world-map.jpg" width="800" height="600" />
    </div>
<style>
	#find-mission-area{position:relative; margin:5px auto;}
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