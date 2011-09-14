<?php $this->load->view('includes/header_view'); ?>

<!-- add new project form container start -->

<div id="story-wrapper">
  <div id="content"></div>
  <?php if(isset($success)): ?>
  <div class="story_created">
    <h2>Done!</h2>
    <p>The project is created.</p>
    <a href="/projects/view/<?php echo $project_id; ?>">view details</a></div>
  <?php else: ?>
  <h2>Create New Project</h2>
  <?php if(validation_errors()) { ?>
  <!-- form error container start -->
  <div class="val-error"> <?php echo validation_errors(); ?> </div>
  <!-- form error container ends -->
  <?php } ?>
  <?php echo form_open("/projects/create"); ?>
  <div class="new-story_field">
    <label for="title">Project Title</label>
    <input type="text" name="title" value="<?php echo $this->input->post('title'); ?>" placeholder="title" id="title" />
    <p></p>
  </div>
  <div class="new-story_field">
    <label for="description">Description</label>
    <textarea name="description" rows="8" cols="40" class="ckeditor"><?php echo $this->input->post('description'); ?></textarea>
  </div>
  <div class="new-story_field">
    <label for="submit">&nbsp;</label>
    <input type="submit" name="submit" value="Create project" id="submit" />
    <p></p>
  </div>
  <?php echo form_close(); ?>
  <?php endif; ?>
</div>
<!-- / add new project form container ends -->

<?php $this->load->view('includes/footer_view'); ?>
