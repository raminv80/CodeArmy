<!-- 
Format of hint is: 
<div id="My_CUSTOM_ID" class="hint" highlight="class1 class2 ..." exclude="clss1 clss2 ..."> ... </div>
This hint will be activated if there is a dom object within body having class hint_MY_CUSTOM_ID and it will attach itself to the selected object.
Selected object and all items with classes located in highlight attribute will be highlighted. 
All items with classed located in exclude attribute will remain enabled.
-->
<?php 
//get tutorial state
$sql = "select show_tutorial from users where user_id=?";
$res=$this->db->query($sql, array($this->session->userdata('user_id')));
$res = $res->result_array(); $tutorial = $res[0]['show_tutorial'];
//if($this->session->userdata('tutorial')>0) 
//--enable previous line if you want the close dialog button hide next dialogs too
if($this->session->userdata('user_id') && $this->gamemech->get_level($me['exp'])<100){?>
	<?php if($tutorial==1 || $this->session->flashdata('bidding_tutorial')){ //bidding tutorial?>
    <!-- homepage -->
    <div id="dev_step1" class="hint" exclude="user-stories">
      <div>
        <div class="left-column"><img height="40px" src="/public/images/step1.jpg" /></div>
        <div class="right-column">
          <h3>Browse!</h3>
          Click here to go to browse story page.
          <p class="dialog-hint">Hint: You can refer to user stories located at bottom of page for a quick browse.</p>
        </div>
      </div>
    </div>
    <!-- -->
    <div id="dev_step2" class="hint" highlight="bid-more" exclude="user-stories">
      <div>
        <div class="left-column"><img height="40px" src="/public/images/step2.jpg" /></div>
        <div class="right-column">
          <h3>Select a Job!</h3>
          Just click/expand a user story, view its summary and if you are intrested click on 'Bid & More'.
          <p class="dialog-hint">Hint: Use search and filtering tools to refine your selection</p>
        </div>
      </div>
    </div>
    
    <div id="dev_step3" class="hint" highlight="WP-qualification-placeholder" exclude="WP-allbid-placeholder WP-comment-placeholder">
      <div>
        <div class="left-column"><img height="40px" src="/public/images/step3.jpg" /></div>
        <div class="right-column">
          <h3>Bid!</h3>
          Read it. Interested? Say how much and how long you need to finish it then click on Bid button.
          <p class="dialog-hint">1)Use discussion area for more info.<br />2)Compare your bidding against other competitors.</p>
        </div>
      </div>
    </div>
    <?php }elseif($tutorial==2){ //submit tutorial?>
    <!-- homepage -->
    <div id="dev_step4" class="hint">
      <div>
        <div class="left-column"><img height="40px" src="/public/images/step1.jpg" /></div>
        <div class="right-column">
          <h3>My Office!</h3>
          Click here to go to Your Office page.
          <p class="dialog-hint">Hint: To do works or to manage project you need to go to your office page first.</p>
        </div>
      </div>
    </div>
    
    <div id="dev_step5" class="hint">
      <div>
        <div class="left-column"><img height="40px" src="/public/images/step2.jpg" /></div>
        <div class="right-column">
          <h3>My Desk!</h3>
          Click here to go to Your Deck. You can access all your tasks there.
          <p class="dialog-hint">My Deck page not only lists your active tasks but also your prvious assigned tasks and their states.</p>
        </div>
      </div>
    </div>
    
    <script type="application/javascript">
	$('.hint_dev_step5').click(function(){$(this).removeClass('hint_dev_step5');});
    </script>
    
    <div id="dev_step6" class="hint">
      <div>
        <div class="left-column"><img height="40px" src="/public/images/step3.jpg" /></div>
        <div class="right-column">
          <h3>Job Done!</h3>
          Once you are finished with a task and you are ready to submit it click here.
          <p class="dialog-hint">Hint: There's a button to submit your assigned jobs within story detail page too.</p>
        </div>
      </div>
    </div>
    
    <div id="dev_step7" class="hint">
      <div>
        <div class="left-column"><img height="40px" src="/public/images/4.png" /></div>
        <div class="right-column">
          <h3>Submit!</h3>
          Add a link to github commit or upload files (ZIP) or add a remote link to files and submit. 
          <p class="dialog-hint">Hint: You need to test your work, review essentials and accept the terms before submission.</p>
        </div>
      </div>
    </div>
    
    <?php }?>
