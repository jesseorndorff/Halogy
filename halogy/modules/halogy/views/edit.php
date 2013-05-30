<script type="text/javascript">
$(function(){
	$('div.permissions input[type="checkbox"]').each(function(){
		if ($(this).prop('checked')) {
			$(this).parent('div').prev('div').children('input[type="checkbox"]').prop('checked', true);
		}
	});	
	$('input.selectall').click(function(){
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
	$('#siteDomain').change(function(){
		var domainVal = $(this).val();
		var tld = '';
		domainVal = domainVal.replace(/^(http)s?:\/+((w+)\.)?|^www\.|\/|\/(.+)/ig, '');
		if (tld = domainVal.match(/\.[a-z]{2,3}\.[a-z]{2}$/i)){
			domainVal = domainVal.replace(/\.[a-z]{2,3}\.[a-z]{2}$/i, '');
			domainVal = domainVal.replace(/^(.+)\./ig, '');
			domainVal = domainVal+tld;
		}
		else if (tld = domainVal.match(/\.[a-z]{2,4}$/i)){
			domainVal = domainVal.replace(/\.[a-z]{2,4}$/i, '');
			domainVal = domainVal.replace(/(.+)\./ig, '');
			domainVal = domainVal+tld;
		}
		$(this).val(domainVal);
		$('#siteURL').val('http://www.'+domainVal);
		$('#siteEmail').val('info@'+domainVal);
	});
	$('a.deselectall').click(function(event){
		event.preventDefault();
		$('input[type="checkbox"]').prop('checked', false);
	});
	$('a.selectall').click(function(event){
		event.preventDefault();
		$('input[type="checkbox"]').prop('checked', true);
	});	

});
</script>
<div class="row">
	<div class="large-12 columns body">

		<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="custom">

		<h1 class="headingleft">Edit Site: <?php echo $data['siteDomain']; ?> </h1>
		<ul class="group-button">
			<li><a href="<?php echo site_url('/halogy/sites'); ?>" class="bluebutton">Back to Sites</a></li>
			<li><input type="submit" value="Save Changes" class="green" /></li>
		</ul>

		<hr>

		<?php if ($errors = validation_errors()): ?>
			<div class="error clear">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>
		<div class="section-container auto" data-section>
			<section>
				<p class="title" data-section-title><a href="#">Site Settings</a></p>
				<div class="content" data-section-content>
					<h2>Site Domain & Details</h2>
					<p>Set the details of the website, including the name, URL, email and telephone.</p>
					<hr>
					<div class="row">
						<div class="large-6 columns">
							<h2>Domains</h2>

							<label for="siteDomain">Domain:</label>
							<?php echo @form_input('siteDomain', set_value('siteDomain', $data['siteDomain']), 'id="siteDomain" class="formelement"'); ?>
							<span class="tip">For example 'mysite.com' (no sub-domains, www or trailing slashes)</span><br class="clear" />
							
							<label for="altDomain">Staging Domain:</label>
							<?php echo @form_input('altDomain', set_value('altDomain', $data['altDomain']), 'id="altDomain" class="formelement"'); ?>
							<span class="tip">Optional alternative domain for staging sites.</span><br class="clear" /><br />
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="large-6 columns">

							<h2>Site Details</h2>

							<label for="siteName">Name of Site:</label>
							<?php echo @form_input('siteName', set_value('siteName', $data['siteName']), 'id="siteName" class="formelement"'); ?>
							<span class="tip">The name of the site</span><br class="clear" />

							<label for="siteURL">URL:</label>
							<?php echo @form_input('siteURL', set_value('siteURL', $data['siteURL']), 'id="siteURL" class="formelement"'); ?>
							<span class="tip">The full URL to the site</span><br class="clear" />

							<label for="siteEmail">Email:</label>
							<?php echo @form_input('siteEmail', set_value('siteEmail', $data['siteEmail']), 'id="siteEmail" class="formelement"'); ?>
							<span class="tip">The site contact email</span><br class="clear" />

							<label for="siteTel">Telephone:</label>
							<?php echo @form_input('siteTel', set_value('siteTel', $data['siteTel']), 'id="siteTel" class="formelement"'); ?>
							<span class="tip">The site contact telephone number</span><br class="clear" />
							<br class="clear" />

							<label for="active">Status:</label>
							<?php
								$actives = array(
									1 => 'Active',
									0 => 'Suspended',			
								);	
								echo @form_dropdown('active', $actives, $data['active'], 'id="active" class="formelement"');
							?>
							<span class="tip">You cannot delete sites, but you can suspend them and take them offline here.</span>
						</div>
					</div>
				</div>
			</section>
			<section>
				<p class="title" data-section-title><a href="#">Permissions</a></p>
				<div class="content" data-section-content>
					<h2>Permissions</h2>
					<p>Set the site module permissions.</p>
					<hr>
					<div class="row select-all">
						<div class="large-6 columns">
							<p><a href="#" class="selectall button small nolabel grey">Select All</a> <a href="#" class="deselectall button small nolabel grey">De-Select All</a></p>

							<?php if ($permissions): ?>
								<?php foreach ($permissions as $cat => $perms): ?>

									<div class="perm-heading">
										<label for="<?php echo strtolower($cat); ?>_all" class="radio"><?php echo $cat; ?></label>
										<input type="checkbox" class="selectall checkbox" id="<?php echo strtolower($cat); ?>_all" />
										<input type="button" value="See more" class="seemore button primary" />
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
				</div>
			</section>
		</div> <!-- /Tabs -->
	</div> <!-- /body -->
</div>
	
</form>
