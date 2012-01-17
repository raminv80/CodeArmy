<?php if($page_is=='story' && $action_is=='edit'){?>
<!-- Story Edit Footer -->
<header>
<div style="height:22px" class="footer">

<?php }elseif($page_is=='Contact' && $action_is!='find'){?>
<!-- contact us footer -->

<div style="height:22px" class="footer">
<?php }elseif(($action_is=='management' || $action_is=='story_management') && $page_is=='project'){?>
<!-- project management -->
<header>
<div class="footer">
<div class="WP-bottom-nav">
  <div class="WP-nav-placeholder-browsejob" style="width: 675px;">
    <div id="WP-nav-content" style="border-right: 3px;border-left:3px;padding-left:13px;;">
      <div id="myoffice"><a href="/myoffice"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0; border-right: 3px;">
      <div id="project-mgmt"><a href="/project/management"></a></div>
    </div>
    <div id="WP-nav-content" style="border-right: 3px;border-left:0;">
      <div id="editprofile"><a href="/profile/edit"></a></div>
    </div>
    <div id="WP-nav-content" style="border-right: 3px;border-left:0;">
      <div id="cashout"><a href="#"></a></div>
    </div>
    <div id="WP-nav-content" style="border-right: 3px;border-left:0;">
      <div id="logout"><a href="/login/logout"></a></div>
    </div>
  </div>
</div>
<?php }elseif(strtolower($page_is)=='login'){?>
<!-- login us footer -->
<div style="height:22px" class="footer">
<?php }elseif(strtolower($page_is)=='signup'){?>
<!-- about us footer -->
<div style="height:22px" class="footer">
<?php }elseif($page_is=='About'){?>
<!-- about us footer -->
<div style="height:22px" class="footer">
<?php }elseif($page_is=='Help'){?>
<!-- about us footer -->
<div style="height:22px" class="footer">
<?php }elseif($page_is=='Privacy'){?>
<!-- about us footer -->
<div style="height:22px" class="footer">
<?php }elseif($page_is=='T&C'){?>
<!-- terms footer -->
<div style="height:22px" class="footer">
<?php }elseif($page_is=='Contact' && $action_is=='find'){?>
<!-- find people footer -->

<header>
<div class="footer">
<div class="WP-bottom-nav">
  <div class="WP-nav-placeholder-browsejob">
    <div id="WP-nav-content" style="padding-left:10px;">
      <div id="design"><a href="#design" onclick="showCategory('R&D')"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="frontend"><a href="#apps" onclick="showCategory('Frontend')"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="backend"><a href="#sw" onclick="showCategory('Backend')"></a></div>
    </div>
    <div id="WP-nav-content" style="width:240px; border-left:0;">
      <div id="browsesearch"> <img align="center" style="margin-top: 10px; margin-left: 15px;"src="/public/images/searchingfor.png"> <?php echo form_open('/stories/browse' , array('class'=>'search-form', 'name' => "browse-tools-form", 'id'=>'browse-tools-form')); ?>
        <input id="browse-search" onfocus="cleanMe(this)" type="text" value="<?php if(isset($_POST['search']) && trim($_POST['search'])!=''){echo $_POST['search'];}else{?>Type and press ENTER<?php }?>" name="search">
        <script type="text/javascript">
			  	function cleanMe(input){if(input.value=='Type and press ENTER')input.value='';}
				function submitSearchForm(){$('#browse-tools-form').submit();}
				function showCategory(cat){$('input[name="type"]').val(cat);$('#browse-tools-form').submit();}
              </script>
        <input type="hidden" name="type" value="<?=(isset($_POST['category']))? $_POST['category']:'0'?>"/>
        <SELECT onchange="submitSearchForm()" type="text" id="time-left" name="time">
          <option <?php if(isset($_POST['time'])&& $_POST['time']==0){?>selected="selected"<?php }?> value="0">Any time left...</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==1){?>selected="selected"<?php }?> value="1">Less than an hour</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==2){?>selected="selected"<?php }?> value="2">Between 1 to 4 hours</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==3){?>selected="selected"<?php }?> value="3">Between 4 to 12 hours</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==4){?>selected="selected"<?php }?> value="4">Between 12 to 24 hours</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==5){?>selected="selected"<?php }?> value="5">Between 1 to 3 days</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==6){?>selected="selected"<?php }?> value="6">Between 3 to 7 days</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==7){?>selected="selected"<?php }?> value="7">More than a week</option>
        </SELECT>
        <SELECT onchange="submitSearchForm()" type="text" id="all-cat" name="project_sel">
          <option value="0">All Projects...</option>
          <?php foreach($projects as $project):?>
          <option <?php if(isset($_POST['project_sel'])&& $_POST['project_sel']==$project['project_id']){?>selected="selected"<?php }?> value="<?=$project['project_id']?>">
          <?=ucwords($project['project_name'])?>
          </option>
          <?php endforeach;?>
        </SELECT>
        <?php echo form_close(); ?> </div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="writingcontent"><a href="#writingcontent" onclick="showCategory('Copywrite')"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="test"><a href="#test" onclick="showCategory('Test')"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="find"><a href="/contact/find"></a></div>
    </div>
  </div>
