
			<div id="halogycms_browser" class="loading"></div>

	</div>


<footer>
	<div class="row">
		<div class="large-12 columns">
		<hr>
			<p class="copyright">Powered by <a href="http://www.halogy.com" title="Halogy">Halogy</a></p>
		</div>
	</div>
</footer>

</div>

	<!-- Check for Zepto support, load jQuery if necessary -->
	<script>
	  document.write('<script src=<?php echo $this->config->item('staticPath'); ?>/js/vendor/'
	    + ('__proto__' in {} ? 'zepto' : 'jquery')
	    + '.js><\/script>');
	</script>
	<script>
		$(document).foundation('topbar')
  	</script>

</body>
</html>