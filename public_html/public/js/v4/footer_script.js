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
			$('.footer').hover(function(){$(this).fadeTo('fast',1);},function(){$(this).fadeTo('fast',0.9);});
			poll();
		});
		
	function poll(){
		//update left sliding boxes
    	$.ajax({ url: "/inbox/update_numbers", success: function(data){
			num_bids = data[0][0]; if(num_bids<=0)num_bids='';
			num_msg = data[1][0]; if(num_msg<=0)num_msg='';
			num_jobs = data[2][0]; if(num_jobs<=0)num_jobs='';
        	$('#bid_side_menu_button').html(num_bids);
			$('#message_side_menu_button').html(num_msg);
			$('#job_side_menu_button').html(num_jobs);
			bids = data[0][1];
			msg = data[1][1];
			jobs = data[2][1];
			//poll bid side menu
			if($('#bid_side_menu').hasClass('sidemenu_active')){
				//if menu is open then update its content.
				var has_new = false;
				for(i=0;i<bids.length;i++){
					bid = bids[i];
					var found = false;
					$('#bid_side_menu.sidemenu_active .message_buble').each(function(){
							if('msg_'+bid.id == $(this).attr('id')){
								found = true; return false;
							}
						});
					if(!found){
						has_new = true;
						//this is a new message so add it to the list
						var html_str = '<div id="msg_'+bid.id+'" class="message_buble '+bid.status+'"><img align="left" src="/public/images/img6.png" /><p class="summary"><span class="title">'+bid.title+': </span> '+bid.message.replace(/(<([^>]+)>)/ig,"").substr(0,50)+'...</p><div class="desc" style="display:none">'+bid.message+'</div>';
						$('#bid_side_menu.sidemenu_active .list').prepend(html_str);
					}
				}
				if(has_new){
					setup_message_bubles();
				}
			}
			//poll message side menu
			if($('#message_side_menu').hasClass('sidemenu_active')){
				//if menu is open then update its content.
				var has_new = false;
				for(i=0;i<msg.length;i++){
					bid = msg[i];
					var found = false;
					$('#message_side_menu.sidemenu_active .message_buble').each(function(){
							if('msg_'+bid.id == $(this).attr('id')){
								found = true; return false;
							}
						});
					if(!found){
						has_new = true;
						//this is a new message so add it to the list
						var html_str = '<div id="msg_'+bid.id+'" class="message_buble '+bid.status+'"><img align="left" src="/public/images/img6.png" /><p class="summary"><span class="title">'+bid.title+': </span> '+bid.message.replace(/(<([^>]+)>)/ig,"").substr(0,50)+'...</p><div class="desc" style="display:none">'+bid.message+'</div>';
						$('#message_side_menu.sidemenu_active .list').prepend(html_str);
					}
				}
				if(has_new){
					setup_message_bubles();
				}
			}
			//poll job side menu
			if($('#job_side_menu').hasClass('sidemenu_active')){
				//if menu is open then update its content.
				var has_new = false;
				for(i=0;i<jobs.length;i++){
					bid = jobs[i];
					var found = false;
					$('#job_side_menu.sidemenu_active .message_buble').each(function(){
							if('msg_'+bid.id == $(this).attr('id')){
								found = true; return false;
							}
						});
					if(!found){
						has_new = true;
						//this is a new message so add it to the list
						var html_str = '<div id="msg_'+bid.id+'" class="message_buble '+bid.status+'"><img align="left" src="/public/images/img6.png" /><p class="summary"><span class="title">'+bid.title+': </span> '+bid.message.replace(/(<([^>]+)>)/ig,"").substr(0,50)+'...</p><div class="desc" style="display:none">'+bid.message+'</div>';
						$('#job_side_menu.sidemenu_active .list').prepend(html_str);
					}
				}
				if(has_new){
					setup_message_bubles();
				}
			}
		}, dataType: "json", complete: do_poll, timeout: 30000 });
	}
	
	function do_poll(){
		setTimeout("poll()", 1000);	
	}
		
	function show_tab(tab){
		$('.tab-content').hide();
		$('ul.tabset li a.active').removeClass('active');
		$('a[href="#'+tab+'"]').addClass('active');
		url = '/myoffice/AjaxTab_'+tab;
		$.post(url, function(data){
				$('#'+tab).html(data);
				$('#'+tab).show();
				initDialogs();
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
		initAlert();
		//pre load images
		if (document.images) {
			img1 = new Image();
			img1.src = "/public/images/alertbox1.png";
		}
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