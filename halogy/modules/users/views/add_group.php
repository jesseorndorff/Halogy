<script type="text/javascript">
$(function(){
	$flag = false;
	$('div.permissions input[type="checkbox"]').each(function(){
		if ($(this).prop('checked')) {
			$(this).parent('div').prev('div').children('input[type="checkbox"]').prop('checked', true);
		}
	});
	$('.selectall').click(function(){
		$el = $(this).parent('div').next('div').children('input[type="checkbox"]');
		$flag = $(this).prop('checked');
		if ($flag) {
			$($el).prop('checked', true);
		}
		else {
			$($el).prop('checked', false);
		}
	});
	$('.seemore').click(function(){
		$el = $(this).parent('div').next('div');
		$($el).toggle('400');
	});
	$('a.selectall').click(function(event){
		event.preventDefault();
		$('input[type="checkbox"]').prop('checked', true);
	});
	$('a.deselectall').click(function(event){
		event.preventDefault();
		$('input[type="checkbox"]').prop('checked', false);
	});	
});
</script>

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="">

<div class="large-10 columns body">
	<div class="small-12 large-12 large-centered columns card">
		<h2 class="left">Add User Group</h2>
		<div class="right">
			<a href="<?php echo site_url('/admin/users/groups'); ?>" class="button">Back to User Groups</a>
			<input type="submit" value="Save Changes" class="button green">
		</div>
		<div class="clear"></div>
		<?php if ($errors = validation_errors()): ?>
			<div class="error">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>

		<label for="groupName">Name this group:</label>
		<?php echo @form_input('groupName',set_value('groupName', $data['groupName']), 'id="groupName" class="formelement"'); ?>

		<hr>
		<?php if ($permissions): ?>

			<h3>Administrative Permissions</h3>
			<p><a href="#" class="selectall button small nolabel grey">Select All</a> <a href="#" class="deselectall button small grey">De-Select All</a></p>
			<?php foreach ($permissions as $cat => $perms): ?>

				<div class="perm-heading">
					<label for="<?php echo strtolower($cat); ?>_all" class="radio"><?php echo $cat; ?></label>
					<input type="checkbox" class="selectall checkbox" id="<?php echo strtolower($cat); ?>_all" />
					<input type="button" value="See more" class="seemore button" />
				</div>

				<div class="permissions">

				<?php foreach ($perms as $perm): ?>

					<label for="<?php echo 'perm_'.$perm['key']; ?>" class="radio"><?php echo $perm['permission']; ?></label>
					<?php echo @form_checkbox('perm'.$perm['permissionID'], 1, set_value('perm'.$perm['permissionID'], $data['perm'.$perm['permissionID']]), 'id="'.'perm_'.$perm['key'].'" class="checkbox"'); ?>
					<br class="clear" />

				<?php endforeach; ?>

				</div>

			<?php endforeach; ?>

		<?php endif; ?>
	</div>
</div>
</form>
