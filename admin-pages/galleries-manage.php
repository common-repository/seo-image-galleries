<?php 		

	$cat=array();
	$fixed_cats = array();
	$cats = get_seo_gallery_categories(); 
	if ($cats) { 
		sort ($cats);
		$fixed_cats = $cats;	
	};
	
	$message = '';

foreach ( $fixed_cats as $cat ) {

if ($_POST['rename_submit_'.$cat]){
 
			if ( !wp_verify_nonce( $_POST[ 'cat_manage_'.$cat ], 'galleries_manage_'.$cat ) ) : 
				echo '<div class="updated">No Good</div>';
			else :  // UPDATE Category NAME
					
				if (isset ($_POST['rename_category_'.$cat])) { 			
					$rename_category = clean_it($_POST['rename_category_'.$cat]);
				};
		
				if (isset ($_POST['cat_fix_'.$cat])) { 			
					$currentCategory = clean_it($_POST['cat_fix_'.$cat]);
				};
		
				if ( $rename_category != '' && $rename_category != $currentCategory ) : 
					$new_category = $rename_category;
						
						if ( file_exists(SEO_GALLERY_CONTENT_PATH . $new_category) ) :
							$new_category_new = $new_category . rand(1,999);					
							rename_category_thumbs($currentCategory,$new_category_new);							
							rename( SEO_GALLERY_CONTENT_PATH . $currentCategory , SEO_GALLERY_CONTENT_PATH . $new_category_new );									
							$message .= '<p>The name you chose was already taken. A random number was added to the category name. Please rename again.</p>';
						else : 
							rename_category_thumbs($currentCategory,$new_category);
							rename( SEO_GALLERY_CONTENT_PATH . $currentCategory , SEO_GALLERY_CONTENT_PATH . $new_category );
						endif;
						
					
					if ( $currentCategory == 'uncategorized' && !file_exists(SEO_GALLERY_CONTENT_PATH . 'uncategorized')) : 
						mkdir(SEO_GALLERY_CONTENT_PATH . 'uncategorized');
					else : endif;
						$message .= 'The Catgeory "' . $currentCategory . '" has been renamed: "' . return_nicename($new_category) . '".<br />';
				
				
				else : 
				
				endif;					
					
				?>

				<?php 
			endif; 

	
	if ($message !='') { 
		echo '<div class="updated">';
		echo '<p>' . $message . '</p>';
		echo '<p>' . $message2 . '</p>';
		echo '</div>';
	};
		
}; // end if $_POST
}; // end foreach

$message = '';
?>
<h2>Manage Galleries</h2>
<div id="tabs">
<?php 
	$cat=array();
	$fixed_cats = array();
	$cats = get_seo_gallery_categories(); 
	if ($cats) { 
		sort ($cats);
		$fixed_cats = $cats;	
	};
if ($fixed_cats) { 
	foreach ($fixed_cats as $cat) { ?>
	<h3 class="tabs">Category: "<?php echo return_nicename($cat); ?>"</h3>
<?php
	} // end foreach - but not if...
	
?>
</div>
<div id="panels">

<?php
	$delete_nonce = wp_create_nonce( 'delete_nonce');

	foreach ($fixed_cats as $cat) { ?>
	<div class="pane">
		<div class="postbox">
			<h3>Rename This Category</h3>
			<form name="rename-form" method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);?>">
		<?php wp_nonce_field( 'galleries_manage_'.$cat, 'cat_manage_'.$cat, false, true ); ?>
				<input name="rename_submit_<?php echo $cat; ?>" type="hidden"  value="1" />
				<input name="cat_fix_<?php echo $cat; ?>" type="hidden" value="<?php echo $cat; ?>" />
				<input name="rename_category_<?php echo $cat; ?>" type="text" size="12" value=""/>
				<input name="Submit_<?php echo $cat; ?>" type="Submit" class="button-secondary" value="Rename"/>
			</form>
		</div>
		<div class="postbox">
			<h3>Add a Gallery</h3>
			<form name="create-gallery" method="post" enctype="multipart/form-data" action="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=create-new">
			<?php wp_nonce_field( 'create_nonce', 'create_nonce', false, true ); ?>
				<p id="addNew" class="submit">New Gallery Name:
					<input size="20" type="text" name="create_name" value="">
					<input type="hidden" name="create_current_cat" value="<?php echo $cat; ?>" />
					<input type="hidden" name="create_type" value="gallery" />
					<input type="hidden" name="options-submit" value="1" />
					<input class="button-primary" type="Submit" name="Submit-Gallery" value="Create" />
				</p>
			</form>
		</div>
		<div class="postbox">
			<h3>Current Galleries in the "<?php echo return_nicename($cat); ?>" Category</h3>
			<ul>
		<?php 
		$galleries = array();
		$galleries = get_seo_gallery_names($cat);
		if ($galleries[0] != '') : 
			foreach ($galleries as $gallery) { ?>
				<li>
					<?php $thumb = get_option( SIG_SHORTNAME . $cat . '_' . $gallery . '_' . 'gallery_thumbnail'); ?>
					<?php if ( isset($thumb) && $thumb != '') : ?>
					<img class="thumbnails" src="<?php echo $thumb; ?>" / >
					<?php else : ?>
					<p class="thumbnails"><a href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=galleries-edit&seo_edit_type=gallery&seo_category=<?php echo $cat; ?>&seo_gallery=<?php echo $gallery; ?>">Add a Thumbnail here.</a>
					</p> 
					<?php endif;?>
					<div class="gallery-quick-links">
						<h3>
							<span><a href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=galleries-edit&seo_edit_type=gallery&seo_category=<?php echo $cat; ?>&seo_gallery=<?php echo $gallery; ?>">edit</a>
							</span>
						<?php echo return_nicename($gallery); ?>
						</h3>
					</div>
					<div class="gallery-code-titles">
						<p>SHORTCODE:</p>
					</div>
					<div class="gallery-code">
						<p>&#91;seo_gallery category="<?php echo return_nicename($cat); ?>" gallery="<?php echo return_nicename($gallery); ?>"&#93;
						</p>
					</div>
					<div class="gallery-quick-links">
						<h3>				<a class="button-secondary delete" href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=delete&delete_type=gallery&current_delete_category=<?php echo $cat; ?>&delete_name=<?php echo $gallery; ?>&delete_nonce=<?php echo $delete_nonce; ?>">Delete This Gallery</a>

						</h3>
					</div>
				</li>
<?php 
		
			} // foreach gallery
		else : 
?>
				<li>No Galleries in this Category Yet
					<a href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=categories-edit&edit_name=<?php echo $cat; ?>">Add your first gallery Here</a>
				</li>
<?php 
		endif; 	// if galleries	
?>
			</ul>
		</div>
		<div class="postbox">
			<h3>Delete This Category</h3>
			<div class="pad15">
			<form name="delete_category" method="post" enctype="multipart/form-data" action="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=delete">
					<input type="hidden" name="delete_type" value="category" />
					<input type="hidden" name="delete_name" value="<?php echo $cat; ?>" />
					<input type="hidden" name="delete_nonce" value="<?php echo $delete_nonce; ?>" />
					<input type="hidden" name="create_type" value="gallery" />

				<input type="radio" name="delete_all" value="delete" />Delete all galleries with it.
				<input type="radio" name="delete_all" value="move" />Move all galleries to "Uncategorized"
				<input type="Submit" class="button-secondary delete" value="Delete This Category" />
			</form>
			</div>
		</div>
	</div>
	
<?php 
	} // end foreach cat
?>
</div>
<?php
} // endif
?>
</div>