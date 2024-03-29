<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<div class="po-wall-container">
  <!-- mission submission-->
  <div id="mission-notification" class="container-fluid">
  </div>
  <!--mission submission-->
  <div class="top-panel">
    <div class="top-panel-left">
      <div class="top-panel-title"><?=ucwords($work['title'])?> <a href="#"><img src="/public/images/codeArmy/po/record-icon.png" /></a></div>
      <div class="proj-category"><?=ucfirst($work['category'].(($work['class'])?' > '.$work['class_name']:'').(($work['subclass'])?' > '.$work['subclass_name']:''))?></div>
      <div class="tabs-row"> <a href="/missions/wall/<?=$work['work_id']?>" class="wall">Wall</a> <a class="task-active" href="/missions/task/<?=$work['work_id']?>">Task</a> <a class="document" href="/missions/documents/<?=$work['work_id']?>">Document</a> <a class="date" href="/missions/dates/<?=$work['work_id']?>">Date</a> </div>
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
          <p class="level">Level <?=$this->game_model->get_level($po['exp']);?></p>
        </div>
        <div class="po-avatar"><img src="/public/images/codeArmy/po/default-avatar.png" /></div>
        <!-- mission submission-->
        <?php if(($work['work_horse']==$me['user_id'])&&(strtolower($work['status'])=='in progress' || strtolower($work['status'])=='redo')){?>
        <div class="button green" id="mission_complete" style="clear:both;"><img src="/public/images/codeArmy/loader4.gif" style="position:absolute;left:75px; bottom:5px; display:none;" id="mission-submit-loader" /> Complete Mission!</div>
        <?php }?>
        <!-- mission submission-->
      </div>
    </div>
  </div>
  <div class="wall-bottom-panel">
    
    <!--<div class="task-taskbar">
    <a class="task-name" href="#"><img src="/public/images/codeArmy/mission/arrow-down.png" />&nbsp;PHP Awesome Fix</a>
    <div class="task-due-date">[ Due 27/10/12 ]</div>
    <div class="profile-n-edit-icon"><a href="#"><img src="/public/images/codeArmy/po/task/profile-icon.png" /></a><a href="#"><img src="/public/images/codeArmy/po/task/edit-icon.png" /></a></div>
    </div>-->
    
    <?php if(in_array(strtolower($work['status']),array('in progress','done','redo'))){?>
    <div class="sub-task-bar">
    <div class="add-subtask-field"><input class="add-subtask" name="add-subtask" id="add-subtask" type="text" placeholder="Type here to add a subtask" /> <input type="hidden" name="work_id" id="work_id" value="<?=$work['work_id']?>" />  <input type="submit" value="Add sub-task" name="add-subtask-btn" id="add-subtask-btn" class="lnkimg" /></div>
    <!--<div class="ta-hours"><div class="total-hrs">Total Hours: 100 hrs</div><div class="assigned-hrs">Assigned Hours: 89 hrs</div></div>-->
    </div>
    <?php }?>
    
    <div class="tasks-table">
    
    <div class="task-table-title">
    <div class="task-title-priority">Priority</div>
    <div class="task-title-taskname">Task Name</div>
    <div class="task-title-deadline">Deadline</div>
    <div class="task-title-hours">Hours</div>
    <div class="task-title-percent">%</div>
    <div class="task-title-status">Status</div>
    </div>
    
    <?php
	$disable = !(in_array(strtolower($work['status']),array('in progress','done','redo')));
    foreach($mission_task as $task):
		if($task['task_status'] != "Done"){
	?>
    <?php echo form_open('#' , array('id'=>'form_sub_task_'.$task['task_id'])); ?>
    <div id="task-template" class="task-table-row">
    <div class="task-row-priority"><select <?=($disable)?'disabled="disabled"':''?> name="task_priority" id="sub_task_priority_<?=$task['task_id']?>" onchange="javascript:update_priority(<?=$task['task_id']?>);"><option value="Low"<?php if($task['task_priority']=="Low") echo " selected";?>>Low</option><option value="Normal"<?php if($task['task_priority']=="Normal") echo " selected";?>>Normal</option><option value="High"<?php if($task['task_priority']=="High") echo " selected";?>>High</option></select></div>
    <div class="task-row-taskname"><?=$task['task_name']?></div>
    <div class="task-row-deadline"> <a href="#" class="datepicker"><img src="/public/images/codeArmy/po/task/task-date-icon.png" /></a></div>
    <div class="task-row-hours"><input <?=($disable)?'disabled="disabled"':''?> type="text" name="task_hours" id="sub_task_hours_<?=$task['task_id']?>" value="<?=$task['task_hours']?>" onkeyup="javascript:update_hours(<?=$task['task_id']?>);" /></div>
    <div class="task-row-percent"><input <?=($disable)?'disabled="disabled"':''?> type="text" name="task_percent" id="sub_task_percent_<?=$task['task_id']?>" value="<?=$task['task_percentage']?>" onkeyup="javascript:update_percent(<?=$task['task_id']?>);" maxlength="3" /></div>
    <div class="task-row-status"><select <?=($disable)?'disabled="disabled"':''?> name="task_status" id="sub_task_status_<?=$task['task_id']?>" onchange="javascript:update_status(<?=$task['task_id']?>);"><option value="To Do"<?php if($task['task_status']=="To Do") echo " selected"; ?>>To Do</option><option value="Working"<?php if($task['task_status']=="Working") echo " selected"; ?>>Working</option><option value="Done">Done</option></select><a href="javascript:;" onclick="delete_task(<?=$task['task_id']?>)"><img src="/public/images/codeArmy/po/task/task-remove-icon.png" class="task-remove-icon" /></a></div>
    </div>
    </form>
    <?php } else { ?>
    <?php echo form_open('#' , array('id'=>'form_sub_task_'.$task['task_id'])); ?>
    <div class="task-table-row">
    <div class="task-row-priority"><span class="priority-<?=strtolower($task['task_priority'])?>"><?=$task['task_priority']?></span></div>
    <div class="task-row-taskname"><?=$task['task_name']?></div>
    <div class="task-row-deadline"><?=$task['task_deadline']?></div>
    <div class="task-row-hours"><?=$task['task_hours']?></div>
    <div class="task-row-percent"><?=$task['task_percentage']?></div>
    <div class="task-row-status"><?=$task['task_status']?> <a href="javascript:;" onclick="delete_task(<?=$task['task_id']?>)"><img src="/public/images/codeArmy/po/task/task-remove-icon.png" class="task-remove-icon" /></a></div>
    </div>
    </form>
    <?php
	}
    endforeach;
	?>
    
