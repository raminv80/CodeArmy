<div class="tab-holder">
	<div class="tab-frame">
		<div class="content">
			<h1>History</h1>
			<?php if(!$history){?>
				<h4>You have not performed any actions.</h4>
				<?php }else{?>
				<p>User placed <?=$overview['bids']?> bids. Totaly <?=$overview['completed']?> jobs out of <?=$overview['assigned']?> assigned jobs are completed. <?php if($overview['done']>0){ echo $overview['done'];?> jobs are waiting to be verified and <?php } echo $overview['paid'];?> jobs are paid.</p>
				<table cellpadding="0" cellspacing="0" style="border:1px solid #fff;">
					<tr>
					<!--
					
					-->
						<th width="15%" style="text-align:left; padding-left:10px;">my job</th>
						<th width="10%">project name</th>
						<th width="5%">event</th>
						<th width="10%">date / time</th>
					</tr>
					<?php if($history){foreach($history as $event):?>
					<tr>
						<td style="color:rgb(143, 145, 148); text-align:left; padding-left:10px;"><a href="/story/<?=$event['work_id']?>"><?php echo $event['title'];?></a></td>
						<td><a href="/project/<?=$event['project_id']?>"><?php echo $event['project_name'];?></a></td>
						<td><?php echo $event['event'];?></td>
						<td><?php echo $event['created_at'];?></td>
					</tr>
					<?php endforeach; }?>
					
				</table>
				<?php }?>
		</div>
	</div>
</div>