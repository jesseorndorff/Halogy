<script type="text/javascript">
$(function(){
	$.listen('click', 'a.showform', function(event){showForm(this,event);});
	$.listen('click', 'input#cancel', function(event){hideForm(this,event);});
});
</script>

<div class="row">
	<div class="large-12 columns body">

		<h1 class="headingleft">Shipping Bands</h1>

		<ul class="group-button">	
			<li><a href="<?php echo site_url('/admin/shop/add_band'); ?>" class="showform button green">Add Band</a></li>
		</ul>

		<hr>

		<div class="hidden"></div>

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