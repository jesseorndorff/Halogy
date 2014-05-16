<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="custom">
<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<?php if (!$this->core->is_ajax()): ?>
					<h2><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Shipping postage</h2>
				<?php endif; ?>
				<a href="<?php echo site_url('/admin/shop/postages'); ?>" >Back to Shipping Costs</a>
			</div>
			<div class="large-6 small-12 columns right">
				<input type="submit" value="Save Changes" class="button small radius success nolabel">
			</div>
		</div>
		<div class="row table">
			<div class="small-12 columns">
				<?php if ($errors = validation_errors()): ?>
					<div class="error">
						<?php echo $errors; ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="small-12 columns item">
				<label for="total">Total:</label>
				<p>When the shopping cart total reaches the given amount, then this rate will be applied.</p>
				<div class="row collapse">
					<div class="small-1 columns">
						<span class="price prefix rounded"><?php echo currency_symbol(); ?></span>
					</div>
					<div class="small-3 pull-8 columns">
						<?php echo @form_input('total', $data['total'], 'class="formelement small" id="total"'); ?>
					</div>
				</div>
			</div>
			<div class="small-12 columns item">
				<label for="cost">Cost:</label>
				<p>What do you want to charge for this rate?</p>
				<div class="row collapse">
					<div class="small-1 columns">
						<span class="price prefix rounded"><?php echo currency_symbol(); ?></span>
					</div>
					<div class="small-3 pull-8 columns">
						<?php echo @form_input('cost', $data['cost'], 'class="formelement small" id="cost"'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>