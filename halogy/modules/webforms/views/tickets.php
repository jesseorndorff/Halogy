<script language="javascript" type="text/javascript">
$(function(){
	$('select#filter').change(function(){
		var status = ($(this).val());
		window.location.href = '<?php echo site_url('/admin/webforms/tickets'); ?>/'+status;
	});	
});
</script>

	<div class="large-10 columns body">
		<h2 class="left">Tickets <?php if ($status) echo ' - ('.$status.')'?> </h2>
		<div class="right">
			<a href="<?php echo site_url('/admin/webforms/viewall'); ?>" class="button"><i class="ss-icon">View</i> View Web Forms</a>
		</div>
		<div class="clear"></div>
		<div class="large-4 columns push-8">
			<label for="filter">
				Filter
			</label>

			<?php
				$options[''] = 'View All';
				$options['open'] = 'Open';
				$options['closed'] = 'Closed';

				$options['-'] = '--------------------';

				if ($webforms)
				{
					foreach($webforms as $form)
					{
						$options[$form['formID']] = $form['formName'];
					}
				}
				
				echo form_dropdown('filter', $options, $this->uri->segment(4), 'id="filter"');
			?>
		</div>

		<?php if ($tickets): ?>

		<?php echo $this->pagination->create_links(); ?>

		<table class="default">
			<thead>
				<tr>
					<th><?php echo order_link('admin/webforms/tickets','subject','Subject'); ?></th>
					<th><?php echo order_link('admin/webforms/tickets','dateCreated','Date'); ?></th>
					<th><?php echo order_link('admin/webforms/tickets','formName','Web Form'); ?></th>		
					<th><?php echo order_link('admin/webforms/tickets','status','Status'); ?></th>		
					<th><?php echo order_link('admin/webforms/tickets','fullName','Name'); ?></th>
					<th><?php echo order_link('admin/webforms/tickets','email','Email'); ?></th>
					<th class="tiny">&nbsp;</th>
					<th class="tiny">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=0;
					foreach ($tickets as $ticket):
					$class = ($i % 2) ? ' class="alt"' : ''; 
					$style = (!$ticket['viewed']) ? ' style="font-weight: bold;"' : '';
					$i++;
				?>
					<tr<?php echo $class; ?><?php echo $style; ?>>
						<td><?php echo anchor('/admin/webforms/view_ticket/'.$ticket['ticketID'], '[#'.$ticket['ticketID'].']: '.$ticket['subject']); ?></td>	
						<td><?php echo dateFmt($ticket['dateCreated'], '', '', TRUE); ?></td>
						<td><?php echo ($ticket['formName']) ? anchor('/admin/webforms/viewall', $ticket['formName']) : ''; ?></td>
						<td><?php echo ($ticket['closed']) ? 'Closed' : 'Open'; ?></td>
						<td><?php echo $ticket['fullName']; ?></td>
						<td><?php echo $ticket['email']; ?></td>		
						<td class="tiny">
							<?php echo anchor('/admin/webforms/view_ticket/'.$ticket['ticketID'], 'Edit'); ?>
						</td>
						<td class="tiny">
							<?php if (in_array('webforms_tickets', $this->permission->permissions)): ?>	
								<?php echo anchor('/admin/webforms/delete_ticket/'.$ticket['ticketID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
		</tbody>
		</table>

		<?php echo $this->pagination->create_links(); ?>

		<?php else: ?>

		<p class="clear">There are no tickets here yet.</p>

		<?php endif; ?>
	</div> <!-- /10 -->
