<!-- <style type="text/css">
.ac_results { padding: 0px; border: 1px solid black; background-color: white; overflow: hidden; z-index: 99999; }
.ac_results ul { width: 100%; list-style-position: outside; list-style: none; padding: 0; margin: 0; }
.ac_results li { margin: 0px; padding: 2px 5px; cursor: default; display: block; font: menu; font-size: 12px; line-height: 16px; overflow: hidden; }
.ac_results li span.email { font-size: 10px; } 
.ac_loading { background: white url('<?php echo $this->config->item('staticPath'); ?>/images/loader.gif') right center no-repeat; }
.ac_odd { background-color: #eee; }
.ac_over { background-color: #0A246A; color: white; }
</style> -->

<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/jquery.fieldreplace.js"></script>
<script type="text/javascript">
$(function(){
    $('#searchbox').fieldreplace();
	function formatItem(row) {
		if (row[0].length) return row[1]+'<br /><span class="email">('+row[0]+')</span>';
		else return 'No results';
	}
	$('#searchbox').autocomplete("<?php echo site_url('/admin/users/ac_users'); ?>", { delay: "0", selectFirst: false, matchContains: true, formatItem: formatItem, minChars: 2 });
	$('#searchbox').result(function(event, data, formatted){
		$(this).parent('form').submit();
	});	
});
</script>

<div class="large-10 columns body">
	<div class="card">
		<h2 class="left">Users</h2>
		<div class="right">
			<?php if (in_array('users_import', $this->permission->permissions)): ?>
				<a href="<?php echo site_url('/admin/users/import'); ?>" class="button">Import Users</a>
				<a href="<?php echo site_url('/admin/users/export'); ?>" class="button">Export Users</a>
			<?php endif; ?>

			<?php if (in_array('users_groups', $this->permission->permissions)): ?>
				<a href="<?php echo site_url('/admin/users/groups'); ?>" class="button">Groups</a>
			<?php endif; ?>	
			<?php if (in_array('users_edit', $this->permission->permissions)): ?>
				<a href="<?php echo site_url('/admin/users/add'); ?>" class="green">Add User</a>
			<?php endif; ?>
		</div>
		<div class="clear"></div>
		<div class="large-4 large-offset-8 columns">
			<div class="row collapse">
				<form method="post" action="<?php echo site_url('/admin/users/viewall'); ?>" class="default" id="search">
				<div class="small-9 columns">
					<input type="text" name="searchbox" id="searchbox" class="formelement inactive" placeholder="Search Users" />
				</div>
				<div class="small-3 columns">
					<input type="submit" class="button prefix" id="searchbutton" />
				</div>
				</form>
			</div>
		</div>
		<div class="clear"></div>

		<?php if ($users): ?>

		<?php echo $this->pagination->create_links(); ?>
			
			<div class="row table-header hide-for-touch">
				<div class="large-2 columns">
					<h3><?php echo order_link('/admin/users/viewall','username','Username'); ?></h3>
				</div>
				<div class="large-2 columns">
					<h3><?php echo order_link('/admin/users/viewall','datecreated','Date Created'); ?></h3>
				</div>
				<div class="large-2 columns">
					<h3><?php echo order_link('/admin/users/viewall','lastname','Name'); ?></h3>
				</div>
				<div class="large-2 columns">
					<h3><?php echo order_link('/admin/users/viewall','email','Email'); ?></h3>
				</div>
				<div class="large-2 columns">
					<h3><?php echo order_link('/admin/users/viewall','groupid','Group'); ?></h3>
				</div>
				<div class="large-2 columns">
				</div>
			</div>

		<?php 
			$i=0;
			foreach ($users as $user): 
			$class = ($i % 2) ? 'alt' : ''; $i++;
		?>
		<?php 
			$class = '';
			if ($user['groupID'] == $this->site->config['groupID'] || $user['groupID'] < 0) $class = 'class="blue"';
			elseif (@in_array($user['groupID'], $adminGroups)) $class = 'class="orange"';

			$username = ($user['username']) ? $user['username'] : '(not set)';
			$userlink = (in_array('users_edit', $this->permission->permissions)) ? anchor('/admin/users/edit/'.$user['userID'], $username) : $username;
			
		?>

			<div class="row table <?php echo $class;?>">
				<div class="large-2 columns">
					<p><?php echo $userlink; ?></p>
				</div>
				<div class="large-2 columns">
					<p><?php echo dateFmt($user['dateCreated'], '', '', TRUE); ?></p>
				</div>
				<div class="large-2 columns">
					<p><?php echo trim($user['firstName'].' '.$user['lastName']); ?></p>
				</div>
				<div class="large-2 columns">
					<p><?php echo $user['email']; ?></p>
				</div>
				<div class="large-2 columns">
					<p>					
						<?php
							if ($user['groupID'] == $this->site->config['groupID'] || $user['groupID'] < 0) echo 'Administrator';
							elseif (@in_array($user['groupID'], $adminGroups)) echo $userGroups[$user['groupID']];
							elseif (@in_array($user['groupID'], $normalGroups)) echo $userGroups[$user['groupID']];
						?>
					</p>
				</div>
				<div class="large-2 columns">
					<ul class="button-group even-2">
						<?php if (in_array('users_edit', $this->permission->permissions)): ?>
							<li><?php echo anchor('/admin/users/edit/'.$user['userID'], 'Edit', array('class' => 'button small grey')); ?></li>
						<?php endif; ?>
						<?php if (in_array('users_delete', $this->permission->permissions)): ?>
							<li><?php echo anchor('/admin/users/delete/'.$user['userID'], 'Delete', array('class' => 'button alert small', 'onClick' => 'return confirm(\'Are you sure you want to delete this?\')')); ?></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			
		<?php endforeach; ?>

		<?php echo $this->pagination->create_links(); ?>

		<?php else: ?>

		<p class="clear">No users found.</p>

		<?php endif; ?>
	</div>
</div>



