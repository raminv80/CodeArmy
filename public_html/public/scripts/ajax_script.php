$('select[name=project]').change(function(){
	$.post('AjaxCategories', { project_id: $('select[name=project]').val() },function(data){
    	$('select[name=category]').html(data);
    })
});

$(document).ready(function(){
$.post('AjaxCategories', { project_id: $('select[name=project]').val() },function(data){
    	$('select[name=category]').html(data);
    })
});