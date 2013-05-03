<script type="text/javascript">
function refresh(){
	$('div.loader').load('<?php echo site_url('/admin/tracking_ajax'); ?>');
	timeoutID = setTimeout(refresh, 5000);
}

$(function(){
	timeoutID = setTimeout(refresh, 0);
});
</script>

<div class="row">

	<div class="large-12 columns header">

		<h1>Most Recent Visits</h1> 
		
		<a class="button" href="<?php echo site_url('/admin'); ?>">Back to Dashboard</a>
	</div>
</div>

<div class="row">
	<div class="large-12 columns body">
		<div class="loader"></div>
	</div>
</div>