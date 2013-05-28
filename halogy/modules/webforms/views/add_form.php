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
	<div class="large-12 columns body">
	
		<h1 class="headingleft">Add Web Form</h1>
	
		<ul class="group-button">
			<li><a href="<?php echo site_url('/admin/webforms/viewall'); ?>" class="bluebutton">Back to Web Forms</a></li>
			<li><input type="submit" value="Save Changes" class="green" /></li>
		</ul>

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

			<hr>

		<div class="large-6 small-12 large-centered columns">

			<div class="item">
				<label for="formName">Form Name</label>
				<p>Give your form a name.</p>
				<?php echo @form_input('formName', set_value('formName', $data['formName']), 'id="formName" class="formelement" placeholder="Form name here.."'); ?>
			</div>
			<div class="item">
				<label for="fieldSet">Type of Form</label>
				<p>What type of form would you like to create? Select 'Custom' to populate with your own fields.</p>
				<?php 
					$values = array(
						1 => 'Enquiry Form',
						2 => 'Newsletter',
						0 => 'Custom'
					);
					echo @form_dropdown('fieldSet',$values,set_value('fieldSet', $data['fieldSet']), 'id="fieldSet" class="formelement"'); 
				?>
			</div>
			<div class="item">
				<label for="fileTypes">Allow Files?</label>
				<p>You can allow users to upload files such as images and documents if you wish. Form must have the correct enctype.</p>
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

			</div>
			<div class="item">
				<label for="account">Create User Account?</label>
				<p>This is optional. This will create a user account for anyone who fills out your form.</p>
				<?php 
					$values = array(
						0 => 'No',
						1 => 'Yes',
					);
					echo @form_dropdown('account',$values,set_value('account', $data['account']), 'id="account" class="formelement"'); 
				?>
			</div>

			<div class="item">
				<div class="showGroup">
					<label for="groupID">Move to Group:</label>
					<p>You can assign a user to a specific group. You can even give them admin rights.</p>
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
				</div>	

			</div>
			<div class="item">
				<label for="outcomeEmails">Emails to CC</label>
				<p>This will override the default email that the ticket is CCed to. Separate emails with a comma.</p>
				<?php echo @form_input('outcomeEmails', set_value('outcomeEmails', $data['outcomeEmails']), 'id="outcomeEmails" class="formelement"'); ?>
			</div>
			<div class="item">
				<label for="outcomeRedirect">Redirect</label>
				<p>Here you can redirect the user to a URL on your website if you wish (e.g. form/success).</p>
				<?php echo @form_input('outcomeRedirect', set_value('outcomeRedirect', $data['outcomeRedirect']), 'id="outcomeRedirect" class="formelement"'); ?>
			</div>
			<div class="item">
				<label for="outcomeMessage">Message</label>
				<p>Here you can display a custom message after the user submits the form.</p>
				<?php echo @form_textarea('outcomeMessage', set_value('outcomeMessage', $data['outcomeMessage']), 'id="outcomeMessage" class="formelement small"'); ?>
			</div>
		</div>
	</div>
</div>
</form>
