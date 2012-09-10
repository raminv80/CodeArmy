<?php $this->load->view('includes/CAProfileHeader.php'); ?>
  <a class="icon-edit fancybox" href="/missions/edit_mission/<?=$work_id?>"> Edit</a> |
  <?php if(strtolower($work['status'])!='draft'){?>
  <a class="icon-thumbs-up" href="javascript:void(0)" onClick="recom('<?=$work_id?>')"> Recommendations</a> |
  <?php }?>
  <a class="icon-trash" id="delete-mission" href="javascript:void(0)"> Remove</a>
<div id="tabs" style="clear:both">
  <ul>
    <li><a href="#tabs-detail">Mission Details</a></li>
    <li><a href="#tabs-proposal" title="List of tallents who answered your call for duty (mission)">Army</a></li>
    <li><a href="#tabs-invite">Invitations</a></li>
  </ul>
  <div id="tabs-detail"> 
    <!-- detail tab-->
    <div class="find-mission-full-wrapper">
      <div class="find-mission-full-container" style="width:730px; overflow:hidden">
        <div class="find-mission-main-col">
          <div class="find_mission_main_desc">
            <div class="find-mission-main-title">
              <div class="find-mission-title-logo"></div>
              <div class="find-mission-title-text">
                <?=$work['title']?>
              </div>
            </div>
            <div class="find-mission-video-block">
              <iframe width="475" height="280" frameborder="0" src="http://www.youtube.com/embed/<?=$work['tutorial']?$work['tutorial']:'zFNb8j3YAd4'?>?wmode=opaque" type="text/html" class="youtube-player"></iframe>
            </div>
            <div class="find-mission-main-desc">
              <?=$work['description']?>
            </div>
          </div>
        </div>
        <div class="find-mission-right-col" style="width:195px">
          <div class="find-mission-right-block">
            <div class="right-col-title-bg">Pre-Requisites</div>
            <div class="prereqicons">
              <?php foreach($work_skills as $skill):?>
              <div class="prereqicon"><span class="skill_<?=$skill['skill_id']?>">
                <?=$skill['name']?>
                </span>
                <p>
                  <?=$skill['point']?>
                </p>
              </div>
              <?php endforeach;?>
            </div>
          </div>
          <div class="find-mission-right-block">
            <div class="right-col-title-bg">Materials</div>
            <?php foreach($work_files as $file):?>
            <div class="find-mission-material-row">
              <div class="attach-file-tools"> <img src="/public/images/codeArmy/mission/fileicon.png" class="fileicon" /> <span class="filename"><a href="/public/uploads/<?=$file['file_name']?>" target="_blank">
                  <?=(strlen($file['file_name'])>25)?substr($file['file_name'],0,15).'...'.substr($file['file_name'],-7,7):$file['file_name']?>
                </a></span> <span class="filesize">
                <?=byte_format($file['file_size'])?>
                </span> </div>
            </div>
            <?php endforeach;?>
          </div>
          <div class="find-mission-right-block">
            <div class="right-col-title-bg">Estimation</div>
            <div class="est-main-rows">
              <div class="est-row1"> <span class="est-blue-txt">
                <?=($estimate_time['time_cal'])?$estimate_time['time_cal']:'?'?>
                <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>
                s</span></div>
              <div class="est-row2"> <span class="est-blue-txt">
                <?=($estimate_budget['amount_cal'])?$estimate_budget['amount_cal']:'?'?>
                per
                <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>
                s</span></div>
            </div>
            <div class="est-average-rows">
              <div class="est-avg-title">Average Bids</div>
              <div class="est-row1"><span class="est-blue-txt">
                <?=round($bid_avg['avg_time'])?>
                </span>
                <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>
                s </div>
              <div class="est-row2"> <span class="est-blue-txt">
                <?=round($bid_avg['avg_cost'])?>
                </span> per
                <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>
                s </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="tabs-proposal"> 
    <!-- proposal tab-->
    <div>
      <div class="applicants-container">
        <div id="block-applicants-header">
          <div class="block-header">
            <h3>Army (<?=count($bids)?>)</h3>
          </div>
          <div id="achievements-header-text">Here is list of tallents A.K.A troopers who applied for this mission. The green circles next to each trooper shows percentage of match between trooper's skill set and your mission skill requirements.</div>
        </div>
        <div class="applicants-subtitle" style="float:none"></div>
        <?php foreach($bids as $bid):?>
        <div class="apply-details-row bid-container bid-status-<?=$bid['bid_status']?>" id="bid-<?=$bid['bid_id']?>" style="float:none;width:730px;">
          <div class="apply-details-left-<?=($bid['bid_status']=='Bid')?'bidded':''?><?=($bid['bid_status']=='Declined')?'declined':''?>">
            <div class="recom-box-top-circle">
              <p>
                <?=round($this->recom_model->get_match($work_id,$bid['user_id']))?>
                %</p>
            </div>
            <a href="/profile/show/<?=$bid['username']?>">
              <div class="applicant-avatar-box">
                <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
                  <p>
                    <?=$this->gamemech->get_level($bid['exp'])?>
                  </p>
                </div>
                <div class="find-mission-comment-name">
                  <?=$bid['username']?>
                </div>
              </div>
            </a> </div>
          <div style="width:603px;" class="apply-details-right-<?=($bid['bid_status']=='Bid')?'bidded':''?><?=($bid['bid_status']=='Declined')?'declined':''?>">
            <div class="apply-details-right-top">
              <?=trim($bid['bid_desc']=='')?'No question or comment.':trim($bid['bid_desc'])?>
            </div>
            <div class="apply-details-right-bottom">
              <div class="right-bot-l" style="width:200px">
                <div class="bot-left-row1"></div>
                <div class="bot-left-row2">
                  <div class="proposed-price"><?=$bid['bid_cost']?>/<?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s</div>
                  <div class="proposed-time"><?=$bid['bid_time']?> <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s</div>
                </div>
              </div>
              <div class="right-bot-r options">
                <?php if($bid['bid_status']=='Bid'){?>
                <input type="button" class="rejimg reject" value="Reject" />
                <input type="button" class="lnkimg accept" value="Accept" />
                <?php }elseif($bid['bid_status']=='Declined'){?>
                <input type="button" class="rejimg declined" value="Ok" />
                <?php }?>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach;?>
      </div>
    </div>
  </div>
  <div id="tabs-invite"> 
    <!-- invite tab-->
    <div>
    <div class="applicants-container">
      <div id="block-applicants-header">
        <div class="block-header">
          <h3> Pending invitations (<?=count($invitations)?>)</h3>
        </div>
        <div id="achievements-header-text"></div>
      </div>
      <div class="applicants-subtitle" style="float:none"></div>
      <?php foreach($invitations as $i=>$invitation):?>
      <?php if($i%5==0):?>
      <div class="pend-resp-row" style="width:730px; height:140px; float:none; position:inherit">
        <?php endif;?>
        <div class="pend-resp-box">
          <div class="recom-box-top-circle">
            <p>
              <?=round($this->recom_model->get_match($work_id,$invitation['user_id']))?>
              %</p>
          </div>
          <a href="/profile/show/<?=$invitation['username']?>">
            <div class="applicant-avatar-box">
              <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
                <p>
                  <?=$this->gamemech->get_level($invitation['exp'])?>
                </p>
              </div>
              <div class="find-mission-comment-name">
                <?=$invitation['username']?>
              </div>
            </div>
          </a> </div>
        <?php if($i%5==0):?>
      </div>
      <?php endif;?>
      <?php endforeach;?>
    </div>
    </div>
  </div>
