<?php

	if ($_POST['options-submit']){
	
	if ( !wp_verify_nonce( $_POST[ 'seo_gallery_options' ], 'seo_gallery_options' ) ) : ?>
<div class="updated">
	<p>There was a problem. Please try again.</p>
</div>
	<?php else :

		// UPDATE GALLERY NAME
		
		if (isset ($_POST['current_gallery'])) { 
			$new_gallery = clean_it($_POST['current_gallery']);
		};
		
		if (isset ($_POST['move_category'])) {
			$move_category = clean_it($_POST['move_category']);
		};			
			
		if ( $move_category != '' && $move_category != $currentCategory ) :
			$new_category = $move_category; 
		else :
			$new_category = $currentCategory;
		endif;
		
		if ( $new_gallery != '' && $new_gallery != $currentGallery ) :
			$new_gallery = $new_gallery;
		else :
			$new_gallery = $currentGallery;
		endif;
		
		
		rename( SEO_GALLERY_CONTENT_PATH . $currentCategory . '/' . $currentGallery , SEO_GALLERY_CONTENT_PATH . $new_category . '/' . $new_gallery );
		
		if ($old_thumb) {
			delete_option( SIG_SHORTNAME . $currentCategory . '_' . $currentGallery . '_' . 'gallery_thumbnail' );
			update_option( SIG_SHORTNAME . $new_category . '_' . $new_gallery . '_' .'gallery_thumbnail', $old_thumb);
		};

	$old_cat = $currentCategory;
	$old_gal = $currentGallery;
	
	if ( $new_gallery != '' &&  $new_gallery != $currentGallery ) :
		$currentGallery = $new_gallery;
	else : 
		$currentGallery = $currentGallery;
	endif;
	
	if ( $new_category != '' && $new_category != $currentCategory ) :
		$currentCategory = $new_category;
	else : 
		$currentCategory = $currentCategory;
	endif;



		// UPDATE THUMBNAIL IMAGE and set to old option name
		
		if (isset ($_FILES['gallery_thumbnail']) && $_FILES['gallery_thumbnail']['name'] != '') { 
		
		$file_name = $_FILES['gallery_thumbnail']['name'];
		$temp_file = $_FILES['gallery_thumbnail']['tmp_name'];
		$file_type = $_FILES['gallery_thumbnail']['type'];

		if($file_type=="image/gif" || $file_type=="image/jpeg" || $file_type=="image/pjpeg" || $file_type=="image/png") :
			$length=filesize($temp_file);
			$fd = fopen($temp_file,'rb');
			$file_content=fread($fd, $length);
			fclose($fd);

			$wud = wp_upload_dir();

			$cleanName = preg_replace('/[^a-zA-Z0-9\s.]/', '', $file_name); // replace all non-alphanumeric characters, remove whitespace at beggining and end but leave spaces.
			$cleanName = str_replace(' ', '-', $cleanName); 				// replace space with dashes
			$cleanName = str_replace('--', '-', $cleanName); 				// replace space with dashes
			$cleanName = strtolower($cleanName); 							// convert all to lowercase
			
			if (file_exists($wud[path].'/'.strtolower($cleanName))){
				unlink ($wud[path].'/'.strtolower($cleanName));
			}
			
			$upload = wp_upload_bits( $cleanName, '', $file_content);
			//	echo $upload['error'];

			$new_thumbnail = $wud[url].'/'.($cleanName);
			
			// REMOVE OLD THUMBNAIL AND OLD OPTION
			
			$old_thumbnail = get_option( SIG_SHORTNAME . $currentCategory . '_' . $currentGallery . '_' . 'gallery_thumbnail' );
			
			$old_thumbnail_path = parse_url($old_thumbnail, PHP_URL_PATH);
			
			if (file_exists($old_thumbnail_path)) { unlink($old_thumbnail_path); };			
			delete_option( SIG_SHORTNAME . $old_cat . '_' . $old_gal . '_' . 'gallery_thumbnail' );
	
			update_option( SIG_SHORTNAME . $currentCategory . '_' . $currentGallery . '_' .'gallery_thumbnail', $new_thumbnail);
			
		
		else :  $errorImage .= 'Error in Image Upload for Main Logo.'; 
		endif;
		
		};	

		?>
<div class="updated">
	<p>Your new options have been successfully saved.
	</p>
</div>
	<?php 
	endif; 
} 
	

		
	$gallery_thumbnail = get_option( SIG_SHORTNAME . $currentCategory . '_' . $currentGallery . '_' . 'gallery_thumbnail' );

?>
