<?php $this->load->view('includes/header'); ?>
		<div id="wrapper" class="home">
			<div id="intro">
				<div class="calculate-block">
					<div class="calculator">
						<span class="num-<?php echo ($total_projects_cash_loaded/1000000)%10;?>"><?php echo ($total_projects_cash_loaded/1000000)%10;?></span>
						<span class="num-<?php echo ($total_projects_cash_loaded/100000)%10;?>"><?php echo ($total_projects_cash_loaded/100000)%10;?></span>
						<span class="num-<?php echo ($total_projects_cash_loaded/10000)%10;?>"><?php echo ($total_projects_cash_loaded/10000)%10;?></span>
						<span class="num-<?php echo ($total_projects_cash_loaded/1000)%10;?>"><?php echo ($total_projects_cash_loaded/1000)%10;?></span>
						<span class="num-<?php echo ($total_projects_cash_loaded/100)%10;?>"><?php echo ($total_projects_cash_loaded/100)%10;?></span>
						<span class="num-<?php echo ($total_projects_cash_loaded/10)%10;?>"><?php echo ($total_projects_cash_loaded/10)%10;?></span>
						<span class="num-<?php echo $total_projects_cash_loaded%10;?>"><?php echo $total_projects_cash_loaded%10;?></span>
					</div>
					<strong class="title">Total Amount of Cash in RM</strong>
					<div class="buttons-holder">
						<?php if(!isset($username)){?>
                        <a href="#login" class="btn-login link-popup">login</a>
						<span class="or">OR</span>
						<a href="#register" class="btn-register link-popup">register now</a>
                        <?php }else{?>
                        Hi <?php echo $username;?> <a href="/login/logout" class="btn-login">Logout</a>
                        <?php }?>
						<div class="popup" id="login">
							<div class="holder">
								<div class="frame">
									<div class="content">
										<div class="heading">
											<a href="#" class="close">close</a>
											<strong class="title">LOGIN</strong>
										</div>
                                        <?php echo form_open('login/validate_credentials' , array('class'=>'login-form')); ?>
											<fieldset>
												<div class="row">
													<label for="username">Username</label>
													<div class="text">
														<input type="text" id="username" name="username" value="<?php echo $this->input->post('username'); ?>"  />
													</div>
												</div>
												<div class="row">
													<label for="password1">Password</label>
													<div class="text">
														<input type="password" name="password" id="password1" value=""  />
													</div>
												</div>
												<div class="row">
													<a class="forgot" href="/login/recovery">Forgot your password?</a>
													<input type="submit" class="submit" value="Yeah!" name="submit" />
												</div>
											</fieldset>
										<?php echo form_close(); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="popup" id="register">
							<div class="holder">
								<div class="frame">
									<div class="content">
										<div class="heading">
											<a href="#" class="close">close</a>
											<strong class="title">Regisration</strong>
										</div>
                                        <?php echo form_open('signup', array('class'=>'register-form')); ?>
											<fieldset>
												<div class="row">
													<label for="name">Username</label>
													<div class="text">
														<input id="name" name="username" type="text" value="<?php echo $this->input->post('username'); ?>"  />
													</div>
												</div>
												<div class="row">
													<label for="email">Email</label>
													<div class="text">
														<input id="email" type="text" name="email" value="<?php echo $this->input->post('email'); ?>"  />
													</div>
												</div>
												<div class="row">
													<label for="password2">Password</label>
													<div class="text">
														<input id="password2" name="password" type="password" value=""  />
													</div>
												</div>
												<div class="row">
													<label for="password3">Re-type Password</label>
													<div class="text">
														<input id="password3" name="passconf" type="password" value=""  />
													</div>
												</div>
												<div class="row">
													<input type="submit" name="submit" class="submit" value="Submit" />
												</div>
											</fieldset>
										<?php echo form_close(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="count-holder">
						<div class="total">
							<strong class="number"><?php echo number_format($total_contacts);?></strong>
							<span>total contracts</span>
						</div>
						<dl>
							<dt><?php echo number_format($total_online);?></dt>
							<dd>online users</dd>
							<dt><?php echo number_format($total_active);?></dt>
							<dd>active users</dd>
						</dl>
					</div>
				</div>
				<div class="leaderboard-block">
					<div class="heading">
						<span class="title">leaderboard</span>
					</div>
					<div class="holder">
						<div class="content">
							<ul>
								<li>
									<strong class="title">mission completed</strong>
									<ol>
                                    <?php foreach($leaderboard_project as $user):?>
										<li>
											<a href="/user/<?php echo $user['user_id'];?>">
                                            	<img src="/public/<?php echo ($myProfile['avatar'])? '/public/'.$myProfile['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $me['email'] ) ) );?>" alt="profile picture" class="alignleft" width="39" height="39" /></a>
											<div class="info">
												<a href="/user/<?php echo $user['user_id'];?>" class="name"><?php echo $user['username'];?></a>
												<span><?php echo $user['num'];?> missions</span>
											</div>
										</li>
                                        <?php endforeach;?>
									</ol>
								</li>
								<li>
									<strong class="title">points gained</strong>
									<ol>
                                    	<?php foreach($leaderboard_points as $user):?>
										<li>
											<a href="/user/<?php echo $user['user_id'];?>">
                                            	<img src="/public/<?php echo ($myProfile['avatar'])? '/public/'.$myProfile['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $me['email'] ) ) );?>" alt="profile picture" class="alignleft" width="39" height="39" /></a>
											<div class="info">
												<a href="/user/<?php echo $user['user_id'];?>" class="name"><?php echo $user['username'];?></a>
												<span><?php echo $user['exp'];?> points</span>
											</div>
										</li>
                                        <?php endforeach;?>
									</ol>
								</li>
								<li>
									<strong class="title">early submission</strong>
									<ol>
                                    	<?php foreach($leaderboard_time as $user):?>
										<li>
											<a href="/user/<?php echo $user['user_id'];?>">
                                            	<img src="/public/<?php echo ($myProfile['avatar'])? '/public/'.$myProfile['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $me['email'] ) ) );?>" alt="profile picture" class="alignleft" width="39" height="39" /></a>
											<div class="info">
												<a href="/user/<?php echo $user['user_id'];?>" class="name"><?php echo $user['username'];?></a>
												<span><?php echo $user['exp'];?> hours</span>
											</div>
										</li>
                                        <?php endforeach;?>
									</ol>
								</li>
							</ul>
							<div class="row">
								<div class="share-holder"><a name="fb_share" share_url="www.workpad.my"></a></div>
                                <script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
								<a href="/leaderboard" class="show">show full leaderboard</a>
							</div>
						</div>
					</div>
				</div>
			</div>
            <div id="summary">
            	<h2>How It Works</h2>
            	<div class="content">
                	<div style="margin:auto 0; height:200px;">
                	<img src="<?php echo base_url();?>/public/images/summary.png" />
                    </div>
                </div>
            </div>
			<div id="content">
				<h2>search contracts</h2>
                <?php echo form_open('/stories/browse' , array('class'=>'search-form', 'name' => "browse-tools-form")); ?>
					<fieldset>
						<label for="search">Search keyword</label>
						<div class="input-holder">
							<input type="text" class="text" name="search" id="search" value="" />
							<input type="submit" class="submit" value="submit" />
						</div>
					</fieldset>
				<?php echo form_close(); ?>
				<div class="columns">
					<div class="column">
						<h3>Projects</h3>
						<ul>
                        	<?php foreach($projects as $project):?>
							<li id="project-list-<?php echo $project['project_id'];?>" class="<?php if($project_sel == $project['project_id']){?>active <?php }?>project-list"><a href="javascript: void(0)" onClick="project_sel(<?php echo $project['project_id'];?>,'<?php echo $this->security->get_csrf_hash(); ?>')"><?php echo $project['project_name'];?></a></li>
                            <?php endforeach;?>
						</ul>
					</div>
					<div class="column categories">
						<h3>Categories</h3>
						<ul id="category_list">
                        	<li id="category-list-0" class="<?php if($category_sel == '' || $category_sel == 0){?>active <?php }?>category-list"><a href="javascript: void(0)" onClick="category_sel(0,'<?php echo $this->security->get_csrf_hash(); ?>')">General</a></li>
                        	<?php foreach($categories as $category):?>
							<li id="category-list-<?php echo $category['id'];?>" class="<?php if($category_sel == $category['id']){?>active <?php }?>category-list"><a href="javascript: void(0)" onClick="category_sel(<?php echo $category['id'];?>,'<?php echo $this->security->get_csrf_hash(); ?>')"><?php echo $category['name'];?></a></li>
                            <?php endforeach;?>
						</ul>
					</div>
					<div class="column stories">
						<h3 class="dialog_step1">User Stories</h3>
						<ul id="story_list">
                        	<?php foreach($stories as $story):?>
							<li>
								<a href="#homepage" class="link-popup-1"><span class="price">RM<?php echo number_format($story['cost']);?></span><span class="story"><?php echo $story['title'];?></span></a>
								<div class="popup-1">
									<div class="heading">
										<div class="holder">
											<span class="title"><?php echo $story['title'];?></span>
											<span>(RM<?php echo number_format($story['cost']);?>)</span>
										</div>
										<a href="#" class="close">close</a>
									</div>
									<dl>
										<dt>Bids</dt>
										<dd><?php echo $story['bids'];?></dd>
										<dt>Comments</dt>
										<dd><?php echo $story['comments'];?></dd>
										<dt>Points</dt>
										<dd><?php echo $story['points'];?></dd>
									</dl>
									<div class="summary">
										<span class="summary-text" style="text-align:justify"><?php echo substr(strip_tags($story['description']),0,255); if(strlen(strip_tags($story['description']))>255)echo '...';?></span>
										
									</div>
									<div class="button-holder">
										<a class="button" href="/story/<?php echo $story['work_id'];?>"><span class="left">Know More</span></a>
									</div>
								</div>
							</li>
                            <?php endforeach;?>
						</ul>
                        <script type="text/javascript">
						$('#story_list').paginate();
						</script>
					</div>
				</div>
			</div>
		</div>
<?php $this->load->view('includes/footer'); ?>