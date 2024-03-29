<?php $this->load->view('includes/header4'); ?>
<script type="text/javascript">
	var works = new Array();
	<?php
		foreach($works as $sprint=>$work_list):
			echo "d=new Object();\n";
			echo "d.sprint_id='".$sprint."';\n";
			echo "d.sprint_from='".$work_list['from']."';\n";
			echo "d.sprint_to='".$work_list['to']."';\n";
			echo "d.sprint_point='".$work_list['point']."';\n";
			echo "d.sprint_cost='".$work_list['cost']."';\n";
			echo "d.work_list= new Array();\n";
			echo "works.push(d);\n";
			foreach($work_list['list'] as $work):
				echo "d = new Object();\n";
				echo "d.id='".$work['work_id']."';\n";
				echo "d.title='".str_replace("'","\'",$work['title'])."';\n";
				echo "d.point='".str_replace("'","\'",$work['points']? $work['points']:0)."';\n";
				echo "d.cost='".str_replace("'","\'",$work['cost']? $work['cost']:0)."';\n";
				echo "d.status='".$work['status']."';\n";
				echo "d.description='".substr(trim(str_replace("'","\'",str_replace(array("\n","\t"),'',strip_tags(nl2br($work['description']))))),0,252)."';\n";
				echo "works[works.length-1].work_list.push(d);\n";
			endforeach;
		endforeach;
	?>
</script>

<div id="wrapper" style="padding:60px 10px 200px 10px; margin-top:10px;">
  <div class="contents">
  	<h1 style="margin-left:20px"><a href="/project/<?=$project_sel?>"><?=$project['project_name']?></a> <a href="/project/print_sprints/<?=$project_sel?>"><img align="absmiddle" src="/public/images/export.png" /></a></h1>
    <div id="plan_holder" class="scrum_holder">
      <div id="sprint_planner">
        <div class="scrum_column" id="ice_box">
          <h2>Ice Box</h2>
          <div id="product_backlog" class="story_list">
            <!-- <li class="empty_space hint_step1"> <span style="margin-left: 67px;">+ Add User Story</span> </li> -->
            <li class="empty_space"> <span style="margin-left: 67px;">+ Add User Story</span> </li>
          </div>
        </div>
        <div class="scrum_column" id="sprint_1">
          <h2 class="sprint-title"><a href='<?php if(isset($project_sel)){?>/project/scrum_board/<?=$project_sel?>/<?=$first_sprint?><?php }else{?>#<?php }?>'>Sprint 1</a> <a style="height:10px;float: Right;position:relative;top:-16px;left:4px;" class="minimize" href="javascript:void(0)"><img height="10px" width="10px" border="0" src="/public/images/icon-minimize.png" /></a></a></h2>
          <ul class="timeline">
            <li><b>Strt:</b>
              <input name="startSprint1" class="start" />
            </li>
            <li><b>End:</b>
              <input name="endSprint1" class="end" />
            </li>
          </ul>
          <div style="clear:both"></div>
          <div class="timeline-holder">
            <div class="datestart">
              <p class="day_date">
                S
              </p>
              <p class="monthyear_date">
                tart Date
              </p>
            </div>
            <div class="timeline-path">
              <span class="total-burndown"></span>
              <div class="mark" style="margin-left:15px;"></div>
            </div>
            <div class="dateend">
              <p class="day_date">E</p>
              <p class="monthyear_date">nd Date</p>
            </div>
          </div>
          <div style="clear:both"></div>
          <div id="scrum1" class="story_list"> </div>
        </div>
        <div class="add_sprint"></div>
      </div>
    </div>
  </div>
