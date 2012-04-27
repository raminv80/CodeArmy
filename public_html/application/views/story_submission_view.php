<?php $this->load->view('includes/header4'); ?>

<section id="pitch" style="padding-top:40px; padding-bottom:200px;"><br />
  <div class="WP-main">
    <div class="WP-qualification-placeholder">
      <div id="qualif-heading"><span id="title"><a class="dialog_opt2" href="/project/<?php echo $work_data['project_id'];?>"><?php echo strtoupper($work_data['project_name'])?></a></span>
        <div style="padding:9px 20px 0 0;"><span id="position">PRODUCT OWNER</span><br />
          <span id="owner"><?php echo $work_data['username'];?></span></div>
      </div>
      <div id="qualif-table">
        <table>
          <tr>
            <td width="50%">User Stories</td>
            <td style="text-align:right;"><p><?php echo $work_data['title'];?></p></td>
          </tr>
        </table>
        <table>
          <tr>
            <td width="50%">Payouts</td>
            <td style="text-align:right;"><p>RM <?php echo $work_data['cost'];?></p></td>
          </tr>
        </table>
        <table>
          <tr>
            <td width="50%">Points Gained</td>
            <td style="text-align:right;"><p>+<?php echo $work_data['points'];?></p></td>
          </tr>
        </table>
        <table style="padding:0;">
          <tr>
            <td width="50%" style="border-right: 1px solid #696F86;border-spacing: 0;"><table id="inner-table">
                <tr>
                  <td>DESCRIPTION</td>
                </tr>
                <tr>
                  <td><?php echo $work_data['description']; ?></td>
                </tr>
                <?php if( $work_data['note'] ){?>
                <tr>
                  <td>NOTES</td>
                </tr>
                <tr>
                  <td><?php echo $work_data['note']; ?></td>
                </tr>
                <?php } ?>
              </table></td>
            <td style="vertical-align:top;"><table style="border:0; padding-left:10px;" id="inner-table">
                <tr>
                  <td>Skill Requirements</td>
                </tr>
                <tr>
                  <td><p>
                    
                    <ul>
                      <?php foreach($skills as $skill):?>
                      <li><?php echo $skill['name'];?></li>
                      <?php endforeach;?>
                    </ul>
                    </p></td>
                </tr>
                <tr>
                  <td>DEADLINE</td>
                </tr>
                <tr>
                  <td><span id="dateline"><?php echo ($work_data['deadline'])? date('j F Y',strtotime($work_data['deadline'])):'undefined';?></span></td>
                </tr>
              </table></td>
            <?php 
						$now = strtotime(date("Y-m-d"));
						$expire=strtotime($work_data['bid_deadline']);
					    if($now>$expire){
						  $bid_open=false;
						  $diff = $now-$expire;
						  $hours = floor($diff/(60*60));
						  $mins = floor(($diff-($hours*60*60))/60);
						}else{
						  $bid_open=true;
						  $diff = $expire-$now;
						  $hours = floor($diff/(60*60));
						  $mins = floor(($diff-($hours*60*60))/60);
						}
					  ?>
            <?php if(in_array(strtolower($work_data['status']),array('open','reject')))if($work_data['bid_deadline']){?>
            <?php if($bid_open && in_array(strtolower($work_data['status']),array('open','reject'))){?>
            <td style="vertical-align:top;"><div class="bidding-box">
                <h3>Bidding is now</h3>
                <p>
                  <?=$hours?>
                  hours,
                  <?=$mins?>
                  minutes left</p>
                <h2>open</h2>
              </div></td>
            <?php }elseif(in_array(strtolower($work_data['status']),array('open','reject')) && !$bid_open){?>
            <td style="vertical-align:top;"><div class="bidding-box">
                <h3>Bidding expired</h3>
                <p>
                  <?=$hours?>
                  hours,
                  <?=$mins?>
                  minutes ago</p>
              </div></td>
            <?php }?>
            <?php }else{?>
            <td style="vertical-align:top;"><div class="bidding-box">
                <h3>Bidding is now</h3>
                <p>&nbsp;</p>
                <h2>open</h2>
              </div></td>
            <?php }?>
            <?php if(!in_array(strtolower($work_data['status']),array('open','reject'))){?>
            <td style="vertical-align:top;"><div class="bidding-box">
                <h3>Job's status is</h3>
                <p>&nbsp;</p>
                <h2 style="font-size:1.9em">
                  <?php $status = $work_data['status']; if (strtolower($status)=='in progress') $status = 'assigned'; if (strtolower($status)=='signoff') $status = 'paid'; echo $status;?>
                </h2>
              </div></td>
            <?php }?>
          </tr>
        </table>
        <table>
          <tr>
            <?php if(isset($work_data['attach'])){?>
            <td width="50%">Files required to complete the task</td>
            <td style="text-align:right;"><?php if(isset($work_data['attach'])){$inf = pathinfo($work_data['attach']);if(strtolower($inf['extension'])=='zip'){?>
              <a href="<?php echo base_url().$work_data['attach'];?>"><img src="/public/images/zip.png" /></a>
              <?php }else{?>
              <a target="_blank" href="<?php echo base_url().$work_data['attach'];?>"><img width="48" height="48" src="<?php echo base_url().$work_data['attach'];?>" border="0"></a>
              <?php }?>
            <td width="155"><div align="center" id="download_all"><a href="<?php echo base_url().$work_data['attach'];?>"></a></div></td>
            <?php }?>
              </td>
            <?php }if(isset($work_data['git']) && trim($work_data['git'])!=''){?>
            <td width="50%">Development (Forked) GIT Repository</td>
            <td style="text-align:right;"><a target="_blank" href="<?php echo $work_data['git'];?>"><?php echo $work_data['git'];?></a></td>
            <td width="155">&nbsp;</td>
            <?php }if(isset($work_data['link']) && trim($work_data['link'])!=''){?>
            <td width="50%">Link to project files</td>
            <td style="text-align:right;"><a target="_blank" href="<?php echo $work_data['link'];?>"><?php echo $work_data['link'];?></a></td>
            <td width="155">&nbsp;</td>
            <?php }if(!isset($work_data['attach']) && (!isset($work_data['git'])||trim($work_data['git'])=='') && (!isset($work_data['link'])||trim($work_data['link'])=='')){?>
            <td width="50%">Files required to complete the task</td>
            <td style="text-align:right;">will be provided once assigned.</td>
            <?php }?>
          </tr>
          <tr> </tr>
        </table>
        <table cellpadding="0" cellspacing="0" style="border: 0;margin: 0;padding: 0;">
          <tr>
            <td></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="WP-people-placeholder">
      <div id="people-top">
        <p id="title" style="padding:10px 0 0 15px;">PEOPLE WORKING ON THIS PROJECT</p>
      </div>
      <div id="people-mid">
        <ul style="margin: 10px 0 20px -40px;">
          <?php foreach($project_ppl as $ppl):?>
          <li class="collab-project-page"><a title="<?php echo $ppl['username'];?>, Level <?php $level = $this->gamemech->get_level($ppl['exp']); echo $level;?>" href="/user/<?=$ppl['user_id']?>"><img src="/public/<?php echo ($ppl['avatar'])? $ppl['avatar']: 'images/img7.png';?>" alt="<?php echo $ppl['username'];?>" width="50" height="49" /></a></li>
          <?php endforeach;?>
        </ul>
      </div>
      <div id="people-bottom"></div>
    </div>
    <div id="push-down">&nbsp;</div>
    <br />
    &nbsp; </div>
  </div>
