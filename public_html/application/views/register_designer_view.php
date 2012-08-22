<?php $this->load->view('includes/CAHeader.php'); ?>

<div id="Register_design_MainContent" class="MainContent">
  <div id="dialog-holder">
    <div id="dialog-title"></div>
    <div id="timer"><span id="counter">60</span> <span style="font-size:18pt">sec</span></div>
    <div id="dialog">
      <div class="title">Oh really?</div>
      <div class="text">
        <p>"Orrrite soldier, you told us you're good with your hands.<br />
          Let's see you recreate our logo.</p>
        <p>Click and swipe with your mouse to fill in the color before it fades away. </p>
        <p>you got 60 seconds!</p>
      </div>
      <div id="brush">
        <ul>
          <li class="brush-sel" id="set-brush">Brush</li>
          <li class="eraser" id="set-eraser">Eraser</li>
          <li class="restart">Restart</li>
        </ul>
        <div id="sketch">
          <canvas width="223px" height="191px" id="canvas">If you see this then your browser is too old for our awesomeness!</canvas>
        </div>
      </div>
      <div id="submit-holder"> <a href="javascript: void(0)" id="submit-button">Submit</a> </div>
    </div>
  </div>
</div>
<div id="dialog-message" class="dialog">
  <p> "Well i aint no pansy art teacher, but it looks good enough to me. </p>
  <p style="font-size:24pt; margin-top:10px;"> You're in!" </p>
  <div class="medal-message"> <img src="/public/images/codeArmy/badges/html5.png" alt="html5 badge" align="left" />
    <div style="padding:35px">
      <p style="font-size:18pt">You've been promoted to</p>
      <p style="font-size:24pt; margin-top:10px;"><img src="/public/images/codeArmy/badges/private1star.png" alt="private 1 star" /></p>
    </div>
    <div style="margin-top:58px"><a class="CAbutton" href="javascript: void(0);" onclick="proceed()" id="medal-message-continue">Continue</a></div>
  </div>
</div>
<script type="text/javascript">
	$('#set-brush').click(function(){sketcher.setBrush(1)});
	$('#set-eraser').click(function(){sketcher.setBrush(2)});
	//preload images function
	function preload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        (new Image()).src = this;
		});
	}
	
	//the effect to be executed once page load.
    function loadEffect(){
        $('#Register_design_MainContent').fadeIn('slow',function(){
                                                            $('#dialog').slideDown();
                                                          });
    }
	
	//list of images to be preloaded
    preload([
		'/public/images/codeArmy/designer_test/brush_hover.png',
		'/public/images/codeArmy/designer_test/eraser_hover.png',
		'/public/images/codeArmy/designer_test/restart_hover.png',
		'/public/images/codeArmy/designer_test/submit_hover.png',
    ]);
    </script> 
<script type="text/javascript">
	//canvas related logic
var sketcher = null;
var brush = null;
var time = 0;
//timer is for grid rendering and timer1 is for jumping effect
var timer,timer1;
var pause = false;
$(window).focus(function(){pause=false;});
$(window).blur(function(){pause=true;});

$(document).ready(function(e) {
	brush1 = new Image();
	brush2 = new Image();
	brush1.src = '/public/images/codeArmy/brush.png';
	brush2.src = '/public/images/codeArmy/eraser.png';
	brush = {brush1: brush1, brush2: brush2};
	brush1.onload = function(){
		sketcher = new Sketcher( "canvas", brush );
	}
	$('#sketch').mousedown(function(){enableCounter();});	
	/*if (Modernizr.touch) {
		alert('touch');
		$('#sketch').touchstart(function(){enableCounter();});	
	}else {
		alert('no touch');
		$('#sketch').mousedown(function(){enableCounter();});	
	}*/
	$('.restart').click(function(){
		sketcher.clear();
	});
	$('#submit-button').mouseover(function(){ if(timer1)clearInterval(timer1); $('#submit-button').stop(true,true);});
	$('*').disableSelection();
});

//things happen when continue button on modal dialog is pressed
function proceed(){
	$.ajax({
		type: 'POST',
		url: '/register/Ajax_reg_div_designer',
		data: {'csrf_workpad': getCookie('csrf_workpad') },
		success: function(msg){
			if(msg=="success"){
				$.fancybox.close();
			}else{
				alert("Error: registering designer division. ");
				if (typeof console == "object") console.log(msg);
			}
		}
	});	
}

function nextStep(){
	window.location = '/my-profile';
}

//counter is for counter clock
var counter = 'disable', counterID;
function enableCounter(){
	if(counter=='disable'){
		$('#sketch').fadeOut(120000);
		counter = 60;
		counterID = setInterval(counterFN, 1000);
		$('#submit-button').hide().css({opacity:1}).fadeIn('fast');
		$('#submit-button').click(function(){check(this)});
	}
}
function counterFN(){
	if(counter>0){
		counter = counter-1;
		$('#counter').html(counter);
	}else{
		counter='timeout';
		sketcher.renderFunction = null;
		clearInterval(counterID);
		check(null);
	}
}

var finished=1;
function check(el){
	$('#timer').html('Checking');
	$('#sketch').stop(true,true).fadeIn('fast', function(){
			$('#timer').html('Done');
			if(el){
				finished = 'submit';
				counter='timeout';
				//TODO: submit
				//window.location='';
				$.fancybox.open({
					href : '#dialog-message',
					type : 'inline',
					padding : 0,
					margin: 0,
					autoSize: true,
					closeBtn: false,
					closeClick: false,
					modal: true,
					'overlayShow': true,
					'overlayOpacity': 0.5, 
					afterClose: function(){nextStep()},
					openMethod : 'dropIn',
					openSpeed : 250,
					closeMethod : 'dropOut',
					closeSpeed : 150,
					nextMethod : 'slideIn',
					nextSpeed : 250,
					prevMethod : 'slideOut',
					prevSpeed : 250,
					scrolling: 'no'
				});
				
			}else{
				finished = 'jump';
				timer1 = setInterval("jumping()", 3000);
				jumping();
			}
		});

}

