<?php $this->load->view('includes/header4'); ?>
<style>
.formrow {padding: 0 0 20px 0;}
.row {width: 380px !important;}
label {width: 90px !important; float: left;}

input[type="text"], textarea {width: 330px !important;border-radius: 5px;border: 0;padding: 5px;}
select {padding: 2px 2px 2px 8px;
border-radius: 5px;}

textarea {max-width: 330px;
max-height: 130px;}
h3 {
text-shadow: 0 1px 15px #63C0D6;
font-size: 22px;
font-weight: lighter;
color: white;
text-transform: uppercase;
}
 #map {
	width:500px;
	height:450px;
	float:left;
	display:block;
	background:#FFF;
}

 #contact-us {
	width:485px;
	height:450px;
	background:rgba(0, 0, 0, 0.4);
	float:right;
}

 #contact-us h3 {
	padding:10px 0 0 15px;
}

 form {
	margin:25px 0 0 20px;
	text-transform:none;
	color:#FFF;
}

 form div.row {
	height:46px;
}

 form div.row label {
	display:block;
	text-align:left;
	width:115px;
	float:left;
}

 form div.row input {
/*	background: url("../images/input.png") no-repeat scroll 0 0 transparent;*/
    border: medium none;
    float: right;
    height: 18px;
    margin: -4px 34px 20px 10px;
    padding: 4px 2px;
    width: 262px;
}

 form div.row select {
	float: right;
    height: 25px;
    margin-right: 33px;
    width: 265px;
}

 form div.row textarea {
/*	background: url("../images/textarea.png") no-repeat scroll 0 0 transparent;*/
    border: medium none;
    float: right;
    height: 132px;
    margin-right: 33px;
    width: 264px;
}

#submitbutton:hover {color:#000;}
#submitbutton {
	width:140px;
	height:36px;
	float: right;
margin: 10px 37px 0 0;
	text-transform:uppercase;
	border:3px solid #FFF;
	color:#FFFFFF;
	border:3px solid #f6f6f6;
	cursor:pointer;
	-webkit-border-radius: 60px;
	-moz-border-radius: 60px;
	border-radius: 60px;
	text-shadow: 0 0 1px #FFF;
	background: rgb(93,172,14); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(93,172,14,1) 0%, rgba(76,107,18,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(93,172,14,1)), color-stop(100%,rgba(76,107,18,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(93,172,14,1) 0%,rgba(76,107,18,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(93,172,14,1) 0%,rgba(76,107,18,1) 100%); /* Opera11.10+ */
	background: -ms-linear-gradient(top, rgba(93,172,14,1) 0%,rgba(76,107,18,1) 100%); /* IE10+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#5dac0e', endColorstr='#4c6b12',GradientType=0 ); /* IE6-9 */
	background: linear-gradient(top, rgba(93,172,14,1) 0%,rgba(76,107,18,1) 100%); /* W3C */
}


/*--------  -------- */


 #slide-show {
	background: none repeat scroll 0 0 rgba(0, 0, 0, 0.3);
    height: 160px;
    float:left;
    width: 500px;
    margin-top:20px;
}

 #slide-show #foo0 {
	margin-top:15px;
}

 #slide-show ul.mw_gallery {
/*	background-color: #ccc; */
	margin: 0 0 0 4px;
	padding: 0;
	list-style: none;
	display: block;
}

 #slide-show ul.mw_gallery li {
/*	background-color: #EEEEEE; */
    display: block;
    float: left;
    height: 135px;
    margin: 8px;
    padding: 0;
    text-align: center;
    width: 148px;
}

 #slide-show ul.mw_gallery li a {
	outline: none;
}
 #slide-show ul.mw_gallery li a img {
	border: 1px solid rgba(0, 0, 0, 0.4);
	height:auto;
}
 #slide-show ul.mw_gallery li a img.last {
	margin-right: 0;
}

 #slide-show .clearfix {
	float: none;
	clear: both;
}

 #contact-info {
   height: 160px;
float: left;
width: 410px;
margin: 20px 0 0 22px;
}

 #contact-info div.address {
	width:228px;
	float:left;
	color:#FFF;
	margin-top:25px;
	font-size: 14px;
}

 #contact-info div.contacts {
	color: #FFFFFF;
    float: left;
    font-size: 15px;
    margin-left: 10px;
    margin-top: 16px;
    text-transform: none;
    width: 160px;
}

 #contact-info div.contacts div.contact-area {
	border-bottom: 1px solid rgba(0, 0, 0, 0.2);
    float: left;
    padding-bottom: 6px;
    padding-top: 6px;
    width: 230px;
}


</style>
<div id="wrapper">
	<div class="WP-main" style="margin-top:100px;">
				<div id="map">
					<a href="http://maps.google.com.my/maps?q=3.118308,101.676579&ll=3.118105,101.678048&spn=0.006181,0.00986&num=1&t=h&vpsrc=6&z=17"><img src="http://maps.googleapis.com/maps/api/staticmap?center=midvaley,kuala+lumpur,Malaysia&zoom=16&size=512x450&maptype=roadmap&markers=color:red%7Clabel:M%7C3.118308,101.676579&sensor=false" /></a>
				</div>
				<div id="contact-us">
					<h3>enquiry</h3>
					<form class="form" action="/contact" method="post">
					<?php echo form_open('/contact' , array('class'=>'form')); ?>
							<div class="formrow"><label for="name">Name </label>
							<input type="text" name="name" id="name" class="text" />
							</div>
							<div class="formrow"><label for="phone">Phone No </label>
							<input type="text" name="phone" id="phone" class="text" />
							</div>
							<div class="formrow"><label for="name">Email </label>
							<input type="text" name="email" id="email" class="text" />
							</div>
							<div class="formrow"><label for="subject">Subject </label>
							<select name="state" id="state">
								<option value="General">General</option>
								<option value="Payment Issue">Payment issue</option>
								<option value="Copyright Issue">Copyright issue</option>
							</select>
							</div>
							<div class="formrow"><label for="message">Message </label>
							<textarea name="message" rows="8" cols="30" class="" id=""></textarea>
						
							<label></label>
							<input type="submit" name="submit" id="submitbutton"  value="Submit">
						</div>
					</form>
                    <?php echo form_close(); ?>
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
					<h3><strong>Contact Information</strong></h3>
<div class="address">
						<p>MotionWorks Sdn Bhd  Suite No. 29-6, 6th Floor, The Boulevard, Mid Valley City, Lingkaran Syed Putra, Kuala Lumpur, Wilayah Persekutuan, 59200</p>
					</div>
					<div class="contacts">
						<div class="contact-area"><img src="/public/images/tele.png"><span> 603 2282 5060</span></div>
						<div class="contact-area"><img src="/public/images/fax.png"><span> 603 2284 5060</span></div>
						<div class="contact-area"><img src="/public/images/email.png"><span> hello@motionworks.com.my</span></div>
					</div>
					
				</div>
				
	</div>
</div>
<?php if(isset($email_sent) && $email_sent){?>
<script type="text/javascript">
			$(document).ready(function(){alert('Thanks for contacting us.');});
		</script>
        <?php }?>
<?php $this->load->view('includes/footer5'); ?>