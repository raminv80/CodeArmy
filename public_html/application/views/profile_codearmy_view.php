<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<!--<img src="/public/images/codeArmy/profile/temp-final.png" id="preview"/>-->

<div id="profile-content-area"> 
  
  <!-- START - Level Block -->
  <div id="block-level"> Level
    <?=$myLevel?>
  </div>
  
  <!-- START - Avatar Block -->
  <div id="block-avatar">
    <div id="profile-name"> Harish </div>
    <div id="msg-icon"></div>
    <div id="profile-type"> Web Designer &nbsp;&nbsp; [Malaysia] </div>
    <div id="avatar-pic"> <img src="/public/images/codeArmy/profile/default-avatar.png" alt="Avatar Picture" /> </div>
    <div id="profile-desc"> Hi, I'm Harish! I've been working as Web designer for the past 6 years. </div>
  </div>
  
  <!-- Ramin: leaderboard-block 17-7-2012-->
  <style>
#block-leaderboard {
	position:absolute;
	top:500px;
	left:0px;
	width:286px;
	height:263px;
	overflow:hidden;
}
.block-header h3 {
	font-size:12.96pt;
	color:white;
	font-family:'Ruda', sans-serif;
	text-shadow: 0px 0px 3px rgba(255, 255, 255, 0.5);
	display:block;
	width:229px;
	height:33px;
	float:left;
	background:url(/public/images/codeArmy/profile/block-header-line.png) no-repeat;
}
.block-header a {
	color:#CCC;
	font-size:8.99pt;
	text-decoration:underline;
	display:block;
	height:33px;
	width:57px;
	float:left;
	text-align:right;
}
</style>
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
</div>
<!-- Ramin:leader board bloclk end-->
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
