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
            <li><a href="#address"><span>Address</span><img src="/public/images/codeArmy/duck/icon-address.png" alt="[address]" /></a></li><!--
            --><li><a href="#band"><span>Band</span><img src="/public/images/codeArmy/duck/icon-band.png" alt="[band]" /></a></li><!--
            --><li><a href="#calendar"><span>Calendar</span><img src="/public/images/codeArmy/duck/icon-calendar.png" alt="[calendar]" /></a></li><!--
            --><li class="active"><a href="#chat"><span>Chat</span><img src="/public/images/codeArmy/duck/icon-chat.png" alt="[chat]" /></a></li><!--
            --><li class="active"><a href="#music"><span>Music</span><img src="/public/images/codeArmy/duck/icon-music.png" alt="[music]" /></a></li><!--
            --><li><a href="#photo"><span>Photo</span><img src="/public/images/codeArmy/duck/icon-photo.png" alt="[photo]" /></a></li><!--
            --><li><a href="javascript: mission_creator_open()"><span>Create Mission</span><img src="/public/images/codeArmy/duck/icon-text.png" alt="[text]" /></a></li><!--
            --><li class="seperator"></li><!--
            --><li><a href="#folder?src=/apps/"><span>Applications</span><img src="/public/images/codeArmy/duck/icon-applications.png" alt="[apps]" /></a></li><!--
            --><li><a href="#folder?src=/pictures/"><span>Pictures</span><img src="/public/images/codeArmy/duck/icon-pictures.png" alt="[pictures]" /></a></li><!--
            --><li><a href="#folder?src=/documents/"><span>Documents</span><img src="/public/images/codeArmy/duck/icon-documents.png" alt="[documents]" /></a></li><!--
            --><li><a href="#bin"><span>Bin</span><img src="/public/images/codeArmy/duck/icon-bin.png" alt="[bin]" /></a></li>
        </ul>
    </div>
</div>

<script>
function mission_creator_open(){
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
			href : 'http://codearmy.git/missions/create',
			type : 'ajax',
			padding : 0,
			margin: 0,
			height: 600,
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
			scrolling: 'auto'
		});
	}
</script>