<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<textarea name="msg" id="msg"></textarea>
<input type="button" id="submit" value="send">
<ul id="list">
</ul>
<script>
$(function(){
	$('#submit').click(function(){
		$.ajax({
			type: 'post',
			url: '/messages/chat_send',
			data: {'id': '<?=$me['user_id']?>', 'name': '<?=$me['username']?>', 'email':'<?=$me['email']?>', 'message': $('#msg').val(), 'csrf_workpad': getCookie('csrf_workpad')},
			success: function(msg){
				console.log(msg)
				$('#list').prepend('<li>'+msg+'</li>');
			}
		});
	});
});
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>