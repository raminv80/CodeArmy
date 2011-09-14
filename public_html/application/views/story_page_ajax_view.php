	<?php //$this->load->view('includes/header_view'); ?>

	<!-- story details container start -->
	<div id="story-wrapper">
	<div id="content">
	<div class="story-header-<?php echo get_status_class(strtolower($work_data['status']));?>">
    <h2>#<?php echo $work_data['work_id']; ?> - <?php echo $work_data['title']; ?></h2>
    </div>
    <?php if((strtolower($work_data['status'])=='in progress' || strtolower($work_data['status'])=='redo') && $is_my_work){?>
    <div id="job-done">
		<?php echo form_open('story/done');?>
            <input type="hidden" name="id" value="<?php echo $work_data['work_id']; ?>" />
            <input type="hidden" name="csrf" value="<?php echo md5('storyDone'); ?>" />
            <input type="submit" name="submit" value="Job Done!" />
        <?php echo form_close(); ?>    
    </div>
    <?php } ?>

    <?php if((strtolower($work_data['status'])=='open' || strtolower($work_data['status'])=='reject')){?>
    <div id="job-bid">
		<input type="button" onclick="window.location='/story/bid/<?php echo $work_data['work_id'] ?>'" name="submit" value="Bid for this job" />
    </div>
    <?php } ?>
    
		<div id="left-content">
		<table>
			<tr>
				<th>Story Creator</th>
				<td><?php echo $work_data['username']; ?></td>
			</tr>
			<tr>
				<th>Product Owner</th>
				<td><?php echo $work_data['username']; ?></td>
			</tr>
			<tr>
				<th colspan="2">Description</th>
			</tr>
			<tr>
				<td colspan="2"><?php echo $work_data['description']; ?></td>
			</tr>
		</table>
            
		  
		
        <div id="comments-container">
<h3>Comments</h3>
	<?php if($this->session->userdata('is_logged_in') == true) { ?>
	<div id="comments_form">
		<?php echo form_open('story/comments');?>
			<dl>
				<dt><label for="comments"></dt><dd><textarea name="comments" id="comments"></textarea></dd>
				<input type="hidden" value="<?php echo $work_data['work_id']; ?>" name="story_id">
				<input type="hidden" value="<?php echo $this->session->userdata('username'); ?>" name="user_id">
				<input class="submitButton" type="submit" value="Submit" name="submit2" />
			</dl>		
		<?php echo form_close(); ?>
	</div>
	<?php } ?>
	
	<div id="comments_block">
	
	<?php if(isset($comments)) { ?>
	<div id="comments">
		<?php foreach($comments as $comment) { ?>		
			<article>
			<div class="comment-user">
			<p class="comment"><?php echo $comment['comment_body']; ?></p>
			<p class="user">By <?php echo $comment['username']; ?>, posted at <?php echo date('j M Y', strtotime($comment['comment_created'])); ?></p>
			</div>
			</article>
		<?php } ?>
	</div>
	<?php } ?>
	
	</div>
	</div>


</div>
		
		<div id="right-content">
			<div class="id"><?php echo $project['project_name']; ?></div>
			
			<table border-collapse="collapse" >
				<tr>
					<th>Type</th>
					<th>Sweat Points</th>
					<th>Payout</th>
					<th>Status</th>
				</tr>
				
				<tr>
					<td><?php echo $work_data['type']; ?></td>
					<td><img style="padding-right: 10px" src="/public/images/sweat_shirt-<?php echo points_size($work_data['points']) ?>.png" /> <?php echo $work_data['points']; ?></td>
					<td>RM <?php echo $work_data['cost']; ?></td>
					<td><?php echo $work_data['status']; ?></td>
				</tr>
				
			</table>
                    
            <?php if($work_data['username'] == $this->session->userdata('username')) { ?>
			
			<?php if(isset($file_upload_error)) { ?>
				
			<!-- error container start -->
			<div>
				<?php echo $file_upload_error['error']; ?>
			</div>
			<!-- error container ends -->
			
			<?php } ?>

<div id="attach_file">	
			<h3>Attach Files</h3>
		
			<?php echo form_open_multipart('story/do_upload');?>
				
			<input type="file" name="userfile" size="20" />	
			<div>
				<label for="file_title">File title</label>
				<input type="text" name="file_title" value="" id="file_title" />
			</div>
			<div>
				<label for="file_description">File description</label>
				<textarea name="file_description" rows="8" cols="30"></textarea>
			</div>
			<input type="hidden" name="work_id" value="<?php echo $work_data['work_id']; ?>" />
			<input type="submit" value="upload" />
			
			<?php echo form_close(); ?>
</div>
		
		<?php } ?>

<?php if(isset($files_data)): ?>
        
        <table>
        
        <tr>
			<th width="30%">Filename</th>
			<th width="50%">Description</th>
			<th width="10%">Action</th>
		</tr>
		<?php $c = count($files_data); for($i = 0; $i < $c; $i++): ?>
		
		<!--<div id="story_upload_wrapper">-->
			<tr>
				<td><a href="/uploads/<?php echo $files_data[$i]['file_name']; ?>" target="_new">
				<?php 	
					if($files_data[$i]['file_title'] == null) {
						echo $files_data[$i]['file_name'];
					} else {
						echo $files_data[$i]['file_title'];
					}
				?>
			</a></td>
				<td><?php echo $files_data[$i]['file_description']; ?></td>
				<td><a href="/story/file_delete/<?php echo $files_data[$i]['file_id']; ?>">Delete</a></td>
			</tr>
		
		<?php endfor; ?>
        </table>
       
	<?php endif; ?>
	<!-- story uploaded file list end -->                          
  
  
  

<div id="bid">
        <h3>Bids</h3>
        <table>
          <tr>
            <th width="45%">Warrior</th>
            <th width="20%">Payout Bid</th>
            <th width="15%">Days</th>
            <th width="20%">Action</th>
          </tr>
          
      <?php if($show_bid == true) { ?>      
          <?php foreach($bid_data as $bid) { ?>
          <tr>
            <td><?php echo get_rank($bid['user_id']);?></td>
            <td>RM <?php echo $bid['bid_cost']; ?></td>
            <td><?php echo $bid['days']; ?></td>
            <td><?php if($bid['bid_status'] == "Bid") { ?>
              	<?php if(strtolower($bid['work_status'])=='open' || strtolower($bid['work_status'])=='reject') {?><a href="/story/bid_accept/<?php echo $bid["bid_id"]; ?>">Accept</a><?php }else{?>No action <?php }?>
              <?php } else { echo $bid['bid_status']; } ?>
            </td>
          </tr>
          <?php } ?>
      <?php }else{ ?>
        <?php foreach($bid_data as $bid) if($bid['user_id'] == $userid){ ?>
        <tr>
          <td><?php echo get_rank($bid['user_id']);?></td>
          <td>RM <?php echo $bid['bid_cost']; ?></td>
          <td><?php echo $bid['days']; ?></td>
          <td><?php if($bid['bid_status'] == "Bid") { ?>Bid
            <?php } else { echo $bid['bid_status']; } ?>
          </td>
        </tr>
        <?php } ?>
      <?php } ?>
        </table>
    </div>

</div>		
</div>	
	<!-- story details container ends -->

<?php //$this->load->view('includes/footer_view'); ?>