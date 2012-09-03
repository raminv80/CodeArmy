<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<style>
#mymission-content-area{
	/*background:url(/public/images/codeArmy/profile/missions/temp.png) no-repeat;*/
	width:760px;
}
#main-content { overflow:scroll;}
#mymission-content-area .block-header h3 {
	margin:1px 5px;
	height: 33px;
	font-size:12.96pt;
	color:white;
	font-family:'Ruda', sans-serif;
	text-shadow: 0px 0px 3px rgba(255, 255, 255, 0.5);
	display:block;
	width:229px;
	height:33px;
	float:left;
	background:url(/public/images/codeArmy/profile/block-header-line.png) no-repeat;
}
#mymission-content-area div.list{
	clear:both;
}
#mymission-content-area div.list .item{
	float: left;
	width:246px;
	height:302px;
	margin: 13px 6px 52px 0;
}
#block-mission-list .list .item.gray-mission{background:url(/public/images/codeArmy/mymission/gray-mission.png) no-repeat;}
#block-mission-list .list .item.green-mission{background:url(/public/images/codeArmy/mymission/green-mission.png) no-repeat;}
#block-mission-list .list .item.orange-mission{background:url(/public/images/codeArmy/mymission/orange-mission.png) no-repeat;}
#block-mission-list .list .item.red-mission{background:url(/public/images/codeArmy/mymission/red-mission.png) no-repeat;}
#block-mission-list .mission-header{position:relative}
#block-mission-list .mission-title{
	text-shadow: -1px -1px 1px rgba(100,100,100,0.5);
	font-size:11pt;
	color:white;
	position:absolute;
	top:15px;
	left: 15px;
	width:180px;
	text-align:justify;
	font-weight:bold;
}
#block-mission-list .mission-inputs{
	font-size:9.36pt;
	color:white;
	position:absolute;
	top:85px;
	left:15px;	
}
#block-mission-list .mission-deliverables{
	font-size:9.36pt;
	color:white;
	position:absolute;
	top:100px;
	left:15px;	
}
#block-mission-list .mission-content{
	position:relative;
	top:130px;
	height:170px;
}
#block-mission-list ul.mission-icons {
	margin: 5px;
}
#block-mission-list  ul.mission-icons li{
	float: left;
	display: block;
	margin: 0 0 3px 4px;
	width: 100px;
	height: 30px;
}
#block-mission-list .mission-icons .icon{
	display: block;
	width: 28px;
	height: 29px;
	float: left;
	margin: 5px 0 0 5px;
}
#block-mission-list .mission-icons .title{
	display: block;
	width: 60px;
	height: 15px;
	float: left;
	margin: 11px 0 0 7px;
	font-size:8.64pt;
}
#block-mission-list .mission-time{
	clear:both;
	position:relative;
	display:block;
	height:80px;
	padding:10px;
}
#block-mission-list .mission-time{color:white}
#block-mission-list .mission-time .time-left{
	font-size:7.2pt;
	position:absolute;
	top:39px;
}
#block-mission-list .mission-time .time{
	font-size:18pt;
}
#block-mission-list .mission-time .hrs{
	font-size:12pt;
}
#block-mission-list .timer{
	position:absolute;
	top:55px; 
	left:7px;
}
#block-mission-list .mission-progress-bg{
	position: absolute;
	top: 59px;
	height: 13px;
	left: 15px;
	width: 216px;
}
#block-mission-list .mission-progress-meter{
	background:url(/public/images/codeArmy/mymission/progress-meter-bg.png);
	width:100px;
	height:13px;
	border-radius: 5px; 
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px;
}
#block-mission-list .blue-button{
	background: url(/public/images/codeArmy/mymission/Blue-button1.png) no-repeat;
	width: 114px;
	height: 48px;
	display: block;
	position: absolute;
	top: 38px;
	right: 20px;
	text-align: center;
	padding: 16px 0;
	font-size:10pt;
}
#block-mission-list .blue-button:hover{
	background: url(/public/images/codeArmy/mymission/Blue-button1-up.png) no-repeat;
}
.mission-status-icon {
	position: absolute;
	top: 8px;
	right: 15px;
}
#dummy-create-mission{
	float: left;width: 246px;height: 302px;margin: 13px 6px 52px 0;border:2px dashed #09F;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	cursor:pointer;
	color:white;
	font-size: 16pt;
	line-height: 301px;
	text-align: center;
   transition: font-size .15s ease-in-out,background .15s ease-in-out,color .15s ease-in-out;
   -moz-transition: font-size .15s ease-in-out,background .15s ease-in-out,color .15s ease-in-out;
   -webkit-transition: font-size .15s ease-in-out,background .15s ease-in-out,color .15s ease-in-out;
}
#dummy-create-mission:hover{
	background: rgb(0, 176, 255); /* The Fallback */
	background: rgba(0, 176, 255, 0.1);
	color:white;
	font-size:18pt;
	text-shadow:0px 0px 3px white;
}
</style>
<div id="mymission-content-area">
	<div id="block-mission-list">
    	<div class="block-header">
        	<h3>My Missions</h3>
            <?php if($me['role']=='po' || $me['role']=='admin'){?>
            <div style="float:right;">
            <select id="mission-status" style="width:150px" onchange="window.location='/missions/my_missions/'+$(this).val()">
            	<option <?php if($status=='All'){?>selected="selected"<?php }?> value="All">All (<?=$this->work_model->get_num_state('All')?>)</option>
                <option <?php if($status=='In_Progress'){?>selected="selected"<?php }?> value="In_Progress">In Progress (<?=$this->work_model->get_num_state('in progress')?>)</option>
                <option <?php if($status=='Pending'){?>selected="selected"<?php }?> value="Pending">Pending  (<?=$this->work_model->get_num_state(array('assigned','open','done','verify','reject'))?>)</option>
                <option <?php if($status=='Draft'){?>selected="selected"<?php }?> value="Draft">Drafts  (<?=$this->work_model->get_num_state('draft')?>)</option>
                <option <?php if($status=='Completed'){?>selected="selected"<?php }?> value="Completed">Completed (<?=$this->work_model->get_num_state('signoff')?>)</option>
            </select>
            </div>
            <?php }?>
        </div>
        <div class="list">
        	<?php
			if($myProfile["params"] != ""){
				$params = json_decode($myProfile["params"]);
				$hideSample = $params->hidesample;
			} else {
				$hideSample = false;
			}
			if($me['role']=='po' && $hideSample != true){ ?>
        	<!-- Sample Mission : Begin -->
            <div class="item gray-mission" id="mission-sample">
            	<div class="mission-header">
                	<div class="mission-title">Sample Mission</div>
                    <div class="mission-status-icon"><img src="/public/images/codeArmy/mymission/thumb-up.png" alt="thumb up" /></div>
                    <div class="mission-progress-bg">
                    	<div class="mission-progress-meter" style="width:0px"></div>
                        <input type="hidden" name="percent" value="0" />
                        <input type="hidden" name="min_to_percent" value="0" />
                    </div>
                    <div class="mission-inputs">Proposed Timeline: 1 month</div>
                    <div class="mission-deliverables">Proposed Reward: 20$/month</div>
                </div>
                <div class="mission-content">
                	<ul class="mission-icons">
                		<li><a href="#"><span class="icon"></span><span class="title">Captain</span></a></li>
                        <li><a href="#" title="You are competing with 1 trooper(s) on this mission!"><span class="icon"></span><span class="title">1 Troop(s)</span></a></li>
                        <li><a href="#"><span class="icon"></span><span class="title">Discussion</span></a></li>
                        <li><a href="#"><span class="icon"></span><span class="title">Attachements</span></a></li>
                    </ul>
                    <div class="mission-time">
                    	<span class="time-left">Time left</span>
                        <div class="timer">
                        <span class="time">720</span>
                        <span class="hrs">hrs</span>
                        </div>
                        <a href="javascript:void(0);" id="removeSample" class="blue-button">Remove</a>
                    </div>
                </div>
            </div>
            <!-- Sample Mission : End -->
            <?php } ?>
            
        	<?php foreach($myPendingList as $list):?>
            <div class="item gray-mission" id="mission-<?=$list['work_id']?>">
            	<div class="mission-header">
                	<div class="mission-title"><?=character_limiter($list['title'],20)?></div>
                    <div class="mission-status-icon"><img src="/public/images/codeArmy/mymission/thumb-up.png" alt="thumb up" /></div>
                    <div class="mission-progress-bg">
                    	<div class="mission-progress-meter" style="width:0px"></div>
                        <input type="hidden" name="percent" value="0" />
                        <input type="hidden" name="min_to_percent" value="0" />
                    </div>
                    <?php
						$proposal = $this->work_model->get_approved_bid($me['user_id'],$list['work_id']);
						$proposal = $proposal[0];
						$arrangement = $this->work_model->get_work_arrangement($list['work_id']);
						$arrangement = str_replace('dai','day',substr($arrangement,0,-2)).'s';
						$troopers = $this->work_model->get_num_troopers($list['work_id']);
					?>
                    <div class="mission-inputs">Proposed Timeline: <?=$proposal['bid_time'].' '.$arrangement?></div>
                    <div class="mission-deliverables">Proposed Reward: <?=$proposal['bid_cost'].'$/'.$arrangement?></div>
                </div>
                <div class="mission-content">
                	<ul class="mission-icons">
                		<li><a href="#"><span class="icon"></span><span class="title">Captain</span></a></li>
                        <li><a href="#" title="You are competing with <?=$troopers?> trooper(s) on this mission!"><span class="icon"></span><span class="title"><?=$troopers?> Troop(s)</span></a></li>
                        <li><a href="#"><span class="icon"></span><span class="title">Discussion</span></a></li>
                        <li><a href="#"><span class="icon"></span><span class="title">Attachements</span></a></li>
                    </ul>
                    <div class="mission-time">
                    	<span class="time-left">Time left</span>
                        <div class="timer">
                        <span class="time"></span>
                        <span class="hrs">hrs</span>
                        </div>
                        <!-- Accept -->
                        <a href="javascript:void(0)" style="right:7px" class="accept blue-button">Accept</a>
                        <!-- Reject -->
                        <a href="javascript:void(0);" style="right:126px" class="reject blue-button">Reject</a>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
			
			<?php foreach($myWorkList as $list):?>
            <div class="item gray-mission" id="mission-<?=$list['work_id']?>">
            	<?php
					//calc remaining time
					$remaining_time = strtotime($list['deadline'])-time();
					if($remaining_time<0)$remaining_time=0;
					//calc elappsed time
					$elappsed_time = time()-strtotime($list['assigned_at']);
					//calc total time he had during assignment
					$given_time = strtotime($list['deadline']) - strtotime($list['assigned_at']);
					if($given_time<0) $given_time = 1;
					
					$progress_percent = ($given_time==0)?0:$elappsed_time/$given_time;
					$progress_percent = ($progress_percent>0)?(($progress_percent>1)?1:$progress_percent):0;
					$remaining_hour = floor($remaining_time / (60*60));
					$remaining_min = $remaining_time % (60*60);
					$remaining_minutes = floor($remaining_min / (60));
					$min_to_percent = ($given_time==0)?0:(1*60)/($given_time);
				?>
            	<div class="mission-header">
                	<div class="mission-title"><?=character_limiter($list['title'],20)?></div>
                    <div class="mission-status-icon"><img src="/public/images/codeArmy/mymission/thumb-up.png" alt="thumb up" /></div>
                    <div class="mission-progress-bg">
                    	<div class="mission-progress-meter" style="width:<?= round(216*$progress_percent) ?>px"></div>
                        <input type="hidden" name="percent" value="<?=$progress_percent?>" />
                        <input type="hidden" name="min_to_percent" value="<?=$min_to_percent?>" />
                    </div>
                    <?php
						$proposal = $this->work_model->get_approved_bid($me['user_id'],$list['work_id']);
						$proposal = $proposal[0];
						$arrangement = $this->work_model->get_work_arrangement($list['work_id']);
						$arrangement = str_replace('dai','day',substr($arrangement,0,-2)).'s';
						$troopers = $this->work_model->get_num_troopers($list['work_id']);
					?>
                    <div class="mission-inputs">Proposed Timeline: <?=$proposal['bid_time'].' '.$arrangement?></div>
                    <div class="mission-deliverables">Proposed Reward: <?=$proposal['bid_cost'].'$/'.$arrangement?></div>
                </div>
                <div class="mission-content">
                	<ul class="mission-icons">
                    	<?php $user = $this->users_model->get_user($list['owner'])->result_array();?>
                		<li><a href="/messages/compose/<?=$user[0]['username']?>"><span class="icon"></span><span class="title">Captain</span></a></li>
                        <li><a href="#" title="You are competing with <?=$troopers?> trooper(s) on this mission!"><span class="icon"></span><span class="title"><?=$troopers?>Troops</span></a></li>
                        <li><a href="/missions/wall/<?=$list['work_id']?>"><span class="icon"></span><span class="title">Discussion</span></a></li>
                        <li><a href="/missions/documents/<?=$list['work_id']?>"><span class="icon"></span><span class="title">Attachements</span></a></li>
                    </ul>
                    <div class="mission-time">
                    	<span class="time-left">Time left</span>
                        <div class="timer">
                        <span class="time"><?=($remaining_hour<24)?$remaining_hour.':'.$remaining_minutes:$remaining_hour?></span>
                        <span class="hrs">hrs</span>
                        </div>
                        <?php if(in_array(strtolower($list['status']),array('in progress','done','redo','signoff','verify'))){?>
                        <a href="/missions/wall/<?=$list['work_id']?>" class="blue-button">Check in</a>
                        <?php }?>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            
            <?php foreach($myMissions as $list):
				$color = (in_array(strtolower($list['status']),array('draft')))?'red':'green';
				$color = (in_array(strtolower($list['status']),array('signoff')))?'grey':$color;
			?>
            <div class="item <?=$color?>-mission" id="mission-<?=$list['work_id']?>">
            	<?php
					//calc remaining time
					$remaining_time = strtotime($list['deadline'])-time();
					if($remaining_time<0)$remaining_time=0;
					//calc elappsed time
					$elappsed_time = time()-strtotime($list['assigned_at']);
					//calc total time he had during assignment
					$given_time = strtotime($list['deadline']) - strtotime($list['assigned_at']);
					if($given_time<0) $given_time = 1;
					
					$progress_percent = ($given_time==0)?0:$elappsed_time/$given_time;
					$progress_percent = ($progress_percent>0)?(($progress_percent>1)?1:$progress_percent):0;
					$remaining_hour = floor($remaining_time / (60*60));
					$remaining_min = $remaining_time % (60*60);
					$remaining_minutes = floor($remaining_min / (60));
					$min_to_percent = ($given_time==0)?0:(1*60)/($given_time);
					
					$po = ($me['user_id']==$list['owner']);
					
				?>
            	<div class="mission-header">
                	<div class="mission-title"><?=character_limiter($list['title'],20)?></div>
                    <div class="mission-status-icon"><?=$list['status']?></div>
                    <div class="mission-progress-bg">
                    	<div class="mission-progress-meter" style="width:<?= round(216*$progress_percent) ?>px"></div>
                        <input type="hidden" name="percent" value="<?=$progress_percent?>" />
                        <input type="hidden" name="min_to_percent" value="<?=$min_to_percent?>" />
                    </div>
                    <?php 
						if(in_array(strtolower($list['status']),array('draft','open','assigned'))){
							$arr = $this->work_model->get_work_arrangement($list['work_id']);
							$arranegement = $arr;
							$estimate_time = $this->work_model->get_selected_arrangement_time($list['est_time_frame']);
							if(!$estimate_time){$estimate_time=0;} else {$estimate_time = $estimate_time[0];}
							$estimate_budget = $this->work_model->get_selected_arrangement_budget($list['est_budget']);
							if(!$estimate_budget){$estimate_budget=0;} else {$estimate_budget = $estimate_budget[0];}
					?>
                    <div class="mission-inputs">About <?=($estimate_time['time_cal'])?$estimate_time['time_cal']:'?'?> <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s, <?=($estimate_budget['amount_cal'])?$estimate_budget['amount_cal']:'?'?>$ per <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s</div>
                    <div class="mission-deliverables"></div>
                    <?php 
						}else{
							$arr = $this->work_model->get_work_arrangement($list['work_id']);
							$arranegement = $arr;
							$time_cost = $this->work_model->get_actual_work_time_cost($list['work_id']);
							if(!$time_cost){$estimate_time=0;} else {$estimate_time = $time_cost['bid_time'];}
							if(!$time_cost){$estimate_budget=0;} else {$estimate_budget = $time_cost['bid_cost'];}
					?>
                    <div class="mission-deliverables"><?=($estimate_time['time_cal'])?$estimate_time['time_cal']:'?'?> <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s, <?=($estimate_budget['amount_cal'])?$estimate_budget['amount_cal']:'?'?>$ per <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s</div>
                    <?php }?>
                </div>
                <div class="mission-content">
                	<ul class="mission-icons">
                    	<?php if($po){?>
                         <li><a href="#"><span class="icon"></span><span class="title">Captain</span></a></li>
                        <li><a href="/missions/applicants/<?=$list['work_id']?>"><span class="icon"></span><span class="title "><span class="bidders-<?=$list['work_id']?>"><?=$list['bids']?></span> Bidders</span></a></li>
                        <li><a href="#"><span class="icon"></span><span class="title">Discussion</span></a></li>
                        <li><a href="#"><span class="icon"></span><span class="title">Attachements</span></a></li>
                        <?php }else{?>
                		<li><a href="#"><span class="icon"></span><span class="title">Captain</span></a></li>
                        <li><a href="#"><span class="icon"></span><span class="title">1 Trooper</span></a></li>
                        <li><a href="#"><span class="icon"></span><span class="title">Discussion</span></a></li>
                        <li><a href="#"><span class="icon"></span><span class="title">Attachements</span></a></li>
                        <?php }?>
                    </ul>
                    <div class="mission-time">
                    	<span class="time-left">Time left</span>
                        <div class="timer">
                        <span class="time"><?=($remaining_hour<24)?$remaining_hour.':'.$remaining_minutes:$remaining_hour?></span>
                        <span class="hrs">hrs</span>
                        </div>
                        <?php if($po && (strtolower($list['status'])=='open' || strtolower($list['status'])=='assigned' || strtolower($list['status'])=='draft')){//TODO: if in open, assigned status allow edit but send alert to bidders on change?>
                        	<a class="blue-button" href="/missions/manage/<?=$list['work_id']?>">Manage</a>
                        <?php }else{?>
                        	<a href="/missions/wall/<?=$list['work_id']?>" class="blue-button">Check in</a>
                        <?php }?>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            <?php if(($this->session->userdata('role')=='po'||$this->session->userdata('role')=='admin')){?>
            <a href="/missions/create" class="fancybox" id="FindMissions">
            <div id="dummy-create-mission">
            	<i class="icon-plus-sign"></i> Create Mission
            </div>
            </a>
            <?php }?>
        </div>
    </div>
