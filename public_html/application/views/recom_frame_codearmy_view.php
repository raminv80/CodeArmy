<?php $this->load->view('includes/frame_header.php'); ?>
<div id="recom_profile">
		<div class="left" style="float:left">
			<div id="block-avatar">
			    <div id="profile-name">beta</div>
			    <a id="msg-icon" href="/messages/compose/beta"></a>
			    <div id="profile-type">developer </div>
			    <div id="avatar-pic"> <img src="/public/images/codeArmy/profile/default-avatar.png" alt="Avatar Picture"> </div>
			    <div id="profile-desc">Hi I'm army from codear.my. Checkout my portfolio to see my latest projects </div>
			  </div>
			
			<div id="mission-complete">
			   <div id="mission-complete-text">Mission In Progress</div>
		       <div id="mission-complete-number">0</div>
		    </div>
		</div>
		
		<div class="right" style="float:right">
			<div id="block-experience">
			    <div id="experience-header">
			      <h3>Level 1 (Exp Points:0)</h3>
			    </div> 
			    <div id="experience-bar">
			      <div style="width:0px" id="experience-bar-progress"> </div>
			    </div>
			</div>
			<div id="block-skill-progression">
			    <div class="block-header active">
			      <h3>Skill Progression</h3>
				  <div class="collapse-arrow"><i class="icon-list-ul"></i></div>
			    </div>
			    <div class="skill-wrapper">
			    	<div class="skill-unit">
				      <div id="skill-title">Problem Solver</div>
				      <div id="skill-bar">
				        <div style="width:0%" id="skill-bar-progress" original-title="0"></div>
				      </div>
				    </div>
					<div class="skill-unit">
				      <div id="skill-title">Planner</div>
				      <div id="skill-bar">
				        <div style="width:0%" id="skill-bar-progress" original-title="0"></div>
				      </div>
				    </div>
					<div class="skill-unit">
				      <div id="skill-title">Decision Maker</div>
				      <div id="skill-bar">
				        <div style="width:0%" id="skill-bar-progress" original-title="0"></div>
				      </div>
				    </div>
					<div class="skill-unit">
				      <div id="skill-title">Communication</div>
				      <div id="skill-bar">
				        <div style="width:0%" id="skill-bar-progress" original-title="0"></div>
				      </div>
				    </div>
					<div class="skill-unit">
				      <div id="skill-title">Public Relation</div>
				      <div id="skill-bar">
				        <div style="width:0%" id="skill-bar-progress" original-title="0"></div>
				      </div>
				    </div>
			    </div>
			</div>
			
			<div id="block-achievements" style="width:460px">
			    <div class="block-header">
			      <h3>Achievements</h3>
			      <div class="collapse-arrow"><i class="icon-list-ul"></i></div>
			  </div>
			  	<div class="badge-row">
			          <div id="achievement-unit">
			        <div id="badge-unit"></div>
			      </div>
			          <div id="achievement-unit">
			        <div id="badge-unit"></div>
			      </div>
			          <div id="achievement-unit">
			        <div id="badge-unit"></div>
			      </div>
			          <div id="achievement-unit">
			        <div id="badge-unit"></div>
			      </div>
			          <div id="achievement-unit">
			        <div id="badge-unit"></div>
			      </div>
			          <div id="achievement-unit">
			        <div id="badge-unit"></div>
			      </div>
			          <div id="achievement-unit">
			        <div id="badge-unit"></div>
			      </div>
			          <div id="achievement-unit">
			        <div id="badge-unit"></div>
			      </div>
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