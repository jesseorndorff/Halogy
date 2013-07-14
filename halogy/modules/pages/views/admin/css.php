<div class="large-10 columns body">
	<h2>CSS Files</h2>
	
	<ul class="button-group even-4 right">
		<li><a href="<?php echo site_url('/admin/pages/templates'); ?>" class="button">Templates</a></li>
		<li><a href="<?php echo site_url('/admin/pages/includes'); ?>" class="button">Includes</a></li>
		<li><a href="<?php echo site_url('/admin/pages/includes/js'); ?>" class="button">Javascript</a></li>	
		<li><a href="<?php echo site_url('/admin/pages/add_include/css'); ?>" class="button green">Add CSS</a></li>
	</ul>
	<ul class="breadcrumbs">
		<li><a href="#">Home</a></li>
		<li><a href="#">Templates</a></li>
		<li class="current"><a href="#">CSS</a></li>
	</ul>
		<?php if ($includes): ?>

		<?php echo $this->pagination->create_links(); ?>

		<div class="row table-header hide-for-touch">
			<div class="large-10 columns">
				<h3>File Name</h3>
			</div>
			<div class="large-2 columns">
			</div>
		</div>
			
		<?php
			$i = 0;
			foreach ($includes as $include):
			$class = ($i % 2) ? ' class="alt"' : ''; $i++;
		?>

			<div class="row table <?php echo $class;?>">
				<div class="large-10 columns">
					<p><?php echo anchor('/admin/pages/edit_include/'.$include['includeID'], $include['includeRef']); ?><p>
				</div>
				<div class="large-2 columns">
					<ul class="button-group even-2">
						<li><?php echo anchor('/admin/pages/edit_include/'.$include['includeID'], 'Edit', array('class' => 'button small grey')); ?></li>
						<li><?php echo anchor('/admin/pages/delete_include/'.$include['includeID'].'/css', 'Delete', array('class' => 'button alert small', 'onClick' => 'return confirm(\'Are you sure you want to delete this?\')')); ?></li>
					</ul>
				</div>
			</div>
		<?php endforeach; ?>

		<?php echo $this->pagination->create_links(); ?>

		<?php else: ?>

		<p class="clear">You haven't made any CSS files yet.</p>

		<?php endif; ?>
	</div>
</div>

