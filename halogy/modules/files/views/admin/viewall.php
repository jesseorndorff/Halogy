<style type="text/css">
.ac_results { padding: 0px; border: 1px solid black; background-color: white; overflow: hidden; z-index: 99999; }
.ac_results ul { width: 100%; list-style-position: outside; list-style: none; padding: 0; margin: 0; }
.ac_results li { margin: 0px; padding: 2px 5px; cursor: default; display: block; font: menu; font-size: 12px; line-height: 16px; overflow: hidden; }
.ac_results li span.email { font-size: 10px; } 
.ac_loading { background: white url('<?php echo $this->config->item('staticPath'); ?>/images/loader.gif') right center no-repeat; }
.ac_odd { background-color: #eee; }
.ac_over { background-color: #0A246A; color: white; }
</style>

<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.fieldreplace.js"></script>
<script type="text/javascript">
$(function(){
	$('.toggle').click(function(event){ 
		event.preventDefault();		
		$('div#upload-file').slideToggle('400');
		$('div#upload-zip:visible, div#loader:visible').slideToggle('400');
	});

	$('.toggle-zip').click(function(event){ 
		event.preventDefault();		
		$('div#upload-zip').toggle('400');
		$('div#upload-file:visible, div#loader:visible').slideToggle('400');
	});

	$('.edit').click(function(event){
		event.preventDefault();
		$.scrollTo(0, '200');
		$('div#loader').load(this.href, function(){
			$('div#loader:hidden').toggle('400');
			$('div#upload-zip:visible, div#upload-file:visible').slideToggle('400');
		});
	});
	
//    $('#searchbox').fieldreplace();
//	function formatItem(row) {
//		if (row[0].length) return row[1]+'<br /><span class="email">(#'+row[0]+')</span>';
//		else return 'No results';
//	}
//	$('#searchbox').autocomplete("<?php echo site_url('/admin/files/ac_files'); ?>", { delay: "0", selectFirst: false, matchContains: true, formatItem: formatItem, minChars: 2 });
//	$('#searchbox').result(function(event, data, formatted){
//		$(this).parent('form').submit();
//	});
	
	$('select#folderID').change(function(){
		var folderID = ($(this).val());
		window.location.href = '<?php echo site_url('/admin/files/viewall'); ?>/'+folderID;
	});
});
</script>

<div class="row">
	<div class="large-12 columns body">

		<h1 class="headingleft">Files</h1>

		<ul class="group-button">
		<?php if ($this->site->config['plan'] = 0 || $this->site->config['plan'] = 6 || (($this->site->config['plan'] > 0 && $this->site->config['plan'] < 6) && $quota < $this->site->plans['storage'])): ?>

			<a href="#" class="green toggle" data-reveal-id="upload-file">Upload File</a>

		<?php endif; ?>
		</ul>
		<hr>
		<div class="large-4 columns">
			<label for="folderID">
				Folder
			</label> 

			<?php
				$options = '';
				$options['me'] = 'My Files';
				if (@in_array('files_all', $this->permission->permissions)):
					$options['all'] = 'View All Files';

					if ($folders):
						foreach ($folders as $folder):
							$options[$folder['folderID']] = $folder['folderName'];
						endforeach;
					endif;
				endif;
				echo form_dropdown('folderID', $options, $folderID, 'id="folderID"');
			?>
		</div>
		<div class="large-4 large-offset-4 columns">
			<div class="row collapse">
				<form method="post" action="<?php echo site_url('/admin/files/viewall'); ?>" class="custom" id="search">
					<div class="small-9 columns">
						<input type="text" name="searchbox" id="searchbox" class="formelement inactive" placeholder="Search Files..." />
					</div>
					<div class="small-3 columns">
						<input type="submit" class="button prefix" id="searchbutton" value="Search" />
					</div>
				</form>
			</div>
		</div>

		<?php if ($errors = validation_errors()): ?>
			<div class="error clear">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>


		<div id="loader" class="hidden clear"></div>

		<?php if ($this->site->config['plan'] > 0 && $this->site->config['plan'] < 6): ?>

			<?php if ($quota > $this->site->plans['storage']): ?>
			
			<div class="error clear">
				<p>You have gone over your storage capacity, we will be contacting you soon.</p>
			</div>
			
			<div class="quota">
				<div class="over"><?php echo floor($quota / $this->site->plans['storage'] * 100); ?>%</div>
			</div>
			
			<?php else: ?>
			
			<div class="quota">
				<div class="used" style="width: <?php echo ($quota > 0) ? (floor($quota / $this->site->plans['storage'] * 100)) : 0; ?>%"><?php echo floor($quota / $this->site->plans['storage'] * 100); ?>%</div>
			</div>
			
			<?php endif; ?>

			<p><small>You have used <strong><?php echo number_format($quota); ?>kb</strong> out of your <strong><?php echo number_format($this->site->plans['storage']); ?> KB</strong> quota.</small></p>

		<?php endif; ?>

		<?php if ($files): ?>

		<hr>

			<?php echo $this->pagination->create_links(); ?>
			
		<ul class="small-block-grid-2 large-block-grid-4">
				<?php
					$numItems = sizeof($files);
					$itemsPerRow = 6;
					$i = 0;
								
					foreach ($files as $file)
					{
						if (($i % $itemsPerRow) == 0 && $i > 1)
						{
							echo '</tr><tr>'."\n";
							$i = 0;
						}
						echo '<td align="center" valign="top" width="'.floor(( 1 / $itemsPerRow) * 100).'%">';

						$extension = substr($file['filename'], strpos($file['filename'], '.')+1);
						$filePath = '/files/'.$file['fileRef'].'.'.$extension;				

				?>

						<li><a href="<?php echo $filePath; ?>" title="<?php echo $file['fileRef']; ?>"><img src="<?php echo $this->config->item('staticPath'); ?>/fileicons/<?php echo $extension; ?>.png" alt="<?php echo $file['fileRef']; ?>" class="file" /></a><p><strong><?php echo $file['fileRef']; ?></strong></p>
						<?php echo anchor('/admin/files/edit/'.$file['fileID'].'/', 'Edit', 'class="button small"'); ?>
						<?php echo anchor('/admin/files/delete/'.$file['fileID'], 'Delete', array('class' => 'button alert small'), 'onclick="return confirm(\'Are you sure you want to delete this file?\')"'); ?></li>
					
				<?php
						echo '</td>'."\n";
						$i++;
					}
				
					for($x = 0; $x < ($itemsPerRow - $i); $x++)
					{
						echo '<td width="'.floor((1 / $itemsPerRow) * 100).'%">&nbsp;</td>';
					}
				?>
		</ul>
			
			<?php echo $this->pagination->create_links(); ?>


		<?php else: ?>

		<p class="clear">You have not yet uploaded any files.</p>

		<?php endif; ?>

	</div>
</div>

<div id="upload-file" class="hidden clear reveal-modal">
	<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="custom">
		<h2>Upload a File</h2>
		<p>You can upload any file you might need to reference on your site.</p>
		<label for="file">File:</label>
		<div class="uploadfile">
			<?php echo @form_upload('file',$this->validation->file, 'size="16" id="file"'); ?>
		</div>
		<br class="clear" />

		<label for="fileFolderID">Folder: <small>[<a href="<?php echo site_url('/admin/files/folders'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')">update</a>]</small></label>
		<?php
			$options = '';		
			$options[0] = 'No Folder';
			if ($folders):
				foreach ($folders as $folderID):
					$options[$folderID['folderID']] = $folderID['folderName'];
				endforeach;
			endif;
				
			echo @form_dropdown('folderID',$options,set_value('folderID', $data['folderID']),'id="fileFolderID" class="formelement"');
		?>	
		<br class="clear" /><br />
			
		<input type="submit" value="Upload File" class="button nolabel" id="submit" />
		<a href="<?php echo site_url('/admin/files'); ?>" class="button cancel grey">Cancel</a>
		
	</form>
	<a class="close-reveal-modal">&#215;</a>
</div>
