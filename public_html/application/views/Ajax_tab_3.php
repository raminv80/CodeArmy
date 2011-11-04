<div class="tab-holder">
	<div class="tab-frame">
		<div class="content">
			<h1>Inbox</h1>
			
			<div class="notification">
				<h3 style="padding: 10px 0 14px 10px;">notification</h3>
				<img height="45" width="90" alt="flag" src="/public/images/ico-new.png" class="alignright">
				
					<?php if($messages){?>
					<dl class="message">
					<?php foreach($messages as $message):?>
						<dt class="<?php echo $message['status'];?>">
							<span class="title"><?php echo $message['title'];?></span>
							<span class="date"><?php echo $message['created_at'];?></span>
							<div class="arrow"></div>
						</dt>
						<dd><?php echo $message['message'];?></dd>
						
						<?php endforeach;?>
						
					</dl>
					<?php }else{?>
						<h4 class="no-message">
						Your inbox is empty.
						</h4>
					<?php }?>
				
				
			</div>

<div class="recommended-tasks">
			<?php if($recom){?>
              <h3 style="padding: 10px 0 20px 10px;">Recommended tasks</h3>
              <div class="notification">
				
                  <dl class="message">
					<?php foreach($recom as $message):?>
						<dt>
							<span class="title"><?php echo $message['title'];?></span>
							<div class="arrow"></div>
						</dt>
						<dd><?php echo substr(strip_tags($message['description']),0,255);?><br /><a href="/story/<?php echo $message['work_id'];?>">more details...</a></dd>
					<?php endforeach;?>	
				  </dl>
			  </div>
			<?php }?>
</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$('.notification .message dd').hide();
	
	$('.notification .message dt').click(function(){
		$(this).next('dd').slideToggle(500).siblings('dd').slideUp();
		$(this).addClass('selected').siblings('dt').removeClass('');
		return false;
	});
	
</script>