<?php 
/*
/
/	plugin-functions.php
/	Defines all functions used within the plugin itself
/
/
*/

function get_image_path ($theImageSrc) {

	global $wpdb;
	$blogid = $wpdb->blogid;
	if (file_exists(WP_CONTENT_DIR . '/blogs.dir/')) {
		if (isset($blogid) && $blogid > 0) {
			$imageParts = explode('/files/', $theImageSrc);
			if (isset($imageParts[1])) {
				$theImageSrc = '/blogs.dir/' . $blogid . '/files/' . $imageParts[1];
			}
		}
	} else { 
		$imageParts = explode('/wp-content/', $theImageSrc);
		if (isset($imageParts[1])) {
			$theImageSrc = '/wp-content/' . $imageParts[1];	
		}	
	};
	return $theImageSrc;
}

/*********************************************************************
/
Descriptions of functions here
/

*********************************************************************/
function  seo_gallery_delete_directory($dirname) {
   if (is_dir($dirname))
      $dir_handle = opendir($dirname);
   if (!$dir_handle)
      return false;
   while($file = readdir($dir_handle)) {
      if ($file != "." && $file != "..") {
         if (!is_dir($dirname."/".$file))
            unlink($dirname."/".$file);
         else
            seo_gallery_delete_directory($dirname.'/'.$file);    
      }
   }
   closedir($dir_handle);
   rmdir($dirname);
   return true;
};

function renumber_gallery($currentCategory, $currentGallery) {

			$galleryImages = get_seo_gallery_images($currentCategory, $currentGallery);

			$fixCount = 1;
			
			if ($galleryImages) {
			
			sort($galleryImages);
			
			foreach ($galleryImages as $galleryImage) { 
				
				$fix_name = $currentGallery;
			
				$ext = get_imageext($galleryImage);
			
				$order = format_number($fixCount);
			
				$old =  SEO_GALLERY_CONTENT_PATH . $currentCategory . '/' . $currentGallery . '/' . $galleryImage;
				$new =  SEO_GALLERY_CONTENT_PATH . $currentCategory . '/' . $currentGallery . '/' . $order . '_' . $fix_name . '.' . $ext;
				
				$fix = 1;
				while (file_exists($new)) {
					$new = SEO_GALLERY_CONTENT_PATH . $currentCategory . '/' . $currentGallery . '/' . $order . '_' . $fix_name . '-' . $fix . '.' . $ext;
					$fix++;
				}
				
				rename( $old,  $new);
				$fixCount++;
			}
			
			}
			
			// now repeat to clean them up
			
			$galleryImages = get_seo_gallery_images($currentCategory, $currentGallery);
			
			$fixCount = 1;
			
			if ($galleryImages) {
			
			sort($galleryImages);
			
			foreach ($galleryImages as $galleryImage) { 
				
				$fix_name = $currentGallery;
			
				$ext = get_imageext($galleryImage);
			
				$order = format_number($fixCount);
			
				$old =  SEO_GALLERY_CONTENT_PATH . $currentCategory . '/' . $currentGallery . '/' . $galleryImage;
				$new =  SEO_GALLERY_CONTENT_PATH . $currentCategory . '/' . $currentGallery . '/' . $order . '_' . $fix_name . '.' . $ext;
				
				rename( $old,  $new);
				$fixCount++;
			}
			
			
			}
			
};

