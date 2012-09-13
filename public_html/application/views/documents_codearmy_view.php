<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<div class="po-wall-container">
  <!-- mission submission-->
  <div id="mission-notification" class="container-fluid">
  </div>
  <!--mission submission-->
  <div class="top-panel">
    <div class="top-panel-left">
      <div class="top-panel-title">
        <?=ucwords($work['title'])?>
        <a href="#"><img src="/public/images/codeArmy/po/record-icon.png" /></a></div>
      <div class="proj-category">
        <?=ucfirst($work['category'].(($work['class'])?' > '.$work['class_name']:'').(($work['subclass'])?' > '.$work['subclass_name']:''))?>
      </div>
      <div class="tabs-row"> <a href="/missions/wall/<?=$work['work_id']?>" class="wall">Wall</a> <a class="task" href="/missions/task/<?=$work['work_id']?>">Task</a> <a class="document-active" href="/missions/documents/<?=$work['work_id']?>">Document</a> <a class="date" href="/missions/dates/<?=$work['work_id']?>">Date</a> </div>
      <div class="desc-row">
        <?=$work['description']?>
      </div>
    </div>
    <div class="top-panel-right">
      <?php
            //calc remaining time
            $remaining_time = strtotime($work['deadline'])-time();
            if($remaining_time<0)$remaining_time0;
            //calc elappsed time
            $elappsed_time = time()-strtotime($work['assigned_at']);
            //calc total time he had during assignment
            $given_time = strtotime($work['deadline']) - strtotime($work['assigned_at']);
            if($given_time<0) $given_time = 1;
            
            $progress_percent = ($given_time==0)?0:$elappsed_time/$given_time;
            $progress_percent = ($progress_percent>0)?(($progress_percent>1)?1:$progress_percent):0;
            $remaining_hour = floor($remaining_time / (60*60));
            $remaining_min = $remaining_time % (60*60);
            $remaining_minutes = floor($remaining_min / (60));
            $min_to_percent = ($given_time==0)?0:(1*60)/($given_time);
        ?>
      <div class="progress-text">Progress:
        <?= round(100*$progress_percent) ?>
        %</div>
      <div class="wall-progress">
        <div class="wall-progress-bar" style="width:<?= round(222*$progress_percent) ?>px"></div>
      </div>
      <div class="bg_progress_summary">
        <div class="start-hours">
          <div class="start">
            <p class="wall-box-title">Start</p>
            <p>
              <?=($work['started_at'])?date('j M Y',strtotime($work['started_at'])):''?>
            </p>
          </div>
          <div class="hours">
            <p class="wall-box-title">
              <?=ucfirst(str_replace('dai','day',substr($work['arrangement_type'],0,-2)))?>
              s</p>
            <p>
              <?=$work['bid_time']?>
            </p>
          </div>
        </div>
        <div class="end-budget">
          <div class="end">
            <p class="wall-box-title">End</p>
            <p>
              <?=date('j M Y',strtotime($work['deadline']))?>
            </p>
          </div>
          <p class="wall-box-title">Budget</p>
          <p>$
            <?=$work['bid_cost']?>
            /
            <?=str_replace('dai','day',substr($work['arrangement_type'],0,-2))?>
          </p>
          <div class="budget"></div>
        </div>
        <div class="po-info">
          <p class="wall-box-title">Mission Captain</p>
          <p class="po-name">
            <?=$po['username']?>
          </p>
          <p class="level">Level
            <?=$this->game_model->get_level($po['exp']);?>
          </p>
        </div>
        <div class="po-avatar"><img src="/public/images/codeArmy/po/default-avatar.png" /></div>
        <!-- mission submission-->
        <?php if(($work['work_horse']==$me['user_id'])&&(strtolower($work['status'])=='in progress' || strtolower($work['status'])=='redo')){?>
        <div class="button green" id="mission_complete" style="clear:both;"><img src="/public/images/codeArmy/loader4.gif" style="position:absolute;left:75px; bottom:5px; display:none;" id="mission-submit-loader" /> Complete Mission!</div>
        <?php }?>
        <!-- mission submission-->
      </div>
    </div>
  </div>
  <div class="documents-bottom-panel">    
    <?php
	$i = 1;
    foreach($docList as $files):
		if(isset($files['link_id'])) {
	?>
    <div class="docs-table-row">
      <div class="doc-number"><?=$i?>.</div>
      <div class="doc-name"><a href="<?=$files['link']?>" target="_blank"><img src="/public/images/codeArmy/po/documents/share-icon.png" align="absmiddle" style="vertical-align:middle !important" border="0" /> <?=(strlen($files['link']) > 45) ? substr($files['link'],0,40).'...' : $files['link']?></a></div>
      <div class="doc-upload-by">Uploaded by <?=$files['username']?></div>
      <div class="doc-upload-time"><!--4 days ago-->&nbsp;</div>
      <div class="doc-upload-date"><?=date('j/m/Y',strtotime($files['upload_at']))?></div>
      <div class="doc-upload-dl-icons" id="<?=$files['link_id']?>"><a href="javascript:;"><img src="/public/images/codeArmy/messages/bin.png" border="0" id="delUploadLink" /></a></div>
    </div>
    <?php
		} else {
	?>
    <div class="docs-table-row">
      <div class="doc-number"><?=$i?>.</div>
      <div class="doc-name"><a href="/public/uploads/<?=$files['file_name']?>" target="_blank"><img src="/public/images/codeArmy/po/documents/download-icon.png" align="absmiddle" style="vertical-align:middle !important" border="0" /> <?=$files['file_name']?></a></div>
      <div class="doc-upload-by">Uploaded by <?=$files['username']?></div>
      <div class="doc-upload-time"><?=byte_format($files['file_size'])?></div>
      <div class="doc-upload-date"><?=date('j/m/Y',strtotime($files['created_at']))?></div>
      <div class="doc-upload-dl-icons" id="<?=$files['file_id']?>"><a href="javascript:;"><img src="/public/images/codeArmy/messages/bin.png" border="0" id="delUploadFile" /></a></div>
    </div>
    <?php
		}
		$i++;
	endforeach;
	?>
        
    <div class="submit-doc-buttons" id="plupload-container">
    <div id="filelist"></div>
    <?php if(!in_array(strtolower($work['status']),array('done','verify','signoff'))){?>
    <input type="button" id="postlink" value="Post a link" class="lnkimg" />
    <input type="button" id="pickfiles" class="lnkimg" value="Select a files">
    <input type="button" id="uploadfiles" value="Upload a document" class="lnkimg" />
    <?php }?>
    </div>
    
    <div id="<?=$work['work_id']?>" style="display:none"><input class="add-subtask" name="doc-url" id="doc-url" type="text" placeholder="Paste your url here" /> <input type="button" id="savelink" value="Save" class="lnkimg" /></div>

  </div>
