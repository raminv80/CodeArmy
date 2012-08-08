<link href="/public/css/CodeArmyV1/style.css" media="all" rel="stylesheet" type="text/css" />

<div class="find-mission-full-container">
  <div class="find-mission-main-col">
    <div class="find_mission_main_desc">
      <div class="find-mission-main-title">
        <div class="find-mission-title-logo"></div>
        <div class="find-mission-title-text"><?=$work['title']?></div>
      </div>
      <div class="find-mission-video-block">
        <iframe width="475" height="280" frameborder="0" src="http://www.youtube.com/embed/<?=isset($this->view_data['work'])?$this->view_data['work']:'zFNb8j3YAd4'?>?wmode=opaque" type="text/html" class="youtube-player"></iframe>
      </div>
      <div class="find-mission-main-desc"><?=$work['description']?></div>
    </div>
    <div class="find-mission-comment-box">
      <div class="find-mission-comment-box-left">
        <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
          <p><?=$this->gamemech->get_level($me['exp'])?></p>
        </div>
        <div class="find-mission-comment-name"><?=$me['username']?></div>
      </div>
      <?php echo form_open('/mission/set_bid' , array('id'=>'form-bid')); ?>
      <div class="find-mission-comment-box-right">
        <div class="fmcb-right-row1">
          <div class="urbid">Your Bid</div>
          <div class="clock-icon"></div>
          <div class="small-box-hr">
            <input name="time" type="text" value="18" />
          </div>
          <div class="botharrows"><a href="#"><img class="arr-up-img" src="/public/images/codeArmy/mission/arr-up.png" /></a><a href="#"><img class="arr-down-img" src="/public/images/codeArmy/mission/arr-down.png" /></a></div>
          <div class="bidhrstext">Hours</div>
          <!--
          <div class="small-box-hr">
            <input type="text" value="4" />
          </div>
          <div class="botharrows"><a href="#"><img class="arr-up-img" src="/public/images/codeArmy/mission/arr-up.png" /></a><a href="#"><img class="arr-down-img" src="/public/images/codeArmy/mission/arr-down.png" /></a></div>
          <div class="bidhrstext">Days</div>
          -->
        </div>
        <div class="fmcb-right-row2">
          <div class="dollar-sign-icon"></div>
          <div class="small-box-hr">
            <input name="budget" type="text" value="35" />
          </div>
          <div class="bidhrstext">/hour</div>
        </div>
        <div class="fmcb-right-textarea">
          <textarea name="desc" rows="3">Ask a question</textarea>
        </div>
        <input type="hidden" name="work_id" value="<?=$work['work_id']?>">
        <input type="submit" name="submit" value="Submit" class="lnkimg" />
      </div>
      </form>
      <div class="find-mission-comment-box-down">
        <div class="find-mission-down-box-row">
          <?php 
		  	foreach($bids as $bid):
				$bidder = $this->users_model->get_user($bid['user_id'])->result_array();
				$bidder = $bidder[0];
				$lvl = $this->gamemech->get_level($bidder['exp']);
		  ?>
          <div class="find-mission-comment-box-left">
            <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
              <p><?=$lvl?></p>
            </div>
            <div class="find-mission-comment-name"><?=$bidder['username']?></div>
          </div>
          <div class="find-mission-comment-box-right">
            <div class="bidded-icon"></div>
            <div class="fmcb-right-row1"><?=$bid['desc']?></div>
            <div class="fmcb-right-row2">
              <div class="commentime"><?=$bid['created_at']?></div>
              <div class="replybut"><a href="#"><img src="/public/images/codeArmy/mission/reply-icon.png" /></a></div>
            </div>
          </div>
        </div>
        <?php endforeach;?>
        <div class="find-mission-down-box-row">
          <div class="find-mission-comment-box-left">
            <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
              <p>75</p>
            </div>
            <div class="find-mission-comment-name">Rolando</div>
          </div>
          <div class="find-mission-comment-box-right">
            <div class="fmcb-right-row1"> <span class="po-comment"> Product Owner's respond will look like this. </span> </div>
            <div class="fmcb-right-row2">
              <div class="commentime">3 minutes ago</div>
            </div>
          </div>
        </div>
        <div class="find-mission-down-box-row">
          <div class="find-mission-comment-box-left">
            <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
              <p>75</p>
            </div>
            <div class="find-mission-comment-name">Rolando</div>
          </div>
          <div class="find-mission-comment-box-right">
            <div class="bidded-icon"></div>
            <div class="fmcb-right-row1"> I can deliver this to you within 4 days. I can start immediately.
              Satisfaction guaramteed ;) </div>
            <div class="fmcb-right-row2">
              <div class="commentime">5 minutes ago</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="find-mission-right-col">
    <div class="closebut"><a href="#">X CLOSE</a></div>
    <div class="find-mission-right-block">
      <div class="right-col-title-bg">Mission Captain</div>
      <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
        <p>99</p>
      </div>
      <div class="captainame"><?=$po['username']?></div>
      <div class="captainrank">Level <?=$this->gamemech->get_level($po['exp'])?></div>
      <div class="rankicons">
      	<?php foreach($po_badge as $badge):?>
        <img src="/public/<?=$badge["achievement_pic"]?>" width="34" height="26" alt="<?=ucfirst(strtolower($badge["achievement_name"]))?>">
        <?php endforeach;?></div>
    </div>
    <div class="find-mission-right-block">
      <div class="right-col-title-bg">Pre-Requisites</div>
      <div class="prereqicons">
      	<?php foreach($work_skills as $skill):?>
        <div class="prereqicon"><span class="skill_<?=$skill['skill_id']?>"><?=$skill['name']?></span>
          <p><?=$skill['point']?></p>
        </div>
        <?php endforeach;?>
      </div>
    </div>
    <div class="find-mission-right-block">
      <div class="right-col-title-bg">Materials</div>
      <?php foreach($work_files as $file):?>
      <div class="find-mission-material-row">
        <div class="attach-file-tools"> <a href="#"><img src="/public/images/codeArmy/mission/fileicon.png" class="fileicon" /></a> <span class="filename"><a href="#"><?=$file['name']?></a></span> <span class="filesize"></span> </div>
      </div>
      <?php endforeach;?>
    </div>
    <div class="find-mission-right-block">
      <div class="right-col-title-bg">Estimation</div>
      <div class="est-main-rows">
        <div class="est-row1"> <span class="est-blue-txt"><?=$work['est_time_frame']?></span></div>
        <div class="est-row2"> <span class="est-blue-txt"><?=$work['est_budget']?></span></div>
      </div>
      <div class="est-average-rows">
        <div class="est-avg-title">Average Bids</div>
        <div class="est-row1"> <span class="est-blue-txt">5</span> Days, <span class="est-blue-txt">18</span> Hours </div>
        <div class="est-row2"> <span class="est-blue-txt">USD30~40</span> per hour </div>
      </div>
    </div>
    <div class="find-mission-right-block">
      <div class="right-col-title-bg">Bidders (3)</div>
      <div class="bidders-avatars">
        <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
          <p>99</p>
          <div class="find-mission-comment-name">Rolando</div>
        </div>
        <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
          <p>99</p>
          <div class="find-mission-comment-name">Rolando</div>
        </div>
        <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
          <p>99</p>
          <div class="find-mission-comment-name">Rolando</div>
        </div>
        <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
          <p>99</p>
          <div class="find-mission-comment-name">Rolando</div>
        </div>
      </div>
    </div>
  </div>
</div>
