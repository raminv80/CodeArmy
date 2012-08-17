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
      <div class="tabs-row"> <a href="/missions/wall/<?=$work['work_id']?>" class="wall">Wall</a> <a class="task" href="/missions/task/<?=$work['work_id']?>">Task</a> <a class="document" href="/missions/documents/<?=$work['work_id']?>">Document</a> <a class="date-active" href="/missions/dates/<?=$work['work_id']?>">Date</a> </div>
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
	<div id="toolbar" class="ui-widget-header ui-corner-all" style="padding:3px; vertical-align: middle; white-space:nowrap; overflow: hidden;">
		<button id="BtnPreviousMonth">Previous Month</button>
		<button id="BtnNextMonth">Next Month</button>
		&nbsp;&nbsp;&nbsp;
		Date: <input type="text" id="dateSelect" size="20"/>
		<!--&nbsp;&nbsp;&nbsp;
		<button id="BtnDeleteAll">Delete All</button>
		 ><button id="BtnICalTest">iCal Test</button>
		<input type="text" id="iCalSource" size="30" value="extra/fifa-world-cup-2010.ics"/> -->
	</div>
  <div class="wall-bottom-panel">
  	<div id="mycal"></div>
  </div>
</div>

<div id="add-event-form" title="Add Events" class="dialog">
	<form>
	<fieldset>
		<label for="Title">Event Details</label>
		<input type="text" name="eventname" id="eventname" style="width:95%" />
		<table style="width:100%; padding:5px; margin-top:15px">
			<tr>
				<td>
					<label>Start Date</label>
					<input type="text" name="startDate" id="startDate" value="" />
				</td>
				<td>&nbsp;</td>
				<td>
					<label>Start Hour</label>
					<div class="wrapselect tiny">
						<select id="startHour">
							<option value="12" SELECTED>12</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
						</select>
					</div>				
				<td>
				<td>
					<label>Start Minute</label>
					<div class="wrapselect tiny">
						<select id="startMin">
							<option value="00" SELECTED>00</option>
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
							<option value="50">50</option>
						</select>
					</div>				
				<td>
				<td>
					<label>Start AM/PM</label>
					<div class="wrapselect tiny">
						<select id="startMeridiem">
							<option value="AM" SELECTED>AM</option>
							<option value="PM">PM</option>
						</select>
					</div>				
				</td>
			</tr>
			<tr>
				<td>
					<label>End Date</label>
					<input type="text" name="endDate" id="endDate" value="" />				
				</td>
				<td>&nbsp;</td>
				<td>
					<label>End Hour</label>
					<div class="wrapselect tiny">
						<select id="endHour" >
							<option value="12" SELECTED>12</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
						</select>
					</div>				
				<td>
				<td>
					<label>End Minute</label>
					<div class="wrapselect tiny">
						<select id="endMin">
							<option value="00" SELECTED>00</option>
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
							<option value="50">50</option>
						</select>
					</div>				
				<td>
				<td>
					<label>End AM/PM</label>
					<div class="wrapselect tiny">
						<select id="endMeridiem">
							<option value="AM" SELECTED>AM</option>
							<option value="PM">PM</option>
						</select>
					</div>				
				</td>				
			</tr>			
		</table>
	</fieldset>
	</form>
</div>

