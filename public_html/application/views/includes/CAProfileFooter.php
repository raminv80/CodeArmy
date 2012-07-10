	</div>
</div>
<script>
	$('#dropdown-button').click(function(){$('#dropdown').slideToggle('fast');})
	$('#logo').click(function(){window.location="/profile"});
	$('#missions-toggle').click(function(){$('#mission-submenue').slideToggle();});
	function loadEffect(){}
</script>
<?php $this->load->view('includes/CAFooter.php'); ?>