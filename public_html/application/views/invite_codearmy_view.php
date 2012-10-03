<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<div class="invite-page-container">
<style>
h3 {
	font-size:18px;
	font-weight:bold;
}
.share a {font-size:.9em}
</style>

<div class="container-fluid">
		
		<div class="row-fluid">
			<div class="span10 offset1" style="text-align:center; margin-bottom:20px">
				<h3>Invite Friends</h3>
				<img src="/public/images/codeArmy/content/title-bg.png" id="preview"/> <br />
				
			</div>
		</div>
		
		<div class="row-fluid" style="margin:10px 0 50px">
			<div class="span5 offset1">
				<?php
				$msg = $this->session->flashdata('msg');
				if($msg) echo "<b>".$msg."</b>";
				?>
				<p>Get your friends in the action. Send them an invite!</p>
			</div>
			<div class="span5 share">
				<div class="pull-right">
					<a href="http://www.facebook.com/share.php?u=http://www.CodeAr.my" target="_blank" onclick="return fbs_click()" class="btn btn-primary"><i class="icon-facebook"></i> Share</a> 
					<a href="http://twitter.com/home?status=Code Army – www.CodeAr.my" class="btn btn-info" target="_blank"><i class="icon-twitter"></i> Share</a>
				</div>
			</div>
		</div>

		<?php echo form_open('invite/sent'); ?>

		<div class="row-fluid" style="margin-bottom:25px">
			<div class="span2 offset1" style="text-align:right">Email Addresses:</div>
			<div class="span8">
				<?php if (isset($form_error)){ ?>
				<textarea name="email" class="span12" id="email"><?=set_value('email')?></textarea><br />
				<div id="errmsg2"><?=form_error("email")?></div>
				<?php } else { ?>
				<textarea name="email" class="span12" id="email"></textarea>
				<?php } ?>
				<p><small>Enter email addresses manually. Please separate each email address with a comma.</small></p>
			</div>
		</div>
		
		<div class="row-fluid">
			<div class="span2 offset1" style="text-align:right">Message:</div>
			<div class="span8">
				
				<?php if (isset($form_error)){ ?>
				<textarea name="message" id="message"><?=set_value('message')?></textarea><br />
				<div id="errmsg2"><?=form_error("message")?></div>
				<?php } else { ?>
				<textarea name="message" id="message" rows="7" class="span12">Greetings!
We are CodeAr.my, a platform that will help you to find exciting Digital Products to work on in a Gamified Environment.
Your friend <?=$me["username"]?> has nominated you for our attention.
Join our troop and be at the top of your game!!
                
Visit http://www.codearmy.com</textarea>
				<?php } ?>
				
				<p class="pull-right"><input type="submit" value="Invite" class="lnkimg" /></p>
				</form>
			</div>
		</div>
</div>

<?php $this->load->view('includes/CAProfileFooter.php'); ?>
