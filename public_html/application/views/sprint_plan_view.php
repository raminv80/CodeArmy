<?php $this->load->view('includes/header4'); ?>
<script type="text/javascript">
	//var works='<=str_replace("'","\'",json_encode($works))?>';
	var works = new Array();
	<?php
		foreach($works as $sprint=>$work_list):
			echo "d=new Object();\n";
			echo "d.sprint_id='".$sprint."';\n";
			echo "d.sprint_from='".$work_list['from']."';\n";
			echo "d.sprint_to='".$work_list['to']."';\n";
			echo "d.work_list= new Array();\n";
			echo "works.push(d);\n";
			foreach($work_list['list'] as $work):
				echo "d = new Object();\n";
				echo "d.id='".$work['work_id']."';\n";
				echo "d.title='".$work['title']."';\n";
				echo "d.status='".$work['status']."';\n";
				echo "d.description='".substr(str_replace("'","\'",str_replace(array("\n","\t"),'',strip_tags($work['description']))),0,252)."';\n";
				echo "works[works.length-1].work_list.push(d);\n";
			endforeach;
		endforeach;
	?>
	//works = jQuery.parseJSON(works);
</script>
<div id="wrapper" style="padding:60px 10px 200px 10px; margin-top:10px;">
  <div class="contents"> 
  	<a href="javascript: save_list();">Save</a>
    <div id="plan_holder" class="scrum_holder">
      <div id="sprint_planner">
        <div class="scrum_column">
          <h2>Ice Box</h2>
          <ul id="product_backlog" class="story_list">
            <li class="empty_space"> <span style="margin-left: 67px;">+ Add User Story</span> </li>
          </ul>
        </div>
        <div class="scrum_column">
          <h2 class="sprint-title">Sprint 1</h2>
          <ul class="timeline">
          	<li><b>Start:</b> <input name="startSprint1" class="start" /></li>
            <li><b>End:</b> <input name="endSprint1" class="end" /></li>
          </ul>
          <a href="javascript: remove_sprint('+num_sprints+')">Remove</a>
          <div style=" clear:both"></div>
          <ul id="scrum1" class="story_list">
          </ul>
        </div>
        <div class="add_sprint"></div>
      </div>
    </div>  
  </div>
</div>
<div id="dialog-confirm" title="Remove the Sprint?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>'Selected Sprint will be deleted and all user stories under it will move to Icebox. Are you sure?'</p>
</div>
<input type="hidden" id="buffer" />
<style type="text/css">
	.locked{background:#F60;}
	ul.options{display:none;}
	.sprint-title{width:130px; float:left;}
	.timeline {
		list-style: none;
		float: left;
		margin: 10px 0;
		padding: 0;
		width: 139px;
		font-size: 13px;
		color: white;
		text-align: right;
	}
	
	.start, .end { width: 70px; border:none;}
	.scrum_holder{
		width:1140;
		overflow-x:scroll;
	}
	#sprint_planner{
		width: 920px;
	}
	
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
	.scrum_column{
		float:left;
		width:300px;
		min-height:400px;
		border:1px #999 solid;
		-moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		border-radius: 10px;
		background-image: linear-gradient(bottom, rgba(185,217,250,0.2) 0%, rgba(221,255,221,0.2) 61%, rgba(255,255,255,0.2) 81%);
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
		);
	}
	
	.story_list{
		width: 300px;
		margin-left:0;
		min-height:400px;
		-webkit-padding-start: 0;
	}
	
	.story_list li{
		list-style:none;
		margin: 0 5px;
	}
	#sprint_planner .story_list li{
		cursor:move;
	}
	
	h1, h2, h3, h4, h5, h6 {
	color: white;
	font-weight: normal;
	text-transform: uppercase;
	}
	h2 {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-weight: bold;
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
	}
	
	h2{
		font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
		font-weight:bold;
		margin: 10px;
		font-size:1.5em;
	}
	
	.empty_space, .add_sprint{
		-moz-border-radius: 5px;
	    -webkit-border-radius: 5px;
	    border-radius: 5px;
		border:#CCC thin dashed;
		
		margin:2px;
	}
	
	.empty_space:hover{
		background: #ccc;
	}
	
	.user_story{
		background:yellow;
		padding:10px;
		color:black;
		border: 1px solid black;
		-moz-border-radius: 5px;
	    -webkit-border-radius: 5px;
	    border-radius: 5px;
	}
	
	.my-work{
		background-color:green;	
	}
	
	.ui-state-highlight { height: 1.5em; line-height: 1.2em; }
