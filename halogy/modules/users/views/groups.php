<div class="large-10 columns body">
	<div class="card">
		<h2 class="left">User Groups</h2>
		<div class="right">
			<?php if (in_array('users', $this->permission->permissions)): ?>
				<a href="<?php echo site_url('/admin/users'); ?>" class="button">Users</a>
			<?php endif; ?>
			<?php if (in_array('users_groups', $this->permission->permissions)): ?>
				<a href="<?php echo site_url('/admin/users/add_group'); ?>" class="button green">Add Group</a>
			<?php endif; ?>
		</div>

		<div class="clear"></div>
		<?php if ($permission_groups): ?>

		<?php echo $this->pagination->create_links(); ?>

			<div class="row table-header hide-for-touch">
				<div class="large-10 columns">
					<h3><?php echo order_link('/admin/users/viewall','groupName','Group name'); ?></h3>
				</div>
				<div class="large-2 columns">
				</div>
			</div>

		<?php 
			$i=0;
			foreach ($permission_groups as $group):
			$class = ($i % 2) ? 'alt' : ''; $i++;
		?>
			<div class="row table <?php echo $class;?>">
				<div class="large-10 columns">
					<p><?php echo (in_array('users_groups', $this->permission->permissions)) ? anchor('/admin/users/edit_group/'.$group['groupID'], $group['groupName']) : $group['groupName']; ?></p>
				</div>
				<div class="large-2 columns">
					<ul class="button-group even-2">
						<li><?php echo anchor('/admin/users/edit_group/'.$group['groupID'], 'Edit', array('class' => 'button small grey')); ?></li>
						<li><?php echo anchor('/admin/users/delete_group/'.$group['groupID'], 'Delete', array('class' => 'button alert small', 'onClick' => 'return confirm(\'Are you sure you want to delete this?\')')); ?></li>
					</ul>
				</div>
			</div>

		<?php endforeach; ?>

		<?php echo $this->pagination->create_links(); ?>
				
		<?php else: ?>

		<p>There are no permission groups set up yet.</p>
	</div>
</div>

<?php endif; ?>