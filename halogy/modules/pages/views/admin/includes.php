<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<h2>Includes</h2>
			</div>
		
			<div class="large-6 small-12 columns right">
				<a href="<?php echo site_url('/admin/pages/templates'); ?>" class="small button radius">Templates</a>
				<a href="<?php echo site_url('/admin/pages/includes/css'); ?>" class="small button radius">CSS</a>
				<a href="<?php echo site_url('/admin/pages/includes/js'); ?>" class="small button radius">Javascript</a>	
				<a href="<?php echo site_url('/admin/pages/add_include'); ?>" class="small button secondary radius">Add Include</a>
			</div>
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
					<?php echo anchor('/admin/pages/edit_include/'.$include['includeID'], 'Edit', array('class' => 'tiny button grey')); ?>
					<?php echo anchor('/admin/pages/delete_include/'.$include['includeID'], 'Delete', array('class' => 'tiny button alert radius', 'onClick' => 'return confirm(\'Are you sure you want to delete this?\')')); ?>
				</div>
			</div>

			<?php endforeach; ?>

			<?php echo $this->pagination->create_links(); ?>

			<?php else: ?>

			<p class="clear">You haven't made any Include files yet.</p>

		<?php endif; ?>

	</div>
</div>



