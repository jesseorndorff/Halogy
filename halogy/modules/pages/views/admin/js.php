<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<h2>Javascript Files</h2>
			</div>
			<div class="large-6 small-12 columns right">
				<a href="<?php echo site_url('/admin/pages/templates'); ?>" class="small button radius">Templates</a>
				<a href="<?php echo site_url('/admin/pages/includes'); ?>" class="small button radius">Includes</a>
				<a href="<?php echo site_url('/admin/pages/includes/css'); ?>" class="small button radius">CSS</a>
				<a href="<?php echo site_url('/admin/pages/add_include/js'); ?>" class="small button secondary radius">Add Javascript</a>
			</div>
		</div>

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
						$class = ($i % 2) ? 'alt' : ''; $i++;
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


