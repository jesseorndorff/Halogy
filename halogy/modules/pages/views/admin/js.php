<div class="row">
	<div class="large-12 columns body">
		<div class="row">
			<div class="large-6 columns">
				<h1 class="headingleft">Javascript Files</h1>
			</div>
			<div class="large-6 columns">
				<ul class="button-group even-4">
					<li><a href="<?php echo site_url('/admin/pages/templates'); ?>" class="button">Templates</a></li>
					<li><a href="<?php echo site_url('/admin/pages/includes'); ?>" class="button">Includes</a></li>
					<li><a href="<?php echo site_url('/admin/pages/includes/css'); ?>" class="button">CSS</a></li>
					<li><a href="<?php echo site_url('/admin/pages/add_include/js'); ?>" class="button green">Add Javascript</a></li>
				</ul>
			</div>
		</div>
		<hr>

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
							<li><?php echo anchor('/admin/pages/delete_include/'.$include['includeID'].'/js', 'Delete', array('class' => 'button alert small', 'onClick' => 'return confirm(\'Are you sure you want to delete this?\')')); ?></li>
						</ul>
					</div>
				</div>
			<?php endforeach; ?>

		<?php echo $this->pagination->create_links(); ?>

		<?php else: ?>

		<p class="clear">You haven't made any Javascript files yet.</p>

		<?php endif; ?>
	</div>
</div>


