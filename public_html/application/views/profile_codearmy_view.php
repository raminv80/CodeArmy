<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<!--<img src="/public/images/codeArmy/profile/temp-final.png" id="preview"/>-->			

<div id="profile-content-area"> 
  
  <div id="profile-page-left-col">
  <!-- START - Level Block - Dev. by Reza  -->
  <div id="block-level" style="display:none"> Level
    <?=$myLevel?>
  </div>
  
  <!-- START - Avatar Block - Dev. by Reza  -->
  <div id="block-avatar">
    <div id="profile-name"><?=substr($me["username"],0,15);?></div>
    <a id="msg-icon" href="/messages/compose/<?=$me["username"]?>"></a>
    <div id="profile-type"><?=$myProfile["specialization"]?> <?php if(trim($myCountry)!=""){?>&nbsp;&nbsp; [<?=$myCountry?>] <?php }?></div>
    <div id="avatar-pic"> <img src="/public/images/codeArmy/profile/default-avatar.png" alt="Avatar Picture" /> </div>
    <div id="profile-desc"><?=$myProfile["status_msg"]?></div>
  </div>
  
  <!-- Ramin: leaderboard-block 17-7-2012-->
  <div id="block-leaderboard">
    <div class="block-header">
      <h3>Leaderboard</h3>
      <a href="/leaderboard">View all</a> </div>
    <div class="block-content">
      <ul>
      	<?php if($leaderBoard){
			foreach($leaderBoard as $leader):
		?>
        <li class="leaderboard-row">
          <a href="/profile/show/<?=$leader['username']?>">
          <img width="35" height="35" src="<?=($leader["avatar"] != NULL)?'/public/'.$leader["avatar"]:'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $leader['email'] ) ) )?>" alt="user-avatar" />
          <ul class="leaderboard-info">
            <li><?=ucfirst($leader["username"])?></li>
            <li><?=$leader["rank"]?></li>
          </ul>
          <div class="leaderboard-points"><?=$leader["exp"]?> Points</div>
          </a>
        </li>
        <?php
			endforeach;
		}
		?>
      </ul>
    </div>
  </div>
  <!-- Ramin:leader board bloclk end--> 
  </div>
  <!-- START - Experience Block - Dev. by Reza -->
  <div id="block-experience">
    <div id="experience-header">
      <h3>Level <?=$myLevel?> (Exp Points:<?=$me["exp"];?>)</h3>
    </div>
    <div id="edit-profile-link"><a href="/profile/edit">Edit Profile</a></div>
    <div id="experience-bar">
      <div style="width:<?=round(443*$expProgress)?>px" id="experience-bar-progress"> </div>
    </div>
  </div>
  
  <!-- START - Experience Block - Dev. by Reza -->
  <div class="block-mission-info">
    <div id="mission-bid">
      <div id="mission-bid-text">Mission Bid</div>
      <div id="mission-bid-number"><?=$myWorkBid?></div>
    </div>
    <div id="mission-complete">
      <div id="mission-complete-text">Mission Complete</div>
      <div id="mission-complete-number"><?=$myWorkCompleted?></div>
    </div>
  </div>
  
  <!-- START - Skill Progression Block - Dev. by Reza -->
  <div id="block-skill-progression">
    <div class="block-header">
      <h3>Skill Progression</h3>
    </div>
    <?php
	if ($mySkills){
    	foreach($mySkills as $skill):
	?>
    <div class="skill-unit">
      <div id="skill-title"><?=ucfirst($skill["name"])?></div>
      <div id="skill-bar">
        <div title="<?=$skill["point"]?>" style="width:<?=$skill["point"]?>%" id="skill-bar-progress"></div>
      </div>
    </div>
    <?php
    	endforeach;
	}else{
	?>
    <div style="border:2px dashed #0cF; padding:88px 0; position:relative; top:40px; margin:0 auto; width:93%; text-align:center; color:#0cf;">No skill set is added yet.</div>
    <?php }?>
  </div>
  
  <!-- START - Achievements Block - Dev. by Reza -->
  <div id="block-achievements">
    <div class="block-header">
      <h3>Achievements</h3>
      <a href="/achievements">View all</a> </div>
    <div class="badge-row">
    <?php
	if (!$myBadges){$myBadges=array();}
		for($i=0; $i<=7; $i++){
			if (array_key_exists($i, $myBadges)) {
	?>
      <div id="achievement-unit">
        <img src="/public/<?=$myBadges[$i]["achievement_pic"]?>" width="97" height="99" alt="<?=ucfirst(strtolower($myBadges[$i]["achievement_name"]))?>" title="<?=ucfirst(strtolower($myBadges[$i]["achievement_name"]))?>" />
      </div>
    <?php
			} else {
	?>
      <div id="achievement-unit">
        <div id="badge-unit"></div>
      </div>
    <?php
			}
		}
	?>
    </div>
  </div>
  
  <!-- START - Activities Block - Dev. by Reza -->
  
  <div id="block-activities">
    <div class="block-header">
      <h3 style="width:380px;"><?=$me["username"]?>'s Activities</h3>
      <a href="#">View all</a> </div>
      
  <div id="activities-list">
  
  <ul>
  <?php if($log){foreach($log as $event):?>
  	<li><?=$event?>.</li>
  <?php endforeach;}else{?>
  <div style="border:2px dashed #0cF; padding:18px 0; margin:0 auto; width:430px; text-align:center; color:#0cf;">No activity is recorded yet.</div>
  <?php }?>
  </ul>
  
  </div>
  
</div>



</div>
<script type="text/javascript">
$('#profile-content-area [title]').tipsy({gravity:'s', opacity:0.95});
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
