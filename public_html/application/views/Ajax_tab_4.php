<div class="tab-holder">
	<div class="tab-frame">
		<div class="content">
			<h1>MyDesk</h1>

			<div class="widget">
				<h3>In Progress</h3>
				<div class="widget-content">
					<?php //start if progress empty not true
					if($inProgress_empty != true) { ?>
					<table class="myTable" cellpadding="0" cellpadding="0" class="listing" width="100%">
						<tr>
							<th class="" width="5%">No.</th>
							<th class="" width="15%">Project</th>
							<th class="" width="50%">User Story Title</th>
							<th class="" width="10%">Sweat Points</th>
							<th class="" width="10%">Payout</th>
						</tr>
						<?php $c = count($work_list_inProgress); for($i = 0; $i < $c; $i++): ?>
						<tr class="story-title" style="background:#3C565C;">
							<td><?php echo $i+1;?></td>
							<td><?php echo $work_list_inProgress[$i]['project_name'] ?></td>
							<td style="text-align:left; padding-left:10px;">
							<span class="type_<?php echo $work_list_inProgress[$i]['type'] ?>"> <?php echo $work_list_inProgress[$i]['title'] ?> </span>
							</td>
							<td><?php echo $work_list_inProgress[$i]['points'] ?></td>
							<td>RM <?php echo $work_list_inProgress[$i]['cost'] ?></td>
						</tr>
						<tr>
							<td colspan="6" style="text-align:left; padding:10px 0 0 20px; color: rgb(143, 145, 148);">
							<p>
								<?php echo $work_list_inProgress[$i]['description'] ?>
							</p>
							<br />
							<a style="float:right; margin:-40px 10px -20px 0; font-size:0.8em; color:#82D1E5;" href="/story/<?php echo $work_list_inProgress[$i]['work_id'] ?>">More details</a>
                            <?php if((strtolower($work_list_inProgress[$i]['status'])=='in progress' || strtolower($work_list_inProgress[$i]['status'])=='redo') && $user_id==$work_list_inProgress[$i]['work_horse']){?>
                                <div id="job-done">
                                    <?php echo form_open('story/submission');?>
                                        <input type="hidden" name="id" value="<?php echo $work_list_inProgress[$i]['work_id']; ?>" />
                                        <input type="hidden" name="csrf" value="<?php echo md5('storyDone'); ?>" />
                                        <!--<input type="submit" name="submit" value="Job Done!" />-->
                                        <div class="proceed">
                                            <a href="javascript: void(0)" class="submit dialog_step3">Job Done!</a>
                                        </div>
                                    <?php echo form_close(); ?>    
                                </div>
                            <?php } ?>
							</td>
						</tr>
						<?php endfor; ?>
					</table>
					<?php }

					//start else progress empty not true
					else { echo "No in progress stories"; }
					//end else progress empty not true
					?>
				</div>
			</div>
			<div class="widget">
				<h3>Done</h3>
					<div class="widget-content">
						<?php //start if done empty not true
						if($done_empty != true) { ?>
						<table class="myTable" cellpadding="0" cellpadding="0" class="listing" width="100%">
							<tr>
								<th class="" width="5%">No.</th>
								<th class="" width="15%">Project</th>
								<th class="" width="50%">User Story Title</th>
								<th class="" width="10%">Sweat Points</th>
								<th class="" width="10%">Payout</th>
							</tr>
							<?php $c = count($work_list_done); for($i = 0; $i < $c; $i++): ?>
							<tr class="story-title" style="background:#3C565C;">
								<td><?php echo $i+1;?></td>
								<td><?php echo $work_list_done[$i]['project_name'] ?></td>
								<td style="text-align:left; padding-left:10px;">
								<span class="type_<?php echo $work_list_done[$i]['type'] ?>"> <?php echo $work_list_done[$i]['title'] ?> </span>
								</td>
								<td><?php echo $work_list_done[$i]['points'] ?></td>
								<td>RM <?php echo $work_list_done[$i]['cost'] ?></td>
							</tr>
							<tr>
								<td colspan="6" style="text-align:left; padding:10px 0 0 20px; color: rgb(143, 145, 148);">
									<p>
										<?php echo $work_list_done[$i]['description'] ?>
									</p>
									<br />
									<a style="float:right; margin:-40px 10px -20px 0; font-size:0.8em; color:#82D1E5;" href="/story/<?php echo $work_list_done[$i]['work_id'] ?>">More details</a>
								</td>
							</tr>
							<?php endfor; ?>
						</table>
						<?php }
						//start else done empty not true
						else { echo "No done stories"; }
						//end else done empty not true
						?>
					</div>
				</div>
				
				<div class="widget">
					<h3>Sign Off</h3>
					<div class="widget-content">
						<?php //start if done empty not true
						if($signoff_empty != true) { ?>
						<table class="myTable" cellpadding="0" cellpadding="0" class="listing" width="100%">
							<tr>
								<th class="" width="5%">No.</th>
								<th class="" width="15%">Project</th>
								<th class="" width="50%">User Story Title</th>
								<th class="" width="10%">Sweat Points</th>
								<th class="" width="10%">Payout</th>
							</tr>
							<?php $c = count($work_list_signoff); for($i = 0; $i < $c; $i++): ?>
							<tr class="story-title" style="background:#3C565C;">
								<td><?php echo $i+1;?></td>
								<td><?php echo $work_list_inProgress[$i]['project_name'] ?></td>
								<td style="text-align:left; padding-left:10px;">
								<span class="type_<?php echo $work_list_signoff[$i]['type'] ?>"> <?php echo $work_list_signoff[$i]['title'] ?> </span>
								</td>
								<td><?php echo $work_list_signoff[$i]['points'] ?></td>
								<td>RM <?php echo $work_list_signoff[$i]['cost'] ?></td>
							</tr>
							<tr>
								<td colspan="6" style="text-align:left; padding:10px 0 0 20px; color: rgb(143, 145, 148);">
									<p>
										<?php echo $work_list_signoff[$i]['description'] ?>
									</p>
									<br />
									<a style="float:right; margin:-40px 10px -20px 0; font-size:0.8em; color:#82D1E5;" href="/story/<?php echo $work_list_signoff[$i]['work_id'] ?>">More details</a>
								</td>
							</tr>
							<?php endfor; ?>
						</table>
						<?php }
						//start else signoff empty not true
						else { echo "No signoff stories"; }
						//end else signoff empty not true
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
    <script type="text/javascript">
	$('a.submit').click(function(){
		test = $(this);
		var form = $(this).parents('form');
		console.log(form);
		form.submit();
	});
	</script>