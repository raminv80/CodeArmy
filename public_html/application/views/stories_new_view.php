<?php $this->load->view('includes/header_view'); ?>
	<!-- add new stories form container start -->
	<div id="story-wrapper">
		<div id="content"></div>
		
		<?php if(isset($success)): ?>
		
		<div class="story_created"><h2>Done!</h2><p>New user stories created.</p> <a href="/story/<?php echo $work_id; ?>">view details</a></div>
		
		<?php else: ?>
				
		<h2>Create New User Story</h2>
		
		<?php if(validation_errors()) { ?>
		<!-- form error container start -->
		<div class="val-error">
			<?php echo validation_errors(); ?>
		</div>
		<!-- form error container ends -->
		<?php } ?>
		
		<?php echo form_open("/stories/create"); ?>
		<div class="new-story_field">
		<label for="Project">Project</label>
			<?php if($project) { 
					echo $project[0]['project_name'];
					echo "<input type='hidden' name='project' value='".$project[0]['project_id']."' />";
			} ?>
			<?php if($projects) { ?>
			<select name="project">
			<?php foreach($projects as $project) { ?>
					<option <?php if($this->input->post('project')==$project['project_id']){?>selected="selected"<?php }?> 
                    value = "<?php echo $project['project_id']; ?>"><?php echo $project['project_name']; ?></option>				
		<?php } } ?>
			</select>
		</div>
		
		
		<div class="new-story_field">
			<label for="title">Title</label>
			<input type="text" name="title" value="<?php echo $this->input->post('title'); ?>" placeholder="title" id="title" />
			<p></p>
		</div>

		<div class="new-story_field">
			<label for="type">Type</label>
			<select name="type">
			<option <?php if($this->input->post('type')=='Feature'){?>selected="selected"<?php }?> value="Feature">Feature</option>
			<option <?php if($this->input->post('type')=='Chore'){?>selected="selected"<?php }?> value="Chore">Chore</option>
			<option <?php if($this->input->post('type')=='Bug'){?>selected="selected"<?php }?> value="Bug">Bug</option>
			<option <?php if($this->input->post('type')=='Milestone'){?>selected="selected"<?php }?> value="Milestone">Milestone</option>
			</select>
		</div>
        
        <div class="new-story_field">
			<label for="type">Category</label>
			<select name="category">
            <option value="0">Select existing or enter a new category...</option>
			<option value="0">General</option>
            <?php if(!$with_ajax){?>
     	       <?php foreach($categories as $category):?>
				<option value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
				<?php endforeach;?>
            <?php }?>
			</select>
            
            <input value="" id="new-category" type="text" name="new_category" />
        </div>        
		
		<div class="new-story_field">
			<label for="description">Description</label>
			<textarea name="description" rows="8" cols="40" class="ckeditor"><?php echo $this->input->post('description'); ?></textarea>
		</div>
        
        <div class="new-story_field">
			<label for="tutorial">Tutorial</label>
			<textarea name="tutorial" rows="8" cols="40" class="ckeditor"><?php echo $this->input->post('tutorial'); ?></textarea>
		</div>
		
      <div class="new-story_field">
        	<label for="skills">Required Skills</label>
            <table id="skill-table">
            	<thead>
                	<th>Skill</th>
                    <th>Required Level</th>
                </thead>
                <tbody>
                	<?php foreach($skills as $skill):?>
                	<tr>
                		<td><?php echo $skill['name'];?></td>
                   	  <td>
                       	  <div class="skill-option"><label class="option-inline"><input type="radio" name="skill_id_<?php echo $skill['id'];?>" <?php if(!($this->input->post('skill_id_'.$skill['id'])>1)){?>checked="checked"<?php }?> value="0">Not Required</label></div>
                          <div class="skill-option"><label><input type="radio" name="skill_id_<?php echo $skill['id'];?>" <?php if($this->input->post('skill_id_'.$skill['id'])==1){?>checked="checked"<?php }?> value="1">Begginer</label></div>
                          <div class="skill-option"><label><input type="radio" name="skill_id_<?php echo $skill['id'];?>" <?php if($this->input->post('skill_id_'.$skill['id'])==2){?>checked="checked"<?php }?> value="2">Intermediate</label></div>
                          <div class="skill-option"><label><input type="radio" name="skill_id_<?php echo $skill['id'];?>" <?php if($this->input->post('skill_id_'.$skill['id'])==3){?>checked="checked"<?php }?> value="3">Professional</label></div>
                          <div class="skill-option"><label><input type="radio" name="skill_id_<?php echo $skill['id'];?>" <?php if($this->input->post('skill_id_'.$skill['id'])==4){?>checked="checked"<?php }?> value="4">Expert</label></div>
						</td>
                    <tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        
        <div class="new-story_field">
        	<label>Bid Deadline</label>
        	<?=$formdate_biddead->selectDay()?>    
			<?=$formdate_biddead->selectMonth()?>    
			<?=$formdate_biddead->selectYear()?>
        </div>
        
        <div class="new-story_field">
        	<label>Deadline</label>
        	<?=$formdate_deadline->selectDay()?>    
			<?=$formdate_deadline->selectMonth()?>    
			<?=$formdate_deadline->selectYear()?>
        </div>
        
		<div class="new-story_field">
			<label for="points">Complexity Points</label>
			<select name="points">
			<option <?php if($this->input->post('points')==1){?>selected="selected"<?php }?> value="1">1 point</option>
			<option <?php if($this->input->post('points')==2){?>selected="selected"<?php }?> value="2">2 points</option>
			<option <?php if($this->input->post('points')==3){?>selected="selected"<?php }?> value="3">3 points</option>
			<option <?php if($this->input->post('points')==5){?>selected="selected"<?php }?> value="5">5 points</option>
			<option <?php if($this->input->post('points')==8){?>selected="selected"<?php }?> value="8">8 points</option>
			<option <?php if($this->input->post('points')==13){?>selected="selected"<?php }?> value="13">13 points</option>
			<option <?php if($this->input->post('points')==20){?>selected="selected"<?php }?> value="20">20 points</option>
			<option <?php if($this->input->post('points')==40){?>selected="selected"<?php }?> value="40">40 points</option>
			</select>
		</div>
		
		<div class="new-story_field">
			<label for="cost">Cost</label>
			RM <input type="text" name="cost" value="<?php echo $this->input->post('cost'); ?>" placeholder="450" id="points" />
		</div>
		
		<div class="new-story_field">
			<label for="submit">&nbsp;</label>
			<input type="submit" name="submit" value="Create Story" id="submit" />
			<p></p>
		</div>
		
		<?php echo form_close(); ?>
		
		<?php endif; ?>
		
		</div>
	</div>
	<!-- / add new stories form container ends -->
    <?php if($with_ajax){?>
		<script type="text/javascript" src="<?php echo base_url() ?>public/scripts/ajax_script.php"></script>		
    <?php }?>
<?php $this->load->view('includes/footer_view'); ?>