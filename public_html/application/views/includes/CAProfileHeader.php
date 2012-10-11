<?php $this->load->view('includes/CAHeader.php'); ?>
<style>
.blur{-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";filter: alpha(opacity=50);-moz-opacity: 0.5;-khtml-opacity: 0.5;opacity: 0.5;}
.hidden{display:none}
#left-block{display:none}
</style>
<div id="inner">
<div id="container" style="background:none" class="container-fluid">

    <div class="profile-header" > 
	
		
	
	<hr style="margin-top:0"/>
    <?php if(in_array($page_is,array('Profile','Missions','Achievements','Leaderboard','Invite'))):?>

	<!-- Left block -->
	<div id="left-block" style="top:10px">
		<div id="left-menu">
        	<ul>
            	<li<?php if($page_is=='Profile'){?> class="active"<?php }?>><a href="/profile"><?=($me['role']=='user')?'My Profile':'Headquarter'?></a></li>
                <li<?php if($page_is=='Missions'){?> class="active"<?php }?>><a id="missions-toggle" href="javascript:void(0)">Missions</a></li>
                <ul id="mission-submenue" <?php if($page_is!="Missions"){?>style="display:none"<?php }?>>
                    <li<?php if($action_is=='my_missions'){?> class="active"<?php }?>><a href="/missions/my_missions">My Missions</a></li>
                    <?php if($this->session->userdata('role')=='po' || $this->session->userdata('role')=='admin'){?>
                    <li<?php if($action_is=='hq'){?> class="active"<?php }?>><a href="/missions/tallent_map">World Map</a></li>
                    <?php }else{?>
                    <li><a href="/missions">Find Mission</a></li>
                    <?php }?>
                    <li<?php if($action_is=='bid'){?> class="active"<?php }?>><a href="/missions/bid">Bid</a></li>
                    <li<?php if($action_is=='completed'){?> class="active"<?php }?>><a href="/missions/completed">Completed</a></li>
                </ul>
                <li<?php if($page_is=='Achievements'){?> class="active"<?php }?>><a href="/achievements">Achievements</a></li>
                <li<?php if($page_is=='Leaderboard'){?> class="active"<?php }?>><a href="/leaderboard">Leaderboard</a></li>
                <li<?php if($page_is=='Invite'){?> class="active"<?php }?>><a href="/invite">Invite friends</a></li>
            </ul>
        </div>
    </div>
    <?php endif;?>
    <?php if(in_array($page_is,array('Messages'))):?>
	
    <div id="left-block">
		<div id="left-menu">
        	<ul>
            	<li<?php if($action_is=='compose'){?> class="active"<?php }?>><a href="/messages/compose">Compose</a></li>
                <li<?php if(in_array($action_is,array('inbox','read'))){?> class="active"<?php }?>><a href="/messages/inbox">Inbox</a></li>
                <li<?php if($action_is=='important'){?> class="active"<?php }?>><a href="/messages/important">Important</a></li>
                <li<?php if($action_is=='sent'){?> class="active"<?php }?>><a href="/messages/sent">Sent</a></li>
                <li<?php if($action_is=='archive'){?> class="active"<?php }?>><a href="/messages/archive">Archive</a></li>
                <li<?php if($action_is=='trash'){?> class="active"<?php }?>><a href="/messages/trash">Trash</a></li>
            </ul>
            <img onclick="document.search_form.submit();" style="margin:30px; cursor:pointer; display:block" src="/public/images/codeArmy/messages/temp_srch.png"/>
            <?php echo form_open('messages/search', array('name'=>'search_form')); ?>
            <?php if (isset($form_error)){ ?>
            <div id="msg-search-err"><?=form_error("msg-search")?></div>
            <input type="text" name="msg-search" id="msg-search" value="<?=set_value('msg-search')?>" />
            <?php } else { ?>
            <input onfocus="this.value=''" onblur="if(this.value=='')this.value='Search message'" type="text" name="msg-search" id="msg-search" value="Search message"/>
            <?php } ?>
            </form>
        </div>
    </div>
    <?php endif;?> 
    <?php if(in_array($page_is,array('About','FAQ','Contact', 'Term'))):?>
    <div id="left-block">
		<div id="left-menu">
        	<ul>
            	<li<?php if($page_is=='About'){?> class="active"<?php }?>><a href="/about">About us</a></li>
                <li<?php if($page_is=='Contact'){?> class="active"<?php }?>><a href="/contact">Contact us</a></li>
                <li<?php if($page_is=='FAQ'){?> class="active"<?php }?>><a href="/faq">FAQ's</a></li>
                <li<?php if($action_is=='Term'){?> class="active"<?php }?>><a href="/term">T&amp;C</a></li>
            </ul>
        </div>
    </div>
    <?php endif;?>
    <div id="main-content" style="margin-top:0; overflow:hidden; padding-top:10px">
	
	<script src="../../../public/js/codeArmy/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../../../public/js/codeArmy/horizontalNav.js" type="text/javascript" charset="utf-8"></script>
	<script src="../../../public/js/codeArmy/cookie.js" type="text/javascript" charset="utf-8"></script>
	
	<script type="text/javascript">
	$(function(){
		//New nav function
		
		var cname = 'nav', 
		chname = 'child',
		coption = {expires: 1, path: '/'},
		cook = $.cookie(cname),
		chook = $.cookie(chname);
		console.log(chook);
		
		if (!cook){ 
			$('.topnav > li').eq(0).find('a').addClass('active');
		} else {
			$('.topnav > li').eq(cook).find('a').addClass('active');
			$('.topnav > li').eq(cook).find('.child').show().find('.childnav a').removeClass('active');
			
			if(!chook){
				$('.topnav .childnav li').eq(0).find('a').addClass('active');
			} else {
				$('.topnav > li').eq(cook).find('.childnav li').eq(chook).find('a').addClass('active');
			}
			
		}
		
		$('.topnav li').bind({
			click : function(e){
				e.preventDefault;
				var self = $(this), index = self.index();
				$.cookie(cname, index, coption);
				$.cookie(chname, null);
			}
		})
		
		$('.topnav .childnav li').bind({
			click : function(){
				var self = $(this), index = self.index();
				$.cookie(chname, index, coption);
			}
		})
		
		$('.profile-setting').bind({
			click : function(){
				$('.arrow_box').slideToggle();
			}
		});
		
		$('.filter .all').mouseenter(function(){
			$(this).next().slideDown('fast');
		});	
		
		$('.filter .filterwrap').mouseleave(function(){
			$(this).slideUp('fast');
		});
		
		$('.child').horizontalNav();
	});
	
	</script>