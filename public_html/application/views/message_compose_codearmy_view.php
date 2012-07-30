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
    <?php echo form_open('messages/send'); ?>
    <div id="compose-main-area">
      <div id="compose-avatar"> </div>
      <div id="receiver-name">
        <label>To:</label>
        &nbsp;
        <?php if (isset($form_error)){ ?>
        <input id="msg-to" name="msg-to" value="<?=set_value('msg-to')?>" />
		<div id="errmsg3"><?=form_error("msg-to")?></div>
        <?php } else { ?>
        <input id="msg-to" name="msg-to" />
        <?php } ?>
      </div>
      <div id="msg-subject">
        <label>Subject:</label>
        &nbsp;
        <?php if (isset($form_error)){ ?>
        <input id="msg-subj" name="msg-subj" value="<?=set_value('msg-subj')?>" />
		<div id="errmsg3"><?=form_error("msg-subj")?></div>
        <?php } else { ?>
        <input id="msg-subj" name="msg-subj" />
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
    <input type="submit" value="Send" class="lnkimg">
    </form>
  </div>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
