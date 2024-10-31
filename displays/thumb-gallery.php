<?php 
$desc = '%Displays the standard thumbnail gallery.%';

/*********************************************************************
/
/	seo_thumb_gallery ($cat, $galleryName )
/
/
/	TEMPLATE TAGS:
/	seo_gallery()
/	seo_thumb_gallery()
/
/	SHORTCODES:
/	[seo_gallery]
/	[seo_thumb_gallery]
/
/
***********************************************************************/


add_shortcode('seo_gallery', 'seo_gallery_short');
add_shortcode('seo_thumb_gallery', 'seo_gallery_short');

function seo_gallery_short($atts) {

	global $post,$wpdb;

	extract(shortcode_atts(array(
		'category' => 'uncategorized',
		'gallery' => '',
		'thumbnails' => 'bottom',
		'skin' => 'default',
		'size' => 'large'
	), $atts));
	
	$category = clean_it($category);
	$gallery = clean_it($gallery);
	ob_start();	
	seo_thumb_gallery($category,$gallery, $skin, $thumbnails, $size);
	$output_string=ob_get_contents();
	ob_end_clean();

	return $output_string;
}

// A RENAMING TO PROTECT OLDER VERSIONS AND PREPARE FOR API
function seo_thumb_gallery($cat, $galleryName, $skin='default', $thumbnails = 'bottom', $gallerySize='large') {
	global $post,$wpdb;
	seo_gallery($cat, $galleryName, $skin, $thumbnails, $gallerySize);
};

function seo_gallery($cat, $galleryName, $skin='default', $thumbnails = 'bottom', $gallerySize='large') {

	global $post,$wpdb;

	$cat = clean_it($cat);
	$galleryName = clean_it($galleryName);
	
	$galleryArray = get_seo_gallery_images($cat, $galleryName);
	
	
	$skinURL = get_skins_stylesheet_url('thumb-gallery', $skin);
	$defaultSkinURL = SEO_IMAGE_PLUGIN_URL . 'skins/thumb-gallery/style.css';
	if ( $skinURL != $defaultSkinURL ) { $customSkin = true; };
	

	// check for images first. if no images... no point
	if ($galleryArray[0] != '') {

	$size = getimagesize(SEO_GALLERY_CONTENT_PATH . $cat . '/' . $galleryName . '/'.$galleryArray[0]);
	
	$GLOBALS['seo-thumb-gallery-count']++;

	$galleryCount = $GLOBALS['seo-thumb-gallery-count'];
	$ID = 'image_wrap_' . $galleryCount;

	$GLOBALS['seo-thumb-gallery-ids'][$galleryCount] = $ID;
	$GLOBALS['seo-thumb-gallery-widths'][$ID] = $size;	
	$GLOBALS['seo-thumb-gallery-skins'][$ID] = $skin;
	
	if ( $gallerySize == 'small' ) :
		$galleryWidth = '620';
	elseif ( $gallerySize == 'medium' ) :
		$galleryWidth = '880';	
	else :
		$galleryWidth = '920';	
	endif;	
	
	$skinCSS = $skin;


	// Determine size of div wrapping images (class="image-wrap-bg) ...
	
	$size2 = getimagesize(SEO_GALLERY_CONTENT_PATH . $cat . '/' . $galleryName . '/'.$galleryArray[0]);
	$width = $size2[0];
	$height = $size2[1];
	
	if ( $customSkin = true ) :
		$style='';
	elseif ( $width <= $galleryWidth ) :
		$style = 'style="height:' . $height . 'px; width:' . $galleryWidth . 'px"';
	else :
		$newHeight = round( $height * $galleryWidth / $width);
		$style = 'style="width:' . $galleryWidth . 'px; height:' . $newHeight . 'px;"';
	endif;
		
	// Start Gallery Display...
				 
	echo '<div id="' . $skinCSS . '-gallery-' . $galleryCount . '" class="' . $skinCSS . '-gallery">';
	echo '<div id="gallery_' . $galleryCount . '" class="seo-gallery-wrap gallery-wrapper-' . $gallerySize . ' section">';
	
	// BIG IMAGE VIEWER ON TOP, Thumbnails on bottom

	if ( $thumbnails == 'bottom' || $thumbnails == '') {  
		
	echo '<div class="image-wrap-bg section"' . $style . '>';
		echo '<div style="opacity: 1;" class="image_wrap" id="' . $ID . '">';

		echo '<img src="' . SEO_IMAGE_PLUGIN_URL . 'skins/images/blank.gif" />';
		echo '</div>';
	echo '</div>';
	
	};
	
	// SCROLLER SECTION
	
	echo '<div class="scrollers section">';
		echo '<a class="prevPage browse left disabled"></a>';

		echo '<div id="scroll_' . $ID . '" class="scrollable">';	
	
			echo '<div class="items">';

	$count = 0;
	
	$alt = seo_image_alt($cat, $galleryName);


	foreach ($galleryArray as $galleryImage ) {
			
		if ( $count ==  0 ) : 
			$class = 'active'; 
		elseif ( $count <= 17 ): 
			$class = '';
		endif; 
		
			//echo '<img class="' . $class . '"  alt="' . $alt . '" title="' . $alt . '" src="' . SEO_GALLERY_CONTENT_USEPATH . $cat . '/' . $galleryName . '/' . $galleryImage . '" rel="' . SEO_GALLERY_CONTENT_USEPATH . $cat . '/' . $galleryName . '/' . $galleryImage . '"/>';
			
			$image_path = SEO_GALLERY_CONTENT_URL . $cat . '/' . $galleryName . '/' . $galleryImage;
    		echo '<img src="'.WP_CONTENT_URL.'/seo-image-gallery-thumbnails/timthumb.php?src=' . $image_path . '&h=40" class="' . $class . '"  alt="' . $alt . '" title="' . $alt . '" rel="'.SEO_GALLERY_CONTENT_USEPATH . $cat . '/' . $galleryName . '/' . $galleryImage . '"/>';
			$count++; 

	}
			echo '</div>';
		echo '</div>';

		echo '<a class="nextPage browse right"></a>';
	echo '</div>';
	
	// END SCROLLER SECTION
	
	// BIG IMAGE VIEWER ON BOTTOM, Thumbnails on top
	
	if ( $thumbnails == 'top' ) {  
	
	
	echo '<div class="image-wrap-bg section"' . $style . '>';
		echo '<div style="opacity: 1;" class="image_wrap" id="' . $ID . '">';

		echo '<img src="' . SEO_IMAGE_PLUGIN_URL . 'skins/images/blank.gif" />';
		echo '</div>';
	echo '</div>';
	
	};
	
	echo '</div>';
	echo '</div>';
	

	
	} else {
		echo '<p>No Images in ths gallery yet.</p>';
		if ( current_user_can('edit_posts') ) {
			echo '<p>You can <a href="' . get_bloginfo('wpurl') . '/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=galleries-manage">edit your galleries here</a>.</p>';
		};
	};

	
};

