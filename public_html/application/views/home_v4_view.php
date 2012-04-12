<?php $this->load->view('includes/header4'); ?>
<!--<a id="feedbackbtn" href="#feedbackbox"><img class="feedback-button" src="/public/images/feedback.png" style="position:fixed; right: 0; padding-top: 90px;"></a>-->

<section id="pitch"><br />
  <div class="WP-main" style="margin-top:100px;">
    <div class="WP-total-amount-placeholder">
      <div class="calculator"> <span class="num-<?php echo ($total_projects_cash_loaded/1000000)%10;?>"><?php echo ($total_projects_cash_loaded/1000000)%10;?></span> <span class="num-<?php echo ($total_projects_cash_loaded/100000)%10;?>"><?php echo ($total_projects_cash_loaded/100000)%10;?></span> <span class="num-<?php echo ($total_projects_cash_loaded/10000)%10;?>"><?php echo ($total_projects_cash_loaded/10000)%10;?></span> <span class="num-<?php echo ($total_projects_cash_loaded/1000)%10;?>"><?php echo ($total_projects_cash_loaded/1000)%10;?></span> <span class="num-<?php echo ($total_projects_cash_loaded/100)%10;?>"><?php echo ($total_projects_cash_loaded/100)%10;?></span> <span class="num-<?php echo ($total_projects_cash_loaded/10)%10;?>"><?php echo ($total_projects_cash_loaded/10)%10;?></span> <span class="num-<?php echo $total_projects_cash_loaded%10;?>"><?php echo $total_projects_cash_loaded%10;?></span> </div>
      <div id="WP-count-caption"></div>
      <table id="total-number" cellpadding="5" border="0">
        <tr>
          <td><div id="WP-number-area"><?php echo number_format($total_contacts);?></div></td>
          <td>TOTAL CONTRACTS</td>
        </tr>
        <tr>
          <td><div id="WP-number-area"><?php echo number_format($total_online);?></div></td>
          <td>ONLINE USERS</td>
        </tr>
        <tr>
          <td><div id="WP-number-area"><?php echo number_format($total_active);?></div></td>
          <td>ACTIVE USERS</td>
        </tr>
      </table>
    </div>
    <div class="WP-leaderboard-placeholder">
      <div class="WP-leaderboard">
        <div id="mainheading"><span id="title">LEADERBOARD</span></div>
        <div id="heading">
          <div id="leaderboard-content"><table><tr><th><span id="title">Mission Completed</span></th><th><span id="title">Points Gained</span></th><th><span id="title">Early Submission</span></th></tr>
            <tr><td><ol>
              <?php foreach($leaderboard_project as $user):?>
              <li>
                
                   <table style="margin-top:-35px;"><tr><td><a href="/user/<?php echo $user['user_id'];?>"> <img style="margin-left: -5px; margin-top: 10px;"  src="<?php echo ($user['avatar'])? '/public/'.$user['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $user['email'] ) ) );?>" alt="profile picture" class="alignleft" width="39" height="39" /></a></td> <td style="vertical-align: bottom;"><div  style="width:100px;" class="info"><a href="/user/<?php echo $user['user_id'];?>" class="name"><?php echo $user['username'];?></a> <br>
                        <span><?php echo $user['num'];?> missions</span></div></td></tr></table>
              </li>
              <?php endforeach;?>
              </ol></td><td>
         <!-- </div>
          <div id="leaderboard-content"><span id="title">Points Gained</span>-->
            <ol>
              <?php foreach($leaderboard_points as $user):?>
              <li>
                <table style="margin-top:-35px;">
                  <tr>
                    <td><a href="/user/<?php echo $user['user_id'];?>"> <img style="margin-left: -5px; margin-top: 10px;" src="<?php echo ($user['avatar'])? '/public/'.$user['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $user['email'] ) ) );?>" alt="profile picture" class="alignleft" width="39" height="39" /></a></td>
                    <td style="vertical-align: bottom;"><div  style="width:100px;" class="info"> <a href="/user/<?php echo $user['user_id'];?>" class="name"><?php echo $user['username'];?></a> <br>
                        <span><?php echo $user['exp'];?> points</span> </div></td>
                  </tr>
                </table>
              </li>
              <?php endforeach;?>
            </ol></td><td>
         <!-- </div>
          <div id="leaderboard-content-last"><span id="title">Early Submission</span>-->
            <ol>
              <?php foreach($leaderboard_time as $user):?>
              <li>
               <table style="margin-top:-35px;">
                  <tr>
                    <td><a href="/user/<?php echo $user['user_id'];?>"> <img style="margin-left: -5px; margin-top: 10px;" src="<?php echo ($user['avatar'])? '/public/'.$user['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $user['email'] ) ) );?>" alt="profile picture" class="alignleft" width="39" height="39" /></a></td>
                    <td style="vertical-align: bottom;"><div  style="width:100px;" class="info"> <a href="/user/<?php echo $user['user_id'];?>" class="name"><?php echo $user['username'];?></a> <br>
                        <span><?php echo $user['exp'];?> hours</span> </div></td>
                  </tr>
                </table>
              </li>
              <?php endforeach;?>
            </ol></td></tr></table>
          </div>
        </div>
        <div class="row" style="margin: -5px 0 0 10px;">
          <div class="share-holder"><a name="fb_share" share_url="www.workpad.my"></a></div>
          <script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script> 
          <a href="/leaderboard" class="show">show full leaderboard</a> </div>
      </div>
    </div>
    <br>
    <div class="WP-howitworks">
      <h1>How it works</h1>
      <img src="/public/images/howitworks.png"></div>
  </div>
  <div class="push"></div>
