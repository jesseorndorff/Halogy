<script type="text/javascript">
$(function(){
	$.listen('click', 'a.showform', function(event){showForm(this,event);});
	$.listen('click', 'input#cancel', function(event){hideForm(this,event);});
});
</script>

<div class="large-10 columns body">
	<div class="card">
		<h2 class="left">Shipping Modifiers</h2>

		<div class="right">	
			<a href="<?php echo site_url('/admin/shop/add_modifier'); ?>" class="showform green">Add Modifier</a>
		</div>

		<div class="clear"></div>

		<div class="hidden"></div>

		<?php if ($shop_modifiers): ?>
		<div class="row table-header hide-for-touch">
			<div class="large-2 columns">
				<h3>Multiplier</h3>
			</div>
			<div class="large-4 columns">
				<h3>Name</h3>
			</div>
			<div class="large-4 columns">
				<h3>Band</h3>
			</div>
			<div class="large-2 columns">
			</div>			
		</div>
			<?php foreach($shop_modifiers as $modifier): ?>
			<div class="row table">
				<div class="large-2 columns">
					<p><?php echo $modifier['multiplier']; ?> x</p>
				</div>
				<div class="large-4 columns">
					<p><?php echo $modifier['modifierName']; ?></p>
				</div>
				<div class="large-4 columns">
					<p><?php echo $modifier['bandName']; ?></p>
				</div>
				<div class="large-2 columns">
					<ul class="button-group even-2">
						<li><?php echo anchor('/admin/shop/edit_modifier/'.$modifier['modifierID'], 'Edit', 'class="showform"'); ?></li>
						<li><?php echo anchor('/admin/shop/delete_modifier/'.$modifier['modifierID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\');"'); ?></li>
					</ul>
				</div>
			</div>
			<?php endforeach; ?>

		<?php else: ?>

		<p>You have not yet set up any shipping modifiers yet.</p>

		<?php endif; ?>
	</div>
</div>