<div id="display-event-form" title="View Event">
	<div class="show-event"></div>
	<div class="edit-event" style="display:none">
		<form>
			<fieldset>
				<label for="Title">Edit event</label>
				<input type="text" name="eventname2" id="eventname2" style="width:95%" />
				<table style="width:100%; padding:5px; margin-top:15px">
					<tr>
						<td>
							<label>Start Date</label>
							<input type="text" name="startDate2" id="startDate2" value="" />				
						</td>
						<td>&nbsp;</td>
						<td>
							<label>Start Hour</label>
							<div class="wrapselect tiny">
								<select id="startHour2">
									<option value="12">12</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
								</select>
							</div>				
						<td>
						<td>
							<label>Start Minute</label>
							<div class="wrapselect tiny">
								<select id="startMin2">
									<option value="00">00</option>
									<option value="10">10</option>
									<option value="20">20</option>
									<option value="30">30</option>
									<option value="40">40</option>
									<option value="50">50</option>
								</select>
							</div>				
						<td>
						<td>
							<label>Start AM/PM</label>
							<div class="wrapselect tiny">
								<select id="startMeridiem2">
									<option value="AM">AM</option>
									<option value="PM">PM</option>
								</select>
							</div>				
						</td>
					</tr>
					<tr>
						<td>
							<label>End Date</label>
							<input type="text" name="endDate2" id="endDate2" value="" />				
						</td>
						<td>&nbsp;</td>
						<td>
							<label>End Hour</label>
							<div class="wrapselect tiny">
								<select id="endHour2" >
									<option value="12">12</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
								</select>
							</div>				
						<td>
						<td>
							<label>End Minute</label>
							<div class="wrapselect tiny">
								<select id="endMin2">
									<option value="00">00</option>
									<option value="10">10</option>
									<option value="20">20</option>
									<option value="30">30</option>
									<option value="40">40</option>
									<option value="50">50</option>
								</select>
							</div>				
						<td>
						<td>
							<label>End AM/PM</label>
							<div class="wrapselect tiny">
								<select id="endMeridiem2">
									<option value="AM">AM</option>
									<option value="PM">PM</option>
								</select>
							</div>				
						</td>				
					</tr>			
				</table>
				<button type="button" id="btnUpdate" class="button black" role="button" aria-disabled="false"><i class="icon-repeat"></i> Update</button>
			</fieldset>
		</form>
	</div>
