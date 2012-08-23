<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<div>
<h1>Public chat room</h1>
<div id="status"></div>
<div>total online users: <span id="count">0</span></div>
<div id="public-message-users">who's online:<br /></div>
</div>
<textarea name="msg" id="public-message-textarea"></textarea>
<input type="button" id="public-message-submit" value="send" disabled="disabled">
<div id="chat-message-list"></div>
<style>

</style>
<script>
$(function(){
	$('#public-message-submit').click(function(){
		var msg = $.trim(removeTags($('#public-message-textarea').val()));
		if(msg.length>0)
			$.ajax({
				type: 'post',
				url: '/messages/chat_send',
				data: {'id': '<?=$me['user_id']?>', 'name': '<?=$me['username']?>', 'email':'<?=$me['email']?>', 'message': msg, 'csrf_workpad': getCookie('csrf_workpad')},
				success: function(msg){
					$('#public-message-textarea').val('');
				}
			});
	});
	var no_chat_msg = 0;
	Pusher.channel_auth_endpoint = '/pusher/auth';
	var public_chat_channel = pusher.subscribe('presence-chat-public');
	
	public_chat_channel.bind('incomming-message', function(data) {
	  no_chat_msg++;
	  $('#chat-message-list').prepend('<div id="msg-'+no_chat_msg+'" style="display:none">'+data.username+': '+data.message+'</div>');
	  $('#msg-'+no_chat_msg).slideDown();
	});
	
	pusher.connection.bind('state_change', function(states) {
	  // states = {previous: 'oldState', current: 'newState'}
	  $('div#status').text("Pusher's state changed from "+states.previous+" to " + states.current);
	  if(states.current=='connected')
	  $('#public-message-submit').removeAttr('disabled');
	  else $('#public-message-submit').attr('disabled',true);
	});
	
	public_chat_channel.bind('pusher:subscription_succeeded', function(members) {	
	  members.each(function(member) {
		add_member(member);
	  });
	});
	public_chat_channel.bind('pusher:member_added', function(member) {
		add_member(member);
	});
	public_chat_channel.bind('pusher:member_removed', function(member) {
	  remove_member(member);
	});
	
	$('#public-message-textarea').keyup(function(e){
	  e = e || event;
	  if (e.keyCode === 13) {
		$('#public-message-submit').click();
	  }
	  return true;
	 });

});

function add_member(member){
	var found = false;
	$('.chat-member').each(function(){if($(this).attr('id').split('-')[2]==member.id)found=true;});
	if(!found){
		var el = $('#count');
		el.html(parseInt(el.html())+1);
		$('#public-message-users').append('<div style="display:none" class="chat-member" id="chat-member-'+member.id+'">'+member.info.username+'</div>');
		$('#chat-member-'+member.id).slideDown();
	}
}

function remove_member(member){
	$('#public-message-user #chat-member-'+member.id).remove();
	var el = $('#count');
	el.html(parseInt(el.html())-1);
}
 
 var tagBody = '(?:[^"\'>]|"[^"]*"|\'[^\']*\')*';

var tagOrComment = new RegExp(
    '<(?:'
    // Comment body.
    + '!--(?:(?:-*[^->])*--+|-?)'
    // Special "raw text" elements whose content should be elided.
    + '|script\\b' + tagBody + '>[\\s\\S]*?</script\\s*'
    + '|style\\b' + tagBody + '>[\\s\\S]*?</style\\s*'
    // Regular name
    + '|/?[a-z]'
    + tagBody
    + ')>',
    'gi');
function removeTags(html) {
  var oldHtml;
  do {
    oldHtml = html;
    html = html.replace(tagOrComment, '');
  } while (html !== oldHtml);
  return html.replace(/</g, '&lt;');
}
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>