<?php 
add_shortcode('seo_album', 'seo_album_short');

function seo_album_short($atts) {

	extract(shortcode_atts(array(
		'category' => '',
		'albumskin' => '',
		'galleryskin' => '',
		'display' => '',
		'thumbnails' => '',
		'titleposition' => '',
		'gallerytitle' => '',
		'categorytitle' => '',
		'thumbnails' => '',
		'overlaycolor' => '',
		'top'=>''
	), $atts));
	
	$category = clean_it($category);
	$gallery = clean_it($gallery);
	
	ob_start();	

	seo_album($category, $albumskin, $galleryskin, $display, $thumbnails, $titleposition, $gallerytitle, $categorytitle,$overlaycolor,$top);
	$output_string=ob_get_contents();
	ob_end_clean();

	return $output_string;
}
function seo_album($category="", $albumSkin="", $gallerySkin="", $display="", $thumbnails="", $titlePosition="", $galleryTitle=true, $categoryTitle=true,$overlaycolor="",$top="") {

	if ( $albumSkin == '' ) { $albumSkin = 'default'; }; 
	if ( $gallerySkin == '' ) { $gallerySkin = 'default'; } else { $gallerySkin = clean_it($skin); }; 
	if ( $display == '' ) { $display = 'thumb_gallery_overlay'; }; 
	if ( $thumbnails == '' ) { $thumbnails = 'bottom'; }; 
	if ( $titlePosition == '' ) { $titlePosition = 'after'; }; 

	$display = 'seo_' . $display;

	if ( $category == '' || $category == 'all' ) :
	
		
		$cats=array();
		$cats = get_seo_gallery_categories();
	
		if ( $cats !='' ) {
		foreach ($cats as $cat ) {
			
			$galleries = array();
			$galleries = get_seo_gallery_names($cat);
			
			if ($galleries[0] != '') {
				//echo '<div class="' . $albumSkin . '-album-loader album-loader">';
				//echo '<div style="display:none;padding: 138px 0px 0px;width:400px; text-align:center;margin: 0 auto; " class="safari-msg">Still Loading?... Try <a href="javascript:location.reload(true);">Refreshing the Page</a></div>';
				//echo '</div>';
				echo '<div class="' . $albumSkin . '-album album-wrapper">';
				if ( $categoryTitle == true ) {
					echo '<h2 class="album-category">' . return_nicename($cat) . '</h2>';			
				};
				
				foreach ($galleries as $galleryName ) {	
					echo '<div class="album-thumbnail">';
					$display($cat, $galleryName, $gallerySkin, $thumbnails, $titlePostion, $galleryTitle,$overlaycolor,$top);			
					echo '</div>';
				};
				echo '</div>';
			};
		};
		
		};
	
	
	else :
		$galleries = array();
		$galleries = get_seo_gallery_names($category);
		if ($galleries[0] != '') {
				//echo '<div class="' . $albumSkin . '-album-loader album-loader">';
				//echo '<div style="display:none;padding: 138px 0px 0px;width:400px; text-align:center;margin: 0 auto; " class="safari-msg">Still Loading?... Try <a href="javascript:location.reload(true);">Refreshing the Page</a></div>';
				//echo '</div>';
				echo '<div class="' . $albumSkin . '-album album-wrapper">';
				foreach ($galleries as $galleryName ) {	
					echo '<div class="album-thumbnail">';
					$display($category, $galleryName, $gallerySkin, $thumbnails, $titlePosition, $galleryTitle,$overlaycolor,$top);			
					echo '</div>';
				};
				echo '</div>';
		};
	endif; 
	
	$GLOBALS['seo_album_skin'] = $albumSkin;
	
	add_action ('wp_footer', 'seo_album_add_css',99);

}

// end display, now add js to footer and style to header...

function seo_album_add_css () {
		$skin =	$GLOBALS['seo_album_skin'];
		echo '<link id="seo-album-skin" rel="stylesheet" href="' . get_album_skin_stylesheet_url($skin) . '" type="text/css" media="screen" />';
?>
	<script type="text/javascript">
	/* <![CDATA[ */
		jQuery(document).ready(function(){
			$(".album-loader").fadeOut(400);
			$(".safari-msg").animate({opacity: 1.0}, 2000).fadeIn(200);
			$(".album-wrapper").animate({height:100px},2000);
			$(".gallery-thumbs a img").fadeIn(300);
		});
	/* ]]> */
	</script>
<?php

};
?>