function rename_all_galleries () {
	
	if (!defined ('GALLERIES_ARE_RENAMED')) {
	
	$all_cats = get_seo_gallery_categories();
	
	// FIRST CLEAN UP CATEGORY NAMES
	
	foreach ( $all_cats as $cat) { 
		
		$old =  SEO_GALLERY_CONTENT_PATH . $cat;
		$cat =  clean_it($cat);
		$new =  SEO_GALLERY_CONTENT_PATH . $cat;
				
		rename ($old, $new);
	}
	
	// GO THROUGH CLEANED UP CATEGORIES AND CLEAN GALLERY NAMES
	
	$all_cats = get_seo_gallery_categories();
	
	foreach ( $all_cats as $cat) { 
		
		$cat_galleries = get_seo_gallery_names($cat);
		
		if ($cat_galleries) {
		
		foreach ($cat_galleries as $gallery) {
			$old =  SEO_GALLERY_CONTENT_PATH . $cat . '/' . $gallery;
			$gallery =  clean_it($gallery);
			$new =  SEO_GALLERY_CONTENT_PATH . $cat . '/' . $gallery;
			
			rename ($old, $new);		
		}
		}
	}

	// GO THROUGH CLEANED UP FOLDERS AND RENAME IMAGES


	$all_cats = get_seo_gallery_categories();
	
	foreach ( $all_cats as $cat) { 
		
		$cat_galleries = get_seo_gallery_names($cat);
		
		if ($cat_galleries) {

		
			foreach ($cat_galleries as $gallery) {
			
				$images = get_seo_gallery_images($cat, $gallery);
			
				$count = 1;
			
				if ($images) {
					foreach ($images as $image) {
				
						$order = format_number($count);
						$ext = get_imageext($image);
				
						$old =  SEO_GALLERY_CONTENT_PATH . $cat . '/' . $gallery . '/' . $image;
						$new =  SEO_GALLERY_CONTENT_PATH . $cat . '/' . $gallery . '/' . $order . '_' . $gallery . '.' . $ext;
				
					// if file already exists, keep adding 1 to order until you find an open space
					$fix = 1;
					while (file_exists($new)) {
						$new = SEO_GALLERY_CONTENT_PATH . $cat . '/' . $gallery . '/' . format_number($image_order + $fix) . '_' . $gallery . '.' . $ext;
						$fix++;
					}
						rename ($old, $new);
						$count++;
					}
				}
			}				
		}	
	}
	
	define ('GALLERIES_ARE_RENAMED', 'true');
	
	}

};

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}


// format number of digits

// $number ~ the original number
// $length ~ the length to pad the number to

function format_number($number) {
 $arg = "%03d";
 return sprintf($arg, $number);
};

// get Image order - filename must be in format of '001_filename.jpg'

function get_image_order ($imageFileName) {

	$imageFileName = explode ('.', $imageFileName); 
	$imageName = $imageFileName[0];						// remove extension
	
	$imageParts = explode ('_', $imageName);
			
	$order = $imageParts[0];
	
	return $order;
};

// get Image name - filename must be in format of '001_filename.jpg'

function get_image_name ($imageFileName) {

	$imageFileName = explode ('.', $imageFileName); 
	$imageName = $imageFileName[0];						// remove extension
	
	$imageParts = explode ('_', $imageName);
			
	$name = $imageParts[1];
	
	return $name;
};

function get_imageext ($fileName) {
	$ext = substr($fileName, strrpos($fileName, '.') + 1);
	return $ext;
};

// Cleans Gallery Names when creating new ones
	
function is_good_name($name) {
      $pattern = '/^[a-zA-Z0-9_.-]{1,20}$/';
      if (preg_match($pattern,$name)) return true;
      else return false;
};

function clean_it ($name) { 
	$name = strip_tags($name); // strip all tags
	$name = preg_replace('/[^a-zA-Z0-9-\s]/', '', $name); // replace all non-alphanumeric characters, remove whitespace at beggining and end but leave spaces.
	$name = str_replace(' ', '-', $name); // replace space with dashes
	$name = str_replace('--', '-', $name); // replace double dashes with dashes	
	$name = strtolower($name); // convert all to lowercase
	return $name;
}

function return_nicename($name) {
	$name = str_replace('-', ' ', $name);
	$name = ucwords($name);
	return $name;
}

function seo_display_function_name($name) {
	$name = str_replace('.php', '', $name);

	$name = clean_it($name);
	$name = 'seo_' . str_replace('-', '_', $name);
	return $name;
}

function seo_display_nicename($name) {
	$name = return_nicename($name);
	$name = str_replace('.php', '', $name);
	return $name;
}

