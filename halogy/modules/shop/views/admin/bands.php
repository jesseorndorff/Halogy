<script type="text/javascript">
$(function(){
	$.listen('click', 'a.showform', function(event){showForm(this,event);});
	$.listen('click', 'input#cancel', function(event){hideForm(this,event);});
});
</script>
<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<h1>Shipping Bands</h1>
			</div>
			<div class="large-6 small-12 columns right">
				<a href="<?php echo site_url('/admin/shop/add_band'); ?>" class="button small radius success showform">Add Band</a>
			</div>
		</div>
		<div class="row table">
			<div class="small-12 columns item">
				<?php if ($shop_bands): ?>
				<table class="default">
					<thead>
						<tr>
							<th>Multiplier</th>
							<th>Name</th>
							<th class="tiny"></th>		
							<th class="tiny"></th>
						</tr>
					</thead>
					<?php foreach($shop_bands as $band): ?>
					<tbody>
						<tr>
							<td><?php echo $band['multiplier']; ?> <small>x</small></td>
							<td><?php echo $band['bandName']; ?></td>
							<td><?php echo anchor('/admin/shop/edit_band/'.$band['bandID'], 'Edit', 'class="showform"'); ?></td>
							<td><?php echo anchor('/admin/shop/delete_band/'.$band['bandID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\');"'); ?></td>
						</tr>
					</tbody>
					<?php endforeach; ?>
				</table>

				<?php else: ?>

				<p>You have not yet set up any shipping bands yet.</p>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>