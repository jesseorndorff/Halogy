<style type="text/css">
.ac_results { padding: 0px; border: 1px solid black; background-color: white; overflow: hidden; z-index: 99999; }
.ac_results ul { width: 100%; list-style-position: outside; list-style: none; padding: 0; margin: 0; }
.ac_results li { margin: 0px; padding: 2px 5px; cursor: default; display: block; font: menu; font-size: 12px; line-height: 16px; overflow: hidden; }
.ac_results li span.email { font-size: 10px; } 
.ac_loading { background: white url('<?php echo $this->config->item('staticPath'); ?>/images/loader.gif') right center no-repeat; }
.ac_odd { background-color: #eee; }
.ac_over { background-color: #0A246A; color: white; }
</style>

<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.fieldreplace.js"></script>
<script type="text/javascript">
function setOrder(){
	$.post('<?php echo site_url('/admin/shop/order/product'); ?>',$(this).sortable('serialize'),function(data){ });
};
var fixHelper = function (e, a) {
	if ($(this).is('tbody')) {
		a.children().each(function () {
			$('table.order .' + $(this).attr('class')).width($(this).width())
		})
	}
	return a
};
function initOrder(el){
	$(el).sortable({ 
		axis: 'y',
	    revert: false, 
	    delay: '80',
	    opacity: '0.5',
	    update: setOrder,
		helper: fixHelper
	});
};
function formatItem(row){
	if (row[0].length) return row[1]+'<br /><span class="email">(#'+row[0]+')</span>';
	else return 'No results';
}
$(function(){
    $('#searchbox').fieldreplace();
	$('#searchbox').autocomplete("<?php echo site_url('/admin/shop/ac_products'); ?>", { delay: "0", selectFirst: false, matchContains: true, formatItem: formatItem, minChars: 2 });
	$('#searchbox').result(function(event, data, formatted){
		$(this).parent('form').submit();
	});
	
	$('select#category').change(function(){
		var folderID = ($(this).val());
		window.location.href = '<?php echo site_url('/admin/shop/products'); ?>/'+folderID;
	});	
	
	initOrder('table.order tbody');	
});
</script>
<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<h2>Products</h2>
			</div>
			<div class="large-6 small-12 columns right">
				<?php if (in_array('shop_edit', $this->permission->permissions)): ?>	
					<a href="<?php echo site_url('/admin/shop/add_product'); ?>" class="button small radius success">Add Product</a>
				<?php endif; ?>
			</div>
		</div>
		<div class="row table">
			<div class="small-12 columns">
				<?php if ($products): ?>

				<?php echo $this->pagination->create_links(); ?>

				<div class="row table-header hide-for-touch <?php echo ($catID) ? ' order' : ''; ?>">
					<div class="large-2 columns">
						<h3><?php echo order_link('admin/shop/products'.(($catID) ? '/'.$catID : ''),'productName','Product name', (($catID) ? 5 : 4)); ?></h3>
					</div>
					<div class="large-1 columns">
						<h3><?php echo order_link('admin/shop/products'.(($catID) ? '/'.$catID : ''),'subtitle','Subtitle', (($catID) ? 5 : 4)); ?></h3>
					</div>
					<div class="large-2 columns">
						<h3><?php echo order_link('admin/shop/products'.(($catID) ? '/'.$catID : ''),'catalogueID','Catalogue ID', (($catID) ? 5 : 4)); ?></h3>
					</div>
					<div class="large-2 columns">
						<h3><?php echo order_link('admin/shop/products'.(($catID) ? '/'.$catID : ''),'dateCreated','Date added', (($catID) ? 5 : 4)); ?></h3>
					</div>
					<div class="large-2 columns">
						<h3><?php echo order_link('admin/shop/products'.(($catID) ? '/'.$catID : ''),'price','Price ('.currency_symbol().')', (($catID) ? 5 : 4)); ?></h3>
					</div>
					<?php if ($this->site->config['shopStockControl']): ?>
						<div class="large-1 columns">
							<h3><?php echo order_link('/admin/shop/products'.(($catID) ? '/'.$catID : ''),'stock','Stock', (($catID) ? 5 : 4)); ?></h3>
						</div>
					<?php endif; ?>
					<div class="large-1 columns">
						<h3><?php echo order_link('/admin/shop/products'.(($catID) ? '/'.$catID : ''),'published','Published', (($catID) ? 5 : 4)); ?></h3>
					</div>
					<div class="large-2 columns">
					</div>
				</div>
				<?php foreach ($products as $product): ?>
				<div class="row table <?php echo (!$product['published']) ? 'draft' : ''; ?>" id="shop_products-<?php echo $product['productID']; ?>">
					<div class="large-2 columns">
						<p><?php echo (in_array('shop_edit', $this->permission->permissions)) ? anchor('/admin/shop/edit_product/'.$product['productID'], $product['productName']) : $product['productName']; ?></p>
					</div>
					<div class="large-1 columns">
						<p><?php echo $product['subtitle']; ?></p>
					</div>
					<div class="large-2 columns">
						<p><?php echo $product['catalogueID']; ?></p>
					</div>
					<div class="large-2 columns">
						<p><?php echo dateFmt($product['dateCreated'], '', '', TRUE); ?></p>
					</div>
					<div class="large-2 columns">
						<p><?php echo currency_symbol(); ?><?php echo number_format($product['price'],2); ?></p>
					</div>
					<?php if ($this->site->config['shopStockControl']): ?>
						<div class="large-1 columns">
							<p><?php echo ($product['stock'] > 0) ? '<span style="color:green;">'.$product['stock'].'</span>' : '<span style="color:red;">'.$product['stock'].'</span>'; ?></p>
						</div>
					<?php endif; ?>
					<div class="large-1 columns">
						<p>			
							<?php
									if ($product['published']) echo '<span style="color:green;">Yes</span>';
									else echo 'No';
								?>
						</p>
					</div>
					<div class="large-2 columns">
						<ul class="button-group even-2">
						<?php if (in_array('shop_edit', $this->permission->permissions)): ?>	
							<li><?php echo anchor('/admin/shop/edit_product/'.$product['productID'], 'Edit'); ?></li>
						<?php endif; ?>
						<?php if (in_array('shop_delete', $this->permission->permissions)): ?>	
							<li><?php echo anchor('/admin/shop/delete_product/'.$product['productID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?></li>
						<?php endif; ?>
						</ul>
					</div>
				</div>
				<?php endforeach; ?>
				

				<?php echo $this->pagination->create_links(); ?>

				<?php else: ?>

				<p>No products were found.</p>


				<?php endif; ?>
			</div>
		</div>
	</div>
</div>