<div class="row">
	<div class="large-12 columns header">
		<h1 class="headingleft">User Groups</h1>
		<ul class="group-button">
			<?php if (in_array('users_groups', $this->permission->permissions)): ?>
				<li><a href="<?php echo site_url('/admin/users/add_group'); ?>" class="green">Add Group</a></li>
			<?php endif; ?>
			<?php if (in_array('users', $this->permission->permissions)): ?>
				<li><a href="<?php echo site_url('/admin/users'); ?>" class="thebutton">Users</a></li>
			<?php endif; ?>
		</ul>
	</div>
</div>

<?php if ($permission_groups): ?>

<?php echo $this->pagination->create_links(); ?>

<div class="row">
	<div class="large-12 columns body">
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

	</div>
</div>

<?php echo $this->pagination->create_links(); ?>
		
<?php else: ?>
<div class="row">
	<div class="large-12 columns body">
		<p>There are no permission groups set up yet.</p>
	</div>
</div>

<?php endif; ?>