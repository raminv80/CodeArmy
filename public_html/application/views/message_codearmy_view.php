<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<style>
#inbox-content-area .message-wrapper{
	border-bottom:1px solid #666;
	min-height:150px;
	float:left;
	width:750px;
	color:white;
}
#inbox-content-area .message-avatar img{
	-moz-box-shadow: 3px 3px 4px #666;
	-webkit-box-shadow: 3px 3px 4px #666;
	box-shadow: 3px 3px 4px #666;
	/* For IE 8 */
	-ms-filter: "progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#666666')";
	/* For IE 5.5 - 7 */
	filter: progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#666666');
}
#inbox-content-area  .message-header h4{
	padding:10px;
}
#inbox-content-area  .message-header{
	border-bottom:1px solid #666;
	font-size:12pt;
}
#inbox-content-area .message-wrapper{

}
#inbox-content-area  .message-avatar {
	float: left;
	width: 60px;
	height: 60px;
	text-align: center;
	margin: 0 20px 20px 0;
}
#inbox-content-area .message-sender{
	font-weight:bold;
	color:#CCC;
	font-family:Verdana, Geneva, sans-serif;
	margin:0 20px 10px 0;
	width:370px;
	float:left;
}
#inbox-content-area .message-date{
	float:left;
	text-align:right;
	width:260px;
}
#inbox-content-area .message-content{
	float:left;
	width:650px;	
}
#inbox-content-area .message-content a{ text-decoration:underline; color:white}
#inbox-content-area .message-content a:hover{color:#09F}
</style>
<!--<img src="/public/images/codeArmy/messages/temp_msg.png" id="preview"/>-->
<div id="inbox-content-area"> 
  
  <!-- START - Inbox Block - Dev. by Reza  -->
  <div id="block-inbox-header">
    <div class="block-header">
      <h3>Messages</h3>
    </div>
  </div>
  <div id="inbox-area">
    <div id="inbox-top-bar">
      <div id="back"><a title="Goto previous page" href="/messages/inbox">Back</a></div>
      <div id="mark-unread"><a title="Mark all selected messages as unread" href="javascript: unread()">Mark as unread</a></div>
      <div id="star" class="<?=($messages[0]['category']=='important')?'important':'';?>"><a href="javascript: switch_importance()" title="Mark all selected messages as important" ><img src="/public/images/codeArmy/messages/star<?=($messages[0]['category']=='important')?'_hover':'';?>.png" /></a></div>
      <div id="bin"><a title="Move all selected messages into trash" href="javascript: to_trash()"><img src="/public/images/codeArmy/messages/bin.png" /></a></div>
      <!--
      <div id="msg-no"></div>
      <div id="arrow-left"><a title="Goto previous page" href="#"><img src="/public/images/codeArmy/messages/arrow-left.png" /></a></div>
      <div id="arrow-right"><a title="Goto next page" href="#"><img src="/public/images/codeArmy/messages/arrow-right.png" /></a></div>
      -->
    </div>
    <div class="message-header">
        <h4><?=$messages[0]['title']?></h4>
    </div>
	<?php foreach($messages as $message):
		$compose_to=$message['username'];
	?>
	<div class="message-wrapper">    	
        <div style="padding:10px">
            <div class="message-avatar" title="Click to see sender's profile"><a href="/profile/show/<?=$message['username']?>"><img src="<?=($message["avatar"] != NULL)?'/public/'.$message["avatar"]:'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $message['email'] ) ) )?>" width="60" height="60" /></a></div>
            <div class="message-sender"><a title="Click to see sender's profile" href="/profile/show/<?=$message['username']?>"><?=$message['username']?></a></div>
            <div class="message-date">
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
                    echo $time;
                ?>
            </div>
            <div class="message-content">
                <?=$message['content']?>
            </div>
        </div>
    </div>
    <?php endforeach;?>
  </div>
  <?php if($compose_to>''){echo form_open('messages/send'); ?>
    <div id="compose-main-area">
      <div id="compose-avatar"> </div>
      <div id="receiver-name">
        <label>To:</label>
        &nbsp;
        <?php if (isset($form_error)){ ?>
        <input id="msg-to" name="msg-to" value="<?=set_value('msg-to')?>" />
		<div id="errmsg3"><?=form_error("msg-to")?></div>
        <?php } else { ?>
        <input id="msg-to" name="msg-to" value="<?=$compose_to?>" <?=($compose_to>'')?'':'autofocus="autofocus"'?> />
        <?php } ?>
      </div>
      <div id="msg-subject">
        <label>Subject:</label>
        &nbsp;
        <?php if (isset($form_error)){ ?>
        <input id="msg-subj" name="msg-subj" value="<?=set_value('msg-subj')?>" />
		<div id="errmsg3"><?=form_error("msg-subj")?></div>
        <?php } else { ?>
        <input id="msg-subj" name="msg-subj" <?=($compose_to=='')?'':'autofocus="autofocus"'?> />
        <?php } ?>
      </div>
      <div id="msg-text">
        <label>Message:</label>
        <?php if (isset($form_error)){ ?>
        <textarea rows="7" id="msg-text" name="msg-text"><?=set_value('msg-text')?></textarea>
		<div id="errmsg3"><?=form_error("msg-text")?></div>
        <?php } else { ?>
        <textarea rows="7" id="msg-text" name="msg-text"></textarea>
        <?php } ?>
      </div>
    </div>
    <input type="hidden" name="parent_id" value="<?=$message['message_id']?>" />
    <input type="submit" value="Send" class="lnkimg">
    </form>
    <?php }?>
</div>
<script type="text/javascript">
	$(function(){
		initEvents();
		$(".fancybox").fancybox({type : 'iframe'});
		$('#inbox-content-area [title]').tipsy({gravity:'s', opacity:0.95});
	});
	function initEvents(){
	}
	function to_trash(){
		var id = <?=$message_selected?>;
		delete_message(id);
	}
	function delete_message(id){
		$.ajax({
			type: 'POST',
			dataType: "json",
			url: "/messages/Ajax_trash",
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'message_id': id},
			success:function(msg){
				window.location='/messages/inbox';
			}
		});
	}
	
	function switch_importance(){
		var url = "/messages/Ajax_flag_important";
		var action = 'flag_important';
		if($('#star').hasClass('important')){
			url = "/messages/Ajax_flag_unimportant";
			action = "flag_unimportant";
		}
		var id = <?=$message_selected?>;
		$.ajax({
			type: 'POST',
			dataType: "json",
			url: url,
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'message_id': id},
			success:function(msg){
				$.each(msg,function(key,value){
						if(action == 'flag_important'){
							$('#star').addClass('important').find('img').attr('src','/public/images/codeArmy/messages/star_hover.png');
						}else{
							$('#star').removeClass('important').find('img').attr('src','/public/images/codeArmy/messages/star.png');
						}
					});
			}
		});
	}
	
	function unread(){
		var id = <?=$message_selected?>;
		$.ajax({
			type: 'POST',
			dataType: "json",
			url: "/messages/Ajax_flag_unread",
			data:{'csrf_workpad': getCookie('csrf_workpad'), 'message_id': id},
			success:function(msg){
				$('#mark-unread').html('Mark as unread').css('color','#666');
			}
		});
	}
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>