<!--    <div class="task-table-row">
    <div class="task-row-priority"><span class="priority-low">Low</span></div>
    <div class="task-row-taskname">Testing</div>
    <div class="task-row-deadline">21/10</div>
    <div class="task-row-hours">5.0</div>
    <div class="task-row-percent">0</div>
    <div class="task-row-status">To do <a href="#"><img src="/public/images/codeArmy/po/task/task-remove-icon.png" class="task-remove-icon" /></a></div>
    </div>
    
    <div class="task-table-row">
    <div class="task-row-priority"><span class="priority-normal">Normal</span></div>
    <div class="task-row-taskname">Planning</div>
    <div class="task-row-deadline">21/10</div>
    <div class="task-row-hours">5.0</div>
    <div class="task-row-percent">0</div>
    <div class="task-row-status">To do <a href="#"><img src="/public/images/codeArmy/po/task/task-remove-icon.png" class="task-remove-icon" /></a></div>
    </div>-->
    
    <?php echo form_open('#' , array('id'=>'form-update-task','style'=>'display:none')); ?>
    <div id="task-template" class="task-table-row">
    <div class="task-row-priority"><select <?=($disable)?'disabled="disabled"':''?> name="task_priority" id="task_priority"><option value="Low">Low</option><option value="Normal" selected="selected">Normal</option><option value="High">High</option></select></div>
    <div class="task-row-taskname"></div>
    <div class="task-row-deadline"> <a href="#" class="datepicker"><img src="/public/images/codeArmy/po/task/task-date-icon.png" /></a></div>
    <div class="task-row-hours"><input <?=($disable)?'disabled="disabled"':''?> type="text" name="task_hours" id="task_hours" value="0" /></div>
    <div class="task-row-percent"><input <?=($disable)?'disabled="disabled"':''?> type="text" name="task_percent" id="task_percent" value="0" maxlength="3" /></div>
    <div class="task-row-status"><select <?=($disable)?'disabled="disabled"':''?> name="task_status" id="task_status"><option value="To Do">To Do</option><option value="Working">Working</option><option value="Done">Done</option></select><input <?=($disable)?'disabled="disabled"':''?> type="button" class="task-remove-icon" id="task_delete" /><input type="hidden" name="task_id" id="task_id" value="" /></div>
    </div>
    </form>
    
    </div>
    
    
  </div>
