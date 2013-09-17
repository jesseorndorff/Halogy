<script type="text/javascript">
function preview(el){
	$.post('<?php echo site_url('/admin/blog/preview'); ?>', { body: $(el).val() }, function(data){
		$('div.preview').html(data);
	});
}
$(function(){
	$('div.category>span, div.category>input').hover(
		function() {
			if (!$(this).prev('input').attr('checked') && !$(this).attr('checked')){
				$(this).parent().addClass('hover');
			}
		},
		function() {
			if (!$(this).prev('input').attr('checked') && !$(this).attr('checked')){
				$(this).parent().removeClass('hover');
			}
		}
	);	
	$('div.category>span').click(function(){
		if ($(this).prev('input').attr('checked')){
			$(this).prev('input').attr('checked', false);
			$(this).parent().removeClass('hover');
		} else {
			$(this).prev('input').attr('checked', true);
			$(this).parent().addClass('hover');
		}
	});
	$('textarea#body').focus(function(){
		$('.previewbutton').show();
	});
	$('textarea#body').blur(function(){
		preview(this);
	});
	$('input.datebox').datepicker({dateFormat: 'M dd yy'});
	preview($('textarea#body'));
});
</script>

<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="noncustom">

			<div class="large-10 columns body">
				<div class="small-12 large-12 large-centered columns card">
					<h2 class="left">Edit Blog Post</h2>
					<div class="button-group right">
						<input type="submit" name="view" value="View Blog Post" class="button" />
					</div>
					<div class="clear"></div>
					<?php if ($errors = validation_errors()): ?>
						<div class="error">
							<?php echo $errors; ?>
						</div>
					<?php endif; ?>
					<?php if (isset($message)): ?>
						<div class="message">
							<?php echo $message; ?>
						</div>
					<?php endif; ?>
					<div class="item">
						<label for="postName">Title</label>
						<p>Give your blog post a title.</p>
						<?php echo @form_input('postTitle', set_value('postTitle', $data['postTitle']), 'id="postTitle" class="formelement"'); ?>
					</div>

					<div class="item">
						<a href="#" data-reveal-id="addCat" class="button small right">Add</a>
						<!-- <a href="<?php echo site_url('/admin/blog/categories'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')" class="button small right">Add</a> -->
						<label>Categories</label>
						<p>Place your post in any relevant categories.</p>
							<div class="categories">
								<?php if ($categories): ?>
								<ul class="list">
								<?php foreach($categories as $category): ?>
									<li><?php echo @form_checkbox('catsArray['.$category['catID'].']', $category['catName'], (isset($data['categories'][$category['catID']])) ? 1 : ''); ?><span class="checkbox-cat"><?php echo $category['catName']; ?></span></li>
								<?php endforeach; ?>
								</ul>
								<?php else: ?>
									<div class="category">
										<strong>Warning:</strong> It is strongly recommended that you use categories or this may not appear properly. <a href="<?php echo site_url('/admin/blog/categories'); ?>" onclick="return confirm('You will lose any unsaved changes.\n\nContinue anyway?')"><strong>Please update your categories here</strong></a>.
									</div>
								<?php endif; ?>
							</div>
					</div>
					<div class="item">
						<div class="buttons">
							<a href="#" class="boldbutton"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_bold.png" alt="Bold" title="Bold" /></a>
							<a href="#" class="italicbutton"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_italic.png" alt="Italic" title="Italic" /></a>
							<a href="#" class="h1button"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_h1.png" alt="Heading 1" title="Heading 1"/></a>
							<a href="#" class="h2button"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_h2.png" alt="Heading 2" title="Heading 2" /></a>
							<a href="#" class="h3button"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_h3.png" alt="Heading 3" title="Heading 3" /></a>	
							<a href="#" class="urlbutton"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_url.png" alt="Insert Link" title="Insert Link" /></a>
							<a href="<?php echo site_url('/admin/images/browser'); ?>" class="halogycms_imagebutton"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_image.png" alt="Insert Image" title="Insert Image" /></a>
							<a href="<?php echo site_url('/admin/files/browser'); ?>" class="halogycms_filebutton"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_file.png" alt="Insert File" title="Insert File" /></a>
							<a href="#" class="previewbutton"><img src="<?php echo $this->config->item('staticPath'); ?>/images/btn_save.png" alt="Preview" title="Preview" /></a>	
						</div>
					</div>

					<div class="item">
						<a href="#" data-reveal-id="previewModal" class="small button right">Preview</a>
						<div class="autosave">
							<label for="body">Body</label>
							<p>Update the body of your blog post.</p>
							<?php echo @form_textarea('body', set_value('body', $data['body']), 'id="body" class="formelement code half"'); ?>
							<!--<div class="preview"></div> -->
						</div>
					</div>

					<div class="item">
						<label for="excerpt">Excerpt</label>
						<p>Create a nice introduction to your blog post here. We will use this on your main blog page.</p>
						<?php echo @form_textarea('excerpt', set_value('excerpt', $data['excerpt']), 'id="excerpt" class="formelement code short"'); ?>
					</div>

					<div class="item">
						<label for="tags">Tags</label>
						<p>Tags are used to help orginize your posts. You can separate tags with a comma (e.g. “places, hobbies, favourite work”) to create multiple tags.</p>
						<?php echo @form_input('tags', set_value('tags', $data['tags']), 'id="tags" class="formelement"'); ?>
					</div>

					<div class="item">
						<label for="published">Publish</label>
						<?php 
							$values = array(
								1 => 'Yes',
								0 => 'No (save as draft)',
							);
							echo @form_dropdown('published',$values,set_value('published', $data['published']), 'id="published"'); 
						?>
					</div>

					<div class="item">
						<label for="allowComments">Allow Comments?</label>
						<?php 
							$values = array(
								1 => 'Yes',
								0 => 'No',
							);
							echo @form_dropdown('allowComments',$values,set_value('allowComments', $data['allowComments']), 'id="allowComments"'); 
						?>
					</div>

					<div class="item">
						<label for="publishDate">Publish Date:</label>
						<?php echo @form_input('publishDate', date('M d Y', strtotime($data['dateCreated'])), 'id="publishDate" class="formelement datebox" readonly="readonly"'); ?>
					</div>
					<input type="submit" value="Save Changes" class="button green" />
				</div> <!-- / 6 -->
			</div> <!-- / 10 -->
	</div>
</div>
</form>

<div id="previewModal" class="reveal-modal">
	<h3>Post Preview:</h3>
	<div class="preview"></div>
	<a class="close-reveal-modal">&#215;</a>
</div>

<div id="addCat" class="reveal-modal">
	<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" class="">
	
		<label for="categoryName">Category Name</label>
		<p>Give your blog category a name</p>
		
		<?php echo @form_input('catName',$blog_cats['catName'], 'class="formelement" id="catName"'); ?>
			
		<input type="submit" value="Save Category" id="submit" class="small button" />
		
	</form>
	<a class="close-reveal-modal">&#215;</a>
</div>
