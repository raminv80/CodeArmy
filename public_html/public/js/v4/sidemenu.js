$(document).ready(function(){
		$('#sidemenubutton').click(function(){
			if($("#side_menu").hasClass("sidemenu_inactive")){
				$(this).removeClass("sideopen").addClass("sideclose");
				$("#side_menu").animate({left: '0px'}).removeClass("sidemenu_inactive").addClass("sidemenu_active");				
			}
			else if($("#side_menu").hasClass("sidemenu_active")){
				$(this).removeClass("sideopen").addClass("sideopen");
				$("#side_menu").animate({left: '-300px'}).removeClass("sidemenu_active").addClass("sidemenu_inactive");				
			}
		})
		
		selected = getCookie('active_menu');
		if(selected){
			$("#"+selected).addClass('projectmenuactive').show();
			$("#"+selected).next().show();
		}else{
			$(".projecttitle:first").addClass('projectmenuactive').show();
			$(".projectmenu:first").show();
		}
		
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
			
			$(".projectmenu ul li a").hover(function(){
				$(this).animate({paddingLeft : '10px'}, {queue: false})
			},function(){
				$(this).animate({paddingLeft : '0px'}, {queue: false})
			})
		
});

function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
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


$(window).resize(function(){$('#sidemenucontent').height($(window.height()-220));});