</div>
<div style="display:none" id="dialog-confirm" title="Remove the Sprint?">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>'Selected Sprint will be deleted and all user stories under it will move to Icebox. Are you sure?'</p>
</div>
<div style="display:none" id="story_dialog-confirm" title="Remove the Story?">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>'Selected Story will be deleted. Are you sure?'</p>
</div>
<div style="display:none" id="save_dialog-confirm" title="Save Sprints?">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>'Sprints have been modified. Would you like to save the changes?'</p>
</div>
<input type="hidden" id="buffer" />
<style type="text/css">
.total-burndown {
	width: 153px;
	display: block;
	text-align: center;
	margin-top: 10px;
}
.action-icons{
	float: Right;
	width: 10px;
	font-size:8px;
}
.action-icons img{margin:2px 2px;}

	.locked{background:#2d2d2d; font-family:"DINRegular";}
	ul.options{margin:3px 0 0 -40px; float: left; padding-top:4px;display:none;width:280px; border-top:1px ridge #414a4e;}
	.sprint-title{
		width: 279px;
		background: url(/public/images/qualif-table-header.png);
		float: left;
		margin: 0;
		padding: 10px 10px 10px 11px;text-shadow: 0 1px 10px white;
		border-top-left-radius: 10px;
		border-top-right-radius: 10px;}
	.timeline {
		list-style: none;
		float: right;
		margin: -45px 25px 0 0;
		padding: 0;
		width: 139px;
		font-size: 13px;
		color: white;
		text-align: right;
	}
	
	.start, .end { width: 70px; border:none; }
	
	.scrum_holder{
		width:1140;
		overflow-x:scroll;
	}
	#sprint_planner{
		width: 920px;
	}
	ul.options li {display:inline-block;padding-right:15px;padding-bottom:5px;margin-top:5px;}
	#scrum_board{width:2000px;}
	.add_sprint{
		width: 15px;
		height:460px;
		float:left;
		cursor:pointer;
	}
	.add_sprint:hover{
		background:#CCC;	
	}
	.new_story input[type="text"]{
		color:black;
		border:1px solid;
		width:256px;
		margin: 0 5px;	
		padding:10px;
		-moz-border-radius: 5px;
	    -webkit-border-radius: 5px;
	    border-radius: 5px;
		
	}
	.scrum_column{margin-right: 5px;
		float:left;
		width:300px;
		min-height:400px;
		border:1px #999 solid;
		-moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		border-radius: 10px;
		background:url(/public/images/scrum.png);
		/*background-image: linear-gradient(bottom, rgba(185,217,250,0.2) 0%, rgba(221,255,221,0.2) 61%, rgba(255,255,255,0.2) 81%);
		background-image: -o-linear-gradient(bottom, rgba(185,217,250,0.2) 0%, rgba(221,255,221,0.2) 61%, rgba(255,255,255,0.2) 81%);
		background-image: -moz-linear-gradient(bottom, rgba(185,217,250,0.2) 0%, rgba(221,255,221,0.2) 61%, rgba(255,255,255,0.2) 81%);
		background-image: -webkit-linear-gradient(bottom, rgba(185,217,250,0.2) 0%, rgba(221,255,221,0.2) 61%, rgba(255,255,255,0.2) 81%);
		background-image: -ms-linear-gradient(bottom, rgba(185,217,250,0.2) 0%, rgba(221,255,221,0.2) 61%, rgba(255,255,255,0.2) 81%);
		
		background-image: -webkit-gradient(
			linear,
			left bottom,
			left top,
			color-stop(0, rgba(185,217,250,0.2)),
			color-stop(0.61, rgba(221,255,221,0.2)),
			color-stop(0.81, rgba(255,255,255,0.2))
		);*/
	}
	
	.story_list{
		width: 300px;
		padding:0;
		margin-left:0;
		min-height:400px;
		-webkit-padding-start: 0;
	}
	
	.story_list li{
		list-style:none;
		margin: 0 5px;
		font-size: 14px;
	}
	.datestart, .dateend {float:left;padding:8px;}
	.timeline-holder {margin: 10px 0 10px 2px;float: left; width:298px;}
	.title_story {font-family: DINregular;font-size: 16px;float: left;width:230px;padding: 0 5px 0 0;}
	.status {padding: 0 0 0 5px;}
	.short_story {	margin: 5px 10px 10px 0;; float: left;
					line-height: 17px;
					font-size: 13px;
					color: #D9D9D9; }
	.day_date { color:#fff; letter-spacing:-2px;
			margin-top: -5px;
			font-size: 30px;
			float: left;}
	.monthyear_date { width:30px;
		 	color:#fff;
			margin: 0;
			font-size: 11px;
			float: left;}
	.timeline-path {
			background:url(/public/images/time-line.png) left; float:left; width:155px; height:15px;margin: 15px 0 0 -5px;}
	.timeline-path .mark {background:url(/public/images/time-line.png) right; width:11px; height:15px; margin-top:-3px;}
	#sprint_planner .story_list li.user_story{
		cursor:move;OVERFLOW:HIDDEN;
		-webkit-box-shadow: 1px 2px 3px rgba(26, 50, 50, 0.36);
		-moz-box-shadow: 1px 2px 3px rgba(26, 50, 50, 0.36);
		box-shadow: inset 1px 2px 3px rgba(26, 50, 50, 0.36);
		bordeR: 0;
		background: #525B62;
		border: 0px;
		border-right: 1px solid #797979;
		border-bottom: 1px solid #797979;
		margin-bottom: 5px;
	}
	
	
	
	.story_list a#view { text-indent:-99999px; display:block; background:url(/public/images/vieweditdelete.png) left top; width: 58px;}
	.story_list a#view:hover {background:url(/public/images/vieweditdelete.png) left bottom;}
	.story_list a#edit {text-indent:-99999px; display:block; background:url(/public/images/vieweditdelete.png) -62px top; width: 52px;}
	.story_list a#edit:hover { background:url(/public/images/vieweditdelete.png) -62px bottom;}
	.story_list a#delete {text-indent:-99999px; display:block; background:url(/public/images/vieweditdelete.png) -114px top; width: 64px;}
	.story_list a#delete:hover {background:url(/public/images/vieweditdelete.png) -114px bottom;}
	
	
	h1, h2, h3, h4, h5, h6 {
	color: white;
	font-weight: normal;
	text-transform: uppercase;
	}
	h2 {
	font-family: "DINRegular";
	
	margin: 10px;
	font-size: 1.5em;
	}
	#wrapper .contents h1 {
	text-shadow: 0 1px 10px white;
	font-size: 32px;
	font-weight: lighter;
	}
	.story_list li.empty_space{
		cursor:pointer;
		margin: 0 5px 5px 5px;
	}
	
	h2{
		font-family:"DINRegular";
		
		margin: 10px;
		font-size:1.5em;
	}
	
	.empty_space, .add_sprint{
		background: none !important;
		border: #CCC thin dashed !important;
		font-size: 17px !important;
		color: white;
		cursor: pointer !important;
		-moz-border-radius: 5px;
	    -webkit-border-radius: 5px;
	    border-radius: 5px;
		margin:2px 2px 10px 0; 
	}
	
	.empty_space:hover{
		background: #ccc !important;
		color:#000 !important;
	}
	
	.user_story{font-family:"DINLightAlternate";
		background:#fff;
		padding:10px 0 10px 10px;
		color:#fff;
		border: 1px solid black;
		-moz-border-radius: 5px;
	    -webkit-border-radius: 5px;
	    border-radius: 5px;
		
	}
	.user_story:hover {opacity:1}
	
	.my-work{
		background-color:green;	
	}
	.status{font-size:9px;}
	
	.ui-state-highlight { height: 1.5em; line-height: 1.2em; }
	
	.Reject{background:url(/public/images/planner-badges.png) left; width:36px; height:50px;float: right;margin: -5px 1px -5px 0;}
	.Redo {background:url(/public/images/planner-badges.png) -36px; width:36px; height:50px;float: right;margin: -5px 1px -5px 0;}
	.draft {background:url(/public/images/planner-badges.png) -72px; width:36px; height:50px;float: right;margin: -5px 1px -5px 0;}
	.Signoff {background:url(/public/images/planner-badges.png) -108px; width:36px; height:50px;float: right;margin: -5px 1px -5px 0;}
	.Verify {background:url(/public/images/planner-badges.png) -144px; width:36px; height:50px;float: right;margin: -5px 1px -5px 0;}
	.Done {background:url(/public/images/planner-badges.png) -180px;; width:36px; height:50px;float: right;margin: -5px 1px -5px 0;}
	.open {background:url(/public/images/planner-badges.png) -216px; width:36px; height:50px;float: right;margin: -5px 1px -5px 0;}
	.Progress{background:url(/public/images/planner-badges.png) -251px; width:36px; height:50px;float: right;margin: -5px 1px -5px 0;}
	.minimized{width:10px !important;}
