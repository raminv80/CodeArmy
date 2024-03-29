<?php $this->load->view('includes/frame_header.php'); ?>
<?php echo form_open('missions/create_complete' , array('id'=>'form-create-mission')); ?>

<div class="create-mission-wrapper">
  <div class="confirm-mission-container">
    <div class="create-mission-title">Mission Preview</div>
    <div class="confirm-mission-project-name">Project Name</div>
    <div class="mission-brief">
      <div class="mission-brief-title">
        <?=$preview['title']?>
      </div>
      <div class="brief-video">
        <iframe width="330" height="216" frameborder="0" src="http://www.youtube.com/embed/<?=$preview['tutorial']?$preview['tutorial']:'zFNb8j3YAd4'?>?wmode=opaque" type="text/html" class="youtube-player"></iframe>
      </div>
      <div class="brief-text">
        <div class="brief-text-title">Mission Briefing</div>
        <div class="brief-text-content">
          <p>
            <?=$preview['description']?>
          </p>
        </div>
      </div>
    </div>
    <div class="mission-type-arrange-budget">
      <div class="confirm-mission-type">
        <div class="confirm-mission-type-title">Mission Type</div>
        <div class="confirm-mission-type-text">
          <p>
            <?=$preview['catname']?>
            >
            <?=$preview['classname']?>
            <?=$preview['subclassname']?>
          </p>
        </div>
      </div>
      <div class="confirm-mission-arrange-budget">
        <div class="confirm-mission-arrange">
          <div class="confirm-mission-type-title">Mission Arrangement</div>
          <div class="confirm-mission-type-text">
            <?php if($arrangement != "") echo $arrangement['type']; else echo "Not Set";?>
            >
            <?php if($duration != "") echo $duration['duration']; else echo "Not Set";?>
          </div>
        </div>
        <div class="confirm-mission-budget">
          <div class="confirm-mission-type-title">Budget</div>
          <div class="confirm-mission-type-text">
            <?php if($budget != "") echo $budget['amount']; else echo "Not Set";?>
          </div>
        </div>
      </div>
    </div>
    <div class="confirm-mission-skills-files ">
      <div class="confirm-mission-skills">
        <div class="confirm-mission-skills-title">Skills Needed</div>
        <div class="confirm-mission-skills-text">
          <p>
            <?php
		  foreach ($preview_skills as $i=>$skills):
		  	echo $skills['skill_level']." ".$skills['name']."<br>";
		  endforeach;
	      ?>
          </p>
        </div>
      </div>
      <div class="confirm-mission-files">
        <div class="confirm-mission-files-title">Files Included</div>
        <div class="confirm-mission-files-text">
          <?php foreach($preview_files as $i=>$files): ?>
          <p>
          <div class="attach-file-tools"><img src="/public/images/codeArmy/mission/fileicon.png" class="fileicon" /> <span class="filename">
            <?=$files["file_name"]?>
            </span></div>
          </p>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="confirm-mission-assign-po" style="margin:70px 25px 5px 0"> 
      <!--<input type="checkbox" />
	    <label>Assigning this mission tp a Project Manager.</label>--> 
        <!--<input type="checkbox" name="recom" id="need-recom" checked="checked" /><label for="need-recom">I would like system to recommend me some contractors now</label>-->
    </div>
    <div class="submit-cancel-row">
      <input type="hidden" name="work_id" id="work_id" value="<?=$preview['work_id']?>" />
      <input type="button" class="lnkimg" id="edit-mission" value="Edit" tabindex="2">
      <input type="button" class="lnkimg" id="draft-mission" value="Save as Draft" tabindex="2">
      <input type="button" class="lnkimg" id="confirm-mission" autofocus="autofocus" tabindex="1" value="Confirm &amp; Upload">
    </div>
  </div>
  </form>
  <div id="dialog-mission-creatd" class="dialog" title="Mission Created">
    <p><span class="ui-icon ui-icon-check" style="float:left; margin:0 7px 20px 0;"></span>Your mission is successfully created.</p>
  </div>