function jumping(){
	if(!pause)$('#submit-button').stop(true,false).effect("bounce", {times:2, distance: 10}, 200);
}

function Sketcher( canvasID, brushes ) {
	brushImage = brushes.brush1;
	this.brushes = brushes;
	this.renderFunction = (brushImage == null || brushImage == undefined) ? this.updateCanvasByLine : this.updateCanvasByBrush;
	this.brush = brushImage;
	this.touchSupported = Modernizr.touch;
	this.canvasID = canvasID;
	this.canvas = $("#"+canvasID);
	this.context = this.canvas.get(0).getContext("2d");	
	this.context.strokeStyle = "#ffffff";
	this.context.lineWidth = 3;
	this.lastMousePoint = {x:0, y:0};
    
	if (this.touchSupported) {
		this.mouseDownEvent = "touchstart";
		this.mouseMoveEvent = "touchmove";
		this.mouseUpEvent = "touchend";
	}
	else {
		this.mouseDownEvent = "mousedown";
		this.mouseMoveEvent = "mousemove";
		this.mouseUpEvent = "mouseup";
	}
	
	this.canvas.bind( this.mouseDownEvent, this.onCanvasMouseDown() );
}

Sketcher.prototype.onCanvasMouseDown = function () {
	var self = this;
	return function(event) {
		self.mouseMoveHandler = self.onCanvasMouseMove()
		self.mouseUpHandler = self.onCanvasMouseUp()

		$(document).bind( self.mouseMoveEvent, self.mouseMoveHandler );
		$(document).bind( self.mouseUpEvent, self.mouseUpHandler );
		
		self.updateMousePosition( event );
		self.renderFunction( event );
	}
}

Sketcher.prototype.onCanvasMouseMove = function () {
	var self = this;
	return function(event) {

		self.renderFunction( event );
     	event.preventDefault();
    	return false;
	}
}

Sketcher.prototype.onCanvasMouseUp = function (event) {
	var self = this;
	return function(event) {

		$(document).unbind( self.mouseMoveEvent, self.mouseMoveHandler );
		$(document).unbind( self.mouseUpEvent, self.mouseUpHandler );
		
		self.mouseMoveHandler = null;
		self.mouseUpHandler = null;
	}
}

Sketcher.prototype.updateMousePosition = function (event) {
 	var target;
	if (this.touchSupported) {
		target = event.originalEvent.touches[0]
	}
	else {
		target = event;
	}

	var offset = this.canvas.offset();
	this.lastMousePoint.x = target.pageX - offset.left;
	this.lastMousePoint.y = target.pageY - offset.top;
}

Sketcher.prototype.updateCanvasByLine = function (event) {
	this.context.beginPath();
	this.context.moveTo( this.lastMousePoint.x, this.lastMousePoint.y );
	this.updateMousePosition( event );
	this.context.lineTo( this.lastMousePoint.x, this.lastMousePoint.y );
	this.context.stroke();
}

Sketcher.prototype.updateCanvasByBrush = function (event) {
	var halfBrushW = this.brush.width/2;
	var halfBrushH = this.brush.height/2;
	var start = { x:this.lastMousePoint.x, y: this.lastMousePoint.y };
	this.updateMousePosition( event );
	var end = { x:this.lastMousePoint.x, y: this.lastMousePoint.y };
	
	var distance = parseInt( Trig.distanceBetween2Points( start, end ) );
	var angle = Trig.angleBetween2Points( start, end );
	
	var x,y;
	for ( var z=0; (z<=distance || z==0); z++ )
	{
		x = start.x + (Math.sin(angle) * z) - halfBrushW;
		y = start.y + (Math.cos(angle) * z) - halfBrushH;
		//if (typeof console == "object") console.log( x, y, angle, z );
		this.context.drawImage(this.brush, x, y);
	}
}

Sketcher.prototype.toString = function () {
	var dataString = this.canvas.get(0).toDataURL("image/png");
	var index = dataString.indexOf( "," )+1;
	dataString = dataString.substring( index );
	return dataString;
}

Sketcher.prototype.toDataURL = function () {
	var dataString = this.canvas.get(0).toDataURL("image/png");
	return dataString;
}

Sketcher.prototype.clear = function () {
	var c = this.canvas[0];
	this.context.clearRect( 0, 0, c.width, c.height );
}

Sketcher.prototype.setBrush = function (i) {
	switch(i){
		case 1: this.brush = this.brushes.brush1;
			$('.brush').removeClass('brush').addClass('brush-sel');
			$('.eraser-sel').removeClass('eraser-sel').addClass('eraser');
		break;
		case 2: this.brush = this.brushes.brush2;
			$('.brush-sel').removeClass('brush-sel').addClass('brush');
			$('.eraser').removeClass('eraser').addClass('eraser-sel');
		break;
	}
}

var Trig = {
	distanceBetween2Points: function ( point1, point2 ) {
		
		var dx = point2.x - point1.x;
		var dy = point2.y - point1.y;
		return Math.sqrt( Math.pow( dx, 2 ) + Math.pow( dy, 2 ) );	
	},
	
	angleBetween2Points: function ( point1, point2 ) {
	
		var dx = point2.x - point1.x;
		var dy = point2.y - point1.y;	
		return Math.atan2( dx, dy );
	}
}
</script>
<?php $this->load->view('includes/CAFooter.php'); ?>
