<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<style>
#mymission-content-area{
	/*background:url(/public/images/codeArmy/profile/missions/temp.png) no-repeat;*/
	width:760px;
}
#main-content { overflow:scroll;}
#mymission-content-area .block-header h3 {
	margin:1px 5px;
	height: 33px;
	font-size:12.96pt;
	color:white;
	font-family:'Ruda', sans-serif;
	text-shadow: 0px 0px 3px rgba(255, 255, 255, 0.5);
	display:block;
	width:229px;
	height:33px;
	float:left;
	background:url(/public/images/codeArmy/profile/block-header-line.png) no-repeat;
}
#mymission-content-area div.list{
	clear:both;
}
#mymission-content-area div.list .item{
	float: left;
	width:246px;
	height:302px;
	margin: 13px 6px 52px 0;
}
#block-mission-list .list .item.gray-mission{background:url(/public/images/codeArmy/mymission/gray-mission.png) no-repeat;}
#block-mission-list .list .item.green-mission{background:url(/public/images/codeArmy/mymission/green-mission.png) no-repeat;}
#block-mission-list .list .item.orange-mission{background:url(/public/images/codeArmy/mymission/orange-mission.png) no-repeat;}
#block-mission-list .list .item.red-mission{background:url(/public/images/codeArmy/mymission/red-mission.png) no-repeat;}
#block-mission-list .mission-header{position:relative}
#block-mission-list .mission-title{
	text-shadow: -1px -1px 1px rgba(100,100,100,0.5);
	font-size:9.99pt;
	color:white;
	position:absolute;
	top:15px;
	left: 15px;
	width:180px;
	text-align:justify;
	font-weight:bold;
}
#block-mission-list .mission-inputs{
	font-size:9.36pt;
	color:white;
	position:absolute;
	top:85px;
	left:15px;	
}
#block-mission-list .mission-deliverables{
	font-size:9.36pt;
	color:white;
	position:absolute;
	top:100px;
	left:15px;	
}
#block-mission-list .mission-content{
	position:relative;
	top:130px;
	height:170px;
}
#block-mission-list ul.mission-icons {
	margin: 5px;
}
#block-mission-list  ul.mission-icons li{
	float: left;
	display: block;
	margin: 0 0 3px 4px;
	width: 100px;
	height: 30px;
}
#block-mission-list .mission-icons .icon{
	display: block;
	width: 28px;
	height: 29px;
	float: left;
	margin: 5px 0 0 5px;
}
#block-mission-list .mission-icons .title{
	display: block;
	width: 60px;
	height: 15px;
	float: left;
	margin: 11px 0 0 7px;
	font-size:8.64pt;
}
#block-mission-list .mission-time{
	clear:both;
	position:relative;
	display:block;
	height:80px;
	padding:10px;
}
#block-mission-list .mission-time{color:white}
#block-mission-list .mission-time .time-left{
	font-size:7.2pt;
	position:absolute;
	top:39px;
}
#block-mission-list .mission-time .time{
	font-size:18pt;
	position:absolute;
	bottom:20px;
}
#block-mission-list .mission-time .hrs{
	font-size:12pt;
	position:absolute;
	bottom:20px;
	left:77px;
}
#block-mission-list .mission-progress-bg{
	position: absolute;
	top: 59px;
	height: 13px;
	left: 15px;
	width: 216px;
}
#block-mission-list .mission-progress-meter{
	background:url(/public/images/codeArmy/mymission/progress-meter-bg.png);
	width:100px;
	height:13px;
	border-radius: 5px; 
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px;
}
#block-mission-list .blue-button{
	background: url(/public/images/codeArmy/mymission/Blue-button.png) no-repeat;
	width: 114px;
	height: 48px;
	display: block;
	position: absolute;
	top: 38px;
	right: 20px;
	text-align: center;
	padding: 16px 0;
	font-size:10pt;
}
</style>
<div id="mymission-content-area">
	<div id="block-mission-list">
    	<div class="block-header">
        	<h3>My Missions</h3>
        </div>
        <div class="list">
            <div class="item green-mission">
            	<?php $progress_percent = 0.3;?>
            	<div class="mission-header">
                	<div class="mission-title">Title of mission (task)</div>
                    <div class="mission-status-icon"></div>
                    <div class="mission-progress-bg">
                    	<div class="mission-progress-meter" style="width:<?= 216*$progress_percent ?>px"></div>
                    </div>
                    <div class="mission-inputs">Inputs: IA, Wireframes</div>
                    <div class="mission-deliverables">Deliverables: HTML files, PSD files</div>
                </div>
                <div class="mission-content">
                	<ul class="mission-icons">
                		<li><span class="icon"></span><span class="title">Captain</span></li>
                        <li><span class="icon"></span><span class="title">3 Troopers</span></li>
                        <li><span class="icon"></span><span class="title">Discussion</span></li>
                        <li><span class="icon"></span><span class="title">Attachements</span></li>
                    </ul>
                    <div class="mission-time">
                    	<span class="time-left">Time left</span>
                        <span class="time">15:00</span>
                        <span class="hrs">hrs</span>
                        <a href="#" class="blue-button">Check in</a>
                    </div>
                </div>
            </div>
            
            <div class="item red-mission">
            	<?php $progress_percent = 0.3;?>
            	<div class="mission-header">
                	<div class="mission-title">Title of mission (task)</div>
                    <div class="mission-status-icon"></div>
                    <div class="mission-progress-bg">
                    	<div class="mission-progress-meter" style="width:<?= 216*$progress_percent ?>px"></div>
                    </div>
                    <div class="mission-inputs">Inputs: IA, Wireframes</div>
                    <div class="mission-deliverables">Deliverables: HTML files, PSD files</div>
                </div>
                <div class="mission-content">
                	<ul class="mission-icons">
                		<li><span class="icon"></span><span class="title">Captain</span></li>
                        <li><span class="icon"></span><span class="title">3 Troopers</span></li>
                        <li><span class="icon"></span><span class="title">Discussion</span></li>
                        <li><span class="icon"></span><span class="title">Attachements</span></li>
                    </ul>
                    <div class="mission-time">
                    	<span class="time-left">Time left</span>
                        <span class="time">15:00</span>
                        <span class="hrs">hrs</span>
                        <a href="#" class="blue-button">Check in</a>
                    </div>
                </div>
            </div>
            
            <div class="item gray-mission">
            	<?php $progress_percent = 0.3;?>
            	<div class="mission-header">
                	<div class="mission-title">Title of mission (task)</div>
                    <div class="mission-status-icon"></div>
                    <div class="mission-progress-bg">
                    	<div class="mission-progress-meter" style="width:<?= 216*$progress_percent ?>px"></div>
                    </div>
                    <div class="mission-inputs">Inputs: IA, Wireframes</div>
                    <div class="mission-deliverables">Deliverables: HTML files, PSD files</div>
                </div>
                <div class="mission-content">
                	<ul class="mission-icons">
                		<li><span class="icon"></span><span class="title">Captain</span></li>
                        <li><span class="icon"></span><span class="title">3 Troopers</span></li>
                        <li><span class="icon"></span><span class="title">Discussion</span></li>
                        <li><span class="icon"></span><span class="title">Attachements</span></li>
                    </ul>
                    <div class="mission-time">
                    	<span class="time-left">Time left</span>
                        <span class="time">15:00</span>
                        <span class="hrs">hrs</span>
                        <a href="#" class="blue-button">Check in</a>
                    </div>
                </div>
            </div>
            
            <div class="item orange-mission">
            	<?php $progress_percent = 0.3;?>
            	<div class="mission-header">
                	<div class="mission-title">Title of mission (task)</div>
                    <div class="mission-status-icon"></div>
                    <div class="mission-progress-bg">
                    	<div class="mission-progress-meter" style="width:<?= 216*$progress_percent ?>px"></div>
                    </div>
                    <div class="mission-inputs">Inputs: IA, Wireframes</div>
                    <div class="mission-deliverables">Deliverables: HTML files, PSD files</div>
                </div>
                <div class="mission-content">
                	<ul class="mission-icons">
                		<li><span class="icon"></span><span class="title">Captain</span></li>
                        <li><span class="icon"></span><span class="title">3 Troopers</span></li>
                        <li><span class="icon"></span><span class="title">Discussion</span></li>
                        <li><span class="icon"></span><span class="title">Attachements</span></li>
                    </ul>
                    <div class="mission-time">
                    	<span class="time-left">Time left</span>
                        <span class="time">15:00</span>
                        <span class="hrs">hrs</span>
                        <a href="#" class="blue-button">Check in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>