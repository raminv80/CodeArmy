						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>Achievements</h1>
                                    <?php 
									$total = 15;
									$has = 0;
									if($badges){
										$has = $badges->num_rows();
										$badges = $badges->result_array();
										foreach($badges as $badge):
									?>
                                	<div class="badge">
                                		<img src="<?php echo base_url();?>public/<?php echo $badge['achievement_pic'];?>">
                                		<h4><?php echo $badge['achievement_name'];?></h4>
                                	</div>
                                    <?php endforeach;}
									for($i=$has; $i<$total; $i++):?>
                                    <div class="badge">
                                		<img src="<?php echo base_url();?>public/images/un-badge.png">
                                		<h4>Unknown</h4>
                                	</div>
                                    <?php endfor;?>
							</div>
							</div>
						</div>