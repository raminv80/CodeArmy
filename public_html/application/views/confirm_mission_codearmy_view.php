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

<?php echo form_open('missions/create_complete' , array('id'=>'form-create-mission')); ?>
<div class="confirm-mission-container">
  <div class="create-mission-title">Mission Preview</div>
  <div class="confirm-mission-project-name">Project Name</div>
  <div class="mission-brief">
    <div class="mission-brief-title"><?=$preview['title']?></div>
    <div class="brief-video">
    <?php if($preview['tutorial'] != ""){ ?>
    	<iframe class="youtube-player" id="mission-video-youtube" type="text/html" width="330" height="216" src="http://www.youtube.com/embed/<?=$preview['tutorial']?>" frameborder="0"></iframe>
    <?php } ?>
    </div>
    <div class="brief-text">
      <div class="brief-text-title">Mission Briefing</div>
      <div class="brief-text-content"><?=$preview['description']?></div>
    </div>
  </div>
  <div class="mission-type-arrange-budget">
    <div class="confirm-mission-type">
      <div class="confirm-mission-type-title">Mission Type</div>
      <div class="confirm-mission-type-text"><?=$preview['catname']?> > <?=$preview['classname']?> <?=$preview['subclassname']?></div>
    </div>
    <div class="confirm-mission-arrange-budget">
      <div class="confirm-mission-arrange">
        <div class="confirm-mission-type-title">Mission Arrangement</div>
        <div class="confirm-mission-type-text"><?=$preview['input']?> > <?=$preview['output']?></div>
      </div>
      <div class="confirm-mission-budget">
        <div class="confirm-mission-type-title">Budget</div>
        <div class="confirm-mission-type-text"><?=$preview['cost']?></div>
      </div>
    </div>
  </div>
  <div class="confirm-mission-skills-files ">
    <div class="confirm-mission-skills">
      <div class="confirm-mission-skills-title">Skills Needed</div>
      <div class="confirm-mission-skills-text"><?php
	  foreach ($preview_skills as $i=>$skills):
	  	echo $skills['skill_level']." ".$skills['name']."<br>";
	  endforeach;
      ?></div>
    </div>
    <div class="confirm-mission-files">
      <div class="confirm-mission-files-title">Files Included</div>
      <?php foreach($preview_files as $i=>$files): ?>
      <div class="confirm-mission-files-text">
        <div class="attach-file-tools"><img src="/public/images/codeArmy/mission/fileicon.png" class="fileicon" /> <span class="filename"><?=$files["file_name"]?></span></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="confirm-mission-assign-po">
    <input type="checkbox" />
    <label>Assigning this mission tp a Project Manager.</label>
  </div>
  <div class="submit-cancel-row"><input type="hidden" name="work_id" id="work_id" value="<?=$preview['work_id']?>" />
    <input type="button" class="lnkimg" id="edit-mission" value="Edit">
    <input type="submit" class="lnkimg" value="Confirm &amp; Upload">
  </div>
</div>
</form>
<script type="text/javascript">
$(function(){
	$('#edit-mission').click(function(){
		var mission_id = $('#work_id').val();
		
		parent.$.fancybox.showLoading();
		parent.$('.fancybox-iframe').attr('src','http://<?=$_SERVER['HTTP_HOST']?>/missions/edit_mission/'+mission_id);
	});
});
</script>