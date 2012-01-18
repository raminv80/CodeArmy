function project_sel(project_id,code){
	$.post(
		'/home/AjaxProjectSel',
		{ 'project_sel': project_id, 'ci_csrf_token': code },
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

function category_sel(category_id, code){
	$.post(
		'/home/AjaxCategorySel',
		{ 'category_sel': category_id, 'ci_csrf_token': code },
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


/*----------- Fancybox script -----------*/

$(function() {
				//	Basic carousel
				$('.mw_gallery').carouFredSel();
});

$(document).ready(function() {

			$("a[rel=fancy_frame]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});

});
