<?php $this->load->view('includes/header4'); ?>
<?php
			$open = 0; $in_progress = 0; $done = 0; $verify=0; $sign_off=0;
			foreach($point_state as $data):
				switch(lower($data['status'])):
					case 'open': $open+=$data['points'];
					break;
					case 'in progress': $in_progress+=$data['points'];
					break;
					case 'done': $done+=$data['points'];
					break;
					case 'redo': $in_progress+=$data['points'];
					break;
					case 'verify': $verify+=$data['points'];
					break;
					case 'signoff': $sign_off+=$data['points'];
					break;
					case 'reject': $open+=$data['points'];
					break;
				endswitch;
			endforeach;
?>
<div id="wrapper" style="padding:100px 10px 200px 10px; ">

  <div class="contents"> 
    <div id="plan_holder" class="scrum_holder">
      <div id="sprint_planner">
        <div class="scrum_column">
          <h2>Ice Box</h2>
          <ul id="product_backlog" class="story_list">
            <li class="empty_space"> <span style="margin-left: 67px;">+ Add User Story</span> </li>
          </ul>
        </div>
        <div class="scrum_column">
          <h2>Sprint 1</h2>
          <ul id="scrum1" class="story_list">
          </ul>
        </div>
        <div class="add_sprint"></div>
      </div>
    </div>
    <div id="board_holder" class="scrum_holder">
      <div id="scrum_board">
        <div class="scrum_column"><div class="header-scrum">
          <h2>Backlog (<?=$open?>pt)</h2></div>
          <ul id="product_backlog_sprint_1" class="story_list">
          	<?php if(isset($works_state))foreach($works_state['open'] as $work):?>
          	<li class="user_story ui-state-default"><span class="title_story"><?=$work['title']?></span> <br><?= (($i=strpos($work['description'],'</p>'))>0)? strip_tags(substr($work['description'],0,$i)) : strip_tags($work['description']);?>
            	<ul class="options">
                	<li><a href="/story/<?=$work['work_id']?>">View Details</a></li>
                </ul>
            </li>
            <?php endforeach;?>
          </ul>
        </div>
        
        <div class="scrum_column">
          <div class="header-scrum"><h2>In Progress (<?=$in_progress?>pt)</h2></div>
          <ul id="scrum1_progress" class="story_list">
          <?php if(isset($works_state))foreach($works_state['progress'] as $work):?>
          	<li class="user_story ui-state-default <?php if($user_id==$work['champion_id']){?>my-work<?php }?>"><span class="title_story"><?=$work['title']?></span><br><?= (($i=strpos($work['description'],'</p>'))>0)? strip_tags(substr($work['description'],0,$i)) : strip_tags($work['description']);?>
            	<ul class="options">
                	<li><a href="/story/<?=$work['work_id']?>">View Details</a></li>
                	<li><a href="/user/<?=$work['champion_id']?>">Champion: <?=$work['champion']?></a></li>
                    <?php if($user_id==$work['champion_id']){?>
                        <li>
                        	<?php echo form_open('story/submission');?>
                                <input type="hidden" name="id" value="<?php echo $work['work_id']; ?>" />
                                <input type="hidden" name="csrf" value="<?php echo md5('storyDone'); ?>" />
                                <!--<input type="submit" name="submit" value="Job Done!" />-->
                                <div class="proceed">
                                    <a href="javascript: void(0)" class="submit dialog_step3">Job Done!</a>
                                </div>
                            <?php echo form_close(); ?>
                        </li>
                    <?php }?>
                    <?php if($project_owner){?>
	                    <li><a href="/story/reopen/<?=$work['work_id']?>" onclick="return confirm('Do you really want to revoke the work from current workhorse and set the story to open for bidding again?')">Revoke!</a></li>
                    <?php }?>
                </ul>
            </li>
            <?php endforeach;?>
          </ul>
        </div>
        <div class="scrum_column">
         <div class="header-scrum"> <h2>Done (<?=$done?>pt)</h2></div>
          <ul id="scrum1_done" class="story_list">
          <?php if(isset($works_state))foreach($works_state['done'] as $work):?>
          	<li class="user_story ui-state-default <?php if($user_id==$work['champion_id']){?>my-work<?php }?>"><span class="title_story"><?=$work['title']?></span><br><?= (($i=strpos($work['description'],'</p>'))>0)? strip_tags(substr($work['description'],0,$i)) : strip_tags($work['description']);?>
            	<ul class="options">
                	<li><a href="/story/<?=$work['work_id']?>">View Details</a></li>
                    <li><a href="/user/<?=$work['champion_id']?>">Champion: <?=$work['champion']?></a></li>
                    <?php if($scrum_master){?>
                    <li><a href="/story/verify/<?=$work['work_id']?>">Verify</a></li>
                    <li><a href="/story/redo/<?=$work['work_id']?>">Needs More Work</a></li>
                    <?php }?>
                </ul>
            </li>
            <?php endforeach;?>
          </ul>
        </div>
        <div class="scrum_column">
          <div class="header-scrum"><h2>Verified (<?=$verify?>pt)</h2></div>
          <ul id="scrum1_verify" class="story_list">
          <?php if(isset($works_state))foreach($works_state['verify'] as $work):?>
          	<li class="user_story ui-state-default <?php if($user_id==$work['champion_id']){?>my-work<?php }?>"><span class="title_story"><?=$work['title']?></span> <br><?= (($i=strpos($work['description'],'</p>'))>0)? strip_tags(substr($work['description'],0,$i)) : strip_tags($work['description']);?>
            	<ul class="options">
                	<li><a href="/story/<?=$work['work_id']?>">View Details</a></li>
                    <li><a href="/user/<?=$work['champion_id']?>">Champion: <?=$work['champion']?></a></li>
                    <?php if($project_owner){?>
                    <li><a href="/story/signoff/<?=$work['work_id']?>">Signoff</a></li>
                    <li><a href="/story/redo/<?=$work['work_id']?>">Needs More Work</a></li>
                    <li><a href="/story/reject/<?=$work['work_id']?>">Reject!</a></li>
                    <?php }?>
                </ul>
            </li>
            <?php endforeach;?>
          </ul>
        </div>
        <div class="scrum_column">
          <div class="header-scrum"><h2>Signed off (<?=$sign_off?>pt)</h2></div>
          <ul id="scrum1_signoff" class="story_list">
          <?php if(isset($works_state))foreach($works_state['signoff'] as $work):?>
          	<li class="user_story ui-state-default <?php if($user_id==$work['champion_id']){?>my-work<?php }?>"><span class="title_story"><?=$work['title']?></span><br><?= (($i=strpos($work['description'],'</p>'))>0)? strip_tags(substr($work['description'],0,$i)) : strip_tags($work['description']);?>
            	<ul class="options">
                	<li><a href="/story/<?=$work['work_id']?>">View Details</a></li>
                    <li><a href="/user/<?=$work['champion_id']?>">Champion: <?=$work['champion']?></a></li>
                </ul>
            </li>
            <?php endforeach;?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
	ul.options{display:none;}
	#plan_holder{ display:none;}
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
	.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited {
	color:#FFCC00 !important; font-size:1.3em;
	text-decoration: none;
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
	}
	
	.story_list{
		width: 300px;
		margin-left:0;
		min-height:400px;
		-webkit-padding-start: 0;
	}
	
	.story_list li{
		list-style:none;
		margin: 10px; font-size:.8em;line-height: 18px;
	}
	#sprint_planner .story_list li{
		cursor:move;
	}
	
	h1, h2, h3, h4, h5, h6 {
	color: white;
	font-weight: normal;
	text-transform: uppercase;
	}
	
	#wrapper .contents h1 {
	text-shadow: 0 1px 10px white;
	font-size: 32px;
	font-weight: lighter;
	}
	.story_list li.empty_space{
		cursor:pointer;
	}
	ul.options {padding-top:10px;}
	ul.options li {margin: 0 0 0 -37px;}
	h2{
		font-family:DinRegular;
		text-align: center;
		margin: 5px 0 0 10px;
font-size: 1.5em;
text-shadow: 0 1px 10px white;

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
		
		color: white;
		padding:10px; 
		-moz-border-radius: 5px;
	    -webkit-border-radius: 5px;
	    border-radius: 5px;font-family: 'DINLightAlternate';
		font-size: 1.0em;
		-webkit-box-shadow: 1px 2px 3px rgba(26, 50, 50, 0.36);
		-moz-box-shadow: 1px 2px 3px rgba(26, 50, 50, 0.36);
		box-shadow: inset 1px 2px 3px rgba(26, 50, 50, 0.36);
		bordeR: 0;
		background: #525B62;
		border: 0px;
		border-right: 1px solid #797979;
		border-bottom: 1px solid #797979;
		margin-bottom: 5px;
		overflow: hidden;
		
	}
	
	.my-work{
	
		background-color:green;	
	}
	.header-scrum {display: block;padding: 1px;height: 42px;background: url(/public/images/qualif-table-header.png);display: block;}
	.ui-state-highlight { height: 1.5em; line-height: 1.2em; }
	.title_story {text-transform: uppercase;
font-size: 1.5em;color: #282828;}
</style>
<script type="text/javascript">
$(init);
function init(){
	var max_height = 0;
	//find the highest height
	$('.story_list').each(function(){if($(this).height()>max_height)max_height = $(this).height();})
	//adjust their height to max
	$('.story_list').css('min-height',max_height);
}
var num_sprints = 1; num_edits=0;
$('.user_story').hover(
	function(){
		//mouse enters story area
		$('.options',this).slideDown();
	},
	function(){
		//mouse leaves story area
		$('.options',this).slideUp();
	}
);
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
		num_edits++;
		$(this).after('<li class="new_story"><input id="edit'+num_edits+'" type="text"></li>');
		$('input#edit'+num_edits).focus();
	});
	
$('#product_backlog').on('click','.user_story',function(){
		entry = $(this).html();
		num_edits++;
		$(this).replaceWith('<li class="new_story"><input id="edit'+num_edits+'" type="text" value="'+entry+'"></li>');
		$('input#edit'+num_edits).focus();
	});

$('#product_backlog').on('click','.new_story',function(){$('input',this).focus();});
	
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
<?php $this->load->view('includes/footer4'); ?>
