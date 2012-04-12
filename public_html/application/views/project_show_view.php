<?php $this->load->view('includes/header4'); ?>

<section id="projectdetails">
  <div id="wrapper">
    <div class="WP-main" style="margin: 90px auto 50px auto;">
      <div class="WP-qualification-placeholder" style="padding:0;">
        <div  id="qualif-heading">
        	<span id="title"><a class="dialog_opt2" target="_blank" href="/project/1"><?php echo $project['project_name'];?></a></span>
            <?php if($project['project_owner_id']==$user_id){?>
			<ul style="float:right;">
				<li><a class='edit_project' href="/project/edit_project/<?php echo $project['project_id'];?>">Edit</a></li>
            </ul>
            <?php }?>
        </div>
      </div>
      <div class="contents">
        <div class="project_detail" style="border-bottom:0;">
          <div style="float: left;margin: 0 0 0 -10px;width: 999px;padding:10px 0 25px 10px;border-bottom:1px solid #696F86;">
            <h1>PROJECT PROGRESS</h1>
            <div class="skills-points">
              <div id="css" class="skill-chart-container">
                <div class="skill-chart-start"></div>
                <div class="skill-chart" style="width:<?=round($percentage/100*96)?>%"></div>
                <span style="color: #FC0;float: right;margin: -6px -85px 0 0;font-size: 2.3em;font-weight: bold;">
                <?=$percentage?>
                %</span></div>
            </div>
            <div class="project-desc">
              <h1 style="floaT:none;padding: 10px 0 0 0;">Description</h1>
              <?php echo $project['project_desc'];?> </div>
          </div>
          <div style="padding-top:10px;border: 1px solid #696F86; border-top:0;float:left;background:url(/public/images/qualif-table-bg2.png); width: 998px;margin: 0 0 0 -11px; ">
            <h3><span class="text-collaborators" style=";padding: 10px 0 13px 20px;font-size: 1.3em;text-transform: uppercase;color: white;">collaborators</span></h3>
            <ul style="margin: 10px 0 20px -20px;">
              <?php foreach($collaborators as $user):?>
              <li class="collab-project-page"> <a href="/user/<?=$user['user_id']?>"><img src="/public/<?=($user['avatar'])? $user['avatar']:'images/img7.png'?>" alt="<?=$user['username']?>" width="40" height="39" /></a></li>
              <?php endforeach;?>
            </ul>
          </div>
        </div>
      </div>
      <br />
    </div>
    <div id="push-down" style="height:125px;">&nbsp;</div>
  </div>
</section>
<?php $this->load->view('includes/footer4'); ?>
