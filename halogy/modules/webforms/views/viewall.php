<div class="row">
	<div class="large-12 columns body">
		<div class="row">
			<div class="large-2 columns side-bar">
				<ul class="button-group">
					<li><a href="<?php echo site_url('/admin/webforms/add_form'); ?>" class="small button green"><i class="ss-icon">Add</i> Add Web Form</a></li>
				</ul>
				<?php if (in_array('webforms', $this->permission->permissions)): ?>
					<h3>Web Forms</h3>
						<ul class="side-nav">
							<li><a href="<?php echo site_url('/admin/webforms/tickets'); ?>"><i class="ss-icon">View</i> View All Tickets</a></li>
							<?php if (in_array('webforms_edit', $this->permission->permissions)): ?>
								<li class="active"><a href="<?php echo site_url('/admin/webforms/viewall'); ?>"><i class="ss-icon">Form</i> All Web Forms</a></li>
							<?php endif; ?>
						</ul>
				<?php endif; ?>
			</div>
			<div class="large-10 columns">
				<h2>Web Forms</h2>
				<ul class="breadcrumbs">
				  <li><a href="#">Home</a></li>
				  <li class="current"><a href="#">Web Forms</a></li>
				</ul>

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
			</div> <!-- /10 -->
		</div> <!-- /row -->
	</div>
</div>

