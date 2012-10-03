<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<style>
.hidden{
	text-indent:-9000px !important;
background:none !important; 
}
.tleft {text-align:left} .tright {text-align:right}
.fgrey, small {color:#aaa}
.btn.small {font-size:.8em; padding-left:5px; padding-right: 5px; line-height:12px}
.fyellow, .fyellow small {color: yellow}
.fred {color:#e95a56; text-shadow:0 0 1px black}
.fblue {color:#06c7f9}
.doubleline {padding-top:2px; line-height:10px;}
.btn-success, .green {
	background: rgb(85,137,0); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(85,137,0,1) 0%, rgba(68,94,19,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(85,137,0,1)), color-stop(100%,rgba(68,94,19,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(85,137,0,1) 0%,rgba(68,94,19,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(85,137,0,1) 0%,rgba(68,94,19,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(85,137,0,1) 0%,rgba(68,94,19,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(85,137,0,1) 0%,rgba(68,94,19,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#558900', endColorstr='#445e13',GradientType=0 ); /* IE6-9 */
}
.btn-blue, .blue {
	color:white; text-shadow:none;
	background: rgb(37,189,232); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(37,189,232,1) 0%, rgba(1,107,197,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(37,189,232,1)), color-stop(100%,rgba(1,107,197,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(37,189,232,1) 0%,rgba(1,107,197,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(37,189,232,1) 0%,rgba(1,107,197,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(37,189,232,1) 0%,rgba(1,107,197,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(37,189,232,1) 0%,rgba(1,107,197,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#25bde8', endColorstr='#016bc5',GradientType=0 ); /* IE6-9 */
}
.red {
	background: rgb(150,39,12); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(150,39,12,1) 0%, rgba(92,11,6,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(150,39,12,1)), color-stop(100%,rgba(92,11,6,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(150,39,12,1) 0%,rgba(92,11,6,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(150,39,12,1) 0%,rgba(92,11,6,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(150,39,12,1) 0%,rgba(92,11,6,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(150,39,12,1) 0%,rgba(92,11,6,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#96270c', endColorstr='#5c0b06',GradientType=0 ); /* IE6-9 */
}
.orange {
	background: rgb(196,148,6); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(196,148,6,1) 0%, rgba(178,112,0,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(196,148,6,1)), color-stop(100%,rgba(178,112,0,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(196,148,6,1) 0%,rgba(178,112,0,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(196,148,6,1) 0%,rgba(178,112,0,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(196,148,6,1) 0%,rgba(178,112,0,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(196,148,6,1) 0%,rgba(178,112,0,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c49406', endColorstr='#b27000',GradientType=0 ); /* IE6-9 */
}
.brown {
	background: rgb(134,111,19); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(134,111,19,1) 0%, rgba(92,85,0,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(134,111,19,1)), color-stop(100%,rgba(92,85,0,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(134,111,19,1) 0%,rgba(92,85,0,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(134,111,19,1) 0%,rgba(92,85,0,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(134,111,19,1) 0%,rgba(92,85,0,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(134,111,19,1) 0%,rgba(92,85,0,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#866f13', endColorstr='#5c5500',GradientType=0 ); /* IE6-9 */
}
.grey {
	background: rgb(153,153,153); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(153,153,153,1) 0%, rgba(85,85,85,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(153,153,153,1)), color-stop(100%,rgba(85,85,85,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(153,153,153,1) 0%,rgba(85,85,85,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(153,153,153,1) 0%,rgba(85,85,85,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(153,153,153,1) 0%,rgba(85,85,85,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(153,153,153,1) 0%,rgba(85,85,85,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#999999', endColorstr='#555555',GradientType=0 ); /* IE6-9 */
}
.container.missions h1 {font-size:1.6em; color:white}
.boxmission { min-height:260px; text-align:center; color:white; margin-bottom:25px;
	background: -moz-linear-gradient(top, rgba(153,153,153,0.3) 0%, rgba(153,153,153,0.3) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(153,153,153,0.3)), color-stop(100%,rgba(153,153,153,0.3))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(153,153,153,0.3) 0%,rgba(153,153,153,0.3) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(153,153,153,0.3) 0%,rgba(153,153,153,0.3) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(153,153,153,0.3) 0%,rgba(153,153,153,0.3) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(153,153,153,0.3) 0%,rgba(153,153,153,0.3) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#99999999', endColorstr='#99999999',GradientType=0 ); /* IE6-9 */; border-radius:10px; box-shadow: 0 1px 1px #111}
	.boxmission header {padding:15px 10px 5px; text-align:left; -webkit-border-top-left-radius: 10px; -webkit-border-top-right-radius: 10px; -moz-border-radius-topleft: 10px; -moz-border-radius-topright: 10px; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom:1px solid #333}
	.boxmission header .title {height:40px; text-shadow: 0 1px 1px black}
	.boxmission header .date {font-size:.85em; height:20px}
	.boxmission .wrapbar {height:30px}
	.boxmission .progress {background: #333; height:12px; border:1px solid #333; margin-bottom:10px}
	.boxmission .head {padding:10px 0; height:60px}
	.boxmission .head article {position:relative}
	.boxmission .head article .accept {color:#06c7f9}
	.boxmission .head article.copy {padding:0 5px; font-size:.9em}
	.boxmission .head aside {position:absolute; top:-5px; left:5px; width:15px; height:15px; line-height:15px; text-align:center; background: orange; color:black; border-radius:50%; font-size:.8em}
	.boxmission .head article i {padding:0 3px 0 15px; font-size:1.6em; line-height:.2em; text-shadow:0; color:#222; text-shadow:0 1px 1px #777}
	.boxmission .bottom {padding:0 10px}
</style>

<!-- NEW PAGE -->
<div class="container missions">
	<div class="row">
		<div class="span12">
			<div class="pull-left"><h1>My Missions</h1></div>
			<div class="pull-right">
				<?php if($me['role']=='po' || $me['role']=='admin'){?>
				<a href="#" class="btn btn-success">Create Mission</a>
				<?php }?>
			</div>
		</div>
		<div class="span12"><hr /></div>
	</div>
	
	<!-- FOR PO -->
	<div class="row">
	
		<!-- Sample green -->
		<div class="span3 boxmission">
			<header class="green">
				<p class="title">A manly wordpress blog template with custom plugins ...</p>
				<div class="wrapbar">
					<div class="progress progress-striped active progress-danger">
					  <div class="bar" style="width: 33%;"></div>
					</div>
				</div>
				<p class="date">Dateline: 10 September 2012</p>
			</header>
			<section>
				<div class="head tleft">
					<div class="row-fluid">
						<article class="span6"><i class="icon-comments"></i> <small>Wall</small> <aside>2</aside></article>
						<article class="span6"><i class="icon-calendar"></i> <small>Dates</small></article>
					</div>
					<div class="row-fluid">
						<article class="span6"><i class="icon-copy"></i> <small>Tasks</small></article>
						<article class="span6"><i class="icon-paper-clip"></i> <small>Documents</small> <aside>8</aside></article>
					</div>
				</div>
				<div class="bottom">
					<div class="pull-left tleft">99 <small>WEEKS LEFT</small> <br /> US$60 <small>/hr</small></div>
					<div class="pull-right"><a href="#" class="btn  btn-success">Check In</a></div>
				</div>
			</section>
		</div>
		
		<!-- Sample Brown -->
		<div class="span3 boxmission">
			<header class="brown">
				<p class="title">Ecommerce for online boutique with MOLpay integration</p>
				<div class="wrapbar">
					<div class="progress progress-striped active progress-warning">
					  <div class="bar" style="width: 50%;"></div>
					</div>
				</div>
				<p class="date">Dateline: 10 September 2012</p>
			</header>
			<section>
				<div class="head tleft">
					<div class="row-fluid">
						<article class="span6"><i class="icon-comments"></i> <small>Comments</small> <aside>2</aside></article>
						<article class="span6"><i class="icon-group"></i> <small>Bidder</small></article>
					</div>
				</div>
				<div class="bottom">
					<div class="pull-left tleft">99 <small>WEEKS LEFT</small> <br /> US$60 <small>/hr</small></div>
					<div class="pull-right"><a href="#" class="btn btn-success">Edit</a></div>
				</div>
			</section>
		</div>
		
		<!-- Sample Brown -->
		<div class="span3 boxmission">
			<header class="brown">
				<p class="title">Ecommerce for online boutique with MOLpay integration</p>
				<div class="wrapbar">
					<div class="progress progress-striped active progress-success">
					  <div class="bar" style="width: 75%;"></div>
					</div>
				</div>
				<p class="date">Dateline: 10 September 2012</p>
			</header>
			<section>
				<div class="head tleft">
					<div class="row-fluid">
						<article class="span6"><i class="icon-comments"></i> <small>Comments</small> <aside>2</aside></article>
						<article class="span6"><i class="icon-group"></i> <small>Bidder</small></article>
					</div>
				</div>
				<div class="bottom">
					<div class="pull-left tleft">99 <small>WEEKS LEFT</small> <br /> US$60 <small>/hr</small></div>
					<div class="pull-right"><a href="#" class="btn btn-success">Edit</a></div>
				</div>
			</section>
		</div>
		
		<!-- Sample Grey -->
		<div class="span3 boxmission">
			<header class="grey">
				<p class="title">Facebook landing page</p>
				<div class="wrapbar">
					<!-- <div class="progress progress-striped active progress-warning">
					  <div class="bar" style="width: 40%;"></div>
					</div> -->
				</div>
				<p class="date"><!-- Dateline: 10 September 2012 --></p>
			</header>
			<section>
				<div class="head tleft">
					<!-- <div class="row-fluid">
						<article class="span6"><i class="icon-comments"></i> <small>Wall</small> <aside>2</aside></article>
						<article class="span6"><i class="icon-calendar"></i> <small>Dates</small></article>
					</div>
					<div class="row-fluid">
						<article class="span6"><i class="icon-copy"></i> <small>Tasks</small></article>
						<article class="span6"><i class="icon-paper-clip"></i> <small>Documents</small> <aside>8</aside></article>
					</div> -->
				</div>
				<div class="bottom">
					<div class="pull-left tleft"><!-- 99 <small>WEEKS LEFT</small> --><br /> US$60 <small>/hr</small></div>
					<div class="pull-right"><a href="#" class="btn btn-success">Edit</a></div>
				</div>
			</section>
		</div>
		
	</div> <!-- End PO row -->
	
	<!-- FOR TALENT -->
	<div class="row">
	
		<!-- Sample green -->
		<div class="span3 boxmission">
			<header class="green">
				<p class="title">A manly wordpress blog template with custom plugins ...</p>
				<div class="wrapbar">
					<div class="progress progress-striped active progress-danger">
					  <div class="bar" style="width: 33%;"></div>
					</div>
				</div>
				<p class="date">Dateline: 10 September 2012</p>
			</header>
			<section>
				<div class="head tleft">
					<div class="row-fluid">
						<article class="span6"><i class="icon-comments"></i> <small>Wall</small> <aside>2</aside></article>
						<article class="span6"><i class="icon-calendar"></i> <small>Dates</small></article>
					</div>
					<div class="row-fluid">
						<article class="span6"><i class="icon-copy"></i> <small>Tasks</small></article>
						<article class="span6"><i class="icon-paper-clip"></i> <small>Documents</small> <aside>8</aside></article>
					</div>
				</div>
				<div class="bottom">
					<div class="pull-left tleft">99 <small>WEEKS LEFT</small> <br /> US$60 <small>/hr</small></div>
					<div class="pull-right"><a href="#" class="btn  btn-success">Check In</a></div>
				</div>
			</section>
		</div>
		
		<!-- Sample orange -->
		<div class="span3 boxmission">
			<header class="orange">
				<p class="title">Ecommerce for online boutique with MOLpay integration</p>
				<div class="wrapbar">
					<!-- <div class="progress progress-striped active progress-warning">
					  <div class="bar" style="width: 50%;"></div>
					</div> -->
				</div>
				<p class="date">
					<span class="pull-left">Hourly, 2-4 Weeks</span>
					<span class="pull-right">11 Bids</span>
				</p>
			</header>
			<section>
				<div class="head tcenter">
					<div class="row-fluid">
						<article class="copy">
							<p class="accept">Offer Accepted!</p>
						</article>
					</div>
					<div class="row-fluid">
						<article class="span4"><span class="fyellow">Your Bid</span></article>
						<article class="span1">12</article>
						<article class="span2 tleft doubleline"><small>hr/ week</small></article>
						<article class="span1">MYR</article>
						<article class="span4">4 <small>/hour</small></article>
					</div>
				</div>
				<div class="bottom">
					<div class="pull-left tleft">42 <small>hr/week</small> <br /> US$60 <small>/hr</small></div>
					<div class="pull-right"><a href="#" class="btn btn-danger small"> <i class="icon-remove"></i><br />Decline</a> <a href="#" class="btn btn-success small"><i class="icon-ok"></i> <br />Accept</a></div>
				</div>
			</section>
		</div>
		
		<!-- Sample Brown -->
		<div class="span3 boxmission">
			<header class="brown">
				<p class="title">Ecommerce for online boutique with MOLpay integration</p>
				<div class="wrapbar">
					<!-- <div class="progress progress-striped active progress-success">
					  <div class="bar" style="width: 75%;"></div>
					</div> -->
				</div>
				<p class="date">
					<span class="pull-left">Fixed</span>
					<span class="pull-right">9 Bids</span>
				</p>
			</header>
			<section>
				<div class="head">
					<div class="row-fluid fgrey">
						<article class="span4"><small>Latest Bid</small></article>
						<article class="span3">30 days</article>
						<article class="span1">MYR</article>
						<article class="span4">4,000</article>
					</div>
					<div class="row-fluid">
						<article class="span4"><span class="fyellow">Your Bid</span></article>
						<article class="span3">30 days</article>
						<article class="span1">MYR</article>
						<article class="span4">4,000</article>
					</div>
				</div>
				<div class="bottom">
					<div class="pull-left tleft">36 <small>days</small> <br /> US$60 <small>/hr</small></div>
					<div class="pull-right"><!-- <a href="#" class="btn btn-success">Edit</a>--></div>
				</div>
			</section>
		</div>
		
		<!-- Sample red -->
		<div class="span3 boxmission">
			<header class="red">
				<p class="title">Facebook landing page</p>
				<div class="wrapbar">
					<!-- <div class="progress progress-striped active progress-warning">
					  <div class="bar" style="width: 40%;"></div>
					</div> -->
				</div>
				<p class="date">
					<span class="pull-left">Hourly, 2-4 Weeks</span>
					<span class="pull-right">11 Bids</span>
				</p>
			</header>
			<section>
				<div class="head tcenter">
					<div class="row-fluid">
						<article class="copy">
							<p class="fred">Sorry your offer rejected</p>
						</article>
					</div>
					<div class="row-fluid">
						<article class="span4"><span class="fyellow">Your Bid</span></article>
						<article class="span1">30</article>
						<article class="span2 tleft doubleline"><small>hr/ week</small></article>
						<article class="span1">MYR</article>
						<article class="span4">42 <small>/hr</small></article>
					</div>	
				</div>
				<div class="bottom">
					<div class="pull-left tleft">36 <small>hr/week</small> <br /> US$60 <small>/hr</small></div>
					<div class="pull-right"><a href="#" class="btn btn-danger small"><i class="icon-remove"></i><br /> Remove</a></div>
				</div>
			</section>
		</div>
		
		<!-- Sample blue -->
		<div class="span3 boxmission">
			<header class="blue">
				<p class="title">Facebook landing page</p>
				<div class="wrapbar"></div>
				<p class="date">
					<span class="pull-left">Hourly, 2-4 Weeks</span>
					<span class="pull-right">11 Bids</span>
				</p>
			</header>
			<section>
				<div class="head tcenter">
					<div class="row-fluid">
						<article class="copy">
							<p class="fblue">You have been invited to bid</p>
						</article>
					</div>
					<div class="row-fluid">
						<article class="span2">days</article>
						<article class="span3"><input type="text" style="width:30px;height:15px" placeholder="5" /></article>
						<article class="span2">MYR</article>
						<article class="span5"><input type="text" style="width:60px; height:15px" placeholder="1250" /></article>
					</div>	
				</div>
				<div class="bottom">
					<div class="pull-left tleft">36 <small>hr/week</small> <br /> US$60 <small>/hr</small></div>
					<div class="pull-right"><a href="#" class="btn btn-danger small"> <i class="icon-remove"></i><br />Decline</a> <a href="#" class="btn btn-blue small"><i class="icon-ok"></i> <br />Place Bid</a></div>
				</div>
			</section>
		</div>
		
		<!-- Sample Grey -->
		<div class="span3 boxmission">
			<header class="grey">
				<p class="title">My Little Pony Design</p>
				<div class="wrapbar">
					<!-- <div class="progress progress-striped active progress-warning">
					  <div class="bar" style="width: 40%;"></div>
					</div> -->
				</div>
				<p class="date">
					<span class="pull-left">Hourly, 3-4 Weeks</span>
					<span class="pull-right">11 Bids</span>
				</p>
			</header>
			<section>
				<div class="head">
					<div class="row-fluid">
						<p class="tcenter fred">Bidding for this mission has ended</p>
					</div>
					<div class="row-fluid">
						<article class="span4"><span class="fyellow">Your Bid</span></article>
						<article class="span1">30</article>
						<article class="span2 tleft doubleline"><small>hr/ week</small></article>
						<article class="span1">MYR</article>
						<article class="span4">42 <small>/hr</small></article>
					</div>
				</div>
				<div class="bottom">
					<div class="pull-left tleft"> 12 <small>hr/week</small><br /> US$60 <small>/hr</small></div>
					<div class="pull-right"><a href="#" class="btn btn-danger small"><i class="icon-remove"></i><br /> Remove</a></div>
				</div>
			</section>
		</div>
		
	</div> <!-- End Talent row>
	
</div>

<!-- OLD PAGE -->
<div class="container-fluid" style="padding-top:500px">
	<div class="row-fluid">
		
		<!-- Page start -->
		<div id="mymission-content-area" class="span10 offset1">
			<div id="block-mission-list">
		    	<div class="block-header">
		        	<h3>My Missions</h3>
		            <?php if($me['role']=='po' || $me['role']=='admin'){?>
		            <div style="float:right;">
		            <select id="mission-status" style="width:150px" onchange="window.location='/missions/my_missions/'+$(this).val()">
		            	<option <?php if($status=='All'){?>selected="selected"<?php }?> value="All">All (<?=$this->work_model->get_num_state($this->session->userdata('user_id'),'All')?>)</option>
		                <option <?php if($status=='In_Progress'){?>selected="selected"<?php }?> value="In_Progress">In Progress (<?=$this->work_model->get_num_state($this->session->userdata('user_id'),'in progress')?>)</option>
		                <option <?php if($status=='Pending'){?>selected="selected"<?php }?> value="Pending">Pending  (<?=$this->work_model->get_num_state($this->session->userdata('user_id'),array('assigned','open','done','verify','reject'))?>)</option>
		                <option <?php if($status=='Draft'){?>selected="selected"<?php }?> value="Draft">Drafts  (<?=$this->work_model->get_num_state($this->session->userdata('user_id'),'draft')?>)</option>
		                <option <?php if($status=='Completed'){?>selected="selected"<?php }?> value="Completed">Completed (<?=$this->work_model->get_num_state($this->session->userdata('user_id'),'signoff')?>)</option>
		            </select>
		            </div>
		            <?php }?>
		        </div>
		        <!-- New Dsign By Reza -->
		        <div class="list">
		        	<?php
					if($myProfile["params"] != ""){
						$params = json_decode($myProfile["params"]);
						$hideSample = $params->hidesample;
					} else {
						$hideSample = "false";
					}
					if($me['role']=='po' && $hideSample != "true"){ ?>
		        	<!-- Sample Mission : Begin -->
		            <div class="item gray-mission" id="mission-sample">
		            	<div class="mission-header">
		                	<div class="mission-title">Sample Mission</div>
		                    <div class="mission-status-icon"><img src="/public/images/codeArmy/mymission/thumb-up.png" alt="thumb up" /></div>
		                    <div class="mission-progress-bg">
		                    	<div class="mission-progress-meter" style="width:0px"></div>
		                        <input type="hidden" name="percent" value="0" />
		                        <input type="hidden" name="min_to_percent" value="0" />
		                    </div>
		                    <!--<div class="mission-inputs">Proposed Timeline: 1 month</div>
		                    <div class="mission-deliverables">Proposed Reward: 20$/month</div>-->
		                    <div class="mission-inputs">Deadline: 
							<?php
							$str1Month = mktime(0, 0, 0, date("m")+1, date("d"),   date("Y"));
							echo date("dS F Y", $str1Month);
							?></div>
		                </div>
		                <div class="mission-content">
		                	<ul class="mission-icons">
		                		<li><a href="#"><span class="icon"></span><span class="title">Wall</span></a></li>
		                        <li><a href="#"><span class="icon"></span><span class="title">Dates</span></a></li>
		                        <li><a href="#"><span class="icon"></span><span class="title">Tasks</span></a></li>
		                        <li><a href="#"><span class="icon"></span><span class="title">Documents</span></a></li>
		                    </ul>
		                    <div class="mission-time">
		                    	<span class="time-left">Time left</span>
		                        <div class="timer">
		                        <span class="time">720</span>
		                        <span class="hrs">hrs</span>
		                        </div>
		                        <a href="javascript:void(0);" id="removeSample" class="blue-button">Remove</a>
		                    </div>
		                </div>
		            </div>
		            <!-- Sample Mission : End -->
		            <?php } ?>

		        	<?php foreach($myPendingList as $list):?>
		            <div class="item gray-mission" id="mission-<?=$list['work_id']?>">
		            	<div class="mission-header">
		                	<div class="mission-title"><?=character_limiter($list['title'],20)?></div>
		                    <div class="mission-progress-bg">
		                    	<div class="mission-progress-meter" style="width:0px"></div>
		                        <input type="hidden" name="percent" value="0" />
		                        <input type="hidden" name="min_to_percent" value="0" />
		                    </div>
		                    <?php
								$proposal = $this->work_model->get_approved_bid($me['user_id'],$list['work_id']);
								$proposal = $proposal[0];
								$arrangement = $this->work_model->get_work_arrangement($list['work_id']);
								$arrangement = str_replace('dai','day',substr($arrangement,0,-2)).'s';
								$troopers = $this->work_model->get_num_troopers($list['work_id']);
							?>
		                    <div class="mission-inputs">Proposed Timeline: <?=$proposal['bid_time'].' '.$arrangement?></div>
		                </div>
		                <div class="mission-content">
		                	<ul class="mission-icons">
		                		<li><a href="#"><span class="icon"></span><span class="title">Wall</span></a></li>
		                        <li><a href="#"><span class="icon"></span><span class="title">Dates</span></a></li>
		                        <li><a href="#"><span class="icon"></span><span class="title">Tasks</span></a></li>
		                        <li><a href="#"><span class="icon"></span><span class="title">Documents</span></a></li>
		                    </ul>
		                    <div class="mission-time">
		                    	<span class="time-left">Time left</span>
		                        <div class="timer">
		                        <span class="time"></span>
		                        <span class="hrs">hrs</span>
		                        </div>
		                        <!-- Accept -->
		                        <a href="javascript:void(0)" style="right:7px" class="accept blue-button">Accept</a>
		                        <!-- Reject -->
		                        <a href="javascript:void(0);" style="right:126px" class="reject blue-button">Reject</a>
		                    </div>
		                </div>
		            </div>
		            <?php endforeach;?>

		            <!--- Reza --->
					<?php foreach($myWorkList as $list):?>
		            <div class="item gray-mission" id="mission-<?=$list['work_id']?>">
		            	<?php
							//calc remaining time
							$remaining_time = strtotime($list['deadline'])-time();
							if($remaining_time<0)$remaining_time=0;
							//calc elappsed time
							$elappsed_time = time()-strtotime($list['assigned_at']);
							//calc total time he had during assignment
							$given_time = strtotime($list['deadline']) - strtotime($list['assigned_at']);
							if($given_time<0) $given_time = 1;

							$progress_percent = ($given_time==0)?0:$elappsed_time/$given_time;
							$progress_percent = ($progress_percent>0)?(($progress_percent>1)?1:$progress_percent):0;
							$remaining_hour = floor($remaining_time / (60*60));
							$remaining_min = $remaining_time % (60*60);
							$remaining_minutes = floor($remaining_min / (60));
							$min_to_percent = ($given_time==0)?0:(1*60)/($given_time);
						?>
		            	<div class="mission-header">
		                	<div class="mission-title"><?=character_limiter($list['title'],20)?></div>
		                    <div class="mission-progress-bg">
		                    	<div class="mission-progress-meter" style="width:<?= round(216*$progress_percent) ?>px"></div>
		                        <input type="hidden" name="percent" value="<?=$progress_percent?>" />
		                        <input type="hidden" name="min_to_percent" value="<?=$min_to_percent?>" />
		                    </div>
		                    <?php
								$proposal = $this->work_model->get_approved_bid($me['user_id'],$list['work_id']);
								$proposal = $proposal[0];
								$arrangement = $this->work_model->get_work_arrangement($list['work_id']);
								$arrangement = str_replace('dai','day',substr($arrangement,0,-2)).'s';
								$budget = $this->work_model->get_work_budget($list['work_id']);
								$troopers = $this->work_model->get_num_troopers($list['work_id']);
							?>
		                    <!--<div class="mission-inputs">Proposed Timeline: <?=$proposal['bid_time'].' '.$arrangement?></div>
		                    <div class="mission-deliverables">Proposed Reward: <?=$proposal['bid_cost'].'$/'.$arrangement?></div>-->
		                    <div class="mission-inputs">Deadline: <?= date("dS F Y", strtotime($list["deadline"])) ?></div>
		                </div>
		                <div class="mission-content">
		                	<ul class="mission-icons">
		                    	<?php $user = $this->users_model->get_user($list['owner'])->result_array();?>
		                        <?php
								$wallNotify = $this->work_model->get_wall_notify($list['work_id'], $me['user_id']);
								?>
		                		<li><a href="/missions/wall/<?=$list['work_id']?>"><span class="icon <?=($wallNotify>0)?'':'hidden'?>"><?php if($wallNotify!=0) echo $wallNotify; ?></span><span class="title">Wall</span></a></li>
		                        <li><a href="/missions/dates/<?=$list['work_id']?>"><span class="icon hidden"></span><span class="title">Dates</span></a></li>
		                        <?php
								$tasksNotify = $this->work_model->get_tasks_notify($list['work_id'], $me['user_id']);
								?>
		                        <li><a href="/missions/task/<?=$list['work_id']?>"><span class="icon <?=($tasksNotify>0)?'':'hidden'?>"><?php if($tasksNotify!=0) echo $tasksNotify; ?></span><span class="title">Tasks</span></a></li>
		                        <?php
								$documentsNotify = $this->work_model->get_documents_notify($list['work_id'], $me['user_id']);
								?>
		                        <li><a href="/missions/documents/<?=$list['work_id']?>"><span class="icon <?=($documentsNotify>0)?'':'hidden'?>"><?php if($documentsNotify!=0) echo $documentsNotify; ?></span><span class="title">Documents</span></a></li>
		                    </ul>
		                    <div class="mission-time">
		                    	<!--<span class="time-left">Time left</span>-->
		                        <div class="timer">
		                        <!--<span class="time"><?=($remaining_hour<24)?$remaining_hour.':'.$remaining_minutes:$remaining_hour?></span>-->
		                        <span class="time"><?php
								if($remaining_hour < 168){
									echo $remaining_hour." hrs";
								} else if ($remaining_hour > 336){
									echo floor(($remaining_hour / 168))." weeks left";
								}
		                        ?></span><br />
		                        <span class="hrs"><?='US$'.$budget." /".$arrangement?></span>
		                        </div>
		                        <?php if(in_array(strtolower($list['status']),array('in progress','done','redo','signoff','verify'))){?>
		                        <a href="/missions/wall/<?=$list['work_id']?>" class="blue-button">Check in</a>
		                        <?php }?>
		                    </div>
		                </div>
		            </div>
		            <?php endforeach;?>
		            <?php foreach($myMissions as $list):
						$color = (in_array(strtolower($list['status']),array('draft')))?'red':'green';
						$color = (in_array(strtolower($list['status']),array('signoff')))?'gray':$color;
					?>
		            <div class="item <?=$color?>-mission" id="mission-<?=$list['work_id']?>">
		            	<?php
							//calc remaining time
							$remaining_time = strtotime($list['deadline'])-time();
							if($remaining_time<0)$remaining_time=0;
							//calc elappsed time
							$elappsed_time = time()-strtotime($list['assigned_at']);
							//calc total time he had during assignment
							$given_time = strtotime($list['deadline']) - strtotime($list['assigned_at']);
							if($given_time<0) $given_time = 1;

							$progress_percent = ($given_time==0)?0:$elappsed_time/$given_time;
							$progress_percent = ($progress_percent>0)?(($progress_percent>1)?1:$progress_percent):0;
							$remaining_hour = floor($remaining_time / (60*60));
							$remaining_min = $remaining_time % (60*60);
							$remaining_minutes = floor($remaining_min / (60));
							$min_to_percent = ($given_time==0)?0:(1*60)/($given_time);

							$po = ($me['user_id']==$list['owner']);

						?>
		            	<div class="mission-header">
		                	<div class="mission-title"><?=character_limiter($list['title'],20)?></div>
		                    <div class="mission-status-icon"><?=$list['status']?></div>
		                    <div class="mission-progress-bg">
		                    	<div class="mission-progress-meter" style="width:<?= round(216*$progress_percent) ?>px"></div>
		                        <input type="hidden" name="percent" value="<?=$progress_percent?>" />
		                        <input type="hidden" name="min_to_percent" value="<?=$min_to_percent?>" />
		                    </div>
		                    <?php 
								if(in_array(strtolower($list['status']),array('draft','open','assigned'))){
									$arr = $this->work_model->get_work_arrangement($list['work_id']);
									$arranegement = $arr;
									$estimate_time = $this->work_model->get_selected_arrangement_time($list['est_time_frame']);
									if(!$estimate_time){$estimate_time=0;} else {$estimate_time = $estimate_time[0];}
									$estimate_budget = $this->work_model->get_selected_arrangement_budget($list['est_budget']);
									if(!$estimate_budget){$estimate_budget=0;} else {$estimate_budget = $estimate_budget[0];}
							?>
		                    <div class="mission-inputs">About <?=($estimate_time['time_cal'])?$estimate_time['time_cal']:'?'?> <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s, <?=($estimate_budget['amount_cal'])?$estimate_budget['amount_cal']:'?'?>$ per <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s</div>
		                    <div class="mission-deliverables"></div>
		                    <?php 
								}else{
									$arr = $this->work_model->get_work_arrangement($list['work_id']);
									$arranegement = $arr;
									$time_cost = $this->work_model->get_actual_work_time_cost($list['work_id']);
									if(!$time_cost){$estimate_time=0;} else {$estimate_time = $time_cost['bid_time'];}
									if(!$time_cost){$estimate_budget=0;} else {$estimate_budget = $time_cost['bid_cost'];}
							?>
		                    <div class="mission-deliverables"><?=($estimate_time['time_cal'])?$estimate_time['time_cal']:'?'?> <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s, <?=($estimate_budget['amount_cal'])?$estimate_budget['amount_cal']:'?'?>$ per <?=ucfirst(str_replace('dai','day',substr($arranegement,0,-2)))?>s</div>
		                    <?php }?>
		                </div>
		                <div class="mission-content">
		                	<ul class="mission-icons">
		                    	<?php if($po){?>
		                         <li><a href="#"><span class="icon hidden"></span><span class="title">Captain</span></a></li>
		                        <li><a href="/missions/applicants/<?=$list['work_id']?>"><span class="icon <?=($list['bids']>0)?'':'hidden'?> bidders-<?=$list['work_id']?>"><?=$list['bids']?></span><span class="title "> Bidders</span></a></li>
		                        <li><a href="#"><span class="icon hidden"></span><span class="title">Discussion</span></a></li>
		                        <li><a href="#"><span class="icon hidden"></span><span class="title">Attachements</span></a></li>
		                        <?php }else{?>
		                		<li><a href="#"><span class="icon hidden"></span><span class="title">Captain</span></a></li>
		                        <li><a href="#"><span class="icon hidden"></span><span class="title">1 Trooper</span></a></li>
		                        <li><a href="#"><span class="icon hidden"></span><span class="title">Discussion</span></a></li>
		                        <li><a href="#"><span class="icon hidden"></span><span class="title">Attachements</span></a></li>
		                        <?php }?>
		                    </ul>
		                    <div class="mission-time">
		                    	<span class="time-left">Time left</span>
		                        <div class="timer">
		                        <span class="time"><?=($remaining_hour<24)?$remaining_hour.':'.$remaining_minutes:$remaining_hour?></span>
		                        <span class="hrs">hrs</span>
		                        </div>
		                        <?php if($po && (strtolower($list['status'])=='open' || strtolower($list['status'])=='assigned' || strtolower($list['status'])=='draft')){//TODO: if in open, assigned status allow edit but send alert to bidders on change?>
		                        	<a class="blue-button" href="/missions/manage/<?=$list['work_id']?>">Manage</a>
		                        <?php }else{?>
		                        	<a href="/missions/wall/<?=$list['work_id']?>" class="blue-button">Check in</a>
		                        <?php }?>
		                    </div>
		                </div>
		            </div>
		            <?php endforeach;?>
		            <?php if(($this->session->userdata('role')=='po'||$this->session->userdata('role')=='admin')){?>
		            <a href="/missions/create" class="fancybox" id="FindMissions">
		            <div id="dummy-create-mission">
		            	<i class="icon-plus-sign"></i> Create Mission
		            </div>
		            </a>
		            <?php }?>
		        </div>
		        </div>
		        <!-- END: New Dsign By Reza -->

		    </div>
		</div>
		<div id="dialog-confirm" class="dialog" title="Mission Agreement">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Do you agree to accept and deliver this mission?</p>
		</div>
		<div id="dialog-reject" class="dialog" title="Mission rejection">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure you want to reject this mission?</p>
		</div>
		<!-- Page ends -->
	</div>
</div>

<script>
	var selectedItem;
	$(function(){
		$('#mission-status').selectmenu();
		$('a[title]').tipsy({trigger: 'hover', gravity: 'sw'});
		mins = 0; setInterval("updateTimer()",1000*60);
		$('.accept').click(function(){
			selectedItem = $(this).parents('.item');
			var work_id = selectedItem.attr('id').split('-')[1];
			if (typeof console == "object") console.log(work_id);
			$( "#dialog-confirm" ).dialog({
				resizable: false,
				modal: true,
				width: 430,
				buttons: {
					"Disagree": function() {
						$( this ).dialog( "close" );
					},
					"I Agree" : function() {
						$.fancybox.showLoading();
						$.ajax({
							url: '/missions/Ajax_accept_work',
							type: 'post',
							data: {'csrf_workpad': getCookie('csrf_workpad'), 'work_id':work_id},
							success: function(msg){
								window.location = '/missions/wall/'+msg;
								$.fancybox.hideLoading();
							}
						});
						$( this ).dialog( "close" );
					}
				}
			});
			
		});
		$('.reject').click(function(){
			selectedItem = $(this).parents('.item');
			var work_id = selectedItem.attr('id').split('-')[1];
			if (typeof console == "object") console.log(work_id);
			$( "#dialog-reject" ).dialog({
				resizable: false,
				modal: true,
				width: 410,
				buttons: {
					cancel: function() {
						$( this ).dialog( "close" );
					},
					"Yes" : function() {
						$.fancybox.showLoading();
						$.ajax({
							url: '/missions/Ajax_reject_work',
							type: 'post',
							data: {'csrf_workpad': getCookie('csrf_workpad'), 'work_id':work_id},
							success: function(msg){
								$('#mission-'+msg).slideUp(function(){$(this).remove()});
								$.fancybox.hideLoading();
							}
						});
						$( this ).dialog( "close" );
					}
				}
			});
		});
		
		$('#removeSample').click(function(){
			$.ajax({
				url: '/missions/Ajax_remove_sample',
				type: 'post',
				async: false,
				data: {'csrf_workpad': getCookie('csrf_workpad')},
				success: function(msg){
					//console.log(msg);
					$('#mission-sample').slideUp('fast');
				}
			});
		});
		
		//Lets show number of bids on a mission in realtime
		var channel = pusher.subscribe('bid');
		  channel.bind_all(function(evnt,data) {
		  if(evnt.indexOf('new-bid')>-1){
			  var el=$('#mission-'+data.work_id).find('.bidders-'+data.work_id);
			  var val = parseInt(el.html());
			  el.html(++val);
		  }else if(evnt.indexOf('cancel-bid')>-1){
			  var el=$('#mission-'+data.work_id).find('.bidders-'+data.work_id);
			  el.html(Math.max(0,--parseInt(el.html())));
		  }
		});

	});
	function updateTimer(){
		mins++;
		if(mins%60==0){
			//An hour passed
			$('#block-mission-list .time').each(function(){
				var time = $(this).html().split(':');
				if(time.length==1){
					if(time[0]==24){if(time[0]>0){time[0]--;time[1]='60';$(this).html(time[0]+':'+time[1]);}}else{$(this).html(time[0]);}
					var item = $(this).parent().parent().parent().parent();
					var percentage_elm = $(item).find('input[name="percent"]');
					var percentage = parseFloat(percentage_elm.val())+parseFloat($(item).find('input[name="min_to_percent"]').val());
					if(percentage>1)percentage=1;
					percentage_elm.val(percentage);
					$(item).find('.mission-progress-meter').css({'width':Math.round(216*percentage)});
				}
			});
		}
		$('#block-mission-list .time').each(function(){
				var time = $(this).html().split(':');
				if(time.length==2){
					if(time[1]<=00){if(time[0]>0){time[0]--;time[1]='59';}}else{time[1]--;}
					$(this).html(time[0]+':'+time[1]);
				}
				var item = $(this).parent().parent().parent().parent();
				var percentage_elm = $(item).find('input[name="percent"]');
				var percentage = parseFloat(percentage_elm.val())+parseFloat($(item).find('input[name="min_to_percent"]').val());
				if(percentage>1)percentage=1;
				percentage_elm.val(percentage);
				$(item).find('.mission-progress-meter').css({'width':Math.round(216*percentage)});
			});
	}
</script>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>