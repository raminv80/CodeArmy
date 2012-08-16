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
	 var pusher = new Pusher('deb0d323940b00c093ee'); // Replace with your app key
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

//chat
chat_channel.bind('message', function(data) {
  $('.chat').show().find('ul').append('<li>'+data+'</li>');
});

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