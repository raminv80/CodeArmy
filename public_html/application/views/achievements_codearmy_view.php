<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<div id="achievements-content-area"> 
  
  <!-- START - Mission Bid Title Block - Dev. by Reza  -->
  <div id="block-achievements-header">
    <div class="block-header">
      <h3>Your Achievements</h3>
    </div>
    <div id="achievements-header-text"> <!--Go above and beyond the call of duty to earn special awards.--></div>
  </div>
  <div id="achievements-row">
    <?php
	if ($myBadges != false){
		$i = 0;
		foreach($myBadges as $key => $value):
	?>
      <div id="achieve-unit">
        <img src="/public/<?=$value["achievement_pic"]?>" width="97" height="99" alt="<?=ucfirst(strtolower($value["achievement_name"]))?>" title="<?=ucfirst(strtolower($value["achievement_name"]))?>" />
      </div>
    <?php
			$i++;
		endforeach;
	}
	?>
  </div>
  <div id="achievements-row"> </div>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
