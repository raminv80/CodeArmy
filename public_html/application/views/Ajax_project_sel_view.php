<li id="category-list-0" class="<?php if($category_sel == ''){?>active <?php }?>category-list"><a href="javascript: void(0)" onClick="category_sel(0,'<?php echo $this->security->get_csrf_hash(); ?>')">General</a></li>
                        	<?php foreach($categories as $category):?>
							<li id="category-list-<?php echo $category['id'];?>" class="<?php if($category_sel == $category['id']){?>active <?php }?>category-list"><a href="javascript: void(0)" onClick="category_sel(<?php echo $category['id'];?>,'<?php echo $this->security->get_csrf_hash(); ?>')"><?php echo $category['name'];?></a></li>
                            <?php endforeach;?>
~
<?php foreach($stories as $story):?>
							<li>
								<a href="#homepage" class="link-popup-1"><span class="price">RM<?php echo number_format($story['cost']);?></span><span class="story"><?php echo $story['title'];?></span></a>
								<div class="popup-1">
									<div class="heading">
										<div class="holder">
											<span class="title"><?php echo $story['title'];?></span>
											<span>(RM<?php echo number_format($story['cost']);?>)</span>
										</div>
										<a href="#" class="close">close</a>
									</div>
									<dl>
										<dt>Bids</dt>
										<dd><?php echo $story['bids'];?></dd>
										<dt>Comments</dt>
										<dd><?php echo $story['comments'];?></dd>
										<dt>Points</dt>
										<dd><?php echo $story['points'];?></dd>
									</dl>
									<div class="summary">
										<span class="summary-text" style="text-align:justify"><?php echo substr(strip_tags($story['description']),0,255); if(strlen(strip_tags($story['description']))>255)echo '...';?></span>
									</div>
									<div class="button-holder">
										<a class="button" href="/story/<?php echo $story['work_id'];?>"><span class="left">Know More</span></a>
									</div>
								</div>
							</li>
                            <?php endforeach;?>