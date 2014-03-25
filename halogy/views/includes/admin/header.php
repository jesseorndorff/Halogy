<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<link rel="icon" href="<?php echo $this->config->item('staticPath'); ?>/images/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('staticPath'); ?>/css/normalize.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('staticPath'); ?>/css/app.css" media="screen" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:600italic,700italic,400,600,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo $this->config->item('staticPath'); ?>/webfonts/ss-pika.css" />

	<script type="text/javascript" src="//use.typekit.net/kvu5lut.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

	<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/vendor/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/vendor/jquery-ui-1.10.3.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/js/vendor/custom.modernizr.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('staticPath'); ?>/bower_components/foundation/js/foundation.js"></script>
<script>
  $(function(){
    $(document)
    .foundation();
  })
</script>

<!-- Setting the Sidebar to 100% Height 
<script>
  $(document).ready(function(){
      resizeDiv();
  });

  window.onresize = function(event) {
      resizeDiv();
  }

  function resizeDiv() {
      vpw = $(window).width(); 
      vph = $(window).height(); 
      $('.side-bar').css({'height': vph + 'px'});
  }
</script>

<!-- Sidebar jquery slide -->
<!-- Need to move to scripts 
<script>
$(document).ready(function($) {
    
  var allPanels = $('.side-bar > ul').hide();
    
  $('.side-bar > h3 > a').click(function() {
     if ($(this).hasClass('selected')) {
               $(this).removeClass('selected');
               $(this).parent().next().slideUp();
          } else {
          	   $('.side-bar > h3 > a').removeClass('selected');
               $(this).addClass('selected');
               $('.side-bar ul').slideUp();
               $(this).parent().next().slideDown();
          }
      
    return false;
  });

});
</script> --> 
	
	<title><?php echo (isset($this->site->config['siteName'])) ? $this->site->config['siteName'] : 'Login to'; ?> Admin - Halogy</title>
	