</div>
<?php }elseif(($action_is=='submission' || $action_is=='done') && $page_is=='story'){?>
<!-- your footer for submission page -->
<header>
<style>
#submit-file {background: url(/public/images/submitlink.png);border: 0;width: 163px;padding: 0 10px 0 36px;height: 26px;margin: 5px 3px 0 0;}
#submit-zip {background: url(/public/images/upload-zip.png) no-repeat;
border: 0;
text-indent: -999px;
width: 211px;
height: 26px;
display: block;
padding-left: 115px;
font-family: DINregular;
font-size: 14px;}
.row {width:430px;}
.row img {padding-left:10px;}
</style>
<div class="footer">
<div class="WP-bottom-nav">
  <div class="WP-nav-placeholder-browsejob" style="width:1000px;">
    <div id="WP-nav-content" style="padding-left:13px;;">
      <div id="burndown"><a href="/project/burndown_chart/<?=$work_data['project_id']?>"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="scrum_board"><a href="/project/scrum_board/<?=$work_data['project_id']?>" id="board"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="essentials"><a href="#essentials" id="plan"></a></div>
    </div>
    <script type="text/javascript">function checkSubmitDone(){
			if(($('input[name="check1"]:checked').length>0)&&($('input[name="check2"]:checked').length>0)){return true;}
			else{alert('You need to check and agree to terms before submision!'); return false;}
		}</script> 
    <?php echo form_open_multipart('story/done', array('id'=>'submit_form', 'onsubmit'=>'return checkSubmitDone();'));?>
    <div id="WP-nav-content" style="width: 575px;; border-left:0;">
      <div style="padding: 20px 0 0 10px;">
        <div class="row">
          <input name="file_upload" type="file" id="submit-zip" value="browse">
          <input name="git" type="text" id="submit-file" onclick="this.value='';" onSetFocus="this.select()" value="Github link...">
          <input name="link" type="text" id="submit-file" onclick="this.value='';" value="Add link to file...">
        </div>
        <div class="row">
          <input type="checkbox" name="check1" value="edit-file">
          <img src="/public/images/tnc.png"></div>
        <div class="row">
          <input type="checkbox" name="check2" value="edit-file">
          <img src="/public/images/compile.png"></div>
        <input type="hidden" name="id" value="<?php echo $work_data['work_id']; ?>" />
        <input type="hidden" name="csrf" value="<?php echo md5('storyDone'); ?>" />
        <input class="hint_dev_step7" type="submit" value="submit" id="submitwork">
      </div>
    </div>
    <?php echo form_close(); ?> </div>
