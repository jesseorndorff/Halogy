<script type="text/javascript">
function setOrder(){
	$.post('<?php echo site_url('/admin/shop/order/upsell'); ?>',$(this).sortable('serialize'),function(data){ });
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

<form method="post" action="<?php echo site_url('/admin/shop/edit_upsell'); ?>">
<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<h2>Upsells</h2>
			</div>
			<div class="large-6 small-12 columns right">
				<a href="<?php echo site_url('/admin/shop/add_upsell'); ?>" class="button small radius showform">Add Upsell</a>
			</div>
		</div>
		<div class="row table">
			<div class="small-12 columns item">
				<?php if ($shop_upsells): ?>
					<div class="order">
					<?php $x=0; foreach ($shop_upsells as $upsell): $x++; ?>
						<div id="shop_upsells-<?php echo $upsell['upsellID']; ?>">
							<div class="col1 large-6 columns">			
								<p>
									<?php echo $x; ?>.
									If
									<?php if ($upsell['type'] == 'V'): ?>
										the <strong>value of the cart</strong>
										is greater than <strong><?php echo currency_symbol(); ?><?php echo number_format($upsell['value'], 2); ?></strong>:
									<?php elseif ($upsell['type'] == 'N'): ?>
										the <strong>number of products in the cart</strong>
										is greater than <strong><?php echo $upsell['numProducts']; ?></strong>:
									<?php else: ?>
										<?php $products = explode(',', $upsell['productIDs']); ?>
										<?php foreach($products as $product): ?>
											<?php
												$productString = '';
												if ($row = $this->shop->get_product($product)) $productString .= $row['productName'].', ';
											?>
											<?php if ($productString): ?>
												<strong><?php echo substr($productString, 0, -2); ?></strong>
											<?php else: ?>
												<strong>N/A</strong>
											<?php endif; ?>
										<?php endforeach; ?>
										is in the cart:
									<?php endif; ?>
								</p>
							</div>
							<div class="col2 large-3 columns">
								<p>Upsell
									<?php if ($upsellProduct = $this->shop->get_product($upsell['productID'])): ?>
										<strong><?php echo $upsellProduct['productName']; ?></strong>
									<?php else: ?>
										<strong>N/A</strong>
									<?php endif; ?>
								<?php if ($upsell['remove']): ?>
									and <strong>remove original products</strong>
								<?php endif; ?></p>
							</div>
							<div class="large-3 columns">
								<ul class="button-group even-2">
									<li><a href="<?php echo site_url('/admin/shop/edit_upsell/'.$upsell['upsellID']); ?>" class="showform edit small">Edit</a></li>
									<li><a href="<?php echo site_url('/admin/shop/delete_upsell/'.$upsell['upsellID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="small">Delete</a></li>
								</ul>
							</div>
						</div>
						<div class="clear"></div>
					<?php endforeach; ?>
					</div>

				</form>

				<?php else: ?>

				<p>You haven't set up any Upsells yet.</p>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
</form>