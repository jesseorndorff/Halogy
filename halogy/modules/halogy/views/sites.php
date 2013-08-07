<div class="large-10 columns body">
	<div class="card">
		<h2 class="left">Your Sites</h2>
		<div class="right">
			<a href="<?php echo site_url('/halogy/add_site'); ?>" class="button green">Add Site</a>
		</div>
		<div class="clear"></div>
		<div class="large-3 large-offset-9 columns">
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

		<div class="clear"></div>

		<?php if ($sites): ?>

		<?php echo $this->pagination->create_links(); ?>

			<div class="row table-header hide-for-touch">
				<div class="large-2 columns">
					<h3><?php echo order_link('halogy/sites/viewall','siteName','Site Name'); ?></h3>
				</div>
				<div class="large-2 columns">
					<h3><?php echo order_link('halogy/sites/viewall','dateCreated','Date Created'); ?></h3>
				</div>
				<div class="large-2 columns">
					<h3><?php echo order_link('halogy/sites/viewall','siteDomain','Domain'); ?></h3>
				</div>
				<div class="large-2 columns">
					<h3><?php echo order_link('halogy/sites/viewall','altDomain','Staging Domain'); ?></h3>
				</div>
				<div class="large-2 columns">
					<h3><?php echo order_link('halogy/sites/viewall','active','Status'); ?></h3>
				</div>
				<div class="large-2 columns">
				</div>
			</div>

			<?php
				$i=0;
				foreach ($sites as $site):
				$class = ($i % 2) ? 'alt' : ''; $i++;
			?>

			<div class="row table <?php echo $class;?>">
				<div class="large-2 columns">
					<p><?php echo anchor('/halogy/edit_site/'.$site['siteID'], $site['siteName']); ?></p>
				</div>
				<div class="large-2 columns">
					<p><?php echo dateFmt($site['dateCreated']); ?></p>
				</div>
				<div class="large-2 columns">
					<p><?php echo $site['siteDomain']; ?></p>
				</div>
				<div class="large-2 columns">
					<p><?php echo $site['altDomain']; ?></p>
				</div>
				<div class="large-2 columns">
					<p>					
						<?php
						if ($site['active']) echo '<span style="color:green"><strong>Active</strong></span>';
						if (!$site['active']) echo '<span style="color:red">Suspended</span>';
					?>
					</p>
				</div>
				<div class="large-2 columns">
					<ul class="button-group even-2">
						<li><?php echo anchor('/halogy/edit_site/'.$site['siteID'], 'Edit', array('class' => 'button small grey')); ?></li>
						<li><?php echo anchor('/halogy/delete_site/'.$site['siteID'], 'Delete', array('class' => 'button alert small', 'onClick' => 'return confirm(\'Are you sure you want to delete this?\')')); ?></li>
					</ul>
				</div>
			</div>

			<?php endforeach; ?>

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
