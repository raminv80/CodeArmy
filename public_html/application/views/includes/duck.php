<!-- Note: comments are used between icons to remove white-space when display inline-block is used -->
<!--[if lte IE 7]>
<style>
/* Inline block fix */
#dock ul {
	display: inline;
	zoom: 1;
}

#dock li, #dock li a {
	display: inline;
	zoom: 1;
}

/* Image quality fix */
img {
	-ms-interpolation-mode: bicubic;
}

#dock li a span {
	filter: alpha(opacity=40);
}
</style>
<![endif]-->
<div id="duck-wrapper">
    <div id="dock">
        <ul>
            <li><a href="#address"><span>Address</span><img src="/public/images/codeArmy/duck/icon-address.png" alt="[address]" /></a></li><!--
            --><li><a href="#band"><span>Band</span><img src="/public/images/codeArmy/duck/icon-band.png" alt="[band]" /></a></li><!--
            --><li><a href="#calendar"><span>Calendar</span><img src="/public/images/codeArmy/duck/icon-calendar.png" alt="[calendar]" /></a></li><!--
            --><li class="active"><a href="#chat"><span>Chat</span><img src="/public/images/codeArmy/duck/icon-chat.png" alt="[chat]" /></a></li><!--
            --><li class="active"><a href="#music"><span>Music</span><img src="/public/images/codeArmy/duck/icon-music.png" alt="[music]" /></a></li><!--
            --><li><a href="#photo"><span>Photo</span><img src="/public/images/codeArmy/duck/icon-photo.png" alt="[photo]" /></a></li><!--
            --><li><a href="javascript: mission_creator_open()"><span>Create Mission</span><img src="/public/images/codeArmy/duck/icon-text.png" alt="[text]" /></a></li><!--
            --><li class="seperator"></li><!--
            --><li><a href="#folder?src=/apps/"><span>Applications</span><img src="/public/images/codeArmy/duck/icon-applications.png" alt="[apps]" /></a></li><!--
            --><li><a href="#folder?src=/pictures/"><span>Pictures</span><img src="/public/images/codeArmy/duck/icon-pictures.png" alt="[pictures]" /></a></li><!--
            --><li><a href="#folder?src=/documents/"><span>Documents</span><img src="/public/images/codeArmy/duck/icon-documents.png" alt="[documents]" /></a></li><!--
            --><li><a href="#bin"><span>Bin</span><img src="/public/images/codeArmy/duck/icon-bin.png" alt="[bin]" /></a></li>
        </ul>
    </div>
</div>

<script>
function mission_creator_open(){
	$.fancybox.showLoading()
	$.fancybox.open({
		href : '#mission_creator',
		type : 'inline',
		padding : 0,
		margin: 0,
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
		scrolling: 'no'
	});
}

//******************************Mission Creator****************************/
	function MissionCreate(category){
		$.fancybox.showLoading()
		$.fancybox.close();
		$.fancybox.open({
			//type: 'inline',
			data:{},
			href : 'http://<?=$_SERVER['HTTP_HOST']?>/missions/create/'+category,
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
			scrolling: 'auto',
			afterShow: initCreateMission
		});
	}
</script>
<script type="application/javascript">
function initCreateMission(){
	// plupload
	// Custom example logic
	//function $(id) {
		//return document.getElementById(id);	
	//}

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
		$('#filelist').html("<div>Current runtime: " + params.runtime + "</div>");
	});
	
	uploader.bind('FilesAdded', function(up, files) {
		for (var i in files) {
			$('#filelist').append('<div id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b> <a href="javascript:;">Delete</a></div>');
		}
	});
	
	uploader.bind('UploadProgress', function(up, file) {
		$('#'+file.id+' b').html("<span>" + file.percent + "%</span>");
	});
	
	$('#uploadfiles').click(function() {
		uploader.start();
		return false;
		//e.preventDefault();
	});
	
	uploader.init();
	// end of plupload
	
	//video link update
	$('#mission-video').change(function(){
		var tag = $(this).val();
		if(tag.indexOf('youtube')>-1){
			var video_id = tag.split('v=')[1];
			var ampersandPosition = video_id.indexOf('&');
			if(ampersandPosition != -1) {
			  video_id = video_id.substring(0, ampersandPosition);
			}
			tag = video_id;
			$(this).val(tag);
		}
		$('#mission-video').attr('value',tag);
		$('#mission-video-youtube').attr('src','http://www.youtube.com/embed/'+tag).show();
	})
	
	$('#post-mission').click(function(){
		$("#form-create-mission").validate({
			submitHandler: function() {
				var mission_title = $('#mission-title').val();
				var mission_desc = $('#mission-desc-text').val();
				var mission_video = $('#mission-video').val();
				var mission_skills = $('#skills-required-text').html();
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
					{ 'mission_title': mission_title,
					  'mission_desc': mission_desc,
					  'mission_video': mission_video,
					  'mission_skills': mission_skills,
					  'mission_type_main': mission_type_main,
					  'mission_type_class': mission_type_class,
					  'mission_type_subclass': mission_type_subclass,
					  'mission_arrange_hour': mission_arrange_hour,
					  'mission_arrange_month': mission_arrange_month,
					  'mission_budget': mission_budget,
					  'assign_po': assign_po,
					  'csrf_workpad': getCookie('csrf_workpad')
					},
					function(msg){
						//console.log(msg)
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
								scrolling: 'auto',
								afterShow: initEditMission
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
}

function initEditMission(){
	$('#edit-mission').click(function(){
		var mission_id = $('#work_id').val();
		
		$.fancybox.showLoading();
		$.fancybox.close();
		$.fancybox.open({
			//type: 'inline',
			data:{},
			href : 'http://<?=$_SERVER['HTTP_HOST']?>/missions/edit_mission/'+mission_id,
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
	});
}
</script>