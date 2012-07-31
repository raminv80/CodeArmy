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
      <div id="back"><a title="Goto previous page" href="/messages/inbox">Back</a></div>
      <div id="archive"></div>
      <div id="star"></div>
      <div id="bin"></div>
      <div id="msg-no"></div>
      <div id="arrow-left"></div>
      <div id="arrow-right"></div>
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
<script type="text/javascript">
	$(function(){
		$('#compose-content-area [title]').tipsy({gravity:'s', opacity:0.95});
	});
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
