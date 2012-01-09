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
		form.submit();
	});
	$('#btnBid').click(function() {
	  $('.hint').hide();
	  show_loading();
	  $('#setBid').submit();
	});
	
	function show_loading(){
	  $('#modalDiv').hide().css({'height':$(document).height(), 'width': $(document).width(), 'z-index': 1000});
	  $('#modalDiv').html('<img style="position:fixed; top:50%; left:50%; margin-top: -50px;margin-left: -50px;" src="/public/images/ajax-loader.gif" />');
	  $('#modalDiv').fadeIn(500);	
	}

	$(function(){
		initDialogs();
		initAlert();
		//pre load images
		if (document.images) {
			img1 = new Image();
			img1.src = "/public/images/ajax-loader.gif";
			img1 = new Image();
			img1.src = "/public/images/dialog-down.png";
			img1 = new Image();
			img1.src = "/public/images/dialog-down-left.png";
			img1 = new Image();
			img1.src = "/public/images/dialog-up.png";
			img1 = new Image();
			img1.src = "/public/images/dialog-up-left.png";
		}
	});
	
	var dialogs = new Array();
	var showDialog = new Array();
	
	function initDialogs(){
		targetLights="";
		excludes = "";
		$('.hint').each(function(index){
			dialogs.push($(this).html());
			showDialog.push(true);
			dialog = $(this);
			dialog.hide();
			target_class = dialog.attr('id');
			target = $('.hint_'+target_class);
			
			//build the list of highlights and excludes.
			var hl = $(this).attr('highlight');
			var he = $(this).attr('exclude');
			if(typeof hl!= 'undefined'){
				hl = hl.split(' ');
				hl_buff = new Array();
				for(i=0;i<hl.length;i++)if($('.'+hl[i]).length>0)hl_buff.push('.'+hl[i]);
				if(hl_buff.length>0){hl=hl_buff.join(',');hl+=',';}else{hl='';}
			}else hl='';
			if(typeof he!= 'undefined'){
				he = he.split(' ');
				he_buff = new Array();
				for(i=0;i<he.length;i++)if($('.'+he[i]).length>0)he_buff.push('.'+he[i]);
				if(he_buff.length>0){he=he_buff.join(',');he+=',';}else{he='';}
			}else he='';
			
			targetLights +=hl;
			excludes +=he;
			
			pic="";margin="";
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
				dialog.html("<div class='dialog-container' style='background:url(/public/images/dialog-"+pic+".png)'><div class='content' style='padding: "+margin+"'><a title='Close the Tutorial.' class='dialog-close' id='dialog-close-"+index+"' href='javascript: void(0);'><img height='12px' width='12px' src='/public/images/close.png' border='0' /></a>"+$(this).html()+"</div></div>");
				$('#dialog-close-'+index).click(function(){$.ajax('/profile/hide_tutorial');$('#modalDiv').hide(); $(old_highlights).css({'position':'relative', 'z-index':0, '-webkit-box-shadow': '#fff 0px 0px 0px', '-moz-box-shadow': '#fff 0px 0px 0px','box-shadow': '#fff 0px 0px 0px'});$(old_exclude).css({'position':'relative', 'z-index':0}); $(this).parents('.hint').hide(); index=$(this).attr('id').substring(13); showDialog[index] = false;});
				dialog.show().css({
					left: (toLeft)+"px",
					top: (toTop)+"px"
				});
			}
		});
		targetLights = targetLights.slice(0, -1);
		excludes = excludes.slice(0, -1);
		if(targetLights!="")highlight(targetLights, excludes);
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