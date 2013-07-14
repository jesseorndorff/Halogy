<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">
<div class="large-10 columns body">
	<h2>Add 
		<?php echo ($type == 'css' || $type == 'js') ? 'File' : 'Include'; ?>
		<?php
			if ($type == 'C') $typeLink = 'css';
			elseif ($type == 'J') $typeLink = 'js';
			else $typeLink = '';
		?>
	</h2>
		
	<a href="<?php echo site_url('/admin/pages/includes/'.$typeLink); ?>" class="button right">Back to Includes</a>
	<ul class="breadcrumbs">
		<li><a href="#">Home</a></li>
		<li><a href="#">Templates</a></li>
		<li class="current"><a href="#">Add Include</a></li>
	</ul>
		<?php if ($errors = validation_errors()): ?>
			<div class="error">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>

		<div class="large-8 columns">

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

			<div class="markup">
				<label for="body">Markup:</label>	
				<?php echo @form_textarea('body',set_value('body', $data['body']), 'id="body" class="code editor"'); ?>
				<br class="clear" />
			</div>
			<input type="submit" value="Save Changes" class="button green" />
		</div>

		<div class="large-4 columns">
			<div data-alert class="module-tip hide-for-small">
				<p>Adding an template is easy! We recommend working in your own code editor, like Sublime Text, then pasting your final markup in this area.</p>
			</div>
		</div>
	</div>
</div>
	
</form>