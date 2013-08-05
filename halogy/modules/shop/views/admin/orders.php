<style type="text/css">
.ac_results { padding: 0px; border: 1px solid black; background-color: white; overflow: hidden; z-index: 99999; }
.ac_results ul { width: 100%; list-style-position: outside; list-style: none; padding: 0; margin: 0; }
.ac_results li { margin: 0px; padding: 2px 5px; cursor: default; display: block; font: menu; font-size: 12px; line-height: 16px; overflow: hidden; }
.ac_results li span.email { font-size: 10px; } 
.ac_loading { background: white url('<?php echo $this->config->item('staticPath'); ?>/images/loader.gif') right center no-repeat; }
.ac_odd { background-color: #eee; }
.ac_over { background-color: #0A246A; color: white; }
</style>

<script language="javascript" type="text/javascript">
function formatItem(row) {
	if (row[0].length) return row[1]+'<br /><span class="email">(#'+row[0]+')</span>';
	else return 'No results';
}
$(function(){
	$('#searchbox').autocomplete("<?php echo site_url('/admin/shop/ac_orders'); ?>", { delay: "0", selectFirst: false, matchContains: true, formatItem: formatItem, minChars: 2 });
	$('#searchbox').result(function(event, data, formatted){
		$(this).parent('form').submit();
	});
	$('select#filter').change(function(){
		var status = ($(this).val());
		window.location.href = '<?php echo site_url('/admin/shop/orders'); ?>/'+status;
	});	
});
</script>

<div class="large-10 columns body">
	<div class="card">
		<h2 class="left">Orders <?php if ($trackingStatus) echo '('.$statusArray[$trackingStatus].')'?></h2>

		<div class="right">
			<a href="<?php echo site_url('/admin/shop/export_orders'); ?>" class="button">Export Orders as CSV</a>
		</div>

		<div class="clear"></div>

		<div class="large-4 push-8 columns">

			<!-- <form method="post" action="<?php echo site_url('/admin/shop/orders'); ?>" class="default" id="search">
				<input type="text" name="searchbox" id="searchbox" class="formelement inactive" title="Search Products..." />
				<input type="image" src="<?php echo $this->config->item('staticPath'); ?>/images/btn_search.gif" id="searchbutton" />
			</form> -->

			<label for="filter">
				Filter
			</label> 

			<?php
				foreach ($statusArray as $key => $status):
					$options[$key] = $status;
				endforeach;
				
				echo form_dropdown('filter',$options,$trackingStatus,'id="filter"');
			?>

		</div>

		<?php if ($orders): ?>

		<?php echo $this->pagination->create_links(); ?>

		<div class="row table">
			<div class="large-1 columns">
				<p>Order ID</p>
			</div>
			<div class="large-2 columns">
				<p>Date Ordered</p>
			</div>
			<div class="large-2 columns">
				<p>Full Name</p>
			</div>
			<div class="large-1 columns">
				<p>Number of Items</p>
			</div>
			<div class="large-2 columns">
				<p>Total (<?php echo currency_symbol(); ?>)</p>
			</div>
			<div class="large-2 columns">
				<p>Status</p>
			</div>
			<div class="large-2 columns">

			</div>
		</div>

		<?php foreach ($orders as $order): 
			if (!$order['viewed']) $class = 'style="font-weight: bold;"'; else $class='';
		?>
		<div class="row table">
			<div class="large-1 columns">
				<p><?php echo anchor('/admin/shop/view_order/'.$order['transactionID'], $order['transactionCode']); ?></p>
			</div>
			<div class="large-2 columns">
				<p><?php echo dateFmt($order['dateCreated'], '', '', TRUE); ?></p>
			</div>
			<div class="large-2 columns">
				<p><?php echo $order['firstName']; ?> <?php echo $order['lastName']; ?></p>
			</div>
			<div class="large-1 columns">
				<p>?php echo $order['numItems']; ?></p>
			</div>
			<div class="large-2 columns">
				<p><?php echo currency_symbol().number_format($order['amount'],2); ?></p>
			</div>
			<div class="large-2 columns">
				<p>						
					<?php
							if ($order['trackingStatus'] == 'U' && $order['paid']) echo 'Unprocessed';
							elseif ($order['trackingStatus'] == 'L') echo 'Allocated';
							elseif ($order['trackingStatus'] == 'A') echo 'Awaiting Goods';
							elseif ($order['trackingStatus'] == 'O') echo 'Out of Stock';
							elseif ($order['trackingStatus'] == 'D') echo 'Dispatched';
							else echo 'Unpaid Checkout';
						?>
				</p>
			</div>
			<div class="large-2 columns">
				<ul class="button-group even-2">
					<li><?php echo anchor('/admin/shop/view_order/'.$order['transactionID'], 'View'); ?></li>
					<li><?php echo anchor('/admin/shop/delete_order/'.$order['transactionID'], 'Delete', 'onclick="return confirm(\'Are you absolutely sure you want to delete this order? There is no undo.\')"'); ?></li>
				</ul>
			</div>
		</div>
		<?php endforeach; ?>

		<?php echo $this->pagination->create_links(); ?>

		<?php else: ?>

		<p class="clear">There were no orders found.</p>

		<?php endif; ?>

	</div>
</div>

