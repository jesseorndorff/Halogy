<div class="row">
	<div class="large-12 columns body">
		<h1 class="headingleft">Javascript Files</h1>

		<ul class="group-button">
			<li><a href="<?php echo site_url('/admin/pages/templates'); ?>" class="bluebutton">Templates</a></li>
			<li><a href="<?php echo site_url('/admin/pages/includes'); ?>" class="bluebutton">Includes</a></li>
			<li><a href="<?php echo site_url('/admin/pages/includes/css'); ?>" class="bluebutton">CSS</a></li>
			<li><a href="<?php echo site_url('/admin/pages/add_include/js'); ?>" class="green">Add Javascript</a></li>
		</ul>
		<hr>

		<?php if ($includes): ?>

		<?php echo $this->pagination->create_links(); ?>

		<table class="default clear">
			<thead>
				<tr>
					<th>Filename</th>
					<th class="tiny">&nbsp;</th>
					<th class="tiny">&nbsp;</th>
				</tr>
			</thead>
		<?php
			$i = 0;
			foreach ($includes as $include):
			$class = ($i % 2) ? ' class="alt"' : ''; $i++;
		?>
			<tbody>
				<tr<?php echo $class;?>>
					<td><?php echo anchor('/admin/pages/edit_include/'.$include['includeID'], $include['includeRef']); ?></td>	
					<td>
						<?php echo anchor('/admin/pages/edit_include/'.$include['includeID'], 'Edit'); ?>
					</td>
					<td>			
						<?php echo anchor('/admin/pages/delete_include/'.$include['includeID'].'/js', 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?>
					</td>
				</tr>
			</tbody>
		<?php endforeach; ?>
		</table>

		<?php echo $this->pagination->create_links(); ?>

		<?php else: ?>

		<p class="clear">You haven't made any Javascript files yet.</p>

		<?php endif; ?>
	</div>
</div>


