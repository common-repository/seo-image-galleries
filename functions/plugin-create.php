<?php

//DEFINE SHORTNAMES
if (!defined('SIG_SHORTNAME')) { define('SIG_SHORTNAME',  'sig_'); }

global $wpdb;
$BlogID = $wpdb->blogid;

define('SEOGALLERY_CURRENT_BLOGID', $BlogID );


// TEST TO SEE IF AN MU UPLOAD DIRECTORY HAS BEEN CREATED. IF NOT, CREATE IT:
if ( function_exists('wpmu_create_blog') && file_exists(WP_CONTENT_DIR . '/blogs.dir/') && SEOGALLERY_CURRENT_BLOGID != '' ) { // IF THIS IS MU && Uplaod directory not created...

	if ( !file_exists(WP_CONTENT_DIR . '/blogs.dir/' . SEOGALLERY_CURRENT_BLOGID ) ) {
		mkdir (WP_CONTENT_DIR . '/blogs.dir/' . SEOGALLERY_CURRENT_BLOGID,0755);
	}	

	if ( !file_exists(WP_CONTENT_DIR . '/blogs.dir/' . SEOGALLERY_CURRENT_BLOGID . '/files')) {
		mkdir (WP_CONTENT_DIR . '/blogs.dir/' . SEOGALLERY_CURRENT_BLOGID . '/files',0755 );
	}	
};

// create / add thumbnail folder
if ( !file_exists(WP_CONTENT_DIR . '/seo-image-gallery-thumbnails')) {
	mkdir (WP_CONTENT_DIR . '/seo-image-gallery-thumbnails',0755 );
}
if ( !file_exists(WP_CONTENT_DIR . '/seo-image-gallery-thumbnails/cache')) {
	mkdir (WP_CONTENT_DIR . '/seo-image-gallery-thumbnails/cache',0755 );
}
if ( !file_exists(WP_CONTENT_DIR . '/seo-image-gallery-thumbnails/temp')) {
	mkdir (WP_CONTENT_DIR . '/seo-image-gallery-thumbnails/temp',0755 );
}
if ( !file_exists(WP_CONTENT_DIR . '/seo-image-gallery-thumbnails/timthumb.php') && file_exists(SEO_IMAGE_PLUGIN_BASEDIR . '/timthumb.php')) {
	copy (SEO_IMAGE_PLUGIN_BASEDIR . '/timthumb.php',WP_CONTENT_DIR . '/seo-image-gallery-thumbnails/timthumb.php' );
}

if( !defined( 'BLOGUPLOADDIR' ) ) define( 'BLOGUPLOADDIR', WP_CONTENT_DIR . '/blogs.dir/' . SEOGALLERY_CURRENT_BLOGID. '/files' );
	
	$current_upload = get_option(SIG_SHORTNAME . 'old_custom_upload'); 	// will be 'seo-galleries' to start
	$custom_upload = get_option(SIG_SHORTNAME . 'custom_upload');		// will be empty to start

	if ( $current_upload == '' ) { 
		$current_upload = 'seo-galleries';
		update_option(SIG_SHORTNAME.'old_custom_upload', 'seo-galleries');
	};

	if ( $custom_upload != '' ) :
		$correct_upload = $custom_upload;
		$custom_upload = $custom_upload;
	else :
		$correct_upload = 'seo-galleries';
		$custom_upload = 'seo-galleries';
	endif;

// DEFINE CUSTOM UPLOAD FOLDER

// TEST FOR MU... 	
if (file_exists(BLOGUPLOADDIR) ) : // IF THIS IS MU...

	$oldDIR = BLOGUPLOADDIR . '/' . $current_upload . '/';
	$newDIR = BLOGUPLOADDIR . '/' . $custom_upload . '/';

	$dir = BLOGUPLOADDIR . '/' . $correct_upload . '/';

else : // IF REGULAR WORDPRESS...
	
	$oldDIR = WP_CONTENT_DIR . '/' . $current_upload . '/';
	$newDIR = WP_CONTENT_DIR . '/' . $custom_upload . '/';
	
	$dir = WP_CONTENT_DIR . '/' . $correct_upload . '/';

endif;

