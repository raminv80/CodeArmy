<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<link rel="stylesheet" type="text/css" href="/public/js/codeArmy/jquery-frontier-cal-1.3.2/css/frontierCalendar/jquery-frontier-cal-1.3.2.css" />
<script src="/public/js/codeArmy/jquery-frontier-cal-1.3.2/js/lib/jshashtable-2.1.js" type="text/javascript"></script>
<script src="/public/js/codeArmy/jquery-frontier-cal-1.3.2/js/frontierCalendar/jquery-frontier-cal-1.3.2.min.js" type="text/javascript"></script>
<div class="po-wall-container">
  <div class="top-panel">
    <div class="top-panel-left">
      <div class="top-panel-title">
        <?=ucwords($work['title'])?>
        <a href="#"><img src="/public/images/codeArmy/po/record-icon.png" /></a></div>
      <div class="proj-category">
        <?=ucfirst($work['category'].(($work['class'])?' > '.$work['class_name']:'').(($work['subclass'])?' > '.$work['subclass_name']:''))?>
      </div>
      <div class="tabs-row"> <a href="/missions/wall/<?=$work['work_id']?>" class="wall-active">Wall</a> <a class="task" href="/missions/task/<?=$work['work_id']?>">Task</a> <a class="document" href="/missions/documents/<?=$work['work_id']?>">Document</a> <a class="date" href="#">Date</a> </div>
      <div class="desc-row">
        <?=$work['description']?>
      </div>
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
      <div class="progress-text">Progress:
        <?= round(100*$progress_percent) ?>
        %</div>
      <div class="wall-progress">
        <div class="wall-progress-bar" style="width:<?= round(222*$progress_percent) ?>px"></div>
      </div>
      <div class="bg_progress_summary">
        <div class="start-hours">
          <div class="start">
            <p class="wall-box-title">Start</p>
            <p>
              <?=($work['started_at'])?date('j M Y',strtotime($work['started_at'])):''?>
            </p>
          </div>
          <div class="hours">
            <p class="wall-box-title">
              <?=ucfirst(str_replace('dai','day',substr($work['arrangement_type'],0,-2)))?>
              s</p>
            <p>
              <?=$work['bid_time']?>
            </p>
          </div>
        </div>
        <div class="end-budget">
          <div class="end">
            <p class="wall-box-title">End</p>
            <p>
              <?=date('j M Y',strtotime($work['deadline']))?>
            </p>
          </div>
          <p class="wall-box-title">Budget</p>
          <p>$
            <?=$work['bid_cost']?>
            /
            <?=str_replace('dai','day',substr($work['arrangement_type'],0,-2))?>
          </p>
          <div class="budget"></div>
        </div>
        <div class="po-info">
          <p class="wall-box-title">Mission Captain</p>
          <p class="po-name">
            <?=$po['username']?>
          </p>
          <p class="level">Level
            <?=$this->gamemech->get_level($po['exp']);?>
          </p>
        </div>
        <div class="po-avatar"><img src="/public/images/codeArmy/po/default-avatar.png" /></div>
      </div>
    </div>
  </div>
  <div class="wall-bottom-panel">
  	<div id="mycal"></div>
  </div>
</div>
<script type="text/javascript">
var dates = <?=json_encode($dates)?>;
/**
 * Initialize with current year and date. Returns reference to plugin object.
 */
var jfcalplugin = $("#mycal").jFrontierCal({
	date: new Date(),
	dayClickCallback: myDayClickHandler,
	agendaClickCallback: myAgendaClickHandler,
	agendaDropCallback: myAgendaDropHandler,
	dragAndDropEnabled: true
}).data("plugin");
/**
 * Get the date (Date object) of the day that was clicked from the event object
 */
function myDayClickHandler(eventObj){
	var date = eventObj.data.calDayDate;
	alert("You clicked day " + date.toDateString());
};
/**
 * Get the agenda item that was clicked.
 */
function myAgendaClickHandler (eventObj){
	var agendaId = eventObj.data.agendaId;
	var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
};
/**
 * get the agenda item that was dropped. It's start and end dates will be updated.
 */
function myAgendaDropHandler(eventObj){
	var agendaId = eventObj.data.agendaId;
	var date = eventObj.data.calDayDate;		
	var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);		
	alert("You dropped agenda item " + agendaItem.title + 
		" onto " + date.toString() + ". Here is where you can make an AJAX call to update your database.");
};

function initDates(){
	for(i=0;i<dates.length;i++){
		jfcalplugin.addAgendaItem(
			"#mycal",
			dates[i].title,
			new Date(dates[i].start),
			new Date(dates[i].end),
			false,
			{
				page_work_id: "<?=$work['work_id']?>",
				work_id: dates[i].work_id,
			},
			{
				backgroundColor: "#FF0000",
				foregroundColor: "#FFFFFF"
			}	
		);	
	}
}
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
