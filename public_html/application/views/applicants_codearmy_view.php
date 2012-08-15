<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<div class="applicants-container">
  <div id="block-applicants-header">
    <div class="block-header">
      <h3>Troopers (<?=count($troops)?>)</h3>
    </div>
    <div id="achievements-header-text"> Intro about what this page does. Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br />
      Pellentesque bibendum elit luctus tortor lobortis varius.</div>
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
          <p><?=$this->gamemech->get_level($bid['exp'])?></p>
        </div>
        <div class="find-mission-comment-name"><?=$bid['username']?></div>
      </div>
      </a>
    </div>
    <div class="apply-details-right-bidded">
      <div class="apply-details-right-top"><?=trim($bid['bid_desc']=='')?'No question or comment.':trim($bid['bid_desc'])?></div>
      <div class="apply-details-right-bottom">
      
      <div class="right-bot-l"><div class="bot-left-row1"><strong><?=$bid['username']?></strong> has bidded on your mission.</div><div class="bot-left-row2">PROPOSING: 
      <div class="proposed-price"><?=$bid['bid_cost']?>/<?=ucfirst(str_replace('dai','day',substr($arrangement,0,-2)))?>s</div>
      <div class="proposed-time"><?=$bid['bid_time']?> <?=ucfirst(str_replace('dai','day',substr($arrangement,0,-2)))?>s</div>
      </div></div>
      <div class="right-bot-r options">
            	<?php if($bid['bid_status']=='Bid'){?>
                <input type="button" class="rejimg reject" value="Reject" /><input type="button" class="lnkimg accept" value="Accept" />
                <?php }elseif($bid['bid_status']=='Declined'){?>
                <input type="button" class="rejimg ok" value="Ok" />
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
              <p><?=$this->gamemech->get_level($invitation['exp'])?></p>
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
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
