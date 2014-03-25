<form action="<?php echo site_url($this->uri->uri_string()); ?>" method="post" class="custom">

	<div class="large-12 columns body">

		<h2>View Ticket</h2>
		
		<ul class="group-button right">
			<li><a href="<?php echo site_url('/admin/webforms/tickets'); ?>">Back to Tickets</a></li>
			<li><input type="submit" value="Update Ticket" class="green" /></li>
		</ul>
		<ul class="breadcrumbs">
			<li><a href="#">Home</a></li>
			<li><a href="#">Web Forms</a></li>
		 	<li class="current"><a href="#">View Ticket</a></li>
		</ul>

		<div class="message">
			<p>
				<strong>Subject:</strong> [#<?php echo $data['ticketID']; ?>]:</strong> <?php echo $data['subject']; ?><br />
				<strong>Date sent:</strong> <?php echo dateFmt($data['dateCreated']); ?><br />
				<?php if ($data['formName']): ?>
					<strong>Web Form:</strong> <?php echo $data['formName']; ?>
				<?php endif; ?>
			</p>
		</div>

		<div id="tpl-2col">

			<div class="col1">
			
				<h2 class="underline">Body</h2>
			
				<p><?php echo nl2br(auto_link($data['body'])); ?></p>
				
			</div>
			<div class="col2">
			
				<h2 class="underline">User Details</h2>
			
				<p><strong>Full name:</strong> <?php echo $data['fullName']; ?></p>
				<p><strong>Email:</strong> <a href="mailto:<?php echo $data['email']; ?>?subject=Re: [#<?php echo $data['ticketID']; ?>]: <?php echo $data['subject']; ?>"><?php echo $data['email']; ?></a></p>
				
			</div>
		</div>
		
		<br />
			
		<h2 class="underline">Process Ticket</h2>

		<label for="closed">Status:</label>
		<?php
			$options = array(
					0 => 'Open',
					1 => 'Closed');
			
			echo form_dropdown('closed',$options,set_value('closed', $data['closed']),'id="closed"');
		?>

		<label for="notes">Ticket notes:</label>
		<?php echo form_textarea('notes',set_value('notes', $data['notes']), 'id="notes" class="formelement small"'); ?>
	</div>
</form>

