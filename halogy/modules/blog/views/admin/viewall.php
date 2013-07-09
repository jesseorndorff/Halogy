<div class="row">
	<div class="large-12 columns body">
		<div class="row">
			<div class="large-2 columns side-bar">
				<ul class="button-group">
					<?php if (in_array('blog_edit', $this->permission->permissions)): ?>
						<li><a href="<?php echo site_url('/admin/blog/add_post'); ?>" class="small button green"><i class="ss-icon">Add</i> Add a Post</a></li>
					<?php endif; ?>
				</ul>
				<?php if (in_array('blog', $this->permission->permissions)): ?>
					<h3>BLOG</h3>
						<ul class="side-nav">
							<?php if (in_array('blog', $this->permission->permissions)): ?>
								<li class="active"><a href="<?php echo site_url('/admin/blog/viewall'); ?>"><i class="ss-icon">Page</i> All Posts</a></li>
							<?php endif; ?>
							<?php if (in_array('blog_edit', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/blog/add_post'); ?>"><i class="ss-icon">Add</i> Add Post</a></li>
							<?php endif; ?>
							<?php if (in_array('blog_cats', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/blog/categories'); ?>"><i class="ss-icon">List</i> Categories</a></li>
							<?php endif; ?>							
							<li><a href="<?php echo site_url('/admin/blog/comments'); ?>"><i class="ss-icon">Comment</i> Comments</a></li>
						</ul>
				<?php endif; ?>
			</div>
			<div class="large-10 columns">
				<h2>Blog Posts</h2>
				<ul class="breadcrumbs">
				  <li><a href="#">Home</a></li>
				  <li><a href="#">Blog</a></li>
				  <li class="current"><a href="#">Blog Posts</a></li>
				</ul>

				<?php if ($blog_posts): ?>

				<?php echo $this->pagination->create_links(); ?>

				<table class="default clear">
					<thead>
						<tr>
							<th><?php echo order_link('/admin/blog/viewall','posttitle','Post'); ?></th>
							<th><?php echo order_link('/admin/blog/viewall','datecreated','Date'); ?></th>
							<th class="narrow"><?php echo order_link('/admin/blog/viewall','published','Published'); ?></th>
							<th class="tiny">&nbsp;</th>
							<th class="tiny">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($blog_posts as $post): ?>
							<tr class="<?php echo (!$post['published']) ? 'draft' : ''; ?>">
								<td><?php echo (in_array('blog_edit', $this->permission->permissions)) ? anchor('/admin/blog/edit_post/'.$post['postID'], $post['postTitle']) : $post['postTitle']; ?></td>
								<td><?php echo dateFmt($post['dateCreated'], '', '', TRUE); ?></td>
								<td>
									<?php
										if ($post['published']) echo '<span style="color:green;">Yes</span>';
										else echo 'No';
									?>
								</td>
								<td class="tiny">
									<?php if (in_array('blog_edit', $this->permission->permissions)): ?>
										<?php echo anchor('/admin/blog/edit_post/'.$post['postID'], 'Edit'); ?>
									<?php endif; ?>
								</td>
								<td class="tiny">			
									<?php if (in_array('blog_delete', $this->permission->permissions)): ?>
										<?php echo anchor('/admin/blog/delete_post/'.$post['postID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php echo $this->pagination->create_links(); ?>


				<?php else: ?>

				<p class="clear">There are no blog posts yet.</p>

				<?php endif; ?>
			</div> <!-- / 10 -->
		</div> <!-- /row -->
	</div>
</div>