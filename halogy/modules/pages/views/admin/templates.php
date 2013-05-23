<script type="text/javascript">
$(function(){
	$('div.hidden').hide();
	$('a.showform').click(function(event){ 
		event.preventDefault();
		$('div.hidden div.inner').load('/templates/add/');		
		$('div.hidden').fadeIn();
	});
	$('p.hide a').click(function(event){ 
		event.preventDefault();		
		$(this).parent().parent().fadeOut();
	});
	$('.toggle-zip').click(function(event){ 
		event.preventDefault();		
		$('div#upload-zip').toggle('400');
		$('div#upload-image:visible, div#loader:visible').toggle('400');
	});
	$('select#filter').change(function(){
		var status = ($(this).val());
		window.location.href = '<?php echo site_url('/admin/pages/templates'); ?>/'+status;
	});
});
</script>

<div class="row">
	<div class="large-12 columns header">
		<h1 class="headingleft">Page Templates</h1>
		<ul class="group-button">
			<li><a href="<?php echo site_url('/admin/pages/includes'); ?>" class="bluebutton">Includes</a></li>
			<li><a href="#" class="bluebutton toggle-zip" data-reveal-id="myModal">Import Theme</a></li>
			<li><a href="<?php echo site_url('/admin/pages/add_template'); ?>" class="green">Add Template</a></li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="large-12 columns body">
		<div class="large-4 large-offset-8 columns">
			<label for="filter">
				Filter
			</label> 

			<?php
				$options = array(
					'' => 'View All',
					'page' => 'Page Templates',
					'module' => 'Module Templates'
				);
				
				echo form_dropdown('filter', $options, $type, 'id="filter"');
			?>
		</div>
		<?php if ($errors = validation_errors()): ?>
			<div class="error clear">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>
		<div id="myModal" class="reveal-modal">
			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" enctype="multipart/form-data" class="default">
				<h2>Import Your Theme</h2>
				<p>Importing your custom theme is simple. Just zip up your HTML, CSS, JS files and upload the zip here!</p>
				<label for="image">ZIP File:</label>
				<div class="uploadfile">
					<?php echo @form_upload('zip', '', 'size="16" id="image"'); ?>
				</div>
				<input type="submit" value="Import Theme" name="upload_zip" class="green" id="submit" />
				<a href="<?php echo site_url('/admin/pages/templates'); ?>" class="button cancel grey">Cancel</a>
				<a class="close-reveal-modal">&#215;</a>
			</form>
		</div>

		<?php if ($templates): ?>

		<?php echo $this->pagination->create_links(); ?>

		<table class="default">
			<thead>
				<tr>
					<th>Templates</th>
					<th>Date Modified</th>		
					<th>Usage</th>	
					<th>&nbsp;</th>
					<th>&nbsp;</th>		
				</tr>
			</thead>
		<?php
			$i = 0;
			foreach ($templates as $template): 
			$class = ($i % 2) ? ' class="alt"' : ''; $i++;
		?>
			<tbody>
				<tr<?php echo $class;?>>
					<td><?php echo anchor('/admin/pages/edit_template/'.$template['templateID'], ($template['modulePath'] != '') ? '<small>Module</small>: '.$template['modulePath'].' <em>('.ucfirst(preg_replace('/^(.+)_/i', '', $template['modulePath'])).')</em>' : $template['templateName']); ?></td>
					<td><?php echo dateFmt($template['dateCreated']); ?></td>		
					<td><?php if ($this->pages->get_template_count($template['templateID']) > 0): ?>
							<?php echo $this->pages->get_template_count($template['templateID']); ?> page(s)
						<?php endif; ?></td>
					<td>
						<?php echo anchor('/admin/pages/edit_template/'.$template['templateID'], 'Edit'); ?>
					</td>
					<td>
						<?php echo anchor('/admin/pages/delete_template/'.$template['templateID'], 'Delete', 'onclick="return confirm(\'Are you sure you want to delete this?\')"'); ?>
					</td>
				</tr>
			</tbody>
		<?php endforeach; ?>
		</table>

		<?php echo $this->pagination->create_links(); ?>

		<?php else: ?>

		<p>There are no templates here yet.</p>

		<?php endif; ?>

	</div>
</div>



