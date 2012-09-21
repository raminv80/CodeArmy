<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<style type="text/css">
 .alert {margin-top:5px; margin-bottom:50px; background:black; border:none; color:orange; text-shadow:none; display:none}
 .alert .close {color:white; text-shadow:0 1px 1px black}
.alert a {color:orange}
</style>

<div class="container-fluid">
	<div class="row-fluid" style="padding-bottom:50px">
		
		<!-- Page start -->
		
			<?php if(in_array($this->session->userdata('role'),array('admin','po'))){?>
			<div class="clearfix span10 offset1 alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<ul>
				<?php foreach($troops as $troop):?>
					<li><a href="/missions/applicants/<?=$troop['work_id']?>"><?=$troop['num']?> troop(s) applied for mission '<?=$troop['title']?>'</a>.</li>
				<?php endforeach;?>
			    </ul>
			</div>
			<?php }?>
		
		
		<div id="mybids-content-area" class="span10 offset1"> 

		  <!-- START - Mission Bid Title Block - Dev. by Reza  -->
		  <div id="block-mission-bid-header">
		    <div class="block-header">
		      <h3>Mission Bids</h3>
		    </div>
		  </div>

		  <!-- START - Mission Bid Info Blocks - Dev. by Reza  -->
		  <?php 
			$cur_date = "";
			foreach($bids as $bid):
			$bid_date = date('j M Y',strtotime($bid['created_at']));
		  ?>
		  <div id="block-bid-container" <?php if($bid['bid_status']=='Accepted'){?>class="latest-bid-container"<?php }?>>
		  	<?php if($bid_date!=$cur_date){$cur_date=$bid_date;?>
		    <div id="bid-date"><?=$bid_date;?></div>
		    <?php }?>
		    <div id="bid-info-block">
		      <div id="bid-info-block-left" style="cursor:pointer" onclick="view_mission('<?=$bid['work_id']?>')">
		        <div id="bid-close-date"><?php if($bid['bid_deadline']){?>Bid closes on <?php echo date('j M Y',strtotime($bid['bid_deadline'])); }?></div>
		        <div id="proj-title"><?=$bid['title']?></div>
		      </div>
		      <div id="bid-info-block-right">
		        <div id="highest-bid">Your final bid</div>
		        <div id="time-price">
		          <div id="bid-time"><?=$bid['bid_time']?> <?=str_replace('dai','day',substr($bid['arrangement'],0,-2))?>s</div>
		          <div id="bid-price">$ <?=$bid['bid_cost']?></div>
		        </div>
		      </div>
		    </div>
		    <div id="bid-msg">
		      <div id="bid-msg-text">
		      	<?php if($bid['bid_status']=='Accepted' && $bid['status']=='assigned'){//if i won and mission is just assigned to me?>
		        <p><a href="#">Report to the captain</a></p>
		        <?php }elseif($bid['bid_status']=='Accepted' && in_array(strtolower($bid['status']),array('in progress','done','redo','verify','signoff'))){//if i won and mission is in progress?>
		        <p>You won this bid on <?=date('j M Y',strtotime($bid['assigned_at']))?></p>
		        <?php }elseif($bid['bid_status']=='Bid' && !in_array(strtolower($bid['status']),array('open','reject'))){//if i lost the biod?>
		        <p>Sorry! you lost this bid. <a href="#">How to win a bid?</a></p>
		        <?php }elseif($bid['bid_status']=='Bid' && in_array(strtolower($bid['status']),array('open','reject'))){//if still bid is ongoing?>
		        <p>Average bids: </br><b style="color:#0FF"><?=round($bid['avg_time'])?></b> <?=str_replace('dai','day',substr($bid['arrangement'],0,-2))?>s for USD <b style="color:#0FF"><?=round($bid['avg_cost'])?></b>/<?=str_replace('dai','day',substr($bid['arrangement'],0,-2))?></p>
		        <?php }?>
		      </div>
		      <?php if(($bid['bid_status']=='Bid')||($bid['bid_status']=='Accepted' && in_array(strtolower($bid['status']),array('open','reject')))){?>
		      <div id="stop-following-bid"><a class="unwatch_bid" title="Cancels your bid and stops following on this mission" href="javascript:void(0)" id="unwatch_<?=$bid['bid_id']?>">Stop following</a></div>
		      <?php }?>
		    </div>
		  </div>
		  <?php endforeach;?>
		</div>
		
		<!-- Page ends -->
		
	</div>
</div>

<script type="text/javascript">
$(function(){
		$(".fancybox").fancybox({type : 'iframe'});
		$('.unwatch_bid').live('click',function(){
			var bid_id = $(this).attr('id').split('_')[1];
			var me = $(this);
			$.ajax({
				url: '/missions/Ajax_cancel_bid',
				type: 'post',
				data:{'csrf_workpad': getCookie('csrf_workpad'), 'bid_id':bid_id},
				success: function(msg){
					if(msg=="success"){
						if (typeof console == "object") console.log(me.parents('#block-bid-container'));
						me.parents('#block-bid-container').slideUp('slow',function(){$(this).remove();});
					}else{
						alert('msg');
						if (typeof console == "object") console.log(msg);
					}
				}
			});
		});
	});

function view_mission(work_id){
	$.fancybox.open({
			type: 'iframe',
			href: "/missions/apply/"+work_id,
			padding : 0,
			margin: 0,
			height: 600,
			autoSize: false,
			width:860,
			'overlayShow': true,
			'overlayOpacity': 0.5, 
			afterClose: function(){},
			openMethod : 'dropIn',
			openSpeed : 250,
			closeMethod : 'dropOut',
			closeSpeed : 150,
			nextMethod : 'slideIn',
			nextSpeed : 250,
			prevMethod : 'slideOut',
			prevSpeed : 250,
			height: 600,
		});
}
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
