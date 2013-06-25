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
	<div class="large-12 columns body">
		<div class="row">
			<div class="large-7 columns">
				<h1 class="headingleft">Edit 
					<?php echo ($type == 'C' || $type == 'J') ? 'File' : 'Include'; ?>
					<?php
						if ($type == 'C') $typeLink = 'css';
						elseif ($type == 'J') $typeLink = 'js';
						else $typeLink = '';
					?>
				</h1>
			</div>
			<div class="large-5 columns">
				<a href="<?php echo site_url('/admin/pages/includes'); ?>/<?php echo $typeLink; ?>" class="button right">Back to Includes</a>
			</div>
		</div> <!-- /row -->
		<hr>

		<div class="large-8 columns">

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
				<p class="tip">To access this include just use {include:REFERENCE} in your template.</p>
				<?php echo @form_input('includeRef',set_value('includeRef', $data['includeRef']), 'id="includeRef" class="formelement"'); ?>

				<?php echo @form_hidden('type', 'H'); ?>

			<?php endif; ?>

			<label for="body">Markup:</label>	
			<?php echo @form_textarea('body',set_value('body', $data['body']), 'id="body" class="code editor"'); ?>

			<div class="autosave">
				<span class="autosave-saving">Saving...</span>
				<span class="autosave-complete"></span>
			</div>

			<input type="submit" value="Save Changes" id="submit" class="button green" />
		</div>
			<div class="large-4 columns">
				<h2>Versions</h2>	

				<ul class="versions">
				<?php if ($versions): ?>
					<?php foreach($versions as $version): ?>
						<li>
							<?php if ($data['versionID'] == $version['versionID']): ?>
								<strong><?php echo dateFmt($version['dateCreated'], '', '', TRUE).(($user = $this->core->lookup_user($version['userID'], TRUE)) ? ' <em>(by '.$user.')</em>' : ''); ?></strong>
							<?php else: ?>
								<?php echo dateFmt($version['dateCreated'], '', '', TRUE).(($user = $this->core->lookup_user($version['userID'], TRUE)) ? ' <em>(by '.$user.')</em>' : ''); ?> <?php echo anchor('/admin/pages/revert_include/'.$version['objectID'].'/'.$version['versionID'], 'Revert', array('class' => 'button small grey right', 'onClick' => 'return confirm(\'You will lose unsaved changes. Continue?\');')); ?>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>	
				<?php endif; ?>
				</ul>
			</div>
		</div>	
	</div>
</div>


</form>	