</section>
<section style="padding-top:20px;" id="user-stories" class="user-stories">
  <div class="WP-main">
    <div id="slideshow"> <span class="control" id="leftControl" style="display: block; ">Clicking moves left</span>
      <div id="slidesContainer" style="overflow-x: hidden; overflow-y: hidden; ">
        <div id="slideInner" style="width: 2240px; margin-left: -1680px; ">
          <?php if(isset($featherlight) && $featherlight &&count($featherlight)>0){?>
          <div class="slide" style="float: left; width: 860px; "> <span id="slidetitle">FeatherLight Weight Jobs</span>
            <table width="860">
              <tr>
                <?php foreach($featherlight as $task):?>
                <td width="36%"><h3 id="h3slide">RM
                    <?=$task['cost']?>
                  </h3>
                  <br />
                  <p id="contentslide"><a href="/story/<?=$task['work_id'];?>">
                    <?=$task['project']?>
                    -->
                    <?=$task['title']?>
                    <br />
                    BID Deadline:
                    <?=date('d M Y',strtotime($task['bid_deadline']))?>
                    </a></p></td>
                <?php endforeach;?>
              </tr>
            </table>
          </div>
          <?php }?>
          <?php if(isset($lightweight) && $lightweight && count($lightweight)>0){?>
          <div class="slide" style="float: left; width: 860px; "> <span id="slidetitle">Lightweight Weight Jobs</span>
            <table width="860">
              <tr>
                <?php foreach($lightweight as $task):?>
                <td width="36%"><h3 id="h3slide">RM
                    <?=$task['cost']?>
                  </h3>
                  <br />
                  <p id="contentslide"><a href="/story/<?=$task['work_id'];?>">
                    <?=$task['project']?>
                    -->
                    <?=$task['title']?>
                    <br />
                    BID Deadline:
                    <?=date('d M Y',strtotime($task['bid_deadline']))?>
                    </a></p></td>
                <?php endforeach;?>
              </tr>
            </table>
          </div>
          <?php }?>
          <?php if(isset($heavyweight) && $heavyweight && count($heavyweight)>0){?>
          <div class="slide" style="float: left; width: 860px; "> <span id="slidetitle">Heavy Weight Jobs</span>
            <table width="860">
              <tr>
                <?php foreach($heavyweight as $task):?>
                <td width="36%"><h3 id="h3slide">RM
                    <?=$task['cost']?>
                  </h3>
                  <br />
                  <p id="contentslide"><a href="/story/<?=$task['work_id'];?>">
                    <?=$task['project']?>
                    -->
                    <?=$task['title']?>
                    <br />
                    BID Deadline:
                    <?=date('d M Y',strtotime($task['bid_deadline']))?>
                    </a></p></td>
                <?php endforeach;?>
              </tr>
            </table>
          </div>
          <?php }?>
        </div>
      </div>
      <span class="control" id="rightControl" style="display: none; ">Clicking moves right</span></div>
    <span id="title">Search Jobs</span>
    <div class="WP-searchbar"> <?php echo form_open('/stories/browse' , array('class'=>'search-form', 'name' => "browse-tools-form")); ?>
      <label>Search Jobs</label>
      <input id="input-search" type="text" name="search">
      <input id="search-button" name="Submit" type="button">
      <?php echo form_close(); ?> </div>
    <div class="WP-contract-placeholder">
      <div id="heading"><span id="title">Deadline</span><span style="width:620px;" id="title">Project Name > Job Title</span> <span style="width:100px;" id="title">bids</span> <span style="width:80px;" id="title">prize</span></div>
      <?php foreach($stories as $i=>$story):?>
      <?php if($i%$num_page==0 and $i!=0){?>
    </div>
    <?php }?>
    <?php if($i%$num_page==0){?>
    <div class="page" id="page<?=floor($i/$num_page)?>">
      <?php }?>
      <div class="story">
        <div class="accordionButton">
          <table class="us_accordion">
            <tr>
              <?php if($story['bid_deadline']){?>
              <td width="130px"><div id="day_date">
                  <?=date('d',strtotime($story['bid_deadline']))?>
                </div>
                <p>
                  <?=date('M Y',strtotime($story['bid_deadline']))?>
                </p></td>
              <?php }else{?>
              <td width="130px"><div id="day_date">&nbsp;</div>
                <p>&nbsp;</p></td>
              <?php }?>
              <td width="650px"><?=$story['project_name']?>
                ->
                <?=$story['title']?></td>
              <td width="90px"><?=$story['bids']?></td>
              <td>RM
                <?=$story['cost']?>
                <!-- BID indicator -->
                <?= (isset($my_bids)&&in_array($story['work_id'],$my_bids))?'<img src="/public/images/bid_indicator.png" class="bid_indicator">':'' ?>
              </td>
            </tr>
          </table>
        </div>
        <div class="accordionContent" style="display: none; ">
          <table class="accordion-table">
            <tr>
              <td style="border:0;" width="390px">Summary<br />
                <br />
                <?=substr(strip_tags($story['description']),0,255).'...'?></td>
              <td style="border:0;" ><table id="us-content">
                  <tr>
                    <td width="80%">Category</td>
                    <td><?=$story['category_name']?></td>
                  </tr>
                  <tr>
                    <td width="80%">Comments</td>
                    <td><?=$story['comments']?></td>
                  </tr>
                  <tr>
                    <td width="80%">Points</td>
                    <td><?=$story['points']?></td>
                  </tr>
                </table></td>
            </tr>
          </table>
          <div class="bid-more"><a href="/story/<?=$story['work_id']?>">Bid & More</a></div>
        </div>
      </div>
      <?php endforeach;?>
      <script type="text/javascript">var lastPage=<?=isset($i)? floor($i/$num_page):0?></script> 
    </div>
    <br />
    &nbsp; </div>
  </div>
  <div class="push"></div>
