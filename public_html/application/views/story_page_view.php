<?php /*
	<?php $this->load->view('includes/header_view'); ?>

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
            	<th>Category</th>
                <td><?php echo $work_data['category_name'];?></td>
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
			<div class="id"><?php echo $work_data['project_name']; ?></div>
			
			<table border-collapse="collapse" >
				<tr>
					<th>Type</th>
					<th>Sweat Points</th>
					<th>Payout</th>
					<th>Status</th>
				</tr>
				
				<tr>
					<td><?php echo $work_data['type']; ?></td>
					<td><img style="padding-right: 10px" src="/public/<?php echo base_url() ?>public/images/sweat_shirt-<?php echo points_size($work_data['points']) ?>.png" /> <?php echo $work_data['points']; ?></td>
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
			<th width="24%">Payout Bid</th>
			<th width="14%">Days</th>
			<th width="17%">Action</th>
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

<div id="skills">
	<h3>Skills</h3>
    <ul>
    	<?php foreach($skills as $skill):?>
    	<li><?php echo $skill['name'];?>, difficulty = <?php echo $skill['point'];?></li>
        <?php endforeach;?>
    </ul>
</div> <!-- end of skills-->

</div>	
	
	<!-- story details container ends -->

<?php $this->load->view('includes/footer_view'); ?>

*/?>
<?php $this->load->view('includes/header'); ?>
<div id="wrapper">
	<div class="contents">
					<div id="story-tutorials">
                    	<h1>Tutorials</h1>
                        <?php 
						if($work_data['tutorial']){
							echo $work_data['tutorial'];
                        }else{
                        	$this->load->view('includes/def_tutorial');
                        }?>
					</div><!--End of the Story Tutorials -->
					<div id="story-details">
						<table cellpadding="" cellspacing="">
							<tr>
								<th colspan="2" width="440px">
									<h1><a class="dialog_opt2" target="_blank" href="/project/<?php echo $work_data['project_id'];?>"><?php echo $work_data['project_name']?></a></h1>
                                    <!--<h2>Status: <?php echo $work_data['status']?></h2>-->
								</th>
								<th width="250px" style="text-align:right;">
									<span style="color:#38de4b; font-weight:normal;">Story creator</span>
									<br />
									<span style="color:#8d8d8d;"><?php echo $work_data['username']; ?></span>
								</th>
							</tr>
							<tr style="border-bottom: 1px solid #23252A;">
								<td colspan="2">user story</td>
								<td style="text-align:right; color:#bbbbbb;"><?php echo $work_data['title']; ?></td>
							</tr>
							<tr style="border-bottom: 1px solid #23252A;">
								<td colspan="2">payout</td>
								<td style="text-align:right; color:#bbbbbb;">rm<?php echo $work_data['cost']; ?></td>
							</tr>
							<tr style="border-bottom: 1px solid #23252A;">
								<td colspan="2">points gained</td>
								<td style="text-align:right; color:#bbbbbb;">+<?php echo $work_data['points']; ?></td>
							</tr>
							<tr>
								<td colspan="2">
									description
									<br />
									<span style="text-transform:lowercase; color:#8f9194;"><?php echo $work_data['description']; ?></span>
								</td>
								<td>
									skills requirement
									<br />
									<span style="margin:5px 0 0 8px; display:block;">
										<ul>
											<?php foreach($skills as $skill):?>
                                            <li><?php echo $skill['name'];?></li>
                                            <?php endforeach;?>
                                        </ul>
									</span>
								</td>
							</tr>
							<tr style="border-bottom: 1px solid #23252A;">
								
								<td style="color:#ff0000;" colspan="3">
									Deadline
									<br />
									<?php echo $work_data['deadline'];?>
								</td>
							</tr>
                            <?php if(in_array(strtolower($work_data['status']),array('done','redo','verify','signoff'))){?>
                            <?php if($work_data['attach']||$work_data['link']){?>
							<tr>
								<td colspan="2">Submited file</td>
								<td style="float:right;">
                                	<?php $inf = pathinfo($work_data['attach']);if(strtolower($inf['extension'])=='zip'){?>
									<a href="<?php echo base_url().$work_data['attach'];?>"><img src="<?php echo base_url() ?>public/images/zip.png" border="0"></a>
                                    <?php }else{?>
                                    <a target="_blank" href="<?php echo base_url().$work_data['attach'];?>"><img width="48" height="48" src="<?php echo base_url().$work_data['attach'];?>" border="0"></a>	
                                    <?php }?>
                                    <?php if($work_data['link']){?>
                                    <a target="_blank" href="<?php echo $work_data['link'];?>"><img src="<?php echo base_url() ?>public/images/download_file.png" border="0" /></a>
                                    <?php }?>
<!--
									<div class="download">
										<a href="">Download All</a>
									</div>-->
								</td>
							</tr>
                            <?php }if($work_data['git'] && trim($work_data['git'])!=''){?>
                            <tr style="text-transform:none;">
								<td colspan="2">Development (Forked) GIT Repository</td>
								<td style="float:right;">
                                	<a target="_blank" href="<?php echo $work_data['git'];?>"><?php echo $work_data['git'];?></a>
								</td>
							</tr>
                            <?php }?>
                            <?php }?>
						</table>
					</div><!--End of the Story Details -->

					
					
                    <?php 
					//show only if story is open for bidding and user i slogged in
					if(in_array($work_data['status'],array('open','Open','reject','Reject'))){
					?>
					<div id="story-bidding">
                    	<?php if($this->session->userdata('user_id')) echo form_open('story/setbid'); ?>
                        <?php
							$msg = $this->session->flashdata('bid_message');
							if($msg){
								?>
                        <div class="" style="margin:10px; color:#F90;">
                        	<?php echo $msg;?>
                        </div>
                        <?php }?>
						<div class="biding-amount">
							<h3>my bid amount for this story is</h3>
							<span>
								RM
                                <input type="text" size="4" name="set_cost" value="<?php echo $work_data['cost']; ?>" id="set_cost" class="text" />
							</span>
						</div>
						<div class="bidding-duration">
							<h3>The number of days I commit to complete this story</h3>
							<span>
                                <input type="text" size="4" name="set_days" id="set_days" class="text" value="<?php $days = ($work_data['deadline'])? round((strtotime($work_data['deadline']) - strtotime(date("Y-m-d"))) / (60 * 60 * 24)) : 1; if($days<1)$days=1; echo $days?>"/>
								days
							</span>
						</div>
                        <input type="hidden" name="work_id" value="<?php echo $work_data['work_id'];?>" />
						<input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>" id="user_id">
                        <?php if($this->session->userdata('user_id')){?>
                       		<div class="proceed">
								<a href="javascript: void(0)" class="submit dialog_step2" style="margin-top:50px;">Bid!</a>
							</div>
                        <?php }else{?>
		                	<div class="proceed">
								<a href="/login" style="margin-top:50px;">Login to Bid!</a>
							</div>
                        <?php } ?>
                        <?php if($this->session->userdata('user_id')) echo form_close(); ?>
					</div><!--End of the Story Bidding -->
					<?php }else{ // Story is not open for bidding?>
                    	<?php if($this->session->userdata('user_id') == $work_data['work_horse'] and in_array(strtolower($work_data['status']),array('in progress','redo'))){ //Current viewer is work horse of this story ?>
                        	<!--TODO: show a time tarcker-->
                            <div id="story-bidding">
                                <div class="biding-amount">
                                	<div>
                                    	<ul style="padding-bottom:30px;">
                                        <li><div><h3>Job status:</h3>
                                    	<span><?php echo $work_data['status'];?></span></div></li>                                     
                                        <li><div><h3>Champion:</h3>
                                    	<span>123<?php echo $work_horse['username'];?></span></div></li>
                                     	</ul>
                                    </div>
                                    <div>
                                    <?php if((strtolower($work_data['status'])=='in progress' || strtolower($work_data['status'])=='redo') && $is_my_work){?>
                                        <div id="job-done">
                                            <?php echo form_open('story/submission');?>
                                                <input type="hidden" name="id" value="<?php echo $work_data['work_id']; ?>" />
                                                <input type="hidden" name="csrf" value="<?php echo md5('storyDone'); ?>" />
                                                <!--<input type="submit" name="submit" value="Job Done!" />-->
                                                <div class="proceed">
													<a href="javascript: void(0)" class="submit dialog_step3">Job Done!</a>
												</div>
                                            <?php echo form_close(); ?>    
                                        </div>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php }else{?>
                        	<div id="story-bidding" style="background:none;">
                            	<?php //the viewer has no rights except viweing details of story?>
                                <!--TODO: show time tracker-->
                                <div class="biding-amount">
                                <table cellpadding="0" cellspacing="0">
                                	<tr>
                                		<th>Job status</th>
                                		<th>Champion</th>
                                		<th>Done At</th>
                                	</tr>
                                	<tr>
                                		<td><?php echo $work_data['status'];?></td>
                                		<td><?php echo $work_horse['username'];?></td>
                                		<td><?php echo $work_data['done_at'];?></td>
                                	</tr>
                                </table>
                                </div>
                            </div>
                        <?php }?>
                    <?php }?>
                    
                    <?php if(isset($username))if($this->session->userdata['role'] == 'admin'){ ?>
                    <!-- bid admin tools -->
                    <div id="story-bidding" style="background:rgba(0, 0, 0, 0.4);">
                      <div id="bidding-amount">
                        <div id="bidding" style="color:#CCC">
                        	<div id="bid">
                                <ul>
                                	<li><a href="/story/edit/<?php echo $work_data['work_id'];?>">Edit Story</a></li>
                                    <li><a href="/story/dashboard">Dashboard</a></li>
                                </ul>
                                <h1 style="">Bidding administration</h1>
                                <table style="font-size:12px; border:none; margin-top:10px;" cellspacing="3px" cellspacing="3px" width="100%">
                                  <tr>
                                    <th align="center" width="45%" style="border:none;">Warrior</th>
                                    <th align="center" width="24%">Payout Bid</th>
                                    <th align="center" width="14%">Days</th>
                                    <th align="center" width="17%">Action</th>
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
                    </div>
                    <!--end of bid-admin tools-->
                    <?php }?>
                    
					<div id="story-discussion">
						<h1>Discuss</h1>
                        <?php if($this->session->userdata('is_logged_in') == true) {?>
						<div class="discussions">
                        	<?php 
								if($this->session->userdata('role')=='admin' || $this->session->userdata('user_id')==$work_data['work_horse']){
								echo form_open_multipart('story/comments');
							?>
                            	<div id="attach" style="margin: 0 0 10px 20px;">
								<label for="file">Attach a file <span style="color:#CCC; font-size:10px" class="hint">(only zip or image less than 10MB)</span>:</label>
                                <input type="file" name="userfile" class="fileUpload" style="color:white" >
                                <input type="hidden" value="has_file" name="has_file" />
                                </div>
                            <?php }else echo form_open('story/comments');?>
							<textarea name="comments" id="comments" class="" style=""></textarea>
                            <input type="hidden" value="<?php echo $work_data['work_id']; ?>" name="story_id">
							<input type="hidden" value="<?php echo $this->session->userdata('username'); ?>" name="user_id">
							<div class="submit">
								<a href="javascript: void(0)" class="submit">Submit comment</a>
							</div>

                            <?php echo form_close(); ?>
						</div>
                        <?php }else{?>
                         <div class="discussions-area">
                        	<div id="ds-left">
								<div class="ds-avatar">
								</div>
								<div class="ds-info">
									Admin
									<br />
									<span>Administrator</span>
								</div>
							</div>
							<div id="ds-right">
								<div class="ds-comment">
									You must <a href="/login" style="color:#09F">login</a> first to leave comments.
								</div>
								<div class="ds-posted">
									posted at <?php echo date('j M Y'); ?>
								</div>
							</div>
							<img src="<?php echo base_url() ?>public/images/cm-divider.png">
                          </div>
                        <?php }?>
						<div class="discussions-area">
                        	<?php if(isset($comments))foreach($comments as $comment) { ?>
                            <div class="comment <?php if($this->session->userdata('username')==strtolower($comment['username']))echo 'my-comment';?>">
							<div id="ds-left">
								<div class="ds-avatar">
                                <?php if($comment['avatar']){?><img style="margin:0" width="40px" height="40px" src="/public/<?php echo $comment['avatar'];?>" /><?php }?>
								</div>
								<div class="ds-info">
									<?php echo $comment['username']; ?>
									<br />
									<span><?php if(strcasecmp($work_data['username'],$comment['username'])==0){?>product owner<?php }?></span>
								</div>
							</div>
							<div id="ds-right">
								<div class="ds-comment">
									<?php echo $comment['comment_body']; ?>
								</div>
								<div class="ds-posted">
									posted at <?php echo date('j M Y', strtotime($comment['comment_created'])); ?>
								</div>
                                <?php if($comment['comment_file']):?>
                                <div class="ds-posted" style="margin-right:30px">
                                	<a href="/<?php echo $comment['comment_file'];?>">download attached</a>
                                </div>
                                <?php endif;?>
							</div>
							<img src="<?php echo base_url() ?>public/images/cm-divider.png">
                            </div>
                            <?php } ?>
						</div>
                        
					</div><!--End of the Story Discussion -->
	</div>
</div>					
<?php $this->load->view('includes/footer'); ?>