</div>
<?php if(!in_array(strtolower($work['status']),array('done','verify','signoff'))){?>
<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.gears.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.silverlight.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.flash.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.browserplus.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.html4.js"></script>
<script type="text/javascript" src="/public/js/plupload/plupload.html5.js"></script>

<script>
	var uploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight,browserplus',
		browse_button : 'pickfiles',
		container: 'plupload-container',
		max_file_size : '10mb',
		url : '/missions/doc_uploadfiles',
		//multipart_params : {'csrf_workpad': getCookie('csrf_workpad')},
		resize : {width : 320, height : 240, quality : 90},
		flash_swf_url : '/public/js/plupload/plupload.flash.swf',
		silverlight_xap_url : '/public/js/plupload/plupload.silverlight.xap',
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		]
	});
	
	uploader.bind('Init', function(up, params) {
		$('#filelist').html("<div style='display:none'>Current runtime: " + params.runtime + "</div>");
	});
	
	uploader.bind('FilesAdded', function(up, files) {
		//for (var i in files) {
		$.each(files, function(i, file) {
			$('#filelist').append('<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b> <a href="javascript:void(0);" class="removeQueue">Remove</a></div>');
			
			$('#' + file.id + ' a.removeQueue').first().click(function(e) {
				e.preventDefault();
				up.removeFile(file);
				$('#' + file.id).remove();
			});
		});
	});
	
	uploader.bind('BeforeUpload', function (up, file) {
		//console.log(file.size);
		var work_id = <?=$work['work_id']?>;
		up.settings.multipart_params = {'filesize': file.size,'csrf_workpad': getCookie('csrf_workpad'),'work_id':work_id}
	});
	
	uploader.bind('FileUploaded', function(uploder, file, response) {
		//res = $.parseJSON(response.response);
		//update id to actual id
		//$('#'+file.id).attr('id',res.id);
		location.reload();
	});
	
	uploader.bind('UploadProgress', function(up, file) {
		$('.removeQueue').hide();
		$('#'+file.id+' b').html("<span>" + file.percent + "%</span>");
	});
	
	$('#delUploadFile').live("click",function() {
		var file_id = $(this).closest("div").attr('id');
		var work_id = <?=$work['work_id']?>;
		$.ajax({
			type: 'post',
			url: '/missions/delete_doc_file',
			data: {'csrf_workpad': getCookie('csrf_workpad'), 'file_id':file_id, 'work_id': work_id},
			success: function(msg){
					if(msg="success"){
						//$('#'+file_id).remove();
						location.reload();
					}else{
						//console.log(msg)
					}
				}
		});
		return false;
	});

	$('#delUploadLink').live("click",function() {
		var link_id = $(this).closest("div").attr('id');
		var work_id = <?=$work['work_id']?>;
		$.ajax({
			type: 'post',
			url: '/missions/delete_doc_link',
			data: {'csrf_workpad': getCookie('csrf_workpad'), 'link_id':link_id, 'work_id': work_id},
			success: function(msg){
					if(msg="success"){
						//$('#'+file_id).remove();
						location.reload();
					}else{
						//console.log(msg)
					}
				}
		});
		return false;
	});
	
	$('#uploadfiles').click(function() {
		uploader.start();
		return false;
		//e.preventDefault();
	});
	
	uploader.init();
	// end of plupload
	
	$('#postlink').click(function(){
		$('#<?=$work['work_id']?>').show();
	});
	
	$('#savelink').click(function(){
		var url = $('#doc-url').val();
		var work_id = <?=$work['work_id']?>;
		$.ajax({
			type: 'post',
			url: '/missions/Ajax_save_link',
			data: {'csrf_workpad': getCookie('csrf_workpad'), 'work_id': work_id, 'link': url},
			success: function(msg){
					if(msg="success"){
						//$('#'+file_id).remove();
						location.reload();
					}else{
						//console.log(msg)
					}
				}
		});
		$('#<?=$work['work_id']?>').hide();
	});
