<script type="text/javascript">
function setOrder(){
	$.post('<?php echo site_url('/admin/shop/order/cat'); ?>',$(this).sortable('serialize'),function(data){ });
};

function initOrder(el){
	$(el).sortable({ 
		axis: 'y',
	    revert: false, 
	    delay: '80',
	    opacity: '0.5',
	    update: setOrder
	});
};

$(function(){
	initOrder('ol.order, ol.order ol');
});
</script>
<div class="row">
	<div class="large-12 columns body">
		<h1 class="headingleft">Shop Categories</h1>

		<ul class="group-button">	
			<li><a href="<?php echo site_url('/admin/shop/products'); ?>" class="bluebutton">View Products</a></li>
			<li><a href="<?php echo site_url('/admin/shop/add_cat'); ?>" class="showform green">Add Category</a></li>
		</ul>

		<hr>

		<div class="hidden"></div>

		<?php if ($parents): ?>

		<form method="post" action="<?php echo site_url('/admin/shop/edit_cat'); ?>">

			<ol class="order">
			<?php foreach ($parents as $cat): ?>
				<li id="shop_cats-<?php echo $cat['catID']; ?>" class="<?php echo (@$children[$cat['catID']]) ? 'haschildren' : ''; ?>">
					<div class="small-buttons large-2 columns">
						<a href="<?php echo site_url('/admin/shop/edit_cat/'.$cat['catID']); ?>" class="showform button small">Edit</a>
						<a href="<?php echo site_url('/admin/shop/delete_cat/'.$cat['catID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="button alert small">Delete</a>
					</div>
					<div class="col1 large-10 columns">			
						<span><strong><?php echo $cat['catName']; ?></strong></span>
						<small>(<?php echo $cat['catSafe']; ?>)</small>
					</div>
					
					<?php if (@$children[$cat['catID']]): ?>
						<ol class="subcat">
						<?php foreach ($children[$cat['catID']] as $child): ?>
							<li id="shop_cats-<?php echo $child['catID']; ?>">
								<div class="small-buttons large-2 columns">
									<a href="<?php echo site_url('/admin/shop/edit_cat/'.$child['catID']); ?>" class="showform button small">Edit</a>
									<a href="<?php echo site_url('/admin/shop/delete_cat/'.$child['catID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="button alert small">Delete</a>
								</div>
								<div class="col1 large-10 columns">
									<span class="padded">--</span>
									<span><strong><?php echo $child['catName']; ?></strong></span>
								</div>

							</li>
						<?php endforeach; ?>
						</ol>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
			</ol>
		</form>

		<?php else: ?>

		<p>You haven't set up any shop categories yet.</p>

		<?php endif; ?>
	</div>
</div>
