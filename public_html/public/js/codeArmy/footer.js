// JavaScript Document
$(window).load(loadEffect);
$(function() {
	$( ".datepicker" ).datepicker({ 
		dateFormat: "yy-mm-dd",
		yearRange: "-80:-9",
		showOn: "both",
		buttonImage: "/public/images/codeArmy/signup/calendar-button.jpg", 
    	buttonImageOnly: true,
		changeMonth: true, 
		changeYear: true,
		defaultDate: "-20y"
	 });
	 $(".datepicker").val("yyyy-mm-dd");
	 $(".datepicker").css({color:'#666'});
	 $(".datepicker").focus(function(){$(this).css({color:'#999'}).val('').mask("9999-99-99",{placeholder:" "});});
	 $('.fancybox').fancybox({
				type:'iframe',
				scrolling: 'no'
			});
	var chat_channel = pusher.subscribe('chat');
	chat_channel.bind('message', function(data) {
		$('.chat').show().find('ul').append('<li>'+data+'</li>');
	});
	 var map_channel = pusher.subscribe('map-channel');
	 map_channel.bind('map-new',updateFeed(data));
	 var mission = pusher.subscribe('mission');
	 mission.bind_all(function(evnt,data){
		 if(evnt.indexOf('accept-mission')>-1)updateFeed(data);
	 });
	 var bid_channel = pusher.subscribe('bid');
	 bid_channel.bind_all(function(evnt,data) {
		  console.log(evnt,data);
		  if(evnt.indexOf('accept-bid')>-1){
			if(data.bidder_id==logged_user_id)
			$( "#dialog-accept" ).dialog({
				resizable: false,
				modal: true,
				width: 500,
				buttons: {
					"Not Now": function() {
						$( this ).dialog( "close" );
					},
					"Proceed": function(){
						window.location='/missions/my_missions';
					}
				}
			});
		  }
		});
});

function updateFeed(data){
	$('#live-feed').hide("slide", { direction: "left" }, 1000).html(data.time+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mission "'+data.work_title+'"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;published by&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+data.username).show("slide", { direction: "right" }, 1000);
}
//cookie management
function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + "; path=/" + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
function getCookie(c_name)
{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
	  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	  x=x.replace(/^\s+|\s+$/g,"");
	  if (x==c_name)
		{
		return unescape(y);
		}
	  }
	  return false;
}

$(window).keypress(function() {
  if ( event.which == "`".charCodeAt(0) ) {
	 $('#debugger').slideToggle();
  }
});