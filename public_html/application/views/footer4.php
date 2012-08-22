<?php if($action_is=='show' && $page_is=='project'){?>

<!-- your footer for project show page -->
<header>
  <div class="footer">
    <div class="WP-bottom-nav">
      <div class="WP-nav-placeholder-browsejob" style="width:415px;">
      
      
        
        <div id="WP-nav-content" style="padding-left:13px;;">
          <div id="burndown"><a href="#"></a></div>
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
<header>
  <div class="footer">
    <div class="WP-bottom-nav">
      <div class="WP-nav-placeholder-browsejob">
      
        <div id="WP-nav-content" style="padding-left:0;">
          <div id="home"><a href="/"></a></div>
        </div>
        
        <div id="WP-nav-content" style="border-left:0;">
          <div id="myoffice"><a href="/myOffice"></a></div>
        </div>
        
        <div id="WP-nav-content" style="border-left:0;">
          <div id="sw"><a href="#sw"></a></div>
        </div>
        
        <div id="WP-nav-content" style="width:240px; border-left:0;">
          <div id="browsesearch">
          	<img align="center" style="margin-top: 10px; margin-left: 15px;"src="/public/images/searchingfor.png">
              <SELECT onchange="switchProject()" type="text" id="project_sel" name="project_sel">
              <?php if(count($projects)<1){?>
              	<option>You have no Active Projects</option>
              <?php }else{?>
                <?php if($project_sel==0){?>
                <option value="0">Please Select a Project...</option>
                <?php }?>
              	<?php foreach($projects as $project):?>
              		<option <?php if(isset($project_sel)&& $project_sel==$project['project_id']){?>selected="selected"<?php }?> value="/project/scrum_board/<?=$project['project_id']?>"><?=ucwords($project['project_name'])?></option>
                <?php endforeach;?>
              <?php }?>
              </SELECT>
              <script type="text/javascript">function switchProject(){window.location.assign($('#project_sel').val());}</script>
          </div>
        </div>
        
        <div id="WP-nav-content" style="border-left:0;">
          <div id="writingcontent"><a href="#writingcontent" onclick="showCategory('Copywrite')"></a></div>
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
      <div class="WP-nav-placeholder-browsejob">
      
        <div id="WP-nav-content" style="padding-left:0;">
          <div id="home"><a href="/"></a></div>
        </div>
        
        <div id="WP-nav-content" style="border-left:0;">
          <div id="myoffice"><a href="/myOffice"></a></div>
        </div>
        
        <div id="WP-nav-content" style="border-left:0;">
          <div id="sw"><a href="#sw"></a></div>
        </div>
        
        <div id="WP-nav-content" style="width:240px; border-left:0;">
          <div id="browsesearch">
          	<img align="center" style="margin-top: 10px; margin-left: 15px;"src="/public/images/searchingfor.png">
              <SELECT onchange="switchProject()" type="text" id="project_sel" name="project_sel">
              <?php if(count($projects)<1){?>
              	<option>You have no Active Projects</option>
              <?php }else{?>
                <?php if($project_sel==0){?>
                <option value="0">Please Select a Project...</option>
                <?php }?>
              	<?php foreach($projects as $project):?>
              		<option <?php if(isset($project_sel)&& $project_sel==$project['project_id']){?>selected="selected"<?php }?> value="/project/scrum_board/<?=$project['project_id']?>"><?=ucwords($project['project_name'])?></option>
                <?php endforeach;?>
              <?php }?>
              </SELECT>
              <script type="text/javascript">function switchProject(){window.location.assign($('#project_sel').val());}</script>
          </div>
        </div>
        
        <div id="WP-nav-content" style="border-left:0;">
          <div id="writingcontent"><a href="#writingcontent" onclick="showCategory('Copywrite')"></a></div>
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
          <div id="browsesearch">
          	<img align="center" style="margin-top: 10px; margin-left: 15px;"src="/public/images/searchingfor.png">
             <?php echo form_open('/stories/browse' , array('class'=>'search-form', 'name' => "browse-tools-form", 'id'=>'browse-tools-form')); ?>
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
              		<option <?php if(isset($_POST['project_sel'])&& $_POST['project_sel']==$project['project_id']){?>selected="selected"<?php }?> value="<?=$project['project_id']?>"><?=ucwords($project['project_name'])?></option>
                <?php endforeach;?>
              </SELECT>
             <?php echo form_close(); ?>
          </div>
        </div>
        
        <div id="WP-nav-content" style="border-left:0;">
          <div id="writingcontent"><a href="#writingcontent" onclick="showCategory('Copywrite')"></a></div>
        </div>
        
        <div id="WP-nav-content" style="border-left:0;">
          <div id="test"><a href="#test" onclick="showCategory('Test')"></a></div>
        </div>
        
        <div id="WP-nav-content" style="border-left:0;">
          <div id="find"><a href="#find"></a></div>
        </div>
       
       
      </div>
    </div>
   

<!-- end of footer for browse page -->
<?php }elseif($page_is=='story'){?>

<header>
<div class="footer">
<div class="WP-bottom-nav">
  <div class="WP-nav-placeholder-qualify">
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
            if($msg){
                ?>
          <div class="" style="margin:10px; color:#F90;"> <?php echo $msg;?> </div>
          <?php }?>
          <input <?php if(!($this->session->userdata('user_id') && in_array($work_data['status'],array('open','Open','reject','Reject')))){?>disabled<?php }?> id="bid" name="set_cost" type="text" value="<?php echo $work_data['cost']; ?>" />
          <img src="/public/images/dayscommit.png" style="padding-right:40px;" />
          <input <?php if(!($this->session->userdata('user_id') && in_array($work_data['status'],array('open','Open','reject','Reject')))){?>disabled<?php }?> name="set_days" id="days" type="text" value="<?php $days = ($work_data['deadline'])? round((strtotime($work_data['deadline']) - strtotime(date("Y-m-d"))) / (60 * 60 * 24)) : 1; if($days<1)$days=1; echo $days?>"/>
          <input type="hidden" name="work_id" value="<?php echo $work_data['work_id'];?>" />
          <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>" id="user_id">
          <img style="padding:10px 10px 10px 5px;" src="/public/images/days.png" /> <img src="/public/images/ratedifficulty.png" />
          
                <div style="float: right;width:110px;margin: 8px 35px 0 0;"id="starating">
                    <span class="star<?php if($work_data['points']>0){?>-on<?php }?>"></span>
                    <span class="star<?php if($work_data['points']>4){?>-on<?php }?>"></span>
                    <span class="star<?php if($work_data['points']>7){?>-on<?php }?>"></span>
                    <span class="star<?php if($work_data['points']>12){?>-on<?php }?>"></span>
                    <span class="star<?php if($work_data['points']>19){?>-on<?php }?>"></span>
                    </div><img src="/public/images/easyhard.png" style="padding: 7px 0 0 75px;"/></div>
      </div>
    </div>
    <?php 
	//show only if story is open for bidding and user i slogged in
	if($this->session->userdata('user_id') && in_array($work_data['status'],array('open','Open','reject','Reject'))){
	?>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="bid"><a id="btnBid" href="javascript:void(0)"></a></div>
    </div>
    <?php echo form_close(); ?>
    <?php }elseif(!$this->session->userdata('user_id')){?>
    <div id="WP-nav-content" style="border-left:0;">
      <?php $this->session->set_userdata('referer','/story/'.$work_data['work_id'])?>
      <div id="bid-login"><a href="/login"></a></div>
    </div>
    <?php }else{?>
    <div id="WP-nav-content" style="border-left:0;">
      <div id="bid-closed"><span>&nbsp;</span></div>
    </div>
    <?php }?>
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
          <div id="reg"><a href="#register"></a></div>
        </div>
        <div id="WP-nav-content" style="border-left:0;">
          <div id="login"><a href="#login"></a></div>
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
      </ul>
      <p>&copy;MOTIONWORKS SDN BHD 2011</p>
    </div>
  </div>
</header>
</body>
<script type="text/javascript">
	$('header').localScroll();
	var currentPage=0;
	$('#page'+currentPage).show();
	$(document).ready(function (){
		$('iframe').each(function(){
				var url = $(this).attr("src");
				$(this).attr("src",url+"?wmode=transparent");
		});
	});
	var test;
	
	$('a.submit').click(function(){
		test = $(this);
		var form = $(this).parents('form');
		if (typeof console == "object") console.log(form);
		form.submit();
	});
	$('#btnBid').click(function() {
	  $('#setBid').submit();
	});
</script>
</html>
