<?php $this->load->view('includes/header4'); ?>
<style>
#qualif-table label, .new-story_field  {padding: 5px 0 5px 0;color:#fff;}
#project-heading {
border-top-left-radius: 10px;
border-top-right-radius: 10px;
background: #000; opacity:.7;
color: white;
width: 980px;
height: 42px;
padding: 10px 0 0 20px;
font-size: 23px;
text-shadow: 0 1px 10px white;
}
#field {float:left; width:240px;}
#cke_description {margin-top:10px;}

#submit {width: 140px;
height: 29px;
margin: -13px 0 0 0;
float: left;
text-transform: uppercase;
border: 3px solid white;
color: white;
border: 3px solid #F6F6F6;
cursor: pointer;
-webkit-border-radius: 60px;
-moz-border-radius: 60px;
border-radius: 60px;
text-shadow: 0 0 1px white;
background: #5DAC0E;
background: -moz-linear-gradient(top, rgba(93, 172, 14, 1) 0%, rgba(76, 107, 18, 1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(93, 172, 14, 1)), color-stop(100%,rgba(76, 107, 18, 1)));
background: -webkit-linear-gradient(top, rgba(93, 172, 14, 1) 0%,rgba(76, 107, 18, 1) 100%);
background: -o-linear-gradient(top, rgba(93, 172, 14, 1) 0%,rgba(76, 107, 18, 1) 100%);
background: -ms-linear-gradient(top, rgba(93, 172, 14, 1) 0%,rgba(76, 107, 18, 1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#5dac0e', endColorstr='#4c6b12',GradientType=0 );
background: linear-gradient(top, rgba(93, 172, 14, 1) 0%,rgba(76, 107, 18, 1) 100%);
border-image: initial;}
</style>
<div id="story-wrapper" style="margin:70px auto 200px; width:1000px;">
  <div class="WP-main" style="margin-top:150px;"></div>
  <?php if(isset($success)): ?>
  <div class="story_created">
    <h2>Done!</h2>
    <p>The project is created.</p>
    <a href="/projects/view/<?php echo $project_id; ?>">view details</a></div>
  <?php else: ?>
  <div id="project-heading">Create New Project</div><div id="qualif-table">
  <?php if(validation_errors()) { ?>
  <!-- form error container start -->
  <div class="val-error"> <?php echo validation_errors(); ?> </div>
  <!-- form error container ends -->
  <?php } ?>
  <?php echo form_open("/admin/new_project"); ?>
  <div class="new-story_field">
    <label for="title">Project Title</label>
    <input type="text" name="title" value="<?php echo $this->input->post('title'); ?>" placeholder="title"/>
    <p></p>
  </div>
  <div class="new-story_field">
    <label for="description">Description</label>
    <!--<textarea name="description" rows="8" cols="40" class="ckeditor"><?php //echo $this->input->post('description'); ?></textarea>-->
    <?php echo $this->ckeditor->editor("description", $this->input->post('description'));?>
  </div>
  <div class="new-story_field">
    <div id="field">Product Owner: <select name="project_owner" onchange="set_others()">
    	<?php foreach($users as $user):?>
    	<option value="<?=$user['user_id']?>"><?=$user['username']?></option>
        <?php endforeach;?>
    </select><br /></div>
   <div id="field"> Scrum Master: <select name="scrum_master">
    	<?php foreach($users as $user):?>
    	<option value="<?=$user['user_id']?>"><?=$user['username']?></option>
        <?php endforeach;?>
    </select><br /></div>
    <div id="field">Deployer: <select name="deployer">
    	<?php foreach($users as $user):?>
    	<option value="<?=$user['user_id']?>"><?=$user['username']?></option>
        <?php endforeach;?>
    </select>
    <script type="text/javascript">function set_others(){var t=$('select[name="project_owner"]').val(); $('select[name="scrum_master"]').val(t); $('select[name="deployer"]').val(t)}</script></div>
  </div>
  <div class="new-story_field">
    <label for="submit">&nbsp;</label>
    <input type="submit" name="submit" value="Create project" id="submit" />
    <p></p>
  </div>
  <?php echo form_close(); ?>
  <?php endif; ?>
</div></div></div>
<!-- / add new project form container ends -->

<?php $this->load->view('includes/footer5'); ?>
