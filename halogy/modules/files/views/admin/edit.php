<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="default">
<div class="row">
	<div class="large-12 columns body">
		<h1 class="headingleft">Edit File</h1>

		<ul class="group-button">
			<li><a href="<?php echo site_url('/admin/files/viewall'); ?>" class="bluebutton">Cancel</a></li>
			<li><input type="submit" value="Save Changes" class="green nolabel" id="submit" /></li>
		</ul>

		<hr>

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

			
		</div>

	</div>
</div>
</form>

