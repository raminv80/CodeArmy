<?php $this->load->view('includes/header_view'); ?>

<div id="dash-wrapper">
	<div id="content">
		<?php if($have_project == true) { ?>
		<div class="admin_menu">
			<span class="button_show">
				<a href="<?php echo base_url() ?>projects" id="dashboardButton">Projects</a>
			</span>
			<span class="button_add">
				<a href="<?php echo base_url() ?>stories/create" id="dashboardButton">Create User Stories</a>
			</span>
		</div>
		<?php } ?>

		<div id="columns">
			<ul id="column1" class="column">
				<li class="widget color-red">
					<div class="widget-head">
						<h3>In Progress</h3>
					</div>
					<div class="widget-content">
			<?php //start if progress empty not true
			if($inProgress_empty != true) { ?>
			<table class="myTable1" cellpadding="0" cellpadding="0" class="listing" width="100%">
				<tr>
					<th class="" width="5%">Priority</th>
					<th class="" width="50%">User Story Title</th>
					<th class="" width="6%">Sweat Points</th>
					<th class="" width="7%">Payout</th>
					<th class="" width="1%"></th>
				</tr>
				<?php $c = count($work_list_inProgress); for($i = 0; $i < $c; $i++): ?>
				<tr class="story-title1">
					<td><?php echo $work_list_inProgress[$i]['priority'] ?></td>
					
					<td><span class="type_<?php echo $work_list_inProgress[$i]['type'] ?>">
						<?php echo $work_list_inProgress[$i]['title'] ?>
					</span>
					</td>
					<td><?php echo $work_list_inProgress[$i]['points'] ?></td>
					<td>RM <?php echo $work_list_inProgress[$i]['cost'] ?></td>
					<td>
						<div class="arrow">
						</div>
					</td>
				</tr>
				
				<tr>
					<td colspan="6" class="details">
					
						<p>
							<?php echo $work_list_inProgress[$i]['description'] ?>
						</p>
						<br />
						<a href="/story/<?php echo $work_list_inProgress[$i]['work_id'] ?>">More details</a>
					
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
			
			<table class="myTable1" cellpadding="0" cellpadding="0" class="listing" width="100%">
				<tr>
					<th class="" width="5%">Priority</th>
					<th class="" width="50%">User Story Title</th>
					<th class="" width="6%">Sweat Points</th>
					<th class="" width="7%">Payout</th>
					<th class="" width="1%"></th>
				</tr>
				
				<?php $c = count($work_list_done); for($i = 0; $i < $c; $i++): ?>
				<tr class="story-title1">
					<td><?php echo $work_list_done[$i]['priority'] ?></td>
					<td><span class="type_<?php echo $work_list_done[$i]['type'] ?>">
						<?php echo $work_list_done[$i]['title'] ?>
					</span>
					</td>
					<td><?php echo $work_list_done[$i]['points'] ?></td>
					<td>RM <?php echo $work_list_done[$i]['cost'] ?></td>
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
						<h3>Sign Off</h3>
					</div>
					<div class="widget-content">
					
			<?php //start if done empty not true
			if($signoff_empty != true) { ?>
			<table class="myTable1" cellpadding="0" cellpadding="0" class="listing" width="100%">
				<tr>
					<th class="" width="5%">Priority</th>
					<th class="" width="50%">User Story Title</th>
					<th class="" width="6%">Sweat Points</th>
					<th class="" width="7%">Payout</th>
					<th class="" width="1%"></th>
				</tr>
				<?php $c = count($work_list_signoff); for($i = 0; $i < $c; $i++): ?>
				<tr class="story-title1">
					<td><?php echo $work_list_signoff[$i]['priority'] ?></td>
					
					<td><span class="type_<?php echo $work_list_signoff[$i]['type'] ?>">
						<?php echo $work_list_signoff[$i]['title'] ?>
					</span>
					</td>
					<td><?php echo $work_list_signoff[$i]['points'] ?></td>
					<td>RM <?php echo $work_list_signoff[$i]['cost'] ?></td>
				</tr>
				<tr>
					<td colspan="6" class="details">
					<div class="test">
						<p>
							<?php echo $work_list_signoff[$i]['description'] ?>
						</p>
						<br />
						<a href="/story/<?php echo $work_list_signoff[$i]['work_id'] ?>">More details</a>
					</div>
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
	</div>
<?php $this->load->view('includes/footer_view'); ?>