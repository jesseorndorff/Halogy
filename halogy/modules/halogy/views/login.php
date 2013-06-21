<?php
	if(!$this->session->userdata('session_admin')) {
?>

	<script type="text/javascript">
	$(function(){
		$('#username').focus();
	});
	</script>

<div class="row">
	<div class="large-12 columns body">
		<div class="large-6 columns">
			<img src="<?php echo site_url('/static/images/halogy.png'); ?>">
			<p>Welcome to your Halogy site! Please enter your login details on the left. If you need access, make sure to email your website administrator.</p>
		</div>
		<div class="large-6 columns">
			<h1>Login</h1>
			
			<?php if ($errors = validation_errors()): ?>
				<div class="error">
					<?php echo $errors; ?>
				</div>
			<?php endif; ?>
			
			<form action="" method="post" class="default">
							
				<label for="username">Username:</label>
				<input type="text" id="username" name="username" class="formelement" />
			
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" class="formelement" />

				<br class="clear" /><br />
				<input type="submit" id="login" name="login" value="Login" class="button nolabel" />
			
			</form>

			<?php
				} else {
			?>

				<h1>Logout</h1>

				<p><a href="/login/logout/">Click here to logout.</a></p>
				
			<?php
				}
			?>
		</div>

	</div>
</div>