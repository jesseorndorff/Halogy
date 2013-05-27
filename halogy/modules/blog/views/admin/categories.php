<script type="text/javascript">
function setOrder(){
	$.post('<?php echo site_url('/admin/blog/order/cat'); ?>',$(this).sortable('serialize'),function(data){ });
};

function initOrder(el){
	$(el).sortable({ 
		axis: 'y',
	    revert: false, 
	    delay: '80',
	    opacity: '0.5',
	    update: setOrder
	});
};

$(function(){
	$('a.toggle').click(function(event){ 
		event.preventDefault();		
		$('div.hidden').slideToggle('400');
	});

	$('a.edit').click(function(event){
		event.preventDefault();
		$(this).parent().siblings('.col1').children('input').show();
		$(this).parent().siblings('.col1').children('span').hide();
	});

	initOrder('ol.order');
});
</script>
<div class="row">
	<div class="large-12 columns body">
		<h1 class="headingleft">Blog Categories</h1>

		<ul class="group-button">
			<li><a href="<?php echo site_url('/admin/blog/viewall'); ?>" class="bluebutton">View Posts</a></li>
			<li><a href="#" class="toggle green">Add Category</a></li>
		</ul>

		<hr>
		<div class="hidden item">
			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="default">
			
				<label for="categoryName">Category Name</label>
				<p>Give your blog category a name</p>
				
				<?php echo @form_input('catName',$blog_cats['catName'], 'class="formelement" id="catName"'); ?>
					
				<input type="submit" value="Add Category" id="submit" class="button" />

				<br class="clear" />
				
			</form>
		</div>

		<?php if ($categories): ?>
		<form method="post" action="<?php echo site_url('/admin/blog/edit_cat'); ?>">

			<ol class="order">
			<?php foreach ($categories as $category): ?>
				<li id="blog_cats-<?php echo $category['catID']; ?>">
					<div class="small-buttons large-2 columns">
						<a href="#" class="edit button small">Edit</a>
						<a href="<?php echo site_url('/admin/blog/delete_cat/'.$category['catID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="button alert small">Delete</a>
					</div>
					<div class="col1 large-10 columns">	
						<span class="cat-name"><strong><?php echo $category['catName']; ?></strong> <small>(<?php echo url_title(strtolower(trim($category['catName']))); ?>)</small></span>
						<?php echo @form_input($category['catID'].'[catName]', $category['catName'], 'class="formelement hide" title="Category Name"'); ?><input type="submit" class="button green small hide" value="Save" />
					</div>

					<div class="clear"></div>
				</li>
			<?php endforeach; ?>
			</ol>

		</form>

		<?php else: ?>

		<p>No blog categories have been created yet.</p>

		<?php endif; ?>

	</div>
</div>

