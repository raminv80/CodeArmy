<?php $this->load->view('includes/header'); ?>
<div id="wrapper">
	<div class="contents">
				<div id="map">
					<iframe width="640" height="480" frameborder="0" scrolling="auto" marginheight="10px" marginwidth="0" src="http://maps.google.com.my/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=motionworks&amp;g=Suite+No.+29-6,+6th+Floor,+The+Boulevard,+Mid+Valley+City,+Lingkaran+Syed+Putra,+Kuala+Lumpur,+Wilayah+Persekutuan,+59200&amp;ie=UTF8&amp;t=h&amp;vpsrc=0&amp;ll=3.11852,101.67852&amp;spn=0.006295,0.006295&amp;output=embed"></iframe>
				</div>
				<div id="contact-us">
					<h3>enquiry</h3>
					<form class="form" action="/contact" method="post">
						<div class="row">
							<label for="name">Name </label>
							<input type="text" name="name" id="name" class="text" />
						</div>
						<div class="row">
							<label for="phone">Phone number </label>
							<input type="text" name="phone" id="phone" class="text" />
						</div>
						<div class="row">
							<label for="name">Email </label>
							<input type="text" name="email" id="email" class="text" />
						</div>
						<div class="row">
							<label for="subject">Subject </label>
							<select name="state" id="state">
								<option value="General">General</option>
								<option value="Payment Issue">Payment issue</option>
								<option value="Copyright Issue">Copyright issue</option>
							</select>
						</div>
						<div class="row">
							<label for="message">Message </label>
							<textarea name="message" rows="8" cols="30" class="" id=""></textarea>
						</div>
						<div class="row">
							<label></label>
							<input type="submit" name="submit" id="submit" class="button" value="Submit">
						</div>
					</form>
				</div>
				
				<div id="slide-show">
					<div id="foo0">
						<ul class="mw_gallery">
							<li>
								<a rel="fancy_frame" href="public/gallery/employee.jpg" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>

							<li>
								<a rel="fancy_frame" href="public/gallery/employee.jpg" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>

							<li>
								<a rel="fancy_frame" href="public/gallery/employee.jpg" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>

							<li>
								<a rel="fancy_frame" href="public/gallery/employee.jpg" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>

							<li>
								<a rel="fancy_frame" href="public/gallery/employee.jpg" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>

							<li>
								<a rel="fancy_frame" href="public/gallery/employee.jpg" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>

							<li>
								<a rel="fancy_frame" href="public/gallery/employee.jpg" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>

							<li>
								<a rel="fancy_frame" href="public/gallery/employee.jpg" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>

							<li>
								<a rel="fancy_frame" href="public/gallery/employee.jpg" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>

							<li>
								<a rel="fancy_frame" href="public/gallery/employee.jpg" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>

							<li>
								<a rel="fancy_frame" href="public/gallery/employee.jpg" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>

							<li>
								<a rel="fancy_frame" href="public/gallery/employee.jpg" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>

							<li>
								<a rel="fancy_frame" href="public/gallery/employee.jpg" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>

							<li>
								<a rel="fancy_frame" class="iframe" href="http://www.youtube.com/embed/Jx2yQejrrUE?rel=0" title="Lorem ipsum dolor sit amet">
								<img alt="" src="public/gallery/employee.jpg" />
								</a>
							</li>
						</ul>
						</div>
						<div class="clearfix">
						</div>

					</div>
				
				<div id="contact-info">
					<h3>Contact Information</h3>
					<div class="address">
						<p>MotionWorks Sdn Bhd  Suite No. 29-6, 6th Floor, The Boulevard, Mid Valley City, Lingkaran Syed Putra, Kuala Lumpur, Wilayah Persekutuan, 59200</p>
					</div>
					<div class="contacts">
						<div class="contact-area"><img src="/public/images/tele.png"><span>603 2282 5060</span></div>
						<div class="contact-area"><img src="/public/images/fax.png"><span>603 2284 5060</span></div>
						<div class="contact-area"><img src="/public/images/email.png"><span>hello@motionworks.com.my</span></div>
					</div>
					
				</div>
				
	</div>
</div>
<?php if(isset($email_sent) && $email_sent){?>
<script type="text/javascript">
			$(document).ready(function(){alert('Thanks for contacting us.');});
		</script>
        <?php }?>
<?php $this->load->view('includes/footer'); ?>