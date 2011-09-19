<?php $this->load->view('includes/header'); ?>
		<div id="main">
			<div id="content">
				<div class="profile-heading">
					<div class="points-box">
						<div class="holder">
							<div class="frame">
								<div class="content">
									<img class="alignleft" src="/public/images/ico-flag.png" alt="flag" width="41" height="64" />
									<div class="text-holder">
										<span class="points-left">points left</span>
										<span class="left-number"><?php echo points_per_level - $me['exp'] % points_per_level;?></span>
										<span class="earned">total earned</span>
										<span class="earned-number"><?php echo $me['exp'];?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<a href="#"><img src="/public/<?php echo $myProfile['avatar'];?>" alt="profile picture" class="alignleft" width="83" height="82" /></a>
					<div class="main-info">
						<h2><?php echo $me['username'];?></h2>
						<span class="name"><?php echo $myProfile['full_name'];?></span>
						<div class="row">
                        	<?php if($myProfile['gender'] || $myProfile['birthdate']){?>
							<span class="sex">
							<?php if($myProfile['gender']) echo $myProfile['gender']; 
								  if($myProfile['birthdate']) echo ', '.(date('Y')-date('Y', strtotime($myProfile['birthdate'])));
							?></span>
                            <?php }?>
							<div class="specialization">
								<span class="left"><?php echo $myProfile['specialization'];?></span>
							</div>
						</div>
					</div>
					<div class="language-info">
						<strong class="text-language">language</strong>
						<dl>
							<dt>spoken</dt>
							<dd><?php echo $myProfile['lan_speak'];?></dd>
							<dt>read / write</dt>
							<dd><?php echo $myProfile['lan_rw'];?></dd>
						</dl>
					</div>
				</div>
				<div class="tabs-area">
					<div class="aside">
						<dl class="refers">
							<dt><span>Completed</span></dt>
							<dd><span class="box"><?php echo $works_completed;?></span></dd>
							<dt><span class="text-spent">Time spent</span></dt>
							<dd><span class="box"><?php echo $hours_spent;?></span> <span class="hours">(hours)</span></dd>
							<dt><span class="text-saved">Time saved</span></dt>
							<dd><span class="box"><?php echo $hours_saved;?></span> <span class="hours">(hours)</span></dd>
						</dl>
						<ul class="tabset">
							<li><a class="tab active" href="#tab-1"><span class="top"><span>summary</span></span></a></li>
							<li><a class="tab" href="#tab-2"><span class="top"><span class="text-achievements">Achievements</span></span></a></li>
							<li><a class="tab" href="#tab-3"><span class="top"><span class="text-inbox">Inbox</span></span></a></li>
							<li><a class="tab" href="#tab-4"><span class="top"><span class="text-mydesk">Mydesk</span></span></a></li>
							<li><a class="tab" href="#tab-5"><span class="top"><span class="text-history">history</span></span></a></li>
							<li><a class="tab" href="#tab-6"><span class="top"><span class="text-leaderboard">Leaderboard</span></span></a></li>
							<li><a class="tab" href="#tab-7"><span class="top"><span class="text-personal">Personal info</span></span></a></li>
						</ul>
					</div>
					<div id="tab-1" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
									<div class="task-block">
										<div class="skills-box">
											<div class="holder">
												<div class="frame">
													<dl>
														<dt><span>HTMl / xhtml</span></dt>
														<dd>250</dd>
														<dt><span class="text-css">css</span></dt>
														<dd>210</dd>
														<dt><span class="text-javascript">javascript</span></dt>
														<dd>185</dd>
														<dt><span class="text-mysql">mysql</span></dt>
														<dd>150</dd>
														<dt><span class="text-php">php</span></dt>
														<dd>100</dd>
														<dt><span class="text-leadership">leadership</span></dt>
														<dd>210</dd>
														<dt><span class="text-teamwork">teamwork</span></dt>
														<dd>175</dd>
													</dl>
													<div class="skills-points"><img src="/public/images/skills.gif" alt="skills" width="298" height="215" /></div>
												</div>
											</div>
										</div>
										<div class="task-holder">
											<div class="last-task">
												<div class="holder">
													<h3><span>Last completed task</span></h3>
													<ul>
                                                    	<?php if($last_task){?>
														<li><span class="title">[<a href="#"><?php echo $last_task['project_name'];?></a>]</span> <a href="#"><?php echo $last_task['title'];?> </a><span class="mark">(<?php echo $last_task['status'];if((strtolower($last_task['status'])!='redo')&&(strtolower($last_task['status'])!='signoff'))echo 'ed';?>)</span></li>
                                                        <?php }else{?>
                                                        <li><span class="title">Registration</span>
                                                        <?php }?>
													</ul>
												</div>
												<div class="button"><span class="left">cash out</span></div>
											</div>
											<div class="currently-task">
												<h3><span class="text-currently">currently working on</span></h3>
												<ul>
                                                	<?php if($working_on){foreach($working_on as $work):?>
													<li><span class="title">[<a href="#"><?php echo $work['project_name'];?></a>]</span> <a href="#"><?php echo $work['title'];?></li>
                                                    <?php endforeach;}else{?>
                                                    <li>You have no active tasks at the moment</li>
                                                    <?php }?>
												</ul>
											</div>
										</div>
									</div>
									<div class="achievements-block">
										<div class="level-block">
											<div class="level-box">
												<span class="level">level</span>
												<span class="number"><?php echo $me['exp'] % points_per_level;?></span>
											</div>
											<strong class="title"><a href="#" class="tier">gold tier</a>73 Users recommended</strong>
										</div>
										<div class="achievement-holder">
											<h3>
												<a href="#">
													<span class="text-recent">Recent Achievement</span>
													<img src="/public/images/achievement-badge.png" alt="achievement badge" width="133" height="121" />
												</a>
											</h3>
											<span class="title">Fast Fowarding Badge</span>
											<span>for completing a task <br /> earlier than the dateline</span>
										</div>
									</div>
								</div>
								<div class="leaderboard-block">
									<div class="holder">
										<div class="frame">
											<div class="content">
												<h3><span>Leaderboard</span></h3>
												<ul>
													<li>
														<strong class="title">mission completed</strong>
														<ul>
															<?php foreach($leaderboard_project as $i=>$leader):?>
															<li>
																<span class="number">#<?php echo $i+1;?></span>
																<div class="image-holder">
																	<a href="#"><img src="/public/<?php echo $leader['avatar']? $leader['avatar'] : 'images/img7.png';?>" alt="profile picture" class="alignleft" width="20" height="20" /></a>
																</div>
																<div class="info">
																	<a href="#" class="name"><?php echo $leader['username'];?></a>
																	<span><?php echo $leader['num'];?></span>
																</div>
															</li>
                                                            <?php endforeach; ?>
														</ul>
													</li>
                                                    
													<li>
														<strong class="title">points gained</strong>
														<ul>
                                                        	<?php foreach($leaderboard_points as $i=>$leader):?>
															<li>
																<span class="number">#<?php echo $i+1;?></span>
																<div class="image-holder">
																	<a href="#"><img src="/public/<?php echo $leader['avatar']? $leader['avatar'] : 'images/img7.png';?>" alt="profile picture" class="alignleft" width="21" height="20" /></a>
																</div>
																<div class="info">
																	<a href="#" class="name"><?php echo $leader['username'];?></a>
																	<span><?php echo $leader['exp'];?></span>
																</div>
															</li>
                                                            <?php endforeach;?>
														</ul>
													</li>
													<li>
														<strong class="title">early submission</strong>
														<ul>
                                                        	<?php foreach($leaderboard_time as $i=>$leader):?>
															<li>
																<span class="number">#<?php echo $i+1;?></span>
																<div class="image-holder">
																	<a href="#"><img src="/public/<?php echo $leader['avatar']? $leader['avatar'] : 'images/img7.png';?>" alt="profile picture" class="alignleft" width="21" height="20" /></a>
																</div>
																<div class="info">
																	<a href="#" class="name"><?php echo $leader['username'];?></a>
																	<span><?php echo $leader['exp'];?></span>
																</div>
															</li>
                                                            <?php endforeach;?>
														</ul>
													</li>
												</ul>
											</div>
											<div class="collaborators-box">
												<div class="collaborators-holder">
													<div class="collaborators-frame">
														<h3><span class="text-collaborators">collaborators</span></h3>
														<ul>
                                                        	<?php if($collaborators)foreach($collaborators as $user):?>
															<li><a href="#"><img src="/public/<?php echo $leader['avatar']? $leader['avatar'] : 'images/img7.png';?>" alt="profile picture" width="40" height="39" /></a></li>
                                                            <?php endforeach;?>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="tab-2" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>Achievements</h1>
                                    <!--TODO: Achievements -->
								</div>
							</div>
						</div>
					</div>
					<div id="tab-3" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>Inbox</h1>
                                    <!-- TODO: Inbox -->
								</div>
							</div>
						</div>
					</div>
					<div id="tab-4" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>MyDesk</h1>
                                    <!-- TODO: MyDesk -->
								</div>
							</div>
						</div>
					</div>
					<div id="tab-5" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>History</h1>
                                    <!-- TODO: History -->
								</div>
							</div>
						</div>
					</div>
					<div id="tab-6" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>Leaderboard</h1>
                                    <!-- TODO: leaderboard -->
								</div>
							</div>
						</div>
					</div>
					<div id="tab-7" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>Personal Info</h1>
                                    <!-- TODO: Personal Info -->
                                </div>
                            </div>    
                        </div>
					</div>
				</div>
			</div>
		</div>
        <script type="text/javascript" src="/public/js/main.js"></script>
<?php $this->load->view('includes/footer'); ?>        