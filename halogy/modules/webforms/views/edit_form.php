<script type="text/javascript">
function showGroup(){
	if ($('select#account').val() == 0){
		$('div.showGroup').hide();
	} else {
		$('div.showGroup').fadeIn();
	}
}
$(function(){
	$('select#account').change(function(){
		showGroup();
	});
	showGroup();
});
</script>

<form name="form" method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">

<div class="row">
	<div class="large-12 columns header">
	
		<h1 class="headingleft">Edit Web Form</h1>
		<ul class="group-button">
			<li><a href="<?php echo site_url('/admin/webforms/viewall'); ?>" class="bluebutton">Back to Web Forms</a></li>
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
		<?php if (isset($message)): ?>
			<div class="message">
				<?php echo $message; ?>
			</div>
		<?php endif; ?>

		<div class="large-6 columns">

			<label for="formName">Form Name:</label>
			<?php echo @form_input('formName', set_value('formName', $data['formName']), 'id="formName" class="formelement"'); ?>
			
			<label for="fieldSet">Type of Form:</label>
			<?php 
				$values = array(
					1 => 'Enquiry Form',
					2 => 'Newsletter',
					0 => 'Custom'
				);
				echo @form_dropdown('fieldSet',$values,set_value('fieldSet', $data['fieldSet']), 'id="fieldSet" class="formelement"'); 
			?>
			<span class="tip">Automatically populate your form with fields based on the type, or select 'Custom' to not populate with fields.</span>
			
			<label for="fileTypes">Allow Files?</label>
			<?php 
				$values = array(
					'' => 'Don\'t allow files',
					'jpg|gif|png|jpeg' => 'Allow images',
					'doc|pdf|txt|rtf|xls' => 'Allow documents',
					'jpg|gif|png|jpeg|doc|pdf|txt|rtf|xls|swf' => 'Allow images and documents',
					'jpg|gif|png|jpeg|doc|pdf|txt|rtf|xls|swf|mp3|mp4' => 'Allow all files'
				);
				echo @form_dropdown('fileTypes',$values,set_value('fileTypes', $data['fileTypes']), 'id="fileTypes" class="formelement"'); 
			?>
			<span class="tip">You can allow users to upload files such as images and documents if you wish. Form must have the correct enctype.</span>


			<h2 class="underline">Outcomes <small>(optional)</small></h2>	

			<label for="account">Create User Account?</label>
			<?php 
				$values = array(
					0 => 'No',
					1 => 'Yes',
				);
				echo @form_dropdown('account',$values,set_value('account', $data['account']), 'id="account" class="formelement"'); 
			?>
			<span class="tip">Optionally create user account.</span>

			<div class="showGroup">
				<label for="groupID">Move to Group:</label>
				<?php 
					$values = array(
						0 => 'None'
					);		
					if ($groups)
					{
						foreach($groups as $group)
						{
							$values[$group['groupID']] = $group['groupName'];
						}
					}
					echo @form_dropdown('groupID',$values,set_value('groupID', $data['groupID']), 'id="groupIDs" class="formelement"'); 
				?>
				<span class="tip">You can only move the user to a group without admin permissions.</span>
			</div>	

			<label for="outcomeEmails">Emails to CC:</label>
			<?php echo @form_input('outcomeEmails', set_value('outcomeEmails', $data['outcomeEmails']), 'id="outcomeEmails" class="formelement"'); ?>
			<span class="tip">This will override the default email that the ticket is CCed to. Separate emails with a comma.</span>

			<label for="outcomeRedirect">Redirect:</label>
			<?php echo @form_input('outcomeRedirect', set_value('outcomeRedirect', $data['outcomeRedirect']), 'id="outcomeRedirect" class="formelement"'); ?>
			<span class="tip">Here you can redirect the user to a URL on your website if you wish (e.g. form/success).</span>

			<label for="outcomeMessage">Message:</label>
			<?php echo @form_textarea('outcomeMessage', set_value('outcomeMessage', $data['outcomeMessage']), 'id="outcomeMessage" class="formelement small"'); ?>
			<span class="tip nolabel">Here you can display a custom message after the user submits the form.</span>

		</div>
	</div>
</div>
</form>
