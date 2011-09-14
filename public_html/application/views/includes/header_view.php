<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?php echo $window_title; ?></title>
	<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>-->
	<!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
    <script type="text/javascript" src="<?php echo base_url() ?>public/scripts/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>public/scripts/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>public/scripts/jquery.uniform.js" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>public/scripts/login.js" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>public/scripts/script.js"></script>
	<script type="text/javascript" charset="utf-8">
	  $(function(){
        $("input, textarea, select, button").uniform();
      });
    </script>
	
	
  	<link href='<?php echo base_url() ?>public/styles/style.css' rel='stylesheet' />
    <link media="screen" rel="stylesheet" href="<?php echo base_url() ?>public/styles/colorbox.css" />
    <link href='<?php echo base_url() ?>public/styles/uniform.default.css' rel='stylesheet' media="screen">
    <link href='<?php echo base_url() ?>public/styles/inettuts.css' rel="stylesheet" type="text/css" />
    <link href='<?php echo base_url() ?>public/styles/inettuts.js.css' rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url() ?>public/scripts/colorbox/jquery.colorbox.js" charset="utf-8"></script>
</head>

<body>
	<div id='container'>
	<div id='top-nav'>
		<a href="<?php echo base_url() ?>" id="dashboardButton"><span>Dashboard</span></a>

		<?php if($this->session->userdata('is_logged_in') == true): ?>
		<a href="<?php echo base_url() ?>works" id="dashboardButton"><span>My Works</span></a>
        <a href="<?php echo base_url() ?>works" id="dashboardButton"><span>Inbox</a>
		<a href="<?php echo base_url() ?>profile" id="dashboardButton"><span>Profile</span></a>
		<a href="<?php echo base_url() ?>dashboard/feedback" id="dashboardButton"><span>Feedback</span></a>
		<?php else: ?>
		
		<a href="<?php echo base_url() ?>signup" id="sign-upButton"><span>Sign Up</span></a>
		
		<?php endif; ?>	
		
		<a href="http://blog.motionworks.com.my" id="dashboardButton" target="_blank"><span>Blog</span></a>
			
		<?php if($this->session->userdata('is_logged_in') == false) { ?>	
		<div id="loginContainer"> 
        <a href="#" id="loginButton"><span>Login</span><em></em></a> 
                <div style="clear:both"></div> 
                <div id="loginBox">
	
	                <?php echo form_open('login/validate_credentials', array('id' => 'loginForm')); ?>
                    
                        <fieldset id="body"> 
                            <fieldset> 
                                <label for="username">Username</label> 
                                <input type="text" name="username" id="username" /> 
                            </fieldset> 
                            <fieldset> 
                                <label for="password">Password</label> 
                                <input type="password" name="password" id="password" /> 
                            </fieldset> 
                            <input type="submit" id="login" value="Sign in" /> 
                            <!-- <label for="checkbox"><input type="checkbox" id="checkbox" />Remember me</label> --> 
                        </fieldset> 
                        <!-- <span><a href="#">Forgot your password?</a></span> -->
					
					<?php echo form_close(); ?>
 					
                </div> 
            </div>
		<?php }
		else { ?>
		<div id="loginContainer"> 
        	<?php $ci =& get_instance(); ?>
        	You are logged in as "<?php print $ci->session->userdata('username') ?>"</div>
			<a href="<?php echo base_url() ?>login/logout" id="dashboardButton"><span>Logout</span></a>
		</div>
		<?php }
		?>
		</div>
		
		<div id="header">
			<div id="workpad-logo" onClick="window.location.href = '<?php echo base_url() ?>'"></div>
			<h3>Spread the work ...</h3>
		</div>