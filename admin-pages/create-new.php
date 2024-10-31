<?php 

		if(empty($_REQUEST['create_type'])){
			$create_type = '';
		}else{
            $create_type = $_REQUEST['create_type'];
        };

		if(empty($_REQUEST['create_name'])){
            $create_name = '';
        }else{
            $create_name = $_REQUEST['create_name'];
        };

		if(empty($_REQUEST['create_current_cat'])){
            $create_current_cat = '';
        }else{
            $create_current_cat = $_REQUEST['create_current_cat'];
        };

		$create_name = clean_it($create_name);
		$display_name = return_nicename($create_name);
		
		$create_current_cat = clean_it($create_current_cat);
		$display_cat_name = return_nicename($create_current_cat);		
		
		switch ($create_type) {

			case "category":
        		$path = SEO_GALLERY_CONTENT_PATH;
				$new = $path . $create_name;
        	break;
    		case "gallery":
        		$path = SEO_GALLERY_CONTENT_PATH . $create_current_cat ;
				$new = $path.'/'.$create_name;

       		break;
		};

if ($_POST['options-submit']){


if ( !wp_verify_nonce( $_POST[ 'create_nonce' ], 'create_nonce' ) ) : ?>

				<div class="updated">
					<p>There was a problem. Please try again.</p>
				</div>

<?php
 
else :  

	if ( $create_name != '' && file_exists($new)) :
	
		switch ($create_type) {
    		case "category":
				$message = 'A Category named "'.$display_name.'" already exists. Please try again.';
				break;
   			case "gallery":
				$message = 'A Gallery named "'.$display_name.'" already exists. Please try again.';
				break;
		}
		$class = 'error';

	
	elseif ( $create_name != '' && !file_exists($new)): 	
	
		switch ($create_type) {
    		case "category":
				mkdir($new);
				$message = 'A Category named "'.$display_name.'" has been created. <a href="' . get_bloginfo('wpurl') . '/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=categories-edit&edit_name=' . $create_name . '&edit_nonce=' . wp_create_nonce('edit_nonce'). '">Add Galleries</a>';
				
								
			break;
   			case "gallery":
				mkdir($new);
				$message = 'A Gallery named "'.$display_name.'" has been created. <a href="' . get_bloginfo('wpurl') . '/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=galleries-edit&seo_category=' . $create_current_cat . '&seo_gallery=' . $create_name . '">Add Images</a>';				
			break;
		}
		$class = 'updated';
		
	else:
		$message = 'An error occured: path: ' . $new . ' name: ' . $create_name;
	endif;
		?>
	
	<?php if ($class == '') { $class = 'updated'; }; ?>
		
	<div class="<?php echo $class; ?>">
		<p><?php echo $message; ?></p>
	</div>			
<?php 

endif; 
}
else
{ ?>



<?php
};

?>
<h2>Create New Categories and Galleries</h2>
<h3>Create New Category</h3>
<div class="pane">
	<div class="section">
		<form name="create-category" method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);?>">
			<p id="addNew" class="submit">New Category Name:
				<?php wp_nonce_field( 'create_nonce', 'create_nonce', false, true ); ?>
				<input size="20" type="text" name="create_name" value="">
				<input type="hidden" name="create_type" value="category" />
				<input type="hidden" name="options-submit" value="1" />
				<input class="button-primary"type="Submit" name="Submit-Category" value="Create" />
			</p>
		</form>
	</div>
</div>
<h3>Create New Gallery</h3>
<div class="pane">
	<div class="section">
		<form name="create-gallery" method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);?>">
			<p id="addNew" class="submit">New Gallery Name:
				<?php wp_nonce_field( 'create_nonce', 'create_nonce', false, true ); ?>
				<input size="20" type="text" name="create_name" value="">
				<?php $cats = get_seo_gallery_categories(); ?>
				<select name="create_current_cat">
  				<?php foreach ($cats as $cat) { ?>
					<option value="<?php echo $cat; ?>"><?php echo return_nicename($cat); ?></option>			
				<?php };?>
				</select>
				<input type="hidden" name="create_type" value="gallery" />
				<input type="hidden" name="options-submit" value="1" />
				<input class="button-primary"type="Submit" name="Submit-Gallery" value="Create" />
			</p>
		</form>
	</div>
</div>