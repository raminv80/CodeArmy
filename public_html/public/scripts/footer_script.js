// Footer JavaScript Document
// Developed by Ramin Vakilian ramin@motionworks.com.my

	$('.dashboard-filter').change(function(){
		$('#filter-option').submit();
	});
	
	$('a.submit').click(function(){
		var form = $(this).parents('form:first');
		form.submit();
	});
	
	var dialog = $('.dialog'), pos, width;
	
	//check if an element is visible considering current vertical scroll situation
	function checkvisible( elm ) {
    var vpH = $(window).height(), // Viewport Height
        st = $(window).scrollTop(), // Scroll Top
        y = $(elm).offset().top;

    return (y > (vpH + st));
	}
	
	var dialogs = new Array();
	var showDialog = new Array();
	
	$(function(){
		initDialogs();
		initAlert();
	});
	
	function initDialogs(){
		$('.dialog').each(function(index){
			dialogs.push($(this).html());
			showDialog.push(true);
			dialog = $(this);
			dialog.hide();
			target = dialog.attr('id');
			target = $('.dialog_'+target);
			pic="";margin="";
			if(target.offset()){
				dialog.click(function(){
						if($(this).is(':visible')){
							target = $(this).attr('id');
							target = $('.dialog_'+target);
							$('html,body').animate({scrollTop: target.offset().top-100},'fast');
						}
					});
				//if show at top
				if((target.offset().top-dialog.height())>$(window).scrollTop()){
					toTop = Math.min($(window).scrollTop()+$(window).height()-dialog.height(), target.offset().top-dialog.height());
					pic = "up";
					margin = "top";
				}else{
					pic = "down";
					margin = "down";
					toTop = Math.max($(window).scrollTop(), target.offset().top+target.height());
				}
				//if show at right
				if((target.offset().left+target.width()+dialog.width()) < $(window).width()){
					toLeft = target.offset().left+target.width();
					if(margin=="top"){margin = "20px 20px 45px 20px"}else{margin = "45px 20px 20px 20px"}
				}else{
					toLeft = target.offset().left-dialog.width();
					pic += "-left";
					if(margin=="top"){margin = "20px 20px 45px 20px"}else{margin = "45px 20px 20px 20px"}
				}
				dialog.html("<div class='dialog-container' style='background:url(/public/images/dialog-"+pic+".png)'><div class='content' style='padding: "+margin+"'><a class='dialog-close' id='dialog-close-"+index+"' href='javascript: void(0);'><img src='/public/images/close.png' border='0' /></a>"+$(this).html()+"</div></div>");
				$('#dialog-close-'+index).click(function(){$(this).parents('.dialog').hide(); index=$(this).attr('id').substring(13); showDialog[index] = false;});
				dialog.show().css({
					left: (toLeft)+"px",
					top: (toTop)+"px"
				});
			}
		});
		
	}
	
	$(window).scroll(function(){ 
		//do this for each dialog
		$('.dialog').each(function(index){
			dialog = $(this);
			dialog.hide();
			target = dialog.attr('id');
			target = $('.dialog_'+target);
			content = dialogs[index];
			pic="";margin="";
			
			if(target.offset()){
				//if show at top
				if((target.offset().top-dialog.height())>$(window).scrollTop()){
					toTop = Math.min($(window).scrollTop()+$(window).height()-dialog.height(), target.offset().top-dialog.height());
					pic = "up";
					margin = "top";
				}else{
					pic = "down";
					margin = "down";
					toTop = Math.max($(window).scrollTop(), target.offset().top+target.height());
				}
				//if show at right
				if((target.offset().left+target.width()+dialog.width()) < $(window).width()){
					toLeft = target.offset().left+target.width();
					if(margin=="top"){margin = "20px 20px 45px 20px"}else{margin = "45px 20px 20px 20px"}
				}else{
					toLeft = target.offset().left-dialog.width();
					pic += "-left";
					if(margin=="top"){margin = "20px 20px 45px 20px"}else{margin = "45px 20px 20px 20px"}
				}
				
				dialog.html("<div class='dialog-container' style='background:url(/public/images/dialog-"+pic+".png)'><div class='content' style='padding: "+margin+"'><a class='dialog-close' id='dialog-close-"+index+"' href='javascript: void(0);'><img src='/public/images/close.png' border='0' /></a>"+content+"</div></div>");
				$('#dialog-close-'+index).click(function(){$(this).parents('.dialog').hide(); index=$(this).attr('id').substring(13); showDialog[index] = false;});
				
				if(showDialog[index]){
					dialog.show().css({
						left: (toLeft)+"px",
						top: (toTop)+"px"
					});
				}
			}
		});
	});
	
function initAlert(){
	alertbox = $('.alert');
	toLeft = $(window).width();
	toTop = Math.round(($(window).height() - alertbox.height())/2);
	alertbox.show().css({
					left: (toLeft)+"px",
					top: (toTop)+"px"
				});
	toLeft = Math.round(($(window).width() - alertbox.width())/2);
	alertbox.show().animate({
			left: (toLeft)+"px",
			top: (toTop)+"px",
			easing: 'easeInOutElastic'
		}).delay(3000).animate({
			left: (-alertbox.width())+"px",
			top: (toTop)+"px",
			easing: 'easeInOutElastic'
		},function(){$(this).hide();});
	alertbox.click(function(){
			$(this).hide();
	});
}