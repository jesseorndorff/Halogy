<div class="row">
	<div class="large-12 columns body">
		<div class="row">
			<div class="large-6 columns">
				<h1 class="headingleft">Web Forms</h1>
			</div>
			<div class="large-6 columns">
				<ul class="button-group even-2">
					<li><a href="<?php echo site_url('/admin/webforms/tickets'); ?>" class="button">Tickets</a></li>
					<li><a href="<?php echo site_url('/admin/webforms/add_form'); ?>" class="button green">Add Form</a></li>
				</ul>
			</div>
		</div>

		<?php if ($web_forms): ?>

		<?php echo $this->pagination->create_links(); ?>

		<table class="default">
			<thead>
				<tr>
					<th><?php echo order_link('admin/webforms/viewall','formName','Form Name'); ?></th>
					<th><?php echo order_link('admin/webforms/viewall','dateCreated','Date Created'); ?></th>		
					<th class="tiny">&nbsp;</th>
					<th class="tiny">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=0;
					foreach ($web_forms as $form):
					$class = ($i % 2) ? ' class="alt"' : '';
					$i++;
				?>
					<tr<?php echo $class; ?>>
						<td>
							<?php echo anchor('/admin/webforms/edit_form/'.$form['formID'], $form['formName']); ?>
							- (<?php echo $form['formRef']; ?>)
						</td>	
						<td><?php echo dateFmt($form['dateCreated'], '', '', TRUE); ?></td>
						<td class="tiny">
							<?php echo anchor('/admin/webforms/edit_form/'.$form['formID'], 'Edit'); ?>
						</td>
						<td class="tiny">
							<?php if (in_array('webforms_delete', $this->permission->permissions)): ?>	
								<?php echo anchor('/admin/webforms/delete_form/'.$form['formID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php echo $this->pagination->create_links(); ?>

		<?php else: ?>

		<p class="clear">You have not yet set up any web forms.</p>

		<?php endif; ?>
	</div>
</div>

