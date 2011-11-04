<?php $this->load->view('includes/header'); ?>
		<div id="wrapper">
			<div class="contents">
              <h1><?php echo $project['project_name'];?></h1>
              <div class="project-desc">
              	<?php echo $project['project_desc'];?>
              </div>
            </div>
        </div>
<?php $this->load->view('includes/footer'); ?>