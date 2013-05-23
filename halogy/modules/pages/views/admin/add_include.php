<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">
<div class="row">
	<div class="large-12 columns header">
		<h1 class="headingleft">Add 
			<?php echo ($type == 'css' || $type == 'js') ? 'File' : 'Include'; ?>
			<?php
				if ($type == 'C') $typeLink = 'css';
				elseif ($type == 'J') $typeLink = 'js';
				else $typeLink = '';
			?>
		</h1>

		<ul class="group-button">
			<li><a href="<?php echo site_url('/admin/pages/includes/'.$typeLink); ?>" class="bluebutton">Back to Includes</a></li>
			<li><input type="submit" value="Save Changes" class="green" /></li>
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

		<div class="large-6 columns">

			<?php if ($type == 'css'): ?>

				<label for="includeRef">Filename:</label>
				<?php echo @form_input('includeRef',set_value('includeRef', $data['includeRef']), 'id="includeRef" class="formelement"'); ?>
				<span class="tip">Your file will be found at &ldquo;/css/filename.css&rdquo; (make sure you use the '.css' extension).</span><br class="clear" />

				<?php echo @form_hidden('type', 'C'); ?>

			<?php elseif ($type == 'js'): ?>

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
					<label for="body">Markup:</label>	
					<?php echo @form_textarea('body',set_value('body', $data['body']), 'id="body" class="code editor"'); ?>
					<br class="clear" />
				</div>
			</div>
	</div>
</div>
	
</form>