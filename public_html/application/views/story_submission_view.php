<?php $this->load->view('includes/header'); ?>
<div id="wrapper">
	<div class="contents">
				<div id="story-details">
						<table cellpadding="" cellspacing="">
							<tr>
								<th colspan="2" width="440px">
									<h1><?php echo $work_data['project_name'];?></h1>
								</th>
								<th width="250px" style="text-align:right;">
									<span style="color:#38de4b; font-weight:normal;">product owner</span>
									<br />
									<span style="color:#8d8d8d;"><?php echo $work_data['username'];?></span>
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
						</table>
					</div><!--End of the Story Details -->
					
                    <?php echo form_open_multipart('story/done', array('id'=>'submit_form'));?>
					<div id="attachments">
                        <!-- TODO: attachment to submission -->
						<div class="attachments-area">
							<h4>attachments</h4>
                            <ul>
                                <!--<li><label for="attach">Attach a file (.zip &lt;50mb)</label><input name="attach" type="file" class="upload" /></li>-->
                                <div>
								<?php if(isset($error)) {?>
                                		<div class="error">
                                			<?php foreach($error as $msg){echo "<li>".$msg."</li>";}?>
                                		</div>
                            	<?php }?>
								</div>
                                <li><label for="git">Define GIT repo.</label><input type="text" name="git" /></li>
                                <li><label for="link">Or define the link to files</label><input type="text" name="link" /></li>
                                <li><label>Or upload a .ZIP file</label><input id="file_upload" name="file_upload" type="file" /></li>
                            </ul>
						</div>
                        <!----->
						<div class="secure-area" align="center">
							<img src="/public/images/lock.png">
							<h1>You are on a secure data transfer page.</h1>
							<p>All your data and transactions are protected for security reason.</p><br />
							<div id="job-done" class="continue">                                            	
                                <input type="hidden" name="id" value="<?php echo $work_data['work_id']; ?>" />
                                <input type="hidden" name="csrf" value="<?php echo md5('storyDone'); ?>" />
                                <!--<input type="submit" name="submit" value="Job Done!" />-->
                                <div class="proceed" style="float:none;">
                                    <!--<a href="javascript: void(0)" class="submit1" onclick="$('#file_upload').uploadifyUpload()">Continue</a>-->
                                    <a href="javascript: void(0)" class="submit">Continue</a>
                                </div>
                            </div>
						</div>
					</div>
                    <?php echo form_close(); ?>
					
					<div id="story-timeline">
						<h1>Time tracker timeline</h1>
						<img src="/public/images/timeline.png">
					</div>
					
					<div id="collaborators">
						<h1>people working on this project</h1>
                        <?php foreach($project_ppl as $ppl):?>
						<div class="collaborator">
							<div class="avatar"><?php if($ppl['avatar']){?><img src="/public/<?php echo $ppl['avatar'];?>" style="margin:0"><?php }?></div>
							<p>LVL</p>
							<div class="level"><?php $level = floor($ppl['exp'] / points_per_level)+1;echo ($level>99) ? 99 : $level;?></div>
							<div class="username"><?php echo $ppl['username'];?></div>
						</div>
                        <?php endforeach;?>
						<!--<div class="arrow"></div>-->
					</div>
	</div>
</div>
<?php $this->load->view('includes/footer'); ?> 