<div class="row">
	<div class="large-12 columns body">
		<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="custom">

		<?php if (!$this->core->is_ajax()): ?>
			<h1 class="headingleft"><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Shipping Band</h1>
		<?php endif; ?>

		<ul class="group-button">
			<li><a href="<?php echo site_url('/admin/shop/bands'); ?>" class="bluebutton">Back to Bands</a></li>
			<li><input type="submit" value="Save Changes" class="button green nolabel" /></li>
		</ul>

		<hr>

		<?php if ($errors = validation_errors()): ?>
			<div class="error">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>

		
		<div class="large-6 small-12 large-centered columns">
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
		</form>
	</div>
</div>

