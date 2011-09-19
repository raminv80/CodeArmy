// JavaScript Document

$('.dashboard-filter').change(function(){
	$('#filter-option').submit();
});

$('a.submit').click(function(){
		var form = $(this).parents('form:first');
		form.submit();
	});