<?php $this->load->view('includes/header4'); ?>
	<link media="all" type="text/css" rel="stylesheet" href="/public/css/v4/myoffice/style.css" />
	<link media="all" type="text/css" rel="stylesheet" href="/public/css/v4/myoffice/autocomplete.css" />
	<link rel="stylesheet" type="text/css" href="/public/css/v4/myoffice/jquery.fancybox-1.3.4.css" media="screen" />
	<link type="text/css" href="/public/css/v4/myoffice/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <style>.tabset li {overflow: hidden;border-bottom: 1px solid rgba(0, 0, 0, 0.4); background:none !important;}</style>
        <section style="padding-top:100px;" id="pitch">
        <div id="wrapper">
			<div class="contents">
				<div class="profile-heading">
					<div class="points-box">
						<div class="holder">
							<div class="frame">
								<div class="content">
									<img class="alignleft" src="/public/images/ico-flag.png" alt="flag" width="41" height="64" />
									<div class="text-holder">
										<span class="points-left">points left</span>
										<span class="left-number" style="text-shadow: 0 1px 10px white;font-size: 22px;font-weight: lighter; background:none; text-indent:0; color:white; font-weight:bold;"><?php echo $this->gamemech->points_left($me['exp']);?></span>
										<span class="earned">total earned</span>
										<span class="earned-number"><?php echo $me['exp'];?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<a href="#"><img src="<?php echo ($myProfile['avatar'])? '/public/'.$myProfile['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $me['email'] ) ) );?>" alt="profile picture" class="alignleft" width="104" height="100" /></a>
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
							<dd><span class="box"><?php echo $works_completed? $works_completed:0;?></span></dd>
							<dt><span class="text-spent">Time spent</span></dt>
							<dd><span class="box"><?php echo $hours_spent? $hours_spent:0;?></span> <span class="hours">(hours)</span></dd>
							<dt><span class="text-saved">Time saved</span></dt>
							<dd><span class="box"><?php echo $hours_saved? $hours_saved:0;?></span> <span class="hours">(hours)</span></dd>
						</dl>
						<ul class="tabset">
							<li><a class="tab active" href="#tab_1"><span class="top"><span>summary</span></span></a></li>
							<li><a class="tab" href="#tab_2"><span class="top"><span class="text-achievements">Achievements</span></span></a></li>
							<li><a class="tab" href="#tab_3"><span class="top"><span class="text-inbox">Inbox</span></span></a></li>
							<li><a class="tab" href="#tab_4"><span class="top"><span class="text-mydesk">Mydesk</span></span></a></li>
							<li><a class="tab" href="#tab_5"><span class="top"><span class="text-history">history</span></span></a></li>
							<li><a class="tab" href="#tab_6"><span class="top"><span class="text-leaderboard">Leaderboard</span></span></a></li>
							<li><a class="tab" href="#tab_7"><span class="top"><span class="text-personal">Personal info</span></span></a></li>
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
                                                	<?php /*<div id="remaining_points">Skill Points: <?=$me['claims']?></div>*/ ?>
													<dl>
                                                    	<?php if($my_skills){foreach($my_skills as $skill):?>
                                                        <dt><span style="text-shadow: 0 1px 10px white;font-size: 16px;font-weight: lighter; background:none; text-indent:0; padding-top:4px;"><?php echo $skill['name'];?></span></dt>
                                                        <?php $color = 'green'; $point = $skill['point'];?>
														<dd><span style="color:<?=$color?>"><?=$point?></span></dd>
                                                        <?php endforeach;}else{?>
                                                        <?php /*
														<dt><span>TECHNICAL SKILL</span></dt>
														<dd>0</dd>
														<dt><span class="text-css">SOFT SKILL</span></dt>
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
														<dd>0</dd>*/?>
														<?php }?>
													</dl>
													<div class="skills-points">
                                                    	<?php if($my_skills){foreach($my_skills as $skill):?>
                                                        <div id="css" class="skill-chart-container" style="height:37px">
                                                        	<?php
																$point = $skill['point'];
																$point = ceil($point/max_skill_point*100);
																if($point<=0)$point = 0;
																if($point>100)$point = 100;
																/*$claim = $skill['claim'];
																if(($claim - $point) > 0){
																	$add_point = $claim - $point;
																}else{
																	$add_point = 0;
																}
																
																$point = ceil($point/max_skill_point*100);
																$add_point = ceil($add_point/max_skill_point*100);
																if($add_point<0)$add_point=0;
																if($add_point>100)$add_point=100;*/
																$add_point = 0;
															?>
                                                        	<div class="skill-chart" style="width:<?php echo $point;?>%"></div>
                                                            <div class="skill-chart-add" style="width:<?php echo $add_point;?>%"></div>
                                                            <?php /*<div><?php if($me['claims']>0){?><?= form_open('/myoffice', array('style' => 'margin: 0'))?><input type="hidden" name="claim" value="<?=$skill['id']?>" /><input type="hidden" name="claim_skill" value="+" /><a style="float: right;margin: -9px -22px;font-size: 24px;font-weight: bold;" href="javascript: void(0)" class="submit" >+</a><?=form_close()?><?php }?></div>*/?>
                                                        </div>
                                                        <?php endforeach;}else{?>
                                                        <?php /*
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
                                                        </div>*/?>
                                                        <?php }?>
                                                    </div>
												</div>
                                                <?php if($show_claim){?>
                                                <div class="frame" style="padding:0">
                                                	<?php if(!$my_skills){?>
                                                	<p>Assign yourselfe 3 skills and let the wowrld know what your are good at.</p>
                                                    <?php }?>
                                                    <div id="add_skill"> 
                                                    <?php echo form_open('/myoffice', array('name'=> 'add_skill', 'style'=>'margin:0;'))?>
                                                    	<a href="javascript: void(0)" class="add_skill_show">+ Add <?=$me['claims']?> more Skills</a>
                                                        <div style="display:none">
                                                    	Add <select name="skill" >
                                                        	<?php if(!$show_voucher){?>
															<optgroup label="Management Skills">
	                                                            <?php foreach($all_skills as $skill)if($skill['type']=="management"):?>
                                                        		<option value="<?=$skill['id']?>"><?=$skill['name']?></option>
                                                                <?php endif;?>
                                                            </optgroup>
                                                            <?php }?>
                                                            <optgroup label="Hard Skills">
                                                            	<?php foreach($all_skills as $skill)if($skill['type']=="hard"):?>
                                                        		<option value="<?=$skill['id']?>"><?=$skill['name']?></option>
                                                                <?php endif;?>
                                                            </optgroup>
                                                            <optgroup label="Soft Skills">
	                                                            <?php foreach($all_skills as $skill)if($skill['type']=="soft"):?>
                                                        		<option value="<?=$skill['id']?>"><?=$skill['name']?></option>
                                                                <?php endif;?>
                                                            </optgroup>
                                                        </select>
                                                    Skill to the skill set
                                                    <input type="submit" value="Go" name="add_skill" />
                                                    </div>
                                                    <?php echo form_close();?>
                                                    </div>
                                                </div>
                                                <?php }?>
                                                <div class="frame" style="padding:0">
                                                <?=$voucher?>
                                                <?php if($show_voucher){?>
													<div id="be_po">
                                                    	<?= form_open('/myoffice')?>
                                                        	Voucher Code: 
                                                        	<input name="code" value="" maxlength="12" />
                                                            <input type="submit" value="Submit" name="submit" />
                                                        <?= form_close();?>
                                                    </div>
                                                <?php }?>
                                                </div>
											</div>
										</div>
										<div class="task-holder">
											<div class="last-task">
												<div class="holder">
													<h3><span>Last completed job</span></h3>
													<ul>
                                                    	<?php if($last_task){?>
														<li style="width: 240px;"><span class="title">[<a href="/project/<?php echo $last_task['project_id'];?>"><?php echo $last_task['project_name'];?></a>]</span> <a href="/story/<?php echo $last_task['work_id'];?>"><?php echo $last_task['title'];?> </a><span class="mark">(<?php echo $last_task['status'];if(in_array(strtolower($last_task['status']),array('reject'))) echo 'ed';?>)</span></li>
                                                        <?php }else{?>
                                                        <li><span class="title">Registration</span>
                                                        <?php }?>
													</ul>
												</div>
												<!--<div class="button"><span class="left">cash out</span></div>-->
											</div>
											<div class="currently-task">
												<h3><span class="text-currently">currently working on</span></h3>
												<ul>
                                                	<?php if($working_on){foreach($working_on as $work):?>
													<li><span class="title">[<a href="/project/<?php echo $work['project_id'];?>"><?php echo $work['project_name'];?></a>]</span> <a href="/story/<?php echo $work['work_id'];?>"><?php echo $work['title'];?></li>
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
												<span class="number"><?php $level = $this->gamemech->get_level($me['exp']); echo $level;?></span>
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
													<span style="background:none;width: 245px;text-indent:1px;font-size: 0.8em;" class="text-recent">Recent Achievement</span>
                                                    <?php if($last_badge){?>
													<img src="/public/<?php echo $last_badge['achievement_pic'];?>" alt="achievement badge" width="133" height="121" />
                                                    <?php }else{?>
                                                    <img src="public/images/un-badge.png">
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
											<div style="width: 750px;" class="content">
												<h3><span>Leaderboard</span></h3>
												<ul>
													<li>
														<strong style="text-align:left" class="title">mission completed</strong>
														<ul>
															<?php foreach($leaderboard_project as $i=>$leader):?>
															<li>
																<span class="number">#<?php echo $i+1;?></span>
																<div class="image-holder">
																	<a href="/user/<?php echo $leader['user_id'];?>"><img src="<?php echo ($leader['avatar'])? '/public/'.$leader['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $leader['email'] ) ) );?>" alt="profile picture" class="alignleft" width="20" height="20" /></a>
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
																	<a href="/user/<?php echo $leader['user_id'];?>"><img src="<?php echo ($leader['avatar'])? '/public/'.$leader['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $leader['email'] ) ) );?>" alt="profile picture" class="alignleft" width="21" height="20" /></a>
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
														<h3><span class="text-collaborators" style="float: left;
margin: 0 0 13px 10px;">collaborators</span></h3>
														<ul>
                                                        	<?php if($collaborators)foreach($collaborators as $user):?>
															<li><a href="/user/<?php echo $user['user_id'];?>"><img src="<?php echo ($user['avatar'])? '/public/'.$user['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $user['email'] ) ) );?>" alt="profile picture" width="40" height="39" /></a></li>
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
					<div id="tab_3" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>Inbox</h1>
                                    <!-- TODO: Inbox -->
								</div>
							</div>
						</div>
					</div>
					<div id="tab_4" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>MyDesk</h1>
                                    <!-- TODO: MyDesk -->
								</div>
							</div>
						</div>
					</div>
					<div id="tab_5" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>History</h1>
                                    <!-- TODO: History -->
								</div>
							</div>
						</div>
					</div>
					<div id="tab_6" class="tab-content">
						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>Leaderboard</h1>
                                    <!-- TODO: leaderboard -->
								</div>
							</div>
						</div>
					</div>
					<div id="tab_7" class="tab-content">
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
            </div></section>
        <script type="text/javascript" src="/public/js/main.js"></script>
        <?php if($tab!=''){?>
        <script type="text/javascript">$(function(){show_tab('<?=$tab?>');});</script>
        <?php }?>
<?php $this->load->view('includes/footer5'); ?>        