</style>
<script type="text/javascript">
var sprint_modified = false;

$(init);
function init(){
	$('#product_backlog').sortable({cancel: '.empty_space', connectWith: '#scrum1', remove: function(){reclac_sprint_points();}});
	$('#scrum1').sortable({connectWith:'#product_backlog', remove: function(){reclac_sprint_points();}});
	$('input[name="startSprint1"]').datepicker({ dateFormat: 'yy-mm-dd',
	'onSelect': function(date,ins){
			sprint_modified = true;
			s = new Date(date.substr(0,4),date.substr(5,2) - 1,date.substr(8,2));
			$('.day_date',$(this).parent().parent().parent()).first().html($.datepicker.formatDate('dd', s));
			$('.monthyear_date',$(this).parent().parent().parent()).first().html($.datepicker.formatDate('M yy', s));
		} 
	});
	$('input[name="endSprint1"]').datepicker({ dateFormat: 'yy-mm-dd', 
	'onSelect': function(date,ins){
			sprint_modified = true;
			s = new Date(date.substr(0,4),date.substr(5,2) - 1,date.substr(8,2));
			$('.day_date',$(this).parent().parent().parent()).last().html($.datepicker.formatDate('dd', s));
			$('.monthyear_date',$(this).parent().parent().parent()).last().html($.datepicker.formatDate('M yy', s));
		} 
	});
	$('.datestart').click(function(){$('input[name="startSprint1"]').datepicker('show')});
	$('.dateend').click(function(){$('input[name="endSprint1"]').datepicker('show')});
	populate(works);
	<?php if($enable_sprint_locks){?>lockSprint(<?=$curSprint?>);<?php }?>
	$('a[href*="/"]').click(function(){return ask_save($(this).attr('href'));});
}