</section>
<section style="padding-top:20px;" id="addnewPrj">
  <div class="WP-main"><br />
    <div class="WP-comment-placeholder" style="width:500px">
      <div id="comment-top" style="width:490px"></div>
      <div id="comment-mid" style=" padding: 20px 20px 55px 20px; width:450px">
        <h1 style="margin: -50px 0 0 -15px;" id="title">Add New Projects</h1>
        <?php if(isset($username)) echo form_open_multipart('/', array('onsubmit'=>'return checkTerms();')); ?>
          <table cellpadding="3" style="font-size:0.9em">
          	<tr>
            	<td colspan="2" style="color:yellow"><?php echo validation_errors().$this->session->flashdata('contact'); ?></td>
            </tr>
            <?php /*ver4
            <tr>
              <td width="200px"><label>Name</label></td>
              <td><input id="form-home" type="text" name="name"></td>
            </tr>
            <tr>
              <td><label>Email</label></td>
              <td><input id="form-home" type="text" name="email"></td>
            </tr>
            <tr>
              <td><label>Contact</label></td>
              <td><input id="form-home" type="text" name="contact"></td>
            </tr> */?>
            <tr>
              <td><label>Project Title</label></td>
              <td><input <?php if(!isset($username)){?>disabled="disabled"<?php }?> id="form-home" type="text" name="title"></td>
            </tr>
            <tr>
              <td style="vertical-align:top"><label>Project Description</label></td>
              <td><textarea <?php if(!isset($username)){?>disabled="disabled"<?php }?> id="form-home2" name="description"></textarea></td>
            </tr>
            <?php /* ver4
            <tr>
              <td><label>Payment Budget</label></td>
              <td><input id="form-home" type="text" name="budget"></td>
            </tr>
            <tr>
              <td><label>Dateline</label></td>
              <td><input id="form-home" type="text" name="dateline"></td>
            </tr>
			*/?>
          </table>
          <?php if(isset($username)){?>
          <input type="hidden" name="action" value="create_project" />
          <?php }?>
          <input <?php if(!isset($username)){?>disabled="disabled"<?php }?> style="margin: 10px 0 0 5px;" type="checkbox" name="terms">
          <span style="padding-left:5px; font-size:0.9em;">I agree to the <a href="#">terms and condition</a></span><br>
          <br>
          <?php if(!isset($username)){?>
          <a href="/login">Login to Create your Project</a>
          <?php }else{?>
          <input id="submitform"  type="submit" value="Submit">
          <?php }?>
        <?php echo form_close();?>
      </div>
      <div id="comment-bottom" style="width:490px"></div>
    </div>
    <img width="495px" src="/public/images/scrum_steps.png">
    <div id="push-down">&nbsp;</div>
    <br />
    &nbsp; </div>
  </div>
  <div class="push"></div>
