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
      <div class="tabs-row"> <a href="/missions/wall/<?=$work['work_id']?>" class="wall-active">Wall</a> <a class="task" href="/missions/task/<?=$work['work_id']?>">Task</a> <a class="document" href="/missions/documents/<?=$work['work_id']?>">Document</a> <a class="date" href="/missions/dates/<?=$work['work_id']?>">Date</a> </div>
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

<div id="add-event-form" title="Add Events" class="dialog">
	<form>
	<fieldset>
		<label for="Title">Event on <span></span></label>
		<input type="text" name="what" id="what" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .3em;"/>
		<table style="width:100%; padding:5px;">
			<tr>
				<td>
					<label>Start Date</label>
					<input type="text" name="startDate" id="startDate" value="" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .3em;"/>				
				</td>
				<td>&nbsp;</td>
				<td>
					<label>Start Hour</label>
					<select id="startHour" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .3em;">
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
				<td>
				<td>
					<label>Start Minute</label>
					<select id="startMin" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .3em;">
						<option value="00" SELECTED>00</option>
						<option value="10">10</option>
						<option value="20">20</option>
						<option value="30">30</option>
						<option value="40">40</option>
						<option value="50">50</option>
					</select>				
				<td>
				<td>
					<label>Start AM/PM</label>
					<select id="startMeridiem" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .3em;">
						<option value="AM" SELECTED>AM</option>
						<option value="PM">PM</option>
					</select>				
				</td>
			</tr>
			<tr>
				<td>
					<label>End Date</label>
					<input type="text" name="endDate" id="endDate" value="" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .3em;"/>				
				</td>
				<td>&nbsp;</td>
				<td>
					<label>End Hour</label>
					<select id="endHour" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .3em;">
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
				<td>
				<td>
					<label>End Minute</label>
					<select id="endMin" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .3em;">
						<option value="00" SELECTED>00</option>
						<option value="10">10</option>
						<option value="20">20</option>
						<option value="30">30</option>
						<option value="40">40</option>
						<option value="50">50</option>
					</select>				
				<td>
				<td>
					<label>End AM/PM</label>
					<select id="endMeridiem" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .3em;">
						<option value="AM" SELECTED>AM</option>
						<option value="PM">PM</option>
					</select>				
				</td>				
			</tr>			
		</table>
	</fieldset>
	</form>
</div>
<div id="display-event-form" title="View Agenda Item"></div>
<style type="text/css">
	.dialog {font-size:.8em}
	.dialog input:focus {outline:none; background:#111}
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
	dragAndDropEnabled: true
}).data("plugin");

/**
 * Get the date (Date object) of the day that was clicked from the event object
 */

function myDayClickHandler(eventObj){
	var date = eventObj.data.calDayDate;
	//alert("You clicked day " + date.toDateString());
	$('label[for="Title"] span').text(date.toDateString());
	//console.log(date.toDateString());
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
 * Initialize add event modal form
 */
$("#add-event-form").dialog({
	autoOpen: false,
	height: 400,
	width: 400,
	modal: true,
	buttons: {
		'Add Event': function() {

			var what = jQuery.trim($("#what").val());
		
			if(what == ""){
				alert("Please enter a short event description into the \"what\" field.");
			}else{
			
				var startDate = $("#startDate").val();
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

				var endDate = $("#endDate").val();
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
				
				//alert("Start time: " + startHour + ":" + startMin + " " + startMeridiem + ", End time: " + endHour + ":" + endMin + " " + endMeridiem);

				// Dates use integers
				var startDateObj = new Date(parseInt(startYear),parseInt(startMonth)-1,parseInt(startDay),startHour,startMin,0,0);
				var endDateObj = new Date(parseInt(endYear),parseInt(endMonth)-1,parseInt(endDay),endHour,endMin,0,0);

				// add new event to the calendar
				jfcalplugin.addAgendaItem(
					"#mycal",
					what,
					startDateObj,
					endDateObj,
					false,
					{
						fname: "Santa",
						lname: "Claus",
						leadReindeer: "Rudolph",
						myDate: new Date(),
						myNum: 42
					},
					{
						backgroundColor: $("#colorBackground").val(),
						foregroundColor: $("#colorForeground").val()
					}
				);

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
		// initialize color pickers
		/* $("#colorSelectorBackground").ColorPicker({
			color: "#333333",
			onShow: function (colpkr) {
				$(colpkr).css("z-index","10000");
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$("#colorSelectorBackground div").css("backgroundColor", "#" + hex);
				$("#colorBackground").val("#" + hex);
			}
		});
		//$("#colorBackground").val("#1040b0");		
		$("#colorSelectorForeground").ColorPicker({
			color: "#ffffff",
			onShow: function (colpkr) {
				$(colpkr).css("z-index","10000");
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$("#colorSelectorForeground div").css("backgroundColor", "#" + hex);
				$("#colorForeground").val("#" + hex);
			}
		}); */
		//$("#colorForeground").val("#ffffff");				
		// put focus on first form input element
		$("#what").focus();
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
		$("#what").val("");
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
	width: 400,
	modal: true,
	buttons: {		
		Cancel: function() {
			$(this).dialog('close');
		},
		'Edit': function() {
			alert("Create edit dialog box");
		},
		'Delete': function() {
			if(confirm("Are you sure you want to delete this agenda item?")){
				if(clickAgendaItem != null){
					jfcalplugin.deleteAgendaItemById("#mycal",clickAgendaItem.agendaId);
					//jfcalplugin.deleteAgendaItemByDataAttr("#mycal","myNum",42);
				}
				$(this).dialog('close');
			}
		}			
	},
	open: function(event, ui){
		if(clickAgendaItem != null){
			console.log(clickAgendaItem);
			var title = clickAgendaItem.title;
			var startDate = clickAgendaItem.startDate;
			var endDate = clickAgendaItem.endDate;
			var allDay = clickAgendaItem.allDay;
			var data = clickAgendaItem.data;
			// in our example add agenda modal form we put some fake data in the agenda data. we can retrieve it here.
			$("#display-event-form").append(
				"<br><b>" + title + "</b><br><br>"		
			);				
			if(allDay){
				$("#display-event-form").append(
					"(All day event)<br><br>"				
				);				
			}else{
				$("#display-event-form").append(
					"<b>Starts:</b> " + startDate + "<br>" +
					"<b>Ends:</b> " + endDate + "<br><br>"				
				);				
			}
			for (var propertyName in data) {
				$("#display-event-form").append("<b>" + propertyName + ":</b> " + data[propertyName] + "<br>");
			}			
		}		
	},
	close: function() {
		// clear agenda data
		$("#display-event-form").html("");
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
	var data = agendaItem.data;
	displayData += "<strong>" + title+ "</strong><br />";
	if(allDay){
		displayData += "(All day event)<br />";
	}else{
		displayData += "<b>Starts:</b> " + startDate + "<br>" + "<b>Ends:</b> " + endDate + "<br><br>";
	}
	for (var propertyName in data) {
		displayData += "<b>" + propertyName + ":</b> " + data[propertyName] + "<br>"
	}
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
