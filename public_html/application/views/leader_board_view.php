<?php $this->load->view('includes/header4'); ?>
<link media="all" type="text/css" rel="stylesheet" href="/public/css/style.css">
<link media="all" type="text/css" rel="stylesheet" href="/public/css/v4/workpad.css">
<script type="text/javascript">
	var mission_leaderboard = new Array();
	var points_leaderboard = new Array();
	var time_leaderboard = new Array();
</script>
<style>
.WP-header-placeholder .WP-profile-header li { margin-left:20px !important; }
.WP-header-placeholder .WP-profile-header ul {width:205px !important;}
.WP-header-placeholder .WP-profile-header li.last {margin-left: 9px !important;}
</style>
			<div id="wrapper">
				<div class="WP-main" style="margin-top:100px;">
				<div class="leaderboard-block" style="float:none; width:100%; background:none;">
					<h1 style="text-shadow: 0 1px 10px white;font-size: 33px;padding-bottom:20px;">Leaderboard</h1>
                                    <ul id="leader-list">
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
                                            </ol>
                                        </li>
                                    </ul>
                    </div>
				</div><!--End of the Contents -->
			</div><!-- End of the Wrapper -->
<script type="text/javascript">
	myPos = $('.my_pos');
	if(myPos.offset()){
		 $('html,body').animate({scrollTop: myPos.offset().top-100},'slow', function(){
					myPos.fadeOut(500).fadeIn(500);
			 });
	}
	setInterval(function(){$.post('<?php echo base_url();?>leaderboard/Ajax_leaderboard',function(data){
			response = data.split("~");
			$('#leader-list').html(response[1]);
			sections = response[0].split(';');
			missions = sections[0];
			points = sections[1];
			times = sections[2];
			missions = missions.split(',');
			points = points.split(',');
			times = times.split(',');
			//alert(missions);
			for(i=0; i<missions.length;i++){
				//for pos i
				newUser = missions[i];
				oldUser = mission_leaderboard[i];
				if(newUser!=oldUser){
					found = false;
					for(j=0; j<i; j++)
						if(mission_leaderboard[j] == newUser)found = true;
					if(!found){
						//winer is new user
						//todo: animate two users
						
					}
					//at end update leaderboard cach
					mission_leaderboard[i] = newUser;	
				}
			}
			for(i=0; i<points.length;i++){
				//for pos i
				newUser = points[i];
				oldUser = points_leaderboard[i];
				if(newUser!=oldUser){
					found = false;
					for(j=0; j<i; j++)
						if(points_leaderboard[j] == newUser)found = true;
					if(!found){
						//winer is new user
						//todo: animate two users
						
					}
					//at end update leaderboard cach
					points_leaderboard[i] = newUser;	
				}
			}
			for(i=0; i<times.length;i++){
				//for pos i
				newUser = times[i];
				oldUser = time_leaderboard[i];
				if(newUser!=oldUser){
					found = false;
					for(j=0; j<i; j++)
						if(time_leaderboard[j] == newUser)found = true;
					if(!found){
						//winer is new user
						//todo: animate two users
						
					}
					//at end update leaderboard cach
					time_leaderboard[i] = newUser;	
				}
			}
		});},1000);
</script>
<?php $this->load->view('includes/footer4'); ?>