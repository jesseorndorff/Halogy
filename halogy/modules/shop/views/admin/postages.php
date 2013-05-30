<script type="text/javascript">
$(function(){
	$.listen('click', 'a.showform', function(event){showForm(this,event);});
	$.listen('click', 'input#cancel', function(event){hideForm(this,event);});
});
</script>

<div class="row">
	<div class="large-12 columns body">

		<h1 class="headingleft">Shipping Costs</h1>

		<ul class="group-button">	
			<li><a href="<?php echo site_url('/admin/shop/add_postage'); ?>" class="showform green">Add Shipping Rate</a></li>
		</ul>

		<hr>

		<div class="hidden"></div>

		<?php if ($shop_postages): ?>
		<table class="default">
			<thead>
				<tr>
					<th>Total</th>
					<th>Cost</th>
					<th class="tiny"></th>		
					<th class="tiny"></th>
				</tr>
			</thead>
			<?php foreach($shop_postages as $postage): ?>
			<tbody>
				<tr>
					<td><?php echo currency_symbol(); ?><?php echo number_format($postage['total'], 2); ?></td>
					<td><?php echo currency_symbol(); ?><?php echo number_format($postage['cost'], 2); ?></td>
					<td><?php echo anchor('/admin/shop/edit_postage/'.$postage['postageID'], 'Edit', 'class="showform"'); ?></td>
					<td><?php echo anchor('/admin/shop/delete_postage/'.$postage['postageID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\');"'); ?></td>
				</tr>
			</tbody>
			<?php endforeach; ?>
		</table>

		<?php else: ?>

		<p>You have not yet set up your shipping costs yet.</p>

		<?php endif; ?>
	</div>
</div>