</div>
<div id="dialog-confirm" class="dialog" title="Mission Agreement">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Do you agree to accept and deliver this mission?</p>
</div>
<div id="dialog-reject" class="dialog" title="Mission rejection">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure you want to reject this mission?</p>
</div>
<script>
	var selectedItem;
	$(function(){
		$('#mission-status').selectmenu();
		$('a[title]').tipsy({trigger: 'hover', gravity: 'sw'});
		mins = 0; setInterval("updateTimer()",1000*60);
		$('.accept').click(function(){
			selectedItem = $(this).parents('.item');
			var work_id = selectedItem.attr('id').split('-')[1];
			if (typeof console == "object") console.log(work_id);
			$( "#dialog-confirm" ).dialog({
				resizable: false,
				modal: true,
				width: 430,
				buttons: {
					"Disagree": function() {
						$( this ).dialog( "close" );
					},
					"I Agree" : function() {
						$.fancybox.showLoading();
						$.ajax({
							url: '/missions/Ajax_accept_work',
							type: 'post',
							data: {'csrf_workpad': getCookie('csrf_workpad'), 'work_id':work_id},
							success: function(msg){
								window.location = '/missions/wall/'+msg;
								$.fancybox.hideLoading();
							}
						});
						$( this ).dialog( "close" );
					}
				}
			});
			
		});
		$('.reject').click(function(){
			selectedItem = $(this).parents('.item');
			var work_id = selectedItem.attr('id').split('-')[1];
			if (typeof console == "object") console.log(work_id);
			$( "#dialog-reject" ).dialog({
				resizable: false,
				modal: true,
				width: 410,
				buttons: {
					cancel: function() {
						$( this ).dialog( "close" );
					},
					"Yes" : function() {
						$.fancybox.showLoading();
						$.ajax({
							url: '/missions/Ajax_reject_work',
							type: 'post',
							data: {'csrf_workpad': getCookie('csrf_workpad'), 'work_id':work_id},
							success: function(msg){
								$('#mission-'+msg).slideUp(function(){$(this).remove()});
								$.fancybox.hideLoading();
							}
						});
						$( this ).dialog( "close" );
					}
				}
			});
		});
		
		$('#removeSample').click(function(){
			$.ajax({
				url: '/missions/Ajax_remove_sample',
				type: 'post',
				async: false,
				data: {'csrf_workpad': getCookie('csrf_workpad')},
				success: function(msg){
					//console.log(msg);
					$('#mission-sample').slideUp('fast');
				}
			});
		});
		
		//Lets show number of bids on a mission in realtime
		var channel = pusher.subscribe('bid');
		  channel.bind_all(function(evnt,data) {
		  if(evnt.indexOf('new-bid')>-1){
			  var el=$('#mission-'+data.work_id).find('.bidders-'+data.work_id);
			  var val = parseInt(el.html());
			  el.html(++val);
		  }else if(evnt.indexOf('cancel-bid')>-1){
			  var el=$('#mission-'+data.work_id).find('.bidders-'+data.work_id);
			  el.html(Math.max(0,--parseInt(el.html())));
		  }
		});

	});
	function updateTimer(){
		mins++;
		if(mins%60==0){
			//An hour passed
			$('#block-mission-list .time').each(function(){
				var time = $(this).html().split(':');
				if(time.length==1){
					if(time[0]==24){if(time[0]>0){time[0]--;time[1]='60';$(this).html(time[0]+':'+time[1]);}}else{$(this).html(time[0]);}
					var item = $(this).parent().parent().parent().parent();
					var percentage_elm = $(item).find('input[name="percent"]');
					var percentage = parseFloat(percentage_elm.val())+parseFloat($(item).find('input[name="min_to_percent"]').val());
					if(percentage>1)percentage=1;
					percentage_elm.val(percentage);
					$(item).find('.mission-progress-meter').css({'width':Math.round(216*percentage)});
				}
			});
		}
		$('#block-mission-list .time').each(function(){
				var time = $(this).html().split(':');
				if(time.length==2){
					if(time[1]<=00){if(time[0]>0){time[0]--;time[1]='59';}}else{time[1]--;}
					$(this).html(time[0]+':'+time[1]);
				}
				var item = $(this).parent().parent().parent().parent();
				var percentage_elm = $(item).find('input[name="percent"]');
				var percentage = parseFloat(percentage_elm.val())+parseFloat($(item).find('input[name="min_to_percent"]').val());
				if(percentage>1)percentage=1;
				percentage_elm.val(percentage);
				$(item).find('.mission-progress-meter').css({'width':Math.round(216*percentage)});
			});
	}
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>