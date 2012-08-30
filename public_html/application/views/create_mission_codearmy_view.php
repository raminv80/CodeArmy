<?php $this->load->view('includes/frame_header.php'); ?>
</head>
 
<body>
<?php echo form_open('#' , array('id'=>'form-create-mission')); ?>
<div class="create-mission-wrapper">
<div class="create-mission-container">
	
  <div class="create-mission-title">Create Mission</div>
  <div class="create-mission-info">
    <div class="mission-title">
      <label>Mission Title</label>
      <input type="text" id="mission-title" name="mission-title" class="required" tabindex="1" autofocus value="" />
    </div>
    <div class="mission-video-url">
      <label>Mission Video</label>
      <input type="text" tabindex="8" id="mission-video" name="mission-video" value="" placeholder="Youtube video tag or url"/>
    </div>
  </div>
  <div class="mission-desc-video">
    <div class="mission-description">
      <div><span class="desc-title-text">Description</span><span class="examples-link"><a href="#">Examples</a></span></div>
      <textarea rows="7" tabindex="2" id="mission-desc-text" name="mission-desc-text" class="required"></textarea>
      <!--<div class="attach-file-tools"> <a href="#"><img src="/public/images/codeArmy/mission/fileicon.png" class="fileicon" /></a> <span class="filename"><a href="#">Project-brief.ppt</a></span> <span class="filesize">(250kb)</span> <span class="filedesc">Acme online store brief...</span> <a href="#"><img src="/public/images/codeArmy/mission/binicon.png" class="binicon" /></a> </div>-->
      <div id="plupload-container" style="clear:both">
      <div id="filelist">No runtime found.</div>
      <input type="button" tabindex="3" id="pickfiles" class="lnkimg" value="Attach files">
      <!--<input type="button" id="uploadfiles" tabindex="4" class="lnkimg" value="Upload files">-->
      </div>
    </div>
    <div class="mission-video-preview">
    	<iframe class="youtube-player" id="mission-video-youtube" type="text/html" width="330" height="216" src="http://www.youtube.com/embed/" frameborder="0"></iframe>
    </div>
  </div>
  <div class="mission-type-n-skills">
    <div class="mission-type"> <span class="mission-type-title">Mission Type</span>
      <div class="wrapselect big right">
      	<select tabindex="5" id="mission-type-main" name="mission-type-main" class="required" validate="required:true">
	        <option value="">--- Please select ---</option>
	      <?php foreach($main_category as $value): ?>
	        <option value="<?=$value['category_id']?>" <?php if($value['category_id']==$cat_selected){?>selected="selected"<?php }?>><?=$value['category']?></option>
	      <?php endforeach; ?>
	      </select>
      </div>
      <div class="wrapselect big right">
      	<select tabindex="6" id="mission-type-class" name="mission-type-class" class="mission-type-sub">
	        <option value="0">--- Please select ---</option>
	      <?php foreach($class as $value): ?>
	        <option value="<?=$value['class_id']?>"><?=$value['class_name']?></option>
	      <?php endforeach; ?>
	    </select>
      </div>
      <div class="wrapselect big right">
      	<select tabindex="7" id="mission-type-sub" name="mission-type-sub" class="mission-type-sub">
	        <option value="0">--- Please select ---</option>
	      <?php foreach($sub_class as $value): ?>
	        <option value="<?=$value['subclass_id']?>"><?=$value['subclass_name']?></option>
	      <?php endforeach; ?>
	    </select>
      </div>
    </div>
    <div class="skills-required"> <span class="skills-required-title">Skills Required</span>
      	<!--<textarea id="skills-required-text-post" name="skills-required-text-post" style="display:none"></textarea>
		<div id="skills-required-text" tabindex="9" contenteditable="true"></div>
		<div class="clearfix"></div>
		<div class="skill-tag"></div>
		<div class="skill-msg">Type the name of a skill or proficiency level...</div>-->
        <input type="hidden" name="tags" id="hiddenSkill" value="" disabled="true">
		<!--<input id="skills-required" placeholder="Enter skills required..">-->
        <ul id="skills-required"></ul>
    </div>
  </div>
  <div class="mission-arrange-budget">
    <div class="mission-arrangements"> <span class="mission-arrange-title">Mission's Arrangements</span>
      <div class="arrange-row">

        <div class="wrapselect small left">
        	<select tabindex="10" id="mission-arrange-type" name="mission-arrange-type" class="mission-arrange-hour required" validate="required:true">
	          <option value=""></option>
              <?php foreach($arrangement_type as $type): ?>
	          <option value="<?=$type['id']?>"><?=$type['type']?></option>
              <?php endforeach; ?>
	        </select>
        </div>
        <span class="dashforselect"><i class="icon-chevron-right"></i></span>
        <div class="wrapselect small left">
        	<select tabindex="11" id="mission-arrange-duration" name="mission-arrange-duration" class="mission-arrange-month required" validate="required:true">
	          <option value=""></option>
	        </select>
        </div>

      </div>
    </div>
    <div class="mission-budget"> <span class="mission-budget-title">Budget</span>
      <div class="arrange-row">

        <div class="wrapselect small">
        	<select tabindex="12" id="mission-budget" name="mission-budget" class="mission-budget required" validate="required:true">
	          <option value=""></option>
	        </select>
        </div>

      </div>
    </div>
  </div>
  
  <div class="mission-submit-row">
    <div class="assign-po" style="height:25px">
    <!-- 
    <input class="assinpo" id="assignpo" type="checkbox" value="yes" /> <label>Assign this mission to a Project Manager? </label>
    -->
   </div>

