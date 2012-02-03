<?php $this->load->view('includes/header4'); ?>

<style>
#profile_form {
	margin: 0 auto;
    width: 620px;
}

#profile_form .edit_info fieldset {
	border: 0;
	font-size:100%;
	font-family: 'DINRegular',Arial;
	margin-top:50px;
}

#profile_form .edit_info .content {
	background:#000;
}

#profile_form .edit_info .heading{
	overflow:hidden;
	margin-bottom:38px;
	padding:0 14px 0 1px;
}

#profile_form .edit_info .heading .title{
	font-size:25px;
	margin:0;
	padding:1px 56px 9px 0px;
	background: url(/public/images/bg-popup-title.png) no-repeat 100% 0;
	text-transform:uppercase;
}

#profile_form .edit_info fieldset div.row label {
	width:250px;
	display:none;
	float:none;
	padding-left:40px
}

#profile_form .edit_info fieldset div.row div.text {
	float: left;
    margin-right: 20px;
}

#profile_form .edit_info fieldset div.row div.text select {
	width:100px;
	float:left;
}

#profile_form .edit_info fieldset div.row div.text input {
	height:auto;
	margin-left:-2px;
	width:360px;
}

#profile_form .edit_info fieldset div.row #submit {
	margin-right:60px;
}
.row {width: 100%;}
#n_pwd, #o_pwd, #r_pwd {width:290px !important;}
#submit {margin-top:0 !important;}
#wrapper .contents form div.row label { width:190px; }
#wrapper .contents #contact-us {
	width:470px;
	height:480px;
	background:rgba(0, 0, 0, 0.4);
	float:right;
}

#wrapper .contents #contact-us h3 {
	padding:20px 0 0 30px;
}

#wrapper .contents form {
	margin:25px 0 0 30px;
	text-transform:none;
	color:#FFF;
}

#wrapper .contents form div.row {
	height:46px;
}

#wrapper .contents form div.row label {
	display:block;
	text-align:left;
	float:left;
}

select, input, textarea, button {
font: 99% sans-serif;
}
input, select {
vertical-align: middle;
}

#wrapper .contents form div.row input {
/*	background: url("../images/input.png") no-repeat scroll 0 0 transparent;*/
    border: medium none;
    float: right;
    height: 18px;
    margin: -4px 34px 20px 10px;
    padding: 4px 2px;
    width: 262px;
}

#wrapper .contents form div.row select {
	float: right;
    height: 25px;
    margin-right: 33px;
    width: 265px;
}

#wrapper .contents form div.row textarea {
/*	background: url("../images/textarea.png") no-repeat scroll 0 0 transparent;*/
    border: medium none;
    float: right;
    height: 132px;
    margin-right: 33px;
    width: 264px;
}

#wrapper .contents form div.row #submit {
	width:140px;
	height:36px;
	margin-top:20px;
	margin-right:55px;
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
</style>
<div id="wrapper">
<div class="contents" style="margin-top:100px">
	<?php echo form_open('profile/edit_password'); ?>

	<div id="profile_form">
	<span class="header">
		<!--<h2>Password</h2>-->
	</span>
	
	<?php if(validation_errors()) { ?>
	<div class="val-error">
		<?php echo validation_errors(); ?>
	</div>
	<?php } ?>
	
	<div class="edit_info">
	<div class="holder">
		<div class="frame">
			<div class="content">
				<div class="heading">
					<strong class="title">Password</strong>
				</div>
				<fieldset>
                	<?php
					$msg = $this->session->flashdata('msg');
					if($msg){?>
                	<div class="row" style="color:#F90;">
                    	Your Password is Successfully updated.
                    </div>
                    <?php }?>
					<div class="row">
						<label for="o_pwd">
							Old Password 
							</label>
								<div class="text">
									<input type="password" name="o_pwd" id="o_pwd" placeholder="Old Password" />
								</div>
					</div>
					<div class="row">
						<label for="n_pwd">
							New Password 
							</label>
								<div class="text">
									<input type="password" name="n_pwd" id="n_pwd" placeholder="New Password" />
								</div>
					</div>
					<div class="row">
						<label for="r_pwd">
							Repeat New Password 
							</label>
								<div class="text">
									<input type="password" name="r_pwd" id="r_pwd" placeholder="Repeat Password" />
								</div>
					</div>
					<div class="row">
						<label for="submit">
							&nbsp;
						</label>
						<div class="text">
							<input type="submit" name="submit2" value="Submit" id="submit" />
						</div>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</div>
		<!--
		<dl>
		<dt><label for="o_pwd">Old Password : <label></dt><dd><input type="password" name="o_pwd" id="o_pwd" placeholder="Old Password" /></dd>
		<dt><label for="n_pwd">New Password : <label></dt><dd><input type="password" name="n_pwd" id="n_pwd" placeholder="New Password" /></dd>
		<dt><label for="r_pwd">Repeat New Password : <label></dt><dd><input type="password" name="r_pwd" id="r_pwd" placeholder="Repeat Password" /></dd>
		<dt><label for="submit">&nbsp;</label></dt>
		<dd><input type="submit" name="submit2" value="Submit" id="submit" /></dd>
		</dl>
		-->
	</div>
	
	<?php echo form_close(); ?>	

	</div>
</div>
<?php $this->load->view('includes/footer4'); ?>