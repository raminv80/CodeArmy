<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<div class="invite-page-container">
<style>
h3 {
	font-size:18px;
	font-weight:bold;
}
#mailimg { margin:5px;}
#invitebutton { float:right;}
</style>

<h3>Invite Friends</h3>
<img src="/public/images/codeArmy/content/title-bg.png" id="preview"/> <br />
<br />
<?php
$msg = $this->session->flashdata('msg');
if($msg) echo "<b>".$msg."</b>";
?>
<img style="float:right; margin-top:-30px;" id="mailimg" src="/public/images/codeArmy/invite-share-buttons.png" />
You can invite friends by sending them an email<br />
  <!--<br /><br /><br />
  Searching from address book to invite your friends to join CodeAr.my<br />
  <br /><br />
  <img id="mailimg" src="/public/images/codeArmy/yahoomail.png" />&nbsp;&nbsp;
  <img id="mailimg" src="/public/images/codeArmy/hotmail.png" />&nbsp;&nbsp;
  <img id="mailimg" src="/public/images/codeArmy/gmail.png" />&nbsp;&nbsp;
  <img id="mailimg" src="/public/images/codeArmy/skype.png" />-->
<br /><br />

<?php echo form_open('invite/sent'); ?>

<div style="height:200px;">
<div style="float:left; width:100px;">
Email Addresses:
</div>
<div style="float:right">
<?php if (isset($form_error)){ ?>
<textarea name="email" rows="7" cols="70" id="email"><?=set_value('email')?></textarea><br />
<div id="errmsg2"><?=form_error("email")?></div>
<?php } else { ?>
<textarea name="email" rows="7" cols="70" id="email"></textarea>
<?php } ?>
<br /><br />
Enter email addresses manually, please separate email addresses with commas.<br />
</div>
</div>

<div>
<div style="float:left; width:100px;">
Message:
</div>
<div style="float:right">
<?php if (isset($form_error)){ ?>
<textarea name="message" rows="12" cols="70" id="message"><?=set_value('message')?></textarea><br />
<div id="errmsg2"><?=form_error("message")?></div>
<?php } else { ?>
<textarea name="message" rows="12" cols="70" id="message">
Hi! I would like to invite you to be a part of CodeAr.my, a platform that helps you to find exciting Digital Products to wok on in a Gamified Environment!

Join me and be at the top of your game.
</textarea>
<?php } ?>
<br /><br />
<input style="float:right" type="image" src="/public/images/codeArmy/invite.png" border="0" alt="Submit" />
</div>
</div>

</form>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
