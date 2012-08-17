<!-- Chat box -->
<div class="chat">
<ul>
	<li><b>Ramin</b>: Hi how are you?</li>
    <li><b>Robin</b>: Fine thanks.</li>
</ul>
</div>
<style>
.chat {
background: white;
border: 1px solid black;
width: 190px;
height: 230px;
position: absolute;
bottom: 40px;
right: 30px;
z-index: 10001;
color: black;
display:none;
}
</style>
<!-- /Chat box-->
<script type="text/javascript">
  var logged_user_id = '<?=$this->session->userdata('user_id')?>';
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

</body>
</html>