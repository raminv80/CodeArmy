// plupload
// Custom example logic
function $(id) {
	return document.getElementById(id);	
}

var uploader = new plupload.Uploader({
	runtimes : 'gears,html5,flash,silverlight,browserplus',
	browse_button : 'pickfiles',
	container: 'plupload-container',
	max_file_size : '10mb',
	url : '/missions/uploadfiles',
	multipart_params : {'csrf_workpad': getCookie('csrf_workpad')},
	resize : {width : 320, height : 240, quality : 90},
	flash_swf_url : '/public/js/plupload/plupload.flash.swf',
	silverlight_xap_url : '/public/js/plupload/plupload.silverlight.xap',
	filters : [
		{title : "Image files", extensions : "jpg,gif,png"},
		{title : "Zip files", extensions : "zip"}
	]
});

uploader.bind('Init', function(up, params) {
	$('filelist').innerHTML = "<div>Current runtime: " + params.runtime + "</div>";
});

uploader.bind('FilesAdded', function(up, files) {
	for (var i in files) {
		$('filelist').innerHTML += '<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></div>';
	}
});

uploader.bind('UploadProgress', function(up, file) {
	$(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
});

$('uploadfiles').onclick = function() {
	uploader.start();
	return false;
};

uploader.init();
// end of plupload

$('#post-mission').click(function(){
	$("#form-create-mission").validate({
		submitHandler: function() {
			var mission_title = $('#mission-title').val();
			var mission_desc = $('#mission-desc-text').val();
			var mission_type_main = $('#mission-type-main').val();
			var mission_type_class = $('#mission-type-class').val();
			var mission_type_subclass = $('#mission-type-sub').val();
			var mission_arrange_hour = $('#mission-arrange-hour').val();
			var mission_arrange_month = $('#mission-arrange-month').val();
			var mission_budget = $('#mission-budget').val();
			var assign_po = $('#assignpo').val();
			$.fancybox.showLoading();
			$.post(
				'/missions/check_create_mission',
				{ 'mission_title': mission_title, 'mission_desc': mission_desc, 'mission_type_main': mission_type_main, 'mission_type_class': mission_type_class, 'mission_type_subclass': mission_type_subclass, 'mission_arrange_hour': mission_arrange_hour, 'mission_arrange_month': mission_arrange_month, 'mission_budget': mission_budget, 'assign_po': assign_po, 'csrf_workpad': getCookie('csrf_workpad') },
				function(msg){
					if(msg!=""){
						//$('#form-create-mission').submit();
						$.fancybox.close();
						$.fancybox.open({
							//type: 'inline',
							data:{},
							href : 'http://<?=$_SERVER['HTTP_HOST']?>/missions/mission_confirmation/'+msg,
							type : 'ajax',
							padding : 0,
							margin: 0,
							height: 600,
							autoSize: true,
							'overlayShow': true,
							'overlayOpacity': 0.5, 
							afterClose: function(){},
							openMethod : 'dropIn',
							openSpeed : 250,
							closeMethod : 'dropOut',
							closeSpeed : 150,
							nextMethod : 'slideIn',
							nextSpeed : 250,
							prevMethod : 'slideOut',
							prevSpeed : 250,
							height: 600,
							scrolling: 'auto'
						});
					} else {
						//$('#error').html('Please enter mission title').show();
						alert("Error");
					}
				}
			);
		}
	});
});