<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<div class="po-wall-container">
  <div class="top-panel">
    <div class="top-panel-left">
      <div class="top-panel-title"><?=ucwords($work['title'])?> <a class="fancybox" href="http://www.youtube.com/embed/<?=$work['tutorial']?$work['tutorial']:'zFNb8j3YAd4'?>?autoplay=1"><img src="/public/images/codeArmy/po/record-icon.png" /></a></div>
      <div class="proj-category"><?=ucfirst($work['category'].(($work['class'])?' > '.$work['class_name']:'').(($work['subclass'])?' > '.$work['subclass_name']:''))?></div>
      <div class="tabs-row"> <a href="#" class="wall-active">Wall</a> <a class="task" href="/missions/task/<?=$work['work_id']?>">Task</a> <a class="document" href="/missions/documents/<?=$work['work_id']?>">Document</a> <a class="date" href="/missions/dates/<?=$work['work_id']?>">Date</a> </div>
      <div class="desc-row"><?=$work['description']?></div>
    </div>
    <div class="top-panel-right">
		<?php
            //calc remaining time
            $remaining_time = strtotime($work['deadline'])-time();
            if($remaining_time<0)$remaining_time=0;
            //calc elappsed time
            $elappsed_time = time()-strtotime($work['assigned_at']);
            //calc total time he had during assignment
            $given_time = strtotime($work['deadline']) - strtotime($work['assigned_at']);
            if($given_time<0) $given_time = 1;
            
            $progress_percent = ($given_time==0)?0:$elappsed_time/$given_time;
            $progress_percent = ($progress_percent>0)?(($progress_percent>1)?1:$progress_percent):0;
            $remaining_hour = floor($remaining_time / (60*60));
            $remaining_min = $remaining_time % (60*60);
            $remaining_minutes = floor($remaining_min / (60));
            $min_to_percent = ($given_time==0)?0:(1*60)/($given_time);
        ?>
      <div class="progress-text">Progress: <?= round(100*$progress_percent) ?>%</div>
      <div class="wall-progress">
        <div class="wall-progress-bar" style="width:<?= round(222*$progress_percent) ?>px"></div>
      </div>
      <div class="bg_progress_summary">
        <div class="start-hours">
          <div class="start">
            <p class="wall-box-title">Start</p>
            <p><?=($work['started_at'])?date('j M Y',strtotime($work['started_at'])):''?></p>
          </div>
          <div class="hours">
            <p class="wall-box-title"><?=ucfirst(str_replace('dai','day',substr($work['arrangement_type'],0,-2)))?>s</p>
            <p><?=$work['bid_time']?></p>
          </div>
        </div>
        <div class="end-budget">
          <div class="end">
            <p class="wall-box-title">End</p>
            <p><?=date('j M Y',strtotime($work['deadline']))?></p>
          </div>
          <p class="wall-box-title">Budget</p>
          <p>$<?=$work['bid_cost']?>/<?=str_replace('dai','day',substr($work['arrangement_type'],0,-2))?></p>
          <div class="budget"></div>
        </div>
        <div class="po-info">
          <p class="wall-box-title">Mission Captain</p>
          <p class="po-name"><?=$po['username']?></p>
          <p class="level">Level <?=$this->gamemech->get_level($po['exp']);?></p>
        </div>
        <div class="po-avatar"><a href="/profile/show/<?=$po['username']?>"><img src="/public/images/codeArmy/po/default-avatar.png" /></a></div>
      </div>
    </div>
  </div>
  <div class="wall-bottom-panel">
    <div class="wall-bottom-left-side">
      <div class="find-mission-comment-box">
        <div class="find-mission-comment-box-left">
          <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
            <p><?=$this->gamemech->get_level($me['exp'])?></p>
          </div>
          <div class="find-mission-comment-name"><?=$me['username']?></div>
        </div>
		<?php 
            if($this->session->userdata('role')=='admin' || $this->session->userdata('user_id')==$work['work_horse'] || $this->session->userdata('user_id')==$work['owner']){
        ?>
        <div class="find-mission-comment-box-right">
          <div class="fmcb-right-textarea">
            <textarea id="discussion-message" rows="3">Share something with your team</textarea>
          </div>
          <div class="attach-tools-line"> <a href="#"><img src="/public/images/codeArmy/po/attach-link-icon.png" /></a> <img src="/public/images/codeArmy/po/divider.png" /> <a href="#"><img src="/public/images/codeArmy/po/attach-img-icon.png" /></a> <img src="/public/images/codeArmy/po/divider.png" /> <a href="#"><img class="attach-vid-ico" src="/public/images/codeArmy/po/attach-video-icon.png" /></a>
            <input type="text" class="attach-url" value="Enter a URL of your image" />
          </div>
          <img src="/public/images/codeArmy/loader4.gif" style="position:absolute; top:116px; right:48px;display:none" id="comment-ajax" />
          <input type="submit" id="discussion-submit" value="Share" class="lnkimg" />
        </div>
        <?php }?>
        <!--<div class="find-mission-comment-box-down">
          <div class="find-mission-down-box-row">
            <div class="find-mission-comment-box-left">
              <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
                <p>75</p>
              </div>
              <div class="find-mission-comment-name">Rolando</div>
            </div>
            <div class="find-mission-comment-box-right">
              <div class="comment-like-icon"><a href="#">3&nbsp;&nbsp;<img src="/public/images/codeArmy/po/comment-like-icon.png" /></a></div>
              <div class="fmcb-right-row1"> Check our new conceptual design! It's awesome! </div>
              <div class="fmcb-right-row2">
                <div class="commentime">5 minutes ago</div>
                <div class="replybut"><a href="#"><img src="/public/images/codeArmy/mission/reply-icon.png" /></a></div>
              </div>
              <div class="nested-comment">
                <div class="find-mission-down-box-row">
                  <div class="find-mission-comment-box-left">
                    <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
                      <p>75</p>
                    </div>
                  </div>
                  <div class="find-mission-comment-box-right">
                    <div class="comment-like-icon"><a href="#">1&nbsp;&nbsp;<img src="/public/images/codeArmy/po/nested-com-like.png" /></a></div>
                    <div class="fmcb-right-row1"> <a href="#">Mr. Product</a><br />
                      Great Job! </div>
                    <div class="fmcb-right-row2">
                      <div class="commentime">5 minutes ago</div>
                    </div>
                  </div>
                </div>
                <div class="find-mission-down-box-row">
                  <div class="find-mission-comment-box-left">
                    <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
                      <p>75</p>
                    </div>
                  </div>
                  <div class="find-mission-comment-box-right">
                    <div class="fmcb-right-row1">
                      <div class="fmcb-right-textarea">
                        <textarea rows="3">Add a comment</textarea>
                      </div>
                    </div>
                    <div class="fmcb-right-row2">
                      <div class="postcomment"><a href="#">Post</a></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>-->
        <?php foreach($comments as $comment):?>
        <div class="find-mission-comment-box-down" id="comment-<?=$comment['comment_id']?>">
          <div class="find-mission-down-box-row">
            <div class="find-mission-comment-box-left">
              <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
                <p class='find-mission-comment-level'><?=$this->gamemech->get_level($comment['exp'])?></p>
              </div>
              <div class="find-mission-comment-name"><?=$comment['username']?></div>
            </div>
            <div class="find-mission-comment-box-right">
              <!--<div class="comment-like-icon"><a href="#">2&nbsp;&nbsp;<img src="/public/images/codeArmy/po/comment-like-icon.png" /></a></div>-->
              <div class="fmcb-right-row1"><?=$comment['comment_body']?></div>
              <div class="fmcb-right-row2">
                <div class="commentime"><?=date('j M Y H:i',strtotime($comment['comment_created']))?></div>
                <!--<div class="replybut"><a href="#"><img src="/public/images/codeArmy/mission/reply-icon.png" /></a></div>-->
              </div>
            </div>
          </div>
        </div>
        <?php endforeach?>
        <div class="find-mission-comment-box-down" id="comment-template" style="display:none">
          <div class="find-mission-down-box-row">
            <div class="find-mission-comment-box-left">
              <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
                <p class='find-mission-comment-level'>75</p>
              </div>
              <div class="find-mission-comment-name">Rolando</div>
            </div>
            <div class="find-mission-comment-box-right">
              <!--<div class="comment-like-icon"><a href="#">2&nbsp;&nbsp;<img src="/public/images/codeArmy/po/comment-like-icon.png" /></a></div>-->
              <div class="fmcb-right-row1">I think I'm having a designer's block :( <br />
                <a href="#">http://www.flickr.com/nklj23/as23jknf.jpg</a> </div>
              <div class="fmcb-right-row2">
                <div class="commentime">3 minutes ago</div>
                <!--<div class="replybut"><a href="#"><img src="/public/images/codeArmy/mission/reply-icon.png" /></a></div>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="wall-bottom-right-side">
      <div class="wall-right-block-title">Recent Activity</div>
      <?php foreach($activities as $activity):?>
      <div class="wall-right-block-row" id="activity-<?=$activity['id']?>">
        <ul>
          <li><a href="/profile/show/<?=$activity['username']?>" class="wall-right-username"><?=$activity['username']==$me['username']?'You':$activity['username']?></a> <?=$activity['Desc']?> on <a href="/missions/wall/<?=$activity['work_id']?>"><?=$activity['title']?></a>.</li>
        </ul>
        <div class="wall-right-block-row2"><?=date('h:ia, d/m/Y',strtotime($activity['created_at']))?></div>
      </div>
      <?php endforeach;?>
      <div class="wall-right-block-row" id="activity-template" style="display:none">
        <ul>
          <li><a href="#" class="wall-right-username">Rolando</a> <span class="wall-right-desc">has added a file</span> on <a class="wall-right-work-link" href="#">Documents</a>.</li>
        </ul>
        <div class="wall-right-block-row2">7:30am, 12/06/2012</div>
      </div>
  </div>
</div>
</div>
<script type="text/javascript">
$(function(){
	var comment_channel = pusher.subscribe('comments');
	var activity_channel = pusher.subscribe('history');
	
	set_def_value($('#discussion-message'),"Share something with your team");
	set_def_value($('.attach-url'),"Enter a URL of your image");
	$('#discussion-submit').click(function(){
			var message = get_value('#discussion-message');
			var attach = get_value('.attach-url');
			if($.trim(message).length>2){
				//send
				$('#comment-ajax').fadeIn();
				$.ajax({
					url: '/missions/Ajax_comment',
					data: {'csrf_workpad': getCookie('csrf_workpad'),'message':message,'attach':attach, 'work_id':'<?=$work['work_id']?>'},
					type: 'post',
					success: function(msg){
						if(msg!="error"){
							//message created on server. waiting for push to send the object
							$('#comment-ajax').fadeOut();
							reset_value('#discussion-message');
							reset_value('.attach-url');
						}
					}
				});
			}
		});
		
	comment_channel.bind('new-comment-'+<?=$work['work_id']?>, function(data) {
		console.log(data);
		if(data.work_id=='<?=$work['work_id']?>'){
			var theme = $('#comment-template').clone();
			theme.find('.fmcb-right-row1').html(data.message);
			theme.find('.find-mission-comment-level').html(data.user_level);
			theme.find('.find-mission-comment-name').html(data.username);
			theme.find('.commentime').html(data.time);
			theme.attr('id','comment-'+data.comment_id);
			$('.find-mission-comment-box-down:first').before(theme);
			theme.slideDown();
		}
	});
	
	activity_channel.bind('new-activity-<?=$work['work_id']?>',function(data){
		if(data.work_id=='<?=$work['work_id']?>'){
			var theme = $('#activity-template').clone();
			theme.find('.wall-right-username').html(data.username=='<?=$me['username']?>'?'You':data.username);
			theme.find('.wall-right-username').attr('href','/profile/show/'+data.username);
			theme.find('.wall-right-desc').html(data.Desc);
			theme.find('.wall-right-work-link').html(data.work_title);
			theme.find('.wall-right-block-row2').html(data.time);
			theme.attr('id','activity-'+data.event_id);
			$('.wall-right-block-title').after(theme);
			theme.slideDown();
		}
	});
});

function set_def_value(el,val){
	$(el).focus(function(){if($(this).val()==val)$(this).val('');});
	$(el).blur(function(){if($.trim($(this).val())=='')$(this).val(val)});
	$(el).data('def_val',val)
}
function get_value(el){
	var el=$(el);
	return (el.val()==el.data().def_val)?'':el.val();
}
function reset_value(el){
	var el=$(el);
	el.val(el.data().def_val);
}
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
