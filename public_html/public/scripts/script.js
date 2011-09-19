function project_sel(project_id){
	$.post(
		'/home/AjaxProjectSel',
		{ project_sel: project_id },
		function(data){
			data = data.split('~');
			$('#category_list').html(data[0]);
			$('#story_list').html(data[1]);
			initPopups();
			initOpenBlocks();
			initAutocomplete();
			$('.project-list').removeClass('active');
			$('#project-list-'+project_id).addClass('active');
		}
	);
}

function category_sel(category_id){
	$.post(
		'/home/AjaxCategorySel',
		{ category_sel: category_id },
		function(data){
			$('#story_list').html(data);
			initPopups();
			initOpenBlocks();
			initAutocomplete();
			$('.category-list').removeClass('active');
			$('#category-list-'+category_id).addClass('active');
		}
	);
}

$(document).ready(function(){
            //$("tr:details").addClass("details");
            $(".myTable tr:not(.story-title)").hide();
            $(".myTable tr:first-child").show();
            
            $(".myTable tr.story-title").click(function(){
                $(this).next("tr").toggle();
                $(this).find(".arrow").toggleClass("up");
            });
            //$("#myTable").jExpand();
});

$(document).ready(function() {
			            //$("tr:details").addClass("details");
            $(".myTable1 tr:not(.story-title1)").hide();
            $(".myTable1 tr:first-child").show();
            
            $(".myTable1 tr.story-title1").click(function(){
                $(this).next("tr").toggle();
                $(this).find(".arrow").toggleClass("up");
            });
            //$("#myTable").jExpand();
			//if($(".detailbox"))
			//$(".detailbox").colorbox({width:"80%", height:"80%"});
			
				$("a[rel=fancy_frame]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});

});


$(function() {
				//	Basic carousel
				$('.mw_gallery').carouFredSel();
});