</div>
<script type="text/javascript">
$(function(){
	<?php if(in_array(strtolower($work['status']),array('in progress','done','redo'))){?>
	$('#add-subtask-btn').click(function(){
		if($('#add-subtask').val() != ""){
			var sub_task = get_value('#add-subtask');
			var work_id = $('#work_id').val();
			$.ajax({
				type: 'post',
				async: false,
				url: '/missions/Ajax_add_sub_task',
				data: { 'sub_task': sub_task, 
				  'work_id': work_id,
				  'csrf_workpad': getCookie('csrf_workpad') 
				},
				success: function(msg){
					if(msg!="" && msg!='error'){
						var theme = $('#form-update-task').clone();
						theme.find('.task-row-taskname').html(sub_task);
						//theme.find('#form-update-task').attr('id','form-update-task-'+msg);
						theme.find('#task_id').val(msg);
						$('.task-table-title').after(theme);
						theme.slideDown('slow');
					} else {
						alert("Error");
					}
				}
			});
		}
	});
	
	$('#task_priority').live("change",function(){
		var task_id = $(this.form.task_id).val();
		var task_priority = $(this.form.task_priority).val();
		$.ajax({
			type: 'post',
			async: false,
			url: '/missions/Ajax_update_task_priority',
			data: { 'task_priority': task_priority, 
			  'task_id': task_id,
			  'csrf_workpad': getCookie('csrf_workpad') 
			}
		});
	});
	
	$('#task_hours').live("blur",function(){
		var task_id = $(this.form.task_id).val();
		var task_hours = $(this.form.task_hours).val();
		$.ajax({
			type: 'post',
			async: false,
			url: '/missions/Ajax_update_task_hours',
			data: { 'task_hours': task_hours, 
			  'task_id': task_id,
			  'csrf_workpad': getCookie('csrf_workpad') 
			}
		});
	});
	
	$('#task_percent').live("blur",function(){
		var task_id = $(this.form.task_id).val();
		var task_percent = $(this.form.task_percent).val();
		$.ajax({
			type: 'post',
			async: false,
			url: '/missions/Ajax_update_task_percent',
			data: { 'task_percent': task_percent, 
			  'task_id': task_id,
			  'csrf_workpad': getCookie('csrf_workpad') 
			}
		});
	});
	
	$('#task_status').live("change",function(){
		var task_id = $(this.form.task_id).val();
		var task_status = $(this.form.task_status).val();
		$.ajax({
			type: 'post',
			async: false,
			url: '/missions/Ajax_update_task_status',
			data: { 'task_status': task_status, 
			  'task_id': task_id,
			  'csrf_workpad': getCookie('csrf_workpad') 
			}
		});
	});
	
	$('#task_delete').live("click",function(){
		var task_id = $(this.form.task_id).val();
		$.ajax({
			type: 'post',
			async: false,
			url: '/missions/Ajax_delete_task',
			data: { 'task_id': task_id,
			  'csrf_workpad': getCookie('csrf_workpad') 
			},
			success: function(msg){
				if(msg!="" && msg!='error'){
					$('#form-update-task').slideUp('slow');
				} else {
					alert("Error");
				}
			}
		});
	});
	<?php }?>
	
	//Mission submission 
	var _lock=false;
	var mission_channel = pusher.subscribe('mission');
	
	<?php if($work['owner']==$me['user_id']){//push events for PO?>
	mission_channel.bind('done-mission-<?=$work['work_id']?>',function(data){
		if(data.work_id=='<?=$work['work_id']?>'){
			$('#mission-notification').html('<div class="row-fluid"><div class="span8"><span style="margin:0 5px" class="icon-comment"></span><?=ucfirst($contractor['username'])?> has marked this mission complete!</div><div class="span4"><button id="redo-mission" type="button" class="btn btn-danger">Don\'t accept</button><button id="verify-mission" type="button" class="btn btn-success">Accept</button></div></div>').removeClass('blue green red yellow orange').addClass('orange').slideDown();
		}
	});
	<?php }elseif($work['work_horse']==$me['user_id']){//push events for contractor?>
	mission_channel.bind('redo-mission-<?=$work['work_id']?>',function(data){
		if(data.work_id=='<?=$work['work_id']?>'){
			$('#mission-notification').html('<span style="margin:0 5px" class="icon-icon-exclamation-sign"></span>Captain asked you to revise your work. Please discuss the requirements on mission wall<a href="javascript:$(\'#mission-notification\').slideUp()" style="float:right" class="icon-eye-close"></a>').removeClass('blue green orange yellow red').addClass('red').slideDown();
			$('#mission_complete').hide().delay(1).slideDown();
			$('#mission-submit-loader').hide();
		}
	});
	mission_channel.bind('verify-mission-<?=$work['work_id']?>',function(data){
		if(data.work_id=='<?=$work['work_id']?>'){
			$('#mission-notification').html('<span style="margin:0 5px" class="icon-ok"></span>Mission accomplished. Nice work and Congradulations!<a href="javascript:$(\'#mission-notification\').slideUp()" style="float:right" class="icon-eye-close"></a>').removeClass('blue red orange yellow green').addClass('green').slideDown();
		}
	});
	<?php }?>
	
	$('#mission_complete').click(function(){
		if(_lock)return false;
		_lock = true;
		$('#mission-submit-loader').show();
		$.ajax({
			url:'/missions/Ajax_submit',
			data: {'csrf_workpad': getCookie('csrf_workpad'), 'work_id': '<?=$work['work_id']?>'},
			type: 'post',
			success: function(msg){
				if(msg=='success'){
					$('#mission_complete').slideUp();
					$('#mission-notification').html('<span style="margin:0 5px" class="icon-ok"></span>Mission is marked as completed and sent to captain for verification...<a href="javascript:$(\'#mission-notification\').slideUp()" style="float:right" class="icon-remove"></a>').addClass('blue').slideDown();
				}else if (typeof console == "object") console.log(msg);
				_lock=false;
			}
		});
		
	});
	<?php if($work['work_horse']==$me['user_id']){//Show to contractor?>
	switch('<?=strtolower($work['status'])?>'){
		case 'done': $('#mission-notification').html('<span class="icon-comment" style="margin:0 5px"></span>Pending for verification by captain...<a href="javascript:$(\'#mission-notification\').slideUp()" style="float:right" class="icon-eye-close"></a>').addClass('orange').slideDown();
		break;
	}
	<?php }elseif($work['owner']==$me['user_id']){//Show to po?>
	switch('<?=strtolower($work['status'])?>'){
		case 'done': $('#mission-notification').html('<div class="row-fluid"><div class="span8"><span style="margin:0 5px" class="icon-comment"></span><?=ucfirst($contractor['username'])?> has marked this mission complete!</div><div class="span4"><button id="redo-mission" type="button" class="btn btn-danger">Don\'t accept</button><button id="verify-mission" type="button" class="btn btn-success">Accept</button></div></div>').addClass('orange').slideDown();
		break;
	}
	
	$('#verify-mission').live('click',function(){
		if(_lock)return false;
		_lock=true;
		$('#redo-mission').hide();
		$(this).html('Accept<img src="/public/images/codeArmy/loader4.gif" id="Ajax-Loader" />');
		
		$.ajax({
			'url':'/missions/Ajax_verify_mission',
			'data':{'csrf_workpad': getCookie('csrf_workpad'), 'work_id':'<?=$work['work_id']?>'},
			'type':'post',
			success:function(msg){
					if(msg=='success'){
						$('#mission-notification').html('<span style="margin:0 5px" class="icon-ok"></span>Mission is successfuly completed and verified.<a href="javascript:$(\'#mission-notification\').slideUp()" style="float:right" class="icon-eye-close"></a>').removeClass('orange').addClass('green');
					}else if (typeof console == "object") console.log(msg);
					_lock=false;
				}
		});
	});
	
	$('#redo-mission').live('click',function(){
		if(_lock)return false;
		_lock=true;
		$('#verify-mission').hide();
		$(this).html('Don\'t accept<img src="/public/images/codeArmy/loader4.gif" id="Ajax-Loader" />');
		
		$.ajax({
			'url':'/missions/Ajax_redo_mission',
			'data':{'csrf_workpad': getCookie('csrf_workpad'), 'work_id':'<?=$work['work_id']?>'},
			'type':'post',
			success:function(msg){
				if(msg=='success'){
						$('#mission-notification').html('<span style="margin:0 5px" class="icon-comment"></span>Mission is sent back to contractor for revision.<a href="javascript:$(\'#mission-notification\').slideUp()" style="float:right" class="icon-eye-close"></a>').removeClass('orange').addClass('red');
					}else if (typeof console == "object") console.log(msg);
				_lock=false;
			}
		});
	});
	<?php }?>
	//end of mission submission
});

