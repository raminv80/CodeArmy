						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
								<div class="leaderboard-block">
                                	<h1>Leaderboard</h1>
                                    <ul>
                                        <li style="width:30%;">
                                            <strong class="title" style="text-align:left;">mission completed</strong>
                                            <ul>
                                                <?php foreach($leaderboard_project as $i=>$leader):?>
                                                <li>
                                                    <span class="number">#<?php echo $i+1;?></span>
                                                    <div class="image-holder">
                                                        <a href="/user/<?php echo $leader['user_id'];?>"><img src="/public/<?php echo $leader['avatar']? $leader['avatar'] : 'images/img7.png';?>" alt="profile picture" class="alignleft" width="70" height="70" /></a>
                                                    </div>
                                                    <div class="info">
                                                        <a href="/user/<?php echo $leader['user_id'];?>" class="name" style="width:100%;"><?php echo $leader['username'];?></a>
                                                        <span><?php echo $leader['num'];?> missions</span>
                                                    </div>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                        
                                        <li style="width:30%;">
                                            <strong class="title">points gained</strong>
                                            <ul>
                                                <?php foreach($leaderboard_points as $i=>$leader):?>
                                                <li>
                                                    <span class="number">#<?php echo $i+1;?></span>
                                                    <div class="image-holder">
                                                        <a href="/user/<?php echo $leader['user_id'];?>"><img src="/public/<?php echo $leader['avatar']? $leader['avatar'] : 'images/img7.png';?>" alt="profile picture" class="alignleft" width="70" height="70" /></a>
                                                    </div>
                                                    <div class="info">
                                                        <a href="/user/<?php echo $leader['user_id'];?>" class="name" style="width:100%;"><?php echo $leader['username'];?></a>
                                                        <span><?php echo $leader['exp'];?> points</span>
                                                    </div>
                                                </li>
                                                <?php endforeach;?>
                                            </ul>
                                        </li>
                                        <li style="width:30%;">
                                            <strong class="title">early submission</strong>
                                            <ul>
                                                <?php foreach($leaderboard_time as $i=>$leader):?>
                                                <li>
                                                    <span class="number">#<?php echo $i+1;?></span>
                                                    <div class="image-holder">
                                                        <a href="/user/<?php echo $leader['user_id'];?>"><img src="/public/<?php echo $leader['avatar']? $leader['avatar'] : 'images/img7.png';?>" alt="profile picture" class="alignleft" width="70" height="70" /></a>
                                                    </div>
                                                    <div class="info">
                                                        <a href="#" class="name" style="width:100%;"><?php echo $leader['username'];?></a>
                                                        <span><?php echo $leader['exp'];?> hours</span>
                                                    </div>
                                                </li>
                                                <?php endforeach;?>
                                            </ul>
                                        </li>
                                    </ul>
								</div>
							</div>
							</div>
						</div>