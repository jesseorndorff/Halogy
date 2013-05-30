<script type="text/javascript">
$(function(){	
	$('a.showtab').click(function(event){
		event.preventDefault();
		var div = $(this).prop('href'); 
		$('div.tab').hide();
		$(div).show();
	});
	$('ul.innernav a').click(function(event){
		event.preventDefault();
		$(this).parent().siblings('li').removeClass('selected'); 
		$(this).parent().addClass('selected');
	});
	$('div.tab:not(#tab1)').hide();
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
		domainVal = domainVal.replace(/^(http)s?:\/+((w+)\.)?|^www\.|\/+/i, '');
		$(this).val(domainVal);
		$('#siteURL').val('http://www.'+domainVal);
	});
	$('#adminEmail').change(function(){
		$('#username').val($(this).val());
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
	$('form').submit(function(){
		$('div.permissions input').each(function(){
			if($(this).prop('checked') == true){
				$(this).closest('form').submit();
			};
		});
		alert('You do not have any permissions set for this site.');
		return false;
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

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="custom">

<div class="row">
	<div class="large-12 columns body">
		<h1 class="headingleft">Add Site</h1>
		<ul class="group-button">
			<li><a href="<?php echo site_url('/halogy/sites'); ?>" class="bluebutton">Back to Sites</a></li>
			<li><input type="submit" value="Add Site" class="green"></li>
		</ul>
		
		<hr>

		<?php if ($errors = validation_errors()): ?>
			<div class="error clear">
				<?php echo $errors; ?>
			</div>
		<?php endif; ?>
		<div class="section-container auto" data-section>
			<section>
				<p class="title" data-section-title><a href="#">Site Details</a></p>
				<div class="content" data-section-content>
					<div class="row">
						<div class="large-6 columns">
							<h2>Domains</h2>

							<label for="siteDomain">Domain:</label>
							<?php echo @form_input('siteDomain', set_value('siteDomain', $data['siteDomain']), 'id="siteDomain" class="formelement"'); ?>
							<span class="tip">For example 'mysite.com' (no sub-domains, www or trailing slashes)</span><br class="clear" />
							
							<label for="altDomain">Staging Domain:</label>
							<?php echo @form_input('altDomain', set_value('altDomain', $data['altDomain']), 'id="altDomain" class="formelement"'); ?>
							<span class="tip">Optional alternative domain for staging sites.</span><br class="clear" /><br />

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
						</div>
					</div>
				</div> <!-- / content -->
			</section>
			<section>
				<p class="title" data-section-title><a href="#">Administrator Details</a></p>
				<div class="content" data-section-content>
					<div class="row">
						<div class="large-6 columns">
							<h2>Administrator Details</h2>

							<label for="adminEmail">Email:</label>
							<?php echo @form_input('adminEmail', set_value('adminEmail', $data['adminEmail']), 'id="adminEmail" class="formelement"'); ?>
							<span class="tip">The email / username for the main administrator</span>
							<br class="clear" />

							<label for="username">Username:</label>
							<?php echo @form_input('username', set_value('username', $data['username']), 'id="username" class="formelement"'); ?>
							<br class="clear" />

							<label for="password">Password:</label>
							<?php echo @form_password('password', set_value('password', $data['password']), 'id="password" class="formelement"'); ?>
							<br class="clear" />

							<label for="confirmPassword">Confirm Password:</label>
							<?php echo @form_password('confirmPassword', set_value('confirmPassword', $data['confirmPassword']), 'id="confirmPassword" class="formelement"'); ?>
							<br class="clear" />

							<label for="firstName">First Name:</label>
							<?php echo @form_input('firstName',set_value('firstName', $data['firstName']), 'id="firstName" class="formelement"'); ?>
							<br class="clear" />

							<label for="lastName">Last Name:</label>
							<?php echo @form_input('lastName',set_value('lastName', $data['lastName']), 'id="lastName" class="formelement"'); ?>
						</div>
					</div>
				</div>
			</section>
			<section>
				<p class="title" data-section-title><a href="#">Site Permissions</a></p>
				<div class="content" data-section-content>
					<div class="row">
						<div class="large-6 columns">
							<h2>Permissions</h2>

							<p><a href="#" class="selectall button small nolabel grey">Select All</a> <a href="#" class="deselectall button small nolabel grey">De-Select All</a></p>

							<?php if ($permissions): ?>
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
				</div>
			</section>
		</div> <!-- /tabs -->
	</div> <!-- /body -->
</div> <!-- /row -->
	
</form>