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
	    update: setOrder,
	    placeholder: "ui-sortable-placeholder"
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

	initOrder('div.order');
});
</script>
<div class="large-12 columns body">
	<div class="card">
		<div class="header">
			<div class="small-12 medium-6 large-4 columns left">
				<h2>Blog Categories</h2>
			</div>
			<div class="large-6 small-12 columns right">
				<a href="#" class="button small radius toggle success">Add Category</a>
			</div>
		</div>
		<div class="row table">
			<div class="small-12 columns item">
				<div class="hidden item">
					<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="">
					
						<label for="categoryName">Category Name</label>
						<p>Give your blog category a name</p>
						
						<?php echo @form_input('catName',$blog_cats['catName'], 'class="formelement" id="catName"'); ?>
							
						<input type="submit" value="Save Category" id="submit" class="small button" />
						
					</form>
				</div>

				<?php if ($categories): ?>
				<form method="post" action="<?php echo site_url('/admin/blog/edit_cat'); ?>">
					<div class="order">
					<?php
					$i = 0;
					foreach ($categories as $category):
					$class = ($i % 2) ? 'alt' : ''; $i++;
					?>
						<div id="blog_cats-<?php echo $category['catID']; ?>" class="large-12 columns table <?php echo $class;?>">
							<div class="col1 large-9 columns">	
								<span class="cat-name"><strong><?php echo $category['catName']; ?></strong> <small>(<?php echo url_title(strtolower(trim($category['catName']))); ?>)</small></span>
								<?php echo @form_input($category['catID'].'[catName]', $category['catName'], 'class="formelement hide" title="Category Name"'); ?><input type="submit" class="button green small hide" value="Save" />
							</div>
							<div class="large-3 columns">
								<ul class="button-group even-2">
									<li><a href="#" class="edit small">Edit</a></li>
									<li><a href="<?php echo site_url('/admin/blog/delete_cat/'.$category['catID']); ?>" onclick="return confirm('Are you sure you want to delete this?')" class="small">Delete</a></li>
								</ul>
							</div>
						</div>
					<?php endforeach; ?>
					</div>

				</form>

				<?php else: ?>

				<p>No blog categories have been created yet.</p>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>