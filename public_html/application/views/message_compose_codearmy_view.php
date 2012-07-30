<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<div id="compose-content-area"> 
  
  <!-- START - Compose Block - Dev. by Reza  -->
  <div id="block-compose-header">
    <div class="block-header">
      <h3>Compose Message</h3>
    </div>
  </div>
  <div id="compose-area">
    <div id="inbox-top-bar">
      <div id="back"><a href="#">Back</a></div>
      <div id="archive"><a href="#">Archive</a></div>
      <div id="star"><a href="#"><img src="/public/images/codeArmy/messages/star.png" /></a></div>
      <div id="bin"><a href="#"><img src="/public/images/codeArmy/messages/bin.png" /></a></div>
      <div id="msg-no">1 of 5</div>
      <div id="arrow-left"><a href="#"><img src="/public/images/codeArmy/messages/arrow-left.png" /></a></div>
      <div id="arrow-right"><a href="#"><img src="/public/images/codeArmy/messages/arrow-right.png" /></a></div>
    </div>
    
    <div id="compose-main-area">
    
    <div id="compose-avatar">
    </div>
    
    <div id="receiver-name"><label>To:</label>&nbsp;<input id="msg-to" name="subj" /></div>
    <div id="msg-subject"><label>Subject:</label>&nbsp;<input id="msg-subj" name="subj" /></div>
    
    <div id="msg-text"><label>Message:</label>
    <textarea rows="7" id="msg-text" name="msg-text">
    </textarea>
    </div>
    
    </div>
    
    </div>
    
</div>

<?php $this->load->view('includes/CAProfileFooter.php'); ?>