</div>
<style type="text/css">
.confirm-mission-files-text, .confirm-mission-skills-text, .confirm-mission-type-text {height:50px; width:100%; overflow:auto}
.brief-text-content {height:160px; width:100%; overflow:auto}
.ui-widget-overlay {
	background: black;
	opacity: 0.8;
	filter: Alpha(Opacity=80);
}
</style>
<script type="text/javascript">
$(function(){
	$('.brief-text-content').jScrollPane();
	$('.confirm-mission-type-text').jScrollPane();
	$('.confirm-mission-files-text').jScrollPane();
	$('.confirm-mission-skills-text').jScrollPane();
})

$('#draft-mission').click(function(){
	parent.$.fancybox.close();
	if(paren.window.location!="http://<?=$_SERVER['HTTP_HOST']?>/missions/my_missions"){
		parent.window.location = "http://<?=$_SERVER['HTTP_HOST']?>/missions/my_missions";
	}else{
		parent.window.location.reload();
	}
});

//by Ramin to open edit page
$('#edit-mission').click(function(){
	var mission_id = $('#work_id').val();
	
	parent.$.fancybox.showLoading();
	parent.$('.fancybox-iframe').attr('src','http://<?=$_SERVER['HTTP_HOST']?>/missions/edit_mission/<?=$preview['work_id']?>');
});

$('#confirm-mission').click(function(){
	$.post(
		'/missions/create_complete',
		{ 
		  'work_id': '<?=$preview['work_id']?>',
		  'csrf_workpad': getCookie('csrf_workpad') 
		},
		function(msg){
			if(msg=="success"){
				<?php if(count($preview_skills)==0){?>
					$( "#dialog-mission-creatd" ).dialog({
						resizable: false,
						height:180,
						width:400,
						modal: true,
						buttons: {
							Ok: function() {
								$( this ).dialog( "close" );
								parent.$.fancybox.close();
							}
						}
					});
				<?php }else{?>
					$( "#dialog-mission-creatd" ).dialog({
						resizable: false,
						height:180,
						width:400,
						modal: true,
						buttons: {
							Ok: function() {
								$( this ).dialog( "close" );
								parent.$.fancybox.close();
								parent.$.fancybox.open({
									//type: 'inline',
									data:{},
									href : 'http://<?=$_SERVER['HTTP_HOST']?>/missions/recommended_tallents/<?=$preview['work_id']?>',
									type : 'iframe',
									padding : 0,
									margin: 0,
									height: 600,
									width: 960,
									autoSize: false,
									'overlayShow': true,
									'overlayOpacity': 0.8, 
									afterClose: function(){},
									openMethod : 'dropIn',
									openSpeed : 250,
									closeMethod : 'dropOut',
									closeSpeed : 150,
									nextMethod : 'slideIn',
									nextSpeed : 250,
									prevMethod : 'slideOut',
									prevSpeed : 250,
									scrolling: 'auto'
								});
							}
						}
					});
					//window.top.location.href = 'http://<?=$_SERVER['HTTP_HOST']?>/missions/recommended_tallents/<?=$preview['work_id']?>';
				<?php }?>
			} else {
				alert("msg "+msg);
				if (typeof console == "object") console.log(msg);
			}
		}
	);
});

var win = $(window);
// Full body scroll
var isResizing = false;
win.bind(
	'resize',
	function()
	{
		if (!isResizing) {
			isResizing = true;
			var container = $('.create-mission-wrapper');
			// Temporarily make the container tiny so it doesn't influence the
			// calculation of the size of the document
			container.css(
				{
					'width': 1,
					'height': 1
				}
			);
			// Now make it the size of the window...
			container.css(
				{
					'width': win.width(),
					'height': win.height()
				}
			);
			isResizing = false;
			container.jScrollPane(
				{
					'showArrows': true
				}
			);
		}
	}
).trigger('resize');
/* IE calculates the width incorrectly first time round (it doesn't count the space used by the native scrollbar) so we re-trigger if necessary. */
if ($('#full-page-container').width() != win.width()) {
	win.trigger('resize');
}
</script>
<?php $this->load->view('includes/frame_footer.php'); ?>
