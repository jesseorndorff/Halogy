<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<h2>Blog Comments</h2>
			</div>
			<div class="large-6 small-12 columns right"></div>
		</div>
		<div class="row table">
			<div class="small-12 columns item">
				<?php if ($comments): ?>

				<?php echo $this->pagination->create_links(); ?>

				<ul class="small-block-grid-1 large-block-grid-1">
					<?php foreach ($comments as $comment): ?>
						<li>
							<div class="card">
								<h3><?php echo anchor('/blog/'.dateFmt($comment['uriDate'], 'Y/m/').$comment['uri'], $comment['postTitle']); ?></h3>
								<p class="excerpt">"<?php echo (strlen($comment['comment'] > 5)) ? htmlentities(substr($comment['comment'], 0, 5)).'...' : htmlentities($comment['comment']); ?>"</p>
								<p class="author">Comment by: <?php echo $comment['fullName']; ?></p>
								<p class="posted">Posted: <?php echo dateFmt($comment['dateCreated']); ?></p>
								<div class="card-status">
									<?php echo ($comment['active']) ? '<span class="published">Active</span>' : '<span class="not-published">Active</span>Pending</span>'; ?>
								</div>
								<div class="card-admin">
									<?php echo (!$comment['active']) ? anchor('/admin/blog/approve_comment/'.$comment['commentID'], 'Approve') : ''; ?>
									<?php echo anchor('/admin/blog/delete_comment/'.$comment['commentID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?>
								</div>
							</div>
						</li>					
					<?php endforeach; ?>
				</ul>

				<?php echo $this->pagination->create_links(); ?>

				<?php else: ?>

				<p class="clear">There are no comments yet.</p>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>