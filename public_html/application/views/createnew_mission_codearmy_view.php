<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<style type="text/css">
	#container {padding-top:0}
	#footer {display:none}
	.tcenter {text-align:center}
	
	section.row-fluid [class*="span"]:first-child {margin-left:2.127659574468085%}
	h1 {font-size:1.7em; text-align:center; padding:10px 0 25px; text-shadow: 0 1px 1px black}
	.panel {background: black; color: #ff8000; height:30px; line-height:30px; padding: 10px 20px; text-align:center; font-size:1.1em; margin-top:5px; text-transform: uppercase; }
	.panel.done {background: #888; color:#222; text-shadow: 0 1px 1px #aaa; font-weight:700; cursor:pointer}
 	.panel.done:hover {background: #aaa}
	.panel.done i {color:lightgreen; text-shadow: 0 1px 1px black}
	.subpanel i, .panel .pull-right i {display:none}
	.panel .pull-left i {cursor:pointer;display:none}
	
	.data {background: #444; display:none}
	.data select {width:100%; border:none; border-radius:0; color:black; background:#666; -webkit-appearance:none; height:50px; padding:0 20px; border-bottom:1px solid black}
	.data select.active { color:white; background:#ff8000;}
	
	.data .wrap-select {position:relative; clear:both}
	.data .wrap-select span {position:absolute; right:10px; top: 20px}
	.data.padding {padding:20px}
	
	.data .wrap-info .subpanel {height:40px; line-height:40px; padding:10px; border-bottom:1px solid black; border-top:1px solid #666; text-align:center}
	.data .wrap-info .subinfo {background:#333; text-align:center; padding:20px; display:none}
	.data .wrap-info.title .subinfo input[type="text"] {margin:20px auto; line-height:1em; width:50%}	
	.data .wrap-info .subinfo textarea {background:white; color:black; width:60%; margin:20px auto; float:none}
	.data .wrap-info.video .subinfo input[type="text"] {margin: 20px auto}
	
	.delivery select {display:none}
	
	.mission-type select {display:none}
	
	ul.tagit {padding: 10px; overflow: auto; background: white; color:black; margin:20px 0; width:inherit; float: none; box-shadow: none;}
	ul.tagit li.tagit-choice {background:#777; color:white; border:0; font-weight:normal}
	ul.tagit input[type="text"] {color:black}
	ul.tagit li.tagit-new {background: none; padding:2px}
	ul.ui-autocomplete.ui-menu.ui-widget.ui-widget-content.ui-corner-all { background: white; color:black; border-radius:0}
	ul.ui-autocomplete.ui-menu.ui-widget.ui-widget-content.ui-corner-all .ui-menu-item a {color:black}
	ul.ui-autocomplete.ui-menu.ui-widget.ui-widget-content.ui-corner-all .ui-menu-item a.ui-state-hover {background: #ff8000; border-radius:0; border:none}
		
	@-moz-document url-prefix() { 
		.data select {padding: 15px 20px;}
		.data .wrap-select span {display:none}
		.data select option {padding:10px 5px}
	}
</style>

<?php echo form_open('#' , array('id'=>'form-create-mission')); ?>
<div class="container-fluid base">
	
	<div class="row-fluid">
		<h1>Create Mission</h1>
	</div>
	
	<div class="row-fluid">
		
		<div class="span10 offset1">
			
			<section class="row-fluid">
				
				<!-- First -->
				<article class="span12 mission-type">
					<div class="panel">I want to build 
						<span class="pull-right"><i class="icon-ok"></i></span>
					</div>
					<div class="data padding clearfix">
						
						<div class="wrap-select">
							<select tabindex="5" id="mission-type-main" name="mission-type-main" class="required active" validate="required:true">
								<option value="">Select type</option>
								<?php foreach($main_category as $value): ?>
								<option value="<?=$value['category_id']?>" <?php if($value['category_id']==$cat_selected){?>selected="selected"<?php }?>><?=$value['category']?></option>
								<?php endforeach; ?>
							</select>
							<span><i class="icon-caret-down"></i></span>
						</div>
						
						<div class="wrap-select">
							<select tabindex="6" id="mission-type-class" name="mission-type-class" class="mission-type-sub">
						        <option value="0">Select area</option>
						      <?php foreach($class as $value): ?>
						        <option value="<?=$value['class_id']?>"><?=$value['class_name']?></option>
						      <?php endforeach; ?>
						    </select>
							<span><i class="icon-caret-down"></i></span>
						</div>
						
						<div class="wrap-select">
							<select tabindex="7" id="mission-type-sub" name="mission-type-sub" class="mission-type-sub">
						        <option value="0">Select area</option>
						      <?php foreach($sub_class as $value): ?>
						        <option value="<?=$value['subclass_id']?>"><?=$value['subclass_name']?></option>
						      <?php endforeach; ?>
						    </select>
							<span><i class="icon-caret-down"></i></span>
						</div>
					</div>
				</article>
				
				<!-- Second -->
				<article class="span12 skills-required">
					<div class="panel">Skills Required
						<!-- <span class="pull-left"><i class="icon-chevron-left"></i></span> -->
						<span class="pull-right"><i class="icon-ok"></i></span>
					</div>
					<div class="data padding clearfix">
						<p class="tcenter">These skills are automatically generated for you based on your chosen mission type:</p>
						<input type="hidden" name="tags" id="hiddenSkill" value="" disabled="true" placeholder="PHP">
						<ul id="skills-required"></ul>
						<div class="btn btn-success pull-right next" style="margin: 0 auto">Next</div>
					</div>
				</article>
				
				<!-- Third -->
				<article class="span12 delivery">
					<div class="panel">I WANT IT DELIVERED BY
						<!-- <span class="pull-left"><i class="icon-chevron-left"></i></span> -->
						<span class="pull-right"><i class="icon-ok"></i></span>
					</div>
					<div class="data padding clearfix">
						
						<div class="wrap-select">
							<span><i class="icon-caret-down"></i></span>
							<select tabindex="10" id="mission-arrange-type" name="mission-arrange-type" class="mission-arrange-hour required" validate="required:true">
					          <option value="">Select duration</option>
				              <?php foreach($arrangement_type as $type): ?>
					          <option value="<?=$type['id']?>"><?=$type['type']?></option>
				              <?php endforeach; ?>
					        </select>
							<span><i class="icon-caret-down"></i></span>
						</div>
				
						<div class="wrap-select">
							<select tabindex="11" id="mission-arrange-duration" name="mission-arrange-duration" class="mission-arrange-month required" validate="required:true">
					          <option value=""></option>
					        </select>
							<span><i class="icon-caret-down"></i></span>
						</div>
					</div>
				</article>
				
				<!-- Fourth -->
				<article class="span12 skills-required">
					<div class="panel">My budget is
						<!-- <span class="pull-left"><i class="icon-chevron-left"></i></span> -->
						<span class="pull-right"><i class="icon-ok"></i></span>
					</div>
					<div class="data padding clearfix">
						<div class="wrap-select">
							<select tabindex="12" id="mission-budget" name="mission-budget" class="mission-budget required" validate="required:true">
					          <option value=""></option>
					        </select>
							<span><i class="icon-caret-down"></i></span>
						</div>
					</div>
				</article>
				
				<!-- Fifth -->
				<article class="span12 skills-required">
					<div class="panel brief">Here is my brief
						<!-- <span class="pull-left"><i class="icon-chevron-left"></i></span> -->
						<span class="pull-right"><i class="icon-ok"></i></span>
					</div>
					<div class="data clearfix">
						
						<!-- Title -->
						<div class="wrap-info title">
							<div class="subpanel">Let’s call this mission … <span class="pull-right"><i class="icon-ok"></i></span></div>
							<div class="subinfo"><input type="text" id="mission-title" name="mission-title" class="required" tabindex="1" autofocus value="" placeholder="Generic website.."/> <div class="btn btn-success go">Next</div></div>
						</div>
						
						<!-- Description -->
						<div class="wrap-info description">
							<div class="subpanel">Mission description <span class="pull-right"><i class="icon-ok"></i></span></div>
							<div class="subinfo clearfix">
								<p>Please describe your mission in detail:</p>
								<textarea rows="7" tabindex="2" id="mission-desc-text" name="mission-desc-text" class="required"></textarea>
								<div style="width:60%; margin:0 auto">
									<!-- Attachment -->
									<div class="pull-left">
										<div id="plupload-container" style="clear:both">
									    	<input type="button" tabindex="3" id="pickfiles" class="btn" value="Attach files">
											<div id="filelist"><small>No runtime found</small></div>
										</div>
									</div>
									<!-- Submit -->
									<div class="pull-right">
										<div class="btn btn-success go">Submit</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Video -->
						<div class="wrap-info video">
							<div class="subpanel">Video <span class="pull-right"><i class="icon-ok"></i></span></div>
							<div class="subinfo">
								<div><input type="text" tabindex="8" id="mission-video" name="mission-video" value="" placeholder="Youtube video tag or url.."/> <div class="btn btn-success go last">Next</div></div>
								<iframe class="youtube-player" id="mission-video-youtube" type="text/html" width="330" height="216" src="http://www.youtube.com/embed/" frameborder="0"></iframe>
							</div>
						</div>
					</div>
				</article>
				
				<!-- Last -->
				<article class="span12 skills-required">
					<div class="panel">Ok I'm all set
						<!-- <span class="pull-left"><i class="icon-chevron-left"></i></span> -->
						<span class="pull-right"><i class="icon-ok"></i></span>
					</div>
					<div class="data padding tcenter clearfix">
						<input tabindex="14" type="reset" class="btn " id="cancel-mission" value="Cancel">
						<input tabindex="13" type="button" class="btn btn-success" id="post-mission" value="Post Mission">
					</div>
				</article>
				
			</section>
			
		</div>
		
	</div>
</div>
</form>
<script type="text/javascript" src="/public/js/tag-it.js"></script>
<script type="text/javascript">
	$(function(){
		init();
		formInit();
		
		var sampleTags = [<?php foreach($skills as $skill): echo "'".$skill['skills']."', "; endforeach;?><?php foreach($skillsonly as $skillonly): echo "'".$skillonly['name']."', "; endforeach;?>''];

        $('#skills-required').tagit({
		    availableTags: sampleTags,
			singleField: true,
			singleFieldNode: $('#hiddenSkill')
	    });
		$('.ui-autocomplete-input').attr('tabindex','8');
	});
	
	function init(){
		$('.mission-type select').eq(0).show();
		$('article').eq(0).find('.data').slideDown();
		$('.subinfo').eq(0).show();
		$('.delivery select').eq(0).show();
	}
	
	function formInit(){
		var start=/@/ig, word=/@(\w+)/ig;
		//var word=/(\w+)/ig;
		
		$('.panel').click(function(){
			//$(this).next().slideToggle();
			//alert('HAZWAN AWESOME!');
		})
		
		$('.next').click(function(){
			$(this).parents('.data').slideUp().prev().addClass('done').find('i').show();
			
			done = $(this).parents('article').next().find('.panel').is('.done');
			if (!done){
				$(this).parents('article').next().find('.data').slideDown().find('select').eq(0).addClass('active');
			}
		});
		
		$('.go').click(function(){
			$(this).parents('.subinfo').slideUp().prev().addClass('done').find('i').show();
			
			if ( $(this).is(".last") ) { 
				$(this).parents('.data').slideUp().prev().addClass('done').find('i').show();
				$(this).parents('article').next().find('.data').slideDown();
			} else {
				$(this).parents('.wrap-info').next().find('.subinfo').slideDown().find('input').focus();
			}

		});
		
		$('select').live('change',function(){
			$(this).removeClass('active').parent().next().find('select').slideDown().addClass('active');
		})
		
		$('.panel').click(function(){
			if ( $(this).is('.done')){
				$(this).removeClass('done').find('i').hide()
				$(this).next().slideToggle();
				
				if ($(this).is('.brief')){
					$(this).next().find('.subinfo').eq(0).slideDown().find('input').focus();
				}
			}
		})
		
		$('.mission-type select').focus(function(){
			$('.mission-type select').removeClass('active');
			$(this).addClass('active')
		});
		
		$('#mission-type-main').live("change",function(){
			$.ajax({
				type: "POST",
				url: "/missions/Ajax_get_class",
				data:{'category':$(this).val(), 'csrf_workpad':getCookie('csrf_workpad')},
				dataType: "json",
				success: function(msg){
					$('#mission-type-class').html('');
					$('#mission-type-class').append("<option value='0'>-- Please select --</option>");
					$(msg).each(function(){$('#mission-type-class').append("<option value='"+this.class_id+"'>"+this.class_name+"</option>")});
				}
			});
			$(this).removeClass('active').parent().next().find('select').slideDown().addClass('active');
		});
		
		$('#mission-type-class').live("change",function(){
			$.ajax({
				type: "POST",
				url: "/missions/Ajax_get_subclass",
				data:{'class':$(this).val(), 'category':$('#mission-type-main').val(), 'csrf_workpad':getCookie('csrf_workpad')},
				dataType: "json",
				success: function(msg){
					$('#mission-type-sub').html('');
					$('#mission-type-sub').append("<option value='0'>-- Please select --</option>");
					$(msg).each(function(){$('#mission-type-sub').append("<option value='"+this.subclass_id+"'>"+this.subclass_name+"</option>")});
				}
			});
			$(this).removeClass('active').parent().next().find('select').slideDown().addClass('active');
		});
		
		$('#mission-type-sub').live('change',function(){
			
			var panel = $(this).parents('.data');
			var done = $(this).parents('article').next().find('.panel').is('.done');
			
			panel.slideUp().prev().addClass('done').find('i').show();
			
			if (!done){
				//panel.parent().next().find('.pull-left i').css('display','block');
				panel.parent().next().find('.data').slideDown().find('input[role="textbox"]').focus();
			}
			
		});
		
		$('#mission-arrange-type').live("change",function(){
			$.ajax({
				type: "POST",
				url: "/missions/Ajax_get_duration",
				data:{'type':$(this).val(), 'csrf_workpad':getCookie('csrf_workpad')},
				dataType: "json",
				success: function(msg){
					$('#mission-arrange-duration').html('');
					$('#mission-arrange-duration').append("<option value=''>Please select</option>");
					$(msg).each(function(){$('#mission-arrange-duration').append("<option value='"+this.time_id+"'>"+this.duration+"</option>")});
				}
			});
			$.ajax({
				type: "POST",
				url: "/missions/Ajax_get_budget",
				data:{'type':$(this).val(), 'csrf_workpad':getCookie('csrf_workpad')},
				dataType: "json",
				success: function(msg){
					$('#mission-budget').addClass('active').html('');
					$('#mission-budget').append("<option value=''>-- Please select --</option>")
					$(msg).each(function(){$('#mission-budget').append("<option value='"+this.budget_id+"'>"+this.amount+" $</option>")});
				}
			});
		});
		
		$('#mission-budget, #mission-arrange-duration').live('change',function(){
			var panel = $(this).parents('.data');
			var done = $(this).parents('article').next().find('.panel').is('.done');
			
			panel.slideUp().prev().addClass('done').find('i').show();
			
			if (!done){
				panel.parent().next().find('.data').slideDown();
			}
			
		});
	}
</script>

<?php $this->load->view('includes/CAProfileFooter.php'); ?>