<!-- Note: comments are used between icons to remove white-space when display inline-block is used -->
<!--[if lte IE 7]>
<style>
/* Inline block fix */
#dock ul {
	display: inline;
	zoom: 1;
}

#dock li, #dock li a {
	display: inline;
	zoom: 1;
}

/* Image quality fix */
img {
	-ms-interpolation-mode: bicubic;
}

#dock li a span {
	filter: alpha(opacity=40);
}
</style>
<![endif]-->
<div id="duck-wrapper">
    <div id="dock">
        <ul>
            <li><a href="/messages/inbox"><span>Messages</span><img src="/public/images/codeArmy/duck/icon-address.png" alt="[address]" /></a></li><!--
            --><li><a href="/achievements"><span>Achievements</span><img src="/public/images/codeArmy/duck/icon-band.png" alt="[band]" /></a></li><!--
            --><li><a href="/leaderboard"><span>Leaderboard</span><img src="/public/images/codeArmy/duck/icon-calendar.png" alt="[calendar]" /></a></li><!--
            --><li class="active"><a href="javascript:void(0)" onclick="$('.chat-box').fadeToggle('fast')"><span>Chat</span><img src="/public/images/codeArmy/duck/icon-chat.png" alt="[chat]" /></a></li><!--
            <li class="active"><a href="#music"><span>Music</span><img src="/public/images/codeArmy/duck/icon-music.png" alt="[music]" /></a></li><!--
            --><li><a href="/profile"><span>Profile</span><img src="/public/images/codeArmy/duck/icon-profile.png" alt="[profile]" /></a></li><!--
-->
<!-- <li><a href="javascript: mission_creator_open()"><span>Create Mission</span><img src="/public/images/codeArmy/duck/icon-text.png" alt="[text]" /></a></li> -->
<li><a href = "javascript:void(0)" class="create_mission"><span>Create Mission</span><img src="/public/images/codeArmy/duck/icon-text.png" alt="[text]" /></a></li>
<!--
            --><li class="seperator"></li><!--
            --><li><a href="javascript:void(0)" onclick="ToggleMyMissions(this)"><span>My Missions</span><img src="/public/images/codeArmy/duck/icon-applications.png" alt="[apps]" /></a></li><!--
           <li><a href="/missions/bid"><span>My Bids</span><img src="/public/images/codeArmy/duck/icon-pictures.png" alt="[pictures]" /></a></li><!--
            --><li><a href="javascript:void(0)" onclick="ToggleCompleted(this)"><span>Completed</span><img src="/public/images/codeArmy/duck/icon-documents.png" alt="[documents]" /></a></li><!--
            <li><a href="#bin"><span>Bin</span><img src="/public/images/codeArmy/duck/icon-bin.png" alt="[bin]" /></a></li>-->
        </ul>
    </div>
</div>
<style type="text/css">
	.nano { height:550px; width:100%}
	.nano .content { padding: 10px; }
	.nano .slider { background: #555; }
</style>
<script>
var myMissions = false, $box, $boxSelector;
//lets close the folder wrapper if user clicks outside of it
$(function(){
	$box = $('#folder-wrapper');
	$box.addClass('nano');
	$(document.body).click(function(e){
		if ($box.is(':visible') && !($boxSelector.has(e.target).length || $box.has(e.target).length)) { // if the click was not within $box
			$box.hide('fast');
		}
	});
});
function ToggleMyMissions(me){
	$boxSelector = $(me);
	var boxContainer = $('.content',$box);
	if(!$box.is(':visible')){
		//fetch the data
		$.ajax({
			url:'/missions/Ajax_myMissions',
			data:{},
			type:'get',
			dataType:'json',
			success: function(data){
				boxContainer.html('');
				$(data).each(function(){
						var status = this.status.toLowerCase();
						ref = "/missions/manage/";
						if($.inArray(status,['in progress','done','redo','signoff','verify'])>-1)ref = "/missions/wall/";
						switch(status){
						 case 'draft': icon = 'icon-pencil';break;
						 case 'in progress': icon = 'icon-cogs';break;
						 default: icon = 'icon-globe';
						}
						boxContainer.append('<a class="mission-icon '+this.status+'" href="'+ref+this.work_id+'"><div class="'+icon+'"></div>'+this.title+'</a>');
					});
				boxContainer.append('<a class="mission-icon-more" href="/missions/my_missions"><div class="icon-share-alt"></div>Open MyMissions</a>');
				$('.mission-icon').dotdotdot();
				$box.nanoScroller();
			}
		});
	}
	$box.find('.arrow').css('left',491);
	$box.toggle('fast');
}

function ToggleCompleted(me){
	$boxSelector = $(me);
	var boxContainer = $('.content',$box);
	if(!$box.is(':visible')){
		//fetch the data
		$.ajax({
			url:'/missions/Ajax_completedMissions',
			data:{},
			type:'get',
			dataType:'json',
			success: function(data){
				boxContainer.html('');
				$(data).each(function(){
						var status = this.status.toLowerCase();
						ref = "/missions/manage/";
						if($.inArray(status,['in progress','done','redo','signoff','verify'])>-1)ref = "/missions/wall/";
						switch(status){
						 case 'draft': icon = 'icon-pencil';break;
						 case 'in progress': icon = 'icon-cogs';break;
						 default: icon = 'icon-globe';
						}
						boxContainer.append('<a class="mission-icon '+this.status+'" href="'+ref+this.work_id+'"><div class="'+icon+'"></div>'+this.title+'</a>');
					});
				boxContainer.append('<a class="mission-icon-more" href="/missions/completed"><div class="icon-share-alt"></div>Open Completed</a>');
				$('.mission-icon').dotdotdot();
				$box.nanoScroller();
			}
		});
	}
	$box.find('.arrow').css('left',530);
	$box.toggle('fast');
}

function mission_creator_open(){
	$('#category>option').attr('selected', false);
	$('#category>option:first').attr('selected', true);
	$('#category').selectmenu({'width':'202', 'style':'popup'});
	$.fancybox.showLoading()
	$.fancybox.open({
		href : '#mission_creator',
		type : 'inline',
		padding : 0,
		margin: 0,
		autoSize: true,
		'overlayShow': true,
		'overlayOpacity': 0.5, 
		afterClose: function(){},
		openMethod : 'dropIn',
		openSpeed : 250,
		closeMethod : 'dropOut',
		closeSpeed : 150,
		nextMethod : 'slideIn',
		nextSpeed : 250,
		prevMethod : 'slideOut',
		prevSpeed : 250,
		scrolling: 'no'
	});
}

//******************************Mission Creator****************************/
	function MissionCreate(category){
		$.fancybox.showLoading()
		$.fancybox.close();
		$.fancybox.open({
			//type: 'inline',
			data:{},
			href : 'http://<?=$_SERVER['HTTP_HOST']?>/missions/create/'+category,
			type : 'iframe',
			padding : 0,
			margin: 0,
			height: 600,
			autoSize: false,
			width:760,
			'overlayShow': true,
			'overlayOpacity': 0.5, 
			afterClose: function(){},
			openMethod : 'dropIn',
			openSpeed : 250,
			closeMethod : 'dropOut',
			closeSpeed : 150,
			nextMethod : 'slideIn',
			nextSpeed : 250,
			prevMethod : 'slideOut',
			prevSpeed : 250,
			scrolling: 'no'
		});
	}
</script>