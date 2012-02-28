<?php $this->load->view('includes/header4'); ?>
<section id="pitch"><br />
  <div class="WP-main" style="overflow:visible;">
    <div class="WP-qualification-placeholder">
      <div id="qualif-heading"><span id="title"><a class="dialog_opt2" href="/project/<?php echo $work_data['project_id'];?>"><?php echo strtoupper($work_data['project_name'])?></a></span>
        <div style="padding:9px 20px 0 0;"><span id="position">PRODUCT OWNER</span><br />
          <span id="owner"><?php echo strtoupper($work_data['username']); ?></span></div>
      </div>
      <div id="qualif-table">
        <table>
          <tr>
            <td width="50%">User Stories</td>
            <td style="text-align:right;"><p><?php echo ucwords($work_data['title']); ?> <?php if($show_bid){?>(<a href="/story/edit/<?=$work_data['work_id']?>">Edit</a>)<?php }?></p></td>
          </tr>
        </table>
        <table>
          <tr>
            <td width="50%">Payouts</td>
            <td style="text-align:right;"><p>RM<?php echo $work_data['cost']; ?></p></td>
          </tr></table>
          <table>
          <tr>
            <td width="50%">Points Gained</td>
            <td style="text-align:right;"><p>+<?php echo $work_data['points']; ?></p></td>
          </tr>
        </table>
                <table style="padding:0;">
                  <tr>
                    <td width="50%" style="vertical-align:top;border-right: 1px solid #696F86;border-spacing: 0;"><table id="inner-table">
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
                              <?php if(count($skills)==0){?>
                                <li>Not specified</li>
                              <?php }else{foreach($skills as $skill):?>
                                <li><?php echo $skill['name'];?></li>
                              <?php endforeach;}?>
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
                    <td style="vertical-align:top;"><div class="bidding-box"><h3>Bidding is now</h3><p><?=$hours?> hours, <?=$mins?> minutes left</p><h2>open</h2></div></td>
                      <?php }elseif(in_array(strtolower($work_data['status']),array('open','reject')) && !$bid_open){?>
                    <td style="vertical-align:top;"><div class="bidding-box"><h3>Bidding expired</h3><p><?=$hours?> hours, <?=$mins?> minutes ago</p></div></td>
                      <?php }?>
                    <?php }else{?>
                    <td style="vertical-align:top;"><div class="bidding-box"><h3>Bidding is now</h3><p>&nbsp;</p><h2>open</h2></div></td>
                    <?php }?>
                    
                    <?php if(!in_array(strtolower($work_data['status']),array('open','reject'))){?>
                    <td style="vertical-align:top;"><div class="bidding-box"><h3>Job's status is</h3><p>&nbsp;</p><h2 style="font-size:1.9em"><?php $status = $work_data['status']; if (strtolower($status)=='in progress') $status = 'assigned'; if (strtolower($status)=='signoff') $status = 'paid'; echo $status;?></h2></div></td>
                    <?php }?>
                  </tr>
                </table>
        <table>
          <tr>
            <?php if(isset($work_data['attach'])){?>
            <td width="50%">Files required to complete the task</td>
            <td style="text-align:right;">
            	<?php if(isset($work_data['attach'])){
					$inf = pathinfo($work_data['attach']);
					if(strtolower($inf['extension'])=='zip'){?>
            	<a href="<?php echo base_url().$work_data['attach'];?>"><img src="/public/images/zip.png" /></a>
				<?php }else{?>
            	<a target="_blank" href="<?php echo base_url().$work_data['attach'];?>"><img width="48" height="48" src="/public/images/compressed.png" border="0"></a>
                <?php }?>
                <td width="155"><div align="center" id="download_all"><a href="<?php echo base_url().$work_data['attach'];?>"></a></div></td>
                <?php }?>
            </td>
            <?php }if(isset($work_data['git']) && trim($work_data['git'])!=''){?>
            <td width="50%">Development (Forked) GIT Repository</td>
            <td style="text-align:right;">
            	<a target="_blank" href="<?php echo $work_data['git'];?>"><img  width="48" height="48" src="/public/images/github.png" /></a>
            </td>
            <td width="155">&nbsp;</td>
            <?php }if(isset($work_data['link']) && trim($work_data['link'])!=''){?>
            <td width="50%">Link to project files</td>
            <td style="text-align:right;">
            	<a target="_blank" href="<?php echo $work_data['link'];?>"><?php echo $work_data['link'];?></a>
            </td>
            <td width="155">&nbsp;</td>
			<?php }if(!isset($work_data['attach']) && (!isset($work_data['git'])||trim($work_data['git'])=='') && (!isset($work_data['link'])||trim($work_data['link'])=='')){?>
            <td width="50%">Files required to complete the task</td>
            <td style="text-align:right;">will be provided once assigned.</td>
            <?php }?>
          </tr>
          <tr>
          </tr>
          </table>
          <table cellpadding="0" cellspacing="0" style="border: 0;margin: 0;padding: 0;"><tr><td>
          	<?php if((strtolower($work_data['status'])=='in progress' || strtolower($work_data['status'])=='redo') && $is_my_work){?>
                <div id="job-done">
                    <?php echo form_open('story/submission');?>
                        <input type="hidden" name="id" value="<?php echo $work_data['work_id']; ?>" />
                        <input type="hidden" name="csrf" value="<?php echo md5('storyDone'); ?>" />
                        <!--<input type="submit" name="submit" value="Job Done!" />-->
                        <div class="proceed">
                            <a href="javascript: void(0)" onclick="$(this).parent().parent().submit();" id="jobdone">Job Done!</a>
                        </div>
                    <?php echo form_close(); ?>    
                </div>
            <?php } ?>
          </td><td>
        <!--<img style="padding:0;margin:-5px 0 0 0;float:right" src="/public/images/social-button.png" />-->
       
       <div id="social-plugin" style="margin-top: 10px;"><iframe style="float:left;height:25px;width: 85px;" allowtransparency="true" frameborder="0" scrolling="no" src="//platform.twitter.com/widgets/tweet_button.html" style="width:60px; height:20px;"></iframe>
       <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like" data-href="http://ver2.workpad.my" data-send="true" style="float:left;width: 132px;" data-layout="button_count" data-width="100" data-show-faces="false"></div>
