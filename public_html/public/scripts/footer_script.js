// JavaScript Document

$('.dashboard-filter').change(function(){
	$('#filter-option').submit();
});

$('#submit').click(function(){
		var form = $(this).parents('form:first');
		form.submit();
	});