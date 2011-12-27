<?php $this->load->view('includes/header_view'); ?>

	<!-- add new stories form container start -->
	<div id="story-wrapper">
		<div id="content"></div>
		
		<?php if(isset($success)): ?>
		
		<div class="story_created"><h2>Done!</h2><p>Stories Edited</p> <a href="/story/<?php echo $work_id; ?>">View details</a></div>
		
		<?php else: ?>
				
		<h2>Edit Story</h2>
		
		<?php if(validation_errors()) { ?>
		<!-- form error container start -->
		<div class="val-error">
			<?php echo validation_errors(); ?>
		</div>
		<!-- form error container ends -->
		<?php } ?>
		
		<?php echo form_open("/story/edit/".$story_id); ?>
		<div class="new-story_field">
		<label for="Project">Project</label>
			<?php echo $story_data['project_name']; ?>
		</div>
		
		
		<div class="new-story_field">
			<label for="title">Title</label>
            <span class="hint">keep it short, informative and unique</span>
			<input type="text" maxlength="35" name="title" value="<?php echo $story_data['title']; ?>" placeholder="title" id="title" />
			<p></p>
		</div>

		<div class="new-story_field">
			<label for="type">Type</label>
			<select name="type">
			<option value="R&D" <?php if($story_data['type'] == "R&D") { echo "selected"; }?>>R&amp;D</option>
			<option value="Frontend" <?php if($story_data['type'] == "Frontend") { echo "selected"; }?>>Frontend</option>
			<option value="Backend" <?php if($story_data['type'] == "Backend") { echo "selected"; }?>>Backend</option>
			<option value="Copywrite" <?php if($story_data['type'] == "Copywrite") { echo "selected"; }?>>Copywrite</option>
            <option value="Test" <?php if($story_data['type'] == "Test") { echo "selected"; }?>>Test</option>
			</select>
		</div>
        
        <div class="new-story_field">
			<label for="type">Category</label>
			<select name="category">
			<option value="0" <?php if($story_data['category'] == NULL) { echo "selected"; }?>>General</option>
            <?php foreach($categories as $category):?>
			<option value="<?php echo $category['id'];?>" <?php if($story_data['category'] == $category['id']) { echo "selected"; }?>><?php echo $category['name'];?></option>
			<?php endforeach;?>
			</select>
            <input value="" id="new-category" type="text" name="new_category" />
        </div>
		
		<div class="new-story_field">
			<label for="description">Description</label>
            <span class="hint">A description should follow thi format: As a [user] i want to [do some action] so that i can [get to some goals]</span>
            <?php echo $this->ckeditor->editor("description", $story_data['description']);?>
		</div>
        
        <div class="new-story_field">
			<label for="note">Note</label>
            <span class="hint">define required tasks, acceptance criteria and any details that can help. Remember: More input you give the better output you will recieve.</span>
            <?php echo $this->ckeditor->editor("note", $story_data['note']);?>
		</div>
        
       	<div class="new-story_field">
			<label for="tutorial">Tutorial</label>
            <?php echo $this->ckeditor->editor("tutorial", $story_data['tutorial']);?>
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
                       	  <div class="skill-option"><label class="option-inline"><input type="radio" name="skill_id_<?php echo $skill['id'];?>" <?php if($skill['point']==0){?>checked="checked"<?php }?> value="0">Not Required</label></div>
                          <div class="skill-option"><label><input type="radio" name="skill_id_<?php echo $skill['id'];?>" <?php if($skill['point']==1){?>checked="checked"<?php }?> value="1">Begginer</label></div>
                          <div class="skill-option"><label><input type="radio" name="skill_id_<?php echo $skill['id'];?>" <?php if($skill['point']==2){?>checked="checked"<?php }?> value="2">Intermediate</label></div>
                          <div class="skill-option"><label><input type="radio" name="skill_id_<?php echo $skill['id'];?>" <?php if($skill['point']==3){?>checked="checked"<?php }?> value="3">Professional</label></div>
                          <div class="skill-option"><label><input type="radio" name="skill_id_<?php echo $skill['id'];?>" <?php if($skill['point']==4){?>checked="checked"<?php }?> value="4">Expert</label></div>
						</td>
                    <tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
		
        <div class="new-story_field">
        	<label>Bid Deadline</label>
            <span class="hint">The date that you expect to find a workhorse and get the work started by.</span><br />
        	<?=$formdate_biddead->selectDay()?>    
			<?=$formdate_biddead->selectMonth()?>    
			<?=$formdate_biddead->selectYear()?>
        </div>
        
        <div class="new-story_field">
        	<label>Deadline</label>
            <span class="hint">The date that delivery is expected</span><br />
        	<?=$formdate_deadline->selectDay()?>    
			<?=$formdate_deadline->selectMonth()?>    
			<?=$formdate_deadline->selectYear()?>
        </div>        
        
		<div class="new-story_field">
			<label for="points">Complexity Points</label>
			<select name="points">
			<option value="1" <?php if($story_data['points'] == 1) { echo "selected"; }?>>1 point</option>
			<option value="2" <?php if($story_data['points'] == 2) { echo "selected"; }?>>2 points</option>
			<option value="3" <?php if($story_data['points'] == 3) { echo "selected"; }?>>3 points</option>
			<option value="5" <?php if($story_data['points'] == 5) { echo "selected"; }?>>5 points</option>
			<option value="8" <?php if($story_data['points'] == 8) { echo "selected"; }?>>8 points</option>
			<option value="13" <?php if($story_data['points'] == 13) { echo "selected"; }?>>13 points</option>
			<option value="20" <?php if($story_data['points'] == 20) { echo "selected"; }?>>20 points</option>
			<option value="40" <?php if($story_data['points'] == 40) { echo "selected"; }?>>40 points</option>
			</select>
		</div>
		
		<div class="new-story_field">
			<label for="cost">Cost</label>
			RM <input type="text" name="cost" value="<?php echo $story_data['cost']; ?>" placeholder="450" id="points" />
		</div>
		
		<div class="new-story_field">
			<label for="submit">&nbsp;</label>
            <input type="hidden" name="project_id" value="<?php echo $story_data['project_id'];?>" />
            <input type="hidden" name="status" value="<?=$story_data['status']?>" />
			<input type="submit" name="submit" value="Edit Story" id="submit" />
			<p></p>
		</div>
		
		<?php echo form_close(); ?>
		
		<?php endif; ?>
		
		</div>
        <div id="ajaxupload">
        </div>
	</div>
	<!-- / add new stories form container ends -->
		
<?php $this->load->view('includes/footer_view'); ?>