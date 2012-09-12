<!DOCTYPE html>
<html lang="en" ng-app>
	<head>
		<meta charset="utf-8">
		<title>Codearmy </title>
		<link href="/public/css/CodeArmyV1/bootstrap.css" media="all" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/2.0/css/font-awesome.css" />
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<style type="text/css">
			body {background: url(http://subtlepatterns.com/patterns/dark_wall.png); color:white; font-size:12px}
			.page {margin-top: 25px; min-width:1024px}
			aside {background: url(http://subtlepatterns.com/patterns/px_by_Gre3g.png); margin-bottom: 10px; border:3px solid rgba(0,0,0,.4); padding:5px 10px}
			aside i {text-shadow: 0} aside h5 {text-align:center}
			.menu i {cursor: pointer; padding:0 10px; font-size:2em; z-index:4; position:relative}
			#panel { background: #754c24; display: none; top:0; z-index:3}
			nav.top { position:absolute; top:20px; overflow:hidden; width:80%; font-size:1.1em}
			nav.top li {width:20%; text-align:center}
			nav.top li a {background:#333; height:30px; line-height:30px; color:orange}
			nav.top li a:hover {background: #2a2a2a}
			
			nav.top.child {position:absolute; top:75px; display:none; z-index:1}
			nav.top.child li a {background:#222; border: 1px solid #555}
			
			.arrow_box {
				font-size:.9em;
				position: relative;
				background: #333333;
				border: 2px solid #555555;
				margin-top:15px;
				display:none;
				text-align:left;
			}
			.arrow_box article:hover {background: #222}
			.arrow_box .user {color:orange;}
			.arrow_box .user span {float:right; font-size:.8em; color:#999}
			.arrow_box article { border-bottom:1px solid #222; padding:3px 0; cursor:pointer; padding:5px;}
			.arrow_box article:last-child {border:none; background:#393939}
			.arrow_box:after, .arrow_box:before {
				bottom: 100%;
				border: solid transparent;
				content: " ";
				height: 0;
				width: 0;
				position: absolute;
				pointer-events: none;
			}

			.arrow_box:after {
				border-color: rgba(51, 51, 51, 0);
				border-bottom-color: #333333;
				border-width: 15px;
				left: 50%;
				margin-left: -15px;
			}
			.arrow_box:before {
				border-color: rgba(85, 85, 85, 0);
				border-bottom-color: #555555;
				border-width: 18px;
				left: 50%;
				margin-left: -18px;
			}
			.cf-active {
			 font-family: 'Open Sans', serif
			}
			/** initial setup **/
			.nano {
			  position : relative;
			  overflow : hidden;
			}
			.nano .content {
			  position      : absolute;
			  overflow      : scroll;
			  overflow-x    : hidden;
			  top           : 0;
			  right         : 0;
			  bottom        : 0;
			  left          : 0;
			}
			.nano .content:focus {
			  outline: thin dotted;
			}
			.nano .content::-webkit-scrollbar {
			  visibility: hidden;
			}
			.has-scrollbar .content::-webkit-scrollbar {
			  visibility: visible;
			}
			.nano > .pane {
			  position   : absolute;
			  width      : 10px;
			  right      : 0;
			  top        : 0;
			  bottom     : 0;
			  visibility : hidden\9; /* Target only IE7 and IE8 with this hack */
			  opacity    : .01; 
			  -webkit-transition    : .2s;
			  -moz-transition       : .2s;
			  -o-transition         : .2s;
			  transition            : .2s;
			  -moz-border-radius    : 5px;
			  -webkit-border-radius : 5px;  
			  border-radius         : 5px;
			}
			.nano > .pane > .slider {
			  position              : relative;
			  margin                : 0 1px;
			  -moz-border-radius    : 3px;
			  -webkit-border-radius : 3px;  
			  border-radius         : 3px;
			}
			.nano:hover > .pane, .pane.active, .pane.flashed {
			  visibility : visible\9; /* Target only IE7 and IE8 with this hack */
			  opacity    : 0.99;
			}
			
			.nano {height:250px; width:100%}
			.nano .slider {background:rgba(0,0,0,.4)}
			.info {color:white; font-size:1.2em; text-shadow:none}
			.info span {color:orange; font-size:.8em}
			.chatbox {height:150px; background:rgba(0,0,0,.6); padding:3px;}
			.chat {height:210px} .chat input[type=text] {background:black; border:none; height:15px; margin-top:5px; width: 75%; font-size:12px;}
			.chat button {border:none; background: none; color:orange; text-shadow:0 1px 1px black}
			.showall {background: #222; height:25px; line-height:25px; text-align:center; cursor:pointer}
		</style>
	</head>

	<body class="cf-active">
		
		<div class="container-fluid page">	
			<div class="row-fluid">
				<div class="span2">
					<aside>
						<div class="logo" style="text-align:center"><img src="http://dl.dropbox.com/u/102637295/logo.png" width="140" height="126" alt="Logo"></div>
					</aside>
					<aside>
						<div class="row-fluid info">
							<div class="span4"><i class="icon-github"></i> <span>23</span></div>
							<div class="span4"><i class="icon-envelope-alt"></i> <span>9 </span></div>
							<div class="span4"><i class="icon-eye-open"></i> <span>2</span></div>
						</div>
						<img src="http://mediacdn.snorgcontent.com/media/catalog/product/g/e/geekisthenewsexy_fullpic_5.jpg" alt="" />
						<p>Level 1</p>
						<div class="progress">
						  <div class="bar" style="width: 60%;"></div>
						</div>
					</aside>
					<aside class="chat">
						<div class="clearfix">
							<div class="pull-left"><strong>Chat</strong></div>
							<div class="pull-right"><i class="icon-remove"></i></div>
						</div>
						<div class="chatbox">{{chat}}</div>
						<input type="text" ng-model="chat"/><button type="submit"><i class="icon-ok"></i></button>
					</aside>
				</div>
				
				<div class="span10" style="margin-bottom:0px">
					
					<div class="row-fluid">
						<div class="span12">
							<nav class="top">
								<ul class="nav nav-pills">
									<li><a href="#"><i class="icon-comments"></i> Messages</a>
										<div class="arrow_box clearfix">

											<div class="nano">
												<div class="content">
													<article>
														<div class="user">Code <span>Few minutes ago</span></div><div class="text">Hello World..</div>
													</article>
													<article>
														<div class="user">Army <span>Yesterday</span></div><div class="text">More coffee please.. I think we running out of stock!</div>
													</article>
													<article>
														<div class="user">Turtle <span>2 days ago</span></div><div class="text">Expecting beta version to be done this month..</div>
													</article>
													<article>
														<div class="user">Cleaner <span>11 June 2012</span></div><div class="text">I'm on leave.</div>
													</article>
													<article>
														<div class="user">Army <span>Yesterday</span></div><div class="text">More coffee please.. I think we running out of stock!</div>
													</article>
													<article>
														<div class="user">Turtle <span>2 days ago</span></div><div class="text">Expecting beta version to be done this month..</div>
													</article>
													<article>
														<div class="user">Cleaner <span>11 June 2012</span></div><div class="text">I'm on leave.</div>
													</article>
												</div>
											</div>
											<div class="showall">Show All</div>
										</div>
									</li>
									<li><a href="#"><i class="icon-bullhorn"></i> Notifications</a></li>
									<li><a href="#"><i class="icon-bar-chart"></i> Find Missions</a></li>
									<li><a href="#"><i class="icon-copy restart"></i> My Missions</a></li>
									<li><a href="#"><i class="icon-user"></i> Profile</a>
										<div class="arrow_box clearfix">
											<div class="content">
												<article><i class="icon-cog"></i> Edit profile</article>
												<article><i class="icon-signout"></i> Log out</article>
												<article></article>
											</div>
										</div>
									</li>
								</ul>
							</nav>

							<nav class="top child">
								<ul class="nav nav-pills">
									<li><a href="#">Messages</a></li>
									<li><a href="#">Notifications</a></li>
									<li><a href="#">Find Missions</a></li>
									<li><a href="#">My Missions</a></li>
									<li><a href="#">Profile</a></li>
								</ul>
							</nav>
						</div>
					</div>
					
					<div style="z-index:3; position:absolute; top:0; right:0" class="span10">
						<div id="panel">
							<iframe src="/profile" width="100%" height="100%" frameborder="0"></iframe>
						</div>
					</div>
					
					<img src="http://www.ivcmedia.co.uk/flash/resources/world-map.png" width="100%" />
					
					<div class="row-fluid" style="margin-top:-10px">
						<div class="span4">
							<nav class="menu">
								<i class="icon-bookmark"></i> <i class="icon-picture"></i> <i class="icon-briefcase"></i> <i class="icon-volume-up"></i>
								
							</nav>
						</div>
						<div class="span5" style="text-align:right">
							<form action="#" class="form-horizontal">
								Filter by
								<select name="filter" id="filter" class="span5">
									<option value="Latest">Latest</option>
									<option value="Classification">Classification</option>
									<option value="Skills">Skills</option>
									<option value="Time Estimation">Time Estimation</option>
									<option value="Payout">Payout</option>
								</select>
							</form>
						</div>
						<div class="span3" style="text-align:right">
							<input type="text" class="input-medium" placeholder="Find mission...">
						</div>
					</div>
					
					<div style="height:30px; padding:0 10px; line-height:30px; background:black; right:0; position: fixed; bottom:0" class="span12">
						<div class="pull-left">Copywrite © 2012 CodeArmy All rights reserved</div>
						<div class="pull-right" style="font-size:1.2em">
							<i class="icon-twitter"></i>
							<i class="icon-facebook"></i>
						</div>
					</div>
				</div>
				<div class="overlay" style="z-index:2; position:absolute; display:none; background: rgba(0,0,0,.8); width:100%; height:100%; top:0; left:0"></div>

			</div>
		</div>
		
	</body>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script src="http://code.angularjs.org/angular-1.0.1.min.js"></script>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/webfont/1.0.19/webfont.js"></script>
	<script type="text/javascript" src="/public/js/codeArmy/nanoscroller.js"></script>
	<script type="text/javascript" src="http://cdn.jsdelivr.net/bootstrap/2.1.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://pushly.github.com/bootstrap-tour/deps/jquery.cookie.js"></script>
	<script type="text/javascript" src="http://pushly.github.com/bootstrap-tour/bootstrap-tour.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".menu i, .overlay").click(function(){
				$("#panel").slideToggle(function(){
					$('.overlay').toggle();
				});
				$(this).toggleClass("active"); return false;
			});
			var curheight = $(window).height() * .85;
			//console.log(curheight);
			$('#panel').css('height',curheight);
			
			$('nav.top li a').click(function(){
				$(this).parent().find('.arrow_box').slideToggle(function(){
								$('.nano').nanoScroller();
				});
				//$('article:last-child').click(function(){$('.arrow_box').slideUp();})
			});
			$('article').click(function(){
				$('.arrow_box').eq(0).slideToggle();
				$('nav.top.child').slideToggle();	
			});
			
			$('.showall').click(function(){
				$('.arrow_box').eq(0).slideUp();
			})
			//$('body').click(function(){$('nav.top.child').slideToggle();})
		})
		WebFontConfig = {
		        google: { families: [ 'Tangerine','Lato', 'Cantarell','Ruda', 'Open Sans' ] }
		      };
		      (function() {
		        var cf = document.createElement('script');
		        cf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
		            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
		        cf.type = 'text/javascript';
		        cf.async = 'true';
		        var s = document.getElementsByTagName('script')[0];
		        s.parentNode.insertBefore(cf, s);
		 })();		
	</script>
	<script type="text/javascript">
	$(function(){
		var tour = new Tour();
		tour.addStep({
		  element: ".bar", /* html element next to which the step popover should be shown */
		  title: "This is indicator", /* title of the popover */
		  content: "Great for project managers to see their potential contractors" /* content of the popover */
		});
		tour.addStep({
		    element: ".chat",
		    placement: "right",
		    title: "Setup in four easy steps",
		    content: "Easy is better, right? Easy like Bootstrap.",
		    options: {
		      labels: {prev: "Go back", next: "Hey", end: "Stop"}
		    }
		  });
		tour.start();
		$(".restart").click(function (e) {
		    e.preventDefault();
		    tour.restart();
		    $(this).parents(".alert").alert("close");
		  });
	})
	</script>

</html>