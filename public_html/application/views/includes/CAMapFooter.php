<div id="footer" style="float:none; height:30px;">
  <div id="social-links">
    <div style="display:block; width:75px;float:left">Follow us on</div>
    <a target="_blank" id="facebook" href="http://www.facebook.com/CodeArmyHQ">Facebook</a> <a id="twitter" target="_blank" href="https://twitter.com/#!/Code_Army">Twitter</a> </div>
  <ul id="footer_links">
    <li><a href="/contact">Contact us</a></li>
    <li><a href="/faq">FAQ's</a></li>
    <li><a href="/blog" target="_blank">Blog</a></li>
    <li><a href="/term">T&amp;C</a></li>
    <!--<li><a href="javascript:var firebug=document.createElement('script');firebug.setAttribute('src','http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js');document.body.appendChild(firebug);(function(){if(window.firebug.version){firebug.init();}else{setTimeout(arguments.callee);}})();void(firebug);">Firebug Lite</a></li>-->
  </ul>
  <div id="copywrite">Copywrite &copy; 2012 CodeArmy All rights reserved</div>
</div>
<div id="debugger" style="background: rgba(20,40,0,0.9); position:absolute;top:0;left:0;text-align:left;display:none;">
	<h2>Console:</h2>
	<?php echo "<pre style=\"border: 1px solid #000; overflow: auto; margin: 2em;\">"; ?>
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++++++Session Values++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    <?php echo nl2br(var_export($this->session->userdata,true)); ?>
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ++++++++++++++++++++PASSED Variables++++++++++++++++++++++++++
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	<?php echo nl2br(var_export($this->_ci_cached_vars,true)); ?>
    <?php echo "</pre>\n";?>
</div>

</div>
<script>
	$('#dropdown-button').click(function(){$('#dropdown').slideToggle('fast');})
	$('#logo').click(function(){window.location="/profile"});
	$('#missions-toggle').click(function(){$('#mission-submenue').slideToggle();});
	function loadEffect(){}
</script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32075842-1']);
  _gaq.push(['_trackPageview']);

  (function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript" src="/public/js/codeArmy/footer.js"></script>