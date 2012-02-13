$(document).ready(function(){
		$('#sidemenubutton').click(function(){
			if($("#side_menu").hasClass("sidemenu_inactive")){//show side menu
				$(this).removeClass("sideopen").addClass("sideclose");
				$("#side_menu").animate({left: '0px'}).removeClass("sidemenu_inactive").addClass("sidemenu_active");				
			}
			else if($("#side_menu").hasClass("sidemenu_active")){//hide side menu
				$(this).removeClass("sideopen").addClass("sideopen");
				$("#side_menu").animate({left: '-300px'}).removeClass("sidemenu_active").addClass("sidemenu_inactive");				
			}
		})
		
		$('#bid_side_menu_button').click(function(){
			if($("#bid_side_menu").hasClass("sidemenu_inactive")){//show bid side menu
				$(this).removeClass("sideopen").addClass("sideclose");
				$("#bid_side_menu").animate({left: '0px'}).removeClass("sidemenu_inactive").addClass("sidemenu_active");			
			}
			else if($("#bid_side_menu").hasClass("sidemenu_active")){//hide bid side menu
				$(this).removeClass("sideopen").addClass("sideopen");
				$("#bid_side_menu").animate({left: '-300px'}).removeClass("sidemenu_active").addClass("sidemenu_inactive");
				$('#bid_side_menu .message_buble').each(function(){//close all bid messages
					$('.desc', this).hide();
					$('.summary', this).show();
					$(this).height(50);
					$(this).removeClass('show_desc');
				});	
			}
		})
		
		$('#message_side_menu_button').click(function(){
			if($("#message_side_menu").hasClass("sidemenu_inactive")){//show message side menu
				$(this).removeClass("sideopen").addClass("sideclose");
				$("#message_side_menu").animate({left: '0px'}).removeClass("sidemenu_inactive").addClass("sidemenu_active");			
			}
			else if($("#message_side_menu").hasClass("sidemenu_active")){//hide message side menu
				$(this).removeClass("sideopen").addClass("sideopen");
				$("#message_side_menu").animate({left: '-300px'}).removeClass("sidemenu_active").addClass("sidemenu_inactive");
				$('#message_side_menu .message_buble').each(function(){//close all message bubles
					$('.desc', this).hide();
					$('.summary', this).show();
					$(this).height(50);
					$(this).removeClass('show_desc');
				});
			}
		})
		
		$('#job_side_menu_button').click(function(){
			if($("#job_side_menu").hasClass("sidemenu_inactive")){//show job side menu
				$(this).removeClass("sideopen").addClass("sideclose");
				$("#job_side_menu").animate({left: '0px'}).removeClass("sidemenu_inactive").addClass("sidemenu_active");		
			}
			else if($("#job_side_menu").hasClass("sidemenu_active")){//hide job side menu
				$(this).removeClass("sideopen").addClass("sideopen");
				$("#job_side_menu").animate({left: '-300px'}).removeClass("sidemenu_active").addClass("sidemenu_inactive");				
				$('#job_side_menu .message_buble').each(function(){//close all job bubles
					$('.desc', this).hide();
					$('.summary', this).show();
					$(this).height(50);
					$(this).removeClass('show_desc');
				});
			}
		})
		
		setup_message_bubles();
		
		//keep selected entry in side menu open.
		selected = getCookie('active_menu');
		if(selected){
			$("#"+selected).addClass('projectmenuactive').show();
			$("#"+selected).next().show();
		}else{
			$(".projecttitle:first").addClass('projectmenuactive').show();
			$(".projectmenu:first").show();
		}
		
		//used in side menu for selecting a menu entry.
		$(".projecttitle").click(function(){
					if($(this).hasClass("projectmenuactive")){
						$(".projectmenu").slideUp(function(){$(".projecttitle").removeClass("projectmenuactive");});
					}
					else{
						$(".projectmenu").slideUp();
						$(".projecttitle").removeClass("projectmenuactive");
						$(this).next().slideDown();
						$(this).addClass("projectmenuactive");
						setCookie('active_menu',$(this).attr('id'));
					}
		});
		//hover effect for side menu items	
		$(".projectmenu ul li a").hover(function(){
				$(this).animate({paddingLeft : '10px'}, {queue: false})
			},function(){
				$(this).animate({paddingLeft : '0px'}, {queue: false})
		})
		
		resize();
		//setup scrolls for left menues
		$("#scroll_container3").mCustomScrollbar("vertical",0,"easeOutCirc",2.05,"auto","yes","no",0);
		$("#scroll_container1").mCustomScrollbar("vertical",0,"easeOutCirc",2.05,"auto","yes","no",0);
		$("#scroll_container2").mCustomScrollbar("vertical",0,"easeOutCirc",2.05,"auto","yes","no",0);
		$("#scroll_container").mCustomScrollbar("vertical",0,"easeOutCirc",2.05,"auto","yes","no",0);

});

