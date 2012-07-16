<?php $this->load->view('includes/header2'); ?>
			<div id="wrapper">
				<div class="contents">
                	<h3>You have <?php echo $message_count?> messages in your inbox</h3>
                    <?php if(isset($messages))foreach($messages as $message):?>
                	<ul>
                    	<li>Status: <?php echo $message->status;?>, Title: <?php echo $message->title;?>, Date: <?php echo $message->created_at;?></li>
                    </ul>
					<?php endforeach;?>
                </div><!-- End of the Container -->
<?php $this->load->view('includes/footer2'); ?>