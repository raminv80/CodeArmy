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
    <div class="skills-required"> <span class="skills-required-title">Skills Required</span>
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
		//$('.fancybox-inner').css( {'overflow-x' : 'hidden','overflow-y' : 'auto'});
		
		var start=/@/ig;
		var word=/@(\w+)/ig;
		
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
			return false();	
		});
		
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
