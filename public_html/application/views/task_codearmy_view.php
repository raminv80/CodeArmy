<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<div class="po-wall-container">
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
          <p class="level">Level <?=$this->gamemech->get_level($po['exp']);?></p>
        </div>
        <div class="po-avatar"><img src="/public/images/codeArmy/po/default-avatar.png" /></div>
      </div>
    </div>
  </div>
  <div class="wall-bottom-panel">
    
    <!--<div class="task-taskbar">
    <a class="task-name" href="#"><img src="/public/images/codeArmy/mission/arrow-down.png" />&nbsp;PHP Awesome Fix</a>
    <div class="task-due-date">[ Due 27/10/12 ]</div>
    <div class="profile-n-edit-icon"><a href="#"><img src="/public/images/codeArmy/po/task/profile-icon.png" /></a><a href="#"><img src="/public/images/codeArmy/po/task/edit-icon.png" /></a></div>
    </div>-->
    
    
    <div class="sub-task-bar">
    <div class="add-subtask-field"><input class="add-subtask" name="add-subtask" id="add-subtask" type="text" placeholder="Type here to add a subtask" /> <input type="hidden" name="work_id" id="work_id" value="<?=$work['work_id']?>" />  <input type="submit" value="Add sub-task" name="add-subtask-btn" id="add-subtask-btn" class="lnkimg" /></div>
    <!--<div class="ta-hours"><div class="total-hrs">Total Hours: 100 hrs</div><div class="assigned-hrs">Assigned Hours: 89 hrs</div></div>-->
    </div>
    
    <div class="tasks-table">
    
    <div class="task-table-title">
    <div class="task-title-priority">Priority</div>
    <div class="task-title-taskname">Task Name</div>
    <div class="task-title-deadline">Deadline</div>
    <div class="task-title-hours">Hours</div>
    <div class="task-title-percent">%</div>
    <div class="task-title-status">Status</div>
    </div>
    
    <?php foreach($mission_task as $task): ?>
    <div class="task-table-row">
    <div class="task-row-priority"><span class="priority-high">High</span></div>
    <div class="task-row-taskname">Database Fix</div>
    <div class="task-row-deadline">21/10</div>
    <div class="task-row-hours">5.0</div>
    <div class="task-row-percent">0</div>
    <div class="task-row-status">To do <a href="#"><img src="/public/images/codeArmy/po/task/task-remove-icon.png" class="task-remove-icon" /></a></div>
    </div>
    <?php endforeach; ?>
    
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
    
    <div id="task-template" style="display:none" class="task-table-row">
    <div class="task-row-priority"><select name="task-priority" id="task-priority"><option value="Low">Low</option><option value="Normal" selected="selected">Normal</option><option value="High">High</option></select></div>
    <div class="task-row-taskname"></div>
    <div class="task-row-deadline"> <a href="#" class="datepicker"><img src="/public/images/codeArmy/po/task/task-date-icon.png" /></a></div>
    <div class="task-row-hours"><input type="text" name="task-hours" id="task-hours" /></div>
    <div class="task-row-percent"><input type="text" name="task-percent" id="task-percent" /></div>
    <div class="task-row-status"><select name="task-status" id="task-status"><option value="To Do">To Do</option><option value="Working">Working</option><option value="Done">Done</option></select><a href="#"><img src="/public/images/codeArmy/po/task/task-remove-icon.png" class="task-remove-icon" /></a><input type="hidden" name="task-id" id="task-id" value="" /></div>
    </div>
    
    </div>
    
    
  </div>
</div>
<script type="text/javascript">
$(function(){
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
						//$('<div class="task-table-row"><div class="task-row-priority"><select><option value="Low">Low</option><option value="Normal">Normal</option><option value="High">High</option></select></div><div class="task-row-taskname">'+sub_task+'</div><div class="task-row-deadline"></div><div class="task-row-hours"><input type="text" value="3" /></div><div class="task-row-percent"><input type="text" value="10" /></div><div class="task-row-status"><select><option value="To Do">To Do</option><option value="Working">Working</option><option value="Done">Done</option></select><a href="#"><img src="/public/images/codeArmy/po/task/task-remove-icon.png" class="task-remove-icon" /></a></div></div>').insertAfter('.task-table-title');
						var theme = $('#task-template').clone();
						theme.find('.task-row-taskname').html(sub_task);
						theme.find('#task-priority').attr('id','task-priority'+msg);
						theme.find('#task-hours').attr('id','task-hours'+msg);
						theme.find('#task-percent').attr('id','task-percent'+msg);
						theme.find('#task-status').attr('id','task-status'+msg);
						theme.find('#task-id').val(msg);
						$('.task-table-title').after(theme);
						theme.slideDown('slow');
					} else {
						alert("Error");
					}
				}
			});
		}
	});
});

function get_value(el){
	var el=$(el);
	return (el.val()==el.data().def_val)?'':el.val();
}
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
