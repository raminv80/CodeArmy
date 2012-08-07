<link href='http://fonts.googleapis.com/css?family=Ruda' rel='stylesheet' type='text/css' />
<link href="/public/css/reset.css" media="all" rel="stylesheet" type="text/css" />
<link href="/public/css/v4/tipsy.css" media="all" rel="stylesheet" type="text/css" />
<link type="text/css" href="/public/css/CodeArmyV1/ui-darkness/jquery-ui-1.8.22.custom.css" rel="stylesheet" />
<link href="/public/css/CodeArmyV1/style.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/public/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="/public/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="/public/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/public/js/jquery.ui.selectmenu.js"></script>
<script type="text/javascript" src="/public/js/v4/jquery.tipsy.js"></script>
<script type="text/javascript" src="/public/js/codeArmy/modernize.js"></script>
<script type="text/javascript" src="/public/js/codeArmy/jquery.transit.min.js"></script>
<script type="text/javascript" src="/public/js/codeArmy/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="/public/js/codeArmy/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="/public/js/jquery.validate.js"></script>
<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.gears.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.silverlight.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.flash.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.browserplus.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.html4.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.html5.js"></script>

<?php echo form_open('#' , array('id'=>'form-create-mission')); ?>
<div class="create-mission-container">
  <div class="create-mission-title">Create Mission</div>
  <div class="create-mission-info">
    <div class="mission-title">
      <label>Mission Title</label>
      <input type="text" id="mission-title" name="mission-title" class="required" value="" />
    </div>
    <div class="mission-video-url">
      <label>Mission Video</label>
      <input type="text" id="mission-video" name="mission-video" value="" placeholder="Youtube video tag or url"/>
    </div>
  </div>
  <div class="mission-desc-video">
    <div class="mission-description">
      <div><span class="desc-title-text">Description</span><span class="examples-link"><a href="#">Examples</a></span></div>
      <textarea rows="7" id="mission-desc-text" name="mission-desc-text" class="required"></textarea>
      <!--<div class="attach-file-tools"> <a href="#"><img src="/public/images/codeArmy/mission/fileicon.png" class="fileicon" /></a> <span class="filename"><a href="#">Project-brief.ppt</a></span> <span class="filesize">(250kb)</span> <span class="filedesc">Acme online store brief...</span> <a href="#"><img src="/public/images/codeArmy/mission/binicon.png" class="binicon" /></a> </div>-->
      <div id="plupload-container" style="clear:both">
      <div id="filelist">No runtime found.</div>
      <input type="button" id="pickfiles" class="lnkimg" value="Select files">
      <input type="button" id="uploadfiles" class="lnkimg" value="Upload files">
      </div>
    </div>
    <div class="mission-video-preview">
    <iframe class="youtube-player" id="mission-video-youtube" type="text/html" width="330" height="216" src="http://www.youtube.com/embed/" frameborder="0"></iframe>
    </div>
  </div>
  <div class="mission-type-n-skills">
    <div class="mission-type"> <span class="mission-type-title">Mission Type</span>
      <select id="mission-type-main" name="mission-type-main" class="mission-type-main required" validate="required:true">
        <option value="">--- Please select ---</option>
      <?php foreach($main_category as $value): ?>
        <option value="<?=$value['category_id']?>" <?php if($value['category_id']==$cat_selected){?>selected="selected"<?php }?>><?=$value['category']?></option>
      <?php endforeach; ?>
      </select>
      <select id="mission-type-class" name="mission-type-class" class="mission-type-sub">
        <option value="0">--- Please select ---</option>
      <?php foreach($class as $value): ?>
        <option value="<?=$value['class_id']?>"><?=$value['class_name']?></option>
      <?php endforeach; ?>
      </select>
      <select id="mission-type-sub" name="mission-type-sub" class="mission-type-sub">
        <option value="0">--- Please select ---</option>
      <?php foreach($sub_class as $value): ?>
        <option value="<?=$value['subclass_id']?>"><?=$value['subclass_name']?></option>
      <?php endforeach; ?>
      </select>
    </div>
    <div class="skills-required"> <span class="skills-required-title">Skills Required (type @ for tagging)</span>
      	<textarea id="skills-required-text-post" name="skills-required-text-post" style="display:none"></textarea>
		<div id="skills-required-text" contenteditable="true"></div>
		<div class="clearfix"></div>
		<div class="skill-tag">
			<!--<a href="#" title="Web Design">Web Design</a>
			<a href="#" title="CSS3">CSS3</a>
			<a href="#" title="HTML5">HTML5</a>-->
		</div>
		<div class="skill-msg">Type the name of someone or something...</div>
    </div>
  </div>
  <div class="mission-arrange-budget">
    <div class="mission-arrangements"> <span class="mission-arrange-title">Mission's Arrangements</span>
      <div class="arrange-row">
        <select id="mission-arrange-hour" name="mission-arrange-hour" class="mission-arrange-hour">
          <option value=""></option>
          <option value="hourly">Hourly</option>
        </select>
        <span class="center-dash">-</span>
        <select id="mission-arrange-month" name="mission-arrange-month" class="mission-arrange-month">
          <option value=""></option>
          <option value="1-3">1-3 months</option>
        </select>
      </div>
    </div>
    <div class="mission-budget"> <span class="mission-budget-title">Budget</span>
      <div class="arrange-row">
        <select id="mission-budget" name="mission-budget" class="mission-budget">
          <option value=""></option>
          <option value="30-40/hour">30$ - 40$ / hour</option>
        </select>
      </div>
    </div>
  </div>
  
  <div class="mission-submit-row">
    <div class="assign-po"> 
    <input class="assinpo" id="assignpo" type="checkbox" value="yes" /> <label>Assign this mission to a Project Manager? </label>
   </div>

