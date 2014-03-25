<div class="large-12 columns body">
	<div class="card">
		<h2 class="left">Includes</h2>
		
		<div class="right">
			<a href="<?php echo site_url('/admin/pages/templates'); ?>" class="button">Templates</a>
			<a href="<?php echo site_url('/admin/pages/includes/css'); ?>" class="button">CSS</a>
			<a href="<?php echo site_url('/admin/pages/includes/js'); ?>" class="button">Javascript</a>	
			<a href="<?php echo site_url('/admin/pages/add_include'); ?>" class="button green">Add Include</a>
		</div>

		<div class="clear"></div>

			<?php if ($includes): ?>

			<?php echo $this->pagination->create_links(); ?>

			<div class="row table-header hide-for-touch">
				<div class="large-5 columns">
					<h3>Reference</h3>
				</div>
				<div class="large-5 columns">
					<h3>Date Modified</h3>
				</div>
				<div class="large-2 columns">
				</div>
			</div>
			<?php
				$i = 0;
				foreach ($includes as $include):
				$class = ($i % 2) ? 'alt' : ''; $i++;
			?>

			<div class="row table <?php echo $class;?>">
				<div class="large-5 columns">
					<p><?php echo anchor('/admin/pages/edit_include/'.$include['includeID'], $include['includeRef']); ?></p>
				</div>
				<div class="large-5 columns">
					<p><?php echo dateFmt($include['dateCreated']); ?></p>
				</div>
				<div class="large-2 columns">
					<ul class="button-group even-2">
						<li><?php echo anchor('/admin/pages/edit_include/'.$include['includeID'], 'Edit', array('class' => 'button small grey')); ?></li>
						<li><?php echo anchor('/admin/pages/delete_include/'.$include['includeID'], 'Delete', array('class' => 'button alert small', 'onClick' => 'return confirm(\'Are you sure you want to delete this?\')')); ?></li>
					</ul>
				</div>
			</div>

			<?php endforeach; ?>

			<?php echo $this->pagination->create_links(); ?>

			<?php else: ?>

			<p class="clear">You haven't made any Include files yet.</p>

		<?php endif; ?>

	</div>
</div>



