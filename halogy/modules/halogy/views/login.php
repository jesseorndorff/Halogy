<?php
	if(!$this->session->userdata('session_admin')) {
?>

	<script type="text/javascript">
	$(function(){
		$('#username').focus();
	});
	</script>

<div class="row">
	<div class="large-4 small-12 large-centered columns login-screen">
		<img src="<?php echo site_url('/static/images/halogy.png'); ?>">
			<?php if ($errors = validation_errors()): ?>
				<div class="error">
					<?php echo $errors; ?>
				</div>
			<?php endif; ?>
			
			<form action="" method="post" class="default">
							
				<label for="username">Username:</label>
				<input type="text" id="username" name="username" class="formelement" placeholder="Username"/>
			
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" class="formelement" placeholder="Password"/>

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