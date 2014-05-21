<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="">
<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<?php if (!$this->core->is_ajax()): ?>
					<h2><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Shipping Modifier</h2>
					<a href="<?php echo site_url('/admin/shop/modifiers'); ?>" >Back to Modifiers</a>
				<?php endif; ?>
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
			<?php if ($bands): ?>
			<div class="small-12 columns item">
				<label for="modifierName">Name:</label>
				<?php echo @form_input('modifierName', $data['modifierName'], 'class="formelement" id="modifierName"'); ?>
			</div>
			<div class="small-12 columns item">
				<label for="templateID">Band:</label>
				<?php
					$options = '';
					foreach ($bands as $band):
						$options[$band['bandID']] = $band['bandName'];
					endforeach;
					
					echo @form_dropdown('bandID', $options, $data['bandID'], 'id="bandID" class="formelement"');
				?>
			</div>
			<div class="small-12 columns item">
				<label for="multiplier">Multiplier:</label>
				<div class="row collapse">
					<div class="small-1 columns">
						<?php echo @form_input('multiplier', set_value('multiplier', $data['multiplier']), 'class="formelement small" id="multiplier"'); ?>
					</div>
					<div class="small-1 pull-10 columns">
						<span class="price postfix rounded">x</span>
					</div>
				</div>
			</div>
		
			<?php else: ?>
			<div class="small-12 columns item">
				<p>You need to create shipping bands before you can add postage modifiers.</p>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
</form>