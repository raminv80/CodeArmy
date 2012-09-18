<?php $this->load->view('includes/frame_header.php'); ?>

<link rel="stylesheet" href="../../public/css/CodeArmyV1/bootstrap.css" type="text/css">
<style type="text/css">
	.find-mission-full-wrappers {font-family: 'Ruda', Lucida Grande, serif;}
</style>
<div class="find-mission-full-wrappers row-fluid content">
	<div class="find-mission-full-containers" style="overflow:hidden">
	  <div class="find-mission-main-cols span8">
	    
		<!-- Main Desc -->
		<div class="find_mission_main_desc">
	      <div class="find-mission-main-title">
	        <div class="find-mission-title-logo"></div>
	        <div class="find-mission-title-text"><?=$work['title']?></div>
	      </div>
	      <div class="find-mission-video-block">
	        <iframe width="541" height="366" frameborder="0" src="http://www.youtube.com/embed/<?=$work['tutorial']?$work['tutorial']:'zFNb8j3YAd4'?>?wmode=opaque" type="text/html" class="youtube-player"></iframe>
	      </div>
	      <div class="find-mission-main-desc"><?=$work['description']?></div>
	    </div>
		
		<!-- Bid -->
		
		<div class="bid-box" style="background:orange">
			<div style="width:30%">Hourly</div>
			<div style="width:70%">
				<p>Your Bid</p>
			</div>
		</div>
		
	    <div class="find-mission-comment-box clearfix">
          <div id="form-bid-container">
              <div class="find-mission-comment-box-left">
                <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
                  <p><?=$this->game_model->get_level($me['exp'])?></p>
                </div>
                <div class="find-mission-comment-name"><?=$me['username']?></div>
              </div>
              <?php echo form_open('/missions/set_bid' , array('id'=>'form-bid')); ?>
              <div class="find-mission-comment-box-right">
                <div class="fmcb-right-row1">
                  <div class="urbid">Your Bid</div>
                  <div class="clock-icon"></div>
                  <div class="small-box-hr"> 
                    <input name="time" class="time input-small" onkeydown="increment(event, this)" autocomplete="off" type="text" value="<?=($estimate_time['time_cal'])?$estimate_time['time_cal']:'18'?>" />
                  </div>
                  <div class="botharrows">
                    <span class="arrowkey">
                        <i class="icon-plus-sign"></i>
                        <i class="icon-minus-sign"></i>
                    </span>
                    <!-- <a href="javascript:void(0)"><img class="arr-up-img" src="/public/images/codeArmy/mission/arr-up.png" /></a><a href="javascript:void(0)"><img class="arr-down-img" src="/public/images/codeArmy/mission/arr-down.png" /></a> -->
                    </div>
                  <div class="bidhrstext"><?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s</div>
                  <!--
                  <div class="small-box-hr">
                    <input type="text" value="4" />
                  </div>
                  <div class="botharrows"><a href="#"><img class="arr-up-img" src="/public/images/codeArmy/mission/arr-up.png" /></a><a href="#"><img class="arr-down-img" src="/public/images/codeArmy/mission/arr-down.png" /></a></div>
                  <div class="bidhrstext">Days</div>
                  -->
                </div>
                <div class="fmcb-right-row2">
                  <div class="dollar-sign-icon"></div>
                  <div class="small-box-hr">
                    <input name="budget" class="budget input-small" type="text" autocomplete="off" onkeydown="increment(event, this)" value="<?=($estimate_budget['amount_cal'])?$estimate_budget['amount_cal']:'35'?>" />
                  </div>
                  <div class="botharrows">
                    <span class="arrowkey">
                        <i class="icon-plus-sign"></i>
                        <i class="icon-minus-sign"></i>
                    </span>
                    <!-- <a href="javascript:void(0)"><img class="arr-up-img" src="/public/images/codeArmy/mission/arr-up.png" /></a><a href="javascript:void(0)"><img class="arr-down-img" src="/public/images/codeArmy/mission/arr-down.png" /></a> -->
                    </div>
                  <div class="bidhrstext">/<?=str_replace('dai','day',substr($arranegement,0,-2))?></div>
                </div>
                <div class="fmcb-right-textarea">
                  <textarea id="ask" name="desc" rows="3">Ask a question or place your comment</textarea>
                </div>
                <input type="hidden" name="work_id" value="<?=$work['work_id']?>">
                <img src="/public/images/codeArmy/loader4.gif" style="position:absolute; top:190px; right:50px;display:none" id="login-ajax" />
                <div class="pull-right" style="padding-right:40px"><input type="submit" name="submit" value="Submit" class="btn btn-warning btn-large" id="submit-bid" /></div>
              </div>
              </form>
          </div>
	      <div class="find-mission-comment-box-down">
	      	<?php 
			  	foreach($bids as $bid):
					$bidder = $this->users_model->get_user($bid['user_id'])->result_array();
					$bidder = $bidder[0];
					$lvl = $this->game_model->get_level($bidder['exp']);
					if(trim($bid['bid_desc'])>"" || $bid['user_id']==$me['user_id']){
			?>
	        <div class="find-mission-down-box-row">
	          <div class="find-mission-comment-box-left">
	            <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
	              <p><?=$lvl?></p>
	            </div>
	            <div class="find-mission-comment-name"><?=$bidder['username']?></div>
	          </div>
	          <div class="find-mission-comment-box-right">
	            <div class="bidded-icon"></div>
	            <div class="fmcb-right-row1"><?=$bid['bid_desc']?><br />You placed a bid on this job. You may review your bids <a target="_top" style="text-decoration:underline" href="/missions/bid">here</a>.</div>
	            <div class="fmcb-right-row2">
	              <div class="commentime"><?=$bid['created_at']?></div>
	              <!--<div class="replybut"><a href="#"><img src="/public/images/codeArmy/mission/reply-icon.png" /></a></div>-->
	            </div>
	          </div>
	        </div>
	        <?php }?>
	        <?php endforeach;?>

	      </div>
	    </div>
	  </div>
	  <div class="find-mission-right-cols span4">
	    <!--<div class="closebut"><a href="#">X CLOSE</a></div>-->
	    <div class="find-mission-right-block">
	      <div class="right-col-title-bg">Mission Captain</div>
	      <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
	        <p><?=$this->game_model->get_level($po['exp'])?></p>
	      </div>
	      <div class="captainame"><?=$po['username']?></div>
	      <div class="captainrank">Level <?=$this->game_model->get_level($po['exp'])?></div>
	      <div class="rankicons">
	      	<?php if($po_badge != "") foreach($po_badge as $badge):?>
	        <img src="/public/<?=$badge["achievement_pic"]?>" width="34" height="26" alt="<?=ucfirst(strtolower($badge["achievement_name"]))?>">
	        <?php endforeach;?></div>
	    </div>
	    <div class="find-mission-right-block">
	      <div class="right-col-title-bg">Pre-Requisites</div>
	      <ul>
	      	<?php foreach($work_skills as $skill):?>
	        <li>
              <span style="text-align:left;display:block;width:50%;float:left;padding:0 10px;" class="skill_<?=$skill['skill_id']?>"><?=$skill['name']?></span>
	          <span style="text-align:right;display:block;width:30%;float:left;padding:0 10px;"><?=$skill['skill_level']?></span>
	        </li>
	        <?php endforeach;?>
	      </ul>
	    </div>
	    <div class="find-mission-right-block">
	      <div class="right-col-title-bg">Materials</div>
	      <?php foreach($work_files as $file):?>
	      <div class="find-mission-material-row">
	        <div class="attach-file-tools"> <img src="/public/images/codeArmy/mission/fileicon.png" class="fileicon" /> <span class="filename"><a href="/public/uploads/<?=$file['file_name']?>" target="_blank"><?=(strlen($file['file_name'])>25)?substr($file['file_name'],0,15).'...'.substr($file['file_name'],-7,7):$file['file_name']?></a></span> <span class="filesize"><?=byte_format($file['file_size'])?></span> </div>
	      </div>
	      <?php endforeach;?>
	    </div>
	    <div class="find-mission-right-block">
	      <div class="right-col-title-bg">Estimation</div>
	      <div class="est-main-rows">
	        <div class="est-row1"> <span class="est-blue-txt"><?=($estimate_time['time_cal'])?$estimate_time['time_cal']:'?'?> <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s</span></div>
	        <div class="est-row2"> <span class="est-blue-txt"><?=($estimate_budget['amount_cal'])?$estimate_budget['amount_cal']:'?'?> per <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s</span></div>
	      </div>
	      <div class="est-average-rows">
	        <div class="est-avg-title">Average Bids</div>
	        <div class="est-row1"><span class="est-blue-txt"><?=round($bid_avg['avg_time'])?></span> <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s </div>
	        <div class="est-row2"> <span class="est-blue-txt"><?=round($bid_avg['avg_cost'])?></span> per <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s </div>
	      </div>
	    </div>
	    <div class="find-mission-right-block">
	      <div class="right-col-title-bg">Bidders (<?=count($bidders)?>)</div>
	      <div class="bidders-avatars">
	      	<?php foreach($bidders as $bidder):?>
	        <div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png" />
	          <p><?=$this->game_model->get_level($bidder['exp'])?></p>
	          <div class="find-mission-comment-name"><?=$bidder['username']?></div>
	        </div>
	        <?php endforeach;?>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<script type="text/javascript">
	$('#submit-bid').click(function(){
		var time = $('input[name="time"]').val();
		var val = $('input[name="budget"]').val();
		var desc = $('#ask').val();
		$('#login-ajax').fadeIn();
		$.ajax({
			'url':'/missions/Ajax_bid',
			'data':{'csrf_workpad': getCookie('csrf_workpad'),'time':time,'budget':val,'desc':desc, 'work_id':'<?=$work['work_id']?>'},
			type: 'POST',
			dataType: "json",
			success:function(msg){
				var template = '<div style="display:none" class="find-mission-down-box-row"><div class="find-mission-comment-box-left"><div class="find-mission-comment-avatar"><img src="/public/images/codeArmy/mission/default-avatar.png"><p>'+msg.level+'</p></div><div class="find-mission-comment-name">'+msg.username+'</div></div><div class="find-mission-comment-box-right"><div class="bidded-icon"></div><div class="fmcb-right-row1"><br>You placed a bid on this job. You may review your bids <a target="_top" style="text-decoration:underline" href="/missions/bid">here</a>.</div><div class="fmcb-right-row2"><div class="commentime">'+msg.created_at+'</div></div></div></div>';
				$('.find-mission-comment-box-down').append(template);
				$('.find-mission-comment-box-down .find-mission-down-box-row:last').slideDown();
				$('#login-ajax').fadeOut();
				$('#form-bid-container').slideUp();
				$('.find-mission-full-wrapper').jScrollPane({'showArrows': true});
			}
		});
		return false;
	});
	
	function increment(e,field) {
	    var keynum;

	    if(window.event) {// IE 
	        keynum = e.keyCode
	    } else if(e.which) {// Netscape/Firefox/Opera 
	        keynum = e.which
	    }
	    if (keynum == 38) {
	        field.value = parseInt(field.value)+ 1;
	    } else if (keynum == 40) {
			if(field.value > 0){
			field.value = parseInt(field.value) - 1;	
			}
	    }
	    return false;
	}
	
	$('.fmcb-right-row1 i.icon-plus-sign').click(function(){
		if($('input.time').val() > -1 ){
			newvalue = parseInt($('input.time').val()) + 1;
			$('input.time').val(newvalue);
		}
	});
	
	$('.fmcb-right-row1 i.icon-minus-sign').click(function(){
		if($('input.time').val() > 0){
			newvalue = parseInt($('input.time').val()) - 1;
			$('input.time').val(newvalue);
		}
	})
	
	$('.fmcb-right-row2 i.icon-plus-sign').click(function(){
		if($('input.budget').val() > -1 ){
			newvalue = parseInt($('input.budget').val()) + 1;
			$('input.budget').val(newvalue);
		}
	});
	
	$('.fmcb-right-row2 i.icon-minus-sign').click(function(){
		if($('input.budget').val() > 0){
			newvalue = parseInt($('input.budget').val()) - 1;
			$('input.budget').val(newvalue);
		}
	})
	
	$('.arr-down-img').click(function(){
		var val = $(this).parent().parent().siblings('.small-box-hr').find('input').val();
		$(this).parent().parent().siblings('.small-box-hr').find('input').val(--val);
	});
	
	$('.arr-up-img').click(function(){
		var val = $(this).parent().parent().siblings('.small-box-hr').find('input').val();
		$(this).parent().parent().siblings('.small-box-hr').find('input').val(++val);
	});
	
	$('#ask').focus(function(){
			var val=$(this).val();
			if (val=="Ask a question or place your comment") val="";
			val=$(this).val(val);
		});
	$('#ask').blur(function(){
			var val=$(this).val();
			if ($.trim(val)=="") val="Ask a question or place your comment";
			val=$(this).val(val);
		});
		
</script>
<?php $this->load->view('includes/frame_footer.php'); ?>