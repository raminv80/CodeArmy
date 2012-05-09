<?php $this->load->view('includes/header4'); ?>
<div id="story-wrapper" style="margin:70px auto 200px; width:1000px; padding-bottom:200px;">
  <div id="content"></div>
  <?php if(isset($success)): ?>
  <div class="story_created">
    <h2>Done!</h2>
    <p>Project Edited</p>
    <a href="/projects/view/<?php echo $project_id; ?>">View details</a></div>
  <?php else: ?>
  <h2>Edit Project</h2>
  <?php if(validation_errors()) { ?>
  <!-- form error container start -->
  <div class="val-error"> <?php echo validation_errors(); ?> </div>
  <!-- form error container ends -->
  <?php } ?>
  <?php echo form_open("/admin/edit_project/".$project_id); ?>
  <div class="new-story_field">
    <label for="title">Title</label>
    <input type="text" name="title" value="<?php echo $project_data['project_name']; ?>" placeholder="title" />
    <p></p>
  </div>
  <div class="new-story_field">
    <label for="description">Description</label>
    <?php echo $this->ckeditor->editor("description", $project_data['project_desc']);?> </div>
  <div class="new-story_field"> Product Owner:
    <select name="project_owner" onchange="set_others()">
      <?php foreach($users as $user):?>
      <option value="<?=$user['user_id']?>">
      <?=$user['username']?>
      </option>
      <?php endforeach;?>
    </select>
    <br />
    Scrum Master:
    <select name="scrum_master">
      <?php foreach($users as $user):?>
      <option value="<?=$user['user_id']?>">
      <?=$user['username']?>
      </option>
      <?php endforeach;?>
    </select>
    <br />
    Deployer:
    <select name="deployer">
      <?php foreach($users as $user):?>
      <option value="<?=$user['user_id']?>">
      <?=$user['username']?>
      </option>
      <?php endforeach;?>
    </select>
    <script type="text/javascript">function set_others(){var t=$('select[name="project_owner"]').val(); $('select[name="scrum_master"]').val(t); $('select[name="deployer"]').val(t)}</script> 
  </div>
  <input type="submit" name="submit" value="submit" />
  <?php echo form_close(); ?>
  <?php endif; ?>
</div>
</div>
<!-- / add new project form container ends -->

<?php $this->load->view('includes/footer5'); ?>
