<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="">
<div class="large-12 columns body">
	<div class="small-12 large-8 large-centered columns card">
		<h2>Edit File</h2>
		<?php if ($errors = validation_errors()): ?>
			<div class="error clear">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>
			<div class="item">
				<label for="fileRef">Reference:</label>
				<p>Give your file a reference name</p>
				<?php echo @form_input('fileRef', $data['fileRef'], 'class="formelement" id="fileRef"'); ?>
			</div> 

			<div class="item">
				<a href="<?php echo site_url('/admin/files/folders'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')" class="button small right">Add</a>
				<label for="folderID">Folder</label>
				<p>We recommend adding your files into folders.</p>
				<?php
					$options[0] = 'No Folder';
					if ($folders):
						foreach ($folders as $folderID):
							$options[$folderID['folderID']] = $folderID['folderName'];
						endforeach;
					endif;
						
					echo @form_dropdown('folderID',$options,set_value('folderID', $data['folderID']),'id="folderID" class="formelement"');
				?>	
			</div>
			<input type="submit" value="Save Changes" class="button green nolabel" id="submit" />
			<a href="<?php echo site_url('/admin/files/viewall'); ?>" class="button">Cancel</a>
	</div>
</div>
</form>

