<?php $this->load->view('includes/header'); ?>

<style>

/* Easy Slider

.user-story, .user-story ul {
	width:355px;
	height:241px;
}

span#prevBtn{}
span#nextBtn{}					

Easy Slider */

</style>
			<div id="wrapper">
				<div class="contents">
					<div id="browse-tools-set">						
                        <?php echo form_open("/stories/browse", array('name' => 'browse-tools-form'));?>
                        	<!--$project_sel, $cat_sel, $skill_sel, $cash_from, $cash_to, $point, $type, $status, $work_horse-->
                            <div class="row">
                            <label style="width:100px;" style="width:100px;" for="Project_sel">Project:</label>
                            <select style="float:left; width:150px; margin-left:10px;" name="project_sel">
                            	<option value="0">Select Project</option>
                                <?php foreach($projects as $project):?>
                                <option value="<?php echo $project['project_id'];?>" <?php if($this->input->post('project_sel')==$project['project_id']){?>selected="selected"<?php }?>><?php echo $project['project_name'];?></option>
                                <?php endforeach;?>
                            </select>
                            </div>
                            
                            <div class="row">
                            <label style="width:100px;" for="category_sel">Category:</label>
                            <select style="float:left; width:150px; margin-left:10px;" name="category_sel">
                            	<option value="0">Select Category</option>
                            	<option value="g" <?php if($this->input->post('category_sel')=='g'){?>selected="selected"<?php }?>>General</option>
                                <?php foreach($categories as $cat):?>
                                <option value="<?php echo $cat['id'];?>" <?php if($this->input->post('category_sel')==$cat['id']){?>selected="selected"<?php }?>><?php echo $cat['name'];?></option>
                                <?php endforeach;?>
                            </select>
                            </div>
                            
                            <div class="row">
                            <label style="width:100px;" for="skill_sel">Skill:</label>
                            <select style="float:left; width:150px; margin-left:10px;" name="skill_sel">
                            	<option value="0">Select Skill</option>
                                <?php foreach($skills as $skill):?>
                                <option value="<?php echo $skill['id'];?>" <?php if($this->input->post('skill_sel')==$skill['id']){?>selected="selected"<?php }?>><?php echo $skill['name'];?></option>
                                <?php endforeach;?>
                            </select>
                            </div>
                            
                            <div class="row">
                            <label style="width:100px;" for="cash_from">Cash From:</label>
                            <input style="float:left; width:145px;" name="cash_from" type="text" value="<?php echo $this->input->post('cash_from');?>" />
                            </div>
                            
                            <div class="row">
                            <label style="width:100px;" for="cash_to">Cash To:</label>
                            <input style="float:left; width:145px;"name="cash_to" type="text" value="<?php echo $this->input->post('cash_to');?>" />
                            </div>
                            
                            <div class="row">
                            <label style="width:100px;" for="point">Points:</label>
                            <select style="float:left; width:150px; margin-left:10px;" name="point">
                            	<option value="0">Select points</option>
                            	<option <?php if($this->input->post('point')==1){?>selected="selected"<?php }?> value="1">1</option>
                                <option <?php if($this->input->post('point')==2){?>selected="selected"<?php }?> value="2">2</option>
                                <option <?php if($this->input->post('point')==3){?>selected="selected"<?php }?> value="3">3</option>
                                <option <?php if($this->input->post('point')==5){?>selected="selected"<?php }?> value="5">5</option>
                                <option <?php if($this->input->post('point')==8){?>selected="selected"<?php }?> value="8">8</option>
                                <option <?php if($this->input->post('point')==13){?>selected="selected"<?php }?> value="13">13</option>
                                <option <?php if($this->input->post('point')==20){?>selected="selected"<?php }?> value="20">20</option>
                                <option <?php if($this->input->post('point')==40){?>selected="selected"<?php }?> value="40">40</option>
                           </select>
                            </div>
                            
                           <div class="row">
                           <label style="width:100px;" for="status">Status:</label>
                           <select style="float:left; width:150px; margin-left:10px;" name="status">
                           		<option value="0">Select status</option>
                           		<option <?php if($this->input->post('status')=='open'){?>selected="selected"<?php }?> value="open">Open</option>
                                <option <?php if($this->input->post('status')=='in progress'){?>selected="selected"<?php }?> value="in progress">In Progress</option>
                                <option <?php if($this->input->post('status')=='done'){?>selected="selected"<?php }?> value="done">Done</option>
                                <option <?php if($this->input->post('status')=='verify'){?>selected="selected"<?php }?> value="verify">Verified</option>
                                <option <?php if($this->input->post('status')=='redo'){?>selected="selected"<?php }?> value="redo">Redo</option>
                                <option <?php if($this->input->post('status')=='signoff'){?>selected="selected"<?php }?> value="signoff">Signed off</option>
                                <option <?php if($this->input->post('status')=='reject'){?>selected="selected"<?php }?> value="reject">Rejected (Open for bidding)</option>
                           </select>
                           </div>
                           
                           <div class="row">
                           <label style="width:100px;" for="work_horse">Username:</label>
                           <input style="float:left; width:145px;" type="text" value="<?php echo $this->input->post('work_horse');?>" name="work_horse" />
                           </div>
                           
                           <div class="row">
                           <label style="width:100px;" for="search">Keyword:</label>
                           <input style="float:left; width:145px;" type="text" value="<?php echo $this->input->post('search');?>" name="search" />
                           </div>
                           
                           <div class="row">
                           <label></label>
                           <input style="float:left; width:145px;" name="submit" id="submit" value="submit" type="submit" />
                           </div>
                        <?php echo form_close();?>
					</div>
					
                    <div id="slider1">
                    	<!--<div class="slide-nav">
                             <a class="nextbutt" href="">Next</a>
                             <a class="previousbutt" href="">Previous</a>
                    	</div>-->
                    	<?php if($stories){foreach($stories as $story):?>
                        	<div class="user-story">
                            	<ul>
                                	<li>Project Name: <span><?php echo $story['project_name'];?></span></li>
                                    <li>Work Name: <span><?php echo $story['title'];?></span></li>
                                    <li>Cost: <span><?php echo $story['cost'];?></span></li>
                                    <li>Points: <span><?php echo $story['points'];?></span></li>
                                    <li>Status: <span style="color:#60d2ab; text-transform:uppercase;"><?php echo $story['status'];?></span></li>
                                    <li><a href="/story/<?php echo $story['work_id'];?>">More details</a></li>
                                </ul>
                            </div>
                        <?php endforeach;}else{?>
                        	<p>Your search result is empty.</p>
                        <?php }?>
                        
                        
                    </div>
                    
				</div><!--End of the Contents -->
			</div><!-- End of the Wrapper -->
<!--			
<script type="text/javascript">
	$(document).ready(function(){	
		$(".user-story ul").easySlider();
	});
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#slider1').bxSlider();
  });
</script>
-->				
<?php $this->load->view('includes/footer'); ?>