<?php }?>
<!-- tutorial intro dialogs -->
<?php 
	if($this->session->userdata('user_id') && $page_is=='Home' && $action_is=='index'){
		if($this->session->flashdata('bidding_tutorial')){
?>
    <div id="bidding_tutorial" title="Bidding Tutorial">
      <p>
        Would you like to take a tour and see how to browse jobs and bid on them?
      </p>
    </div>
<?php 	}else{
			if($tutorial>0){ 
 				if($tutorial==2){
?>
    <div id="submit_tutorial" title="Submission Tutorial">
      <p>
        Would you like to take a tour and see how to submit your jobs?
      </p>
    </div>
<?php 			}?>
<?php 		}//if tutorial >0?>
<?php 	} //if first time?>
<?php } // if logged ?>

<script type="application/javascript">
	$( "#bidding_tutorial:ui-dialog" ).dialog( "destroy" );
		$( "#bidding_tutorial" ).dialog({
			resizable: false,
			height:240,
			width:470,
			modal: true,
			buttons: {
				"Yes": function() {
					$.ajax({url:"/tutorial/AjaxBiddingTutorial", async:false});
					$( this ).dialog( "close" );
					initDialogs();
				},
				"No": function() {
					$.ajax("/tutorial/AjaxDisable");
					$( this ).dialog( "close" );
				}
			}
		});
		
	$( "#submit_tutorial:ui-dialog" ).dialog( "destroy" );
		$( "#submit_tutorial" ).dialog({
			resizable: false,
			height:240,
			width:470,
			modal: true,
			buttons: {
				"Yes": function() {
					$( this ).dialog( "close" );
					initDialogs();
				},
				"No": function() {
					$.ajax("/tutorial/AjaxDisable");
					$( this ).dialog( "close" );
				}
			}
		});

	$(function(){
		<?php if(!($page_is=='Home' && $action_is=='index')){?>initDialogs();<?php }?>
		//pre load images
		if (document.images) {
			img1 = new Image();
			img1.src = "/public/images/ajax-loader.gif";
			img1 = new Image();
			img1.src = "/public/images/dialog-down.png";
			img1 = new Image();
			img1.src = "/public/images/dialog-down-left.png";
			img1 = new Image();
			img1.src = "/public/images/dialog-up.png";
			img1 = new Image();
			img1.src = "/public/images/dialog-up-left.png";
			img1 = new Image();
			img1.src = "/public/images/alertbox1.png";
		}
	});		
	
	var dialogs = new Array();
	var showDialog = new Array();
	var target_found = false;
	
	function initDialogs(){
		targetLights="";
		excludes = "";
		$('.hint').each(function(index){
			dialogs.push($(this).html());
			showDialog.push(true);
			dialog = $(this);
			dialog.hide();
			target_class = dialog.attr('id');
			target = $('.hint_'+target_class);
			if(target.length>0) target_found=true;
			//build the list of highlights and excludes.
			var hl = $(this).attr('highlight');
			var he = $(this).attr('exclude');
			if(typeof hl!= 'undefined'){
				hl = hl.split(' ');
				hl_buff = new Array();
				for(i=0;i<hl.length;i++)if($('.'+hl[i]).length>0)hl_buff.push('.'+hl[i]);
				if(hl_buff.length>0){hl=hl_buff.join(',');hl+=',';}else{hl='';}
			}else hl='';
			if(typeof he!= 'undefined'){
				he = he.split(' ');
				he_buff = new Array();
				for(i=0;i<he.length;i++)if($('.'+he[i]).length>0)he_buff.push('.'+he[i]);
				if(he_buff.length>0){he=he_buff.join(',');he+=',';}else{he='';}
			}else he='';
			
			targetLights +=hl;
			excludes +=he;
			
			pic="";margin="";
			if(target.offset()){
				targetLights += '.hint_'+target_class+',';
				dialog.click(function(){
						if($(this).is(':visible')){
							target = $(this).attr('id');
							target = $('.hint_'+target);
							$('html,body').animate({scrollTop: target.offset().top-100},'fast');
						}
					});
				//if show at top
				if((target.offset().top-dialog.height())>$(window).scrollTop()){
					toTop = Math.min($(window).scrollTop()+$(window).height()-dialog.height(), target.offset().top-dialog.height());
					pic = "up";
					margin = "top";
				}else{
					pic = "down";
					margin = "down";
					toTop = Math.max($(window).scrollTop(), target.offset().top+target.height());
				}
				//if show at right
				if((target.offset().left+target.width()+dialog.width()) < $(window).width()){
					toLeft = target.offset().left+target.width();
					if(margin=="top"){margin = "20px 20px 45px 20px"}else{margin = "45px 20px 20px 20px"}
				}else{
					toLeft = target.offset().left-dialog.width();
					pic += "-left";
					if(margin=="top"){margin = "20px 20px 45px 20px"}else{margin = "45px 20px 20px 20px"}
				}
				dialog.html("<div class='dialog-container' style='background:url(/public/images/dialog-"+pic+".png)'><div class='content' style='padding: "+margin+"'><a title='Close the Tutorial.' class='dialog-close' id='dialog-close-"+index+"' href='javascript: void(0);'><img height='12px' width='12px' src='/public/images/close.png' border='0' /></a>"+$(this).html()+"</div></div>");
				$('#dialog-close-'+index).click(function(){$.ajax('/profile/hide_tutorial');$('#modalDiv').hide(); $(old_highlights).css({'position':'relative', 'z-index':0, '-webkit-box-shadow': '#fff 0px 0px 0px', '-moz-box-shadow': '#fff 0px 0px 0px','box-shadow': '#fff 0px 0px 0px'});$(old_exclude).css({'position':'relative', 'z-index':0}); $(this).parents('.hint').hide(); index=$(this).attr('id').substring(13); showDialog[index] = false;});
				dialog.show().css({
					left: (toLeft)+"px",
					top: (toTop)+"px"
				});
			}
		});
		targetLights = targetLights.slice(0, -1);
		excludes = excludes.slice(0, -1);
		if(target_found && targetLights!=""){
			highlight(targetLights, excludes);
		}
	}
	
	$(window).scroll(function(){ 
		//do this for each dialog
		$('.hint').each(function(index){
			dialog = $(this);
			dialog.hide();
			target = dialog.attr('id');
			target = $('.hint_'+target);
			content = dialogs[index];
			pic="";margin="";
			
			if(target.offset()){
				//if show at top
				if((target.offset().top-dialog.height())>$(window).scrollTop()){
					toTop = Math.min($(window).scrollTop()+$(window).height()-dialog.height(), target.offset().top-dialog.height());
					pic = "up";
					margin = "top";
				}else{
					pic = "down";
					margin = "down";
					toTop = Math.max($(window).scrollTop(), target.offset().top+target.height());
				}
				//if show at right
				if((target.offset().left+target.width()+dialog.width()) < $(window).width()){
					toLeft = target.offset().left+target.width();
					if(margin=="top"){margin = "20px 20px 45px 20px"}else{margin = "45px 20px 20px 20px"}
				}else{
					toLeft = target.offset().left-dialog.width();
					pic += "-left";
					if(margin=="top"){margin = "20px 20px 45px 20px"}else{margin = "45px 20px 20px 20px"}
				}
				
				dialog.html("<div class='dialog-container' style='background:url(/public/images/dialog-"+pic+".png)'><div class='content' style='padding: "+margin+"'><a class='dialog-close' id='dialog-close-"+index+"' href='javascript: void(0);'><img height='12px' width='12px' src='/public/images/close.png' border='0' /></a>"+content+"</div></div>");
				$('#dialog-close-'+index).click(function(){$.ajax('/profile/hide_tutorial');$('#modalDiv').hide(); $(old_highlights).css({'position':'relative', 'z-index':0, '-webkit-box-shadow': '#fff 0px 0px 0px', '-moz-box-shadow': '#fff 0px 0px 0px','box-shadow': '#fff 0px 0px 0px'});$(old_exclude).css({'position':'relative', 'z-index':0}); $(this).parents('.hint').hide(); index=$(this).attr('id').substring(13); showDialog[index] = false;});
				
				if(showDialog[index]){
					dialog.show().css({
						left: (toLeft)+"px",
						top: (toTop)+"px"
					});
				}
			}
		});
	});
</script>