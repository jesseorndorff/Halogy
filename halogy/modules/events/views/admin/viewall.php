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

			<div class="row table-header hide-for-touch">
				<div class="large-2 columns">
					<h3><?php echo order_link('/admin/events/viewall','eventtitle','Event'); ?></h3>
				</div>
				<div class="large-2 columns">
					<h3><?php echo order_link('/admin/events/viewall','location','Location'); ?></h3>
				</div>
				<div class="large-2 columns">
					<h3><?php echo order_link('/admin/events/viewall','eventDate','Event Start'); ?></h3>
				</div>
				<div class="large-2 columns">
					<h3><?php echo order_link('/admin/events/viewall','eventEnd','Event End'); ?></h3>
				</div>
				<div class="large-2 columns">
					<h3>Active</h3>
				</div>
				<div class="large-2 columns">
				</div>
			</div>

		<?php 
			$i = 0;
			foreach ($events as $event): 
			$class = ($i % 2) ? 'alt' : ''; $i++;
		?>

			<div class="row table <?php echo $class;?>">
				<div class="large-2 columns">
					<p><?php echo (in_array('events_edit', $this->permission->permissions)) ? anchor('/admin/events/edit_event/'.$event['eventID'], $event['eventTitle']) : $event['eventTitle']; ?></p>
				</div>
				<div class="large-2 columns">
					<p><?php echo $event['location']; ?></p>
				</div>
				<div class="large-2 columns">
					<p><?php echo dateFmt($event['eventDate'], '', FALSE); ?></p>
				</div>
				<div class="large-2 columns">
					<p><?php echo dateFmt($event['eventEnd'], '', FALSE); ?></p>
				</div>
				<div class="large-2 columns">
					<p>					
						<?php
							if (strtotime($event['eventDate']) < time()) echo 'No';
							else echo 'Yes';
						?>
					</p>
				</div>
				<div class="large-2 columns">
					<ul class="button-group even-2">
						
						<?php if (in_array('events_edit', $this->permission->permissions)): ?>
							<li><?php echo anchor('/admin/events/edit_event/'.$event['eventID'], 'Edit', array('class' => 'button small grey')); ?></li>
						<?php endif; ?>
						<?php if (in_array('events_delete', $this->permission->permissions)): ?>
							<li><?php echo anchor('/admin/events/delete_event/'.$event['eventID'], 'Delete', array('class' => 'button alert small', 'onClick' => 'return confirm(\'Are you sure you want to delete this?\')')); ?></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			
		<?php endforeach; ?>

		<?php echo $this->pagination->create_links(); ?>

		<?php else: ?>

		<p class="clear">There are no events yet.</p>

		<?php endif; ?>

	</div>
</div>