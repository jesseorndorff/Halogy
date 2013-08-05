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

<div class="large-10 columns body">
	<div class="card">
		<h2 class="left">Upsells</h2>

		<div class="right">	
			<a href="<?php echo site_url('/admin/shop/add_upsell'); ?>" class="showform button green">Add Upsell</a>
		</div>

		<div class="clear"></div>

		<div class="hidden"></div>

		<?php if ($shop_upsells): ?>

		<form method="post" action="<?php echo site_url('/admin/shop/edit_upsell'); ?>">

			<ol class="order">
			<?php $x=0; foreach ($shop_upsells as $upsell): $x++; ?>
				<li id="shop_upsells-<?php echo $upsell['upsellID']; ?>">
					<div class="small-buttons large-2 columns">
						<a href="<?php echo site_url('/admin/shop/edit_upsell/'.$upsell['upsellID']); ?>" class="showform button small">Edit</a>
						<a href="<?php echo site_url('/admin/shop/delete_upsell/'.$upsell['upsellID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="button alert small">Delete</a>
					</div>
					<div class="col1 large-5 columns">			
						<span>
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
						</span>
					</div>
					<div class="col2 large-5 columns">
						Upsell
							<?php if ($upsellProduct = $this->shop->get_product($upsell['productID'])): ?>
								<strong><?php echo $upsellProduct['productName']; ?></strong>
							<?php else: ?>
								<strong>N/A</strong>
							<?php endif; ?>
						<?php if ($upsell['remove']): ?>
							and <strong>remove original products</strong>
						<?php endif; ?>
					</div>

				</li>
			<?php endforeach; ?>
			</ol>

		</form>

		<?php else: ?>

		<p>You haven't set up any Upsells yet.</p>

		<?php endif; ?>
	</div>
</div>
