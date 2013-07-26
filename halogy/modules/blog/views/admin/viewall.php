
	<div class="large-10 columns body">
		<h2 class="left">Blog Posts</h2>
		<ul class="button-group right">
			<?php if (in_array('blog_edit', $this->permission->permissions)): ?>
				<li><a href="<?php echo site_url('/admin/blog/add_post'); ?>" class="button green"><i class="ss-icon">Add</i> Add a Post</a></li>
			<?php endif; ?>
		</ul>

		<?php if ($blog_posts): ?>

		<?php echo $this->pagination->create_links(); ?>
		
		<ul class="small-block-grid-1 large-block-grid-4">
			<?php foreach ($blog_posts as $post): ?>
			<li>
				<div class="card">
					<h3><?php echo (in_array('blog_edit', $this->permission->permissions)) ? anchor('/admin/blog/edit_post/'.$post['postID'], $post['postTitle']) : $post['postTitle']; ?></h3>
					<p class="excerpt">"Experpt text goes here. A few lines will do, maybe we limit at a few charaters."</p>
					<p class="author">Author: Jesse Orndorff</p>
					<p class="posted">Posted: <?php echo dateFmt($post['dateCreated'], '', '', TRUE); ?></p>
					<div class="card-status">
						<?php
							if ($post['published']) echo '<span class="published">Published</span>';
							else echo '<span class="not-published">Not Published</span>';
						?>
					</div>
					<div class="card-admin">
							<?php if (in_array('blog_edit', $this->permission->permissions)): ?>
								<?php echo anchor('/admin/blog/edit_post/'.$post['postID'], 'Edit'); ?>
							<?php endif; ?>
							<?php if (in_array('blog_delete', $this->permission->permissions)): ?>
								<?php echo anchor('/admin/blog/delete_post/'.$post['postID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?>
							<?php endif; ?>
					</div>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>

		<?php echo $this->pagination->create_links(); ?>


		<?php else: ?>

		<p class="clear">There are no blog posts yet.</p>

		<?php endif; ?>
	</div> <!-- / 10 -->
</div>