</style>
<script type="text/javascript">
$(init);
function init(){
	$('#product_backlog').sortable({cancel: '.empty_space', connectWith: '#scrum1'});
	$('#scrum1').sortable({connectWith:'#product_backlog'});
	$('input[name="startSprint1"]').datepicker({ dateFormat: 'yy-mm-dd' });
	$('input[name="endSprint1"]').datepicker({ dateFormat: 'yy-mm-dd' });
	populate(works);
	lockSprint(<?=$curSprint?>);
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
		$('.options',this).slideDown();
	});
$('.story_list').on('mouseleave','.user_story',function(){
		$('.options',this).slideUp();
	});
	
function save_list(){
	jQuery.data(document.body, 'save_request', 0);
	//TODO:will save sprints, schadules and order of user stories into datbase.
	$('.story_list').each(function(){
		if($(this).data('sprint_id')!==undefined){
			//save the order into an existing sprint id
			//console.log('sprint id '+$(this).data('sprint_id')+' includes '+JSON.stringify($(this).sortable('toArray')));
			sprint_id = $(this).data('sprint_id');
		}
		if($(this).data('sprint_id')===undefined){
			//sprint is new and we don't have a sprint id
			//console.log('New sprint. includes '+$(this).sortable('toArray'));
			sprint_id = 'new';
		}
		//update priority of all user stories that belong to sprint id
		date_from = $('.start',$(this).parent()).val();
		date_to = $('.end',$(this).parent()).val();
		console.log('process sprint '+sprint_id);
		console.log('sprint is from '+date_from+' to '+date_to);
		data = JSON.stringify($(this).sortable('toArray'));
		jQuery.data(document.body, 'save_request', jQuery.data(document.body, 'save_request')+1);
		$.post(
		'/project/AjaxSavePriority',
		{ 'data': data, 'date_from': date_from, 'date_to': date_to, 'sprint_id': sprint_id, 'project_id': <?=$project_sel?>, 'ci_csrf_token': '<?php echo $this->security->get_csrf_hash(); ?>' },
		function(msg){
			console.log('process done.');
			jQuery.data(document.body, 'save_request', jQuery.data(document.body, 'save_request')-1);
			if(msg!='0'){
				//TODO
				if($(this).data('sprint_id')===undefined){
					$(this).data('sprint_id',msg);
				}
				console.log('sprint '+msg+' successfuly saved.');
			}
			if(jQuery.data(document.body, 'save_request')==0)alert('Your project is saved successfully.');
		});
	});
}

function deleteUserStory(work_id){
	$.post(
		"/project/AjaxDeleteStory",
		{ 'work_id': work_id, 'project_id': <?=$project_sel?>, 'ci_csrf_token': '<?php echo $this->security->get_csrf_hash(); ?>' },
		function(msg){
			if(msg!='0'){
				$('#work_'+msg).hide(1000,function(){$(this).remove();});
			}else{
				alert('Error: Unable to remove User Story '+msg);
			}
		}
	);
}

