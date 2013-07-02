<div class="row">
	<div class="large-12 columns body">
		<div class="row">
			<div class="large-6 columns">
				<h1>Blog comments</h1>
			</div>
			<div class="large-6 columns">

			</div>
		</div>

		<?php if ($comments): ?>

		<?php echo $this->pagination->create_links(); ?>

		<table class="default clear">
			<thead>
				<tr>
					<th>Date Posted</th>
					<th>Post</th>
					<th>Author</th>
					<th>Email</th>
					<th>Comment</th>	
					<th>Status</th>
					<th class="tiny">&nbsp;</th>
					<th class="tiny">&nbsp;</th>
				</tr>
				<tbody>
					<?php foreach ($comments as $comment): ?>
						<tr>
							<td><?php echo dateFmt($comment['dateCreated']); ?></td>
							<td><?php echo anchor('/blog/'.dateFmt($comment['uriDate'], 'Y/m/').$comment['uri'], $comment['postTitle']); ?></td>
							<td><?php echo $comment['fullName']; ?></td>
							<td><?php echo $comment['email']; ?></td>
							<td><small><?php echo (strlen($comment['comment'] > 50)) ? htmlentities(substr($comment['comment'], 0, 50)).'...' : htmlentities($comment['comment']); ?></small></td>						
							<td><?php echo ($comment['active']) ? '<span style="color:green;">Active</span>' : '<span style="color:orange;">Pending</span>'; ?></td>		
							<td><?php echo (!$comment['active']) ? anchor('/admin/blog/approve_comment/'.$comment['commentID'], 'Approve') : ''; ?></td>
							<td>
								<?php echo anchor('/admin/blog/delete_comment/'.$comment['commentID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</thead>
		</table>

		<?php echo $this->pagination->create_links(); ?>

		<?php else: ?>

		<p class="clear">There are no comments yet.</p>

		<?php endif; ?>
	</div>
</div>