</section>
<section id="essentials">
  <div class="WP-main"><div id="qualif-table">
    <div id="terms">
      <h1>Terms And Conditions</h1>
      <hr>
      <p> All rights reserved for <a href="http://www.motionworks.com.my" target="_blank">Motionworks SDN BHD</a> </p>
    </div></div>
    <div id="push-down">&nbsp;</div>
  </div>
</section>
<script>
	$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
		$( "#dialog-modal" ).dialog({
			height: 140,
			modal: true
		});
	});
</script>
<div id="dialog-modal" title="Almost there!">
	<p>Wait! You are just one step away from completing this job. Prepare your files and submit them at the bottom of this page.</p>
</div>
<?php $this->load->view('includes/footer4'); ?>
<style>
.WP-main .WP-people-placeholder {
color: white;
overflow: hidden;
width: 100%;
float: left;
}
.WP-main .WP-people-placeholder #people-top {
background: url(/public/images/people-top.png);
width: 100%;
height: 34px;
display: block;
}
.WP-main .WP-people-placeholder #people-mid {
padding: 20px 20px 20px 20px;
background: url(/public/images/people-mid.png) repeat-y;
width: 100%px;
display: block;
}
.WP-main .WP-people-placeholder #people-bottom {
background: url(/public/images/people-bottom.png);
width: 100%;
height: 43px;
display: block;
}
</style>