<?php if(in_array(strtolower($work['status']),array('in progress','done','redo'))){?>
function delete_task(task_id){
	$.ajax({
		type: 'post',
		async: false,
		url: '/missions/Ajax_delete_task',
		data: { 'task_id': task_id,
		  'csrf_workpad': getCookie('csrf_workpad') 
		},
		success: function(msg){
			if(msg!="" && msg!='error'){
				$('#form_sub_task_'+msg).slideUp('slow');
			} else {
				alert("Error");
			}
		}
	});
}

function update_priority(task_id){
	var task_priority = $('#sub_task_priority_'+task_id).val();
	$.ajax({
		type: 'post',
		async: false,
		url: '/missions/Ajax_update_task_priority',
		data: { 'task_priority': task_priority, 
		  'task_id': task_id,
		  'csrf_workpad': getCookie('csrf_workpad') 
		}
	});
}

function update_hours(task_id){
	var task_hours = $('#sub_task_hours_'+task_id).val();
	$.ajax({
		type: 'post',
		async: false,
		url: '/missions/Ajax_update_task_hours',
		data: { 'task_hours': task_hours, 
		  'task_id': task_id,
		  'csrf_workpad': getCookie('csrf_workpad') 
		}
	});
}

function update_percent(task_id){
	var task_percent = $('#sub_task_percent_'+task_id).val();
	$.ajax({
		type: 'post',
		async: false,
		url: '/missions/Ajax_update_task_percent',
		data: { 'task_percent': task_percent, 
		  'task_id': task_id,
		  'csrf_workpad': getCookie('csrf_workpad') 
		}
	});
}

function update_status(task_id){
	var task_status = $('#sub_task_status_'+task_id).val();
	$.ajax({
		type: 'post',
		async: false,
		url: '/missions/Ajax_update_task_status',
		data: { 'task_status': task_status, 
		  'task_id': task_id,
		  'csrf_workpad': getCookie('csrf_workpad') 
		}
	});
}
<?php }?>

function get_value(el){
	var el=$(el);
	return (el.val()==el.data().def_val)?'':el.val();
}
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
