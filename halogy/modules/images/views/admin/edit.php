<?php
	$image = $this->uploads->load_image($data['imageRef']);
	$thumb = $this->uploads->load_image($data['imageRef'], true);
	$imagePath = $image['src'];
	$imageThumbPath = $thumb['src'];
?>
<div class="large-12 columns body">
	<div class="card">
		<h2 class="left">Edit Image: <?php if ($image): ?> <?php echo $image['imageRef']; ?> <?php endif; ?></h2>
		<a href="<?php echo site_url('/admin/images/viewall/'); ?>" class="button right">Back to Images</a>
		<div class="clear"></div>

		<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="">
			<div class="large-6 columns">
				<?php if ($errors = validation_errors()): ?>
					<div class="error clear">
						<?php echo $errors; ?>
					</div>
				<?php endif; ?>
				<div class="item">
					<label for="image">Image:</label>
					<div class="uploadfile">
						<?php echo @form_upload('image', '', 'size="16" id="image"'); ?>
					</div>
				</div>

				<div class="item">
					<label for="folderID">Folder: <small>[<a href="<?php echo site_url('/admin/images/folders'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')">update</a>]</small></label>
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

				<div class="item">
					<label for="imageName">Description:</label>
					<p>Add a detailed description for your image here. We use this for alt tags and some templates may use it.</p>
					<?php echo @form_input('imageName', $data['imageName'], 'class="formelement" id="imageName"'); ?>
				</div>

				<div class="item">
					<label for="imageRef">Reference:</label>
					<p>A reference name allows you to easily reference your image on your site pages.</p>
					<?php echo @form_input('imageRef', $data['imageRef'], 'class="formelement" id="imageRef"'); ?>
				</div>

				<div class="item">
					<label for="class">Display:</label>
					<?php
						$values = array(
							'default' => 'Default',
							'left' => 'Left Align',
							'center' => 'Center Align',
							'right' => 'Right Align',
							'bordered' => 'Border',
							'bordered left' => 'Border - Left Align',
							'bordered center' => 'Border - Center Align',
							'bordered right' => 'Border - Right Align',
							'full' => 'Full Width',
							'' => 'No Style'
						);
						echo @form_dropdown('class',$values,$data['class'], 'class="formelement"');
					?>
				</div>

				<div class="item">
					<label for="maxsize">Max Size (px):</label>
					<?php echo @form_input('maxsize', set_value('maxsize', (($data['maxsize']) ? $data['maxsize'] : '')), 'class="formelement" id="maxsize"'); ?>
				</div>

				<input type="submit" value="Save Changes" class="green nolabel" id="submit" />
				<a href="<?php echo site_url('/admin/images/viewall'); ?>" class="button cancel grey">Cancel</a>
			</div>
			<div class="large-6 columns edit-image">
				<?php echo ($thumb = display_image($imagePath, $data['imageName'], 0, 'class="pic th" ')) ? $thumb : display_image($imagePath, $data['imageName'], 0, 'class="pic"'); ?>
			</div>

		</form>

	</div>
</div>