</div>
<style type="text/css">
	.dialog,.edit-event {font-size:.8em}
	.dialog input:focus, #display-event-form input:focus {outline:none; background:#f2f2f2}
	.dialog input, #display-event-form input {
		background:#626262; font-weight:700;
		border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px; box-shadow:inset 0px -1px 1px #222;
		border:1px solid #333; overflow:hidden; position:relative; padding:5px;
	}
	.dialog select, #display-event-form select {color:#9e5c09}
	.button {
	  margin: 0 0 5px;
	  height: 28px;
	  line-height: 28px;
	  padding: 0 12px;
	  font-size: 11px;
	  font-weight: bold;
	  color: #555555;
	  text-shadow: 0 1px #fff;
	  border-width: 1px 1px 0;
	  border-style: solid;
	  border-color: #cecece #bababa #a8a8a8;
	  border-radius: 3px 3px 2px 2px;
	  outline: none;
	  -webkit-box-sizing: content-box;
	  -moz-box-sizing: content-box;
	  box-sizing: content-box;
	  display: inline-block;
	  vertical-align: baseline;
	  zoom: 1;
	  *display: inline;
	  *vertical-align: auto;
	  background-color: #dfdfdf;
	  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #f1f1f1), color-stop(70%, #dfdfdf), color-stop(100%, #dadada));
	  background-image: -webkit-linear-gradient(top, #f1f1f1 0%, #dfdfdf 70%, #dadada 100%);
	  background-image: -moz-linear-gradient(top, #f1f1f1 0%, #dfdfdf 70%, #dadada 100%);
	  background-image: -ms-linear-gradient(top, #f1f1f1 0%, #dfdfdf 70%, #dadada 100%);
	  background-image: -o-linear-gradient(top, #f1f1f1 0%, #dfdfdf 70%, #dadada 100%);
	  background-image: linear-gradient(top, #f1f1f1 0%, #dfdfdf 70%, #dadada 100%);
	  -webkit-box-shadow: inset 0 1px #fdfdfd, inset 0 0 0 1px #eaeaea, 0 1px #a8a8a8, 0 3px #bbbbbb, 0 4px #a8a8a8, 0 5px 2px rgba(0, 0, 0, 0.25);
	  box-shadow: inset 0 1px #fdfdfd, inset 0 0 0 1px #eaeaea, 0 1px #a8a8a8, 0 3px #bbbbbb, 0 4px #a8a8a8, 0 5px 2px rgba(0, 0, 0, 0.25);
	}
	.button:hover, .button:active {
	  text-decoration: none;
	  background: #dfdfdf;
	  border-top-color: #c9c9c9;
	  cursor: pointer;
	}
	.button:active, .button.green:active, .button.blue:active, .button.yellow:active, .button.red:active, .button.purple:active, .button.grey:active, .button.black:active {
	  vertical-align: -5px;
	  margin-bottom: 0;
	  padding: 1px 13px 0;
	  border-width: 0;
	  border-radius: 3px;
	  -webkit-box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.3), inset 0 1px 1px rgba(0, 0, 0, 0.4), 0 1px white;
	  box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.3), inset 0 1px 1px rgba(0, 0, 0, 0.4), 0 1px white;
	}
	.button.black {
	  color: #f1f1f1;
	  text-shadow: 0 1px #111;
	  border-color: #505050 #414141 #2c2c2c;
	  background-color: #4f4f4f;
	  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #696969), color-stop(70%, #4f4f4f), color-stop(100%, #3c3c3c));
	  background-image: -webkit-linear-gradient(top, #696969 0%, #4f4f4f 70%, #3c3c3c 100%);
	  background-image: -moz-linear-gradient(top, #696969 0%, #4f4f4f 70%, #3c3c3c 100%);
	  background-image: -ms-linear-gradient(top, #696969 0%, #4f4f4f 70%, #3c3c3c 100%);
	  background-image: -o-linear-gradient(top, #696969 0%, #4f4f4f 70%, #3c3c3c 100%);
	  background-image: linear-gradient(top, #696969 0%, #4f4f4f 70%, #3c3c3c 100%);
	  -webkit-box-shadow: inset 0 1px #828282, inset 0 0 0 1px #555555, 0 1px #2c2c2c, 0 3px #444444, 0 4px #2c2c2c, 0 5px 2px rgba(0, 0, 0, 0.4);
	  box-shadow: inset 0 1px #828282, inset 0 0 0 1px #555555, 0 1px #2c2c2c, 0 3px #444444, 0 4px #2c2c2c, 0 5px 2px rgba(0, 0, 0, 0.4);
	}
	.button.black:hover, .button.black:active {
	  background: #4f4f4f;
	  border-top-color: #494949;
	}

	.lt-ie9 .button {
	  border-width: 1px;
	  padding: 0 12px;
	}
</style>
<script type="text/javascript">
var dates = <?=json_encode($dates)?>;

var clickDate = "";
var clickAgendaItem = "";
/**
 * Initialize with current year and date. Returns reference to plugin object.
 */
var jfcalplugin = $("#mycal").jFrontierCal({
	date: new Date(),
	dayClickCallback: myDayClickHandler,
	agendaClickCallback: myAgendaClickHandler,
	agendaDropCallback: myAgendaDropHandler,
	agendaMouseoverCallback: myAgendaMouseoverHandler,
	applyAgendaTooltipCallback: myApplyTooltip,
	dragAndDropEnabled: false
}).data("plugin");

<?php
foreach($dates as $eventItem):
	$strStartDate = explode(",",$eventItem['startDate']);
	if($strStartDate[1] == "1"){
		$strStartYear = $strStartDate[0] - 1;
		$strStartMonth = "12";
		$strStartDay = $strStartDate[2];
		$strStartHour = $strStartDate[3];
		$strStartMinute = $strStartDate[4];
	} else {
		$strStartYear = $strStartDate[0];
		$strStartMonth = $strStartDate[1] - 1;
		$strStartDay = $strStartDate[2];
		$strStartHour = $strStartDate[3];
		$strStartMinute = $strStartDate[4];
	}
	$strEndDate = explode(",",$eventItem['endDate']);
	if($strEndDate[1] == "1"){
		$strEndYear = $strEndDate[0] - 1;
		$strEndMonth = "12";
		$strEndDay = $strEndDate[2];
		$strEndHour = $strEndDate[3];
		$strEndMinute = $strEndDate[4];
	} else {
		$strEndYear = $strEndDate[0];
		$strEndMonth = $strEndDate[1] - 1;
		$strEndDay = $strEndDate[2];
		$strEndHour = $strEndDate[3];
		$strEndMinute = $strEndDate[4];
	}
?>
	jfcalplugin.addAgendaItem(
		"#mycal",
		"<?=$eventItem['title']?>",
		new Date(<?=$strStartYear.",".$strStartMonth.",".$strStartDay.",".$strStartHour.",".$strStartMinute.",0,0"?>),
		new Date(<?=$strEndYear.",".$strEndMonth.",".$strEndDay.",".$strEndHour.",".$strEndMinute.",0,0"?>),
		false,
		{
			calendar_id: <?=$eventItem['calendar_id']?>
		}
	);
	
<?php endforeach; ?>

/**
 * Get the date (Date object) of the day that was clicked from the event object
 */

function myDayClickHandler(eventObj){
	var date = eventObj.data.calDayDate;
	//$('label[for="Title"] span').text(date.toDateString());
	clickDate = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
	$('#add-event-form').dialog('open'); 
};

/**
 * Get the agenda item that was clicked.
 */
function myAgendaClickHandler (eventObj){
	// Get ID of the agenda item from the event object
	var agendaId = eventObj.data.agendaId;		
	// pull agenda item from calendar
	var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
	clickAgendaItem = agendaItem;
	$("#display-event-form").dialog('open');
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

function myAgendaMouseoverHandler(eventObj){
	var agendaId = eventObj.data.agendaId;
	var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
	//alert("You moused over agenda item " + agendaItem.title + " at location (X=" + eventObj.pageX + ", Y=" + eventObj.pageY + ")");
};

/**
 * Initialize jquery ui datepicker. set date format to yyyy-mm-dd for easy parsing
 */
$("#dateSelect").datepicker({
	showOtherMonths: true,
	selectOtherMonths: true,
	changeMonth: true,
	changeYear: true,
	showButtonPanel: true,
	dateFormat: 'yy-mm-dd'
});

/**
 * Set datepicker to current date
 */
$("#dateSelect").datepicker('setDate', new Date());
/**
 * Use reference to plugin object to a specific year/month
 */
$("#dateSelect").bind('change', function() {
	var selectedDate = $("#dateSelect").val();
	var dtArray = selectedDate.split("-");
	var year = dtArray[0];
	// jquery datepicker months start at 1 (1=January)		
	var month = dtArray[1];
	// strip any preceeding 0's		
	month = month.replace(/^[0]+/g,"")		
	var day = dtArray[2];
	// plugin uses 0-based months so we subtrac 1
	jfcalplugin.showMonth("#mycal",year,parseInt(month-1).toString());
});

/**
 * Initialize previous month button
 */
$("#BtnPreviousMonth").button();
$("#BtnPreviousMonth").click(function() {
	jfcalplugin.showPreviousMonth("#mycal");
	// update the jqeury datepicker value
	var calDate = jfcalplugin.getCurrentDate("#mycal"); // returns Date object
	var cyear = calDate.getFullYear();
	// Date month 0-based (0=January)
	var cmonth = calDate.getMonth();
	var cday = calDate.getDate();
	// jquery datepicker month starts at 1 (1=January) so we add 1
	$("#dateSelect").datepicker("setDate",cyear+"-"+(cmonth+1)+"-"+cday);
	return false;
});
/**
 * Initialize next month button
 */
$("#BtnNextMonth").button();
$("#BtnNextMonth").click(function() {
	jfcalplugin.showNextMonth("#mycal");
	// update the jqeury datepicker value
	var calDate = jfcalplugin.getCurrentDate("#mycal"); // returns Date object
	var cyear = calDate.getFullYear();
	// Date month 0-based (0=January)
	var cmonth = calDate.getMonth();
	var cday = calDate.getDate();
	// jquery datepicker month starts at 1 (1=January) so we add 1
	$("#dateSelect").datepicker("setDate",cyear+"-"+(cmonth+1)+"-"+cday);		
	return false;
});

/**
 * Initialize delete all agenda items button
 */
$("#BtnDeleteAll").button();
$("#BtnDeleteAll").click(function() {	
	jfcalplugin.deleteAllAgendaItems("#mycal");	
	return false;
});

/**
 * Initialize add event modal form
 */
$("#add-event-form").dialog({
	autoOpen: false,
	height: 400,
	width: 450,
	modal: true,
	buttons: {
		'Add Event': function() {

			var eventname = jQuery.trim($("#eventname").val());
			var startDate = $("#startDate").val();
			var endDate = $("#endDate").val();
		
			// Validation
			if(eventname == ""){
				elem = $('#eventname').css('border-color','red')
				$('#eventname').attr('placeholder','Please enter a short event description into the field');
				setTimeout(function(){ elem.css('border-color','#555'); },2000);
				$('#eventname').focus(function(){$(this).attr('placeholder',' ')})
			}else if (startDate == ""){
				elem = $('#startDate').css('border-color','red')
				$('#startDate').attr('placeholder','Pick start date');
				setTimeout(function(){ elem.css('border-color','#555'); },2000);
				$('#startDate').focus(function(){$(this).attr('placeholder',' ')})
			} else if (endDate == ""){
				elem = $('#endDate').css('border-color','red')
				$('#endDate').attr('placeholder','Pick end date');
				setTimeout(function(){ elem.css('border-color','#555'); },2000);
				$('#endDate').focus(function(){$(this).attr('placeholder',' ')})
			} else {
			
				var startDtArray = startDate.split("-");
				var startYear = startDtArray[0];
				// jquery datepicker months start at 1 (1=January)		
				var startMonth = startDtArray[1];		
				var startDay = startDtArray[2];
				// strip any preceeding 0's		
				startMonth = startMonth.replace(/^[0]+/g,"");
				startDay = startDay.replace(/^[0]+/g,"");
				var startHour = jQuery.trim($("#startHour").val());
				var startMin = jQuery.trim($("#startMin").val());
				var startMeridiem = jQuery.trim($("#startMeridiem").val());
				startHour = parseInt(startHour.replace(/^[0]+/g,""));
				if(startMin == "0" || startMin == "00"){
					startMin = 0;
				}else{
					startMin = parseInt(startMin.replace(/^[0]+/g,""));
				}
				if(startMeridiem == "AM" && startHour == 12){
					startHour = 0;
				}else if(startMeridiem == "PM" && startHour < 12){
					startHour = parseInt(startHour) + 12;
				}

				var endDtArray = endDate.split("-");
				var endYear = endDtArray[0];
				// jquery datepicker months start at 1 (1=January)		
				var endMonth = endDtArray[1];		
				var endDay = endDtArray[2];
				// strip any preceeding 0's		
				endMonth = endMonth.replace(/^[0]+/g,"");

				endDay = endDay.replace(/^[0]+/g,"");
				var endHour = jQuery.trim($("#endHour").val());
				var endMin = jQuery.trim($("#endMin").val());
				var endMeridiem = jQuery.trim($("#endMeridiem").val());
				endHour = parseInt(endHour.replace(/^[0]+/g,""));
				if(endMin == "0" || endMin == "00"){
					endMin = 0;
				}else{
					endMin = parseInt(endMin.replace(/^[0]+/g,""));
				}
				if(endMeridiem == "AM" && endHour == 12){
					endHour = 0;
				}else if(endMeridiem == "PM" && endHour < 12){
					endHour = parseInt(endHour) + 12;
				}
				
				// Dates use integers
				var startDateObj = new Date(parseInt(startYear),parseInt(startMonth)-1,parseInt(startDay),startHour,startMin,0,0);
				var endDateObj = new Date(parseInt(endYear),parseInt(endMonth)-1,parseInt(endDay),endHour,endMin,0,0);
				
				//console.log(startDateObj, endDateObj);

				// add new event to the calendar
				jfcalplugin.addAgendaItem(
					"#mycal",
					eventname,
					startDateObj,
					endDateObj,
					false
				);
				
				var startDateTime = startDtArray+','+startHour+','+startMin+',0,0';
				var endDateTime = endDtArray+','+endHour+','+endMin+',0,0';

				if(Date.parse(startDate) <= Date.parse(endDate)){
					// Ajax start here
					$.ajax({
						type: 'post',
						async: false,
						url: '/missions/Ajax_add_calendar_event',
						data: { 'csrf_workpad':getCookie('csrf_workpad'), 'work_id':<?=$work['work_id']?>, 'eventname':eventname, 'startDateTime':startDateTime, 'endDateTime':endDateTime },
						success: function(msg){
							if(msg!="" && msg!='error'){
								console.log(msg);
							} else {
								alert("Error");
							}
						}
					});
				}

				$(this).dialog('close');

			}
			
		},
		Cancel: function() {
			$(this).dialog('close');
		}
	},
	open: function(event, ui){
		// initialize start date picker
		$("#startDate").datepicker({
			showOtherMonths: true,
			selectOtherMonths: true,
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd'
		});
		// initialize end date picker
		$("#endDate").datepicker({
			showOtherMonths: true,
			selectOtherMonths: true,
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd'
		});
		
		// initialize with the date that was clicked
		$("#startDate").val(clickDate);
		$("#endDate").val(clickDate);
		$("#eventname").focus();
	},
	close: function() {
		// reset form elements when we close so they are fresh when the dialog is opened again.
		$("#startDate").datepicker("destroy");
		$("#endDate").datepicker("destroy");
		$("#startDate").val("");
		$("#endDate").val("");
		$("#startHour option:eq(0)").attr("selected", "selected");
		$("#startMin option:eq(0)").attr("selected", "selected");
		$("#startMeridiem option:eq(0)").attr("selected", "selected");
		$("#endHour option:eq(0)").attr("selected", "selected");
		$("#endMin option:eq(0)").attr("selected", "selected");
		$("#endMeridiem option:eq(0)").attr("selected", "selected");			
		$("#eventname").val("");
		//$("#colorBackground").val("#1040b0");
		//$("#colorForeground").val("#ffffff");
	}
});

/**
 * Initialize display event form.
 */
$("#display-event-form").dialog({
	autoOpen: false,
	height: 400,
	width: 450,
	modal: true,
	buttons: {		
		Cancel: function() {
			$(this).dialog('close');
		},
		'Edit': function() {
			var calendarID = clickAgendaItem.data.calendar_id;
			$.ajax({
				type: 'get',
				async: false,
				url: '/missions/Ajax_get_calendar_event',
				data: { 'csrf_workpad':getCookie('csrf_workpad'), 'calendarID':calendarID },
				success: function(msg){
					var msg = msg.replace('[','');
					var msg = msg.replace(']','');
					var eventDetails = jQuery.parseJSON(msg);
					//console.log(msg)
					$('#eventname2').attr('value',eventDetails.title);
					var StartDateTime = eventDetails.startDate;
					var subStartDateTime = StartDateTime.split(',');
					var startDate = subStartDateTime[0]+'-'+subStartDateTime[1]+'-'+subStartDateTime[2];
					$('#startDate2').attr('value',startDate);
					if(subStartDateTime[3] > 12){
						var startHour = subStartDateTime[3] - 12;
						var startMeridiem = 1;
					} else {
						var startHour = subStartDateTime[3];
						var startMeridiem = 0;
					}
					var startMinute = parseInt(subStartDateTime[4])/10;
					$('#startHour2 option:eq('+startHour+')').attr("selected", "selected");
					$('#startMin2 option:eq('+startMinute+')').attr("selected", "selected");
					$('#startMeridiem2 option:eq('+startMeridiem+')').attr("selected", "selected");
					
					var EndDateTime = eventDetails.endDate;
					var subEndDateTime = EndDateTime.split(',');
					var endDate = subEndDateTime[0]+'-'+subEndDateTime[1]+'-'+subEndDateTime[2];
					$('#endDate2').attr('value',endDate);
					if(subEndDateTime[3] > 12){
						var endHour = subEndDateTime[3] - 12;
						var endMeridiem = "PM";
					} else {
						var endHour = subEndDateTime[3];
						var endMeridiem = "AM";
					}
					var endMinute = parseInt(subEndDateTime[4])/10;
					$('#endHour2 option:eq('+endHour+')').attr("selected", "selected");
					$('#endMin2 option:eq('+endMinute+')').attr("selected", "selected");
					$('#endMeridiem2 option:eq('+endMeridiem+')').attr("selected", "selected");
				}
			});
			$('.edit-event').show();
			$('.show-event').hide();
		},
		'Delete': function() {
			if(confirm("Are you sure you want to delete this agenda item?")){
				if(clickAgendaItem != null){
					jfcalplugin.deleteAgendaItemById("#mycal",clickAgendaItem.agendaId);
					var agendaItem = clickAgendaItem.data.calendar_id;
					$.ajax({
						type: 'post',
						async: false,
						url: '/missions/Ajax_delete_calendar_event',
						data: { 'csrf_workpad':getCookie('csrf_workpad'), 'calendarID':agendaItem },
						success: function(msg){
							if(msg!="" && msg!='error'){
								console.log(msg);
							} else {
								alert("Error");
							}
						}
					});
				}
				$(this).dialog('close');
			}
		}			
	},
	open: function(event, ui){
		$('.edit-event').hide();
		$('.show-event').show();
		
		$("#startDate2").datepicker({
			showOtherMonths: true,
			selectOtherMonths: true,
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd'
		});
		// initialize end date picker
		$("#endDate2").datepicker({
			showOtherMonths: true,
			selectOtherMonths: true,
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd'
		});
		// initialize with the date that was clicked
		$("#startDate2").val(clickDate);
		$("#endDate2").val(clickDate);
		
		if(clickAgendaItem != null){
			//console.log(clickAgendaItem);
			var title = clickAgendaItem.title;
			var startDate = clickAgendaItem.startDate;
			var endDate = clickAgendaItem.endDate;
			var allDay = clickAgendaItem.allDay;
			//var data = clickAgendaItem.data;
			// in our example add agenda modal form we put some fake data in the agenda data. we can retrieve it here.
			
			$(".show-event").append(
				"<strong>" + title + "</strong><br><br>"		
			);			
			if(allDay){
				$(".show-event").append(
					"(All day event)<br><br>"				
				);				
			}else{
				$(".show-event").append(
					"<b>Starts:</b> " + startDate + "<br><br />" +
					"<b>Ends:</b> " + endDate + "<br><br>"				
				);				
			}
			/*for (var propertyName in data) {
				$("#display-event-form").append("<b>" + propertyName + ":</b> " + data[propertyName] + "<br>");
			}*/			
		}		
	},
	close: function() {
		// clear agenda data
		$(".show-event").html("");
		// reset form elements when we close so they are fresh when the dialog is opened again.
		$("#startDate2").datepicker("destroy");
		$("#endDate2").datepicker("destroy");
		$("#startDate2").val("");
		$("#endDate2").val("");
		$("#startHour2 option:eq(0)").attr("selected", "selected");
		$("#startMin2 option:eq(0)").attr("selected", "selected");
		$("#startMeridiem2 option:eq(0)").attr("selected", "selected");
		$("#endHour2 option:eq(0)").attr("selected", "selected");
		$("#endMin2 option:eq(0)").attr("selected", "selected");
		$("#endMeridiem2 option:eq(0)").attr("selected", "selected");			
		$("#eventname2").val("");
	}
});

$("#btnUpdate").click(function() {
	var calendarID = clickAgendaItem.data.calendar_id;
	var eventname = jQuery.trim($("#eventname2").val());
	var startDate = $("#startDate2").val();
	var endDate = $("#endDate2").val();

	// Validation
	if(eventname == ""){
		elem = $('#eventname2').css('border-color','red')
		$('#eventname2').attr('placeholder','Please enter a short event description into the field');
		setTimeout(function(){ elem.css('border-color','#555'); },2000);
		$('#eventname2').focus(function(){$(this).attr('placeholder',' ')})
	}else if (startDate == ""){
		elem = $('#startDate2').css('border-color','red')
		$('#startDate2').attr('placeholder','Pick start date');
		setTimeout(function(){ elem.css('border-color','#555'); },2000);
		$('#startDate2').focus(function(){$(this).attr('placeholder',' ')})
	} else if (endDate == ""){
		elem = $('#endDate2').css('border-color','red')
		$('#endDate2').attr('placeholder','Pick end date');
		setTimeout(function(){ elem.css('border-color','#555'); },2000);
		$('#endDate2').focus(function(){$(this).attr('placeholder',' ')})
	} else {
	
		var startDtArray = startDate.split("-");
		var startYear = startDtArray[0];
		// jquery datepicker months start at 1 (1=January)		
		var startMonth = startDtArray[1];		
		var startDay = startDtArray[2];
		// strip any preceeding 0's		
		startMonth = startMonth.replace(/^[0]+/g,"");
		startDay = startDay.replace(/^[0]+/g,"");
		var startHour = jQuery.trim($("#startHour2").val());
		var startMin = jQuery.trim($("#startMin2").val());
		var startMeridiem = jQuery.trim($("#startMeridiem2").val());
		startHour = parseInt(startHour.replace(/^[0]+/g,""));
		if(startMin == "0" || startMin == "00"){
			startMin = 0;
		}else{
			startMin = parseInt(startMin.replace(/^[0]+/g,""));
		}
		if(startMeridiem == "AM" && startHour == 12){
			startHour = 0;
		}else if(startMeridiem == "PM" && startHour < 12){
			startHour = parseInt(startHour) + 12;
		}

		var endDtArray = endDate.split("-");
		var endYear = endDtArray[0];
		// jquery datepicker months start at 1 (1=January)		
		var endMonth = endDtArray[1];		
		var endDay = endDtArray[2];
		// strip any preceeding 0's		
		endMonth = endMonth.replace(/^[0]+/g,"");

		endDay = endDay.replace(/^[0]+/g,"");
		var endHour = jQuery.trim($("#endHour2").val());
		var endMin = jQuery.trim($("#endMin2").val());
		var endMeridiem = jQuery.trim($("#endMeridiem2").val());
		endHour = parseInt(endHour.replace(/^[0]+/g,""));
		if(endMin == "0" || endMin == "00"){
			endMin = 0;
		}else{
			endMin = parseInt(endMin.replace(/^[0]+/g,""));
		}
		if(endMeridiem == "AM" && endHour == 12){
			endHour = 0;
		}else if(endMeridiem == "PM" && endHour < 12){
			endHour = parseInt(endHour) + 12;
		}
		
		// Dates use integers
		var startDateObj = new Date(parseInt(startYear),parseInt(startMonth)-1,parseInt(startDay),startHour,startMin,0,0);
		var endDateObj = new Date(parseInt(endYear),parseInt(endMonth)-1,parseInt(endDay),endHour,endMin,0,0);
		
		var startDateTime = startDtArray+','+startHour+','+startMin+',0,0';
		var endDateTime = endDtArray+','+endHour+','+endMin+',0,0';
		
		if(Date.parse(startDate) <= Date.parse(endDate)){
			// Ajax start here
			$.ajax({
				type: 'post',
				async: false,
				url: '/missions/Ajax_udpate_calendar_event',
				data: { 'csrf_workpad':getCookie('csrf_workpad'), 'eventname':eventname, 'startDateTime':startDateTime, 'endDateTime':endDateTime, 'calendar_id':calendarID },
				success: function(msg){
					if(msg!="" && msg!='error'){
						console.log(msg);
					} else {
						alert("Error");
					}
				}
			});
		}

		//$(this).dialog('close');
		location.reload();
	}
});

function myApplyTooltip(divElm,agendaItem){

	// Destroy currrent tooltip if present
	if(divElm.data("qtip")){
		divElm.qtip("destroy");
	}
	
	var displayData = "";
	
	var title = agendaItem.title;
	var startDate = agendaItem.startDate;
	var endDate = agendaItem.endDate;
	var allDay = agendaItem.allDay;
	//var data = agendaItem.data;
	displayData += "<strong>" + title+ "</strong><br />";
	if(allDay){
		displayData += "(All day event)<br />";
	}else{
		displayData += "<b>Starts:</b> " + startDate + "<br><br />" + "<b>Ends:</b> " + endDate + "<br><br>";
	}
	/*for (var propertyName in data) {
		displayData += "<b>" + propertyName + ":</b> " + data[propertyName] + "<br>"
	}*/
	// apply tooltip
	divElm.qtip({
		content: displayData,
		position: {
			corner: {
				tooltip: "bottomMiddle",
				target: "topMiddle"			
			},
			adjust: { 
				mouse: true,
				x: 0,
				y: -15
			},
			target: "mouse"
		},
		show: { 
			when: { 
				event: 'mouseover'
			}
		},
		style: {
			border: {
				width: 5,
				radius: 10
			},
			padding: 10, 
			textAlign: "left",
			tip: true,
			name: "dark"
		}
	});

};
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
