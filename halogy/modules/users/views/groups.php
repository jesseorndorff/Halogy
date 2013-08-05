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

		<table class="default clear">
			<thead>
				<tr>
					<th><?php echo order_link('/admin/users/viewall','groupName','Group name'); ?></th>
					<th class="tiny">&nbsp;</th>
					<th class="tiny">&nbsp;</th>		
				</tr>
			</thead>
		<?php foreach ($permission_groups as $group): ?>
				<tr>
					<td><?php echo (in_array('users_groups', $this->permission->permissions)) ? anchor('/admin/users/edit_group/'.$group['groupID'], $group['groupName']) : $group['groupName']; ?></td>
					<td class="tiny">
						<?php echo anchor('/admin/users/edit_group/'.$group['groupID'], 'Edit'); ?>
					</td>
					<td class="tiny">
						<?php echo anchor('/admin/users/delete_group/'.$group['groupID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?>
					</td>
				</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->pagination->create_links(); ?>
				
		<?php else: ?>

		<p>There are no permission groups set up yet.</p>
	</div>
</div>

<?php endif; ?>