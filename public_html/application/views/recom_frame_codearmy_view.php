<?php $this->load->view('includes/frame_header.php'); ?>
<div id="recom_profile">
		<div class="left" style="float:left">
			<div id="block-avatar">
			    <div id="profile-name"><?=substr($user["username"],0,15);?></div>
			    <a id="msg-icon" target="_blank" href="/messages/compose/<?=substr($user["username"],0,15);?>"></a>
			    <div id="profile-type"><?=$user_profile["specialization"]?> <?php if(trim($myCountry)!=""){?>&nbsp;&nbsp; [<?=$myCountry?>] <?php }?></div>
			    <div id="avatar-pic"> <img src="/public/images/codeArmy/profile/default-avatar.png" alt="Avatar Picture"> </div>
			    <div id="profile-desc"><?=$user_profile["status_msg"]?></div>
			  </div>
			
			<div id="mission-complete">
			   <div id="mission-complete-text">Mission In Progress</div>
		       <div id="mission-complete-number"><?=$completed?></div>
		    </div>
		</div>
		
		<div class="right" style="float:right">
			<div id="block-experience">
			    <div id="experience-header">
			      <h3>Level <?=$myLevel?> (Exp Points:<?=$user["exp"];?>)</h3>
			    </div> 
			    <div id="experience-bar">
			      <div style="width:<?=round(443*$expProgress)?>px" id="experience-bar-progress"> </div>
			    </div>
			</div>
			<div id="block-skill-progression">
			    <div class="block-header active">
			      <h3>Skill Progression</h3>
				  <div class="collapse-arrow"><i class="icon-list-ul"></i></div>
			    </div>
			    <div class="skill-wrapper">
				<?php
                if ($mySkills){
                    foreach($mySkills as $skill):
                ?>
                <div class="skill-unit">
                  <div id="skill-title"><?=ucfirst($skill["name"])?></div>
                  <div id="skill-bar">
                    <div style="width:<?=$skill["point"]?>%" id="skill-bar-progress"></div>
                  </div>
                </div>
                <?php
                    endforeach;
                }
                ?>
			    </div>
			</div>
			
			<div id="block-achievements" style="width:460px">
			    <div class="block-header">
			      <h3>Achievements</h3>
			      <div class="collapse-arrow"><i class="icon-list-ul"></i></div>
			  </div>
			  	<div class="badge-row">
    <?php
	if (!$myBadges){$myBadges=array();}
		for($i=0; $i<=7; $i++){
			if (array_key_exists($i, $myBadges)) {
	?>
      <div id="achievement-unit">
        <img src="/public/<?=$myBadges[$i]["achievement_pic"]?>" width="97" height="99" alt="<?=ucfirst(strtolower($myBadges[$i]["achievement_name"]))?>" title="<?=ucfirst(strtolower($myBadges[$i]["achievement_name"]))?>" />
      </div>
    <?php
			} else {
	?>
      <div id="achievement-unit">
        <div id="badge-unit"></div>
      </div>
    <?php
			}
		}
	?>
			   </div>
		</div>
		
		<div class="clearfix"></div>
</div>
<style type="text/css">
	/* Contractors popup */
	#recom_profile {padding:10px; background:url(http://subtlepatterns.com/patterns/dark_wall.png) repeat; overflow:hidden}
	#block-avatar, #block-experience, #block-skill-progression, #mission-complete, #block-achievements {float:none; overflow:hidden}
	#block-avatar, #experience-header, #block-skill-progression, #block-achievements {text-align:left}
	.badge-row {display:none}
	.block-header {overflow:hidden; cursor:pointer; width: 450px}
	.block-header .collapse-arrow {float:right}
	.block-header:hover, .block-header.active{color:#ff7d0f}
	#mission-complete {margin:5px auto 0}
</style>
<script type="text/javascript">
	//contractors popup
	$('.recom-box-unit').css('cursor','pointer');
	
	$('#block-skill-progression .block-header').bind('click',function(){ 
		$('.block-header').removeClass('active');
		$(this).addClass('active');
		$(this).next().slideDown("slow");
		$('.badge-row').slideUp();
	});
	$('#block-achievements .block-header').bind('click',function(){ 
		$('.block-header').removeClass('active');
		$(this).addClass('active');
		$(this).next().slideDown("slow");
		$('.skill-wrapper').slideUp();
	});
</script>
<?php $this->load->view('includes/frame_footer.php'); ?>