<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="">
	<div class="large-12 columns body">
		<div class="card">
			<div class="header">
				<div class="small-12 medium-6 large-4 columns left">
					<?php if (!$this->core->is_ajax()): ?>
						<h2><?php echo (preg_match('/edit/i', $this->uri->segment(3))) ? 'Edit' : 'Add'; ?> Categories</h2>
					<?php endif; ?>
					<a href="<?php echo site_url('/admin/shop/categories'); ?>">Back to Categories</a>
				</div>
				<div class="large-6 small-12 columns right">
					<input type="submit" value="Save Changes" class="button small radius success nolabel" />
				</div>
			</div>
			<div class="row table">				
				<div class="small-12 columns">
					<?php if ($errors = validation_errors()): ?>
						<div class="error">
							<?php echo $errors; ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="small-12 columns item">
					<label for="catName">Title:</label>
					<?php echo @form_input('catName', $data['catName'], 'class="formelement" id="catName"'); ?>
				</div>
				<div class="small-12 columns item">
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
				<div class="small-12 columns item">
					<label for="description">Description:</label>
					<?php echo @form_textarea('description',set_value('description', $data['description']), 'id="description" class="formelement short"'); ?>
				</div>
			</div>
		</div>
	</div>
</form>