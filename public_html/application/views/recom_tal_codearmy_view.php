<link href="/public/css/CodeArmyV1/style.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/public/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="/public/js/jPages.min.js"></script>

<div class="recom-tal-container"> <a href="#"><img class="recom-page-nav-left" src="/public/images/codeArmy/mission/recom-page-left-nav.png" /></a> <a href="#"><img class="recom-page-nav-right" src="/public/images/codeArmy/mission/recom-page-right-nav.png" /></a>
  <div class="recom-tal-inner">
    <div class="title-top-bar">
      <div class="recom-title">
        <div class="recom-title-main">Recommended Contractors</div>
        <div class="recom-title-text">Brief explanation about Recommended Contractors here.</div>
      </div>
      <div class="recom-matches">
        <div class="recom-matches-number"><?=count($recoms)?></div>
        <div class="recom-matches-text">matches</div>
      </div>
    </div>

    <div class="recom-boxes-container">
	<div id="recom-boxes-wrapper">
      <?php for($i=$page*$num_per_page;$i<min(($page+1)*$num_per_page,count($recoms));$i++){?>
      <?php
	  	$user_id = $recoms[$i]['user_id'];
	  	$user = $this->users_model->get_user($user_id)->result_array();$user=$user[0];
		$profile = $this->users_model->get_profile($user_id)->result_array();$profile=$profile[0];
		$country="";
		$countries = config_item('country_list');
		$contact = json_decode($profile["contact"]);
		if ($contact != ""){
			$country = $contact->country;
			if($country != ""){
				foreach($countries as $key=>$value) {
					if ($key == $country){
						$country = ', '.$value;
					}
				}
			} else {
				$country = "";
			}
		}
	  	$mySkills = $this->skill_model->get_my_top5_skills($user_id);
		$myBadges = $this->skill_model->get_my_top8_badges($user_id);
		$completed = $this->users_model->works_compeleted($user_id);
		if(!$myBadges){$myBadges=NULL;}
		$level = $this->gamemech->get_level($user['exp']);
	  ?>
      <div class="recom-box-unit" id="user-<?=$user_id?>">
        <div class="recom-box-top-left">
          <div class="recom-box-top-circle">
            <p><?=round($recoms[$i]['match'])?>%</p>
          </div>
          <div class="recom-box-name"><?=$user['username']?></div>
          <div class="recom-box-position"><?=(trim($profile['specialization'])=='')?'Developer':$profile['specialization']?><?=ucfirst($country)?></div>
          <div class="recom-box-badges">
          	<?php for($j=0; $j<3; $j++)if(isset($myBadges[$j])):?>
          	<img src="/public/<?=$myBadges[$j]["achievement_pic"]?>" width="34" height="26" alt="<?=ucfirst(strtolower($myBadges[$j]["achievement_name"]))?>">
            <?php endif;?>
          </div>
        </div>
        <div class="recom-box-avatar">
          <p>Lvl. <?=$level?></p>
        </div>
        <div class="recom-box-desc"><?=$profile['status_msg']?$profile['status_msg']:'&nbsp;'?></div>
        <div class="recom-box-prog-row">
          <?php for($j=0;$j<min(count($mySkills),2);$j++):?>
          <div class="recom-box-prog-unit">
            <div class="recom-box-prog-name"><?=$mySkills[$j]['name']?></div>
            <div class="recom-box-prog-bar">
              <div class="recom-box-prog-inner" style="width:<?=$mySkills[$j]['point']?>%"></div>
            </div>
          </div>
          <?php endfor;?>
        </div>
        <div class="recom-box-prog-row">
          <?php for($j=2;$j<min(count($mySkills),4);$j++):?>
          <div class="recom-box-prog-unit">
            <div class="recom-box-prog-name"><?=$mySkills[$j]['name']?></div>
            <div class="recom-box-prog-bar">
              <div class="recom-box-prog-inner" style="width:<?=$mySkills[$j]['point']?>%"></div>
            </div>
          </div>
          <?php endfor;?>
        </div>
        <div class="recom-box-invite-row">
          <div class="recom-box-complete-missions">
            <div class="recom-box-mis-com-txt">Mission Complete</div>
            <div class="recom-box-mis-no"><?=$completed?></div>
          </div>
          <div class="recom-box-invite-button">
            <input type="submit" value="Invite" class="lnkimg">
          </div>
        </div>
      </div>
	  <?php }?>
	  </div> <!-- Wrapper end-->
    </div> <!-- Container end -->

	<div class="recom-page-nav"><div class="holder"></div></div>
    <div class="recom-page-confirm-invite">
      <input type="submit" value="Confirm Invite" class="lnkimg">
    </div>
  </div>
</div>

<style type="text/css">
	.recom-boxes-wrapper {width:750px; overflow:hidden}
	.holder {
		margin: 15px 0;
	}

	.holder a {
		display: inline-block;
		cursor: pointer;
		margin: 0 5px;
		padding: 4px;
		border-radius: 50%;
		background-color: #999;
	}

	.holder a:hover {
		background-color: #222;
		color: #fff;
	}

	.holder a.jp-previous { margin-right: 15px; }
	.holder a.jp-next { margin-left: 15px; }

	.holder a.jp-current, a.jp-current:hover { 
		color: #FF4242;
		font-weight: bold;
	}

	.holder a.jp-disabled, a.jp-disabled:hover {
		color: #bbb;
	}

	.holder a.jp-current, a.jp-current:hover,
	.holder a.jp-disabled, a.jp-disabled:hover {
		cursor: default;
		background-color: #FF4242;
	}

	.holder span { margin: 0 5px; }
	.recom-box-invite-button input.lnkimg {cursor:pointer}
	.recom-box-invite-button input.lnkimg.selected {background: url(/public/images/codeArmy/mission/savebtn_hoverstate.png) no-repeat}
</style>
<script type="text/javascript">
		$(function() {
		    /* initiate pugin assigning the desired button labels  */
		    $(".holder").jPages({
		        containerID : "recom-boxes-wrapper",
		        perPage     : 6,
		        first       : false,
		        previous    : "img.recom-page-nav-left",
		        next        : "img.recom-page-nav-right",
		        last        : false,
				links		: 'blank'
		    });
			
			$('.recom-box-invite-button input.lnkimg').toggle(function(){
				$(this).val('Invited').addClass('selected');
			}, function(){
				$(this).val('Invite').removeClass('selected');
			});
			
			$('.recom-page-confirm-invite').click(function(){
				console.log($('#recom-boxes-wrapper').find('input.selected').size());
			})

		});
</script>