function setup_message_bubles(){//minimizes bubles.
	$('.message_buble').each(function(){
		$('.desc', this).show();
		$('.summary', this).hide();
		$(this).data('height',$(this).height());
		$('.desc', this).hide();
		$('.summary', this).show();
		$(this).removeClass('show_desc');
		$(this).height(50);
	});
	//expand or minimize message bubles upon click.
	$('.message_buble').click(
		function(){
				if($(this).hasClass('show_desc')){
					$(this).find('.desc').hide();
					$(this).find('.summary').show();
					$(this).stop(true, true).animate({height:50},500, function(){
							$("#scroll_container").mCustomScrollbar("vertical",0,"easeOutCirc",2.05,"auto","yes","no",0);
							$("#scroll_container1").mCustomScrollbar("vertical",0,"easeOutCirc",2.05,"auto","yes","no",0);
							$("#scroll_container2").mCustomScrollbar("vertical",0,"easeOutCirc",2.05,"auto","yes","no",0);
							$("#scroll_container3").mCustomScrollbar("vertical",0,"easeOutCirc",2.05,"auto","yes","no",0);
						});
					$(this).removeClass('show_desc');
				}else{
					$(this).find('.desc').show();
					$(this).find('.summary').hide();
					$(this).stop(true, true).animate({height:$(this).data('height')},500, function(){
							$("#scroll_container").mCustomScrollbar("vertical",0,"easeOutCirc",2.05,"auto","yes","no",0);
							$("#scroll_container1").mCustomScrollbar("vertical",0,"easeOutCirc",2.05,"auto","yes","no",0);
							$("#scroll_container2").mCustomScrollbar("vertical",0,"easeOutCirc",2.05,"auto","yes","no",0);
							$("#scroll_container3").mCustomScrollbar("vertical",0,"easeOutCirc",2.05,"auto","yes","no",0);
						});
					$(this).addClass('show_desc');
				}
			}
	);
	
	//make inside links clickable
	$('.message_buble a').click(function(event){
		event.stopImmediatePropagation();
	});
	
	var me_message_buble="";
	//read message bubles.
	$('.message_buble').click(function(){
		me_message_buble = $(this);
		var data = $(this).attr('id');
		if($(this).hasClass('unread')){
			me_message_buble = $(this);
			$.post(
			'/myoffice/AjaxMessageRead',
			{ 'id': data, 'ci_csrf_token': getCookie('ci_csrf_token') },
			function(msg){
				$('#'+msg).removeClass('unread');
				$('#'+msg).addClass('read');
				me = me_message_buble.parent().parent().parent().parent().parent().find('.sideclose');
				val = me.html()-1;
				if (val<=0) val = '';
				me.html(val);
			});
		}
	});
}

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

//adjust custom scrolls
$(window).resize(function(){
	resize();
});

function resize() {
	$('#scroll_container').css('height',$(window).height()-$('.footer').height()-85);
	$('#scroll_container1').css('height',$(window).height()-$('.footer').height()-85);
	$('#scroll_container2').css('height',$(window).height()-$('.footer').height()-85);
	$('#scroll_container3').css('height',$(window).height()-$('.footer').height()-85);
}