</div>
<div id="dialog-delete" class="dialog" title="Delete mission">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure you want to delete this mission?</p>
</div>
<div id="dialog-confirm" class="dialog" title="Proposal approval">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>You are accepting the selected proposal as your mission trooper.</p>
  <br>
  <p style="text-align:center">Are you sure?</p>
</div>
<div id="dialog-reject" class="dialog" title="Proposal rejection">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>You are rejecting the selected proposal.</p>
  <br>
  <p style="text-align:center">Are you sure?</p>
</div>
<div class="pop-recom"></div>
<style type="text/css">
	.bid-status-Accepted{background-color:rgba(50,50,150,0.2)}
	.mission-top-menu li{float:left; width:100px; display:block}
	.mission-top-menu{ display:block; clear:both;}
	.pop-recom {width:1000px; height:550px; border:2px solid #333; position:relative; display:none; z-index:2; padding:20px; background: black}
	.pop-recom .close {position:absolute; right:-10px; top:-10px; background:black; width:25px; height:25px; line-height:25px; text-align:center; border:2px solid #999; border-radius:50%; cursor:pointer}
</style>
<script type="text/javascript">
$(function(){
	$( "#tabs" ).tabs({selected: 0});
});
</script>
<script type="text/javascript">
var selectedBid;
$(function(){
	$('#delete-mission').click(function(){
		$( "#dialog-delete" ).dialog({
			resizable: false,
			modal: true,
			width: 410,
			buttons: {
				Cancel: function(){$(this).dialog("close");},
				"Yes": function(){
					$(this).dialog("close");
					$.fancybox.showLoading();
					$.ajax({
						'url': '/missions/Ajax_remove_mission',
						'type': 'post',
						'data': {'csrf_workpad': getCookie('csrf_workpad'), 'work_id': '<?=$work_id?>'},
						'success': function(msg){
								$.fancybox.hideLoading();
								window.location = '/missions/my_missions';
							}
					})
				}
			},
		});
	});
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

/*function recom(work_id){
	$.fancybox.open({
		data:{},
		href : 'http://<?=$_SERVER['HTTP_HOST']?>/missions/recommended_tallents/'+work_id,
		type : 'iframe',
		padding : 0,
		margin: 0,
		height: 600,
		width: 960,
		autoSize: false,
		'overlayShow': true,
		'overlayOpacity': 0.8, 
		afterClose: function(){},
		openMethod : 'dropIn',
		openSpeed : 250,
		closeMethod : 'dropOut',
		closeSpeed : 150,
		nextMethod : 'slideIn',
		nextSpeed : 250,
		prevMethod : 'slideOut',
		prevSpeed : 250,
		scrolling: 'auto'
	});	
}*/

function recom(work_id) {
	$('.fancybox-close').css({'position' : 'absolute', 'z-index' : '1'});
	$(".pop-recom").lightbox_me({
		closeSelector: '.close',
		overlayCSS	: {background: 'black', opacity: .8},
		onLoad : function() {
			var url = 'http://<?=$_SERVER['HTTP_HOST']?>/missions/recommended_tallents/'+work_id;
			$('.pop-recom').html('<iframe width="100%" height="100%" src="'+url+'"></iframe><div class="close"><i class="icon-remove"></i></div>');
		}
	});
}

</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
