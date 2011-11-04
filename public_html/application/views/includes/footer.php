        <?php if(($this->session->userdata('level')<20)&&($this->session->userdata('tutorial')>0)){?>
			<?php if($page_is=='Home' && !$this->session->userdata('step1') || true){ $this->session->set_userdata('step1',true);?>
            <div id="step1" class="dialog">
                <div>
                    <div class="left-column"><img width="40px" src="<?php echo base_url();?>public/images/step1.jpg" /></div>
                    <div class="right-column"><h3>Select a Job!</h3>Just click/expand a user story, view its summary and if you are intrested click on 'Know More'.
                        <p class="hint">Hint: Use search and filtering tools to refine your selection</p>
                    </div>
                </div>
            </div>
            <?php }?>
            <?php if($page_is=='story'){ ?>
            <?php if(isset($work_data))if(in_array(strtolower($work_data['status']), array('in progress', 'redo')) && ($this->session->userdata('user_id')==$work_data['work_horse'])){//step3?>
            <div id="step3" class="dialog">
                <div>
                    <div class="left-column"><img width="40px" src="<?php echo base_url();?>public/images/step3.jpg" /></div>
                    <div class="right-column"><h3>Finish it!</h3>Once you are done with this job click here to submit the work.
                    </div>
                </div>
            </div>
            <?php }//step 3?>
            
            <?php if(isset($work_data))if(in_array(strtolower($work_data['status']), array('open', 'reject')))//step2
            if(!$this->session->userdata('step2')){ $this->session->set_userdata('step2',true);?>
            <div id="step2" class="dialog">
                <div>
                    <div class="left-column"><img width="40px" src="<?php echo base_url();?>public/images/step2.jpg" /></div>
                    <div class="right-column"><h3>Bid it!</h3>Read it. Interested? Say how much and how long you need to finish it then click on Bid button.
                    </div>
                </div>
            </div>
            <div id="opt2" class="dialog">
                <div>
                    <div class="left-column"><img width="40px" src="<?php echo base_url();?>public/images/hint.png" /></div>
                    <div class="right-column"><h3>Dig it!</h3>Read job details in this column. Optionally to know more about the project or download source files click on project name. 
                    </div>
                </div>
            </div>
            <?php }//step2?>
            <?php }//story?>
        <?php }//show tutorial?>
        <?php $msg = $this->session->flashdata('alert');
			  if($msg){
		?>
        <div class="alert">
        	<div class="alert-content">
        		<?php echo $msg;?>
                <?php /*sample of content
                <div class="left-column"><img src="<?php echo base_url();?>public/images/1stbidder.png" /></div>
                <div class="right-column">
                	<h3>Congradulations!</h3>
                    <p>You just won your first badge by placing your first bid on a job. We will notify you and assign this job to you once your bidding wins in this bidding completition. Goodluck!</p>
                </div>
				*/?>
            </div>
        </div>
        <?php }?>
		<div id="footer">
			<div class="footer-holder">
				<ul class="add-nav" <?php if(isset($username)){?>style="width:485px"<?php }?>>
					<li <?php if($page_is=='Help'){?>class="active"<?php }?>><a href="/help">Help</a></li>
					<li <?php if($page_is=='Privacy'){?>class="active"<?php }?>><a href="/privacy">Privacy</a></li>
					<li <?php if($page_is=='T&C'){?>class="active"<?php }?>><a href="/terms">T&amp;C</a></li>
					<li <?php if($page_is=='Contact'){?>class="active"<?php }?>><a href="/contact">Contact Us</a></li>
					<li><a href="http://blog.motionworks.com.my/">Blog</a></li>
                    <?php if(isset($username)){?>
                    <li><a href="/login/logout">Logout</a></li>
                    <?php }?>
				</ul>
				<p>&copy;Motionworks sdn bhd 2011</p>
			</div>
		</div>

    	<script type="text/javascript" src="/public/scripts/footer_script.js"></script>
</body>
</html>