<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<h2>Blog Posts</h2>
			</div>
			<div class="small-12 medium-5 large-2 columns right">
			<?php if (in_array('blog_edit', $this->permission->permissions)): ?>
				<a href="<?php echo site_url('/admin/blog/add_post'); ?>" class="small button radius secondary">Add a Post</a>
			<?php endif; ?>
			</div>
		</div>

		<?php if ($blog_posts): ?>

		<?php echo $this->pagination->create_links(); ?>
			<?php foreach ($blog_posts as $post): ?>
				<div class="row pages">
					<div class="large-4 columns">
						<strong><?php echo (in_array('blog_edit', $this->permission->permissions)) ? anchor('/admin/blog/edit_post/'.$post['postID'], $post['postTitle']) : $post['postTitle']; ?></strong>
					</div>
					<div class="large-5 columns">
						<?php
							if ($post['published']) echo '<span class="published">Published</span>';
							else echo '<span class="label draft">Not Published</span>';
						?>
						<p class="posted">Posted On: <?php echo dateFmt($post['dateCreated'], '', '', TRUE); ?></p>
					</div>
					<div class="small-12 large-3 columns text-right">
						<?php if (in_array('blog_edit', $this->permission->permissions)): ?>
							<?php echo anchor('/admin/blog/edit_post/'.$post['postID'], 'Edit', array('class' => 'tiny button grey')); ?>
						<?php endif; ?>
						<?php if (in_array('blog_delete', $this->permission->permissions)): ?>
							<?php echo anchor('/admin/blog/delete_post/'.$post['postID'], 'Delete', array('class' => 'tiny alert button radius', 'onclick' => 'return confirm(\'Are you sure you want to delete this?\')')); ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		<?php echo $this->pagination->create_links(); ?>

		<?php else: ?>

		<p class="clear">There are no blog posts yet.</p>

		<?php endif; ?>
	</div> <!-- / 10 -->
</div>