</section>

<!-- login -->
<div style="display:none">
	<div id="loginbox">
    	<a class="close" href="#1"><img src="/public/images/close.png" /></a>
			<?php echo form_open('login/validate_credentials' , array('class'=>'login-form')); ?>
              <?php if(isset($login_error)): ?>
              <div class="row"> <span style="color:#F60">Login Error: please check your username or password.</span> </div>
              <?php endif; ?>                  
              <div class="row">

                <div class="text">
                  <input id="username" name="username" value="<?php echo $this->input->post('username'); ?>" type="text">
                </div>
              </div>
              <div class="row">
                <div class="text">
                  <input name="password" id="password1" value="" type="password">
                </div>
              </div>
              <div class="row">  
				<a class="forgot" href="http://ver2.workpad.my/login/recovery">Forgot your password?</a>
                <input class="reg-submit" name="submit" value="Submit" type="submit">
              </div>
              <div class="clear"></div>
              <div class="goregister">
              		<p>Not a User? </p><a href="#registerbox" id="logintoreg">Register Now!</a>
              </div>
             <?php echo form_close(); ?>
    </div>
</div>



<div style="display:none">
	<div id="registerbox">
    	<a class="close" href="#1"><img src="/public/images/close.png" /></a>
			<?php echo form_open('signup', array('class'=>'register-form')); ?>
                            <div class="row">

                              <div class="text">
                                <input id="name" name="username" value="" type="text">
                              </div>
                            </div>
                            <div class="row">

                              <div class="text">
                                <input id="email" name="email" value="" type="text">
                              </div>
                            </div>
                            <div class="row">

                              <div class="text">
                                <input id="password2" name="password" value="" type="password">
                              </div>
                            </div>
                            <div class="row">
                              <div class="text">
                                <input id="password3" name="passconf" value="" type="password">
                              </div>
                            </div>
							<div class="captcha">
                              <?=$captcha;?>
                              <input id="captcha" name="captcha" type="text" value=""  />
							</div>
                            <input class="reg-submit" name="submit" value="Submit" type="submit">
                <?php echo form_close(); ?>
    </div>
</div>
<div style="display:none">
	<div id="feedbackbox">
    	<a class="close" href="#1"><img src="/public/images/close.png" /></a>
			<?php echo form_open('/home/feedback', array('class'=>'register-form')); ?>
                            <div class="row">

                              <div class="text">
                                <input id="name" name="name" value="" type="text">
                              </div>
                            </div>
                            <div class="row">

                              <div class="text">
                                <input id="email" name="email" value="" type="text">
                              </div>
                            </div>
                             <div class="row"><div class="text">
                               <textarea id="feedbacktext" name="desc"></textarea>
                              </div>
                            </div>
                            <div class="row">
							<div class="text">
                            	<input type="hidden" name="action" value="feedback" />
                                <input class="feedback-submit" name="submit" value="Submit" type="submit">
                              </div>
                            </div>
                <?php echo form_close(); ?>
    </div>
</div>

