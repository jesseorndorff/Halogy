<div class="large-10 columns body">
	<div class="small-12 large-12 large-centered columns card">
		<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="">

		<?php if (!$this->core->is_ajax()): ?>
			<h2 class="left"><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Shipping Modifier</h2>
		<?php endif; ?>

		<div class="right">
			<a href="<?php echo site_url('/admin/shop/modifiers'); ?>" class="button">Back to Modifiers</a>
			<input type="submit" value="Save Changes" class="button green nolabel">
		</div>

		<div class="clear"></div>

		<?php if ($errors = validation_errors()): ?>
			<div class="error">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>

		<?php if ($bands): ?>
			
			<div class="item">
				<label for="modifierName">Name:</label>
				<?php echo @form_input('modifierName', $data['modifierName'], 'class="formelement" id="modifierName"'); ?>
			</div>

			<div class="item">
				<label for="templateID">Band:</label>
				<?php
					$options = '';
					foreach ($bands as $band):
						$options[$band['bandID']] = $band['bandName'];
					endforeach;
					
					echo @form_dropdown('bandID', $options, $data['bandID'], 'id="bandID" class="formelement"');
				?>
			</div>

			<div class="item">						
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
				
			</form>

		<?php else: ?>

		You need to create shipping bands before you can add postage modifiers.

		<?php endif; ?>

	</div>
</div>
