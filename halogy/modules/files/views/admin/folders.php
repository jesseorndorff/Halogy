<script type="text/javascript">
function setOrder(){
	$.post('<?php echo site_url('/admin/files/order/folder'); ?>',$(this).sortable('serialize'),function(data){ });
};

function initOrder(el){
	$(el).sortable({ 
		axis: 'y',
	    revert: false, 
	    delay: '80',
	    opacity: '0.5',
	    update: setOrder
	});
};

$(function(){
	$('a.toggle').click(function(event){ 
		event.preventDefault();		
		$('div.hidden').slideToggle('400');
	});

	$('a.edit').click(function(event){
		event.preventDefault();
		$(this).parent().siblings('.col1').children('input').show();
		$(this).parent().siblings('.col1').children('span').hide();
	});

	initOrder('ol.order');
});
</script>

<div class="row">
	<div class="large-12 columns header">

		<h1 class="headingleft">File Folders</h1>

		<ul class="group-button">
			<li><a href="<?php echo site_url('/admin/files/viewall'); ?>" class="bluebutton">View Files</a></li>
			<li><a href="#" class="toggle green" data-reveal-id="file-folder-reveal">Add Folder</a></li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="large-12 columns body">

		<?php if ($folders): ?>
		<div class="large-6 columms">
			<form method="post" action="<?php echo site_url('/admin/files/edit_folder'); ?>">

				<ol class="order">
				<?php foreach ($folders as $folder): ?>
					<li id="file_folders-<?php echo $folder['folderID']; ?>">
						<div class="col1">
							<span><strong><?php echo $folder['folderName']; ?></strong></span>
							<?php echo @form_input($folder['folderID'].'[folderName]', $folder['folderName'], 'class="formelement hide" title="folder Name"'); ?><input type="submit" class="button green hide" value="Update" />
							<a class="button" href="<?php echo site_url('/admin/files/delete_folder/'.$folder['folderID']); ?>" onclick="return confirm('Are you sure you want to delete this?')"/>Delete</a>

						</div>

					</li>
				<?php endforeach; ?>
				</ol>

			</form>
		</div>
		<?php else: ?>

		<p>No folders have been created yet.</p>

		<?php endif; ?>
	</div>
</div>

<div id="file-folder-reveal" class="hidden reveal-modal">
	<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">
	
		<label for="folderName">Folder Name:</label>
		
		<?php echo @form_input('folderName',$files_folders['folderName'], 'class="formelement" id="folderName"'); ?>
			
		<input type="submit" value="Add Folder" id="submit" class="button" />
		
	</form>
	<a class="close-reveal-modal">&#215;</a>
</div>