function populate(works){
	var first_sprint=true;
	for(sprint in works){
		work_list = works[sprint].work_list;
		sprint_id = works[sprint].sprint_id;
		sprint_from = works[sprint].sprint_from;
		sprint_to = works[sprint].sprint_to;
		if(sprint_id!=0 && first_sprint){//populate first sprint
			first_sprint = false;
			cur_sprint = $('#scrum1');
			cur_sprint.data('sprint_id',sprint_id);
			$('.start',cur_sprint.parent()).val(sprint_from);
			$('.end',cur_sprint.parent()).val(sprint_to);
			for(i=0;i<work_list.length;i++){
				var data=work_list[i];
				entry = data.description;
				cur_sprint.append('<li id="work_'+data.id+'" class="user_story ui-state-default"><span class="title_story">'+data.title+'</span>:<span class="status">'+data.status+'</span><br><span class="short_story">'+entry+'</span><ul class="options"><li><a href="/story/'+data.id+'">view</a><li><a href="/story/edit/'+data.id+'">edit</a></li></li><li><a onclick="deleteUserStory(\''+data.id+'\')" href="javascript:void(0)">Delete</a></li></ul></li>');
			}
		}else if(sprint_id!=0 && !first_sprint){//add a new sprint
			$('.add_sprint').click();
			cur_sprint = $('#scrum'+num_sprints);
			cur_sprint.data('sprint_id', sprint_id);
			$('.start',cur_sprint.parent()).val(sprint_from);
			$('.end',cur_sprint.parent()).val(sprint_to);
			for(i=0;i<work_list.length;i++){
				var data=work_list[i];
				entry = data.description;
				cur_sprint.append('<li id="work_'+data.id+'" class="user_story ui-state-default"><span class="title_story">'+data.title+'</span>:<span class="status">'+data.status+'</span><br><span class="short_story">'+entry+'</span><ul class="options"><li><a href="/story/'+data.id+'">view</a></li><li><a href="/story/edit/'+data.id+'">edit</a></li><li><a onclick="deleteUserStory(\''+data.id+'\')" href="javascript:void(0)">Delete</a></li></ul></li>');
			}
		}
		if(sprint_id==0){//ice box
			cur_sprint = $('#product_backlog');
			cur_sprint.data('sprint_id','0');
			for(i=0;i<work_list.length;i++){
				var data=work_list[i];
				entry = data.description;
				cur_sprint.append('<li id="work_'+data.id+'" class="user_story ui-state-default"><span class="title_story">'+data.title+'</span>:<span class="status">'+data.status+'</span><br><span class="short_story">'+entry+'</span><ul class="options"><li><a href="/story/'+data.id+'">view</a></li><li><a href="/story/edit/'+data.id+'">edit</a></li><li><a onclick="deleteUserStory(\''+data.id+'\')" href="javascript:void(0)">Delete</a></li></ul></li>');
			}
		}
	}
	
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
		$(this).before('<div class="scrum_column"><h2 class="sprint-title">Sprint '+num_sprints+'</h2><ul class="timeline"><li><b>Start:</b> <input name="startSprint'+num_sprints+'" class="start" /></li><li><b>End:</b> <input name="endSprint'+num_sprints+'" class="end" /></li></ul><a href="javascript: remove_sprint('+num_sprints+')">Remove</a><div style=" clear:both"></div><ul id="scrum'+num_sprints+'" class="story_list"></ul></div>');
		$('input[name="startSprint'+num_sprints+'"]').datepicker({ dateFormat: 'yy-mm-dd' });
		$('input[name="endSprint'+num_sprints+'"]').datepicker({ dateFormat: 'yy-mm-dd' });
		//connect sprints with eachothers
		for(j=num_sprints;j>0;j--){
			buffer = '#product_backlog';
			for(i=1;i<=num_sprints;i++)if(j!=i)buffer += (',#scrum'+i);
			if(j==num_sprints)$('#scrum'+j).sortable({connectWith: buffer});
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
					obj.replaceWith('<li id="work_'+msg+'" class="user_story ui-state-default"><span class="title_story">'+title+'</span>:<span class="status">Draft</span><br><span class="short_story">'+entry+'</span><ul class="options"><li><a href="/story/'+msg+'">view</a></li><li><a href="/story/edit/'+msg+'">edit</a></li><li><a onclick="deleteUserStory(\''+msg+'\')" href="javascript:void(0)">Delete</a></li></ul></li>');
				/*$('#product_backlog').sortable({
					'containment':'#product_backlog',
					'revert':true,
					'snap':'.empty_space',
					'axis':'y',
					'snapMode':'outer',
					'stack': '#product_backlog',
				});*/
			});
		}else{
			url = "/project/AjaxSaveStory";
			$.post(
			url,
			{ 'data': entry, 'project_id': <?=$project_sel?>, 'ci_csrf_token': '<?php echo $this->security->get_csrf_hash(); ?>' },
			function(msg){
				if(msg!='0')
					obj.replaceWith('<li id="work_'+msg+'" class="user_story ui-state-default"><span class="title_story">UserStory '+msg+'</span>:<br><span class="short_story">'+entry+'</span><ul class="options"><li><a href="/story/'+msg+'">view</a></li><li><a href="/story/edit/'+msg+'">edit</a></li><li><a onclick="deleteUserStory(\''+msg+'\')" href="javascript:void(0)">Delete</a></li></ul></li>');
				/*$('#product_backlog').sortable({
					'containment':'#product_backlog',
					'revert':true,
					'snap':'.empty_space',
					'axis':'y',
					'snapMode':'outer',
					'stack': '#product_backlog',
				});*/
			});
		}

		return true;
	}else return false;
}
	
$('#product_backlog').on('keypress','.new_story',event,function(){
		if(event.which==13)	
			if(!saveUserStory($(this))){
					$(this).next().remove();
					$(this).remove();
				}
	});
</script>
<?php $this->load->view('includes/footer4'); ?>
