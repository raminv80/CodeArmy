<?php $this->load->view('includes/header4'); ?><link media="all" type="text/css" rel="stylesheet" href="/public/css/v4/myoffice/style.css" />
<?php 
 if($usrProfile){
	$contact = json_decode($profile["contact"]);
	$urls = json_decode($profile["urls"]);
 }else{
	$contact = array();
	$urls = array(); 
 }
?>
	<link media="all" type="text/css" rel="stylesheet" href="/public/css/v4/myoffice/autocomplete.css" />
	<link rel="stylesheet" type="text/css" href="/public/css/v4/myoffice/jquery.fancybox-1.3.4.css" media="screen" />
	<link type="text/css" href="/public/css/v4/myoffice/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <style>.tabset li {overflow: hidden;border-bottom: 1px solid #252525; background:none !important;}</style>
        <section style="padding-top:100px;" id="pitch">
		<div id="wrapper">
			<div class="contents">
				<div class="profile-heading">
					
					<a href="#"><img src="/public/<?php echo ($usrProfile && isset($usrProfile['avatar']))? $usrProfile['avatar']:"images/img7.png";?>" alt="profile picture" class="alignleft" width="104" height="100" /></a>
					<div class="main-info">
						<h2><?php echo $usr['username'];?></h2>
						<span class="name"><?php echo ($usrProfile)? $usrProfile['full_name'] : "";?></span>
						<div class="row">
                        	<?php if($usrProfile){?>
							<span class="sex">
							<?php if(isset($usrProfile['gender'])) echo $usrProfile['gender']; 
								  if(isset($usrProfile['birthdate'])) echo ', '.(date('Y')-date('Y', strtotime($usrProfile['birthdate'])));
							?></span>
                            <?php }?>
							<div class="specialization">
								<span class="left"><?php echo ($usrProfile)? $usrProfile['specialization'] : "";?></span>
							</div>
						</div>
					</div>
					<div class="language-info">
						<strong class="text-language">language</strong>
						<dl>
							<dt>spoken</dt>
							<dd><?php echo ($usrProfile && isset($usrProfile['lan_speak']))? $usrProfile['lan_speak']: 'English';?></dd>
							<dt>read / write</dt>
							<dd><?php echo ($usrProfile && isset($usrProfile['lan_rw']))? $usrProfile['lan_rw']: 'English';?></dd>
						</dl>
					</div>
				</div>
                <?php if(isset($urls->skype)){?>
                    <div id="skype_call">
                    <!--
                    Skype 'Skype Me™!' button
                    http://www.skype.com/go/skypebuttons
                    -->
                    <script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
                    <a href="skype:<?=$urls->skype?>?call"><img src="http://download.skype.com/share/skypebuttons/buttons/call_blue_transparent_70x23.png" style="border: none;" width="70" height="23" alt="Skype Me™!" /></a>
                    </div>
                <?php }?>
                	<!-- text me section <a href=""><img src="/public/images/textme.png" style="border: none;" width="70" height="23" alt="Text me!" /></a>
				<div class="tabs-area"> -->
					<div class="aside">
						<dl class="refers">
							<dt><span>Completed</span></dt>
							<dd><span class="box"><?php echo $works_completed? $works_completed:0;?></span></dd>
							<dt><span class="text-spent">Time spent</span></dt>
							<dd><span class="box"><?php echo $hours_spent? $hours_spent:0;?></span> <span class="hours">(hours)</span></dd>
							<dt><span class="text-saved">Time saved</span></dt>
							<dd><span class="box"><?php echo $hours_saved? $hours_saved:0;?></span> <span class="hours">(hours)</span></dd>
						</dl>
						<ul class="tabset">
                        	<li><a class="user tab active" href="#tab_1"><span class="top"><span>summary</span></span></a></li>
							<li><a class="user tab" href="#tab_2"><span class="top"><span class="text-achievements">Achievements</span></span></a></li>
							<li><a class="user tab" href="#tab_7"><span class="top"><span class="text-personal">Personal info</span></span></a></li>
						</ul>
					</div>
                <div id="tab_1" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
									<div class="task-block">
										<div class="skills-box">
											<div class="holder">
												<div class="frame">
													<dl>
                                                    	<?php if($my_skills){foreach($my_skills as $skill):?>
                                                        <dt><span style="text-shadow: 0 1px 10px white;font-size: 20px;font-weight: lighter; background:none; text-indent:0;"><?php echo $skill['name'];?></span></dt>
														<dd><?php echo $skill['point'];?></dd>
                                                        <?php endforeach;}else{?>
														<dt><span>HTMl / xhtml</span></dt>
														<dd>0</dd>
														<dt><span class="text-css">css</span></dt>
														<dd>0</dd>
														<dt><span class="text-javascript">javascript</span></dt>
														<dd>0</dd>
														<dt><span class="text-mysql">mysql</span></dt>
														<dd>0</dd>
														<dt><span class="text-php">php</span></dt>
														<dd>0</dd>
														<dt><span class="text-leadership">leadership</span></dt>
														<dd>0</dd>
														<dt><span class="text-teamwork">teamwork</span></dt>
														<dd>0</dd>
														<?php }?>
													</dl>
													<div class="skills-points">
                                                    	<?php if($my_skills){foreach($my_skills as $skill):?>
                                                        <div id="css" class="skill-chart-container">
                                                        	<?php
																$last_point = $this->session->flashdata('skill-'.$skill['id']);
																$point = $skill['point'];
																if($last_point){
																	$point = $last_point;
																	$add_point = $skill['point'] - $last_point;
																}else{
																	$add_point = 0;
																}
																$point = round($point/max_skill_point*100);
																$add_point = round($add_point/max_skill_point*100);
																if($point<=0)$point = 1;
																if($point>100)$point = 100;
																if($add_point<0)$add_point=0;
																if($add_point>100)$add_point=100;
															?>
                                                        	<div class="skill-chart" style="width:<?php echo $point;?>%"></div>
                                                            <div class="skill-chart-add" style="width:<?php echo $add_point;?>%"></div>
                                                        </div>
                                                        <?php endforeach;}else{?>
                                                    	<div id="css" class="skill-chart-container">
                                                        	<div class="skill-chart" style="width:1%"></div>
                                                        </div>
                                                        <div id="css" class="skill-chart-container">
                                                        	<div class="skill-chart" style="width:1%"></div>
                                                        </div>
                                                        <div id="css" class="skill-chart-container">
                                                        	<div class="skill-chart" style="width:1%"></div>
                                                        </div>
                                                        <div id="css" class="skill-chart-container">
                                                        	<div class="skill-chart" style="width:1%"></div>
                                                        </div>
                                                        <div id="css" class="skill-chart-container">
                                                        	<div class="skill-chart" style="width:1%"></div>
                                                        </div>
                                                        <div id="css" class="skill-chart-container">
                                                        	<div class="skill-chart" style="width:1%"></div>
                                                        </div>
                                                        <div id="css" class="skill-chart-container">
                                                        	<div class="skill-chart" style="width:1%"></div>
                                                        </div>
                                                        <?php }?>
                                                    </div>
												</div>
											</div>
										</div>
										<div class="task-holder">
											<div class="last-task">
												<div class="holder">
													<h3><span>Last completed job</span></h3>
													<ul>
                                                    	<?php if($last_task){?>
														<li><span class="title">[<a href="#"><?php echo $last_task['project_name'];?></a>]</span> <a href="/story/<?php echo $last_task['work_id'];?>"><?php echo $last_task['title'];?> </a><span class="mark">(<?php echo $last_task['status'];if((strtolower($last_task['status'])!='redo')&&(strtolower($last_task['status'])!='signoff'))echo 'ed';?>)</span></li>
                                                        <?php }else{?>
                                                        <li><span class="title">Registration</span>
                                                        <?php }?>
													</ul>
												</div>
												
											</div>
											<div class="currently-task">
												<h3><span class="text-currently">currently working on</span></h3>
												<ul>
                                                	<?php if($working_on){foreach($working_on as $work):?>
													<li><span class="title">[<a href="#"><?php echo $work['project_name'];?></a>]</span> <a href="/story/<?php echo $work['work_id'];?>"><?php echo $work['title'];?></li>
                                                    <?php endforeach;}else{?>
                                                    <li>You have no active job at the moment</li>
                                                    <?php }?>
												</ul>
											</div>
										</div>
									</div>
									<div class="achievements-block">
										<div class="level-block">
											<div class="level-box">
												<span class="level">level</span>
												<span class="number"><?php $level = $this->gamemech->get_level($usr['exp']); echo $level;?></span>
											</div>
											<strong class="title">
                                            	<a href="#" class="tier">
                                            		<?php 
														if($level<25) echo 'bronze';
														if(($level>=25)&&($level<50))echo 'silver';
														if($level>=50)echo 'gold';
													?> tier
                                                </a>&nbsp;<!-- TODO: 73 Users recommended-->
                                            </strong>
										</div>
										<div class="achievement-holder">
											<h3>
												<a href="#" class="tab">
													<span class="text-recent">Recent Achievement</span>
                                                    <?php if($last_badge){?>
													<img src="<?php echo base_url();?>public/<?php echo $last_badge['achievement_pic'];?>" alt="achievement badge" width="133" height="121" />
                                                    <?php }else{?>
                                                    <img src="<?php echo base_url();?>public/images/un-badge.png">
                                                    <?php }?>
												</a>
											</h3>
                                            <?php if($last_badge){?>
											<span class="title"><?php echo $last_badge['achievement_name'];?></span>
											<span><?php echo $last_badge['achievement_desc'];?></span>
                                            <?php }else{?>
											<span class="title">In Progress...</span>
											<span></span>
                                            <?php }?>
										</div>
									</div>
								</div>
								<div class="leaderboard-block">
									<div class="holder">
										<div class="frame">
											<div style="width:100%" class="content">
												<h3><span>Leaderboard</span></h3>
												<ul>
													<li>
														<strong class="title">mission completed</strong>
														<ul>
															<?php foreach($leaderboard_project as $i=>$leader):?>
															<li>
																<span class="number">#<?php echo $i+1;?></span>
																<div class="image-holder">
																	<a href="/user/<?php echo $leader['user_id'];?>"><img src="/public/<?php echo $leader['avatar']? $leader['avatar'] : 'images/img7.png';?>" alt="profile picture" class="alignleft" width="20" height="20" /></a>
																</div>
																<div class="info">
																	<a href="/user/<?php echo $leader['user_id'];?>" class="name"><?php echo $leader['username'];?></a>
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
																	<a href="/user/<?php echo $leader['user_id'];?>"><img src="/public/<?php echo $leader['avatar']? $leader['avatar'] : 'images/img7.png';?>" alt="profile picture" class="alignleft" width="21" height="20" /></a>
																</div>
																<div class="info">
																	<a href="/user/<?php echo $leader['user_id'];?>" class="name"><?php echo $leader['username'];?></a>
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
																	<a href="/user/<?php echo $leader['user_id'];?>"><img src="/public/<?php echo $leader['avatar']? $leader['avatar'] : 'images/img7.png';?>" alt="profile picture" class="alignleft" width="21" height="20" /></a>
																</div>
																<div class="info">
																	<a href="/user/<?php echo $leader['user_id'];?>" class="name"><?php echo $leader['username'];?></a>
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
															<li><a href="/user/<?php echo $user['user_id'];?>"><img src="/public/<?php echo $user['avatar']? $user['avatar'] : 'images/img7.png';?>" alt="profile picture" width="40" height="39" /></a></li>
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
<!--                //////////////////////////////-->
					<div id="tab_2" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>Achievements</h1>
                                    <!--TODO: Achievements -->
								</div>
							</div>
						</div>
				</div>