function percentage(start,end){
	t = (end-start)/(1000*24*60*60);
	now = new Date(<?=date('Y')?>,<?=date('m')?>-1,<?=date('d')?>);
	c = (now-start)/(1000*24*60*60);
	return c/t;
}

function lockSprint(i){
	$('.story_list').each(function(){
		if($(this).data('sprint_id')==i){
			$(this).sortable( "option", "disabled", true );
			$(this).addClass('lock');
			par = $(this).parent();
			par.addClass('locked');
			$('.start', par).attr('disabled','disabled');
			$('.end', par).attr('disabled','disabled');
		}
	});	
}

$('.story_list').on('mouseenter','.user_story',function(){
		$('.options',this).stop(true, true).slideDown();
	});
$('.story_list').on('mouseleave','.user_story',function(){
		$('.options',this).stop(true, true).slideUp();
	});
	
function save_list(){
	$.ajaxSetup({async:false});
	$('.story_list').each(function(){
		if($(this).data('sprint_id')!==undefined){
			//save the order into an existing sprint id
			//if (typeof console == "object") console.log('sprint id '+$(this).data('sprint_id')+' includes '+JSON.stringify($(this).sortable('toArray')));
			sprint_id = $(this).data('sprint_id');
		}
		if($(this).data('sprint_id')===undefined){
			//sprint is new and we don't have a sprint id
			//if (typeof console == "object") console.log('New sprint. includes '+$(this).sortable('toArray'));
			sprint_id = 'new';
		}
		//update priority of all user stories that belong to sprint id
		date_from = $('.start',$(this).parent()).val();
		date_to = $('.end',$(this).parent()).val();
		if (typeof console == "object") console.log('process sprint '+sprint_id);
		if (typeof console == "object") console.log('sprint is from '+date_from+' to '+date_to);
		data = JSON.stringify($(this).sortable('toArray'));
		$.post(
		'/project/AjaxSavePriority',
		{ 'data': data, 'date_from': date_from, 'date_to': date_to, 'sprint_id': sprint_id, 'project_id': <?=$project_sel?>, 'ci_csrf_token': '<?php echo $this->security->get_csrf_hash(); ?>' },
		function(msg){
			if (typeof console == "object") console.log('process done.');
			if(msg!='0'){
				//TODO
				if($(this).data('sprint_id')===undefined){
					$(this).data('sprint_id',msg);
				}
				if (typeof console == "object") console.log('sprint '+msg+' successfuly saved.');
			}
		});
	});
	alert('Your project is saved successfully.');
	sprint_modified = false;
	$.ajaxSetup({async:true});
}

function ask_save(href){
	if(sprint_modified){
		$( "#save_dialog-confirm:ui-dialog" ).dialog( "destroy" );
		$( "#save_dialog-confirm" ).dialog({
			resizable: false,
			height:240,
			width:470,
			modal: true,
			buttons: {
				"SAVE": function() {
					$( this ).dialog( "close" );
					save_list();
					window.location.href=href;
				},
				Cancel: function() {
					$( this ).dialog( "close" );
					window.location.href=href;
				}
			}
		});
	}
	return !sprint_modified;
}

