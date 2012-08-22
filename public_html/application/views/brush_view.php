<?php $this->load->view('includes/header4'); ?>
<section id="Projects">
<div class="WP-main" style="margin-top:100px;">
	<ul>
	<li><a href="javascript: void(0)" id="clear">Clear</a></li>
    <li><a href="javascript: void(0)" onClick="sketcher.setBrush(1)">White Brush</a></li>
    <li><a href="javascript: void(0)" onClick="sketcher.setBrush(2)">Black Brush</a></li>
    <li><a href="javascript: void(0)" onClick="check()">Submit</a></li>
    </ul>
    <div id="res" style="display:none">Good Boy!</div>
    <div style="position: relative;">
     <canvas id="sketch1" width="256" height="256" class="sketch"></canvas>
     <canvas id="sketch2" width="260" height="260" class="sketch"
       style="display: none;position:absolute; top:0; left:0; z-index:1;"></canvas>
    </div>
</div>
</section>
<style>
#sketch1{
border-radius: 128px; 
-moz-border-radius: 128px; 
-webkit-border-radius: 128px;
border:1px solid black;
background-color: black; 	
}
</style>
<script>
var sketcher = null;
var brush = null;

$(document).ready(function(e) {
	brush1 = new Image();
	brush2 = new Image();
	  brush1.src = '/public/images/brush.png';
	  brush2.src = '/public/images/brush2.png';
	  brush = {brush1: brush1, brush2: brush2};
	  brush1.onload = function(){
		sketcher = new Sketcher( "sketch1", brush );
	  }
	$('#clear').click(function(){
			sketcher.clear();
		});
});

var time = 0;
var timer;
function check(){
	$('#sketch2').show();
	timer = setInterval(render, 33);
}
function render(){
	time+=33;
var context = $('#sketch2').get(0).getContext("2d");
	context.beginPath();
	context.strokeStyle = 'green';
		i = Math.round(time/33)*10;
		if(i<=250){
			context.moveTo(i,0);
			context.lineTo(i,260);
			context.moveTo(0,i);
			context.lineTo(260,i);
		}else{
			$('#sketch2').hide(200);
			$('#sketch1').hide(300, function(){$('#res').show(300);});
			//$('#sketch2').hide(200);
			clearInterval(timer);	
		}
	context.stroke();	
}

function Sketcher( canvasID, brushes ) {
	brushImage = brushes.brush1;
	this.brushes = brushes;
	this.renderFunction = (brushImage == null || brushImage == undefined) ? this.updateCanvasByLine : this.updateCanvasByBrush;
	this.brush = brushImage;
	//this.touchSupported = Modernizr.touch;
	this.canvasID = canvasID;
	this.canvas = $("#"+canvasID);
	this.context = this.canvas.get(0).getContext("2d");	
	this.context.strokeStyle = "#000000";
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
		case 1: this.brush = this.brushes.brush1; break;
		case 2: this.brush = this.brushes.brush2; break;	
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
<?php $this->load->view('includes/footer5'); ?>