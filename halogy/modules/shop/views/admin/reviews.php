<div class="large-10 columns body">
	<div class="card">
		<h2 class="left">Shop Reviews</h2>

		<?php if ($reviews): ?>

		<?php echo $this->pagination->create_links(); ?>

		<div class="row table-header hide-for-touch">
			<div class="large-2 columns">
				<h3>Date Posted</h3>
			</div>
			<div class="large-1 columns">
				<h3>Product</h3>
			</div>
			<div class="large-2 columns">
				<h3>Author</h3>
			</div>
			<div class="large-2 columns">
				<h3>Email</h3>
			</div>
			<div class="large-2 columns">
				<h3>Review</h3>
			</div>
			<div class="large-1 columns">
				<h3>Status</h3>
			</div>
			<div class="large-2 columns">
			</div>
		</div>

		<?php foreach ($reviews as $review): ?>
		<div class="row table">
			<div class="large-2 columns">
				<p><?php echo dateFmt($review['dateCreated']); ?></p>
			</div>
			<div class="large-1 columns">
				<h3>?php echo anchor('/shop/viewproduct/'.$review['productID'], $review['productName']); ?></h3>
			</div>
			<div class="large-2 columns">
				<h3><?php echo $review['fullName']; ?></h3>
			</div>
			<div class="large-2 columns">
				<h3><?php echo $review['email']; ?></h3>
			</div>
			<div class="large-2 columns">
				<h3><?php echo (strlen($review['review'] > 50)) ? substr($review['review'], 0, 50).'...' : $review['review']; ?></h3>
			</div>
			<div class="large-1 columns">
				<h3><?php echo ($review['active']) ? '<span style="color:green;">Active</span>' : '<span style="color:orange;">Pending</span>'; ?></h3>
			</div>
			<div class="large-2 columns">
				<ul class="button-group even-2">
					<li><?php echo (!$review['active']) ? anchor('/admin/shop/approve_review/'.$review['reviewID'], 'Approve') : ''; ?></li>
					<li><?php echo anchor('/admin/shop/delete_review/'.$review['reviewID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?></li>
				</ul>
			</div>
		</div>
		<?php endforeach; ?>

		<?php echo $this->pagination->create_links(); ?>

		<?php endif; ?>
	</div>
</div>