function seo_image_alt($cat='', $gallery='') {
	
	global $post,$wpdb;
	$shortname = SIG_SHORTNAME;
	$site_name = get_option('blogname');

	$cat = clean_it($cat);
	$galleryName = clean_it($gallery);

	$cat = return_nicename($cat);
	$gallery = return_nicename($gallery);
	
	
	$alt = '';
	
	$custom_alt = get_option($shortname.'custom_alt');
	$alt_options = get_option($shortname.'alt_options');
	
	if ($alt_options == '') { update_option($shortname.'alt_options', 'use-all'); };

	if ($alt_options == 'site-name') :		
		$alt = $site_name;
	elseif ($alt_options == 'post-titles') : 
		if (isset($post) && !is_home()) :
			$alt = $post->post_title;
		elseif (is_admin()) :
			$alt = 'titleofpost';
		else :		 
			$alt = $site_name;
		endif;
	elseif ($alt_options == 'gallery-names') : 
	
		$alt = clean_it($cat . '-' . $gallery);
	
	elseif ($alt_options == 'use-custom') : 
	
		$alt = clean_it($custom_alt);

	elseif ($alt_options == 'use-all-but-site') : 
		if (is_admin()) : 
			$alt =  $cat . '-' . $gallery . '-' . 'titleofpost';
		elseif (is_home()) : 
			$alt = $cat . '-' . $gallery;
		else : 
			$alt =$cat . '-' . $gallery . '-' . $post->post_title;
		endif;
	
	elseif ($alt_options == 'use-all') : 
		if (is_admin()) : 
			$alt =  $cat . '-' . $gallery . '-' . 'titleofpost' . '-' . $site_name;
		elseif (is_home()) : 
			$alt = $cat . '-' . $gallery . '-' . $site_name;
		else : 
			$alt =$cat . '-' . $gallery . '-' . $post->post_title . '-' . $site_name;
		endif;
	else : 
		if (is_admin()) : 
			$alt = $site_name . '-' . $cat . '-' . $gallery . '-' . 'titleofpost';
		elseif (is_home()) : 
			$alt = $site_name . '-' . $cat . '-' . $gallery;
		else : 
			$alt = $site_name . '-' . $cat . '-' . $gallery . '-' . $post->post_title;
		endif;
	
	endif;
	
	if ($alt == '' )
		$alt = $post->post_title;
	
	
	$alt = return_nicename($alt);
	 
	return $alt;
};

// Returns an array of all category names

function get_seo_gallery_categories() {
	$catArray = array();
	$path = SEO_GALLERY_CONTENT_PATH;
	if (file_exists($path)) :
		$contents = glob($path.'/*');
		$folders = array_filter($contents, 'is_dir');
		$i=0;
		foreach ($folders as $cat) {
			$catArray[$i] = basename($cat);
			$i++;
		}
	else : 
		$catArray = '';
	endif;
	
	if ($catArray) { sort($catArray); };
	
	return $catArray;

};

// Returns an array of all gallery names

function get_seo_gallery_names($cat) {
	$cat = clean_it($cat);
	$folders = array();
	$galleryName = clean_it($galleryName);
	$galleryArray = array();
	$path = SEO_GALLERY_CONTENT_PATH . $cat;
	if (file_exists($path)) :
		$contents = glob($path.'/*');
		$folders = array_filter($contents, 'is_dir');
		$i=0;
		foreach ($folders as $gallery) {
			$galleryArray[$i] = basename($gallery);
			$i++;
		}
	else : 
		$galleryArray = '';
	endif;
	if ($galleryArray) { sort($galleryArray); };
	return $galleryArray;

};

// Returns the full URL for the gallery thumbnail

function get_seo_gallery_thumbnail($cat, $galleryName) {
	
	$cat = clean_it($cat);
	$galleryName = clean_it($galleryName);

	if ( $thumb = get_option( SIG_SHORTNAME . $cat . '_' . $galleryName . '_' . 'gallery_thumbnail') ) :
		return $thumb;
	else :
		return false;
	endif;
}

