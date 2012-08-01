// JavaScript Document
//library
function distance(x0, y0, x1, y1) {
	var xDiff = x1-x0;
	var yDiff = y1-y0;
	
	return Math.sqrt(xDiff*xDiff + yDiff*yDiff);
}

$(document).ready(function() {
	var proximity = 60;
	var iconSmall = 35, iconLarge = 55; //css also needs changing to compensate with size
	var iconDiff = (iconLarge - iconSmall);
	var mouseX, mouseY;
	var dock = $("#dock");
	var animating = false, redrawReady = false;
	
	$(document.body).removeClass("no_js");
	
	//below are methods for maintaining a constant 60fps redraw for the dock without flushing
	$(document).bind("mousemove", function(e) {
		if (dock.is(":visible")) {
			mouseX = e.pageX;
			mouseY = e.pageY;
		
			redrawReady = true;
			registerConstantCheck();
		}
	});
	
	function registerConstantCheck() {
		if (!animating) {
			animating = true;
			
			window.setTimeout(callCheck, 30);
		}
	}
	
	function callCheck() {
		sizeDockIcons();
		
		animating = false;
	
		if (redrawReady) {
			redrawReady = false;
			registerConstantCheck();
		}
	}
	
	//do the maths and resize each icon
	function sizeDockIcons() {
		dock.find("li").each(function() {
			//find the distance from the center of each icon
			var centerX = $(this).offset().left + ($(this).outerWidth()/2.0);
			var centerY = $(this).offset().top + ($(this).outerHeight()/2.0);
			
			var dist = distance(centerX, centerY, mouseX, mouseY);
			
			//determine the new sizes of the icons from the mouse distance from their centres
			var newSize =  (1 - Math.min(1, Math.max(0, dist/proximity))) * iconDiff + iconSmall;
			$(this).find("a").css({width: newSize});
		});
	}
});