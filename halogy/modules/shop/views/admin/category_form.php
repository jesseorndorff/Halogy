<div class="large-10 columns body">
	<div class="small-12 large-8 large-centered columns card">
		<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="">
		
			<?php if (!$this->core->is_ajax()): ?>
				<h2 class="left"><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Categories</h2>
			<?php endif; ?>

			<div class="right">
				<a href="<?php echo site_url('/admin/shop/categories'); ?>" class="button">Back to Categories</a>
				<input type="submit" value="Save Changes" class="green button nolabel" />
			</div>

			<div class="clear"></div>

			<?php if ($errors = validation_errors()): ?>
				<div class="error">
					<?php echo $errors; ?>
				</div>
			<?php endif; ?>

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
		</form>
	</div>
</div>