</div>
<!-- end of footer for submission page -->
<?php }elseif(strtolower($page_is)=='myoffice'){?>
<header>
<div class="footer">
<div class="WP-bottom-nav">
  <div class="WP-nav-placeholder-browsejob" style="width: 675px;">
    <div id="WP-nav-content" style="border-right: 3px;border-left:3px;padding-left:13px;;">
      <div id="mydesk"><a class="hint_dev_step5" href="javascript: show_tab('tab_4');"></a></div>
    </div>
    <div id="WP-nav-content" style="border-right: 3px;">
      <div id="project-mgmt"><a href="/project/management"></a></div>
    </div>
    <div id="WP-nav-content" style="border-right: 3px;border-left:0;">
      <div id="editprofile"><a href="/profile/edit"></a></div>
    </div>
    <div id="WP-nav-content" style="border-right: 3px;border-left:0;">
      <div id="cashout"><a href="#"></a></div>
    </div>
    <div id="WP-nav-content" style="border-right: 3px;border-left:0;">
      <div id="logout"><a href="/login/logout"></a></div>
    </div>
  </div>
</div>
<?php }elseif($action_is=='show' && $page_is=='project'){?>

<!-- your footer for project show page -->

<header>
<div class="footer">
<div class="WP-bottom-nav">
  <div class="WP-nav-placeholder-browsejob" style="width:415px;">
    <div id="WP-nav-content" style="padding-left:13px;;">
      <div id="burndown"><a href="/project/burndown_chart/<?=$project['project_id']?>"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="scrum_plan"><a href="/project/sprint_planner/<?=$project['project_id']?>" id="plan"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="scrum_board"><a href="/project/scrum_board/<?=$project['project_id']?>" id="board"></a></div>
    </div>
  </div>
</div>

<!-- end of footer for project show -->

<?php }elseif($action_is=='burndown_chart'){?>

<!-- start of burn chart footer -->
<style>
p#burndown {width:230px; text-align: left;
font-size: 20px;
font-weight: bold;
float: left;
padding: 0 5px 5px 10px;
color: black;
font-family: DINMediumAlternate;}
#project-select {margin: 0 0 10px 10px;
border-radius: 5px;
border: 0;
padding: 3px;}
</style>
<header>
<div class="footer">
<div class="WP-bottom-nav">
  <div class="WP-nav-placeholder-browsejob" style="width:666px;">
    <div id="WP-nav-content" style="padding-left:13px;;">
      <div id="burndown"><a href="/project/burndown_chart/<?=$project_sel?>"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="scrum_plan"><a href="/project/sprint_planner/<?=$project_sel?>" id="plan"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="scrum_board"><a href="/project/scrum_board/<?=$project_sel?>" id="board"></a></div>
    </div>
    <div id="WP-nav-content" style="width:240px; border-left:0;">
      <p style="margin-top: 10px;" id="burndown">Project:</p>
      <SELECT id="project-select" onchange="switchProject()" type="text" id="project_sel" name="project_sel">
      <?php if(count($projects)<1){?>
      <option>You have no Active Projects</option>
      <?php }else{?>
      <?php if($project_sel==0){?>
      <option value="0">Please Select a Project...</option>
      <?php }?>
      <?php foreach($projects as $project):?>
      <option <?php if(isset($project_sel)&& $project_sel==$project['project_id']){?>selected="selected"<?php }?> value="/project/scrum_board/<?=$project['project_id']?>">
      <?=ucwords($project['project_name'])?>
      </option>
      <?php endforeach;?>
      <?php }?>
      </SELECT>
      <script type="text/javascript">function switchProject(){window.location.assign($('#project_sel').val());}</script> 
      <script type="text/javascript">function sprintChart(){window.location.assign('/project/burndown_chart/<?=$project_sel?>/'+$('#sprintChart').val());}</script>
      <p id="burndown"> Sprint: </p>
      <select id="sprintChart"  name="sprint" onchange="sprintChart()" id="sprintChart">
      <?php foreach($sprints as $i=>$sprint):?>
      <option value="<?=$sprint['id']?>" <?php if($sprint_sel==$sprint['id']){?>selected="selected"<?php }?>>Sprint
      <?=$i+1;?>
      </option>
      <?php endforeach;?>
      </select>
    </div>
  </div>
