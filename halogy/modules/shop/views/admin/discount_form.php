<script type="text/javascript">
function showObjects(el){
	if ($(el).val() == 'P'){
		$('div#products').show();
		$('div#categories').hide();
		$('select#productID').removeAttr('disabled');
		$('select#catID').attr('disabled', 'disabled');
	} else if ($(el).val() == 'C'){
		$('div#products').hide();
		$('div#categories').show();
		$('select#productID').attr('disabled', 'disabled');
		$('select#catID').removeAttr('disabled');
		
	} else {
		$('div#products').slideUp(200);
		$('div#categories').slideUp(200);
	}
}

function showModifier(el){
	if ($(el).val() == 'P'){
		$('span#percentage').show();
		$('span#currency').hide();
	} else {
		$('span#percentage').hide();
		$('span#currency').show();
	}
}

$(function(){
	$('input.datebox').datepicker({dateFormat: 'M dd yy'});
	$('select#modifier').change(function(){
		showModifier($(this));
	});
	$('select#type').change(function(){
		showObjects($(this));
	});
	showModifier('select#modifier');
	showObjects('select#type');	
});
</script>

<div class="row">
	<div class="large-12 columns body">
		<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="custom">

		<?php if (!$this->core->is_ajax()): ?>
			<h1 class="headingleft"><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Discount</h1>
		<?php endif; ?>

		<ul class="group-button">
			<li><a href="<?php echo site_url('/admin/shop/discounts'); ?>" class="button">Back to Discounts</a></li>
			<li><input type="submit" value="Save Changes" class="button green nolabel" /></li>
		</ul>

		<hr>

		<?php if ($errors = validation_errors()): ?>
			<div class="error">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>

		<div class="large-6 small-12 large-centered columns">

			<div class="item">
				<label for="code">Code:</label>
				<?php echo @form_input('code', $data['code'], 'class="formelement" id="code"'); ?>
			</div>

			<div class="item">
				<label for="type">Calculated On:</label>
				<?php 
					$values = array(
						'T' => 'Total Value of Cart',
						'P' => 'Products',
						'C' => 'Category'
					);
					echo @form_dropdown('type',$values,set_value('type', $data['type']), 'id="type" class="formelement"'); 
				?>
			</div>

			<div style="display: none;" id="categories">
				<div class="item">	
					<label for="catID">Category:</label>
					<?php
						$options = '';
						$options[0] = 'Select a Category...';			
						if ($categories):
							foreach ($categories as $category):
								$options[$category['catID']] = ($category['parentID']) ? '-- '.$category['catName'] : $category['catName'];
							endforeach;
						endif;					
						echo @form_dropdown('catID',$options,set_value('catID', $data['objectID']),'id="catID" class="formelement"');
					?>	
				</div>
			</div>

			
			<div style="display: none;" id="products">
				<div class="item">
					<label for="productID">Product:</label>
					<?php
						$options = '';		
						if ($products):
							foreach ($products as $product):
								$options[$product['productID']] = $product['productName'];
							endforeach;
						endif;
						$objectIDArray = (isset($data['objectID'])) ? @explode(',',$data['objectID']) : $this->input->post('productID');
						echo @form_dropdown('productID[]',$options, $objectIDArray, 'id="productID" class="formelement" multiple="multiple"');
					?>	
				</div>
			</div>

			<div class="item">
				<label for="base">Taken Off:</label>
				<?php 
					$values = array(
						'T' => 'Sub Total of Cart',
						'P' => 'Product Price (and quantity)'
					);
					echo @form_dropdown('base',$values,set_value('base', $data['base']), 'id="base" class="formelement"'); 
				?>
			</div>

			<div class="item">
				<label for="modifier">Modifier:</label>
				<?php 
					$values = array(
						'A' => 'Amount',
						'P' => 'Percentage'
					);
					echo @form_dropdown('modifier',$values,set_value('modifier', $data['modifier']), 'id="modifier" class="formelement"'); 
				?>
			</div>

			<div class="item">				
				<label for="discount">Discount:</label>
				<div class="row collapse">
					<div class="small-2 columns">
						<span class="price prefix rounded" id="currency"><?php echo currency_symbol(); ?></span>
						<span class="price prefix rounded" id="percentage" style="display: none;">%</span>
					</div>
					<div class="small-2 pull-8 columns">
						<?php echo @form_input('discount', $data['discount'], 'class="formelement small" id="discount"'); ?>
					</div>
				</div>
			</div>
			<div class="item">
				<label for="expiryDate">Expiry Date:</label>
				<?php echo @form_input('expiryDate', dateFmt($data['expiryDate'], 'M d Y'), 'id="expiryDate" class="formelement datebox" readonly="readonly"'); ?>
			</div>
		</div>
		</form>
	</div>
</div>