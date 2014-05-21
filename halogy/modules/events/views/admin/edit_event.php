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
<form name="form" method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="">
<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="large-4 small-12 columns left">
				<h2>Edit Event</h2>
				<a href="<?php echo site_url('/admin/events'); ?>">Back to Events</a>
			</div>
			<div class="large-6 small-12 columns right">
				<input type="submit" value="Save Changes" class="button small radius success">
			</div>
		</div>

		<?php if ($errors = validation_errors()): ?>
			<div class="large-12 columns error">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>
		<?php if (isset($message)): ?>
			<div class="large-12 columns message">
				<?php echo $message; ?>
			</div>
		<?php endif; ?>
		<div class="clear"></div>		
		<div class="large-12 columns">
			<dl class="tabs vertical" data-tab>
				<dd class="active"><a href="#panel2-1">Detail</a></dd>
				<dd><a href="#panel2-2">Description</a></dd>
				<dd><a href="#panel2-3">Publishing</a></dd>
			</dl>

			<div class="tabs-content">
				<div class="content active" id="panel2-1">
					<div class="row">
						<div class="small-12 large-6 columns large-centered">
							<h3>Place and Time</h3>
							<div class="item">
								<label for="eventName">Event Title:</label>
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
						</div>
					</div>
				</div>
				
				<div class="content" id="panel2-2">
					<div class="row">
						<div class="small-12 large-6 columns large-centered">
							<h3>Event Description</h3>
							<div class="item">
								<label for="body">Body:</label>
								<?php echo @form_textarea('description', set_value('description', $data['description']), 'id="body" class="formelement code half"'); ?>
							</div>
							<div class="item">
								<label for="excerpt">Excerpt:</label>
								<?php echo @form_textarea('excerpt', set_value('excerpt', $data['excerpt']), 'id="excerpt" class="formelement code short"'); ?>
							</div>
						</div>
					</div>
				</div>

				<div class="content" id="panel2-3">
					<div class="row">
						<div class="small-12 large-6 columns large-centered">
							<h3>Publishing</h3>
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
								<label for="tags">Tags:</label>
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>