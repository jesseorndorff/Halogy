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
<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<h2>Shop Categories</h2>
			</div>
			<div class="large-6 small-12 columns right">
				<a href="<?php echo site_url('/admin/shop/products'); ?>" class="button small radius">View Products</a>
				<a href="<?php echo site_url('/admin/shop/add_cat'); ?>" class="showform success button small radius">Add Category</a>
			</div>
		</div>
		<div class="row table">
			<div class="small-12 columns">
				<?php if ($parents): ?>

				<form method="post" action="<?php echo site_url('/admin/shop/edit_cat'); ?>">

					<div class="order">
					<?php foreach ($parents as $cat): ?>
						<div id="shop_cats-<?php echo $cat['catID']; ?>" class="large-12 columns table <?php echo (@$children[$cat['catID']]) ? 'haschildren' : ''; ?>">
			
							<div class="col1 large-9 columns">			
								<span class="cat-name"><strong><?php echo $cat['catName']; ?></strong>
								<small>(<?php echo $cat['catSafe']; ?>)</small></span>
							</div>

							<div class="large-3 columns">
								<ul class="button-group even-2">
									<li><a href="<?php echo site_url('/admin/shop/edit_cat/'.$cat['catID']); ?>" class="showform">Edit</a></li>
									<li><a href="<?php echo site_url('/admin/shop/delete_cat/'.$cat['catID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="">Delete</a></li>
								</ul>
							</div>
							
							<?php if (@$children[$cat['catID']]): ?>
								<div class="subcat">
								<?php foreach ($children[$cat['catID']] as $child): ?>
									<div id="shop_cats-<?php echo $child['catID']; ?>" class="large-12 columns table">
										<div class="col1 large-9 columns">
											<span class="cat-name padded">--</span>
											<span class="cat-name"><strong><?php echo $child['catName']; ?></strong></span>
										</div>
										<div class="large-3 columns">
											<ul class="button-group even-2">
												<li><a href="<?php echo site_url('/admin/shop/edit_cat/'.$child['catID']); ?>" class="showform">Edit</a></li>
												<li><a href="<?php echo site_url('/admin/shop/delete_cat/'.$child['catID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="">Delete</a></li>
											</ul>
										</div>
									</div>
								<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
					</div>
				</form>

				<?php else: ?>

				<p>You haven't set up any shop categories yet.</p>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>