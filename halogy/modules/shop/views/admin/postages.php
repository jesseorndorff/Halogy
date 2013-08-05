<script type="text/javascript">
$(function(){
	$.listen('click', 'a.showform', function(event){showForm(this,event);});
	$.listen('click', 'input#cancel', function(event){hideForm(this,event);});
});
</script>

<div class="large-10 columns body">
	<div class="card">
		<h2 class="left">Shipping Costs</h2>

		<div class="right">	
			<a href="<?php echo site_url('/admin/shop/add_postage'); ?>" class="showform green button">Add Shipping Rate</a>
		</div>

		<div class="clear"></div>

		<div class="hidden"></div>

		<?php if ($shop_postages): ?>

		<div class="row table-header hide-for-touch">
			<div class="large-5 columns">
				<h3>Total</h3>
			</div>
			<div class="large-5 columns">
				<h3>Cost</h3>
			</div>
			<div class="large-2 columns">
			</div>
		</div>
		<?php foreach($shop_postages as $postage): ?>
		<div class="row table">
			<div class="large-5 columns">
				<p><?php echo currency_symbol(); ?><?php echo number_format($postage['total'], 2); ?></p>
			</div>
			<div class="large-5 columns">
				<p><?php echo currency_symbol(); ?><?php echo number_format($postage['cost'], 2); ?></p>
			</div>
			<div class="large-2 columns">
				<ul class="button-group even-2">
					<li><?php echo anchor('/admin/shop/edit_postage/'.$postage['postageID'], 'Edit', 'class="showform"'); ?></li>
					<li><?php echo anchor('/admin/shop/delete_postage/'.$postage['postageID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\');"'); ?></li>
				</ul>
			</div>
		</div>
		<?php endforeach; ?>

		<?php else: ?>

		<p>You have not yet set up your shipping costs yet.</p>

		<?php endif; ?>
	</div>
</div>