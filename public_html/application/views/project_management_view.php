<?php $this->load->view('includes/header4'); ?>
<style type="text/css">.accordion-table a{color:#09F;} h3{color:white; margin-top:10px;}</style>
<div id="wrapper">
  <div class="WP-main" style="margin-top:100px">
    <div class="bidding-project-placeholder">
      <div id="tabs">
        <ul>
        <?php if($action_is=='management'){?>
          <li class="ui-state-active"><a id="#toptab3" href="#tabs-3">PROJECT MANAGEMENT</a></li>
          <li><a id="#toptab1" href="#tabs-1">STORY MANAGEMENT</a></li>
        <?php }else{?>
          <li><a id="#toptab3" href="#tabs-3">PROJECT MANAGEMENT</a></li>
          <li class="ui-state-active"><a id="#toptab1" href="#tabs-1">STORY MANAGEMENT</a></li>
        <?php }?>
        </ul>
        <div id="tabs-1" >
          <div class="WP-contract-placeholder">
          <?php if($project_owner){?>
          	<div style="border:dashed 1px #0CF; background-color:#333; color:#FFF; text-align:center; padding:5px;">Hint: To create, modify and perform actions on stories refer to sprint planning page of each project.</div>
          <?php }?>
          	<?php foreach($stories_list as $list=>$stories): if(count($stories)>0){?>
          	<h3><?=$list?></h3>
            <div id="heading"><span id="title">Bid Until</span><span style="width:520px;" id="title">user stories</span> <span style="width:108px;" id="title">Comments</span> <span style="width:60px;" id="title">bids</span> <span style="width:80px;" id="title">prize</span></div>
            <?php foreach($stories as $story):?>
            <div class="story">
              <div class="accordionButton">
                <table class="us_accordion">
                  <tr>
                    <?php if($story['bid_deadline']!='Open'){?>
                    <td width="130px"><div id="day_date"><?=date('d',strtotime($story['bid_deadline']))?></div>
                      <p><?=date('M Y',strtotime($story['bid_deadline']))?></p></td>
                    <?php }else{?>
                    <td width="130px">Open</td>
                    <?php }?>
                    <td width="580px"><?=$story['project_name']?>
                      ->
                      <?=$story['title']?> (<?=$story['status']?>)</td>
                    <td width="90px" <?php if($story['last_week_comments']>0){?>style="color:red;text-shadow: 0 0 0.2em #F87, 0 0 0.2em #F87"<?php }?>><?=$story['total_comments']?></td>
                    <td width="90px" <?php if($story['last_week_bids']>0 && in_array(strtolower($story['status']),array('open','reject'))){?>style="color:red;text-shadow: 0 0 0.2em #F87, 0 0 0.2em #F87"<?php }?>><?=$story['total_bids']?></td>
                    <td>RM
                      <?=($story['cost'])?$story['cost']:0?></td>
                  </tr>
                </table>
              </div>
              <div class="accordionContent" style="display: none; ">
                <table class="accordion-table">
                  <tr>
                    <td style="border:0;" width="390px">Summary<br />
                      <br />
                      <?=strip_tags($story['description'])?></td>
                    <td style="border:0;" ><table id="us-content">
                        <tr>
                          <td width="80%">Project Type</td>
                          <td><?=$story['type']?></td>
                        </tr>
                        <tr>
                          <td width="80%">Comments</td>
                          <td><?=$story['total_comments']?></td>
                        </tr>
                        <tr>
                          <td width="80%">Points</td>
                          <td><?=$story['points']?></td>
                        </tr>
                        <tr>
                          <td colspan="2"><a href="/story/<?=$story['work_id']?>">View</a> | <a href="/story/edit/<?=$story['work_id']?>">Edit</a></td>
                        </tr>
                      </table></td>
                  </tr>
                </table>
                <div class="bid-more"><a href="/story/<?=$story['work_id']?>">Bid & More</a></div>
                <div class="bidding-mgmt-placeholder">
                  <div class="section-holder">
                    <?php if(in_array(strtolower($story['status']), array('open','reject'))){?>
                    <?php $bidders = $this->story_model->get_bidders($story['work_id']); if(count($bidders)>0):?>
                    <h3>BIDDERS</h3>
                    <?php foreach($bidders as $bid):?>
                    <div id="section">
                      <table width="100%" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                          <tr>
                            <td width="40px"><div id="alert"></div></td>
                            <td width="280px"><img style="float:left;" src="/public/<?=$bid['avatar']?>" />
                              <p id="user">
                                <?=$bid['username']?>
                              </p>
                              <p id="userlevel">Level
                                <?php $level = floor($bid['exp'] / points_per_level)+1;echo ($level>99) ? 99 : $level;?>
                              </p></td>
                            <td width="445px">Bid <span style="color:#00FF00">RM
                              <?=$bid['bid_cost']?>
                              </span> in <span style="color:#00FF00">
                              <?=$bid['days']?>
                              days</span></td>
                            <td><form method="get" action="/story/bid_accept/<?php echo $bid["bid_id"]; ?>">
                                <input onclick="$(this).parent().submit();" type="button" id="approvebid">
                              </form></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <?php endforeach;?>
                    <?php endif;?>
                    <?php }else{?>
                    <h3>AWARDED to <a style="color:#FFF" href="/user/<?=$story['user_id']?>">
                      <?=$story['username']?>
                      </a></h3>
                    <?php }?>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach;?>
            <?php }?>
            <?php endforeach;?>
          </div>
        </div>
        <div id="tabs-3">
          <div class="WP-contract-placeholder">
            <div id="heading"><span id="title">Delivery</span><span style="width:330px;" id="title">Project Name</span> <span style="width:170px;" id="title">No. of Bids</span> <span style="width:200px;" id="title">No. of Comments</span> <span style="width:80px;" id="title">Status</span></div>
            <?php foreach($projects as $project):?>
            <div class="story">
              <div class="accordionButton">
                <table class="us_accordion">
                  <tr>
                    <td width="130px"><div id="day_date">19</div>
                      <p>OCT 2011</p></td>
                    <td width="340px"><?=$project['project_name']?></td>
                    <td style="text-align:center" width="120px"><?=$project['bids']?></td>
                    <td style="text-align:center" width="270px"><?=$project['comments']?></td>
                    <td style="text-align:center"  ><?= $this->projects_model->get_percentage($project['project_id']); ?>
                      %</td>
                  </tr>
                </table>
              </div>
              <div class="accordionContent" style="display: none; ">
                <table class="accordion-table">
                  <tr>
                    <td style="border:0;" width="390px">Summary<br />
                      <br />
                      <?=substr(strip_tags($project['project_desc']),0,350)?></td>
                    <td style="border:0;" ><table width="350px;">
                        <tr>
                          <td width="80%">Total User Stories</td>
                          <td><?=$project['num_works']?></td>
                        </tr>
                        <tr>
                          <td width="80%">Submitted User Stories</td>
                          <td><?=$project['submited_works']?></td>
                        </tr>
                        <tr>
                          <td width="80%">Remaining User Stories</td>
                          <td><?=$project['remaining_works']?></td>
                        </tr>
                      </table></td>
                  </tr>
                </table>
                <div class="more-details"><a href="/project/<?=$project['project_id']?>">Bid & More</a></div>
              </div>
            </div>
            <?php endforeach;?>
            <div id="addnewproject" style="width:1000px;"><a style="margin: 15px auto 200px;" href="http://ver2.workpad.my/#addnewPrj">add new projects</a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div><div id="push-down">&nbsp;</div>
</div>
</div>
<link rel="stylesheet" href="/public/js/jquery.ui.all.css">
<script type="text/javascript">
	$('.accordionButton').click(function(){
		$(this).next('.accordionContent').slideToggle();
	});
	$(function() {
		$( "#tabs" ).tabs(<?php if($action_is=='story_management'){?>{ selected: 1 }<?php }?>);
	});

</script>
<?php $this->load->view('includes/footer4'); ?>
