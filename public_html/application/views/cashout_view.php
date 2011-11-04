<?php $this->load->view('includes/header'); ?>
<div id="wrapper">
	<div class="contents">
		<div class="profile-heading" style="background:none;">
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
			<a href="#">
			<img src="/public/<?php echo $myProfile['avatar'];?>" alt="profile picture" class="alignleft" width="104" height="100" />
			</a>
			<div class="main-info">
				<h2><?php echo $me['username'];?></h2>
				<span class="name"><?php echo $myProfile['full_name'];?></span>
				<div class="row">
					<?php if($myProfile['gender'] || $myProfile['birthdate']){?>
					<span class="sex">	<?php if($myProfile['gender']) echo $myProfile['gender'];
						if($myProfile['birthdate']) echo ', '.(date('Y')-date('Y', strtotime($myProfile['birthdate'])));
						?></span>
					<?php }?>
					<div class="specialization">
						<span class="left"><?php echo $myProfile['specialization'];?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="cash-block" style="background:rgba(0, 0, 0, 0.4);">
			<div class="cash-holder">
				<h3>Congratulations!</h3>
				<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
				<div class="proceed" style="margin-top:20px;">
					<a class="submit" href="">Cash Out</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('includes/footer'); ?>