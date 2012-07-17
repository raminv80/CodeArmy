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
	$('#debugger').slideToggle('fast');  
  }
});