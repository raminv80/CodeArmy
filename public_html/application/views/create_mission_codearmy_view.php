<link href="/public/css/CodeArmyV1/style.css" media="all" rel="stylesheet" type="text/css" />

<?php echo form_open('/missions/create_mission' , array('id'=>'form-create-mission')); ?>
<div class="create-mission-container">
  <div class="create-mission-title">Create Mission</div>
<span id="error" class="error">hello world</span>
  <div class="create-mission-info">
    <div class="mission-title">
      <label>Mission Title</label>
      <input type="text" id="mission-title" name="mission-title" value="" />
    </div>
    <div class="mission-video-url">
      <label>Mission Video</label>
      <input type="text" id="mission-video" name="mission-video" value="" />
    </div>
  </div>
  <div class="mission-desc-video">
    <div class="mission-description">
      <div><span class="desc-title-text">Description</span><span class="examples-link"><a href="#">Examples</a></span></div>
      <textarea rows="7" name="mission-desc-text"></textarea>
      <!--<div class="attach-file-tools"> <a href="#"><img src="/public/images/codeArmy/mission/fileicon.png" class="fileicon" /></a> <span class="filename"><a href="#">Project-brief.ppt</a></span> <span class="filesize">(250kb)</span> <span class="filedesc">Acme online store brief...</span> <a href="#"><img src="/public/images/codeArmy/mission/binicon.png" class="binicon" /></a> </div>-->
      <input type="button" id="attach-file" class="lnkimg" value="Attach">
    </div>
    <div class="mission-video-preview">
      <!--<iframe class="youtube-player" type="text/html" width="330" height="216" src="http://www.youtube.com/embed/zFNb8j3YAd4?wmode=opaque" frameborder="0"></iframe>-->
    </div>
  </div>
  <div class="mission-type-n-skills">
    <div class="mission-type"> <span class="mission-type-title">Mission Type</span>
      <select id="mission-type-main" class="mission-type-main">
      <?php foreach($main_category as $value): ?>
        <option value="<?=$value['category_id']?>"><?=$value['category']?></option>
      <?php endforeach; ?>
      </select>
      <select id="mission-type-sub" class="mission-type-sub">
      <?php foreach($sub_category as $value): ?>
        <option value="<?=$value['class_id']?>"><?=$value['class_name']?></option>
      <?php endforeach; ?>
      </select>
    </div>
    <div class="skills-required"> <span class="skills-required-title">Skills Required</span>
      <textarea rows="7" id="skills-required-text" name="skills-required-text"></textarea>
    </div>
  </div>
  <div class="mission-arrange-budget">
    <div class="mission-arrangements"> <span class="mission-arrange-title">Mission's Arrangements</span>
      <div class="arrange-row">
        <select id="mission-arrange-hour" class="mission-arrange-hour">
          <option>Hourly</option>
        </select>
        <span class="center-dash">-</span>
        <select id="mission-arrange-month" class="mission-arrange-month">
          <option>1-3 months</option>
        </select>
      </div>
    </div>
    <div class="mission-budget"> <span class="mission-budget-title">Budget</span>
      <div class="arrange-row">
        <select id="mission-budget" class="mission-budget">
          <option>30$ - 40$ / hour</option>
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
<script type="text/javascript">
$('#post-mission').click(function(){
	mission_title = $('#mission-title').val();
	mission_desc = $('#mission-desc-text').val();
	mission_type_main = $('#mission-type-main').val();
	mission_type_sub = $('#mission-type-sub').val();
	mission_arrange_hour = $('#mission-arrange-hour').val();
	mission_arrange_month = $('#mission-arrange-month').val();
	mission_budget = $('#mission-budget').val();
	assign_po = $('#assignpo').val();
	$.post(
		'/missions/check_create_mission',
		{ 'mission_title': mission_title, 'mission_desc': mission_desc, 'mission_type_main': mission_type_main, 'mission_type_sub': mission_type_sub, 'mission_arrange_hour': mission_arrange_hour, 'mission_arrange_month': mission_arrange_month, 'mission_budget': mission_budget, 'assign_po': assign_po },
		function(msg){
			if(msg=="success"){
				$('#form-create-mission').submit();
			} else {
				$('#error').html('Please enter mission title').show();
			}
		}
	);
});
</script>