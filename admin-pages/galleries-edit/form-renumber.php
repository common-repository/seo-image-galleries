<?php renumber_gallery($currentCategory, $currentGallery);   ?>

	<form name="theform2" method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);?>&refresh=<?php echo rand(1,999999); ?>">
	<?php wp_nonce_field('seo_image_renumber', 'seo_image_nonce'); ?>


<?php 
	
	
	
	$galleryImages = get_seo_gallery_images($currentCategory, $currentGallery);
	
	if ($galleryImages ) { sort($galleryImages); 
	
	$count = 1;
	
	foreach ($galleryImages as $galleryImage) { 
		
			$current_order = get_image_order($galleryImage);
			$current_name = get_image_name($galleryImage);
			


?>
<div class="section">
	<div class="current-images image-menu">
		<div class="left image-list image-thumb">
			<p>Image Preview</p>
		</div>
		<div class="left image-list image-order">
			<p>Order</p>
		</div>
		<div class="left image-list image-reorder">
			<p>Re-Order</p>
		</div>		

		<div class="left image-list image-delete">
			<p>Delete?</p>
		</div>

		<div class="left image-list image-update">
		</div>
	</div>
</div>
<div class="section">
	<div class="current-images">
		<div class="left image-list image-thumb">
			<input type="hidden" name="old_name-<?php echo $count; ?>" value="<?php echo $galleryImage; ?>" />
			<img class="thumbnails" src="<?php echo SEO_GALLERY_CONTENT_URL . $currentCategory . '/' . $currentGallery . '/' . $galleryImage.  '?' . rand(1,999999); ?>; ?>" />
		</div>
		<div class="left image-list image-order">
			<p><?php echo $current_order; ?></p>
		</div>
		<div class="left image-list image-reorder">
			<input size="1" type="text" name="order-<?php echo $count; ?>" value="">
		</div>

		<div class="left image-list image-delete">
			<input type="checkbox" name="image_delete-<?php echo $count; ?>" value="<?php echo $galleryImage; ?>" />

		</div>

		<div class="left image-list image-update">
			<input type="hidden" name="images_submit" value="1" />
			<p><input class="button-secondary"type="submit" name="submit" value="Update" /></p>
		</div>
	</div>
</div>


<?php 
	$count ++;
	} 	// end foreach 
} else {
echo '<p>No Images yet. Start uploading...</p>';

};		// endif
?>
	</form>

