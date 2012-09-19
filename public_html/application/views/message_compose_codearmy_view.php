<?php $this->load->view('includes/CAProfileHeader.php'); ?>
  <style>
  #errmsg3 {
	  width: 200px;
margin: 0 0 0px 30px;}
#msg-text #errmsg3 {
	float:right;
	margin: 30px;
}
#msg-subject input, #receiver-name input {
	float:left;
}
  </style>
  
<div class="container-fluid">
	<div class="row-fluid">
		
		<!-- Page start -->
		<!-- START - Compose Block - Dev. by Reza  -->
		  <div class="span10 offset1">
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
			    <input type="submit" value="Send" class="lnkimg">
			    </form>
			  </div>
		  </div>
		<!-- Page ends -->
		
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$('#compose-content-area [title]').tipsy({gravity:'s', opacity:0.95});
	});
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
