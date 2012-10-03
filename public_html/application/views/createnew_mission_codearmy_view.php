<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<style type="text/css">
	#container {padding-top:0}
	#footer {display:none}
	.tcenter {text-align:center}
	
	h1 {font-size:1.7em; text-align:center; padding:10px 0 25px; text-shadow: 0 1px 1px black}
	.subpanel i, .panel .pull-right i {display:none}
	
	.data {background: #444; display:block}
	.data select {width:100%; border:none; border-radius:0; color:black; background:#666; -webkit-appearance:none; height:50px; padding:0 20px; border-bottom:1px solid black}
	.data select.active { color:white; background:#ff8000;}
	
	.data .wrap-select {position:relative; clear:both}
	.data .wrap-select span {position:absolute; right:10px; top: 20px}
	.data.padding {padding:20px}
	
	.data .wrap-info .subpanel {height:40px; line-height:40px; padding:10px; border-bottom:1px solid black; border-top:1px solid #666; text-align:center; color:#ff8000; background:#111}
	.data .wrap-info .subinfo {text-align:center; padding:20px;}
	/* .data .wrap-info.title .subinfo input[type="text"] {margin:20px auto; line-height:1em; width:50%} */
	.data .wrap-info .subinfo textarea {background:white; color:black; width:60%; margin:20px auto; float:none}
	
	ul.tagit {padding: 10px; overflow: auto; background: white; color:black; margin:20px 0; width:inherit; float: none; box-shadow: none;}
	ul.tagit li.tagit-choice {background:#777; color:white; border:0; font-weight:normal}
	ul.tagit input[type="text"] {color:black}
	ul.tagit li.tagit-new {background: none; padding:2px}
	ul.ui-autocomplete.ui-menu.ui-widget.ui-widget-content.ui-corner-all { background: white; color:black; border-radius:0}
	ul.ui-autocomplete.ui-menu.ui-widget.ui-widget-content.ui-corner-all .ui-menu-item a {color:black}
	ul.ui-autocomplete.ui-menu.ui-widget.ui-widget-content.ui-corner-all .ui-menu-item a.ui-state-hover {background: #ff8000; border-radius:0; border:none}
	
	.missionlevel { margin:10px auto; }
	.missiontype {width:100px; height:100px; line-height:100px; border-radius: 50%; margin-right: 10px;background: #999; color:#555; cursor:pointer; display:inline-block; margin-bottom:20px}
	.missiontype:hover {background:white; color:black}
	.missiontype.active {background:#ff8000; color:white}
		
	@-moz-document url-prefix() { 
		.data select {padding: 15px 20px;}
		.data .wrap-select span {display:none}
		.data select option {padding:10px 5px}
	}
</style>
<?php if($me['role']!='po' || $me['role']!='admin'){?>
	<?php echo form_open('#' , array('id'=>'form-create-mission')); ?>
<?php } ?>
<div class="container-fluid base">
	
	<div class="row-fluid">
		<h1>Create Mission</h1>
	</div>
	
	<div class="row-fluid">
		
		<article class="span10 offset1 skills-required">
			<div class="data clearfix">
				
				<!-- Title -->
				<div class="wrap-info title">
					<div class="subpanel">What should you call this mission? <span class="pull-right"><i class="icon-ok"></i></span></div>
					<div class="subinfo">
						<input type="text" id="mission-title" name="mission-title" class="required" tabindex="1" autofocus value="" placeholder="Generic website.."/>
					</div>
				</div>
				
				<!-- Mission type -->
				<div class="wrap-info title">
					<div class="subpanel">What type of mission you want to carry out? <span class="pull-right"><i class="icon-ok"></i></span></div>
					<div class="subinfo">
						<div class="clearfix missionlevel">
							<div class="missiontype">software</div>
							<div class="missiontype">web</div>
							<div class="missiontype active">mobile</div>
							<div class="missiontype">design</div>
							<div class="missiontype">writing</div>
						</div>
						<hr />
						<div class="clearfix missionlevel">
							<div class="missiontype">ios</div>
							<div class="missiontype">android</div>
							<div class="missiontype">win</div>
							<div class="missiontype active">web</div>
						</div>
						
						<div class="data padding clearfix">
							<p class="tcenter">These skills are automatically generated for you based on your chosen mission type:</p>
							<input type="hidden" name="tags" id="hiddenSkill" value="" disabled="true" placeholder="PHP">
							<ul id="skills-required"></ul>
						</div>
					</div>
				</div>
				
				<!-- Budget -->
				<div class="wrap-info title">
					<div class="subpanel">Please enter the max dollars for this mission (USD).<span class="pull-right"><i class="icon-ok"></i></span></div>
					<div class="subinfo">
						<input type="text" id="" name="" class="input-medium required" tabindex="1" autofocus value="" placeholder="$ 5500"/>
					</div>
				</div>
				
				<!-- Date -->
				<div class="wrap-info title">
					<div class="subpanel">Please specify the mission’s start and end date.<span class="pull-right"><i class="icon-ok"></i></span></div>
					<div class="subinfo">
						<input type="text" id="" name="datestart" class="pickadate input-small required" tabindex="1" autofocus value="" /> to <input type="text" id="" name="dateend" class="pickadate2 input-small required" tabindex="1" autofocus value=""/>
						
					</div>
				</div>
				
				<!-- Description -->
				<div class="wrap-info description">
					<div class="subpanel">Please elaborate this mission as detail as you can.<span class="pull-right"><i class="icon-ok"></i></span></div>
					<div class="subinfo clearfix">
					
						<textarea rows="7" tabindex="2" id="mission-desc-text" name="mission-desc-text" class="required"></textarea>
						<div class="clearfix">
							<!-- Attachment -->
								<div id="plupload-container" style="clear:both">
							    	<input type="button" tabindex="3" id="pickfiles" class="btn" value="Attach files">
									<div id="filelist"><small>No runtime found</small></div>
								</div>
						</div>
						<hr />
						<div>
							<p>Paste a video from YouTube or Vimeo:</p>
							<input type="text" tabindex="8" id="mission-video" name="mission-video" value="" placeholder="Youtube video tag or url.."/>
						</div>
						<iframe class="youtube-player" id="mission-video-youtube" type="text/html" width="330" height="216" src="http://www.youtube.com/embed/" frameborder="0"></iframe>
					</div>
				</div>
				
				<!-- Submit -->
				<div class="wrap-info description">
					<div class="subpanel"><a href="#" class="btn">Cancel</a> <a href="#" class="btn">Save as Draft</a> <a  href="#" class="btn btn-success go">Submit</a></div>
				</div>
				
			</div>
		</article>
		
	</div>
</div>
</form>
<script type="text/javascript" src="/public/js/tag-it.js"></script>
<script type="text/javascript">
	$(function(){
		$( ".pickadate, .pickadate2" ).datepicker();
		
		formInit();
		
		var sampleTags = [<?php foreach($skills as $skill): echo "'".$skill['skills']."', "; endforeach;?><?php foreach($skillsonly as $skillonly): echo "'".$skillonly['name']."', "; endforeach;?>''];

        $('#skills-required').tagit({
		    availableTags: sampleTags,
			singleField: true,
			singleFieldNode: $('#hiddenSkill')
	    });
		$('.ui-autocomplete-input').attr('tabindex','8');
	});
	
	function formInit(){
		var start=/@/ig, word=/@(\w+)/ig;
		//var word=/(\w+)/ig;
		
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