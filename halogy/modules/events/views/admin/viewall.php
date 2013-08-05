<div class="large-10 columns body">
	<div class="card">
		<h2 class="left">Events</h2>

		<div class="right">
			<?php if (in_array('events_edit', $this->permission->permissions)): ?>
				<a href="<?php echo site_url('/admin/events/add_event'); ?>" class="button green">Add Event</a>
			<?php endif; ?>
		</div>

		<div class="clear"></div>

		<?php if ($events): ?>

		<?php echo $this->pagination->create_links(); ?>

		<table class="default clear">
			<thead>
				<tr>
					<th><?php echo order_link('/admin/events/viewall','eventtitle','Event'); ?></th>
					<th><?php echo order_link('/admin/events/viewall','location','Location'); ?></th>		
					<th><?php echo order_link('/admin/events/viewall','eventDate','Event Start'); ?></th>
					<th><?php echo order_link('/admin/events/viewall','eventEnd','Event End'); ?></th>
					<th>Active</th>
					<th class="tiny">&nbsp;</th>
					<th class="tiny">&nbsp;</th>
				</tr>
			</thead>
		<?php foreach ($events as $event): ?>
			<tbody>
				<tr>
					<td><?php echo (in_array('events_edit', $this->permission->permissions)) ? anchor('/admin/events/edit_event/'.$event['eventID'], $event['eventTitle']) : $event['eventTitle']; ?></td>
					<td><?php echo $event['location']; ?></td>		
					<td><?php echo dateFmt($event['eventDate'], '', FALSE); ?></td>
					<td><?php echo dateFmt($event['eventEnd'], '', FALSE); ?></td>
					<td>
						<?php
							if (strtotime($event['eventDate']) < time()) echo 'No';
							else echo 'Yes';
						?>
					</td>
					<td class="tiny">
						<?php if (in_array('events_edit', $this->permission->permissions)): ?>
							<?php echo anchor('/admin/events/edit_event/'.$event['eventID'], 'Edit'); ?>
						<?php endif; ?>
					</td>
					<td class="tiny">			
						<?php if (in_array('events_delete', $this->permission->permissions)): ?>
							<?php echo anchor('/admin/events/delete_event/'.$event['eventID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?>
						<?php endif; ?>
					</td>
				</tr>
			</tbody>
		<?php endforeach; ?>
		</table>

		<?php echo $this->pagination->create_links(); ?>

		<?php else: ?>

		<p class="clear">There are no events yet.</p>

		<?php endif; ?>

	</div>
</div>