</head>
<body>

	<!-- Start Nav -->
	<nav class="top-bar" data-topbar>
		<ul class="title-area">
			<li class="name">
				<h1><a href="/admin"><img alt="Halogy" src="<?php echo site_url('/static/images/device.png'); ?>"></a></h1>
			</li>
			<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
		</ul>
		<section class="top-bar-section">
			<ul class="left">
				<!-- Pages -->
				
				<?php if($this->session->userdata('session_admin')): ?>
					<?php if (in_array('pages', $this->permission->permissions)): ?>
					<li class="has-dropdown"><a href="#">Pages</a>
						<ul class="dropdown">
							<li><a href="<?php echo site_url('/admin/pages/viewall'); ?>">All Pages</a></li>
							<?php if (in_array('pages_edit', $this->permission->permissions)): ?>
							<li><a href="<?php echo site_url('/admin/pages/add'); ?>">Add Page</a></li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>
				<!-- Templates -->
				
				<?php if (in_array('pages_templates', $this->permission->permissions)): ?>
					<li class="has-dropdown"><a href="#">Templates</a>
						<ul class="dropdown">
							<li><a href="<?php echo site_url('/admin/pages/templates'); ?>">All Templates</a></li>
							<li><a href="<?php echo site_url('/admin/pages/includes'); ?>">Includes</a></li>
							<li><a href="<?php echo site_url('/admin/pages/includes/css'); ?>">CSS</a></li>
							<li><a href="<?php echo site_url('/admin/pages/includes/js'); ?>">Javascript</a></li>
						</ul>
					</li>
				<?php endif; ?>
				<!-- Uploads -->
				
				<?php if (in_array('images', $this->permission->permissions)): ?>
					<li class="has-dropdown"><a href="#">Uploads</a>
						<ul class="dropdown">
							<li><a href="<?php echo site_url('/admin/images/viewall'); ?>">Images</a></li>
							<?php if (in_array('images_all', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/images/folders'); ?>">Image Folders</a></li>
							<?php endif; ?>
							<?php if (in_array('files', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/files/viewall'); ?>">Files</a></li>
								<?php if (in_array('files_all', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/files/folders'); ?>">File Folders</a></li>
								<?php endif; ?>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>
				<!-- Webforms -->
				
				<?php if (in_array('webforms', $this->permission->permissions)): ?>
					<li class="has-dropdown"><a href="#">Web Forms</a>
						<ul class="dropdown">
							<li><a href="<?php echo site_url('/admin/webforms/tickets'); ?>">Tickets</a></li>
							<?php if (in_array('webforms_edit', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/webforms/viewall'); ?>">All Web Forms</a></li>
								<li><a href="<?php echo site_url('/admin/webforms/add_form'); ?>">Add Web Form</a></li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>
				<!-- Blog -->
				
				<?php if (in_array('blog', $this->permission->permissions)): ?>
					<li class="has-dropdown"><a href="#">Blog</a>
						<ul class="dropdown">
							<?php if (in_array('blog', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/blog/viewall'); ?>">All Posts</a></li>
							<?php endif; ?>
							<?php if (in_array('blog_edit', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/blog/add_post'); ?>">Add Post</a></li>
							<?php endif; ?>
							<?php if (in_array('blog_cats', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/blog/categories'); ?>">Categories</a></li>
							<?php endif; ?>							
							<li><a href="<?php echo site_url('/admin/blog/comments'); ?>">Comments</a></li>
						</ul>
					</li>
				<?php endif; ?>
				<!-- Shop -->
				
				<?php if (in_array('shop', $this->permission->permissions)): ?>
					<li class="has-dropdown"><a href="#">Shop</a>
						<ul class="dropdown">
							<li><a href="<?php echo site_url('/admin/shop/products'); ?>">All Products</a></li>
							<?php if (in_array('shop_edit', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/add_product'); ?>">Add Product</a></li>
							<?php endif; ?>
							<?php if (in_array('shop_cats', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/categories'); ?>">Categories</a></li>
							<?php endif; ?>
							<?php if (in_array('shop_orders', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/orders'); ?>">View Orders</a></li>
							<?php endif; ?>
							<?php if (in_array('shop_shipping', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/bands'); ?>">Shipping Bands</a></li>
								<li><a href="<?php echo site_url('/admin/shop/postages'); ?>">Shipping Costs</a></li>
								<li><a href="<?php echo site_url('/admin/shop/modifiers'); ?>">Shipping Modifiers</a></li>								
							<?php endif; ?>
							<?php if (in_array('shop_discounts', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/discounts'); ?>">Discount Codes</a></li>
							<?php endif; ?>
							<?php if (in_array('shop_reviews', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/reviews'); ?>">Reviews</a></li>
							<?php endif; ?>
							<?php if (in_array('shop_upsells', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/shop/upsells'); ?>">Upsells</a></li>
							<?php endif; ?>	
						</ul>
					</li>
				<?php endif; ?>
				<!-- Events -->
				
				<?php if (in_array('events', $this->permission->permissions)): ?>
					<li class="has-dropdown"><a href="#">Events</a>
						<ul class="dropdown">
							<li><a href="<?php echo site_url('/admin/events/viewall'); ?>">All Events</a></li>
						<?php if (in_array('events_edit', $this->permission->permissions)): ?>
							<li><a href="<?php echo site_url('/admin/events/add_event'); ?>">Add Event</a></li>
						<?php endif; ?>	
						</ul>
					</li>
				<?php endif; ?>
				<!-- Forums -->
				
				<?php if (in_array('forums', $this->permission->permissions)): ?>
					<li class="has-dropdown"><a href="#">Forums</a>
						<ul class="dropdown">
							<li><a href="<?php echo site_url('/admin/forums/forums'); ?>">Forums</a></li>
							<?php if (in_array('forums_cats', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/forums/categories'); ?>">Forum Categories</a></li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>
				<!-- Wiki -->
				
				<?php if (in_array('wiki', $this->permission->permissions)): ?>
					<li class="has-dropdown"><a href="#">Wiki</a>
						<ul class="dropdown">
							<?php if (in_array('wiki_edit', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/wiki/viewall'); ?>">All Wiki Pages</a></li>
							<?php endif; ?>
							<?php if (in_array('wiki_cats', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/wiki/categories'); ?>">Wiki Categories</a></li>
							<?php endif; ?>
							<li><a href="<?php echo site_url('/admin/wiki/changes'); ?>">Recent Changes</a></li>
						</ul>
					</li>
				<?php endif; ?>
				<!-- Users -->
				
				<?php if (in_array('users', $this->permission->permissions)): ?>
					<li class="has-dropdown"><a href="#">Users</a>
						<ul class="dropdown">
							<?php if (in_array('users_groups', $this->permission->permissions)): ?>
								<li><a href="<?php echo site_url('/admin/users/viewall'); ?>">All Users</a></li>
								<li><a href="<?php echo site_url('/admin/users/groups'); ?>">User Groups</a></li>
							<?php endif; ?>
							<?php else: ?>
								<li><a href="<?php echo site_url('/admin'); ?>">Login</a></li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>
				<!-- Admin -->
				
				<li class="has-dropdown"><a href="#">Admin</a>
					<ul class="dropdown">
						<li><a href="<?php echo site_url('/'); ?>">View Site</a></li>
						<?php if ($this->session->userdata('session_admin')): ?>
							<li><a href="<?php echo site_url('/admin/dashboard'); ?>">Dashboard</a></li>
							<li><a href="<?php echo site_url('/admin/users/edit/'.$this->session->userdata('userID')); ?>">My Account</a></li>
							<?php if ($this->session->userdata('groupID') == $this->site->config['groupID'] || $this->session->userdata('groupID') < 0): ?>
								<li><a href="<?php echo site_url('/admin/site/'); ?>">My Site</a></li>
							<?php endif; ?>
							<?php if ($this->session->userdata('groupID') < 0 && @file_exists(APPPATH.'modules/halogy/controllers/halogy.php')): ?>
								<li><a href="<?php echo site_url('/admin/logout'); ?>">Logout</a></li>
								<li><a href="<?php echo site_url('/halogy/sites'); ?>">Sites</a></li>
							<?php else: ?>
								<li class="last"><a href="<?php echo site_url('/admin/logout'); ?>">Logout</a></li>
							<?php endif; ?>	
						<?php else: ?>
							<li class="last"><a href="<?php echo site_url('/admin'); ?>">Login</a></li>
						<?php endif; ?>
					</ul>
				</li>
				</li>
			</ul> <!-- / left -->
		</section> <!-- /left section -->
		<!--<section class="top-bar-section hide-for-small">
			<div class="right user-dropdown">
				<img class="profile" src="<?php echo site_url('/static/uploads/avatars/jesse.png'); ?>">
				
				<ul class="right">
					<li class="left has-dropdown"><a href="#">Jesse Orndorff</a>
						<ul class="dropdown">
							<li><a href="#">Profile</a></li>
							<li><a href="#">My Account</a></li>
							<li><a href="#">My Site</a></li>
							<li class="divider"></li>
							<li><label>Client Management</label></li>
							<li><a href="#">Manage Sites</a></li>
							<li><a href="#">Client Billing</a></li>
						</ul>
					</li>	
				</ul>
			</div>
		</section> -->
	</nav>
	<div class="row">


