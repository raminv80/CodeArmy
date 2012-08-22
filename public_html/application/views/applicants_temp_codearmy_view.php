<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<ul style="border:1px solid white; padding:5px">
<?php foreach($bids as $bid):?>
	<li>
    	<ul class="bid-container bid-status-<?=$bid['bid_status']?>" id="bid-<?=$bid['bid_id']?>">
        	<li>username: <?=$bid['username']?></li>
            <li>Level: <?=$this->gamemech->get_level($bid['exp'])?></li>
            <li>Bid message: <?=trim($bid['bid_desc']=='')?'No question or comment.':trim($bid['bid_desc'])?></li>
            <li>Bid Time: <?=$bid['bid_time']?> <?=ucfirst(str_replace('dai','day',substr($arrangement,0,-2)))?>s</li>
            <li>Bid Cost: <?=$bid['bid_cost']?> per <?=ucfirst(str_replace('dai','day',substr($arrangement,0,-2)))?>s</li>
            <li class="options">
            	<?php if($bid['bid_status']=='Bid'){?>
            	<a class="accept" href="#">Accept</a> | <a class="reject" href="#">Reject</a>
                <?php }elseif($bid['bid_status']=='Declined'){?>
                <a class="ok" href="#">Ok</a>
                <?php }?>
            </li>
        </ul>
    </li>
<?php endforeach;?>
</ul>
<div id="dialog-confirm" class="dialog" title="Mission assignment confirmation">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>You are accepting <span style="colo:yellow"></span>'s proposal as your mission trooper.</p><br><p style="text-align:center">Are you sure?</p>
</div>
<style>
.bid-status-Bid{background-color:#000}
.bid-status-Declined{background-color:orange}
.bid-status-Rejected{background-color:red}
.bid-status-Accepted{background-color:green}
</style>
<script type="text/javascript">
var selectedBid;
$(function(){
	$('.accept').click(function(){
		var pressed_button = $(this);
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			modal: true,
			width: 410,
			buttons: {
				Cancel: function() {
					$( this ).dialog( "close" );
				},
				"Yes" : function() {
					$.fancybox.showLoading();
					selectedBid = pressed_button.parents('.bid-container');
					if (typeof console == "object") console.log(pressed_button);
					var bid_id = selectedBid.attr('id').split('-')[1];
					$.ajax({
						'url': '/missions/Ajax_approve_bid',
						'type': 'post',
						'data': {'csrf_workpad': getCookie('csrf_workpad'), 'bid_id': bid_id},
						'success': function(msg){
								if (typeof console == "object") console.log(msg);
								if(msg=='success'){
									selectedBid.removeClass('bid-status-Bid').addClass('bid-status-Accepted');
									selectedBid.find('.options').remove();
								}
								$.fancybox.hideLoading();
							}
					});
					$( this ).dialog( "close" );
				}
			}
		});
	});
	$('.reject').click(function(){
		selectedBid = $(this).parents('.bid-container');
		var bid_id = selectedBid.attr('id').split('-')[1];
		$.ajax({
			'url': '/missions/Ajax_reject_bid',
			'type': 'post',
			'data': {'csrf_workpad': getCookie('csrf_workpad'), 'bid_id': bid_id},
			'success': function(msg){
					if (typeof console == "object") console.log(msg);
					if(msg=='success'){
						selectedBid.slideUp(function(){$(this).remove()});
					}
				}
		});
	});
	$('.declined').click(function(){
		selectedBid = $(this).parents('.bid-container');
		var bid_id = selectedBid.attr('id').split('-')[1];
		$.ajax({
			'url': '/missions/Ajax_remove_bid',
			'type': 'post',
			'data': {'csrf_workpad': getCookie('csrf_workpad'), 'bid_id': bid_id},
			'success': function(msg){
					if (typeof console == "object") console.log(msg);
					if(msg=='success'){
						selectedBid.slideUp(function(){$(this).remove()});
					}
				}
		});
	});
});
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
