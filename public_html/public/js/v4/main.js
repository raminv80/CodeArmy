$(document).ready(function(){
  var currentPosition = 0;
  var slideWidth = 860;
  var slides = $('.slide');
  var numberOfSlides = slides.length;

  // Remove scrollbar in JS
  $('#slidesContainer').css('overflow', 'hidden');

  // Wrap all .slides with #slideInner div
  slides.wrapAll('<div id="slideInner"></div>')
    // Float left to display horizontally, readjust .slides width
	.css({
      'float' : 'left',
      'width' : slideWidth
    });

  // Set #slideInner width equal to total width of all slides
  $('#slideInner').css('width', slideWidth * numberOfSlides);

  // Insert controls in the DOM
  $('#slideshow')
    .prepend('<span class="control" id="leftControl">Clicking moves left</span>')
    .append('<span class="control" id="rightControl">Clicking moves right</span>');

  // Hide left arrow control on first load
  currentPosition = 0;
  $('#slideInner').animate({
      'marginLeft' : slideWidth*(-currentPosition)
    });
  manageControls(currentPosition);
  
  // Create event listeners for .controls clicks
  $('.control')
    .bind('click', function(){
    // Determine new position
	currentPosition = ($(this).attr('id')=='rightControl') ? currentPosition+1 : currentPosition-1;
    if(currentPosition<0)currentPosition=0;
	if(currentPosition>=numberOfSlides)currentPosition=numberOfSlides-1;
	// Hide / show controls
    manageControls(currentPosition);
    // Move slideInner using margin-left
    $('#slideInner').animate({
      'marginLeft' : slideWidth*(-currentPosition)
    });
  });

  // manageControls: Hides and Shows controls depending on currentPosition
  function manageControls(position){
    // Hide left arrow if position is first slide
	if(position==0){ $('#leftControl').hide() } else{ $('#leftControl').show() }
	// Hide right arrow if position is last slide
    if(position==numberOfSlides-1){ $('#rightControl').hide() } else{ $('#rightControl').show() }
  }	
});

  function evolve(components){
	  //unbind events
	  $('*').not($(components).find('*')).unbind().each(function(){
		  if($(this).is("a")){$(this).click(function(){return false})}
		  if($(this).is("input")){$(this).attr('disabled', true);}
		  if($(this).is("textarea")){$(this).attr('disabled', true);}
	  });
  }
  
  var old_highlights = "";
  var old_exclude = "";
  
  function highlight(components, exclude){
	  components = $.trim(components);
	  exclude = $.trim(exclude);
	  if(components!='' || exclude!=''){
		  $('#modalDiv').hide().css({'height':$(document).height(), 'width': $(document).width()});
		  $('#modalDiv').fadeIn(1000);
	  }
	  if(old_highlights!=""){$(old_highlights).css({'position':'relative', 'z-index':0, '-webkit-box-shadow': '#fff 0px 0px 0px', '-moz-box-shadow': '#fff 0px 0px 0px','box-shadow': '#fff 0px 0px 0px'});}
	  if(components!=','){
		  $(components).css({'position':'relative', 'z-index':90, '-webkit-box-shadow': '#fff 0px 0px 100px', '-moz-box-shadow': '#fff 0px 0px 100px','box-shadow': '#fff 0px 0px 100px'});
		  old_highlights = components;
	  }
	  if(old_exclude!=""){$(old_exclude).css({'position':'relative', 'z-index':0});}
	  if(exclude!=','){
		  $(exclude).css({'position':'relative', 'z-index':90});
		  old_exclude = exclude;
  	  }
	  return $(components).offset();
  }