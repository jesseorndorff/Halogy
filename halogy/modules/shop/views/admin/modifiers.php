<script type="text/javascript">
$(function(){
	$.listen('click', 'a.showform', function(event){showForm(this,event);});
	$.listen('click', 'input#cancel', function(event){hideForm(this,event);});
});
</script>

<div class="row">
	<div class="large-12 columns body">

		<h1 class="headingleft">Shipping Modifiers</h1>

		<ul class="group-button">	
			<li><a href="<?php echo site_url('/admin/shop/add_modifier'); ?>" class="showform green">Add Modifier</a></li>
		</ul>

		<hr>

		<div class="hidden"></div>

		<?php if ($shop_modifiers): ?>
		<table class="default">
			<thead>
				<tr>
					<th>Multiplier</th>
					<th>Name</th>
					<th>Band</th>		
					<th class="tiny"></th>		
					<th class="tiny"></th>
				</tr>
			</thead>
			<?php foreach($shop_modifiers as $modifier): ?>
			<tbody>
				<tr>
					<td><?php echo $modifier['multiplier']; ?> <small>x</small></td>
					<td><?php echo $modifier['modifierName']; ?></td>
					<td><?php echo $modifier['bandName']; ?></td>
					<td><?php echo anchor('/admin/shop/edit_modifier/'.$modifier['modifierID'], 'Edit', 'class="showform"'); ?></td>
					<td><?php echo anchor('/admin/shop/delete_modifier/'.$modifier['modifierID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\');"'); ?></td>
				</tr>
			</tbody>
			<?php endforeach; ?>
		</table>

		<?php else: ?>

		<p>You have not yet set up any shipping modifiers yet.</p>

		<?php endif; ?>
	</div>
</div>