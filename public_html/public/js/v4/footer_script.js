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