</div>
<!-- end of burndown chart footer -->

<?php }elseif($action_is=='sprint_planner'){?>
<!-- your footer for SPRINTPLANNER is here -->

<?php if($project_owner){?>
<!-- project owner tools -->
<?php }elseif($scrum_master){?>
<!-- scrum_master tools -->
<?php }else{?>
<!-- developer tools -->
<?php }?>
<!-- Temporary for all show this footer -->
<style>
#project-select {margin: 5px 0 10px 13px;
border-radius: 5px;
border: 0;
padding: 3px;
width: 210px;}

</style>
<header>
<div class="footer">
<div class="WP-bottom-nav">
  <div class="WP-nav-placeholder-browsejob">
    <div id="WP-nav-content" style="padding-left:0;">
      <div id="home"><a href="/"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="myoffice"><a href="/myoffice"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="save"><a <?php if(!$project_owner){?>onclick="return false;"<?php }?> href="javascript: save_list();"></a></div>
    </div>
    <div id="WP-nav-content" style="width:240px; border-right: 0; border-left:0;">
      <div id="browsesearch"> <img align="center" style="margin-top: 10px; margin-left: 15px;"src="/public/images/searchingfor.png">
        <SELECT id="project-select" onchange="switchProject()" type="text" id="project_sel" name="project_sel">
        <?php if(count($projects)<1){?>
        <option>You have no Active Projects</option>
        <?php }else{?>
        <?php if($project_sel==0){?>
        <option value="0">Please Select a Project...</option>
        <?php }?>
        <?php foreach($projects as $project):?>
        <option <?php if(isset($project_sel)&& $project_sel==$project['project_id']){?>selected="selected"<?php }?> value="/project/scrum_board/<?=$project['project_id']?>">
        <?=ucwords($project['project_name'])?>
        </option>
        <?php endforeach;?>
        <?php }?>
        </SELECT>
        <script type="text/javascript">function switchProject(){window.location.assign($('#project_sel').val());}</script> 
        <div><input type="checkbox" name="autoscroll" id="autoscroll" value="1" onchange="auto_scroll(this.checked)" />Enable Auto Scroll</div>
        <script type="text/javascript">function auto_scroll(checked){if(checked){$('.story_list').hover(function(){$('#plan_holder').stop().scrollTo($(this),800, {over:-2});});}else{$('.story_list').off('hover');}}</script>
      </div>
    </div>
    <div id="WP-nav-content" style="padding-left:13px;;">
      <div id="burndown"><a href="/project/burndown_chart/<?=$project_sel?>"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="scrum_plan"><a href="/project/sprint_planner<?= ($project_sel)? '/'.$project_sel:''?>" id="plan"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="scrum_board"><a href="/project/scrum_board<?= ($project_sel)? '/'.$project_sel:''?>" id="board"></a></div>
    </div>
  </div>
</div>

