<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<script type="text/javascript">
	var bids_pusher = new Pusher('deb0d323940b00c093ee');
	var bids_channel = pusher.subscribe('CA_activities_bid');
</script>
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
	font-size:9.99pt;
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
</style>
<div id="mymission-content-area">
	<div id="block-mission-list">
    	<div class="block-header">
        	<h3>My Missions</h3>
        </div>
        <div class="list">
        	<?php foreach($myPendingList as $list):?>
            <div class="item gray-mission" id="mission-<?=$list['work_id']?>">
            	<div class="mission-header">
                	<div class="mission-title"><?=$list['title']?></div>
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
                        <li><a href="#" title="You are competing over <?=$troopers?> trooper(s) over this job!"><span class="icon"></span><span class="title"><?=$troopers?> Troop(s)</span></a></li>
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
                	<div class="mission-title"><?=$list['title']?></div>
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
                		<li><a href="#"><span class="icon"></span><span class="title">Captain</span></a></li>
                        <li><a href="#" title="You are competing over <?=$troopers?> trooper(s) over this job!"><span class="icon"></span><span class="title"><?=$troopers?>Troops</span></a></li>
                        <li><a href="#"><span class="icon"></span><span class="title">Discussion</span></a></li>
                        <li><a href="#"><span class="icon"></span><span class="title">Attachements</span></a></li>
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
            
            <?php foreach($myMissions as $list):?>
            <div class="item green-mission" id="mission-<?=$list['work_id']?>">
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
                	<div class="mission-title"><?=$list['title']?></div>
                    <div class="mission-status-icon"><?=$list['status']?></div>
                    <div class="mission-progress-bg">
                    	<div class="mission-progress-meter" style="width:<?= round(216*$progress_percent) ?>px"></div>
                        <input type="hidden" name="percent" value="<?=$progress_percent?>" />
                        <input type="hidden" name="min_to_percent" value="<?=$min_to_percent?>" />
                    </div>
                    <div class="mission-inputs">Inputs: <?=trim($list['input'])==''?'not defined':$list['input']?></div>
                    <div class="mission-deliverables">Deliverables: <?=trim($list['output'])==''?'not defined':$list['output']?></div>
                </div>
                <div class="mission-content">
                	<ul class="mission-icons">
                    	<?php if($po){?>
                         <li><a href="#"><span class="icon"></span><span class="title">Captain</span></a></li>
                        <li><a href="/missions/applicants/<?=$list['work_id']?>"><span class="icon"></span><span class="title "><span class="bidders-<?=$list['work_id']?>"><?=$list['bids']?></span> Bidders</span></a></li>
                        <script type="text/javascript">
							bids_channel.bind('new-bid-<?=$list['work_id']?>', function(data) {
							  var el = $('.bidders-<?=$list['work_id']?>');
							  el.html(++parseInt(el.html()));
							  alert(bid); console.log(data);
							});
						</script>
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
                        <?php if($po && strtolower($list['status'])=='draft'){?>
                        	<a class="fancybox blue-button" href="/missions/edit_mission/<?=$list['work_id']?>">Edit</a>
                        <?php }if($po){//TODO: if in open, assigned status allow edit but send alert to bidders on change?>
                        	<a class="fancybox blue-button" href="/missions/edit_mission/<?=$list['work_id']?>">Manage</a>
                        <?php }else{?>
                        	<a href="/missions/wall/<?=$list['work_id']?>" class="blue-button">Check in</a>
                        <?php }?>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
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
		mins = 0; setInterval("updateTimer()",1000*60);
		$('.accept').click(function(){
			selectedItem = $(this).parents('.item');
			var work_id = selectedItem.attr('id').split('-')[1];
			console.log(work_id);
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
								console.log(msg);
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
			console.log(work_id);
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
								console.log(msg);
								$('#mission-'+msg).slideUp(function(){$(this).remove()});
								$.fancybox.hideLoading();
							}
						});
						$( this ).dialog( "close" );
					}
				}
			});
		});
		var pusher = new Pusher('deb0d323940b00c093ee'); // Replace with your app key
		var channel = pusher.subscribe('bid');
		  channel.bind_all(function(evnt,data) {
		  console.log(evnt,data);
		  if(evnt.indexOf('new-bid')>-1){
			  var el=$('#mission-'+data.work_id).find('.bidders-'+data.work_id);
			  var val = parseInt(el.html());
			  el.html(++val);
		  }else if(evnt.indexOf('cancel-bid')>-1){
			  var el=$('#mission-'+data.work_id).find('.bidders-'+data.work_id);
			  el.html(Math.max(0,--parseInt(el.html())));
		  }else if(evnt.indexOf('accept-bid')>-1){
			$( "#dialog-accept" ).dialog({
				resizable: false,
				modal: true,
				width: 430,
				buttons: {
					"Not Now": function() {
						$( this ).dialog( "close" );
					},
					"Proceed": function(){
						window.location='/missions/my_missions';
					}
				}
			});
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