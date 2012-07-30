<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<div id="leaderboard-content-area"> 
  
  <!-- START - Mission Bid Title Block - Dev. by Reza  -->
  <div id="block-leaderboard-header">
    <div class="block-header">
      <h3>Leaderboard</h3>
    </div>
    <div id="leaderboard-header-text"> Go above and beyond the call of duty to earn special awards.</div>
  </div>
  <div id="leaderboard-cols">
    <div id="leaderboard-left-col">
      <div id="col-title"> Top 10 </div>
      <div id="col-content">
        <ul>
      	<?php if($leaderboard_points){
			foreach($leaderboard_points as $i=>$leader):
		?>
          <li>
          <div class="li-number"><?=$i+1?>.</div>
            <div id="col-li">
              <div id="col-li-left"><img src="<?=($leader["avatar"] != NULL)?'/public/'.$leader["avatar"]:'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $leader['email'] ) ) )?>" width="34" height="35" /></div>
              <div id="col-li-right"><span id="name"><?=ucfirst($leader["username"])?></span> <br />
                <span id="level"><?=$leader["rank"]?></span> <br />
                <span id="points"><?=$leader["exp"]?> Points</span></div>
            </div>
          </li>
        <?php
			endforeach;
		}
		?>
        </ul>
      </div>
      <div id="col-footer"> </div>
    </div>
    <div id="leaderboard-right-col">
      <div id="col-title"> Your position </div>
      <div id="col-content">
        <ul>
      	<?php if($leaderboard_centered){
			foreach($leaderboard_centered as $leaderc):
		?>
          <li>
          	<div class="li-number"><?=$leaderc['position']+1?>.</div>
            <div id="col-li">
              <div id="col-li-left"><img src="<?=($leaderc["avatar"] != NULL)?'/public/'.$leaderc["avatar"]:'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $leaderc['email'] ) ) )?>" width="34" height="35" /></div>
              <div id="col-li-right"><span id="name"><?=ucfirst($leaderc["username"])?></span> <br />
                <span id="level"><?=$leaderc["rank"]?></span> <br />
                <span id="points"><?=$leaderc["exp"]?> Points</span></div>
            </div>
          </li>
        <?php
			endforeach;
		}
		?>
        </ul>
      </div>
      <div id="col-footer"> </div>
    </div>
  </div>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