<!-- end of footer for SPRINT PLANNER -->
<?php }elseif($action_is=='scrum_board'){?>
<!-- your footer for SCRUMBOARD page is here -->

<?php if($project_owner){?>
<!-- project owner tools -->
<?php }elseif($scrum_master){?>
<!-- scrum_master tools -->
<?php }else{?>
<!-- developer tools -->
<?php }?>
<!-- Temporary for all show this footer -->
<header>
<div class="footer">
<div class="WP-bottom-nav">
  <div class="WP-nav-placeholder-browsejob" style="width:935px;">
    <div id="WP-nav-content" style="padding-left: 10px;">
      <div id="home"><a href="/"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="myoffice"><a href="/myoffice"></a></div>
    </div>
   <!-- <div id="WP-nav-content" style="border-left:0;">
      <div id="save"><a href="#save"></a></div>
    </div>-->
    <div id="WP-nav-content" style="width:240px; border-right:0; border-left:0;">
      <div id="browsesearch"> <img align="center" style="margin-top: 10px; margin-left: 15px;"src="/public/images/searchingfor.png"> Project:
        <SELECT onchange="switchProject()" type="text" id="project_sel" name="project_sel">
          <?php if(count($projects)<1){?>
          <option>You have no Active Projects</option>
          <?php }else{?>
          <?php if($project_sel==0){?>
          <option value="0">Please Select a Project...</option>
          <?php }?>
          <?php foreach($projects as $project):?>
          <option <?php if(isset($project_sel)&& $project_sel==$project['project_id']){?>selected="selected"<?php }?> value="/project/scrum_board/<?=$project['project_id']?>">
          <?=ucwords($project['project_name'])?>
          </option>
          <?php endforeach;?>
          <?php }?>
        </SELECT>
        <script type="text/javascript">function switchProject(){window.location.assign($('#project_sel').val());}</script> 
        <script type="text/javascript">function sprintChart(){window.location.assign('/project/scrum_board/<?=$project_sel?>/'+$('#sprintChart').val());}</script> <br />
        Sprint:
        <select name="sprint" onchange="sprintChart()" id="sprintChart">
          <?php foreach($sprints as $i=>$sprint):?>
          <option value="<?=$sprint['id']?>" <?php if($sprint_sel==$sprint['id']){?>selected="selected"<?php }?>>Sprint
          <?=$i+1;?>
          </option>
          <?php endforeach;?>
        </select>
        <div><input type="checkbox" name="autoscroll" id="autoscroll" value="1" onchange="auto_scroll(this.checked)" />Enable Auto Scroll</div>
        <script type="text/javascript">function auto_scroll(checked){if(checked){$('.story_list').hover(function(){$('#board_holder').stop().scrollTo($(this),400, {over:-2});});}else{$('.story_list').off('hover');}}</script>
      </div>
    </div>
    <div id="WP-nav-content" style="padding-left:13px;;">
      <div id="burndown"><a href="/project/burndown_chart/<?=$project_sel?>"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="scrum_plan"><a href="/project/sprint_planner<?= ($project_sel)? '/'.$project_sel:''?>" id="plan"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="scrum_board"><a href="/project/scrum_board<?= ($project_sel)? '/'.$project_sel:''?>" id="board"></a></div>
    </div>
  </div>
</div>

<!-- end of footer for SCRUMBOARD page -->
<?php }elseif($action_is== 'browse'){?>
<!-- your footer for browse page is here -->

<header>
<div class="footer">
<div class="WP-bottom-nav">
  <div class="WP-nav-placeholder-browsejob">
    <div id="WP-nav-content" style="padding-left:10px;">
      <div id="design"><a href="#design" onclick="showCategory('R&D')"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="frontend"><a href="#apps" onclick="showCategory('Frontend')"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="backend"><a href="#sw" onclick="showCategory('Backend')"></a></div>
    </div>
    <div id="WP-nav-content" style="width:240px; border-left:0;">
      <div id="browsesearch"> <img align="center" style="margin-top: 10px; margin-left: 15px;"src="/public/images/searchingfor.png"> <?php echo form_open('/stories/browse' , array('class'=>'search-form', 'name' => "browse-tools-form", 'id'=>'browse-tools-form')); ?>
        <input id="browse-search" onfocus="cleanMe(this)" type="text" value="<?php if(isset($_POST['search']) && trim($_POST['search'])!=''){echo $_POST['search'];}else{?>Type and press ENTER<?php }?>" name="search">
        <script type="text/javascript">
			  	function cleanMe(input){if(input.value=='Type and press ENTER')input.value='';}
				function submitSearchForm(){$('#browse-tools-form').submit();}
				function showCategory(cat){$('input[name="type"]').val(cat);$('#browse-tools-form').submit();}
              </script>
        <input type="hidden" name="type" value="<?=(isset($_POST['category']))? $_POST['category']:'0'?>"/>
        <SELECT onchange="submitSearchForm()" type="text" id="time-left" name="time">
          <option <?php if(isset($_POST['time'])&& $_POST['time']==0){?>selected="selected"<?php }?> value="0">Any time left...</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==1){?>selected="selected"<?php }?> value="1">Less than an hour</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==2){?>selected="selected"<?php }?> value="2">Between 1 to 4 hours</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==3){?>selected="selected"<?php }?> value="3">Between 4 to 12 hours</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==4){?>selected="selected"<?php }?> value="4">Between 12 to 24 hours</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==5){?>selected="selected"<?php }?> value="5">Between 1 to 3 days</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==6){?>selected="selected"<?php }?> value="6">Between 3 to 7 days</option>
          <option <?php if(isset($_POST['time'])&& $_POST['time']==7){?>selected="selected"<?php }?> value="7">More than a week</option>
        </SELECT>
        <SELECT onchange="submitSearchForm()" type="text" id="all-cat" name="project_sel">
          <option value="0">All Projects...</option>
          <?php foreach($projects as $project):?>
          <option <?php if(isset($_POST['project_sel'])&& $_POST['project_sel']==$project['project_id']){?>selected="selected"<?php }?> value="<?=$project['project_id']?>">
          <?=ucwords($project['project_name'])?>
          </option>
          <?php endforeach;?>
        </SELECT>
        <?php echo form_close(); ?> </div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="writingcontent"><a href="#writingcontent" onclick="showCategory('Copywrite')"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="test"><a href="#test" onclick="showCategory('Test')"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="find"><a href="/contact/find"></a></div>
    </div>
  </div>