<!--                //////////////////////////////-->
				<div id="tab_7" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                    
                                    						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>Personal Info</h1>
									<!-- profile content container start -->
									
                                    <div id="personal-info">
                                    	<ul class="details">
                                        	<!--<li><img src="/public/<?php echo $profile['avatar'];?>" /></li>-->
                                        	<li>username: <span><?php echo $usr['username'];?></span></li>
                                            <?php if(isset($username)):?>
                                            <li>Email: <span><a href="mailto:<?php echo $usr['email'];?>"><?php echo $usr['email'];?></a></span></li>
                                            <?php endif;?>
                                            <li>Exp: <span><?php echo $usr['exp'];?></span></li>
                                            <li>hours spent: <span><?php echo $hours_spent;?> hour(s)</span></li>
                                            <li>Works done: <span><?php echo $works_completed;?> jobs</span></li>
                                            <li>Early submission: <span><?php echo $hours_saved;?> hour(s)</span></li>
                                            <?php if($usrProfile){?>
                                            <li>Gender: <span><?php echo $profile['gender'];?></span></li>
                                            <li>Birthdate:<span> <?php echo $profile['birthdate'];?></span></li>
                                            <li>Specilization: <span><?php echo $profile['specialization'];?></span></li>
                                            <li>Language Spoken: <span><?php echo $profile['lan_speak'];?></span></li>
                                            <li>Language read/write: <span><?php echo $profile['lan_rw'];?></span></li>
                                            <?php if(isset($contact->city)) { ?>
                                            <li>City: <span><?php echo $contact->city; ?></span></li>
                                            <?php }?>
                                            <?php if(isset($contact->country)) { ?>
                                            <li>Country: <span><?php echo $contact->country; ?></span></li>
                                            <?php }?>
                                            <?php if(isset($urls->linkedin)) { ?>
                                            <li>Linkedin: <span><?php echo $urls->linkedin; ?></span></li>
                                            <?php }?>
                                            <?php if(isset($urls->skype)) { ?>
                                            <li>Skype: <span><?php echo $urls->skype; ?></span></li>
                                            <?php }?>
                                            <?php if(isset($urls->github)) { ?>
                                            <li>Github: <span><?php echo $urls->github; ?></span></li>
                                            <?php }?>
                                            <?php if(isset($urls->portfolio)) { ?>
                                            <li>Portfolio: <span><?php echo $urls->portfolio; ?></span></li>
                                            <?php }?>
                                            <?php }?>
                                        </ul>
                                    </div>
                                    <!-- / profile content container ends -->
                                </div>
                            </div>    
                        </div></div>
                                    
                                </div>
                            </div>    
                        </div>
					</div>
				</div>
			</div>
		</div></section>
        <script type="text/javascript" src="/public/js/main.js"></script>
<?php $this->load->view('includes/footer4'); ?>