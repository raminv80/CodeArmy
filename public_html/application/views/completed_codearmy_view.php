<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<div class="container-fluid">
	<div class="row-fluid">
		
		<!-- Page start -->
		<div class="completed-mission-container span10 offset1">
		  <div class="block-header">
		    <h3>Completed Missions</h3>
		  </div>
		  <div class="completed-missions-table">

		    <table border="1" cellspacing="0" cellpadding="0">
		      <?php foreach($missions as $i=>$mission):
			  	$work_id = $mission['work_id'];
			  	$hours = $this->work_model->mission_completed_hours($work_id);
				$arrangement_type = $this->work_model->get_work_arrangement($work_id);
				$arrangement = $this->work_model->get_actual_work_time_cost($work_id);
			  ?>
		      <tr>
		        <td><div class="row-no"><?=$i+1?></div>
		          <div class="com-mission-info">
		            <div class="com-mission-title"><?=$mission['title']?></div>
		            <div class="com-mission-date">Done at <?=date('jth M Y',strtotime($mission['done_at']))?></div>
		            <div class="com-mission-desc"><a href="/missions/wall/<?=$mission['work_id']?>">Mission details...</a></div>
		          </div></td>
		        <td><div class="com-mission-review">Review</div>
		          <div class="com-mission-from">From Commander</div>
		          <div class="com-mission-rev-text">"Nice Work"</div></td>
		        <td><div class="com-mission-pay-title">Payout Details</div>
		          <div class="com-mission-pay-method">Manual</div>
		          <div class="com-mission-pay-amount">$ <?=$arrangement['bid_cost']*$arrangement['bid_time']?> for <?=$arrangement['bid_time']?> <?=str_replace('dai','day',substr($arrangement_type,0,-2))?>s</div></td>
		      </tr>
		      <?php endforeach;?>
		    </table>
		  </div>
		</div>
		<!-- Page ends -->
		
	</div>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
