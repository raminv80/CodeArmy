<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
									<div class="task-block">
										<div class="skills-box">
											<div class="holder">
												<div class="frame">
	                                                <div>Points to spend: <?=$me['claims']?> pts</div>
													<dl>
                                                    	<?php if($my_skills){foreach($my_skills as $skill):?>
                                                        <dt><span style="text-shadow: 0 1px 10px white;font-size: 20px;font-weight: lighter; background:none; text-indent:0;"><?php echo $skill['name'];?></span></dt>
                                                        <?php if($skill['point']>$skill['claim']){ $color = 'green'; $point = $skill['point']; }else{ $color = 'yellow'; $point = $skill['claim']; }?>
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
                                                        <div id="css" class="skill-chart-container">
                                                        	<?php
																$point = $skill['point'];
																$claim = $skill['claim'];
																if(($claim - $point) > 0){
																	$add_point = $claim - $point;
																}else{
																	$add_point = 0;
																}
																
																$point = ceil($point/max_skill_point*100);
																$add_point = ceil($add_point/max_skill_point*100);
																if($point<=0)$point = 0;
																if($point>100)$point = 100;
																if($add_point<0)$add_point=0;
																if($add_point>100)$add_point=100;
																
															?>
                                                        	<div class="skill-chart" style="width:<?php echo $point;?>%"></div>
                                                            <div class="skill-chart-add" style="width:<?php echo $add_point;?>%"></div>
                                                            <div><?php if($me['claims']>0){?><?= form_open('/myoffice', array('style' => 'margin: 0'))?><input type="hidden" name="claim" value="<?=$skill['id']?>" /><input type="hidden" name="claim_skill" value="+" /><a style="float: right;margin: -9px -22px;font-size: 24px;font-weight: bold;" href="javascript: void(0)" class="submit" >+</a><?=form_close()?><?php }?></div>
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
                                                <div class="frame">
                                                	<?php if(!$my_skills){?>
                                                	<p>Skill points can be acheieved by finishing jobs but that's not the only way to show what you are good at. You have been rewarded <?=$me['claims']?> points for claiming your skills. Use them wise and tell the world what you are good at! </p>
                                                    <?php }?>
                                                    <?php echo form_open('/myoffice', array('name'=> 'add_skill'))?>
                                                    <p>Add 
                                                    	<select name="skill" >
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
                                                    .</p>
                                                    <?php echo form_close();?>
                                                </div>
											</div>
										</div>
										<div class="task-holder">
											<div class="last-task">
												<div class="holder">
													<h3><span>Last completed task</span></h3>
													<ul>
                                                    	<?php if($last_task){?>
														<li><span class="title">[<a href="/project/<?php echo $last_task['project_id'];?>"><?php echo $last_task['project_name'];?></a>]</span> <a href="/story/<?php echo $last_task['work_id'];?>"><?php echo $last_task['title'];?> </a><span class="mark">(<?php echo $last_task['status'];if(in_array(strtolower($last_task['status']),array('reject'))) echo 'ed';?>)</span></li>
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
                                                </a>&nbsp; <!-- TODO: 73 Users recommended-->
                                            </strong>
										</div>
										<div class="achievement-holder">
											<h3>
												<a href="#" class="tab">
													<span class="text-recent">Recent Achievement</span>
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
																	<a href="#"><img src="<?php echo ($leader['avatar'])? '/public/'.$leader['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $leader['email'] ) ) );?>" alt="profile picture" class="alignleft" width="20" height="20" /></a>
																</div>
																<div class="info">
																	<a href="/user/<?=$leader['user_id']?>" class="name"><?php echo $leader['username'];?></a>
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
																	<a href="#"><img src="<?php echo ($leader['avatar'])? '/public/'.$leader['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $leader['email'] ) ) );?>" alt="profile picture" class="alignleft" width="21" height="20" /></a>
																</div>
																<div class="info">
																	<a href="/user/<?=$leader['user_id']?>" class="name"><?php echo $leader['username'];?></a>
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
																	<a href="#"><img src="<?php echo ($leader['avatar'])? '/public/'.$leader['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $leader['email'] ) ) );?>" alt="profile picture" class="alignleft" width="21" height="20" /></a>
																</div>
																<div class="info">
																	<a href="/user/<?=$leader['user_id']?>" class="name"><?php echo $leader['username'];?></a>
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
<script>
$('a.submit').click(function(){
	test = $(this);
	var form = $(this).parents('form');
	form.submit();
});
</script>