<link href="/public/css/v4/colorbox.css" media="all" rel="stylesheet" type="text/css">
<script type="text/javascript">
	
	$(document).ready(function(){
		   $("#regbtn").colorbox({inline:true, fixed:true, opacity:0.7});
		   $("#loginbtn").colorbox({inline:true, fixed:true, opacity:0.7});
		   $(".close").click(function(){
				$.colorbox.close();
			});
		   $("#logintoreg").colorbox({inline:true, fixed:true, opacity:0.7});
		   
		   $("#feedbackbtn").colorbox({inline:true, fixed:true, opacity:0.7});
		   Autopush();
		   $(window).resize(function(){Autopush();});
 		});
	
	function checkTerms(){
		test = $('input[name="terms"]:checked').length>0;
		if (!test) alert("Tp proceed you need to read and agree to the terms and conditions.");
		return test;
	}
	
	function show_home(){
		$('#register').hide();
		$('#login_block').hide();
		$('#pitch').slideDown(function(){$('#user-stories').slideDown(function(){$('#addnewPrj').slideDown(function(){$('#pitch').localScroll();});});});
	}
	function show_newPrj(){
		$('#register').hide();
		$('#login_block').hide();
		$('#pitch').slideDown(function(){$('#user-stories').slideDown(function(){$('#addnewPrj').slideDown(function(){$('#addnewPrj').localScroll();});});});
	}
	function show_us(){
		$('#register').hide();
		$('#login_block').hide();
		$('#pitch').slideDown(function(){$('#user-stories').slideDown(function(){$('#addnewPrj').slideDown(function(){$('#user-stories').localScroll();});});});
	}

	$(document).ready(function(){
		$('#reg').click(function(){show_reg();});
		$('#login').click(function(){show_login();});
		$('#addnew').click(function(){show_newPrj();});
		$('#US').click(function(){show_us();});
		$('#home').click(function(){show_home();});
	});

	$('.accordionButton').click(function(){
		$(this).next('.accordionContent').slideToggle();
	});
	$('header').localScroll();
	var currentPage=0;
	$('#page'+currentPage).show();
	page_numbers="<ul class='wp-pagination'>";
	for(i=1;i<=Math.min(5, lastPage+1);i++){
		page_numbers+="<li class='wp-page-num' id='wp-page-num-"+i+"'><a href='javascript:goto_page("+(i-1)+");'>"+i+"</a></li>";
	}
	page_numbers+="</ul>";
	$('.page').append("<div class='wp-pagination'><div class='wp-previous-page'><a href='javascript: void(0);' class='pre-page'>&lt; Previous Page</a></div><div class='wp-page-numbers'>"+page_numbers+"</div><div class='wp-next-page'><a href='javascript: void(0);' class='nxt-page'>Next Page &gt;</a></div></div>");
	//$('.page').prepend("<div class='wp-previous-page'><a href='javascript: void(0);' class='pre-page'>&lt; Previous Page</a></div>");
	managePagination(currentPage);
	function managePagination(currentPage){
		if(currentPage==0)$('.pre-page','#page'+currentPage).hide(); else $('.wp-previous-page','#page'+currentPage).show();
		if(currentPage==lastPage)$('.nxt-page','#page'+currentPage).hide(); else $('.wp-next-page','#page'+currentPage).show();
		page_numbers="<ul class='wp-pagination'>";
		for(i=Math.max(1,Math.min(lastPage-5,currentPage-1));i<=Math.min(lastPage+1, Math.max(5,currentPage+3));i++){
			page_numbers+="<li class='wp-page-num' id='wp-page-num-"+i+"'><a href='javascript:goto_page("+(i-1)+");'>"+i+"</a></li>";
		}
		page_numbers+="</ul>";
		$('.wp-page-numbers').html(page_numbers);
		$('.wp-page-num').removeClass('active');
		$('#wp-page-num-'+(currentPage+1)).addClass('active');
	}
	$('.nxt-page').click(function(){
			$('#page'+currentPage).slideUp();
			currentPage++;
			managePagination(currentPage);
			if(currentPage>lastPage)currentPage=0;
			$('#page'+currentPage).slideDown();
		});
	$('.pre-page').click(function(){
			$('#page'+currentPage).slideUp();
			currentPage--;
			managePagination(currentPage);
			if(currentPage<0)currentPage=lastPage;
			$('#page'+currentPage).slideDown();
		});
	function goto_page(i){
		$('#page'+currentPage).slideUp();
		currentPage=i;
		managePagination(currentPage);
		if(currentPage<0)currentPage=lastPage;
		$('#page'+currentPage).slideDown();
	}
	
	function Autopush(){
		$('section div.push').each(function(){
			h = $(window).height() - $(this).parent().height()-170-105;
			if(h>0) $(this).height(h);
		});
	}
	
	function Cancelpush(){
		$('section div.push').each(function(){$(this).height(0);});
	}
</script>
<?php $this->load->view('includes/footer4'); ?>
