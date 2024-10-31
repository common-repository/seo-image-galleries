<?php 

	if (isset ( $_POST['gallery_fix'] ) ) {
		$currentGallery = clean_it($_POST['gallery_fix']) ;
	};
	
	if (isset ( $_POST['cat_fix'] ) ) {
		$currentCategory = clean_it($_POST['cat_fix']) ;		
	};
	
 	if ( isset ( $_POST['thumb_fix'] ) &&  $_POST['thumb_fix'] != '' ) :
		$old_thumb = $_POST['thumb_fix'] ;	
	else :
		$old_thumb = '';
	endif; 
	
	include (SEO_IMAGE_PLUGIN_BASEDIR . '/admin-pages/galleries-edit/post-options.php');
	include (SEO_IMAGE_PLUGIN_BASEDIR . '/admin-pages/galleries-edit/post-renumber.php');
	include (SEO_IMAGE_PLUGIN_BASEDIR . '/admin-pages/galleries-edit/post-upload.php');

?>
<h2>Editing the Gallery: "<?php echo return_nicename($currentGallery); ?>"</h2>
<div id="tabs">
	<h3 class="tabs">Gallery Options</h3>
	<h3 class="tabs">Current Images</h3>
	<h3 class="tabs">Upload New Images</h3>
	<h3 class="tabs">Image Sizes</h3>
	<h3 class="tabs">Display Options</h3>
</div>
<div id="panels">
	<div id="gallery-options" class="pane">
		<?php include (SEO_IMAGE_PLUGIN_BASEDIR . '/admin-pages/galleries-edit/form-options.php'); ?>
	</div>
	<div id="current-images" class="pane" >
		<?php include (SEO_IMAGE_PLUGIN_BASEDIR . '/admin-pages/galleries-edit/form-renumber.php'); ?>
	</div>
	<div id="upload-images" class="pane">
		<?php include (SEO_IMAGE_PLUGIN_BASEDIR . '/admin-pages/galleries-edit/form-upload.php'); ?>
	</div>
	<div id="image-sizes" class="pane">
		<?php include (SEO_IMAGE_PLUGIN_BASEDIR . '/admin-pages/galleries-edit/image-sizes.php'); ?>
	</div>
	<div id="display-options" class="pane">
		<?php include (SEO_IMAGE_PLUGIN_BASEDIR . '/admin-pages/galleries-edit/display-options.php'); ?>
	</div>
</div>

