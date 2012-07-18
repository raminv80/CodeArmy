<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<!--<img src="/public/images/codeArmy/profile/temp-final.png" id="preview"/>-->

<div id="profile-content-area"> 
  
  <!-- START - Level Block - Dev. by Reza  -->
  <div id="block-level"> Level
    <?=$myLevel?>
  </div>
  
  <!-- START - Avatar Block - Dev. by Reza  -->
  <div id="block-avatar">
    <div id="profile-name"><?=$me["username"]?></div>
    <div id="msg-icon"></div>
    <div id="profile-type"><?=$myProfile["specialization"]?> &nbsp;&nbsp; [<?=$myCountry?>] </div>
    <div id="avatar-pic"> <img src="/public/images/codeArmy/profile/default-avatar.png" alt="Avatar Picture" /> </div>
    <div id="profile-desc"> </div>
  </div>
  
  <!-- Ramin: leaderboard-block 17-7-2012-->
  <div id="block-leaderboard">
    <div class="block-header">
      <h3>Leaderboard</h3>
      <a href="/leaderboard">View all</a> </div>
    <div class="block-content">
      <ul>
        <li class="leaderboard-row"> <img src="" alt="user-avatar" />
          <ul>
            <li>%Username%</li>
            <li>%Rank%</li>
          </ul>
          <div>%1000% Points</div>
        </li>
        <li class="leaderboard-row"> <img src="" alt="user-avatar" />
          <ul>
            <li>%Username%</li>
            <li>%Rank%</li>
          </ul>
          <div>%1000% Points</div>
        </li>
      </ul>
    </div>
  </div>
  <!-- Ramin:leader board bloclk end--> 
  
  <!-- START - Experience Block - Dev. by Reza -->
  <div id="block-experience">
    <div id="experience-header">
      <h3>Exp Points:<?=$me["exp"];?></h3>
    </div>
    <div id="edit-profile-link"><a href="#">Edit Profile</a></div>
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
      <a href="#">View all</a> </div>
    <?php foreach($mySkills as $skill){ ?>
    <div class="skill-unit">
      <div id="skill-title"><?=ucfirst($skill["name"])?></div>
      <div id="skill-bar">
        <div style="width:<?=$skill["point"]?>%" id="skill-bar-progress"></div>
      </div>
    </div>
    <?php } ?>
  </div>
  
  <!-- START - Achievements Block - Dev. by Reza -->
  <div id="block-achievements">
    <div class="block-header">
      <h3>Achievements</h3>
      <a href="/achievements">View all</a> </div>
    <div class="badge-row">
    <?php
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
      <h3><?=$me["username"]?>'s Activities</h3>
      <a href="#">View all</a> </div>
      
  <div id="activities-list">
  
  <ul>
  <li>Harish completed the profile and earn a newbie badge.</li>
  <li>Harish joined the CodeArmy.</li>
  </ul>
  
  </div>
</div>

</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
