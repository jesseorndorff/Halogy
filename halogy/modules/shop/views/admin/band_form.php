	<div class="large-10 columns body">
		<div class="small-12 large-8 large-centered columns card">
			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="custom">

				<?php if (!$this->core->is_ajax()): ?>
					<h2 class="left"><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Shipping Band</h1>
				<?php endif; ?>

				<div class="right">
					<a href="<?php echo site_url('/admin/shop/bands'); ?>" class="button">Back to Bands</a>
					<input type="submit" value="Save Changes" class="button green nolabel"/>
				</div>

				<div class="clear"></div>

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

