<?php $this->load->view('includes/header_view'); ?>

<div id="delete_wrapper">
	<h2>Are you sure to delete this Story?</h2>
	<span class="confirm_button"><a href="/story/delete_confirm/<?php echo $pro_id; ?>/<?php echo $id; ?>">Yes</a></span>
	<span class="cancel_button"><a href="/projects/view/<?php echo $pro_id; ?>">No</a></span>
</div>
	
<?php $this->load->view('includes/footer_view'); ?>