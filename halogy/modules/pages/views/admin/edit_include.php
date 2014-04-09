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
<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<h2>Edit 
					<?php echo ($type == 'C' || $type == 'J') ? 'File' : 'Include'; ?>
					<?php
						if ($type == 'C') $typeLink = 'css';
						elseif ($type == 'J') $typeLink = 'js';
						else $typeLink = '';
					?>
				</h2>
			</div>
			<div class="large-6 small-12 columns right">
				<a href="<?php echo site_url('/admin/pages/includes'); ?>/<?php echo $typeLink; ?>" class="small button radius">Back to Includes</a>
			</div>
		</div>
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
			<div class="item">
				<label for="includeRef">Filename:</label>
				<span>Your file will be found at &ldquo;/css/filename.css&rdquo; (make sure you use the '.css' extension).</p>
				<?php echo @form_input('includeRef',set_value('includeRef', $data['includeRef']), 'id="includeRef" class="formelement"'); ?>
				<?php echo @form_hidden('type', 'C'); ?>
			</div>
			<?php elseif ($type == 'J'): ?>
			<div class="item">
				<label for="includeRef">Filename:</label>
				<p>Your file will be found at &ldquo;/js/filename.js&rdquo; (make sure you use the '.js' extension).</p>
				<?php echo @form_input('includeRef',set_value('includeRef', $data['includeRef']), 'id="includeRef" class="formelement"'); ?>

				<?php echo @form_hidden('type', 'J'); ?>
			</div>
			<?php else: ?>
			<div class="item">
				<label for="includeRef">Reference:</label>
				<p>To access this include just use {include:REFERENCE} in your template.</p>
				<?php echo @form_input('includeRef',set_value('includeRef', $data['includeRef']), 'id="includeRef" class="formelement"'); ?>

				<?php echo @form_hidden('type', 'H'); ?>
			</div>
			<?php endif; ?>
			<div class="item">
				<label for="body">Markup:</label>	
				<?php echo @form_textarea('body',set_value('body', $data['body']), 'id="body" class="code editor"'); ?>

				<div class="autosave">
					<span class="autosave-saving">Saving...</span>
					<span class="autosave-complete"></span>
				</div>
			</div>
			<input type="submit" value="Save Changes" id="submit" class="button green" />
		</div>
		<div class="large-4 columns">
			<h3>Versions</h3>	

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


</form>	