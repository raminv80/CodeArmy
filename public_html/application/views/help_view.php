<?php $this->load->view('includes/header'); ?>
		
		<div id="wrapper">
				<div class="contents">
					<div id="search">
						<h2>search keyword</h2>
						<div class="search-form">
							<input type="text" maxlength="128" name="" id="form-block" size="15" value="" title="Enter the terms you wish to search for." class="form-text">
							<input type="submit" class="" value="Search" id="form-submit" name="op">
						</div>
						<div id="help-frame">
							<h3>payment</h3>
							<dt>
							<dl class="question">
								<dt>
									How long do payout requests take?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est
								</dd>
							</dl>
							<dl class="question">
								<dt>
									What currency do I get paid in?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...
								</dd>
							</dl>
							
							
							<div class="read">
								<a href="">+ Read more</a>
							</div>
						</div>
						<div id="help-frame">
							<h3>payment</h3>
							<dt>
							<dl class="question">
								<dt>
									When do I get paid?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est
								</dd>
							</dl>
							<dl class="question">
								<dt>
									How do I request a payout?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est
								</dd>
							</dl>
							<dl class="question">
								<dt>
									How long do payout requests take?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est
								</dd>
							</dl>
							<dl class="question">
								<dt>
									What currency do I get paid in?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...
								</dd>
							</dl>
							<div class="read">
								<a href="">+ Read more</a>
							</div>
						</div>
						<div id="help-frame">
							<h3>payment</h3>
							<dt>
							<dl class="question">
								<dt>
									When do I get paid?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est
								</dd>
							</dl>
							<dl class="question">
								<dt>
									How do I request a payout?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est
								</dd>
							</dl>
							<dl class="question">
								<dt>
									How long do payout requests take?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est
								</dd>
							</dl>
							<dl class="question">
								<dt>
									What currency do I get paid in?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...
								</dd>
							</dl>
							<div class="read">
								<a href="">+ Read more</a>
							</div>
						</div>
						<div id="help-frame">
							<h3>payment</h3>
							<dt>
							<dl class="question">
								<dt>
									When do I get paid?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est
								</dd>
							</dl>
							<dl class="question">
								<dt>
									How do I request a payout?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est
								</dd>
							</dl>
							<dl class="question">
								<dt>
									How long do payout requests take?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est
								</dd>
							</dl>
							<dl class="question">
								<dt>
									What currency do I get paid in?
									<div class="arrow"></div>
								</dt>
								<dd>
									Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...
								</dd>
							</dl>
							<div class="read">
								<a href="">+ Read more</a>
							</div>
						</div>
						
						<div id="help-contact">
							<h3>I want to talk to a real person</h3>
							<p>We understand - things don't always go to plan. When the going gets tough, contact our</p>
							<a href="/contact" style="text-decoration:underline; text-transform:none;">friendly support team.</a>
							<p>We'll be happy to help (provided we've had our morning coffee) :p</p>
						</div>
					</div>            	
					
				</div><!-- End of the Contents -->
			</div><!-- End of the Wrapper -->

<script type="text/javascript">

	$('#help-frame .question dd').hide();
/*	$('#help-frame .question dd:first').show().prev('dt').addClass('selected'); */
	
	$('#help-frame .question dt').click(function(){
		$(this).next('dd').slideToggle(200).siblings('dd').slideUp();
		$(this).addClass('selected').siblings('dt').removeClass();
		return false;
	});
	
</script>
			
<?php $this->load->view('includes/footer'); ?>