</script>
<?php }?>
<script>
	$(function(){
		//Mission submission 
	var _lock=false;
	var mission_channel = pusher.subscribe('mission');
	
	<?php if($work['owner']==$me['user_id']){//push events for PO?>
	mission_channel.bind('done-mission-<?=$work['work_id']?>',function(data){
		if(data.work_id=='<?=$work['work_id']?>'){
			$('#mission-notification').html('<div class="row-fluid"><div class="span8"><span style="margin:0 5px" class="icon-comment"></span><?=ucfirst($contractor['username'])?> has marked this mission complete!</div><div class="span4"><button id="redo-mission" type="button" class="btn btn-danger">Don\'t accept</button><button id="verify-mission" type="button" class="btn btn-success">Accept</button></div></div>').removeClass('blue green red yellow orange').addClass('orange').slideDown();
		}
	});
	<?php }elseif($work['work_horse']==$me['user_id']){//push events for contractor?>
	mission_channel.bind('redo-mission-<?=$work['work_id']?>',function(data){
		if(data.work_id=='<?=$work['work_id']?>'){
			$('#mission-notification').html('<span style="margin:0 5px" class="icon-icon-exclamation-sign"></span>Captain asked you to revise your work. Please discuss the requirements on mission wall<a href="javascript:$(\'#mission-notification\').slideUp()" style="float:right" class="icon-eye-close"></a>').removeClass('blue green orange yellow red').addClass('red').slideDown();
			$('#mission_complete').hide().delay(1).slideDown();
			$('#mission-submit-loader').hide();
		}
	});
	mission_channel.bind('verify-mission-<?=$work['work_id']?>',function(data){
		if(data.work_id=='<?=$work['work_id']?>'){
			$('#mission-notification').html('<span style="margin:0 5px" class="icon-ok"></span>Mission accomplished. Nice work and Congradulations!<a href="javascript:$(\'#mission-notification\').slideUp()" style="float:right" class="icon-eye-close"></a>').removeClass('blue red orange yellow green').addClass('green').slideDown();
		}
	});
	<?php }?>
	
	$('#mission_complete').click(function(){
		if(_lock)return false;
		_lock = true;
		$('#mission-submit-loader').show();
		$.ajax({
			url:'/missions/Ajax_submit',
			data: {'csrf_workpad': getCookie('csrf_workpad'), 'work_id': '<?=$work['work_id']?>'},
			type: 'post',
			success: function(msg){
				if(msg=='success'){
					$('#mission_complete').slideUp();
					$('#mission-notification').html('<span style="margin:0 5px" class="icon-ok"></span>Mission is marked as completed and sent to captain for verification...<a href="javascript:$(\'#mission-notification\').slideUp()" style="float:right" class="icon-remove"></a>').addClass('blue').slideDown();
				}else if (typeof console == "object") console.log(msg);
				_lock=false;
			}
		});
		
	});
	<?php if($work['work_horse']==$me['user_id']){//Show to contractor?>
	switch('<?=strtolower($work['status'])?>'){
		case 'done': $('#mission-notification').html('<span class="icon-comment" style="margin:0 5px"></span>Pending for verification by captain...<a href="javascript:$(\'#mission-notification\').slideUp()" style="float:right" class="icon-eye-close"></a>').addClass('orange').slideDown();
		break;
	}
	<?php }elseif($work['owner']==$me['user_id']){//Show to po?>
	switch('<?=strtolower($work['status'])?>'){
		case 'done': $('#mission-notification').html('<div class="row-fluid"><div class="span8"><span style="margin:0 5px" class="icon-comment"></span><?=ucfirst($contractor['username'])?> has marked this mission complete!</div><div class="span4"><button id="redo-mission" type="button" class="btn btn-danger">Don\'t accept</button><button id="verify-mission" type="button" class="btn btn-success">Accept</button></div></div>').addClass('orange').slideDown();
		break;
	}
	
	$('#verify-mission').live('click',function(){
		if(_lock)return false;
		_lock=true;
		$('#redo-mission').hide();
		$(this).html('Accept<img src="/public/images/codeArmy/loader4.gif" id="Ajax-Loader" />');
		
		$.ajax({
			'url':'/missions/Ajax_verify_mission',
			'data':{'csrf_workpad': getCookie('csrf_workpad'), 'work_id':'<?=$work['work_id']?>'},
			'type':'post',
			success:function(msg){
					if(msg=='success'){
						$('#mission-notification').html('<span style="margin:0 5px" class="icon-ok"></span>Mission is successfuly completed and verified.<a href="javascript:$(\'#mission-notification\').slideUp()" style="float:right" class="icon-eye-close"></a>').removeClass('orange').addClass('green');
					}else if (typeof console == "object") console.log(msg);
					_lock=false;
				}
		});
	});
	
	$('#redo-mission').live('click',function(){
		if(_lock)return false;
		_lock=true;
		$('#verify-mission').hide();
		$(this).html('Don\'t accept<img src="/public/images/codeArmy/loader4.gif" id="Ajax-Loader" />');
		
		$.ajax({
			'url':'/missions/Ajax_redo_mission',
			'data':{'csrf_workpad': getCookie('csrf_workpad'), 'work_id':'<?=$work['work_id']?>'},
			'type':'post',
			success:function(msg){
				if(msg=='success'){
						$('#mission-notification').html('<span style="margin:0 5px" class="icon-comment"></span>Mission is sent back to contractor for revision.<a href="javascript:$(\'#mission-notification\').slideUp()" style="float:right" class="icon-eye-close"></a>').removeClass('orange').addClass('red');
					}else if (typeof console == "object") console.log(msg);
				_lock=false;
			}
		});
	});
	<?php }?>
	//end of mission submission
	});
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
