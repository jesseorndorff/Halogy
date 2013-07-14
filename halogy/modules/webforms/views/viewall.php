<div class="large-10 columns body">
	<h2>Web Forms</h2>
	<ul class="button-group right">
		<li><a href="<?php echo site_url('/admin/webforms/add_form'); ?>" class="button green"><i class="ss-icon">Add</i> Add Web Form</a></li>
	</ul>
	<ul class="breadcrumbs">
		<li><a href="#">Home</a></li>
	 	<li class="current"><a href="#">Web Forms</a></li>
	</ul>


	<?php if ($web_forms): ?>

	<?php echo $this->pagination->create_links(); ?>
	<div class="row table-header hide-for-touch">
		<div class="large-5 columns">
			<h3>Form Name</h3>
		</div>
		<div class="large-5 columns">
			<h3>Date Created</h3>
		</div>
		<div class="large-2 columns">
		</div>
	</div>

	<?php
		$i=0;
		foreach ($web_forms as $form):
		$class = ($i % 2) ? 'alt' : '';
		$i++;
	?>
	<div class="row table <?php echo $class;?>">
		<div class="large-5 columns">
			<p><?php echo anchor('/admin/webforms/edit_form/'.$form['formID'], $form['formName']); ?> - (<?php echo $form['formRef']; ?>)</p>
		</div>
		<div class="large-5 columns"><p>
			<?php echo dateFmt($form['dateCreated'], '', '', TRUE); ?></p>
		</div>
		<div class="large-2 columns">
			<ul class="button-group even-2">
				<li><?php echo anchor('/admin/webforms/edit_form/'.$form['formID'], 'Edit', array('class' => 'button small grey')); ?></li>
					<?php if (in_array('webforms_delete', $this->permission->permissions)): ?>	
						<li><?php echo anchor('/admin/webforms/delete_form/'.$form['formID'], 'Delete', array('class' => 'button alert small', 'onClick' => 'return confirm(\'Are you sure you want to delete this?\')')); ?></li>
					<?php endif; ?>
			</ul>
		</div>
	</div>
		<?php endforeach; ?>


	<?php echo $this->pagination->create_links(); ?>

	<?php else: ?>

	<p class="clear">You have not yet set up any web forms.</p>

	<?php endif; ?>

</div>

