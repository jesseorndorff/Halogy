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
        
        if ($(this).parent().siblings('.col1').children('input').is(":hidden"))
            {
                $(this).parent().siblings('.col1').children('input').show();
                $(this).parent().siblings('.col1').children('span').hide();
            }else{
                $(this).parent().siblings('.col1').children('input').hide();
                $(this).parent().siblings('.col1').children('span').show();
            }
        });

	initOrder('ol.order');
});
</script>
<div class="large-10 columns body">
	<h2 class="left">File Folders</h2>
	<div class="right">
		<a href="<?php echo site_url('/admin/files/viewall'); ?>" class="button">View Files</a>
		<a href="#" class="toggle button green" data-reveal-id="file-folder-reveal">Add Folder</a>
	</div>
	<div class="clear"></div>

		<?php if ($folders): ?>
			<form method="post" action="<?php echo site_url('/admin/files/edit_folder'); ?>">

				<ul class="small-block-grid-1 large-block-grid-4">
				<?php foreach ($folders as $folder): ?>
					<li id="file_folders-<?php echo $folder['folderID']; ?>">
						<div class="card">
							<div class="">
								<h3><?php echo $folder['folderName']; ?></h3>
								<?php echo @form_input($folder['folderID'].'[folderName]', $folder['folderName'], 'class="formelement hide" title="folder Name"'); ?><input type="submit" class="button green small" value="Save" />
							</div>
							<div class="card-admin">
								<a href="#" class="edit">Edit</a>
								<a href="<?php echo site_url('/admin/files/delete_folder/'.$folder['folderID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="">Delete</a>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
				</ul>

			</form>
		<?php else: ?>

		<p>No folders have been created yet.</p>

		<?php endif; ?>
</div>

<div id="file-folder-reveal" class="hidden reveal-modal">
	<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">
	
		<label for="folderName">Folder Name:</label>
		
		<?php echo @form_input('folderName',$files_folders['folderName'], 'class="formelement" id="folderName"'); ?>
			
		<input type="submit" value="Add Folder" id="submit" class="button" />
		
	</form>
	<a class="close-reveal-modal">&#215;</a>
</div>

