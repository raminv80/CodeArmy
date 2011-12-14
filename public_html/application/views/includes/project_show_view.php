<?php $this->load->view('includes/header4'); ?>
		<section id="projectdetails"><div id="wrapper">
        	<div class="WP-main" style="margin: 90px auto 50px auto;">
			<div class="WP-qualification-placeholder" style="padding:0;">
      <div  id="qualif-heading"><span id="title"><a class="dialog_opt2" target="_blank" href="/project/1"><?php echo $project['project_name'];?></a></span></div></div>
       <div class="contents">
              <div class="project_detail">
                 <h1>PROJECT PROGRESS :<span style="color:#fc0;">75%</span></h1>
                 <div class="loadingprogress">
                  <div id="starter"></div>
                 
                  </div>
                  <div class="project-desc">
                    <?php echo $project['project_desc'];?>
                  </div>
                
              </div>
            </div>
        
    <br />
    </div><div id="push-down" style="height:125px;">&nbsp;</div>
  </div></section>
<?php $this->load->view('includes/footer4'); ?>