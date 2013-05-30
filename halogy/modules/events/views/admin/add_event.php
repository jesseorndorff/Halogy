<script type="text/javascript">
function preview(el){
	$.post('<?php echo site_url('/admin/events/preview'); ?>', { body: $(el).val() }, function(data){
		$('div.preview').html(data);
	});
}
$(function(){
	$('input.datebox').datepicker({dateFormat: 'M dd yy'});
	$('textarea#body').focus(function(){
		$('.previewbutton').show();
	});
	$('textarea#body').blur(function(){
		preview(this);
	});
	preview($('textarea#body'));	
});
</script>

<div class="row">
	<div class="large-12 columns body">

		<form name="form" method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="custom">
			
			<h1 class="headingleft">Add Event</h1>
			
			<ul class="group-button">
				<li><a href="<?php echo site_url('/admin/events'); ?>" class="button">Back to Events</a></li>
				<li><input type="submit" value="Save Changes" class="button green" /></li>
			</ul>
			
			<hr>
			
			<?php if ($errors = validation_errors()): ?>
				<div class="error">
					<?php echo $errors; ?>
				</div>
			<?php endif; ?>

			<div class="large-6 small-12 large-centered columns">

				<h2 class="underline">Place and Time</h2>

				<div class="item">
					<label for="eventName">Event title:</label>
					<?php echo @form_input('eventTitle', set_value('eventTitle', $data['eventTitle']), 'id="eventTitle" class="formelement"'); ?>
				</div>

				<div class="item">
					<label for="eventDate">Start Date:</label>
					<?php echo @form_input('eventDate', date('M d Y', strtotime($data['eventDate'])), 'id="eventDate" class="formelement datebox" readonly="readonly"'); ?>
				</div>

				<div class="item">
					<label for="eventEnd">End Date:</label>
					<p>This is optional and useful if the event goes on for more than one day.</p>
					<?php echo @form_input('eventEnd', (($data['eventEnd'] > 0) ? date('M d Y', strtotime($data['eventEnd'])) : ''), 'id="eventEnd" class="formelement datebox" readonly="readonly"'); ?>
				</div>

				<div class="item">
					<label for="time">Time:</label>
					<?php echo @form_input('time', set_value('time', $data['time']), 'id="time" class="formelement"'); ?>
				</div>

				<div class="item">
					<label for="location">Location:</label>
					<?php echo @form_input('location', set_value('location', $data['location']), 'id="location" class="formelement"'); ?>
				</div>

				<h2 class="underline">Event Description</h2>	

				<!-- <div class="buttons">
					<a href="#" class="boldbutton"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_bold.png" alt="Bold" title="Bold" /></a>
					<a href="#" class="italicbutton"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_italic.png" alt="Italic" title="Italic" /></a>
					<a href="#" class="h1button"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_h1.png" alt="Heading 1" title="Heading 1"/></a>
					<a href="#" class="h2button"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_h2.png" alt="Heading 2" title="Heading 2" /></a>
					<a href="#" class="h3button"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_h3.png" alt="Heading 3" title="Heading 3" /></a>	
					<a href="#" class="urlbutton"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_url.png" alt="Insert Link" title="Insert Link" /></a>
					<a href="<?php echo site_url('/admin/images/browser'); ?>" class="halogycms_imagebutton"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_image.png" alt="Insert Image" title="Insert Image" /></a>
					<a href="<?php echo site_url('/admin/files/browser'); ?>" class="halogycms_filebutton"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_file.png" alt="Insert File" title="Insert File" /></a>
					<a href="#" class="previewbutton"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_save.png" alt="Preview" title="Preview" /></a>	
				</div> -->

				<div class="item">
					<label for="body">Body:</label>
					<?php echo @form_textarea('description', set_value('description', $data['description']), 'id="body" class="formelement code half"'); ?>
				<div class="preview"></div>
				</div>

				<div class="item">
					<label for="excerpt">Excerpt:</label>
					<?php echo @form_textarea('excerpt', set_value('excerpt', $data['excerpt']), 'id="excerpt" class="formelement code short"'); ?>
				</div>

				<h2 class="underline">Publishing</h2>
				
				<div class="item">
					<label for="featured">Featured:</label>
					<?php 
						$values = array(
							0 => 'No',
							1 => 'Yes',
						);
						echo @form_dropdown('featured',$values,set_value('featured', $data['featured']), 'id="featured"'); 
					?>
				</div>

				<div class="item">
					<label for="tags">Tags: <br /></label>
					<p>Separate tags with spaces (e.g. &ldquo;event popular london&rdquo;)</p>
					<?php echo @form_input('tags', set_value('tags', $data['tags']), 'id="tags" class="formelement"'); ?>
				</div>

				<div class="item">
					<label for="published">Publish:</label>
					<?php 
						$values = array(
							1 => 'Yes',
							0 => 'No (save as draft)',
						);
						echo @form_dropdown('published',$values,set_value('published', $data['published']), 'id="published"'); 
					?>
				</div>
				
		</form>

	</div>
</div>