// end display, now add js to footer and style to header...

add_action ('wp_footer', 'seo_thumb_gallery_add_footer');

function seo_thumb_gallery_add_footer () {

$IDS = $GLOBALS['seo-thumb-gallery-ids'];

if($IDS) {

foreach ( $IDS as $ID ) {

$width = $GLOBALS['seo-thumb-gallery-widths'][$ID];

if ( $width == 'medium' ) : 
	$thumbs = '11';
elseif ( $width = 'small' ) :
	$thumbs = '8';
else :
	$thumbs = '12';
endif;

?>
<script type="text/javascript">
		/* <![CDATA[ */

jQuery(document).ready(function($) {
	
	// initialize scrollable
	$("div#<?php echo 'scroll_' . $ID; ?>").scrollable({
	
		size: <?php echo $thumbs; ?>. // NUMBER OF THUMBNAILS
	
	});


	$("div#<?php echo 'scroll_' . $ID; ?> .items img").click(function() {

		// calclulate large image URL based on the thumbnail URL (flickr specific)
		var url = $(this).attr("rel");
		var alt = $(this).attr("alt");
		var title = $(this).attr("title");
	
		// get handle to element that wraps the image and make it semitransparent
		var wrap = $("#<?php echo $ID; ?>").fadeTo("medium", 0.5);

		// the large image from flickr
		var img = new Image();

		// call this function after its loaded
		img.onload = function() {

			// make wrapper fully visible
			wrap.fadeTo("fast", 1);

			// change the image
			wrap.find("img").attr("src", url);
			wrap.find("img").attr("alt", alt);
			wrap.find("img").attr("title", title);

		};

	// begin loading the image from flickr
	img.src = url;

// when page loads simulate a "click" on the first image
	}).filter(":first").click();

});


		/* ]]> */
</script>
<?php

}
}
$skins = $GLOBALS['seo-thumb-gallery-skins'];
//print_r($skins);
if($skins) {
	$skins = array_unique($skins);
	foreach ( $skins as $skin ) {
		// LOAD WIDTHS FIRST, SO IT CAN BE OVER RIDDEN IN CUSTOM SKINS...
		echo '<link id="seo-image-gallery-thumbs" rel="stylesheet" href="' . get_skins_stylesheet_url('thumb-gallery', $skin) . '" type="text/css" media="screen" />';
	}
}
};


?>