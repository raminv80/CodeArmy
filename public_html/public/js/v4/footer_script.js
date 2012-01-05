// JavaScript Document
	$(function() {
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
			$( "#dialog-message" ).dialog({
				modal: true,
				buttons: {
					Ok: function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});
		
	function show_tab(tab){
		$('.tab-content').hide();
		$('ul.tabset li a.active').removeClass('active');
		$('a[href="#'+tab+'"]').addClass('active');
		url = '/myoffice/AjaxTab_'+tab;
		$.post(url, function(data){
				$('#'+tab).html(data);
				$('#'+tab).show();
			});
	}
	
	$('header').localScroll();
	var currentPage=0;
	$('#page'+currentPage).show();
	$(document).ready(function (){
		$('iframe').each(function(){
				var url = $(this).attr("src");
				$(this).attr("src",url+"?wmode=transparent");
		});
	});
	var test;
	
	$('a.submit').click(function(){
		test = $(this);
		var form = $(this).parents('form');
		console.log(form);
		form.submit();
	});
	$('#btnBid').click(function() {
	  $('#setBid').submit();
	});

	$(function(){
		initDialogs();
		initAlert();
	});
	
	var dialogs = new Array();
	var showDialog = new Array();
	
	function initDialogs(){
		$('.hint').each(function(index){
			dialogs.push($(this).html());
			showDialog.push(true);
			dialog = $(this);
			dialog.hide();
			target_class = dialog.attr('id');
			target = $('.hint_'+target_class);
			pic="";margin="";targetLights=",";
			if(target.offset()){
				targetLights += '.hint_'+target_class+',';
				dialog.click(function(){
						if($(this).is(':visible')){
							target = $(this).attr('id');
							target = $('.hint_'+target);
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
				dialog.html("<div class='dialog-container' style='background:url(/public/images/dialog-"+pic+".png)'><div class='content' style='padding: "+margin+"'><a class='dialog-close' id='dialog-close-"+index+"' href='javascript: void(0);'><img height='12px' width='12px' src='/public/images/close.png' border='0' /></a>"+$(this).html()+"</div></div>");
				$('#dialog-close-'+index).click(function(){$(this).parents('.hint').hide(); index=$(this).attr('id').substring(13); showDialog[index] = false;});
				dialog.show().css({
					left: (toLeft)+"px",
					top: (toTop)+"px"
				});
			}
		});
		targetLights = targetLights.slice(0, -1);
		if(targetLights!="")highlight(targetLights);
	}
	
	$(window).scroll(function(){ 
		//do this for each dialog
		$('.hint').each(function(index){
			dialog = $(this);
			dialog.hide();
			target = dialog.attr('id');
			target = $('.hint_'+target);
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
				
				dialog.html("<div class='dialog-container' style='background:url(/public/images/dialog-"+pic+".png)'><div class='content' style='padding: "+margin+"'><a class='dialog-close' id='dialog-close-"+index+"' href='javascript: void(0);'><img height='12px' width='12px' src='/public/images/close.png' border='0' /></a>"+content+"</div></div>");
				$('#dialog-close-'+index).click(function(){$(this).parents('.hint').hide(); index=$(this).attr('id').substring(13); showDialog[index] = false;});
				
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