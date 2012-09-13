<link href='http://fonts.googleapis.com/css?family=Black+Ops+One' rel='stylesheet' type='text/css'>

<style>
	.fancybox-nav span {visibility: visible;}
	.fancybox-nav{top:30px;height:90%; width:60px;}
	.fancybox-next{right:-60px;}
	.fancybox-prev{left:-60px;}
	#mission_list{
		/* width:752px; */
		overflow-x : hidden;
	}
	.mission_list_header{
		border-bottom:2px solid #da921f;
		border-top:2px solid #da921f;
		background:black;
		color:#fff200;
		font-size:12pt;
		height:30px;
		padding:13px 0 0 12px;
	}
	.down-arrow{
		background:url(/public/images/codeArmy/mission/down-arrow.png) no-repeat;
		width:12px;height:6px;
	}
	.header-row{color:white; font-size:12px; clear:both; width:100%;height:25px; text-align:center;}
	.header-row div{ margin-right:2px; line-height:25px;}
	.header-row .col1{width:30px; height:25px; float:left}
	.header-row .col2{width:103px; height:25px; float:left}
	.header-row .col3{width:360px; height:25px; float:left; text-align:left; padding-left:5px;}
	.header-row .col4{width:70px; height:25px; float:left}
	.header-row .col5{width:30px; height:25px; float:left}
	.header-row .col6{width:50px; height:25px; float:left}
	.header-row .col7{width:80px; height:25px; float:left}
	.summary-row{color:white; font-size:11px; clear:both; width:100%;height:25px; text-align:center; border:1px solid #da921f; cursor:pointer}
	.summary-row:hover{background:#662600;}
	.summary-row.selected{background:#662600;}
	.summary-row div{ margin-right:2px; line-height:25px;}
	.summary-row .col1{width:29px; height:25px; float:left; border-right:1px solid #da921f;}
	.summary-row .col2{width:101px; height:25px; float:left; border-right:1px solid #da921f;}
	.summary-row .col3{width:360px; height:25px; float:left; text-align:left; padding-left:5px;}
	.summary-row .col4{width:70px; height:25px; float:left}
	.summary-row .col5{width:30px; height:25px; float:left}
	.summary-row .col6{width:50px; height:25px; float:left}
	.summary-row .col7{width:80px; height:25px; float:left}
	.detail-row{width:100%; height:247px; background:#da921f; border:1px solid #da921f; display:none;}
	.mission-video-preview{background:#da921f; width:260px;height:227px;border-right:1px solid white;}
	.mission-video-preview h2{color:white; font-size:14pt; text-align:justify;}
	.mission-description-container h2{background:#da921f; font-size:14pt; color:white; text-align:left;}
	.mission-description{background:white; width:441px; border:1px solid #da921f; height:97px; color:black;}
	.info{background:white; width:465px; height:107px; float:left}
	.info .header-row{height:34px; width:465px; background:#da921f;}
	.info .header-row .col1{float:left;width:100px;color:white; font-size:11pt;text-align:left;line-height:30px;padding-left:10px;}
	.info .header-row .col2{float:left;width:100px;color:white; font-size:11pt;text-align:left;line-height:30px;padding-left:10px;}
	.info .header-row .col3{float:left;width:224px;color:white; font-size:11pt;text-align:left;line-height:30px;padding-left:10px;}
	.info .data-row{height:34px; width:465px; background:red;height:73px;}
	.info .data-row .col1{float:left;width:100px;color:white; font-size:11pt;text-align:left;line-height:73px;padding-left:10px; background:white;border:1px solid #da921f;color:#cc6600;}
	.info .data-row .col2{float:left;width:100px;color:white; font-size:11pt;text-align:left;line-height:73px;padding-left:10px; text-align:center;border:1px solid #da921f;background:white;color:#cc6600;}
	.info .data-row .col3{float:left;width:229px;color:white; font-size:11pt;text-align:left;height:73px;line-height:35px;padding-left:10px;background:white;border:1px solid #da921f;color:#cc6600;}
	.detail-row{cursor:pointer;}
	
	.mission-list {padding-bottom:20px;}
	.mission-list .maplink {text-align:right; padding-top:20px } .mission-list .maplink a {color:#FFA800}
	.mission-list h1 {font-family: 'Black Ops One', cursive; font-size:1.6em; color:#FFA800; padding-bottom: 15px}
	.mission-list .headbox {background: #FFA800; color:black; font-weight:700; line-height:30px}
	.mission-list div[class*="span"] {border-left:1px solid black; padding-left:5px}
	.mission-list .lists div[class*="span"] {cursor:pointer; border:none; padding-top:10px}
	.mission-list a.mission_apply:nth-child(even) .lists {background:#1f1f1f}
	.mission-list a.mission_apply:nth-child(odd) .lists {background:#161616}
	.mission-list a.mission_apply:hover > .lists {background: #402800} 
	.mission-list a.mission_apply:hover .lists > div[class*="span"] {color:white; text-shadow: 0 1px 1px black}
	.mission-list .lists div[class*="span"]:nth-child(3),
	.mission-list .lists div[class*="span"]:nth-child(4),
	.mission-list .lists div[class*="span"]:nth-child(5),
	.mission-list .lists div[class*="span"]:nth-child(6) {text-align:center}
	.mission-list .skillset article {position:relative; width:32px; float:left; padding-left:7px}
	.mission-list .skillset article .level {position:absolute; top:-2px; right:-2px; background:#333; color:white; border-radius:50%; width:15px; height:15px; line-height:15px; border:1px solid black; font-size:.8em;}
</style>

<div class="mission-list container-fluid">
	
	<div class="slidelist">
		<div class="row-fluid">
			<div class="pull-left span6"><h1>Latest Missions (All)</h1></div>
			<div class="pull-right span6 maplink"><a href="#"><i class="icon-globe"></i> Back to world map</a></div>
		</div>
		<div class="row-fluid headbox">
			<div class="span1">Category</div>
			<div class="span4">Title</div>
			<div class="span2">Skills Required</div>
			<div class="span1">Bids</div>
			<div class="span2">Time Left</div>
			<div class="span2">Payout (USD)</div>
		</div>
		<?php foreach($works as $i=>$work):?>
		<a href="javascript:void(0)" rel="/missions/apply/<?=$work['work_id']?>" class="mission_apply">
			<div class="row-fluid lists">
				<div class="span1"><img src="/public/images/codeArmy/missionlist/<?=$work['image_file']?>" width="70" height="60" alt="Icon Design"></div>
				<div class="span4"><?=$work['title']?></div>
				<div class="span2 skillset clearfix">
                	<?php $skills = $this->skill_model->get_work_skills($work['work_id'],3); ?>
                    <?php foreach($skills as $skill):?>
					<article>
						<img src="../../public/images/codeArmy/missionlist/<?=$skill['image_file']?>" width="32" height="32" alt="Icon Skill">
						<span class="level"><?=$skill['point']?></span>
					</article>
                    <?php endforeach;?>
					<!--<article>
						<img src="../../public/images/codeArmy/missionlist/icon-skill.png" width="32" height="32" alt="Icon Skill">
						<span class="level">6</span>
					</article>
					<article>
						<img src="../../public/images/codeArmy/missionlist/icon-skill.png" width="32" height="32" alt="Icon Skill">
						<span class="level">3</span>
					</article>-->
				</div>
				<div class="span1"><?=$work['num_bids']?></div>
				<div class="span2"><?=$work['end']?></div>
				<div class="span2"><?=$work['cost']?></div>
			</div>
		</a>
		<?php endforeach;?>

		<!-- <div id="mission_list">
			<div class="mission_list_header">Latest Missions (All)</div>
		    <div class="down-arrow"></div>
		    <div class="header-row">
		    	<div class="col1">#</div>
		        <div class="col2">Type</div>
		        <div class="col3">Task Description</div>
		        <div class="col4">Payout</div>
		        <div class="col5">Bids</div>
		        <div class="col6">comments</div>
		        <div class="col7">End</div>
		    </div>
		    <?php foreach($works as $i=>$work):?>
		    <div class="summary-row" id="summary-<?=$work['work_id']?>">
		    	<div class="col1"><?=$i+1?></div>
		        <div class="col2"><?=$work['category']?></div>
		        <div class="col3"><?=$work['title']?></div>
		        <div class="col4"><?=$work['cost']?></div>
		        <div class="col5"><?=$work['num_bids']?></div>
		        <div class="col6"><?=$work['num_comments']?></div>
		        <div class="col7"><?=$work['end']?></div>
		    </div>
		    <div class="detail-row" id="detail-<?=$work['work_id']?>">
				<a href="javascript:void(0)" rel="/missions/apply/<?=$work['work_id']?>" class="mission_apply">
		    	<div class="mission-video-preview">
		      		<iframe class="youtube-player" type="text/html" width="250" height="150" src="http://www.youtube.com/embed/<?=$work['tutorial']?$work['tutorial']:'zFNb8j3YAd4'?>?wmode=opaque" frameborder="0"></iframe>
		        	<h2><?=$work['title']?></h2>
		        </div>
		        <div class="mission-description-container">
		        	<h2 class="mission-description-header">Description</h2>
		            <div class="mission-description">
		            	<?=substr(strip_tags($work['description']),0,250)?><?=(strlen($work['description'])>250)?'...':''?>
		            </div>
		        </div>
		        <div class="info">
		        	<div class="header-row">
		            	<div class="col1">Time</div>
		                <div class="col2">Payout <span style="color:#ffd339">(USD)</span></div>
		                <div class="col3">Pre-Requisite</div>
		            </div>
		            <div class="data-row">
		            	<div class="col1"><?=$work['end']?></div>
		                <div class="col2"><?=$work['cost']?> $</div>
		                <div class="col3">
		                	<?php $skills = $this->skill_model->get_work_skills($work['work_id'],3);?>
		                	<table border="1" cellspacing="3px" cellpadding="3px" width="100%">
		                    	<tr style="margin:3px;">
		                        	<td>Skills:</td>
		                            <?php foreach($skills as $skill):?>
		                            <td style="text-align:center;border:1px solid #fc0;background:#333;"><?=$skill['name']?></td>
		                            <?php endforeach;?>
		                        </tr>
		                        <tr>
		                        	<td>Levels:</td>
		                            <?php foreach($skills as $skill):?>
		                            <td style="text-align:center;border:1px solid #fc0;background:#333;"><?=$skill['point']?></td>
		                            <?php endforeach;?>
		                        </tr>
		                    </table>
		                </div>
		            </div>
		        </div>
		        </a>
		    </div>
		    <?php endforeach;?>
		</div> -->
	</div>
	
	<div class="slideapply" style="display:none">
		<div class="row-fluid" style="padding-bottom:20px; color:white">
			<div class="pull span2"><a class="btn btn-warning" id="returnlist">Back</a></div>
		</div>	
		<div class="apply"></div>
	</div>
	
</div>
<script type="text/javascript" src="/public/js/jscrollpane.js"></script>
<script type="text/javascript" src="http://jscrollpane.kelvinluck.com/script/jquery.mousewheel.js"></script>
<script type="text/javascript" src="/public/js/codeArmy/lightboxme.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('a.mission_apply').bind('click',function(e){
			
			var frame = $(this).attr('rel');
			/* $('.mission-frame').lightbox_me({
				showOverlay :true,
				closeSelector: ".closeme",
				//closeClick: true,
				onLoad: function(){
					$('.mission-frame').append('<iframe src="'+frame+'" frameborder="0" width="100%" height="100%"></iframe>');
				},
				onClose: function() {
					$('.mission-frame iframe').remove();
				}
			}); */
			
			$('.missionlist .slidelist').slideUp();
			$('.missionlist .slideapply').slideDown(function(){
				$('.slideapply .apply').html('<iframe src="'+frame+'" frameborder="0" width="100%" height="1500"></iframe>');
				$('.nano').nanoScroller();
			})
			e.preventDefault();
		});
		
		$('a#returnlist').click(function(){
			$('.slidelist').slideDown();
			$('.slideapply').slideUp(function(){ $('.slideapply .apply').find('iframe').remove(); });
		})
		
	})
</script>