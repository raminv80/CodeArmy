<?php $this->load->view('includes/header_view'); ?>

	<!-- bid for stories start -->
	<div id="bid-wrapper">
		<div id="content">
			
		<h2>Bid for <a style="color:#FFF;" href="/story/<?php echo $work_data['work_id']; ?>"><?php echo $work_data['title']; ?></a></h2>
		
		<div class="desc">
			<p><?php echo $work_data['description']  ?></p>
		</div>
		
		<div class="points">
			<strong>Sweat Points:</strong> <img src="/public/images/sweat_shirt-<?php echo points_size($work_data['points']) ?>.png"> <?php echo $work_data['points']; ?>
		</div>
		<div class="points">
			<strong>Payout:</strong> RM <?php echo $work_data['cost']; ?>
		</div>
		
		<?php echo form_open('story/setbid'); ?>
		
		<div class="cost">
			<strong>My Bid amount for this story:</strong>
		RM
		<input type="text" size="4" name="set_cost" value="<?php echo $work_data['cost']; ?>" id="set_cost" /></div>
                <div class="cost">
			<strong>The number of days I commit to complete this story:</strong>
		<input type="text" size="4" name="set_days" id="set_days" /> days
                </div>
		<div class="cost">
			<input type="hidden" name="work_id" value="<?php echo $work_data['work_id'];?>" />
			<input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>" id="user_id">	
			<input type="submit" name="submit" value="Bid Now" id="submit" />
		</div>
		</div>
		
		<?php echo form_close(); ?>
		
		</div>
	</div>
	<!-- bid for stories ends -->

<?php $this->load->view('includes/footer_view'); ?>