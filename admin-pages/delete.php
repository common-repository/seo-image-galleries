<?php 

		if(empty($_REQUEST['delete_type'])){
			$delete_type = '';
		}else{
            $delete_type = $_REQUEST['delete_type'];
        };

		if(empty($_REQUEST['delete_all'])){
			$delete_all = 'move';
		}else{
            $delete_all = $_REQUEST['delete_all'];
        };

		if(empty($_REQUEST['delete_name'])){
            $delete_name = '';
        }else{
            $delete_name = $_REQUEST['delete_name'];
        };

		if(empty($_REQUEST['current_delete_category'])){
            $current_delete_category = '';
        }else{
            $current_delete_category = $_REQUEST['current_delete_category'];
        };

		$delete_name = clean_it($delete_name);
		$display_name = return_nicename($delete_name);

		$delete_cat_name = clean_it($current_delete_category);
		$display_cat_name = return_nicename($delete_cat_name);


		switch ($delete_type) {
    		case "category":
        		$delete = SEO_GALLERY_CONTENT_PATH . $delete_name;
        	break;
    		case "gallery":
        		$delete = SEO_GALLERY_CONTENT_PATH . $current_delete_category . '/'.$delete_name ;
       		break;
		};

if ($delete_name == 'uncategorized' && $delete_type == 'category' ) { ?>

	<div class="error">
		<p>'You cannot delete the category named 'Uncategorized'. Please try again.</p>
	</div>		
	
<?php exit; } ?>

<?php 

if ( !wp_verify_nonce( $_REQUEST[ 'delete_nonce' ], 'delete_nonce' ) ) : ?>

				<div class="updated">
					<p>There was a problem. Please try again.</p>
				</div>

<?php
 
else :  

	if ( $delete_name != '' && file_exists($delete)) :
	
		switch ($delete_type) {
    		case "category":
				
				if ($delete_all == 'move') {	

					// First move all galleries to uncategorized
					$galleries = get_seo_gallery_names($delete_name);
					if (is_array($galleries)) {
						$move_message = '<p>The Galleries...<ul>';
						foreach ($galleries as $gallery) {	
							if ( file_exists(SEO_GALLERY_CONTENT_PATH . 'uncategorized/'. $gallery) ) :
								$galleryNew = $gallery . rand(1,999);
								rename ( SEO_GALLERY_CONTENT_PATH . $delete_name . '/' . $gallery , SEO_GALLERY_CONTENT_PATH . 'uncategorized/'. $galleryNew);
							else : 
								rename ( SEO_GALLERY_CONTENT_PATH . $delete_name . '/' . $gallery , SEO_GALLERY_CONTENT_PATH . 'uncategorized/'. $gallery);
							endif;
							$move_message .= '<li>..."' .$gallery .'"...</li>';
						};		
						$move_message .= '</ul>...have been moved to the "Uncategorized" category.</p>';				
					}
				};
				
				// Otherwise delete all files, folders and delete category
				if ( seo_gallery_delete_directory($delete)) :
					$message = 'The Category named "'.$display_name.'" has been deleted.'.$move_message;				
				else : 
					$message = 'The was a problem deleting "'.$display_name.'".';
					$class = 'error';				
				endif; 
				
			break;
   			case "gallery":
				if ( seo_gallery_delete_directory($delete)) :
					$message = 'The Gallery named "'.$display_name.'" has been deleted from the "'.$display_cat_name.'" category.';				
				else : 
					$message = 'The was a problem deleting "'.$display_name.'" from the "'.$display_cat_name.'" category.';
					$class = 'error';				
				endif; 			
			break;
		}
		$class = 'updated';

	
	elseif ( $delete_name != '' && !file_exists($delete)): 	
	
		switch ($delete_type) {
    		case "category":
				$message = ' There was no Category named "'.$display_name.'" to delete. Please try again.';
				break;
   			case "gallery":
				$message = ' There was no Gallery named "'.$display_name.'" to delete. Please try again.';
				break;
		}
		$class = 'error';
		
	else:
		$message = 'An error occured: path: ' . $delete . ' name: ' . $delete_name;
	endif;
		?>
	
	<?php if ($class == '') { $class = 'updated'; }; ?>
		
	<div class="<?php echo $class; ?>">
		<p><?php echo $message; ?></p>
	</div>			
<?php 

endif; 

?>