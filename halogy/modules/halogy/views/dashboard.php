<script type="text/javascript">
	var days = <?php echo $days; ?>;
</script>
<script type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.flot.js"></script>
<!--[if IE]>
	<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/excanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.flot.init.js"></script>

<script type="text/javascript">
function refresh(){
	$('div.loader').load('<?php echo site_url('/admin/activity_ajax'); ?>');
	timeoutID = setTimeout(refresh, 5000);
}
$(function(){
	timeoutID = setTimeout(refresh, 5000);
});
</script>


<div class="row">
	
	<div class="large-8 columns">
		
		<?php if ($errors = validation_errors()): ?>
			<div data-alert class="error">
				<?php echo $errors; ?>
				<a href="#" class="close">&times;</a>
			</div>
		<?php endif; ?>

		<?php if ($message): ?>
			<div data-alert class="message">
				<?php echo $message; ?>
				<a href="#" class="close">&times;</a>
			</div>
		<?php endif; ?>

		<div class="admin-header"><h3><?php echo (isset($this->site->config['siteName'])) ? $this->site->config['siteName'] : 'Login to'; ?> - <?php echo ($this->session->userdata('firstName')) ? ucfirst($this->session->userdata('firstName')) : $this->session->userdata('username'); ?>'s Dashboard</h3></div>
		
		<div class="activity" class="loader">
			<ul class="dashboardnav">
				<li class="<?php echo ($days == 30) ? 'active' : ''; ?>"><a class="button" href="<?php echo site_url('/admin'); ?>">Last 30 Days</a></li>
				<li class="<?php echo ($days == 60) ? 'active' : ''; ?>"><a class="button" href="<?php echo site_url('/admin/dashboard/60'); ?>">Last 60 Days</a></li>
				<li class="<?php echo ($days == 90) ? 'active' : ''; ?>"><a class="button" href="<?php echo site_url('/admin/dashboard/90'); ?>">3 Months</a></li>
				<li><a class="button" href="<?php echo site_url('/admin/tracking'); ?>">Most Recent Visits</a></li>
			</ul>

			<div id="placeholder"></div>
				<?php echo $activity; ?>
		</div>

		<?php if ($this->site->config['plan'] > 0 && $this->site->config['plan'] < 6): ?>		

			<div class="quota">
				<div class="<?php echo ($quota > $this->site->plans['storage']) ? 'over' : 'used'; ?>" style="width: <?php echo ($quota > 0) ? (floor($quota / $this->site->plans['storage'] * 100)) : 0; ?>%"><?php echo floor($quota / $this->site->plans['storage'] * 100); ?>%</div>
			</div>
			
			<p><small>You have used <strong><?php echo number_format($quota); ?>kb</strong> out of your <strong><?php echo number_format($this->site->plans['storage']); ?> KB</strong> quota.</small></p>

		<?php endif; ?>

		<div class="large-6 columns">
			<div class="dash-sales">
				<i class="ss-icon">basket</i>
				<p class="dash-number"><?php echo number_format($monthlyTotalSales); ?></p>
				<p>Monthly Total Sales</p>
			</div>
		</div>
		
		<div class="large-6 columns">
			<div class="dash-sales">
				<i class="ss-icon">cash</i>
				<p class="dash-number-money">$<?php echo number_format($monthlyTotalSalesVolume,2); ?></p>
				<p>Monthly Sales Volume</p>
			</div>
		</div>
		
		<div class="large-6 columns">
			<div class="dash-tickets">
				<i class="ss-icon">headset</i>
				<p class="dash-number"><?php echo number_format($unopenedTickets); ?></p>
				<p>Unopened Tickets</p>
			</div>
		</div>
		
		<div class="large-6 columns">
			<div class="dash-tickets">
				<i class="ss-icon">headset</i>
				<p class="dash-number"><?php echo number_format($activeTickets); ?></p>
				<p>Active Tickets</p>
			</div>
		</div>
		
		<div class="large-6 columns">
			<div class="dash-users">
				<i class="ss-icon">users</i>
				<p class="dash-number"><?php echo number_format($numUsersWeek); ?></p>
				<p>New Users This Week</p>
			</div>
		</div>
		
		<div class="large-6 columns">
			<div class="dash-users">
				<i class="ss-icon">usergroup</i>
				<p class="dash-number"><?php echo number_format($numUsers); ?></p>
				<p>Total Users</p>
			</div>
		</div>

	</div> 
	
	<div class="large-4 columns sidebar">
		<?php if ($this->session->userdata('session_admin')): ?>
			<div data-alert class="welcome">
				<h3>Welcome back <?php echo $this->session->userdata('username'); ?>!</h3>
				<p>Here's a few things that have been happening on your website.</p>
			</div>
		<?php endif; ?>
		
		<div class="sidebar-module-header">
			<h3>Site Information</h3>
		</div>
		
		<div class="sidebar-module">
			<ul>
				<li>Site name: <?php echo $this->site->config['siteName']; ?></li>
				<li>Site URL: <a href="<?php echo $this->site->config['siteURL']; ?>"><?php echo $this->site->config['siteURL']; ?></a></li>
				<li>Site email: <a href="mailto:<?php echo $this->site->config['siteEmail']; ?>"><?php echo $this->site->config['siteEmail']; ?></a></li>
			</ul>
		</div>
		
		<div class="sidebar-module-header">
			<h3>Site Statistics</h3>
		</div>
		<div class="sidebar-module">
			<ul>
				<li>Disk space used: <?php echo number_format($quota); ?> KB</li>
				<li>Total page views: <?php echo number_format($numPageViews); ?> Views</li>
				<li>Pages: <?php echo $numPages; ?> page<?php echo ($numPages != 1) ? 's' : ''; ?></li>
				<?php if (@in_array('blog', $this->permission->permissions)): ?>
					<li>Blog posts: <?php echo $numBlogPosts ?> post<?php echo ($numBlogPosts != 1) ? 's' : ''; ?></li>
				<?php endif; ?>
			</ul>
		</div>
		
		<div class="sidebar-module-header">
			<h3>User Statistics</h3>
		</div>
		<div class="sidebar-module">
			
			<ul>
				<li>Total users: <?php echo number_format($numUsers); ?> user<?php echo ($numUsers != 1) ? 's' : ''; ?></li>
				<li>New today: <?php echo number_format($numUsersToday); ?> user<?php echo ($numUsersToday != 1) ? 's' : ''; ?>
					<?php
						$difference = @round(100 / $numUsersYesterday * ($numUsersToday - $numUsersYesterday), 2);
						$polarity = ($difference < 0) ? '' : '+';
						?>						
						<?php if ($difference != 0): ?>
							(<span style="color:<?php echo ($polarity == '+') ? 'green' : 'red'; ?>"><?php echo $polarity.$difference; ?>%</span>)</li>
						<?php endif; ?>
				
				<li>New yesterday: <?php echo number_format($numUsersYesterday); ?> user<?php echo ($numUsersYesterday != 1) ? 's' : ''; ?></li>
				<li>New this week: <?php echo number_format($numUsersWeek); ?> user<?php echo ($numUsersWeek != 1) ? 's' : ''; ?>
						<?php
							$difference = @round(100 / $numUsersLastWeek * ($numUsersWeek - $numUsersLastWeek), 2);
							$polarity = ($difference < 0) ? '' : '+';
							?>				
							<?php if ($difference != 0): ?>
								(<span style="color:<?php echo ($polarity == '+') ? 'green' : 'red'; ?>"><?php echo $polarity.$difference; ?>%</span>)</li>
							<?php endif; ?>

				<li>New last week: <?php echo number_format($numUsersLastWeek); ?> user<?php echo ($numUsersLastWeek != 1) ? 's' : ''; ?></li>

			</ul>
		</div>
		
		<div class="sidebar-module-header">
			<h3>Most Popular</h3>
		</div>
		
		<div class="sidebar-module">

			<?php if ($popularPages): ?>
				<h3>Most popular pages</h3>
				<ol>		
					<?php foreach ($popularPages as $page): ?>
						<li><?php echo anchor('/admin/pages/edit/'.$page['pageID'], $page['pageName']); ?></li>
					<?php endforeach; ?>
				</ol>
			<?php else: ?>
				<p>We don't have this information yet.</p>
			<?php endif; ?>
				
			<?php if (@in_array('blog', $this->permission->sitePermissions)): ?>

				<h3>Most popular blog posts</h3>

				<?php if ($popularBlogPosts): ?>
						<ol>		
							<?php foreach ($popularBlogPosts as $post): ?>
								<li><?php echo anchor('/admin/blog/edit_post/'.$post['postID'], $post['postTitle']); ?></li>
							<?php endforeach; ?>
						</ol>
					<?php else: ?>
					<p>We don't have this information yet.</p>
				<?php endif; ?>
		
			<?php endif; ?>

			<?php if (@in_array('shop', $this->permission->sitePermissions)): ?>		

				<h3>Most popular shop products</h3>

				<?php if ($popularShopProducts): ?>
					<ol>		
						<?php foreach ($popularShopProducts as $product): ?>
							<li><?php echo anchor('/admin/shop/edit_product/'.$product['productID'], $product['productName']); ?></li>
						<?php endforeach; ?>
					</ol>
					<?php else: ?>
					<p>We don't have this information yet.</p>
			<?php endif; ?>

		</div>

<?php endif; ?> <!-- not sure about this endif required -->
		
</div> <!-- / row -->
