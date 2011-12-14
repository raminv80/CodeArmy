<?php $this->load->view('includes/header'); ?>
<div id="wrapper">
	<div class="contents">
    	<span id="plan">Plan</span><br /><span id="board">Board</span>
 		<div id="plan_holder" class="scrum_holder">
        	<h1>Scrum Planner</h1>
            <div id="sprint_planner">
                <div class="scrum_column">
                    <h2>Ice Box</h2>
                    <ul id="product_backlog" class="story_list">
                        <li class="empty_space">
                            <span style="margin-left: 67px;">+ Add User Story</span>
                        </li>
                    </ul>
                </div>
                <div class="scrum_column">
                    <h2>Sprint 1</h2>
                    <ul id="scrum1" class="story_list"></ul>
                </div>
                <div class="add_sprint"></div>
            </div>
		</div>
        <div id="board_holder" class="scrum_holder">
        	<h1>Scrum Board</h1>
            <div id="scrum_board">
                <div class="scrum_column">
                    <h2>Product Backlog</h2>
                    <ul id="product_backlog_sprint_1" class="story_list"></ul>
                </div>
                <div class="scrum_column">
                    <h2>In Progress</h2>
                    <ul id="scrum1_progress" class="story_list"></ul>
                </div>
                <div class="scrum_column">
                    <h2>Done</h2>
                    <ul id="scrum1_done" class="story_list"></ul>
                </div>
                <div class="scrum_column">
                    <h2>Verified</h2>
                    <ul id="scrum1_verify" class="story_list"></ul>
                </div>
                <div class="scrum_column">
                    <h2>Signed off</h2>
                    <ul id="scrum1_signoff" class="story_list"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
	#board_holder{ display:none;}
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
	}
	
	.story_list li{
		list-style:none;
		margin: 0 5px;
		cursor:move;
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
	
	.ui-state-highlight { height: 1.5em; line-height: 1.2em; }
</style>
<script type="text/javascript">
$(init);
function init(){
	$('#product_backlog').sortable({cancel: '.empty_space', connectWith: '#scrum1'});
	$('#scrum1').sortable({connectWith:'#product_backlog'});
	$('#plan').click(function(){
		$('#plan_holder').slideToggle();
		$('#board_holder').slideToggle();
	});
	$('#board').click(function(){
		$('#board_holder').slideToggle();
		$('#plan_holder').slideToggle();
	});
}
var num_sprints = 1;
$('.add_sprint').click(function(){
		num_sprints++;
		obj = $('#sprint_planner');
		obj.width(obj.width()+460);
		$(this).before('<div class="scrum_column"><h2>Sprint '+num_sprints+'</h2><ul id="scrum'+num_sprints+'" class="story_list"></ul></div>');
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
	});

$('#product_backlog').on('click','.empty_space',function(){
		$(this).after('<li class="new_story"><input type="text"></li>');
		$('input').focus();
	});
	
$('#product_backlog').on('click','.user_story',function(){
		entry = $(this).html();
		$(this).replaceWith('<li class="new_story"><input type="text" value="'+entry+'"></li>');
		$('input').focus();
	});
	
function saveUserStory(obj){
	entry = $.trim($('input', obj).val());
	if(entry!=''){
		<!--TODO: ajax method to save the entry-->
		obj.replaceWith('<li class="user_story ui-state-default">'+entry+'</li>');
		$('.user_story').sortable({
			'containment':'#product_backlog',
			'revert':true,
			'snap':'.empty_space',
			'axis':'y',
			'snapMode':'outer',
			'stack': '#product_backlog',
		});
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
<?php $this->load->view('includes/footer'); ?>