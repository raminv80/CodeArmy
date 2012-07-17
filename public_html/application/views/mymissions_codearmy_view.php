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
#mymission-content-area ul{
	clear:both;
}
#mymission-content-area ul li{
	float: left;
	width:246px;
	height:302px;
	margin: 13px 6px 52px 0;
}
#mymission-content-area ul li.gray-mission{background:url(/public/images/codeArmy/mymission/gray-mission.png) no-repeat;}
#mymission-content-area ul li.green-mission{background:url(/public/images/codeArmy/mymission/green-mission.png) no-repeat;}
#mymission-content-area ul li.orange-mission{background:url(/public/images/codeArmy/mymission/orange-mission.png) no-repeat;}
#mymission-content-area ul li.red-mission{background:url(/public/images/codeArmy/mymission/red-mission.png) no-repeat;}
</style>
<div id="mymission-content-area">
	<div id="block-mission-list">
    	<div class="block-header">
        	<h3>My Missions</h3>
        </div>
        <ul>
            <li class="green-mission">
            	<div class="mission-header">
                	<div class="mission-title">Title of mission (task)</div>
                    <div class="mission-status-icon"></div>
                    <div class="mission-progress-bg">
                    	<div class="mission-progress-meter"></div>
                    </div>
                    <div class="mission-inputs">Inputs: IA, Wireframes</div>
                    <div class="mission-deliverables">Deliverables: HTML files, PSD files</div>
                </div>
                <div class="mission-content">
                	<ul class="mission-icons">
                		<li>Captain</li>
                        <li>4 Troopers</li>
                        <li>Discussion</li>
                        <li>Attachments</li>
                    </ul>
                    <div class="mission-time">
                    	<span>Time left</span>
                        <span>15:00</span>
                        <span>hrs</span>
                        <a href="#" class="blue-button">check in</a>
                    </div>
                </div>
            </li>
            <li class="gray-mission">
            </li>
            <li class="orange-mission">
            </li>
            <li class="orange-mission">
            </li>
            <li class="red-mission">
            </li>
            <li class="gray-mission">
            </li>
        </ul>
    </div>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>