<!-- Place this tag where you want the +1 button to render -->
<g:plusone size="medium" annotation="inline" style="float:left;"width="120"></g:plusone>

<!-- Place this render call where appropriate -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
</div>
        </td></tr></table>
        
        
        </div>
    </div>
    <div class="WP-comment-placeholder">
      <div id="comment-top">
        <p id="title">discuss</p>
      </div>
      <div id="comment-mid">
      	<?php if($this->session->userdata('is_logged_in') == true) {?>
			<?php 
                if($this->session->userdata('role')=='admin' || $this->session->userdata('user_id')==$work_data['work_horse']){
                echo form_open_multipart('story/comments');
            ?>
            <div id="attach" style="margin: 0 0 10px 20px;">
                <label for="file">Attach a file <span style="color:#CCC; font-size:10px" class="hint">(only zip or image less than 10MB)</span>:</label>
                <input type="file" name="userfile" class="fileUpload" style="color:white" >
                <input type="hidden" value="has_file" name="has_file" />
            </div>
            <?php }else echo form_open('story/comments');?>
            <textarea name="comments" id="comments-text" class="" style=""></textarea>
            <input type="hidden" value="<?php echo $work_data['work_id']; ?>" name="story_id">
            <input type="hidden" value="<?php echo $this->session->userdata('username'); ?>" name="user_id">
            <input id="comments-submit" type="submit" />
            <?php echo form_close(); ?>
        <?php }?>
        <div id="comments-section">
        <?php if($this->session->userdata('is_logged_in') == false) {?>
          <table width="550px">
            <tr>
              <td style="vertical-align:top;" width="50"><div style="float: left; width: 180px;"><img src="/public/images/icon1.png" style="float: left;padding-right:5px;"/>
              <p id="commentator">System</p>
                <p id="level">Hint!</p></div><p id="comment-content">You must <a href="/login" style="color:#09F">login</a> first to leave comments.</p>
                <p id="date-comment">Posted <?php echo date('j M Y'); ?></p></td>
            </tr>
          </table>
        <?php }?>
        <?php if(isset($comments))foreach($comments as $comment) { 
				$myComment = $comment['username']==$this->session->userdata('username');
				$admin = $this->session->userdata('role')=='admin';
		?>
          <table width="550px" class="<?php if($this->session->userdata('username')==strtolower($comment['username']))echo 'my-comment';?>">
            <tr>
              <td style="vertical-align:top;" width="50"><div style="float: left; width: 180px;"><img style="float: left;padding-right:5px;" src="<?php echo ($comment['avatar'])? '/public/'.$comment['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $comment['email'] ) ) );?>" /><p id="commentator"><?php echo $comment['username']; ?></p>
                <p id="level"><?php if(strcasecmp($work_data['username'],$comment['username'])==0){?>product owner<?php }elseif($this->session->userdata('role')=='admin'){?>Admin<?php }else{?>lvl <?php $level = $this->gamemech->get_level($comment['exp']);echo $level;}?></p></div><p id="comment-content"><?php echo $comment['comment_body']; ?></p>
                <?php if($comment['comment_file']):?>
                    <div class="ds-posted" style="margin-right:30px">
                        <a href="/<?php echo $comment['comment_file'];?>">download attached</a>
                    </div>
                <?php endif;?>
                <p id="date-comment">Posted <?php echo date('j M Y', strtotime($comment['comment_created'])); ?> <?php if($myComment || $admin){?>(<a title="Remove this comment" href="/project/remove_comment/<?=$comment['comment_id']?>"><img alt="Remove Comment" src="/public/images/icon_delete.png"  /></a>)<?php }?></p></td>
            </tr>
          </table>
        <?php } ?>
        </div>
      </div>
      <div id="comment-bottom"></div>
    </div>
    <div class="WP-allbid-placeholder">
      <div id="allbid-top">
        <p id="title">Competitors (<?=count($bid_data)?>)</p>
      </div>
      <div id="allbid-mid">
        <div id="allbid-section">
          <?php foreach($bid_data as $bid) { ?>
          <table width="350px">
            <tr>
              <td width="40"><img style="float: left;padding-right:5px;"src="<?php echo ($bid['avatar'])? '/public/'.$bid['avatar'] : 'http://www.gravatar.com/avatar/'.md5( strtolower( trim( $bid['email'] ) ) );?>" /></td>
              <td><p id="bidder"><?php echo $bid['username']; ?></p>
                <p id="level">lvl <?php $level = $this->gamemech->get_level($bid['exp']);echo  $level;?></p></td>
              <td><p id="allbid-content"><?php echo number_format($bid['bid_cost']); ?> RM in <?php echo $bid['days']; ?> days</p>
                <p id="date-comment">Posted <?php echo date('j M Y',strtotime($bid['created_at']));?></p></td>
                <td width="60px">
                <?php 
					$my_bid = (isset($user_id) && ($user_id==$bid['user_id']));
					$bid_open = (strtolower($bid['work_status'])=='open' || strtolower($bid['work_status'])=='reject');
					$has_admin_right = $show_bid;
					if($my_bid){
						if($bid_open){
							//show cancel button
							?><a id="accept" href="/story/bid_remove/<?php echo $bid["bid_id"]; ?>">Cancel</a><?php
						}else{
							//show status
							echo $bid['bid_status'];
						}
					}elseif(!$bid_open){
						//show status
						echo $bid['bid_status'];
					}
					if($has_admin_right && $bid_open){
						//show accept button
						?><a id="accept" href="/story/bid_accept/<?php echo $bid["bid_id"]; ?>/story">Accept</a><?php
					}
				?>
                </td>
            </tr>
          </table>
          <?php }?>
        </div>
      </div>
      <div id="allbid-bottom"></div>
    </div>
    <div id="push-down">&nbsp;</div>
    <br />
    &nbsp; </div>
  </div>
</section>
<section id="user-stories">
  <div class="WP-main">
    <div class="WP-tutorial-placeholder">
      <?php if(trim($work_data['tutorial'])!=""){ echo $work_data['tutorial']; }else{?>
      <iframe width="490" height="350" src="http://www.youtube.com/embed/oQBHecq0apQ" frameborder="0" allowfullscreen></iframe>
      <iframe width="490" height="350" src="http://www.youtube.com/embed/ZDR433b0HJY" frameborder="0" allowfullscreen></iframe>
      <?php if(count($skills)>0){?>
      <div id="useful-links">
        <h1>Useful Links</h1>
        <ul>
		  <?php foreach($skills as $skill):?>
            <li><a target="_blank" href="<?php echo $skill['desc']? $skill['desc']: '#';?>">Leran <?php echo $skill['name'];?></a></li>
          <?php endforeach;?>
        </ul>
      </div>
      <?php }}?>
    </div>
    <div id="push-down">&nbsp;</div>
    <br />
    &nbsp; </div>
  </div>
</section>

<?php $this->load->view('includes/footer4'); ?>
