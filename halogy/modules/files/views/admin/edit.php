<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="custom">
<div class="large-10 columns body">
	<h2>Edit File</h2>
	<ul class="breadcrumbs">
		<li><a href="#">Home</a></li>
		<li><a href="#">Uploads</a></li>
		<li class="current"><a href="#">Edit File</a></li>
	</ul>	

		<?php if ($errors = validation_errors()): ?>
			<div class="error clear">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>

		<div class="large-6 small-12 large-centered columns">

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
			<ul class="button-group">
				<li><input type="submit" value="Save Changes" class="button green nolabel" id="submit" /></li>
				<li><a href="<?php echo site_url('/admin/files/viewall'); ?>" class="button">Cancel</a></li>
			</ul>
			
		</div>

	</div>
</div>
</form>

