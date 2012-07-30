<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<style>
#inbox-rows{ height:auto}
</style>
<div id="inbox-content-area"> 
  
  <!-- START - Inbox Block - Dev. by Reza  -->
  <div id="block-inbox-header">
    <div class="block-header">
      <h3>Messages</h3>
    </div>
  </div>
  <div id="inbox-area">
    <div id="inbox-top-bar">
      <div id="back"><a href="#">Back</a></div>
      <div id="mark-unread"><a href="#">Mark as unread</a></div>
      <div id="star"><a href="#"><img src="/public/images/codeArmy/messages/star.png" /></a></div>
      <div id="bin"><a href="#"><img src="/public/images/codeArmy/messages/bin.png" /></a></div>
      <div id="msg-no"><?=$current+1?> to <?=min($limit*($current+1), $total)?> of <?=$total?></div>
      <div id="arrow-left"><a href="#"><img src="/public/images/codeArmy/messages/arrow-left.png" /></a></div>
      <div id="arrow-right"><a href="#"><img src="/public/images/codeArmy/messages/arrow-right.png" /></a></div>
    </div>
    <div id="inbox-rows">
      <div class="title-row">
        <div id="select-all"><a href="#">Select all</a></div>
        <div id="all-messages">All messages</div>
      </div>
      
      <?php foreach($messages as $i=>$message):?>
      <div class="msg-row <?=(($i%2)==0)?'even':'odd'?>" id="message_<?=$message['message_id']?>">
        <input type="checkbox" />
        <div id="inbox-user-avatar"><a href="#"><img src="/public/images/codeArmy/messages/default-avatar.png" /></a></div>
        <div id="sender-name"><a href="#"><?=$message['from_username']?></a></div>
        <div id="mail-subject"><a href="#"><?=$message['title']?></a></div>
        <div id="mail-time">3 hours ago</div>
        <div id="star"><a href="#"><img src="/public/images/codeArmy/messages/star.png" /></a></div>
        <div id="bin"><a href="#"><img src="/public/images/codeArmy/messages/bin.png" /></a></div>
      </div>
      <?php endforeach;?>
    </div>
    <div id="inbox-top-bar">
      <div id="back"><a href="#">Back</a></div>
      <div id="mark-unread"><a href="#">Mark as unread</a></div>
      <div id="star"><a href="#"><img src="/public/images/codeArmy/messages/star.png" /></a></div>
      <div id="bin"><a href="#"><img src="/public/images/codeArmy/messages/bin.png" /></a></div>
      <div id="msg-no"><?=$current+1?> to <?=min($limit*($current+1), $total)?> of <?=$total?></div>
      <div id="arrow-left"><a href="#"><img src="/public/images/codeArmy/messages/arrow-left.png" /></a></div>
      <div id="arrow-right"><a href="#"><img src="/public/images/codeArmy/messages/arrow-right.png" /></a></div>
    </div>
  </div>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
