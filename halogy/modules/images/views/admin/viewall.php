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
	$('.toggle-image').click(function(event){ 
		event.preventDefault();		
		$('div#upload-image').slideToggle('400');
		$('div#upload-zip:visible, div#loader:visible').slideToggle('400');
	});

	$('.toggle-zip').click(function(event){ 
		event.preventDefault();		
		$('div#upload-zip').slideToggle('400');
		$('div#upload-image:visible, div#loader:visible').slideToggle('400');
	});

	$('.edit').click(function(event){
		event.preventDefault();
		$.scrollTo(0, '200');
		$('div#loader').load(this.href, function(){
			$('div#loader:hidden').toggle('400');
			$('div#upload-zip:visible, div#upload-image:visible').slideToggle('400');
		});
	});
	
    
	$('select#folderID').change(function(){
		var folderID = ($(this).val());
		window.location.href = '<?php echo site_url('/admin/images/viewall'); ?>/'+folderID;
	});

//	$('a.lightbox').lightBox({imageLoading:'<?php echo $this->config->item('staticPath'); ?>/images/loading.gif',imageBtnClose: '<?php echo $this->config->item('staticPath'); ?>/images/lightbox_close.gif',imageBtnNext:'<?php echo $this->config->item('staticPath'); ?>/image/lightbox_btn_next.gif',imageBtnPrev:'<?php echo $this->config->item('staticPath'); ?>/image/lightbox_btn_prev.gif'});

//  $('#searchbox').fieldreplace();
//	function formatItem(row) {
//		if (row[0].length) return row[1]+'<br /><span class="email">(#'+row[0]+')</span>';
//		else return 'No results';
//	}
//	$('#searchbox').autocomplete("<?php echo site_url('/admin/images/ac_images'); ?>", { delay: "0", selectFirst: false, matchContains: true, formatItem: formatItem, minChars: 2 });
//	$('#searchbox').result(function(event, data, formatted){
//		$(this).parent('form').submit();
//	});

});
</script>
<div class="row">
	<div class="large-12 columns body">
		<div class="row">
			<div class="large-6 columns">
				<h1 class="headingleft">Images</h1>
			</div>

			<div class="large-6 columns">
				<?php if ($this->site->config['plan'] = 0 || $this->site->config['plan'] = 6 || (($this->site->config['plan'] > 0 && $this->site->config['plan'] < 6) && $quota < $this->site->plans['storage'])): ?>
					<ul class="button-group even-2">
						<li><a href="#" class="button" data-reveal-id="upload-zip">Upload Zip</a></li>
						<li><a href="#" class="button green" data-reveal-id="upload-image">Upload Image</a></li>
					</ul>
				<?php endif; ?>
			</div>
		</div>

       <?php echo $this->session->flashdata('error'); ?>
                
		<div class="large-4 columns">
			<label for="folderID">
				Folder
			</label> 

			<?php
				$options = '';
				$options['me'] = 'My Images';
				if (@in_array('images_all', $this->permission->permissions)):
					$options['all'] = 'View All Images';

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
				<form method="post" action="<?php echo site_url('/admin/images/viewall'); ?>" class="custom" id="search">
					<div class="small-9 columns">
						<input type="text" name="searchbox" id="searchbox" class="formelement inactive" placeholder="Search Images..." />
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

		<hr>

		<ul class="small-block-grid-2 large-block-grid-4">
		<?php if ($images): ?>

			<?php echo $this->pagination->create_links(); ?>

				<?php
					$numItems = sizeof($images);
					$itemsPerRow = 4;
					$i = 0;
								
					foreach ($images as $image)
					{
						if (($i % $itemsPerRow) == 0 && $i > 1)
						{
							echo '</tr><tr>'."\n";
							$i = 0;
						}
						echo '<td valign="top" align="center" width="'.floor(( 1 / $itemsPerRow) * 100).'%">';

						$imageData = $this->uploads->load_image($image['imageRef']);
						$imagePath = $imageData['src'];
						$imageData = $this->uploads->load_image($image['imageRef'], true);				
						$imageThumbPath = $imageData['src'];
				?>
		

						
							<li><a href="<?php echo $imagePath; ?>" title="<?php echo $image['imageName']; ?>" class="lightbox"><?php echo ($thumb = display_image($imageThumbPath, $image['imageName'], 100, 'class="pic"')) ? $thumb : display_image($imagePath, $image['imageName'], 100, 'class="pic"'); ?></a>
							<p><strong><?php echo $image['imageRef']; ?></strong></p>
							<?php echo anchor('/admin/images/edit/'.$image['imageID'].'/'.$this->core->encode($this->uri->uri_string()), 'Edit', array('class' => 'button small')); ?>				
							<?php echo anchor('/admin/images/delete/'.$image['imageID'].'/'.$this->core->encode($this->uri->uri_string()),'Delete', array('class' => 'button alert small'), 'onclick="return confirm(\'Are you sure you want to delete this image?\')"'); ?></li>
						
				<?php
						echo '</td>'."\n";
						$i++;
					}
				
					for($x = 0; $x < ($itemsPerRow - $i); $x++)
					{
						echo '<td width="'.floor((1 / $itemsPerRow) * 100).'%">&nbsp;</td>';
					}
				?>

			
			<?php echo $this->pagination->create_links(); ?>
		</ul>
		<?php else: ?>
		
		<p>You have not yet uploaded any images.</p>

		<?php endif; ?>
	</div>
