<div class="row">
	<div class="large-12 columns body">
		<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="custom">
		
		<?php if (!$this->core->is_ajax()): ?>
			<h1 class="headingleft"><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Categories</h1>
		<?php endif; ?>

		<ul class="group-button">
			<li><a href="<?php echo site_url('/admin/shop/categories'); ?>" class="bluebutton">Back to Categories</a></li>
			<li><input type="submit" value="Save Changes" class="green nolabel" /></li>
		</ul>

		<hr>

		<?php if ($errors = validation_errors()): ?>
			<div class="error">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>

		<div class="large-6 small-12 large-centered columns">
			<div class="item">
				<label for="catName">Title:</label>
				<?php echo @form_input('catName', $data['catName'], 'class="formelement" id="catName"'); ?>
			</div>
				
			<div class="item">
				<label for="templateID">Parent:</label>
				<?php
					$options = '';		
					$options[0] = 'Top Level';
					if ($parents):	
						foreach ($parents as $parent):
							if ($parent['catID'] != @$data['catID']) $options[$parent['catID']] = $parent['catName'];
						endforeach;
					endif;
					
					echo @form_dropdown('parentID',$options,$data['parentID'],'id="parentID" class="formelement"');
				?>
			</div>
			
			<div class="item">
				<label for="description">Description:</label>
				<?php echo @form_textarea('description',set_value('description', $data['description']), 'id="description" class="formelement short"'); ?>
			</div>
		</div>
		</form>
	</div>
</div>
