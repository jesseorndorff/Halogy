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
<div class="large-12 columns body">
	<div class="card">
		<h2>Page Templates</h2>

		<div class="right">
			<a href="<?php echo site_url('/admin/pages/includes'); ?>" class="button">View Includes</a>
			<a data-reveal-id="zipUpload" href="#" class="button toggle-zip">Import Theme</a>
			<a href="<?php echo site_url('/admin/pages/add_template'); ?>" class="button green">Add Template</a>
		</div>

			<div class="row">
				<div class="large-4 columns">
					<label for="filter">Filter</label> 

					<?php
						$options = array(
							'' => 'View All',
							'page' => 'Page Templates',
							'module' => 'Module Templates'
						);
						
						echo form_dropdown('filter', $options, $type, 'id="filter"');
					?>
				</div>
			</div>

			<?php if ($errors = validation_errors()): ?>
				<div class="error clear">
					<?php echo $errors; ?>
				</div>
			<?php endif; ?>

			<?php if ($templates): ?>

			<?php echo $this->pagination->create_links(); ?>
			<div class="row table-header hide-for-touch">
				<div class="large-5 columns">
					<h3>Templates</h3>
				</div> 
				<div class="large-3 columns">
					<h3>Date Modified</h3>
				</div>
				<div class="large-2 columns">
					<h3>Usage</h3>
				</div>
				<div class="large-2 columns">
					<h3>	</h3>
				</div> 
			</div>
				<?php
					$i = 0;
					foreach ($templates as $template): 
					$class = ($i % 2) ? 'alt' : ''; $i++;
				?>
			<div class="row table <?php echo $class;?>">
					<div class="small-6 large-5 columns">
						<h4 class="show-for-small">Template: </h4>
						<p><?php echo anchor('/admin/pages/edit_template/'.$template['templateID'], ($template['modulePath'] != '') ? '<strong>Module</strong>: '.$template['modulePath'].' <em>('.ucfirst(preg_replace('/^(.+)_/i', '', $template['modulePath'])).')</em>' : $template['templateName']); ?></p>
					</div>
					<div class="small-6 large-3 columns">
						<h4 class="show-for-small">Date Modified: </h4>
						<p><?php echo dateFmt($template['dateCreated']); ?></p>
					</div>
					<div class="small-6 large-2 columns">
						<h4 class="show-for-small">Usage: </h4>
						<?php if ($this->pages->get_template_count($template['templateID']) > 0): ?>
							<p><?php echo $this->pages->get_template_count($template['templateID']); ?> page(s)</p>
						<?php endif; ?></td>
					</div>
					<div class="small-12 large-2 columns buttons">
						<ul class="button-group even-2">
							<li><?php echo anchor('/admin/pages/edit_template/'.$template['templateID'], 'Edit', array('class' => 'button small grey')); ?></li>
							<li><?php echo anchor('/admin/pages/delete_template/'.$template['templateID'], 'Delete', array('class' => 'button alert small', 'onClick' => 'return confirm(\'Are you sure you want to delete this?\')')); ?></li>
						</ul>
					</div>
			</div>
			<?php endforeach; ?>

			<!--<table class="default">
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
			</table> -->

			<?php echo $this->pagination->create_links(); ?>

			<?php else: ?>

			<p>There are no templates here yet.</p>

			<?php endif; ?>
	</div>
</div>

		<div id="zipUpload" class="reveal-modal">
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