</div>

<!-- end of footer for browse page -->
<?php }elseif($page_is=='story' && $action_is=='show'){?>
<header>
<div class="footer">
<div class="WP-bottom-nav">
  <div class="WP-nav-placeholder-qualify" style="width:977px">
    <div id="WP-nav-content" style="padding-left:10px;">
      <div id="details"><a href="#pitch"></a></div>
    </div>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="tutorial"><a href="#user-stories"></a></div>
    </div>
    <div id="WP-nav-content" style="width:430px;border:0;">
      <?php if($this->session->userdata('user_id') && in_array($work_data['status'],array('open','Open','reject','Reject'))) echo form_open('story/setbid', array("id"=>"setBid")); ?>
      <div id="searcharea">
        <div style="margin-top:20px"><img src="/public/images/bidamountstory.png" />
          <?php
            $msg = $this->session->flashdata('bid_message');
            if(false && $msg){
                ?>
          <div class="" style="margin:10px; color:#F90;"> <?php echo $msg;?> </div>
          <?php }?>
          <input <?php if(!($this->session->userdata('user_id') && in_array(strtolower($work_data['status']),array('open','reject')))){?>disabled<?php }?> id="bid" name="set_cost" type="text" value="<?php echo $work_data['cost']; ?>" />
          <img src="/public/images/dayscommit.png" style="padding-right:40px;" />
          <input <?php if(!($this->session->userdata('user_id') && in_array(strtolower($work_data['status']),array('open','reject')))){?>disabled<?php }?> name="set_days" id="days" type="text" value="<?php $days = ($work_data['deadline'])? round((strtotime($work_data['deadline']) - strtotime(date("Y-m-d"))) / (60 * 60 * 24)) : 1; if($days<1)$days=1; echo $days?>"/>
          <input type="hidden" name="work_id" value="<?php echo $work_data['work_id'];?>" />
          <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>" id="user_id">
          <img style="padding:10px 10px 10px 5px;" src="/public/images/days.png" /> <img src="/public/images/ratedifficulty.png" />
          <div style="float: right;width:110px;margin: 8px 35px 0 0;"id="starating"> <span class="star<?php if($work_data['points']>0){?>-on<?php }?>"></span> <span class="star<?php if($work_data['points']>4){?>-on<?php }?>"></span> <span class="star<?php if($work_data['points']>7){?>-on<?php }?>"></span> <span class="star<?php if($work_data['points']>12){?>-on<?php }?>"></span> <span class="star<?php if($work_data['points']>19){?>-on<?php }?>"></span> </div>
          <img src="/public/images/easyhard.png" style="padding: 7px 0 0 75px;"/></div>
      </div>
    </div>
    <?php 
	//show only if story is open for bidding and user i slogged in
	if($this->session->userdata('user_id') && in_array($work_data['status'],array('open','Open','reject','Reject'))){
	?>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="bid"><a class="hint_dev_step3" id="btnBid" href="javascript:void(0)"></a></div>
    </div>
    <?php echo form_close(); ?>
    <?php }elseif(!$this->session->userdata('user_id')){?>
    <div id="WP-nav-content" style="border-left:0;">
      <?php $this->session->set_userdata('referer','/story/'.$work_data['work_id'])?>
      <div id="bid-login"><a href="/login" class="hint_dev_step3"></a></div>
    </div>
    <?php }else{?>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="bid-closed"><span>&nbsp;</span></div>
    </div>
    <?php }?>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="scrum_board"><a style="text-indent: -999px;margin: 20px 0 0;text-indent: -999px;background: url(/public/images/scrumboard.png) right top;width: 103px;height: 105px;display: block;" href="/project/scrum_board/<?=$work_data['project_id']?>" id="board"></a></div>
    </div>
  </div>
</div>
<?php }else{?>
<header>
  <div class="footer">
    <div class="WP-bottom-nav">
      <div class="WP-nav-placeholder">
        <div id="WP-nav-content" style="padding-left:10px;">
          <div id="home"><a href="#pitch"></a></div>
        </div>
        <div id="WP-nav-content" style="border-left:0;">
          <div id="US"><a href="#user-stories"></a></div>
        </div>
        <div id="WP-nav-content" style="border-left:0;">
          <div id="addnew"><a href="#addnewPrj"></a></div>
        </div>
        <?php if(!isset($username)){?>
        <div id="WP-nav-content" style="border-left:0;">
          <div id="reg"><a id="regbtn" href="#registerbox"></a></div>
        </div>
        <div id="WP-nav-content" style="border-left:0;">
          <div id="login"><a id="loginbtn" href="#loginbox"></a></div>
        </div>
        <?php }else{?>
        <div id="WP-nav-content" style="border-left:0;">
          <div id="myoffice"><a href="/myoffice"></a></div>
        </div>
        <div id="WP-nav-content" style="border-left:0;">
          <div id="logout"><a href="/login/logout"></a></div>
        </div>
        <?php }?>
      </div>
    </div>
    <?php }?>
    <!-- common footer section -->
    <?php if(isset($modal_message)){?>
    <div id="dialog-message" title="<?=isset($modal_title)? $modal_title: 'Workpad'?>">
      <p>
        <?=$modal_message?>
      </p>
    </div>
    <?php }?>
    
    <div class="footer-holder">
      <ul class="add-nav" >
        <li ><a href="/help">Help</a></li>
        <li ><a href="/privacy">Privacy</a></li>
        <li ><a href="/terms">T&amp;C</a></li>
        <li ><a href="/contact">Contact Us</a></li>
        <li><a href="http://blog.motionworks.com.my/">Blog</a></li>
        <?php if(!isset($username)){?>
        <li><a href="/login">Login</a></li>
        <?php }else{?>
        <li><a href="/login/logout">Logout</a></li>
        <?php }?>
        <?php if($this->session->userdata('role')=='admin'){?>
        <li><a href="/admin">Admin</a></li>
        <?php }?>
      </ul>
      <p>&copy;MOTIONWORKS SDN BHD 2011</p>
    </div>
  </div>
  <div id="modalDiv"></div>
  <?php if(!isset($modal_message)) $this->load->view('includes/hints'); ?>
  <?php $msg = $this->session->flashdata('alert');if($msg){?>
  <div class="alert">
    <div class="alert-content"> <?php echo $msg;?></div>
  </div>
  <?php }?>
</header>
</body>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/v4/footer_script.js"></script>
</html>
