<?php $this->load->view('includes/header_view'); ?>

	<!-- add new stories form container start -->
	<div id="story-wrapper">
		<div id="content"></div>
		
		<?php if(isset($success)): ?>
		
		<div class="story_created"><h2>Done!</h2><p>Project Edited</p> <a href="/projects/view/<?php echo $project_id; ?>">View details</a></div>
		
		<?php else: ?>
				
		<h2>Edit Project</h2>
		
		<?php if(validation_errors()) { ?>
		<!-- form error container start -->
		<div class="val-error">
			<?php echo validation_errors(); ?>
		</div>
		<!-- form error container ends -->
		<?php } ?>
		
		<?php echo form_open("/projects/edit/".$project_id); ?>
		
		<div class="new-story_field">
			<label for="title">Title</label>
			<input type="text" name="title" value="<?php echo $project_data['project_name']; ?>" placeholder="title" id="title" />
			<p></p>
		</div>
		
		<div class="new-story_field">
			<label for="description">Description</label>
			<textarea name="description" rows="8" cols="40" class="ckeditor"><?php echo $project_data['project_desc']; ?></textarea>
            <input type="submit" name="submit" value="submit" />
		</div>
		
		<?php echo form_close(); ?>
		
		<?php endif; ?>
		
		</div>
	</div>
	<!-- / add new stories form container ends -->
		
<?php $this->load->view('includes/footer_view'); ?>