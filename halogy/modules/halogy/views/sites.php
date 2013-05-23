
<div class="row">
	<div class="large-12 columns header">
		<h1 class="headingleft">Your Sites</h1>

			<a href="<?php echo site_url('/halogy/add_site'); ?>" class="button green">Add Site</a>
	</div>
</div>

<div class="row">
	<div class="large-12 columns body">
		<div class="large-4 large-offset-8 columns">
			<div class="row collapse">
				<form method="post" action="<?php echo site_url('/halogy/sites'); ?>" class="default" id="search">
				<div class="small-9 columns">
					<input type="text" name="searchbox" id="searchbox" class="formelement inactive" placeholder="Search Sites..." />
				</div>
				<div class="small-3 columns">
					<input type="submit" class="button prefix" id="searchbutton" />
				</div>
				</form>
			</div>
		</div>

		<?php if ($sites): ?>

		<?php echo $this->pagination->create_links(); ?>

		<table class="default">
			<thead>
				<tr>
					<th><?php echo order_link('halogy/sites/viewall','siteName','Site Name'); ?></th>
					<th><?php echo order_link('halogy/sites/viewall','dateCreated','Date Created'); ?></th>
					<th><?php echo order_link('halogy/sites/viewall','siteDomain','Domain'); ?></th>
					<th><?php echo order_link('halogy/sites/viewall','altDomain','Staging Domain'); ?></th>		
					<th class="narrow"><?php echo order_link('halogy/sites/viewall','active','Status'); ?></th>		
					<th class="tiny">&nbsp;</th>
					<th class="tiny">&nbsp;</th>
				</tr>
			</thead>
		<?php
			$i=0;
			foreach ($sites as $site):
			$class = ($i % 2) ? ' class="alt"' : ''; $i++;
		?>
			<tbody>
			<tr<?php echo $class; ?>>
				<td><?php echo anchor('/halogy/edit_site/'.$site['siteID'], $site['siteName']); ?></td>
				<td><?php echo dateFmt($site['dateCreated']); ?></td>		
				<td><?php echo $site['siteDomain']; ?></td>
				<td><?php echo $site['altDomain']; ?></td>		
				<td>
					<?php
						if ($site['active']) echo '<span style="color:green"><strong>Active</strong></span>';
						if (!$site['active']) echo '<span style="color:red">Suspended</span>';
					?>
				</td>	
				<td class="tiny">
					<?php echo anchor('/halogy/edit_site/'.$site['siteID'], 'Edit'); ?>
				</td>
				<td class="tiny">
					<?php echo anchor('/halogy/delete_site/'.$site['siteID'], 'Delete', 'onclick="return confirm(\'Are you absolutely SURE you want to delete this site?\n\nThere is no undo!\')"'); ?>
				</td>
			</tr>
			</tbody>
		<?php endforeach; ?>
		</table>

		<?php echo $this->pagination->create_links(); ?>

		<?php else: ?>

			<?php if (count($_POST)): ?>
			
				<p>No sites found.</p>
			
			<?php else: ?>
			
				<p>You haven't created any sites yet. Create one using the &ldquo;Add Site&rdquo; link above.</p>
			
			<?php endif; ?>

		<?php endif; ?>
	</div>
</div> <!-- / row -->
