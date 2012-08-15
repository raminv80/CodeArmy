<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<div class="po-wall-container">
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
            <?=$this->gamemech->get_level($po['exp']);?>
          </p>
        </div>
        <div class="po-avatar"><img src="/public/images/codeArmy/po/default-avatar.png" /></div>
      </div>
    </div>
  </div>
  <div class="documents-bottom-panel">
    <div class="docs-table-title">PHP Awesome Fix</div>
    <div class="docs-table-row">
      <div class="doc-number">1.</div>
      <div class="doc-name">Database fix.doc</div>
      <div class="doc-upload-by">Uploaded by Mr. Product Owner</div>
      <div class="doc-upload-time">Latest</div>
      <div class="doc-upload-date">27/10/12</div>
      <div class="doc-upload-dl-icons"><a href="#"><img src="/public/images/codeArmy/po/documents/download-icon.png" /></a></div>
    </div>
    <div class="docs-table-row">
      <div class="doc-number">2.</div>
      <div class="doc-name">Planning.xls</div>
      <div class="doc-upload-by">Uploaded by Mr. Product Owner</div>
      <div class="doc-upload-time">2 days ago</div>
      <div class="doc-upload-date">25/10/12</div>
      <div class="doc-upload-dl-icons"><a href="#"><img src="/public/images/codeArmy/po/documents/download-icon.png" /></a></div>
    </div>
    <div class="docs-table-row">
      <div class="doc-number">3.</div>
      <div class="doc-name"><a href="#">awesome PHP fix.gif</a></div>
      <div class="doc-upload-by">Uploaded by Mr. Product Owner</div>
      <div class="doc-upload-time">4 days ago</div>
      <div class="doc-upload-date">18/10/12</div>
      <div class="doc-upload-dl-icons"><a href="#"><img src="/public/images/codeArmy/po/documents/share-icon.png" /></a></div>
    </div>
    
    <div class="submit-doc-buttons">
    <input type="submit" value="Post a link" class="lnkimg" />
    <input type="submit" value="Upload a document" class="lnkimg" />
    </div>
    
  </div>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