function rename_category_thumbs($currentCategory,$new_category) {
	$cat_galleries = array();
	$cat_galleries = get_seo_gallery_names($currentCategory);
					
	foreach ($cat_galleries as $gallery) {
						
		$old_thumb = get_option( SIG_SHORTNAME . $currentCategory . '_' . $gallery . '_' . 'gallery_thumbnail' );
						
		if ($old_thumb) {
			delete_option( SIG_SHORTNAME . $currentCategory . '_' . $gallery . '_' . 'gallery_thumbnail' );
			update_option( SIG_SHORTNAME . $new_category . '_' . $gallery . '_' .'gallery_thumbnail', $old_thumb);
		};
					
	};
}

// Returns an array of images from a folder

function get_seo_gallery_images($cat, $galleryName) {

	$cat = clean_it($cat);
	$galleryName = $galleryName;
	
	$galleryNamePieces = array();
	$galleryNamePieces = explode ('/',$galleryName);
	
	$cleanPiece = array();
	
	foreach ( $galleryNamePieces as $galleryNamePiece ) {
		$cleanPiece[] = clean_it($galleryNamePiece);
	}
	
	$galleryName = implode('/',$cleanPiece);
	
	
	$path = SEO_GALLERY_CONTENT_PATH . $cat . '/'. $galleryName;
	
	if (file_exists ($path)){ 
	if ($handle = opendir($path)) {
		$imageString = "";
		$count = 0; 	
		while (false !== ($file = readdir($handle))) {			if ($file != "." && $file != "..") {
				$image = $file;
				$file = substr($file, strrpos($file, '.') + 1);
				if ($file == "jpg" or $file == "png" or $file == "gif") { //replace with.php or.txt to get text files??
					$imageArray[$count]=$image;
					$count++;
				}
			}	
		}
		if ($count = 0) {
			echo 'No pages created yet';
		}					
	}
	}
	if ($imageArray) { sort($imageArray); };
	
	return $imageArray;

};

// Returns an array of .php files from a folder

function get_seo_gallery_displays() {

	$path = SEO_IMAGE_PLUGIN_BASEDIR . '/displays';
	
	if (file_exists ($path)){ 
	if ($handle = opendir($path)) {
		$displayString = "";
		$count = 0; 	
		while (false !== ($file = readdir($handle))) {			if ($file != "." && $file != "..") {
				$display = $file;
				$file = substr($file, strrpos($file, '.') + 1);
				if ($file == "php" ) { 
					$displayArray[$count]=$display;
					$count++;
				}
			}	
		}
		if ($count = 0) {
			echo 'No pages created yet';
		}					
	}
	}
	if ($displayArray) { sort($displayArray); };
	
	return $displayArray;

};

function seo_gallery_thumb($cat, $galleryName) {
	
	$cat = clean_it($cat);
	$galleryName = clean_it($galleryName);
	
	$imageArray = get_seo_gallery_images($cat, $galleryName);
	$i = 0;
	foreach ($imageArray as $image) {
		$path = SEO_GALLERY_CONTENT_URL . $cat . '/' . $galleryName; 
		$image= basename($image);
		$imageFile=$path.'/'.$image;	
		$ext = strrchr($image, '.'); // remov extensions for div ids		
		if ($ext !== false)  {
			$name = substr($image, 0, -strlen($ext));
		}			
		echo '<li id="' . $gallery . '-' . $name . '" class="seo-thumbs ' . $galleryName . '"><img class="thumbnails" src="'.$imageFile.'" /></a>';
		$i++;
	}	 			
};

function seo_gallery_full_images($cat, $galleryName) {
	$cat = clean_it($cat);
	$galleryName = clean_it($galleryName);
				
	$imageArray = get_seo_gallery_images($cat, $galleryName);
			
	$i = 0;
	foreach ($imageArray as $image) {
		$path = SEO_GALLERY_CONTENT_URL . $cat . '/' . $galleryName;
		$image= basename($image);
		$imageFile=$path.'/'.$image;	
		$ext = strrchr($image, '.'); // remov extensions for div ids		
		if($ext !== false)  {
  			$name = substr($image, 0, -strlen($ext));
  	 	}			
		echo '<li id="' . $gallery . '-' . $name . '" class="seo-images ' . $galleryName . '"><img src="'.$imageFile.'" /></li>';
		$i++;
	}
};

?>