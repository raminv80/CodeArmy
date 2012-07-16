						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>Personal Info</h1>
                                    <?php 
										$contact = json_decode($profile["contact"]);
										$urls = json_decode($profile["urls"]);							
									?>
									<!-- profile content container start -->
									<!--<a class="iframe" href="http://www.youtube.com/embed/Jx2yQejrrUE?rel=0" rel="fancy_frame" title="Lorem ipsum dolor sit amet"> <img alt="" src="http://www.youtube.com/embed/Jx2yQejrrUE?rel=0" /> </a>-->
									
                                    <div id="personal-info">
                                    	<ul class="details">
                                        	<!--<li><img src="/public/<?php echo $profile['avatar'];?>" /></li>-->
                                        	<li>username: <span><?php echo $me['username'];?></span></li>
                                            <li>Email: <span><?php echo $me['email'];?></span></li>
                                            <li>Exp: <span><?php echo $me['exp'];?></span></li>
                                            <li>hours spent: <span><?php echo $hours_spent;?> hour(s)</span></li>
                                            <li>Works done: <span><?php echo $works_completed;?> jobs</span></li>
                                            <li>Early submission: <span><?php echo $hours_saved;?> hour(s)</span></li>
                                            <li>Full Name: <span><?php echo $profile['full_name'];?></span></li>
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
                                            <?php if(isset($urls->portfolio)) { ?>
                                            <li>Portfolio: <span><?php echo $urls->portfolio; ?></span></li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                    <!-- / profile content container ends -->
                                </div>
                            </div>    
                        </div>