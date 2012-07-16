<?php $this->load->view('includes/header_view'); ?>
		
		<div id="dash-wrapper">
			<div id="content">
			<?php if($have_project == true) { ?>
                            <div class="admin_menu">
			<span class="button_show"><a href="<?php echo base_url() ?>projects" id="dashboardButton">Projects</a></span>
			
			<span class="button_add"><a href="<?php echo base_url() ?>stories/create" id="dashboardButton">Create User Stories</a></span>
                            </div>
			<?php } ?>
                        <div id="dash_nav">
                            <a href="#" class="dash_open_button">Open</a>
                            <a href="#" class="dash_progress_button">In Progress</a>
                            <a href="#" class="dash_done_button">Done</a>
                            <a href="#" class="dash_signoff_button">Paid</a>
                        </div>
                        <div class="dash_open">
                            <h3>Open</h3>
                        <?php //start if open empty not true 
                        if($open_empty != true) { ?>
			<table id="myTable" cellpadding="0" cellpadding="0" class="listing" width="100%">
			<tr>
				<th class="" width="5%">Priority</th>
				<th class="" width="50%">Title</th>
				<th class="" width="6%">Points</th>
				<th class="" width="7%">RM Cost</th>
			</tr>
			
			<?php $c = count($work_list_open); for($i = 0; $i < $c; $i++): ?>
			
			<tr class='item'>
				<td><?php echo $work_list_open[$i]['priority'] ?></td>
				<td class="item-left"><span class="type_<?php echo $work_list_open[$i]['type'] ?>"><a href="/story/<?php echo $work_list_open[$i]['work_id'] ?>"><?php echo $work_list_open[$i]['title'] ?></a></span></td>
				<td><?php echo $work_list_open[$i]['points'] ?></td>
				<td><?php echo $work_list_open[$i]['cost'] ?></td>
			</tr>
			<tr class='details'>
				<td colspan="8">
					<div class="test">
						<p><?php echo $work_list_open[$i]['description'] ?></p><br />
						<a href="/story/<?php echo $work_list_open[$i]['work_id'] ?>">More details</a>
						<?php if($this->session->userdata('is_logged_in') == true): ?>
						<a href="/story/bid/<?php echo $work_list_open[$i]['work_id'] ?>">Bid for this story</a>
						<?php endif; ?>
					</div>
				</td>
			</tr>
				
			<?php endfor; ?>	
                        </table>
                        <?php } 
                        
                        //start else open empty not true
                        else { echo "No open stories"; } 
                        //end else open empty not true
                        ?>
                        </div>
                        
                        <div class="dash_progress">
                            <h3>In Progress</h3>
                        <?php //start if progress empty not true 
                        if($progress_empty != true) { ?>
                        <table id="myTable" cellpadding="0" cellpadding="0" class="listing" width="100%">
			<tr>
				<th class="" width="5%">Priority</th>
				<th class="" width="50%">Title</th>
				<th class="" width="6%">Points</th>
			</tr>
			
			<?php $c = count($work_list_progress); for($i = 0; $i < $c; $i++): ?>
			
			<tr class='item'>
				<td><?php echo $work_list_progress[$i]['priority'] ?></td>
				<td class="item-left"><span class="type_<?php echo $work_list_progress[$i]['type'] ?>"><a href="/story/<?php echo $work_list_progress[$i]['work_id'] ?>"><?php echo $work_list_progress[$i]['title'] ?></a></span></td>
				<td><?php echo $work_list_progress[$i]['points'] ?></td>
			</tr>
			<tr class='details'>
				<td colspan="8">
					<div class="test">
						<p><?php echo $work_list_progress[$i]['description'] ?></p><br />
						<a href="/story/<?php echo $work_list_progress[$i]['work_id'] ?>">More details</a>
						<?php if($this->session->userdata('is_logged_in') == true): ?>
						<a href="/story/bid/<?php echo $work_list_progress[$i]['work_id'] ?>">Bid for this story</a>
						<?php endif; ?>
					</div>
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
                        
                        <div class="dash_done">
                            <h3>Done</h3>
                        <?php //start if done empty not true 
                        if($done_empty != true) { ?>
                        <table id="myTable" cellpadding="0" cellpadding="0" class="listing" width="100%">
			<tr>
				<th class="" width="5%">Priority</th>
				<th class="" width="50%">Title</th>
				
				<th class="" width="6%">Points</th>
			</tr>
			
			<?php $c = count($work_list_done); for($i = 0; $i < $c; $i++): ?>
			
			<tr class='item'>
				<td><?php echo $work_list_done[$i]['priority'] ?></td>
				<td class="item-left"><span class="type_<?php echo $work_list_open[$i]['type'] ?>"><a href="/story/<?php echo $work_list_open[$i]['work_id'] ?>"><?php echo $work_list_open[$i]['title'] ?></a></span></td>
				
				<td><?php echo $work_list_done[$i]['points'] ?></td>
			</tr>
			<tr class='details'>
				<td colspan="8">
					<div class="test">
						<p><?php echo $work_list_done[$i]['description'] ?></p><br />
						<a href="/story/<?php echo $work_list_done[$i]['work_id'] ?>">More details</a>
						<?php if($this->session->userdata('is_logged_in') == true): ?>
						<a href="/story/bid/<?php echo $work_list_done[$i]['work_id'] ?>">Bid for this story</a>
						<?php endif; ?>
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
                        
                        <div class="dash_signoff"> 
                            <h3>Sign Off</h3>
                        <?php //start if done empty not true 
                        if($signoff_empty != true) { ?>
                        <table id="myTable" cellpadding="0" cellpadding="0" class="listing" width="100%">
			<tr>
				<th class="" width="5%">Priority</th>
				<th class="" width="50%">Title</th>
				
				<th class="" width="6%">Points</th>
			</tr>
			
			<?php $c = count($work_list_signoff); for($i = 0; $i < $c; $i++): ?>
			
			<tr class='item'>
				<td><?php echo $work_list_signoff[$i]['priority'] ?></td>
				<td class="item-left"><span class="type_<?php echo $work_list_open[$i]['type'] ?>"><a href="/story/<?php echo $work_list_open[$i]['work_id'] ?>"><?php echo $work_list_open[$i]['title'] ?></a></span></td>
				
				<td><?php echo $work_list_signoff[$i]['points'] ?></td>
			</tr>
			<tr class='details'>
				<td colspan="8">
					<div class="test">
						<p><?php echo $work_list_signoff[$i]['description'] ?></p><br />
						<a href="/story/<?php echo $work_list_signoff[$i]['work_id'] ?>">More details</a>
						<?php if($this->session->userdata('is_logged_in') == true): ?>
						<a href="/story/bid/<?php echo $work_list_signoff[$i]['work_id'] ?>">Bid for this story</a>
						<?php endif; ?>
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
    		</div>
    	</div>
		

	
<?php $this->load->view('includes/footer_view'); ?>