<div class="submit-cancel-row">

<input type="submit" class="lnkimg" id="post-mission" value="Post Mission">
<input type="reset" class="lnkimg" id="cancel-mission" value="Cancel">
</div>
   
   </div>
  
</div>
</form>
<!-- Temporary -->
<style type="text/css">
	.clearfix:before, .clearfix:after { content: "\0020"; display: block; height: 0; overflow: hidden; }  
	.clearfix:after { clear: both; }  
	.clearfix { zoom: 1; }
	#skills-required-text {height:100px; background: url("/public/images/codeArmy/mission/textarea-box-bg.jpg") no-repeat; margin-left:40px; padding:5px; color:white}
	#skills-required-text:focus {outline:none}
	#skills-required-text a {padding:3px; background: black; color:#FC0}
	#create-mission-container {overflow-x:hidden; overflow-y:auto}
	.skill-tag {width:290px; padding:5px; background:black; margin-left:40px; display:none; }
	.skill-tag a {color:white; width:100%; font-size:.85em; padding:3px; background: #333}
	.skill-tag a:hover {background:#FC0; color:black}
	.skill-msg {margin-left:40px; color: #FC0; display:none; font-size:.85em}
</style>
<script type="text/javascript">
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
					console.log(msg);
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
			$("#skills-required-text-post").html(content);
			$("#skills-required-text").html(content);
			var E=username+",";
			$("#skills-required-text").append(E+' ');
			$("#skills-required-text-post").append(E+' ');
			$(".skill-tag").hide();
			$(".skill-msg").hide();
			$("#skills-required-text").focus();
		});	
	});
</script>

<script>
//cookie management
function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + "; path=/" + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
function getCookie(c_name)
{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
	  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	  x=x.replace(/^\s+|\s+$/g,"");
	  if (x==c_name)
		{
		return unescape(y);
		}
	  }
	  return false;
}

$(window).keypress(function() {
  if ( event.which == "`".charCodeAt(0) ) {
	 $('#debugger:hidden').slideToggle();
  }
});

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
		$('#filelist').html("<div style='display:none'>Current runtime: " + params.runtime + "</div>");
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
		$('#mission-video-youtube').attr('src','http://www.youtube.com/embed/'+tag).show();
	})
	
	$('#post-mission').click(function(){
		$("#form-create-mission").validate({
			submitHandler: function() {
				var mission_title = $('#mission-title').val();
				var mission_desc = $('#mission-desc-text').val();
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
						console.log(msg)
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
}
</script>