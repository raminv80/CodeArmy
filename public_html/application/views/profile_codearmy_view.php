<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<!--<img src="/public/images/codeArmy/profile/temp-final.png" id="preview"/>-->
<style type="text/css">
<!--

#content_area {
	position:absolute;
	left:17px;
	top:17px;
	width:766px;
	height:794px;
}

#block-level-indicator {
	width: 279px;
	height: 7px;
	text-align: right;
	padding: 9px 0px;
	font-size: 9.99pt;
}

#block-experience-bar{
	position:absolute;
	left:290px;
	top:0px;
}
#block-experience-bar #experience-meter {
	width:476px;
	height:18px;
	margin-left:12px;
	padding:3px 2px;
	background:url(/public/images/codeArmy/profile/experience-bar-background.png) no-repeat;
}
#block-experience-bar #meter{
	background:url(/public/images/codeArmy/profile/meter.png);
	height:14px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}

#experience-points {
	width:402px;
	height:29px;
}

#edit-profile {
	position:absolute;
	left:692px;
	top:0px;
	width:74px;
	height:29px;
}

#introduction {
	position:absolute;
	left:1px;
	top:30px;
	width:289px;
	height:72px;
	background:url(/public/images/codeArmy/profile/introduction.png) no-repeat;
}

#action-summary {
	position:absolute;
	left:290px;
	top:47px;
	width:476px;
	height:144px;
}

#avatar-pic {
	position:absolute;
	left:0px;
	top:102px;
	width:290px;
	height:274px;
}

#skill-header {
	position:absolute;
	left:290px;
	top:191px;
	width:476px;
	height:36px;
}

#skills {
	position:absolute;
	left:290px;
	top:227px;
	width:476px;
	height:142px;
}

#achievement-header {
	position:absolute;
	left:290px;
	top:369px;
	width:476px;
	height:42px;
}

#description {
	position:absolute;
	left:0px;
	top:376px;
	width:290px;
	height:107px;
}

#achievements {
	position:absolute;
	left:290px;
	top:411px;
	width:476px;
	height:268px;
}

#leaderboard-header {
	position:absolute;
	left:0px;
	top:483px;
	width:290px;
	height:77px;
}

#leaderboard {
	position:absolute;
	left:0px;
	top:560px;
	width:290px;
	height:234px;
}

#activities-header {
	position:absolute;
	left:290px;
	top:679px;
	width:476px;
	height:42px;
}

#activities {
	position:absolute;
	left:290px;
	top:721px;
	width:476px;
	height:73px;
}

#content_area h1{font-size:18pt}
#content_area h2{font-size:13pt}
#content_area{font-size:9pt; color:white}

-->
</style>
<div id="content_area">
	<!-- Block level indicator -->
	<div id="block-level-indicator">
		Level <?=$myLevel?>
	</div>
    <!-- end of level indicator -->
    <!-- -->
    <dic id="block-experience-bar">
        <div id="experience-points">
            <img src="/public/images/codeArmy/profile/experience_points.png" width="402" height="29" alt="">
        </div>
        <div id="experience-meter">
            <div id="meter" style="width:<?= 443*$expProgress ?>px;"></div>
        </div>
    </div>
	<div id="edit-/public/images/codeArmy/profile">
		<img src="/public/images/codeArmy/profile/edit_profile.png" width="74" height="29" alt="">
	</div>
	<div id="introduction">
		<h1 style="margin:17px 0 5px 15px"><?=$me['username']?></h1>
        <p style="margin-left:15px;"><?=ucwords($myProfile['specialization'])?>    [Malaysia]</p>
	</div>
	<div id="action-summary">
		<img src="/public/images/codeArmy/profile/action_summary.png" width="476" height="144" alt="">
	</div>
	<div id="avatar-pic">
		<img src="/public/images/codeArmy/profile/avatar_pic.png" width="290" height="274" alt="">
	</div>
	<div id="skill-header">
		<img src="/public/images/codeArmy/profile/skill_header.png" width="476" height="36" alt="">
	</div>
	<div id="skills">
		<img src="/public/images/codeArmy/profile/skills.png" width="476" height="142" alt="">
	</div>
	<div id="achievement-header">
		<img src="/public/images/codeArmy/profile/achievement_header.png" width="476" height="42" alt="">
	</div>
	<div id="description">
		<img src="/public/images/codeArmy/profile/description.png" width="290" height="107" alt="">
	</div>
	<div id="achievements">
		<img src="/public/images/codeArmy/profile/achievements.png" width="476" height="268" alt="">
	</div>
	<div id="leaderboard-header">
		<img src="/public/images/codeArmy/profile/leaderboard_header.png" width="290" height="77" alt="">
	</div>
	<div id="leaderboard">
		<img src="/public/images/codeArmy/profile/leaderboard.png" width="290" height="234" alt="">
	</div>
	<div id="activities-header">
		<img src="/public/images/codeArmy/profile/activities_header.png" width="476" height="42" alt="">
	</div>
	<div id="activities">
		<img src="/public/images/codeArmy/profile/activities.png" width="476" height="73" alt="">
	</div>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>