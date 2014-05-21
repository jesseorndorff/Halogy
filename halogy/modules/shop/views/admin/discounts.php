<script type="text/javascript">
$(function(){
	$.listen('click', 'a.showform', function(event){showForm(this,event);});
	$.listen('click', 'input#cancel', function(event){hideForm(this,event);});
});
</script>


<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<h2>Discount Codes</h2>
			</div>
			<div class="large-6 small-12 columns right">
				<a href="<?php echo site_url('/admin/shop/add_discount'); ?>" class="button small radius showform">Add Discount</a>
			</div>
		</div>
		<div class="row table">
			<div class="small-12 columns item">
				<?php if ($shop_discounts): ?>

				<?php echo $this->pagination->create_links(); ?>

				<div class="row table-header hide-for-touch">
					<div class="large-2 columns">
						<h3>Code</h3>
					</div>
					<div class="large-3 columns">
						<h3>Calculated On</h3>
					</div>
					<div class="large-2 columns">
						<h3>Discount</h3>
					</div>
					<div class="large-3 columns">
						<h3>Expiry Date</h3>
					</div>
					<div class="large-2 columns">
					</div>
				</div>

					<?php foreach ($shop_discounts as $discount): ?>
						<div class="row table">
							<div class="large-2 columns">
								<p><?php echo anchor('/admin/shop/edit_discount/'.$discount['discountID'], $discount['code'], 'class="showform"'); ?></p>
							</div>
							<div class="large-3 columns">
								<p><?php
									if ($discount['type'] == 'P') echo 'Product';
									elseif ($discount['type'] == 'C') echo 'Category';
									else echo 'Total';
								?></p>
							</div>
							<div class="large-2 columns">
								<p><?php echo ($discount['modifier'] == 'A') ? currency_symbol().number_format($discount['discount'],2) : $discount['discount'].'%'; ?></p>
							</div>
							<div class="large-3 columns">
								<p><?php echo (strtotime($discount['expiryDate']) < time()) ? 
									'<span style="color:red;">'.dateFmt($discount['expiryDate']).'</span>' : 
									'<span style="color:green;">'.dateFmt($discount['expiryDate']).'</span>'; ?></p>
							</div>
							<div class="large-2 columns">
								<ul class="button-group even-2">
									<li><?php echo anchor('/admin/shop/edit_discount/'.$discount['discountID'], 'Edit', 'class="showform"'); ?></li>
									<li><?php echo anchor('/admin/shop/delete_discount/'.$discount['discountID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?></li>
								</ul>
							</div>
						</div>
					<?php endforeach; ?>
					

				<?php echo $this->pagination->create_links(); ?>

				<?php else: ?>

				<p>You have not set up any discount codes yet.</p>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>






<div class="large-10 columns body">
	<div class="card">

				
	</div>
</div>