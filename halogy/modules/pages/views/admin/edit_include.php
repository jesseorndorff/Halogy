<script type="text/javascript">
$(function(){
	$('input#submit').click(function(){
		$('span.autosave-saving').fadeIn('fast');
		$.post('<?php echo site_url($this->uri->uri_string()); ?>', {
				includeRef: $('#includeRef').val(),
				body: $('#body').val()
		}, function(data){
			$('span.autosave-saving').fadeOut('fast');
			$('span.autosave-complete').text(data).fadeIn('fast').delay(3000).fadeOut('fast');
		});
		return false;
	});
});
</script>

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">

<div class="row">
	<div class="large-12 columns header">

		<h1 class="headingleft">Edit 
			<?php echo ($type == 'C' || $type == 'J') ? 'File' : 'Include'; ?>
			<?php
				if ($type == 'C') $typeLink = 'css';
				elseif ($type == 'J') $typeLink = 'js';
				else $typeLink = '';
			?>
		</h1>
	
		<ul class="group-button">
			<li><a href="<?php echo site_url('/admin/pages/includes'); ?>/<?php echo $typeLink; ?>" class="bluebutton">Back to Includes</a></li>
			<li><input type="submit" value="Save Changes" id="submit" class="green" /></li>
		</ul>
	</div>
</div>
	
<div class="row">
	<div class="large-12 columns body">	
		<?php if ($errors = validation_errors()): ?>
			<div class="error">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>
		<?php if (isset($message)): ?>
			<div class="message">
				<?php echo $message; ?>
			</div>
		<?php endif; ?>

		<div class="large-6 columns">

		<?php if ($type == 'C'): ?>

			<label for="includeRef">Filename:</label>
			<?php echo @form_input('includeRef',set_value('includeRef', $data['includeRef']), 'id="includeRef" class="formelement"'); ?>
			<span class="tip">Your file will be found at &ldquo;/css/filename.css&rdquo; (make sure you use the '.css' extension).</span><br class="clear" />

			<?php echo @form_hidden('type', 'C'); ?>

		<?php elseif ($type == 'J'): ?>

			<label for="includeRef">Filename:</label>
			<?php echo @form_input('includeRef',set_value('includeRef', $data['includeRef']), 'id="includeRef" class="formelement"'); ?>
			<span class="tip">Your file will be found at &ldquo;/js/filename.js&rdquo; (make sure you use the '.js' extension).</span><br class="clear" />

			<?php echo @form_hidden('type', 'J'); ?>

		<?php else: ?>

			<label for="includeRef">Reference:</label>
			<?php echo @form_input('includeRef',set_value('includeRef', $data['includeRef']), 'id="includeRef" class="formelement"'); ?>
			<span class="tip">To access this include just use {include:REFERENCE} in your template.</span><br class="clear" />

			<?php echo @form_hidden('type', 'H'); ?>

		<?php endif; ?>

			<div class="autosave">
				<span class="autosave-saving">Saving...</span>
				<span class="autosave-complete"></span>
			</div>
		</div>
		<div class="large-12 columns markup">
				<label for="body">Markup:</label>	
				<?php echo @form_textarea('body',set_value('body', $data['body']), 'id="body" class="code editor"'); ?>
				<br class="clear" />

			<h2>Versions</h2>	

			<ul>
			<?php if ($versions): ?>
				<?php foreach($versions as $version): ?>
					<li>
						<?php if ($data['versionID'] == $version['versionID']): ?>
							<strong><?php echo dateFmt($version['dateCreated'], '', '', TRUE).(($user = $this->core->lookup_user($version['userID'], TRUE)) ? ' <em>(by '.$user.')</em>' : ''); ?></strong>
						<?php else: ?>
							<?php echo dateFmt($version['dateCreated'], '', '', TRUE).(($user = $this->core->lookup_user($version['userID'], TRUE)) ? ' <em>(by '.$user.')</em>' : ''); ?> - <?php echo anchor('/admin/pages/revert_include/'.$version['objectID'].'/'.$version['versionID'], 'Revert', 'onclick="return confirm(\'You will lose unsaved changes. Continue?\');"'); ?>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>	
			<?php endif; ?>
			</ul>

		</div>	
	</div>
</div>


</form>	