<div class="submit-cancel-row">
<div class="loader" style="margin:-40px auto 20px; padding-left:180px"><img id="reg-ajax" style="display: none;"src="/public/images/codeArmy/loader4.gif"></div>
<input tabindex="13" type="button" class="lnkimg" id="post-mission" value="Post Mission">
<input tabindex="14" type="reset" class="lnkimg" id="cancel-mission" value="Cancel">
</div>
   
   </div>
  
</div>
</div>
<!-- end container -->
</form>
<style type="text/css">
	.create-mission-container {overflow-x:hidden}
	select:focus{border: 2px dashed grey;}
</style>
<script type="text/javascript">
	$(function(){
		var sampleTags = [<?php foreach($skills as $skill): echo "'".$skill['skills']."', "; endforeach;?><?php foreach($skillsonly as $skillonly): echo "'".$skillonly['name']."', "; endforeach;?>''];

        //-------------------------------
        // Minimal
        //-------------------------------
        $('#skills-required').tagit({
		    availableTags: sampleTags,
			singleField: true,
			singleFieldNode: $('#hiddenSkill')
	    });
		$('.ui-autocomplete-input').attr('tabindex','8');
	});
	
	$(function(){
		initCreateMission();
		
		var start=/@/ig;
		var word=/@(\w+)/ig;
		//var word=/(\w+)/ig;
		$('#mission-type-main').live("change",function(){
			$.ajax({
				type: "POST",
				url: "/missions/Ajax_get_class",
				data:{'category':$(this).val(), 'csrf_workpad':getCookie('csrf_workpad')},
				dataType: "json",
				success: function(msg){
					$('#mission-type-class').html('');
					$('#mission-type-class').append("<option value='0'>--- Please select ---</option>");
					$(msg).each(function(){$('#mission-type-class').append("<option value='"+this.class_id+"'>"+this.class_name+"</option>")});
				}
			});
		});
		
		$('#mission-type-class').live("change",function(){
			$.ajax({
				type: "POST",
				url: "/missions/Ajax_get_subclass",
				data:{'class':$(this).val(), 'category':$('#mission-type-main').val(), 'csrf_workpad':getCookie('csrf_workpad')},
				dataType: "json",
				success: function(msg){
					$('#mission-type-sub').html('');
					$('#mission-type-sub').append("<option value='0'>--- Please select ---</option>");
					$(msg).each(function(){$('#mission-type-sub').append("<option value='"+this.subclass_id+"'>"+this.subclass_name+"</option>")});
				}
			});
		});
		
		$('#mission-arrange-type').live("change",function(){
			$.ajax({
				type: "POST",
				url: "/missions/Ajax_get_duration",
				data:{'type':$(this).val(), 'csrf_workpad':getCookie('csrf_workpad')},
				dataType: "json",
				success: function(msg){
					$('#mission-arrange-duration').html('');
					$('#mission-arrange-duration').append("<option value=''>Please select</option>");
					$(msg).each(function(){$('#mission-arrange-duration').append("<option value='"+this.time_id+"'>"+this.duration+"</option>")});
				}
			});
			$.ajax({
				type: "POST",
				url: "/missions/Ajax_get_budget",
				data:{'type':$(this).val(), 'csrf_workpad':getCookie('csrf_workpad')},
				dataType: "json",
				success: function(msg){
					$('#mission-budget').html('');
					$('#mission-budget').append("<option value=''>Please select</option>")
					$(msg).each(function(){$('#mission-budget').append("<option value='"+this.budget_id+"'>"+this.amount+" $</option>")});
				}
			});
		});

		$("#skills-required-text").live("keyup",function() {
			var content = $(this).text();
			var go = content.match(start);
			var name= content.match(word);
			var dataString = 'searchword='+ name +'&csrf_workpad='+ getCookie('csrf_workpad');
			
			if (go){
				$('.skill-msg, .skill-tag').slideDown('show');
				if(name) {
					$.ajax({
						type: "POST",
						url: "/missions/getSkills",
						data: dataString,
						cache: false,
						success: function(html) {
							$(".skill-msg").hide();
							$(".skill-tag").html(html).show();
						}
					});
				};
			};
			return false;	
		});
		
		$('.skills-required').mouseleave(function(){
			$('.skill-msg, .skill-tag').slideUp('hide');
		})
		
		$(".skill-tag a").live("click",function() 
		{
			var username = $(this).attr('title');
			var old = $("#skills-required-text").html();
			var content = old.replace(word,"");
			$("#skills-required-text").html(content);
			var E=username+",";
			$("#skills-required-text").append(E+' ');
			$(".skill-tag").hide();
			$(".skill-msg").hide();
			$("#skills-required-text").focus();
		});	
		
		$('[title]').tipsy({'gravity':'s'});
	});
