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
		
		$(".projectblock .projecttitle:first").addClass('projectmenuactive');
		$(".projectblock .projectmenu:first").show();
		
		$(".projecttitle").click(function(){
				if($(this).hasClass("projectmenuactive")){
				}
				else{
					$(".projectmenu").slideUp();
					$(".projecttitle").removeClass("projectmenuactive");
					$(this).next().slideDown();
					$(this).addClass("projectmenuactive");
				}
		});
		
		$(".projectmenu ul li a").hover(function(){
			$(this).animate({paddingLeft : '10px'}, {queue: false})
		},function(){
			$(this).animate({paddingLeft : '0px'}, {queue: false})
		})
})