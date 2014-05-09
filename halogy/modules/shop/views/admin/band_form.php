<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="custom">
<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<?php if (!$this->core->is_ajax()): ?>
					<h2><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Shipping Band</h1>				<?php endif; ?>
				<a href="<?php echo site_url('/admin/shop/bands'); ?>">Back to Bands</a>
			</div>
			<div class="large-6 small-12 columns right">
				<input type="submit" value="Save Changes" class="button small radius success nolabel"/>
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
			<div class="small-12 columns">
				<label for="bandName">Name:</label>
				<?php echo @form_input('bandName', $data['bandName'], 'class="formelement" id="bandName"'); ?>
					
				<label for="multiplier">Multiplier:</label>
				<div class="row collapse">
					<div class="small-2 columns">
						<?php echo @form_input('multiplier', $data['multiplier'], 'class="formelement small" id="multiplier"'); ?>
					</div>
					<div class="small-2 pull-8 columns">
						<span class="price postfix rounded">x</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>