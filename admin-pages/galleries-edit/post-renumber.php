<?php
		
	$warning = '';
	$message = '';
	if ($_POST['images_submit']) {

		if ( !wp_verify_nonce( $_POST[ 'seo_image_nonce' ], 'seo_image_renumber' ) ) : 
			echo 'delete:' . $_POST['old_name-1'];
	else :
				
		$imagePath =  SEO_GALLERY_CONTENT_PATH . $currentCategory . '/' . $currentGallery . '/';
		$tempDir = $imagePath . 'temp/';
		if (!file_exists($tempDir)) { mkdir($tempDir); } ;

		$deleteArray = array();


// first delete all images to be deleted
		
		$galleryImages = get_seo_gallery_images($currentCategory, $currentGallery);

		if ($galleryImages) { 
			sort($galleryImages); 
			$count = 1; 
			foreach ($galleryImages as $galleryImage) { 
				if ($_POST['image_delete-' . $count] && $_POST['image_delete-' . $count] != '' ) {
					
					$deleteImage = $_POST['old_name-' . $count];
					
					$delete = $imagePath . $deleteImage;
					
					if ( file_exists($delete) && is_file($delete) ) :
            			unlink($delete);
						$message .= 'The file "' . $deleteImage . '" was succesfully deleted.<br />';
        			else : 
						$warning .=  '<div class="error">There was a problem deleting: "' . $deleteImage . '"</div>';
					endif; 
				};
			$count++;
			}
		};
						

// MOVE RE-ORDERED IMAGES INTO FOLDER 'GalleryName/TEMP' **********************************
		
	$galleryImages = get_seo_gallery_images($currentCategory, $currentGallery);

	if ($galleryImages) { 
			
		sort($galleryImages); 
		
		$count = 1; 

		foreach ($galleryImages as $galleryImage) { 

			$current_image = $_POST['old_name-' . $count];

			$current_name = get_image_name($current_image);
			$current_order = get_image_order($current_image);
			$ext = get_imageext($current_image);
	
			if (isset ($_POST['order-' . $count]) && $_POST['order-' . $count] != '') { 
			
				$image_order = $_POST['order-' . $count];

				if ( $image_order > 0 && $image_order <= 999 ) : // make sure it is integer between 0 & 999
					
					$new_order = format_number($image_order);
					
					if ( $new_order > $current_order) {
						
						$current_name = 'zzzzzzz' . '-' . $count;
						
					}
					
					$old =  $imagePath . $current_image;
										
					$new = $tempDir . $new_order . '_' . $current_name . '.' . $ext;
					
					$fix = 1;
					while (file_exists($new)) {
						$new = $imagePath . format_number($image_order + $fix) . '_'. $current_name . '.' . $ext;
						$fix++;
					}
					
					rename( $old , $new);
					// $warning .= 'order"' . $image_order . '" | image "' . $current_name . '" | imagepath: ' . $imagePath . ' | old: ' . $old . ' | new: ' . $new;
				else : 
					$warning .= 'The new order value of "' . $image_order . '" for the image "' . $current_name . '" was not a number between 0 and 999.';
				
				endif; 
			}
			$count++;
		}

	};
		
// NOW MOVE ALL REMAINING IMAGES INTO 'GalleryName/TEMP' **********************************
			
	$galleryImages = get_seo_gallery_images($currentCategory, $currentGallery); // have to re-get array without moved images

	if ($galleryImages) { 
	
		sort($galleryImages); 
		
		foreach ($galleryImages as $galleryImage) { 
		
			$current_name = get_image_name($galleryImage);
			$current_order = get_image_order($galleryImage);
			$ext = get_imageext($galleryImage);
	
			$old =  $imagePath . $galleryImage;
										
			$new = $tempDir . $galleryImage;
			
			$fix = 1;
			
			while (file_exists($new)) {
				$new = $imagePath . 'temp/' . format_number($current_order + $fix) . '_' . $current_name . '.' . $ext;
				$fix++;
			}
					
					rename( $old , $new);

										
		};
			
	};
	
 // NOW MOVE ALL IMAGES Back into INTO Gallery Folder **********************************

	$galleryImages = get_seo_gallery_images($currentCategory, $currentGallery . '/temp' ); 

	if ($galleryImages) { 
		
		sort($galleryImages); 
		
		$count = 1; 
		
		foreach ($galleryImages as $galleryImage) { 
			
			$old = $tempDir . $galleryImage;
										
			$new = $imagePath . $galleryImage;
					
			rename( $old , $new);
										
		}
	}; 
	
// DELETE TEMP FOLDER *********************************************************************

	if (file_exists($tempDir)) { seo_gallery_delete_directory($tempDir); } ;

						
?>
		<?php if ($message != '') : ?>
		<div class="updated">
			<p><?php echo $message; ?>
			</p>
		</div>
		<?php else : endif; ?>
		 
		<?php if ($warning != '') : ?>
			<div class="error">
				<p><?php echo $warning; ?></p>
			</div>
		<?php else : endif; 	 
	
	endif;	
} 

?>