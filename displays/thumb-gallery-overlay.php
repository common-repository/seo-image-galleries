<?php 


/*********************************************************************
/
/	seo_gallery_overlay ($cat, $galleryName, $skin='default', $thumbnails = 'bottom', $gallerySize='large' )
/
***********************************************************************/

// 

add_shortcode('seo_thumb_gallery_overlay', 'seo_thumb_gallery_overlay_short');

function seo_thumb_gallery_overlay_short($atts) {

	extract(shortcode_atts(array(
		'category' => 'uncategorized',
		'gallery' => '',
		'skin' => 'default',
		'thumbnails' => 'bottom',
		'titleposition' => '',
		'title' => '',
		'overlaycolor' => '',
		'top'=>''
	), $atts));
	
	$category = clean_it($category);
	$gallery = clean_it($gallery);
	
	ob_start();	

	seo_thumb_gallery_overlay($category,$gallery, $skin, $thumbnails, $titlepostion, $title,$overlaycolor,$top);
	$output_string=ob_get_contents();
	ob_end_clean();

	return $output_string;
}

function seo_thumb_gallery_overlay($cat, $galleryName, $skin='default', $thumbnails = 'bottom', $titleposition="", $title="",$overlaycolor="",$top="") {

if ( !isset($GLOBALS['seo-thumb-gallery-overlay-count']) || $GLOBALS['seo-thumb-gallery-overlay-count'] == '' ) { $GLOBALS['seo-thumb-gallery-overlay-count'] = '1'; };

if ( $titlePosition == '' ) { $titlePosition = 'after'; }; 
if ( $title == '' ) { $title = true; };

$galleryCount = $GLOBALS['seo-thumb-gallery-overlay-count'];
$ID = 'galleryoverlay' . $galleryCount;

$GLOBALS['seo-thumb-gallery-overlay-ids'][$galleryCount] = $ID;
$GLOBALS['seo-thumb-gallery-overlay-color'] = $overlaycolor;
$GLOBALS['seo-thumb-gallery-overlay-top'] = $top;

$thumb = get_seo_gallery_thumbnail($cat, $galleryName);
$alt = seo_image_alt($cat, $galleryName);

$skinCSS = $skin;
	
?>

<div class="<?php echo $skinCSS; ?>-gallery-overlay-wrapper overlay-wrapper" style="display: none;">
<div class="overlay gallery-overlay" id="<?php echo $ID; ?>" style="display: none;">
	<?php seo_thumb_gallery($cat, $galleryName, $skin, $thumbnails); ?>
	<button type="button" class="close">Close</button>
	<h2 class="overlay-title"><span class="before-title"></span><?php echo return_nicename($galleryName); ?><span class="after-title"></span></h2>
</div>
<?php if ( $title == true && $titlePosition == 'before' ) { ?>
	<h2 class="before"><a class="overlay-button" rel="#<?php echo $ID; ?>"><span class="before-title"></span><?php echo return_nicename($galleryName); ?><span class="after-title"></span></a></h2>
<?php } ?>
<div class="gallery-thumbs" style="display: none;">
	<a class="overlay-button loading" rel="#<?php echo $ID; ?>">
		<?php if ($thumb != '' ) : ?>	
		<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>">
		<?php else : ?>
		You haven't added a thumbnail for this gallery yet. But you can still click here to see the gallery.
		<?php endif; ?>
	</a>
</div>
<?php if ( $title == true && $titlePosition == 'after' ) { ?>
	<h2 class="after"><a class="overlay-button" rel="#<?php echo $ID; ?>"><span class="before-title"></span><?php echo return_nicename($galleryName); ?><span class="after-title"></span></a></h2>
<?php } ?>


</div>
<?php
$GLOBALS['seo-thumb-gallery-overlay-count']++;
}


add_action ('wp_footer', 'seo_thumb_gallery_overlay_add_footer',9999);

function seo_thumb_gallery_overlay_add_footer () {
	if ( $GLOBALS['seo-thumb-gallery-overlay-color'] != '' ) :
		$overlaycolor = $GLOBALS['seo-thumb-gallery-overlay-color'];
	elseif (defined ('SEO_IMAGE_DEFAULT_COLOR')) :
		$overlaycolor = SEO_IMAGE_DEFAULT_COLOR;
	else :
		$overlaycolor = '333';
	endif;

	if ( $GLOBALS['seo-thumb-gallery-overlay-top'] != '' ) :
		 $top = $GLOBALS['seo-thumb-gallery-overlay-top'];
	else : 
		$top = "'center'";
	endif;	
	
?>
	<script type="text/javascript">
	/* <![CDATA[ */
	
		jQuery(document).ready(function(){

		$(".overlay-wrapper").fadeIn();
		$(".gallery-thumbs").fadeIn(1400);
		
		var triggers = $("a.overlay-button").overlay({ 				
			// some expose tweaks suitable for modal dialogs 
   			 expose: { 
       			color: '#<?php echo $overlaycolor; ?>', 
        		loadSpeed: 200, 
        		opacity: 0.9,
				oneInstance : false
    		},
		top : <?php echo $top; ?>,
    	closeOnClick: true
		
		});
});
	/* ]]> */
	</script>
<?php
};
?>