</script>

<script>
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
		//multipart_params : {'csrf_workpad': getCookie('csrf_workpad')},
		resize : {width : 320, height : 240, quality : 90},
		flash_swf_url : '/public/js/plupload/plupload.flash.swf',
		silverlight_xap_url : '/public/js/plupload/plupload.silverlight.xap',
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		],
		init : {
			FilesAdded: function(up, files) {
			  up.start();
			}
		}
	});

	uploader.bind('Init', function(up, params) {
		$('#filelist').html("<div style='display:none'>Current runtime: " + params.runtime + "</div>");
	});
	
	uploader.bind('UploadComplete', function(up, files) {
		//for (var i in files) {
		$.each(files, function(i, file) {
			$('#filelist').append('<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b> <a href="javascript:void(0);" class="removeQueue">Remove</a></div>');
			
			$('#' + file.id + ' a.removeQueue').first().click(function(e) {
				e.preventDefault();
				up.removeFile(file);
				$('#' + file.id).remove();
			});
		});
	});
	
	uploader.bind('BeforeUpload', function (up, file) {
		//console.log(file.size);
		up.settings.multipart_params = {'filesize': file.size,'csrf_workpad': getCookie('csrf_workpad')}
	});
	
	uploader.bind('FileUploaded', function(uploder, file, response) {
		res = $.parseJSON(response.response);
		//update id to actual id
		$('#'+file.id).attr('id',res.id);
	});
	
	uploader.bind('UploadProgress', function(up, file) {
		$('.removeQueue').hide();
		$('#'+file.id+' b').html("<span>" + file.percent + "%</span> <a href='javascript:void(0)' id='delUploadFile'>Delete</a>");
	});
	
	$('#delUploadFile').live("click",function() {
		var file_id = $(this).parent().parent().attr('id');
		$.ajax({
			type: 'post',
			url: '/missions/ajax_delete_file',
			data: {'csrf_workpad': getCookie('csrf_workpad'), 'file_id':file_id},
			success: function(msg){
					if(msg="success"){
						$('#'+file_id).remove();
					}else{
						//console.log(msg)
					}
				}
		});
		return false;
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
	
	$('#cancel-mission').click(function(){
		parent.$.fancybox.close();
	});
	
	$('#post-mission').click(function(){
		if($("#form-create-mission").valid()){
			submitHandler();
		}
	});
	
	function submitHandler() {
		$('#reg-ajax').show();
		var mission_title = $('#mission-title').val();
		var mission_desc = $('#mission-desc-text').val();
		var mission_tutorial = $('#mission-video').val();
		var mission_skills = $('#hiddenSkill').val();
		var mission_type_main = $('#mission-type-main').val();
		var mission_type_class = $('#mission-type-class').val();
		var mission_type_subclass = $('#mission-type-sub').val();
		var mission_arrange_type = $('#mission-arrange-type').val();
		var mission_arrange_duration = $('#mission-arrange-duration').val();
		var mission_budget = $('#mission-budget').val();
		var assign_po = $('#assignpo').val();
		$.fancybox.showLoading();
		$.ajax({
			type: 'post',
			async: false,
			url: '/missions/check_create_mission',
			data: { 'mission_title': mission_title, 
			  'mission_desc': mission_desc, 
			  'mission_video': mission_tutorial, 
			  'mission_skills': mission_skills,
			  'mission_type_main': mission_type_main, 
			  'mission_type_class': mission_type_class, 
			  'mission_type_subclass': mission_type_subclass, 
			  'mission_arrange_type': mission_arrange_type, 
			  'mission_arrange_duration': mission_arrange_duration, 
			  'mission_budget': mission_budget, 
			  'assign_po': assign_po, 
			  'csrf_workpad': getCookie('csrf_workpad') 
			},
			success: function(msg){
				//console.log(msg)
				if(msg!="" && msg!='error'){
					//console.log(msg);
					parent.$('.fancybox-iframe').attr('src','http://<?=$_SERVER['HTTP_HOST']?>/missions/mission_confirmation/'+msg);
				} else {
					alert("Error");
				}
				$('#reg-ajax').hide();
			}
		});
	}
}

var win = $(window);
// Full body scroll
var isResizing = false;
win.bind(
	'resize',
	function()
	{
		if (!isResizing) {
			isResizing = true;
			var container = $('.create-mission-wrapper');
			// Temporarily make the container tiny so it doesn't influence the
			// calculation of the size of the document
			container.css(
				{
					'width': 1,
					'height': 1
				}
			);
			// Now make it the size of the window...
			container.css(
				{
					'width': win.width(),
					'height': win.height()
				}
			);
			isResizing = false;
			container.jScrollPane(
				{
					'showArrows': true
				}
			);
		}
	}
).trigger('resize');
/* IE calculates the width incorrectly first time round (it doesn't count the space used by the native scrollbar) so we re-trigger if necessary. */
if ($('#full-page-container').width() != win.width()) {
	win.trigger('resize');
}
</script>
</body>
<?php $this->load->view('includes/frame_footer.php'); ?>
