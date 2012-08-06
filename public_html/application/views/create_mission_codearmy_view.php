<?php echo form_open('#' , array('id'=>'form-create-mission')); ?>
<div class="create-mission-container">
  <div class="create-mission-title">Create Mission</div>
  <div class="create-mission-info">
    <div class="mission-title">
      <label>Mission Title</label>
      <input type="text" id="mission-title" name="mission-title" class="required" value="" />
    </div>
    <div class="mission-video-url">
      <label>Mission Video</label>
      <input type="text" id="mission-video" name="mission-video" value="" />
    </div>
  </div>
  <div class="mission-desc-video">
    <div class="mission-description">
      <div><span class="desc-title-text">Description</span><span class="examples-link"><a href="#">Examples</a></span></div>
      <textarea rows="7" id="mission-desc-text" name="mission-desc-text" class="required"></textarea>
      <!--<div class="attach-file-tools"> <a href="#"><img src="/public/images/codeArmy/mission/fileicon.png" class="fileicon" /></a> <span class="filename"><a href="#">Project-brief.ppt</a></span> <span class="filesize">(250kb)</span> <span class="filedesc">Acme online store brief...</span> <a href="#"><img src="/public/images/codeArmy/mission/binicon.png" class="binicon" /></a> </div>-->
      <div id="plupload-container" style="clear:both">
      <div id="filelist">No runtime found.</div>
      <input type="button" id="pickfiles" class="lnkimg" value="Select files">
      <input type="button" id="uploadfiles" class="lnkimg" value="Upload files">
      </div>
    </div>
    <div class="mission-video-preview">
      <!--<iframe class="youtube-player" type="text/html" width="330" height="216" src="http://www.youtube.com/embed/zFNb8j3YAd4?wmode=opaque" frameborder="0"></iframe>-->
    </div>
  </div>
  <div class="mission-type-n-skills">
    <div class="mission-type"> <span class="mission-type-title">Mission Type</span>
      <select id="mission-type-main" name="mission-type-main" class="mission-type-main required" validate="required:true">
        <option value="">--- Please select ---</option>
      <?php foreach($main_category as $value): ?>
        <option value="<?=$value['category_id']?>" <?php if($value['category_id']==$cat_selected){?>selected="selected"<?php }?>><?=$value['category']?></option>
      <?php endforeach; ?>
      </select>
      <select id="mission-type-class" name="mission-type-class" class="mission-type-sub required" validate="required:true">
        <option value="">--- Please select ---</option>
      <?php foreach($class as $value): ?>
        <option value="<?=$value['class_id']?>"><?=$value['class_name']?></option>
      <?php endforeach; ?>
      </select>
      <select id="mission-type-sub" name="mission-type-sub" class="mission-type-sub required" validate="required:true">
        <option value="">--- Please select ---</option>
      <?php foreach($sub_class as $value): ?>
        <option value="<?=$value['subclass_id']?>"><?=$value['subclass_name']?></option>
      <?php endforeach; ?>
      </select>
    </div>
    <div class="skills-required"> <span class="skills-required-title">Skills Required</span>
      <textarea rows="7" id="skills-required-text" name="skills-required-text"></textarea>
    </div>
  </div>
  <div class="mission-arrange-budget">
    <div class="mission-arrangements"> <span class="mission-arrange-title">Mission's Arrangements</span>
      <div class="arrange-row">
        <select id="mission-arrange-hour" name="mission-arrange-hour" class="mission-arrange-hour required" validate="required:true">
          <option value=""></option>
          <option value="hourly">Hourly</option>
        </select>
        <span class="center-dash">-</span>
        <select id="mission-arrange-month" name="mission-arrange-month" class="mission-arrange-month required" validate="required:true">
          <option value=""></option>
          <option value="1-3">1-3 months</option>
        </select>
      </div>
    </div>
    <div class="mission-budget"> <span class="mission-budget-title">Budget</span>
      <div class="arrange-row">
        <select id="mission-budget" name="mission-budget" class="mission-budget required" validate="required:true">
          <option value=""></option>
          <option value="30-40/hour">30$ - 40$ / hour</option>
        </select>
      </div>
    </div>
  </div>
  
  <div class="mission-submit-row">
    <div class="assign-po"> 
    <input class="assinpo" id="assignpo" type="checkbox" value="yes" /> <label>Assign this mission to a Project Manager? </label>
   </div>

<div class="submit-cancel-row">

<input type="submit" class="lnkimg" id="post-mission" value="Post Mission">
<input type="reset" class="lnkimg" id="cancel-mission" value="Cancel">
</div>
   
   </div>
  
</div>
</form>