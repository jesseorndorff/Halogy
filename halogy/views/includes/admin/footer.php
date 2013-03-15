
			<div id="halogycms_browser" class="loading"></div>

	</div>


	<div id="footer" class="content">

		<div class="container">

		
			<p class="copyright">Powered by <a href="http://www.halogy.com" title="Halogy">Halogy</a></p>
			
			<br />
			
			<a href="http://www.halogy.com"><img src="<?php echo $this->config->item('staticPath'); ?>/images/halogy_marque.gif" alt="Powered by Halogy" /></a>


		</div>

	</div>

</div>

	<!-- Check for Zepto support, load jQuery if necessary -->
	<script>
	  document.write('<script src=<?php echo $this->config->item('staticPath'); ?>/js/vendor/'
	    + ('__proto__' in {} ? 'zepto' : 'jquery')
	    + '.js><\/script>');
	</script>
	
</body>
</html>