function deleteUserStory(work_id){
	$( "#story_dialog-confirm:ui-dialog" ).dialog( "destroy" );
	$( "#story_dialog-confirm" ).dialog({
		resizable: false,
		height:240,
		width:470,
		modal: true,
		buttons: {
			"Delete Story": function() {
				$( this ).dialog( "close" );
				$.post(
					"/project/AjaxDeleteStory",
					{ 'work_id': work_id, 'project_id': <?=$project_sel?>, 'ci_csrf_token': '<?php echo $this->security->get_csrf_hash(); ?>' },
					function(msg){
						if(msg!='0'){
							$('#work_'+msg).hide(1000,function(){$(this).remove();reclac_sprint_points();});
						}else{
							alert('Error: Unable to remove User Story '+msg);
						}
					}
				);
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
}

function populate(works){
	var first_sprint=true;
	for(sprint in works){
		work_list = works[sprint].work_list;
		sprint_id = works[sprint].sprint_id;
		sprint_from = works[sprint].sprint_from;
		sprint_to = works[sprint].sprint_to;
		sprint_point = works[sprint].sprint_point;
		sprint_cost = works[sprint].sprint_cost;
		if(sprint_id!=0 && first_sprint){//populate first sprint
			first_sprint = false;
			cur_sprint = $('#scrum1');
			cur_sprint.data('sprint_id',sprint_id);
			$('.start',cur_sprint.parent()).val(sprint_from);
			$('.end',cur_sprint.parent()).val(sprint_to);
			if(isNaN(sprint_point))sprint_point=0;
			if(isNaN(sprint_cost))sprint_cost=0;
			$('.total-burndown',cur_sprint.parent()).html('Total: '+sprint_point+'pt, '+sprint_cost+'RM');
			if(sprint_from!=''){
				s = new Date(sprint_from.substr(0,4),sprint_from.substr(5,2)-1,sprint_from.substr(8,2));
				$('.day_date',cur_sprint.parent()).first().html($.datepicker.formatDate('dd', s));
				$('.monthyear_date',cur_sprint.parent()).first().html($.datepicker.formatDate('M yy', s));
			}
			if(sprint_to!=''){
				e = new Date(sprint_to.substr(0,4),sprint_to.substr(5,2)-1,sprint_to.substr(8,2));
				$('.day_date',cur_sprint.parent()).last().html($.datepicker.formatDate('dd', e));
				$('.monthyear_date',cur_sprint.parent()).last().html($.datepicker.formatDate('M yy', e));
			}
			if(sprint_from!='' && sprint_to!=''){
				var percent = percentage(s,e);
				if(percent>=0 && percent <=1){
					$('.mark',cur_sprint.parent()).css({'margin-left': Math.round(percent*145)});
				}else{
					$('.mark',cur_sprint.parent()).hide();
				}
			}else{
				$('.mark',cur_sprint.parent()).hide();
			}
			for(i=0;i<work_list.length;i++){
				var data=work_list[i];
				entry = data.description;
				if(isNaN(data.point))data.point=0;
				if(isNaN(data.cost))data.cost=0;
				cur_sprint.append('<li id="work_'+data.id+'" class="user_story ui-state-default"><div class="'+data.status+'"></div><span class="title_story">'+data.title+'</span><span class="status">'+data.point+'pt '+data.cost+'RM '+data.status+'</span><br><span class="short_story">'+entry+'</span><ul class="options" ><li><a id="view" href="/story/'+data.id+'">view</a><li><a id="edit" href="/story/edit/'+data.id+'">edit</a></li><li><a onclick="deleteUserStory(\''+data.id+'\')" id="delete" href="javascript:void(0)">Delete</a></li></ul></li>');
				$('#work_'+data.id).data('point',data.point);
				$('#work_'+data.id).data('cost',data.cost);
			}
		}else if(sprint_id!=0 && !first_sprint){//add a new sprint
			$('.add_sprint').click();
			cur_sprint = $('#scrum'+num_sprints);
			cur_sprint.parent().find('.sprint-title .title').html('<a href="/project/scrum_board/<?=$project_sel?>/'+sprint_id+'">SPRINT '+num_sprints+"</a>");
			cur_sprint.data('sprint_id', sprint_id);
			$('.start',cur_sprint.parent()).val(sprint_from);
			$('.end',cur_sprint.parent()).val(sprint_to);
			if(isNaN(sprint_point))sprint_point=0;
			if(isNaN(sprint_cost))sprint_cost=0;
			$('.total-burndown',cur_sprint.parent()).html('Total: '+sprint_point+'pt, '+sprint_cost+'RM');
			if(sprint_from!=''){
				s = new Date(sprint_from.substr(0,4),sprint_from.substr(5,2)-1,sprint_from.substr(8,2));
				$('.day_date',cur_sprint.parent()).first().html($.datepicker.formatDate('dd', s));
				$('.monthyear_date',cur_sprint.parent()).first().html($.datepicker.formatDate('M yy', s));
			}
			if(sprint_to!=''){
				e = new Date(sprint_to.substr(0,4),sprint_to.substr(5,2)-1,sprint_to.substr(8,2));
				$('.day_date',cur_sprint.parent()).last().html($.datepicker.formatDate('dd', e));
				$('.monthyear_date',cur_sprint.parent()).last().html($.datepicker.formatDate('M yy', e));
			}
			if(sprint_from!='' && sprint_to!=''){
				var percent = percentage(s,e);
				if(percent>=0 && percent <=1){
					$('.mark',cur_sprint.parent()).css({'margin-left': Math.round(percent*145)});
				}else{
					$('.mark',cur_sprint.parent()).hide();
				}
			}else{
				$('.mark',cur_sprint.parent()).hide();
			}
			for(i=0;i<work_list.length;i++){
				var data=work_list[i];
				entry = data.description;
				if(isNaN(data.point))data.point=0;
				if(isNaN(data.cost))data.cost=0;
				cur_sprint.append('<li id="work_'+data.id+'" class="user_story ui-state-default"><div class="'+data.status+'"></div><span class="title_story">'+data.title+'</span><span class="status">'+data.point+'pt '+data.cost+'RM '+data.status+'</span><br><span class="short_story">'+entry+'</span><ul class="options"><li><a id="view" href="/story/'+data.id+'">view</a></li><li><a id="edit" href="/story/edit/'+data.id+'">edit</a></li><li><a onclick="deleteUserStory(\''+data.id+'\')" href="javascript:void(0)" id="delete">Delete</a></li></ul></li>');
				$('#work_'+data.id).data('point',data.point);
				$('#work_'+data.id).data('cost',data.cost);
			}
		}
		if(sprint_id==0){//ice box
			cur_sprint = $('#product_backlog');
			cur_sprint.data('sprint_id','0');
			for(i=0;i<work_list.length;i++){
				var data=work_list[i];
				entry = data.description;
				if(isNaN(data.point))data.point=0;
				if(isNaN(data.cost))data.cost=0;
				cur_sprint.append('<li id="work_'+data.id+'" class="user_story ui-state-default"><div class="'+data.status+'"></div><span class="title_story">'+data.title+'</span><span class="status">'+data.point+'pt '+data.cost+'RM '+data.status+'</span><br><span class="short_story">'+entry+'</span><ul class="options"><li><a id="view" href="/story/'+data.id+'">view</a></li><li><a id="edit" href="/story/edit/'+data.id+'">edit</a></li><li><a onclick="deleteUserStory(\''+data.id+'\')" id="delete" href="javascript:void(0)">Delete</a></li></ul></li>');
				$('#work_'+data.id).data('point',data.point);
				$('#work_'+data.id).data('cost',data.cost);
			}
		}
	}
	var max_height = 0;
	//find the highest height
	$('.story_list').each(function(){if($(this).height()>max_height)max_height = $(this).height();})
	//adjust their height to max
	$('.story_list').css({'min-height': max_height+'px'});
	$('.add_sprint').css('min-height',(max_height+120));
	resume_sprint_visibility();
}

function resume_sprint_visibility(){
	$(".scrum_column").each(function(){
			column = $(this);
			status = getCookie(column.attr('id') + "_<?=$project_sel?>_<?=$curSprint?>");
			if (status === "hide"){
				column.addClass('minimized').find('*').hide();
				var max_height=0;
				$('.story_list').each(function(){if($(this).height()>max_height)max_height = $(this).height();});
				column.append('<div style="height:'+max_height+'px;" class="maximize"></div>');
			}
		});
}

var num_sprints = 1; num_edits=0;
function remove_sprint(id){
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "#dialog-confirm" ).dialog({
		resizable: false,
		height:240,
		width:470,
		modal: true,
		buttons: {
			"Delete Sprint": function() {
				$( this ).dialog( "close" );
				cur_sprint = $('#scrum'+id);
				if(cur_sprint.data('sprint_id')!==undefined){
					window.location.replace('/project/removeSprint/'+cur_sprint.data('sprint_id'));
				}else{
					$('.user_story', cur_sprint).each(function(){t=$(this).remove();$('#product_backlog').append(t);});
					cur_sprint.parent().remove();
				}
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
}
$('.add_sprint').click(function(){
		num_sprints++;
		obj = $('#sprint_planner');
		obj.width(obj.width()+460);
		//find the highest height
		var max_height=0;
		$('.story_list').each(function(){if($(this).height()>max_height)max_height = $(this).height();})
		//adjust their height to max
		$('.story_list').css({'min-height': max_height+'px'});
		$(this).before('<div id="col_'+num_sprints+'" class="scrum_column"><h2 class="sprint-title"><span class="title">Sprint '+num_sprints+'</span> <div class="action-icons"><a class="minimize" href="javascript:void(0)"><img height="10px" width="10px" border="0" src="/public/images/icon-minimize.png" /></a><a class="remove" href="javascript:  remove_sprint('+num_sprints+')"><img height="10px" width="10px" src="/public/images/icon_delete.png" border="0" /></a></div></h2><ul class="timeline"><li><b>Strt:</b> <input name="startSprint'+num_sprints+'" class="start" /></li><li><b>End:</b> <input name="endSprint'+num_sprints+'" class="end" /></li></ul><div style="clear:both"></div><div class="timeline-holder"><div class="datestart"><p class="day_date">S</p><p class="monthyear_date">tart Date</p></div><div class="timeline-path"><div class="mark" style="margin-left:15px;"></div><span class="total-burndown"></span></div><div class="dateend"><p class="day_date">E</p><p class="monthyear_date">nd Date</p></div></div><div style=" clear:both"><ul class="sprint-info"></div><div id="scrum'+num_sprints+'" class="story_list" style="min-height: '+max_height+'px"></div></div>');
		$('.minimize').unbind('click');
		$('.minimize').click(function(){
				column = $(this).parents('.scrum_column');
				column.addClass('minimized').find('*').hide();
				column.append('<div style="height:'+max_height+'px;" class="maximize"></div>');
				setCookie(column.attr('id') + "_<?=$project_sel?>_<?=$curSprint?>", "hide");
			});
		$('.scrum_column').off('click','.maximize');
		$('.scrum_column').on('click','.maximize',function(){
			column = $(this).parent();
			if(column.hasClass('minimized')){
				column.remove('.maximize');
				column.removeClass('minimized').find('*:not(.options,.mark)').show();
				$(this).remove();
				setCookie(column.attr('id') + "_<?=$project_sel?>_<?=$curSprint?>", "show");
			}
		});
		tmpCurSprint = $('#scrum'+num_sprints).parent();
		$('input[name="startSprint'+num_sprints+'"]', tmpCurSprint).datepicker({ dateFormat: 'yy-mm-dd',
		'onSelect': function(date,ins){
				sprint_modified = true;
				s = new Date(date.substr(0,4),date.substr(5,2) - 1,date.substr(8,2));
				$('.day_date',$(this).parent().parent().parent()).first().html($.datepicker.formatDate('dd', s));
				$('.monthyear_date',$(this).parent().parent().parent()).first().html($.datepicker.formatDate('M yy', s));
			} 
		});
		$('input[name="endSprint'+num_sprints+'"]', tmpCurSprint).datepicker({ dateFormat: 'yy-mm-dd', 
		'onSelect': function(date,ins){
				sprint_modified = true;
				s = new Date(date.substr(0,4),date.substr(5,2) - 1,date.substr(8,2));
				$('.day_date',$(this).parent().parent().parent()).last().html($.datepicker.formatDate('dd', s));
				$('.monthyear_date',$(this).parent().parent().parent()).last().html($.datepicker.formatDate('M yy', s));
			} 
		});
		//if (typeof console == "object") console.log($('.datestart',tmpCurSprint));
		$('.datestart',tmpCurSprint).click(function(){
				$('.start',$(this).parent().parent()).datepicker('show');
			});
		$('.dateend',tmpCurSprint).click(function(){
				$('.end',$(this).parent().parent()).datepicker('show');
			});
		//connect sprints with eachothers
		for(j=num_sprints;j>0;j--){
			buffer = '#product_backlog';
			for(i=1;i<=num_sprints;i++)if(j!=i)buffer += (',#scrum'+i);
			if(j==num_sprints)$('#scrum'+j).sortable({connectWith: buffer, remove: function(){reclac_sprint_points();}});
			else $('#scrum'+j).sortable( "option", "connectWith", buffer );
		}
		//connect product backlog to sprints
		buffer = '#scrum1';
		for(i=2;i<=num_sprints;i++)buffer+=(',#scrum'+i);
		$( "#product_backlog" ).sortable( "option", "connectWith", buffer );
		$('.story_list').on('mouseenter','.user_story',function(){
		$('.options',this).slideDown();
			});
		$('.story_list').on('mouseleave','.user_story',function(){
				$('.options',this).slideUp();
			});
	});
		
$('#product_backlog').on('click','.empty_space',function(){
		num_edits++;
		$(this).after('<li class="new_story"><input id="edit'+num_edits+'" type="text"></li>');
		$('input#edit'+num_edits).focus();
	});
	
$('#product_backlog').on('click','.short_story',function(){
		entry = $(this).html();
		num_edits++;
		id=$(this).parent().attr('id');
		title = $('.title_story',$(this).parent()).html();
		$(this).parent().replaceWith('<li id="'+id+'" class="new_story edit_story"><input id="edit'+num_edits+'" type="text" value="'+entry+'"></li>');
		$('input#edit'+num_edits).data('title',title);
		$('input#edit'+num_edits).focus();
	});

$('#product_backlog').on('click','.new_story',function(){$('input',this).focus();});

function reclac_sprint_points(){
	sprint_modified = true;
	$('.story_list').each(function(){
		var sum=0; var cost = 0;
		$('.user_story',$(this)).each(function(){sum += Math.round($(this).data('point'));cost += Math.round($(this).data('cost'));});
		if(isNaN(sum))sum=0;
		if(isNaN(cost))cost=0;
		$('.total-burndown',$(this).parent()).html('Total: '+sum	+'pt, '+cost+'RM');
		
		var max_height = 0;
		//find the highest height
		$('.story_list').each(function(){if($(this).height()>max_height)max_height = $(this).height();})
		//adjust their height to max
		$('.story_list').css('min-height',max_height);
		$('.add_sprint').css('min-height',max_height);
	});
}

function saveUserStory(obj){
	entry = $.trim($('input', obj).val());
	var title = $.trim($('input', obj).data('title'));
	if(entry!=''){
		if(obj.hasClass('edit_story')){
			url="/project/AjaxUpdateStory";
			var work_id = obj.attr('id').substring(5,obj.attr('id').length);
			$.post(
			url,
			{ 'data': entry, 'work_id': work_id, 'project_id': <?=$project_sel?>, 'ci_csrf_token': '<?php echo $this->security->get_csrf_hash(); ?>' },
			function(msg){
				if(msg!='0')
					obj.replaceWith('<li id="work_'+msg+'" class="user_story ui-state-default"><div class="draft"></div><span class="title_story">'+title+'</span>:<span class="status">Draft</span><br><span class="short_story">'+entry+'</span><ul class="options"><li><a id="view" href="/story/'+msg+'">view</a></li><li><a id="edit" href="/story/edit/'+msg+'">edit</a></li><li><a onclick="deleteUserStory(\''+msg+'\')" id="delete" href="javascript:void(0)">Delete</a></li></ul></li>');
			});
		}else{
			url = "/project/AjaxSaveStory";
			$.post(
			url,
			{ 'data': entry, 'project_id': <?=$project_sel?>, 'ci_csrf_token': '<?php echo $this->security->get_csrf_hash(); ?>' },
			function(msg){
				if(msg!='0')
					obj.replaceWith('<li id="work_'+msg+'" class="user_story ui-state-default"><span class="title_story">UserStory '+msg+'</span>:<br><span class="short_story">'+entry+'</span><ul class="options"><li><a id="view" href="/story/'+msg+'">view</a></li><li><a id="edit" href="/story/edit/'+msg+'">edit</a></li><li><a id="delete" onclick="deleteUserStory(\''+msg+'\')" href="javascript:void(0)">Delete</a></li></ul></li>');
			});
		}

		return true;
	}else return false;
}
	
$('#product_backlog').on('keypress','.new_story',function(event){
		if(event.which==13)	
			if(!saveUserStory($(this))){
					$(this).next().remove();
					$(this).remove();
				}
	});

	</script>
<?php $this->load->view('includes/footer5'); ?>