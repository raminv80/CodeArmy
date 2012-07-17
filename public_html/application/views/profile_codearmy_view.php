<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<!--<img src="/public/images/codeArmy/profile/temp-final.png" id="preview"/>-->

<div id="profile-content-area"> 
  
  <!-- START - Level Block - Dev. by Reza  -->
  <div id="block-level"> Level
    <?=$myLevel?>
  </div>
  
  <!-- START - Avatar Block - Dev. by Reza  -->
  <div id="block-avatar">
    <div id="profile-name"> Harish </div>
    <div id="msg-icon"></div>
    <div id="profile-type"> Web Designer &nbsp;&nbsp; [Malaysia] </div>
    <div id="avatar-pic"> <img src="/public/images/codeArmy/profile/default-avatar.png" alt="Avatar Picture" /> </div>
    <div id="profile-desc"> Hi, I'm Harish! I've been working as Web designer for the past 6 years. </div>
  </div>
  
  <!-- Ramin: leaderboard-block 17-7-2012-->
  <div id="block-leaderboard">
    <div class="block-header">
      <h3>Leaderboard</h3>
      <a href="#">View all</a> </div>
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
      <h3>Exp Points:1100</h3>
    </div>
    <div id="edit-profile-link"><a href="#">Edit Profile</a></div>
    <div id="experience-bar">
      <div id="bar-progress"> </div>
    </div>
  </div>
  
  <!-- START - Experience Block - Dev. by Reza -->
  <div class="block-mission-info">
    <div id="mission-bid">
      <div id="mission-bid-text">Mission Bid</div>
      <div id="mission-bid-number">0</div>
    </div>
    <div id="mission-complete">
      <div id="mission-complete-text">Mission Complete</div>
      <div id="mission-complete-number">0</div>
    </div>
  </div>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
