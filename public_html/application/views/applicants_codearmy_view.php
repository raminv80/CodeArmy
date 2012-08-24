<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<div class="applicants-container">
  <div id="block-applicants-header">
    <div class="block-header">
      <h3>Troopers (<?=count($troops)?>)</h3>
    </div>
    <div id="achievements-header-text">Here is list of bidders on your mission A.K.A troopers. The green circles next to each trooper shows percentage of match between trooper's skill set and your mission skill requirements.</div>
  </div>
  <div class="applicants-subtitle"> Responded (<?=count($bids)?>) </div>
  <?php foreach($bids as $bid):?>
  <div class="apply-details-row bid-container bid-status-<?=$bid['bid_status']?>" id="bid-<?=$bid['bid_id']?>">
    <div class="apply-details-left-<?=($bid['bid_status']=='Bid')?'bidded':''?><?=($bid['bid_status']=='Declined')?'declined':''?>">
      <div class="recom-box-top-circle">
        <p><?=round($this->recom_model->get_match($work_id,$bid['user_id']))?>%</p>
      </div>
      <a href="/profile/show/<?=$bid['username']?>">
      <div class="applicant-avatar-box">
        <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
          <p><?=$this->game_model->get_level($bid['exp'])?></p>
        </div>
        <div class="find-mission-comment-name"><?=$bid['username']?></div>
      </div>
      </a>
    </div>
    <div class="apply-details-right-<?=($bid['bid_status']=='Bid')?'bidded':''?><?=($bid['bid_status']=='Declined')?'declined':''?>">
      <div class="apply-details-right-top"><?=trim($bid['bid_desc']=='')?'No question or comment.':trim($bid['bid_desc'])?></div>
      <div class="apply-details-right-bottom">
      
      <div class="right-bot-l"><div class="bot-left-row1"><strong><?=$bid['username']?></strong> proposed:</div><div class="bot-left-row2"> 
      <div class="proposed-price"><?=$bid['bid_cost']?>/<?=ucfirst(str_replace('dai','day',substr($arrangement,0,-2)))?>s</div>
      <div class="proposed-time"><?=$bid['bid_time']?> <?=ucfirst(str_replace('dai','day',substr($arrangement,0,-2)))?>s</div>
      </div></div>
      <div class="right-bot-r options">
            	<?php if($bid['bid_status']=='Bid'){?>
                <input type="button" class="rejimg reject" value="Reject" /><input type="button" class="lnkimg accept" value="Accept" />
                <?php }elseif($bid['bid_status']=='Declined'){?>
                <input type="button" class="rejimg declined" value="Ok" />
                <?php }?>
	  </div>
      </div>
    </div>
  </div>
  <?php endforeach;?>
  <!--<div class="apply-details-row">
    <div class="apply-details-left-declined">
      <div class="recom-box-top-circle">
        <p>1%</p>
      </div>
      <div class="applicant-avatar-box">
        <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
          <p>22</p>
        </div>
        <div class="find-mission-comment-name">Roland</div>
      </div>
    </div>
    <div class="apply-details-right-declined">
      <div class="apply-details-right-top">Contractor's reason will appear here. Sorry to decline, my schedule is fully occupied currently.</div>
      <div class="apply-details-right-bottom">
      
       <div class="right-bot-l"><div class="bot-left-row1"><strong>Jual_Mahal</strong> has declined your invitation.</div></div>
      <div class="right-bot-r"><input type="submit" class="rejimg" value="OK" /></div>
      
      </div>
    </div>
  </div>-->
  <div class="applicants-subtitle"> Pending Response (<?=count($invitations)?>) </div>
  <?php foreach($invitations as $i=>$invitation):?>
	  <?php if($i%5==0):?>
      <div class="pend-resp-row">
      <?php endif;?>
        <div class="pend-resp-box">
          <div class="recom-box-top-circle">
            <p><?=round($this->recom_model->get_match($work_id,$invitation['user_id']))?>%</p>
          </div>
          <a href="/profile/show/<?=$invitation['username']?>">
          <div class="applicant-avatar-box">
            <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
              <p><?=$this->game_model->get_level($invitation['exp'])?></p>
            </div>
            <div class="find-mission-comment-name"><?=$invitation['username']?></div>
          </div>
          </a>
        </div>
      <?php if($i%5==0):?>
      </div>
      <?php endif;?>
  <?php endforeach;?>
</div>
<div id="dialog-confirm" class="dialog" title="Proposal approval">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>You are accepting the selected proposal as your mission trooper.</p><br><p style="text-align:center">Are you sure?</p>
</div>
<div id="dialog-reject" class="dialog" title="Proposal rejection">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>You are rejecting the selected proposal.</p><br><p style="text-align:center">Are you sure?</p>
</div>

<style type="text/css">
.bid-status-Accepted{background-color:rgba(50,50,150,0.2)}
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
								if(msg!='error'){
									if (typeof console == "object") console.log($('#bid-'+msg));
									$('#bid-'+msg).removeClass('bid-status-Bid').addClass('bid-status-Accepted').find('.apply-details-left-bidded').removeClass('apply-details-left-bidded');
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
		if (typeof console == "object") console.log(bid_id);
		$( "#dialog-reject" ).dialog({
			resizable: false,
			modal: true,
			width: 410,
			buttons: {
				Cancel: function() {
					$( this ).dialog( "close" );
				},
				"Yes" : function() {
					$.ajax({
						'url': '/missions/Ajax_reject_bid',
						'type': 'post',
						'data': {'csrf_workpad': getCookie('csrf_workpad'), 'bid_id': bid_id},
						'success': function(msg){
								if (typeof console == "object") console.log(msg);
								if(msg!='error'){
									$( "#dialog-reject" ).dialog( "close" );
									selectedBid.slideUp(function(){$('#bid-'+msg).remove()});
								}
							}
					});
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