// RENAME CURRENT DIRECTORY or INITIAL 'seo-image-galleries' FOLDER TO NEW CUSTOM FOLDER NAME

	if ( isset($oldDIR) && $oldDIR != '' && file_exists($oldDIR) ) :
		rename($oldDIR, $newDIR);
	else :
		
	endif;
	
	if (file_exists($dir)) :
			// if the correct upload folder exists, do nothing
	else :	// in not, create it
		// echo '<div class="updated">Created the upload folder called: ' . $dir . '</div>';
		mkdir($dir,0755);
		update_option(SIG_SHORTNAME.'old_custom_upload', $correct_upload ); // hold new name as 'old' name to be tested against next time around.		
	endif;
		
	if (file_exists($dir . 'uncategorized')) :
	else :
		mkdir($dir . 'uncategorized',0755);	
	endif;	

// DEFINE BASE OF UPLOAD FOLDERS

// TEST FOR MU... 	
if (file_exists(WP_CONTENT_DIR . '/blogs.dir/' . SEOGALLERY_CURRENT_BLOGID) ) : // IF THIS IS MU...

	if ( !defined('SEO_GALLERY_CONTENT_BASEPATH') ) { define('SEO_GALLERY_CONTENT_BASEPATH', BLOGUPLOADDIR ); };		
	if ( !defined('SEO_GALLERY_CONTENT_BASEURL') ) { define('SEO_GALLERY_CONTENT_BASEURL', WP_CONTENT_URL . '/blogs.dir/' . SEOGALLERY_CURRENT_BLOGID . '/files'); };

else : // IF REGULAR WORDPRESS...

	if (!defined('SEO_GALLERY_CONTENT_BASEPATH')) { define('SEO_GALLERY_CONTENT_BASEPATH', WP_CONTENT_DIR ); }
	if (!defined('SEO_GALLERY_CONTENT_BASEURL')) { define('SEO_GALLERY_CONTENT_BASEURL',  WP_CONTENT_URL ); }
	
endif;

// DEFINE FULL UPLOAD FOLDERS

	define('SEO_GALLERY_CORRECT_DIR',  $correct_upload);

	if (!defined('SEO_GALLERY_CONTENT_PATH')) { define('SEO_GALLERY_CONTENT_PATH', SEO_GALLERY_CONTENT_BASEPATH . '/' . SEO_GALLERY_CORRECT_DIR . '/'); }
	if (!defined('SEO_GALLERY_CONTENT_URL')) { define('SEO_GALLERY_CONTENT_URL',  SEO_GALLERY_CONTENT_BASEURL . '/' . SEO_GALLERY_CORRECT_DIR . '/'); }

// URL / PATH USED TO DISPLAY IMAGES - HIDE BLOGS.DIR FOLDER
if (file_exists(WP_CONTENT_DIR . '/blogs.dir/' . SEOGALLERY_CURRENT_BLOGID) ) : // IF THIS IS MU...

	if ( !defined('SEO_GALLERY_CONTENT_USEPATH') ) { define('SEO_GALLERY_CONTENT_USEPATH', 'http://' . $current_blog->domain . '/files/' . SEO_GALLERY_CORRECT_DIR . '/'); };		

else : // IF REGULAR WORDPRESS...

	if ( !defined('SEO_GALLERY_CONTENT_USEPATH') ) { define('SEO_GALLERY_CONTENT_USEPATH', SEO_GALLERY_CONTENT_URL); };		
	
endif;

// DEFINE SKINS FOLDER
	
	if ( !defined('SEO_GALLERY_SKINS_BASEPATH') ) { define('SEO_GALLERY_SKINS_BASEPATH', SEO_GALLERY_CONTENT_BASEPATH . '/' . 'seo-image-gallery-skins/'); };
	if ( !defined('SEO_GALLERY_SKINS_URL') ) { define('SEO_GALLERY_SKINS_URL', SEO_GALLERY_CONTENT_BASEURL . '/' . 'seo-image-gallery-skins/'); };

	if ( !file_exists(SEO_GALLERY_SKINS_BASEPATH)) { mkdir(SEO_GALLERY_SKINS_BASEPATH); };

// CREATE HOLDER FOR SKINS...	
	
	function empty_gallery_info() {
	$GLOBALS['seo-gallery-count'] = 1;

	};

	add_action ('wp_head','empty_gallery_info');
	add_action ('admin_head','empty_gallery_info');
	
// Add jquery and jquery tools but only yo actual site....
	wp_enqueue_script('jquery');
	wp_enqueue_script('jTools', SEO_IMAGE_PLUGIN_URL . 'js/jquerytools.min.js', array('jquery'));
	wp_enqueue_script('multifile', SEO_IMAGE_PLUGIN_URL . 'js/multifile.js');
		
?>