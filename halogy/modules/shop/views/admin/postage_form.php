<div class="row">
	<div class="large-12 columns body">
		<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="custom">
		
		<?php if (!$this->core->is_ajax()): ?>
			<h1 class="headingleft"><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Shipping postage</h1>
		<?php endif; ?>

		<ul class="group-button">
			<li><a href="<?php echo site_url('/admin/shop/postages'); ?>" class="button">Back to Shipping Costs</a></li>
			<li><input type="submit" value="Save Changes" class="button green nolabel" /></li>
		</ul>

		<hr>

		<?php if ($errors = validation_errors()): ?>
			<div class="error">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>

		<div class="large-6 small-12 large-centered columns">

			<div class="item">
				<label for="total">Total:</label>
				<p>When the shopping cart total reaches the given amount, then this rate will be applied.</p>
				<div class="row collapse">
					<div class="small-3 columns">
						<span class="price prefix rounded"><?php echo currency_symbol(); ?></span>
					</div>
					<div class="small-9 columns">
						<?php echo @form_input('total', $data['total'], 'class="formelement small" id="total"'); ?>
					</div>
				</div>
			</div>
				
			<div class="item">	
				<label for="cost">Cost:</label>
				<p>What do you want to charge for this rate?</p>
				<div class="row collapse">
					<div class="small-3 columns">
						<span class="price prefix rounded"><?php echo currency_symbol(); ?></span>
					</div>
					<div class="small-9 columns">
						<?php echo @form_input('cost', $data['cost'], 'class="formelement small" id="cost"'); ?>
					</div>
			</div>
		</div>
			
		</form>
	</div>
</div>