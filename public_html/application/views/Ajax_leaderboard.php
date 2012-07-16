										<li style="width:30%;">
                                            <strong class="title">mission completed</strong>
                                            <ol style="list-style-type:none;">
                                                <?php foreach($leaderboard_project as $i=>$leader):?>
                                                <script type="text/javascript">
													mission_leaderboard[<?php echo $i;?>] = '<?php echo $leader['user_id'];?>';
												</script>
                                                <li style="width: 300px;" id="m<?php echo $leader['user_id'];?>">
                                                    <span class="number"><?php echo $i+1;?></span>
                                                    <div class="image-holder">
                                                        <a href="/user/<?php echo $leader['user_id'];?>"><img src="/public/<?php echo $leader['avatar']? $leader['avatar'] : 'images/img7.png';?>" alt="profile picture" class="alignleft" width="80" height="80" /></a>
                                                    </div>
                                                    <div class="info" style="width: 50%; display: block; overflow: hidden; float: none; padding-left: 10px;">
                                                        <a href="/user/<?php echo $leader['user_id'];?>" class="name" style="float:none; font-size:1.2em;"><?php echo $leader['username'];?></a>
                                                        <span><?php echo $leader['num'];?></span>
                                                    </div>
                                                </li>
                                                <?php endforeach; ?>
                                            </ol>
                                        </li>
                                        
                                        <li style="width:30%;">
                                            <strong class="title">points gained</strong>
                                            <ol style="list-style-type:none;">
                                                <?php foreach($leaderboard_points as $i=>$leader):?>
                                                <script type="text/javascript">
													points_leaderboard[<?php echo $i;?>] = '<?php echo $leader['user_id'];?>';
												</script>
                                                <li style="width: 300px;" <?php if($this->session->userdata('user_id')==$leader['user_id']){?>class="my_pos"<?php }?>>
                                                    <span class="number"><?php echo $i+1;?></span>
                                                    <div class="image-holder">
                                                        <a href="/user/<?php echo $leader['user_id'];?>"><img src="/public/<?php echo $leader['avatar']? $leader['avatar'] : 'images/img7.png';?>" alt="profile picture" class="alignleft" width="80" height="80" /></a>
                                                    </div>
                                                    <div class="info" style="width: 50%; display: block; overflow: hidden; float: none; padding-left: 10px;">
                                                        <a href="/user/<?php echo $leader['user_id'];?>" class="name" style="float:none; font-size:1.2em;"><?php echo $leader['username'];?></a>
                                                        <span><?php echo $leader['exp'];?></span>
                                                    </div>
                                                </li>
                                                <?php endforeach;?>
                                            </ol>
                                        </li>
                                        <li style="width:30%;">
                                            <strong class="title">early submission</strong>
                                            <ol style="list-style-type:none;">
                                                <?php foreach($leaderboard_time as $i=>$leader):?>
                                                <script type="text/javascript">
													time_leaderboard[<?php echo $i;?>] = '<?php echo $leader['user_id'];?>';
												</script>
                                                <li style="width: 300px;">
                                                    <span class="number"><?php echo $i+1;?></span>
                                                    <div class="image-holder">
                                                        <a href="/user/<?php echo $leader['user_id'];?>"><img src="/public/<?php echo $leader['avatar']? $leader['avatar'] : 'images/img7.png';?>" alt="profile picture" class="alignleft" width="80" height="80" /></a>
                                                    </div>
                                                    <div class="info" style="width: 50%; display: block; overflow: hidden; float: none; padding-left: 10px;">
                                                        <a href="/user/<?php echo $leader['user_id'];?>" class="name" style="float:none; font-size:1.2em;"><?php echo $leader['username'];?></a>
                                                        <span><?php echo $leader['exp'];?></span>
                                                    </div>
                                                </li>
                                                <?php endforeach;?>