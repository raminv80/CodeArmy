<?php $this->load->view('includes/header_view'); ?>

<div id="dash-wrapper">
<div id="content">
  <?php if($have_project == true) { ?>
  <div class="admin_menu"> <span class="button_show"> <a href="<?php echo base_url() ?>projects" id="dashboardButton">Projects</a> </span> <span class="button_add"> <a href="<?php echo base_url() ?>stories/create" id="dashboardButton">Create User Stories</a> </span> </div>
  <?php } ?>
  <div id="columns">
 <!----------------------------------------------------------------------------------------------->   
  	<div id="story-open">
    	
  	</div>
 <!-----------------------------------------------------------------------------------------------> 
    <?php //start if open empty not true
					if($open_empty != true) { ?>
    <table class="myTable" cellpadding="0" cellpadding="0" class="listing" width="100%">
    <tr>
      <th class="" width="5%">Priority</th>
      <th style="text-align: left" class="">User Story Title</th>
      <th class="" width="10%">Bids</th>
      <th class="" width="10%">Comments</th>
      <th class="" width="10%">Sweat Points</th>
      <th class="" width="15%">Payout</th>
      <th class="" width="1%"></th>
    </tr>
    <?php $c = count($work_list_open); for($i = 0; $i < $c; $i++): ?>
    <tr class="story-title <?php if($i%2){ ?>odd-row<?php }else{?>even-row<?php } ?>">
      <td><?php echo $work_list_open[$i]['priority'] ?></td>
      <td><span class="type_<?php echo $work_list_open[$i]['type'] ?>"> <?php echo $work_list_open[$i]['title'] ?></a> </span></td>
      <td style="text-align:right"><?php if($work_list_open[$i]['last_week_bids']>=1){?>
        <img src="<?php echo base_url() ?>public/images/fire.png" alt="Hot zone!" style="margin:0; padding:0; border:none; float:left" />
        <?php } ?>
        <?php echo $work_list_open[$i]['total_bids']; ?></td>
      <td style="text-align:right"><?php if($work_list_open[$i]['last_week_comments']>=1){?>
        <img src="<?php echo base_url() ?>public/images/fire.png" alt="Hot zone!" style="margin:0; padding:0; border:none; float:left" />
        <?php } ?>
        <?php echo $work_list_open[$i]['total_comments'];?></td>
      <td><div class="sweat-shirt-<?php echo points_size($work_list_open[$i]['points']) ?>">
        <?php echo $work_list_open[$i]['points'] ?></td>
  </div>
  <td style="text-align: right"> RM <?php echo number_format($work_list_open[$i]['cost']) ?></td>
  <td><div class="arrow"> </div></td>
  </tr>
  <tr>
    <td colspan="7" class="details"><p> <?php echo $work_list_open[$i]['description'] ?> </p>
      <br />
      <a class="" href="/story/<?php echo $work_list_open[$i]['work_id'] ?>">More details</a>
      <?php if($this->session->userdata('is_logged_in') == true): ?>
      <input type="button" onclick="window.location='/story/bid/<?php echo $work_list_open[$i]['work_id'] ?>'" name="submit" value="Bid for this" />
      <?php endif; ?></td>
  </tr>
  <?php endfor; ?>
  </table>
  <?php }

						//start else open empty not true
						else { echo "No open stories"; }
						//end else open empty not true
						?>
  <?php /*				<li class="widget color-red">
					<div class="widget-head">
						<h3>In progress</h3>
					</div>
					<div class="widget-content">
						<?php //start if progress empty not true
						if($progress_empty != true) { ?>
						<table class="myTable" cellpadding="0" cellpadding="0" class="listing" width="100%">
							<tr>
								<th class="" width="5%">Priority</th>
								<th class="" width="50%">Title</th>
                                <th class="" width="15%">Warrior</th>
								<th class="" width="15%">Sweat Points</th>
								<th class="" width="12%">Payout</th>
								<th class="" width="1%"></th>
							</tr>
							<?php $c = count($work_list_progress); for($i = 0; $i < $c; $i++): ?>
							<tr class="story-title <?php if($i%2){ ?>odd-row<?php }else{?>even-row<?php } ?>">
								<td><?php echo $work_list_progress[$i]['priority'] ?></td>
								<td>
								<span class="type_<?php echo $work_list_progress[$i]['type'] ?>">
									<?php echo $work_list_progress[$i]['title'] ?></a>
								</span>
								</td>
                                <td><?php echo get_rank($work_list_progress[$i]['work_horse']);?></td>
								<td>
								<div class="sweat-shirt-<?php echo points_size($work_list_progress[$i]['points']) ?>">
									<?php echo $work_list_progress[$i]['points'] ?></td>
								</div>
								<td style="text-align: right"> RM <?php echo number_format($work_list_progress[$i]['cost']) ?></td>
								<td>
								<div class="arrow">
								</div>
								</td>
							</tr>
							
							<tr>
								<td colspan="6" class="details" >
								
									<p>
										<?php echo $work_list_progress[$i]['description'] ?>
									</p>
									<br />
									<a href="/story/<?php echo $work_list_progress[$i]['work_id'] ?>">More details</a>
								
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
				</li>
				<li class="widget color-yellow">
					<div class="widget-head">
						<h3>Done</h3>
					</div>
					<div class="widget-content">
						<?php //start if done empty not true
						if($done_empty != true) { ?>
						<table class="myTable" cellpadding="0" cellpadding="0" class="listing" width="100%">
							<tr>
								<th class="" width="5%">Priority</th>
								<th class="" width="50%">Title</th>
                                <th class="" width="15%">Warrior</th>
								<th class="" width="15%">Sweat Points</th>
								<th class="" width="12%">Payout</th>
								<th class="" width="1%"></th>
							</tr>
							<?php $c = count($work_list_done); for($i = 0; $i < $c; $i++): ?>
							<tr class="story-title <?php if($i%2){ ?>odd-row<?php }else{?>even-row<?php } ?>">
								<td><?php echo $work_list_done[$i]['priority'] ?></td>
								<td>
								<span class="type_<?php echo $work_list_done[$i]['type'] ?>">
									<?php echo $work_list_done[$i]['title'] ?></a>
								</span>
								</td>
                                <td><?php echo get_rank($work_list_done[$i]['work_horse']);?></td>
								<td>
								<div class="sweat-shirt-<?php echo points_size($work_list_done[$i]['points']) ?>">
									<?php echo $work_list_done[$i]['points'] ?></td>
								</div>
								<td style="text-align: right"> RM <?php echo number_format($work_list_done[$i]['cost']) ?></td>
								<td>
								<div class="arrow">
								</div>
								</td>
							</tr>
							<tr>
								<td colspan="6" class="details">
								<div>
									<p>
										<?php echo $work_list_done[$i]['description'] ?>
									</p>
									<br />
									<a href="/story/<?php echo $work_list_done[$i]['work_id'] ?>">More details</a>
									<?php if($have_project == true) { ?>
									<?php if($work_list_done[$i]['status'] == 'Done' || $work_list_done[$i]['status'] == 'Redo') { ?>
									<?php if($this->session->userdata('is_logged_in') == true): ?>
									<a href="/story/verify/<?php echo $work_list_done[$i]['work_id'] ?>">Verfy</a>
									<?php endif; ?>
									<?php if($this->session->userdata('is_logged_in') == true): ?>
									<a href="/story/redo/<?php echo $work_list_done[$i]['work_id'] ?>">Redo</a>
									<?php endif; ?>
									<?php } ?>
									<?php if(strtolower($work_list_done[$i]['status']) == 'verify') { ?>
									<?php if($this->session->userdata('is_logged_in') == true): ?>
									<a href="/story/signoff/<?php echo $work_list_done[$i]['work_id'] ?>">Sign off</a>
									<?php endif; ?>
									<?php if($this->session->userdata('is_logged_in') == true): ?>
									<a href="/story/reject/<?php echo $work_list_done[$i]['work_id'] ?>">Reject</a>
									<?php endif; ?>
									<?php } ?>
									<?php } ?>
								</div>
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
				</li>
				<li class="widget color-blue">
					<div class="widget-head">
						<h3>Paid</h3>
					</div>
					<div class="widget-content">
						<?php //start if done empty not true
						if($signoff_empty != true) { ?>
						<table class="myTable" cellpadding="0" cellpadding="0" class="listing" width="100%">
							<tr>
								<th class="" width="5%">Priority</th>
								<th class="" width="50%">Title</th>
                                <th class="" width="15%">Warrior</th>
								<th class="" width="15%">Sweat Points</th>
								<th class="" width="12%">Payout</th>
								<th class="" width="1%"></th>
							</tr>
							<?php $c = count($work_list_signoff); for($i = 0; $i < $c; $i++): ?>
							<tr class="story-title <?php if($i%2){ ?>odd-row<?php }else{?>even-row<?php } ?>">
								<td><?php echo $work_list_signoff[$i]['priority'] ?></td>
								<td>
								<span class="type_<?php echo $work_list_signoff[$i]['type'] ?>">
									<?php echo $work_list_signoff[$i]['title'] ?></a>
								</span>
								</td>
                                <td><?php echo get_rank($work_list_done[$i]['work_horse']);?></td>
								<td>
								<div class="sweat-shirt-<?php echo points_size($work_list_signoff[$i]['points']) ?>">
									<?php echo $work_list_signoff[$i]['points'] ?></td>
								</div>
								<td style="text-align: right"> RM <?php echo number_format($work_list_signoff[$i]['cost']) ?></td>
								<td>
								<div class="arrow">
								</div>
								</td>
							</tr>
							<tr>
								<td colspan="6" class="details">
									<p>
										<?php echo $work_list_signoff[$i]['description'] ?>
									</p>
									<br />
									<a href="/story/<?php echo $work_list_signoff[$i]['work_id'] ?>">More details</a>
								
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
				</li>
			</ul>
		</div>
		*/ ?>
</div>
<?php $this->load->view('includes/footer_view'); ?>