</div>

		<div id="upload-image" class="hidden clear reveal-modal">
<style>
#progressbox,#progressbox2 {
    border: 1px solid #0099CC;
    padding: 1px;
    position:relative;
    width:400px;
    border-radius: 3px;
    margin: 10px;
    display:none;
    text-align:left;
}
#progressbar,#progressbar2 {
    height:20px;
    border-radius: 3px;
    background-color: #003333;
    width:1%;
}
#statustxt,#statustxt2 {
    top:3px;
    left:50%;
    position:absolute;
    display:inline-block;
    color: #000000;
}
</style>
    
<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.form.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
        //elements
        var progressbox     = $('#progressbox');
        var progressbar     = $('#progressbar');
        var statustxt       = $('#statustxt');
        var submitbutton    = $("#submit");
        var myform          = $("#UploadForm");
        var output          = $("#output");
        var completed       = '0%';
                
                $(myform).ajaxForm({
                    beforeSend: function() { //brfore sending form
                        submitbutton.attr('disabled', ''); // disable upload button
                        statustxt.empty();
                        progressbox.slideDown(); //show progressbar
                        progressbar.width(completed); //initial value 0% of progressbar
                        statustxt.html(completed); //set status text
                        statustxt.css('color','#000'); //initial color of status text
                    },
                    uploadProgress: function(event, position, total, percentComplete) { //on progress
                        progressbar.width(percentComplete + '%') //update progressbar percent complete
                        statustxt.html(percentComplete + '%'); //update status text
                        if(percentComplete>50)
                            {
                                statustxt.css('color','#fff'); //change status text to white after 50%
                            }
                        },
                    complete: function(response) { // on complete
                        
                        percentComplete = 100;
                        progressbar.width(percentComplete + '%') //update progressbar percent complete
                        statustxt.html(percentComplete + '%'); //update status text
                        statustxt.css('color','#fff'); //change status text to white after 50%
                        
                        output.html(response.responseText); //update element with received data
                        myform.resetForm();  // reset form
                        submitbutton.removeAttr('disabled'); //enable submit button
                        window.location = '/admin/images/viewall';
                        //progressbox.slideUp(); // hide progressbar
                    }
            });
        });

    </script>

    <script type="text/javascript">
        $(document).ready(function() {
        //elements
        var progressbox2     = $('#progressbox2');
        var progressbar2     = $('#progressbar2');
        var statustxt2       = $('#statustxt2');
        var submitbutton2    = $("#submit2");
        var myform2          = $("#UploadForm2");
        var output2          = $("#output2");
        var completed2       = '0%';
                
                $(myform2).ajaxForm({
                    beforeSend: function() { //brfore sending form
                        submitbutton2.attr('disabled', ''); // disable upload button
                        statustxt2.empty();
                        progressbox2.slideDown(); //show progressbar
                        progressbar2.width(completed2); //initial value 0% of progressbar
                        statustxt2.html(completed2); //set status text
                        statustxt2.css('color','#000'); //initial color of status text
                    },
                    uploadProgress: function(event, position, total, percentComplete) { //on progress
                        progressbar2.width(percentComplete + '%') //update progressbar percent complete
                        statustxt2.html(percentComplete + '%'); //update status text
                        if(percentComplete>50)
                            {
                                statustxt2.css('color','#fff'); //change status text to white after 50%
                            }
                        },
                    complete: function(response) { // on complete
                        
                        percentComplete = 100;
                        progressbar2.width(percentComplete + '%') //update progressbar percent complete
                        statustxt2.html(percentComplete + '%'); //update status text
                        statustxt2.css('color','#fff'); //change status text to white after 50%
                        
                        output2.html(response.responseText); //update element with received data
                        myform2.resetForm();  // reset form
                        submitbutton2.removeAttr('disabled'); //enable submit button
                        window.location = '/admin/images/viewall';
                        //progressbox.slideUp(); // hide progressbar
                    }
            });
        });

    </script>
    
                    
			<form id="UploadForm" method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="custom">
			
				<h2>Upload an Image</h2>
				<p>Upload any image file you want to use on your site. Want to add some folders before you start? <a href="<?php echo site_url('/admin/images/folders'); ?>">Add them now.</a></p>
				<label for="image">Image:</label>
				<div class="uploadfile hide-for-touch">
					<?php echo @form_upload('image', '', 'size="16" id="image"'); ?>
				</div>

				<div class="uploadfile show-for-touch">
					<input type="file" accept="/*" capture="camera" name="image" id="image">
				</div>
				
				<label for="imageName">Description (alt tag):</label>
				<?php echo @form_input('imageName', $images['imageName'], 'class="formelement" id="imageName"'); ?>

				<p class="tip">Note: You will want to add image folders before uploading your images.</p>
				<label for="imageFolderID">Folder: <small>[<a href="<?php echo site_url('/admin/images/folders'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')">update</a>]</small></label>
				<?php
					$options = '';		
					$options[0] = 'No Folder';
					if ($folders):
						foreach ($folders as $folderID):
							$options[$folderID['folderID']] = $folderID['folderName'];
						endforeach;
					endif;
						
					echo @form_dropdown('folderID',$options,set_value('folderID', $data['folderID']),'id="imageFolderID" class="formelement"');
				?>	

				<input type="submit" value="Save Changes" class="button nolabel" id="submit" />
				<a href="<?php echo site_url('/admin/images'); ?>" class="button cancel grey">Cancel</a>			
			</form>
                        <div id="progressbox"><div id="progressbar"></div ><div id="statustxt">0%</div ></div>
                        <a class="close-reveal-modal">&#215;</a>
		</div>

		<div id="upload-zip" class="hidden clear reveal-modal">
			<form id="UploadForm2" method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="custom">
				<h2>Upload a Zip File</h2>
				<p>If you have a lot of images to upload, add them all to a zip folder and upload them here!</p>
			
				<label for="image">ZIP File:</label>
				<div class="uploadfile hide-for-touch ">
					<?php echo @form_upload('zip', '', 'size="16" id="image"'); ?>
				</div>

				<label for="zipFolderID">Folder: <small>[<a href="<?php echo site_url('/admin/images/folders'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')">update</a>]</small></label>
				<?php
					$options[0] = 'No Folder';
					if ($folders):
						foreach ($folders as $folderID):
							$options[$folderID['folderID']] = $folderID['folderName'];
						endforeach;
					endif;
						
					echo @form_dropdown('folderID',$options,set_value('folderID', $data['folderID']),'id="zipFolderID" class="formelement"');
				?>
				<br class="clear" /><br />		

				<input type="submit" value="Upload Zip" name="upload_zip" class="button nolabel" id="submit2" />
				<a href="<?php echo site_url('/admin/images'); ?>" class="button cancel grey">Cancel</a>
			</form>
                        <div id="progressbox2"><div id="progressbar2"></div ><div id="statustxt2">0%</div ></div>
                        <a class="close-reveal-modal">&#215;</a>
		</div>

