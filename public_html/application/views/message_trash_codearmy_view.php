<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<style>
.star a{width:18px;height:17px; background:url(/public/images/codeArmy/messages/star.png) no-repeat;display:block;}
.star a.important{background:url(/public/images/codeArmy/messages/star_hover.png) no-repeat;}
.unread{color:#FFC; font-weight:bold; text-decoration:underline; text-transform:uppercase;}
.summary{cursor:pointer}
</style>

<div class="container-fluid">
	<div class="row-fluid">
		
		<!-- Page start -->
		<div id="inbox-content-area" class="span10 offset1"> 

		  <!-- START - Inbox Block - Dev. by Reza  -->
		  <div id="block-inbox-header">
		    <div class="block-header">
		      <h3>Messages</h3>
		    </div>
		  </div>
		  <div id="inbox-area">
		    <div id="inbox-top-bar">
		      <div id="back"><a title="Previous page" href="/messages/important/<?=($current>0)?$current-1:$current?>">Back</a></div>
		      <div id="mark-unread"><a title="Mark all selected messages as unread" href="javascript: unread_all()">Mark as unread</a></div>
		      <div id="star"><a title="Recover all selected messages into inbox" href="javascript: recover_all()"><img src="/public/images/codeArmy/messages/star.png" /></a></div>
		      <div id="bin"><a title="Delete all selected messages from trash" href="javascript: all_to_trash()"><img src="/public/images/codeArmy/messages/bin.png" /></a></div>
		      <div id="msg-no"><?=$current*$limit+1?> to <?=min($limit*($current+1), $total)?> of <?=$total?></div>
		      <div id="arrow-left"><a title="Go to previous page" href="/messages/important/<?=($current>0)?$current-1:$current?>"><img src="/public/images/codeArmy/messages/arrow-left.png" /></a></div>
		      <div id="arrow-right"><a title="Go to next page" href="/messages/important/<?=(($current+1) < ceil($total/$limit))?$current+1:$current?>"><img src="/public/images/codeArmy/messages/arrow-right.png" /></a></div>
		    </div>
		    <div class="inbox-rows">
		      <div class="title-row">
		        <div id="select-all">Select <a title="Select all messages" href="javascript: selectAll()">all</a>/<a title="Deselect all messages" href="javascript: selectNone()">none</a></div>
		        <div id="all-messages">All messages</div>
		      </div>

		      <?php foreach($messages as $i=>$message):?>
		      <div class="msg-row <?=(($i%2)==0)?'even':'odd'?> <?=$message['status']?>" id="message_<?=$message['message_id']?>">
		        <input type="checkbox" />
		        <div class="summary">
		        	<a href="/messages/read/<?=$message['message_id']?>"></a>
		            <div class="inbox-user-avatar"><img src="<?=($message["avatar"] != NULL)?'/public/'.$message["avatar"]:'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $message['email'] ) ) )?>" width="44" height="45" /></div>
		            <div class="sender-name"><?=$message['from_username']?></div>
		            <div class="mail-subject"><?=$message['title']?></div>
		        <?php
					$diff = abs(strtotime($message['created_at'])-time());
					if($diff>(24*60*60)){
						$time = date('Y-M-d',strtotime($message['created_at']));
					}elseif($diff>=60*60){
						$time = round($diff/(60*60)).' hours ago';
					}elseif($diff>=60){
						$time = round($diff/60).' mins ago';
					}else{
						$time = 'now';
					}
				?>
		        	<div class="mail-time"><?=$time?></div>
		        </div>
		        <div class="star"><a href="javascript: void(0)" <?php if($message['category']=='important'){?>class="important"<?php }?>></a></div>
		        <div class="bin"><a href="javascript: void(0)"><img src="/public/images/codeArmy/messages/bin.png" /></a></div>
		      </div>
		      <?php endforeach;?>
		    </div>
		    <div id="inbox-top-bar">
		      <div id="back"><a title="Previous page" href="/messages/important/<?=($current>0)?$current-1:$current?>">Back</a></div>
		      <div id="mark-unread"><a title="Mark all selected messages as unread" href="javascript: unread_all()">Mark as unread</a></div>
		      <div id="star"><a title="Recover all selected messages" href="javascript: set_importance()"><img src="/public/images/codeArmy/messages/star.png" /></a></div>
		      <div id="bin"><a title="Delete all selected messages from trash" href="javascript: all_to_trash()"><img src="/public/images/codeArmy/messages/bin.png" /></a></div>
		      <div id="msg-no"><?=$current*$limit+1?> to <?=min($limit*($current+1), $total)?> of <?=$total?></div>
		      <div id="arrow-left"><a title="Goto previous page" href="/messages/important/<?=($current>0)?$current-1:$current?>"><img src="/public/images/codeArmy/messages/arrow-left.png" /></a></div>
		      <div id="arrow-right"><a title="Goto next page" href="/messages/important/<?=(($current+1) < round($total/$limit))?$current+1:$current?>"><img src="/public/images/codeArmy/messages/arrow-right.png" /></a></div>
		    </div>
		  </div>
		</div>
		<!-- Page ends -->
		
	</div>
</div>

<script type="text/javascript">
	$(function(){
		initEvents();
		$('#inbox-content-area [title]').tipsy({gravity:'s', opacity:0.95});
	});
	
	function initEvents(){
		$('.star a').click(recover);
		$('.bin a').click(to_trash);
		$('.summary').click(function(){window.location=$(this).find("a").attr("href"); return false;});
	}
	
	function unread_all(){
		var list =new Array();
		$('input[type=checkbox]:checked').each(function(){
				list.push($(this).parent().attr('id').split('_')[1]);
			});
		list = list.join(',');
		$.ajax({
			type: 'POST',
			dataType: "json",
			url: "/messages/Ajax_flag_unread",
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'message_id': list},
			success:function(msg){
				$.each(msg,function(key,value){
						$('#message_'+value).addClass('unread').removeClass('read');
					});
			}
		});
	}
	
	function to_trash(){
		var id = $(this).parent().parent().attr('id').split('_')[1];
		delete_message(id);
	}
	
	function all_to_trash(){
		var list =new Array();
		$('input[type=checkbox]:checked').each(function(){
				list.push($(this).parent().attr('id').split('_')[1]);
			});
		list = list.join(',');
		delete_message(list);
	}
	
	function delete_message(list){
		$.ajax({
			type: 'POST',
			dataType: "json",
			url: "/messages/Ajax_delete",
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'message_id': list},
			success:function(msg){
				$.each(msg,function(key,value){
						$('#message_'+value).slideUp(function(){$(this).remove()});
					});
			}
		});
	}
	
	function recover(){
		var id = $(this).parent().parent().attr('id').split('_')[1];
		do_recover(id);
	}

	function recover_all(){
		var list =new Array();
		$('input[type=checkbox]:checked').each(function(){
				list.push($(this).parent().attr('id').split('_')[1]);
			});
		list = list.join(',');
		do_recover(list);
	}
	
	function do_recover(list){
		$.ajax({
			type: 'POST',
			dataType: "json",
			url: "/messages/Ajax_recover",
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'message_id': list},
			success:function(msg){
				$.each(msg,function(key,value){
						$('#message_'+value).slideUp(function(){$(this).remove()});
					});
			}
		});
	}
	
	function selectAll(){
		$('input[type=checkbox]').attr('checked','checked');
	}
	
	function selectNone(){
		$('input[type=checkbox]').removeAttr('checked');
	}
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
