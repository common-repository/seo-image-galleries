<?php 
add_shortcode('seo_album_panels', 'seo_album_panels_short');

function seo_album_panels_short($atts) {

	extract(shortcode_atts(array(
		'category' => '',
		'albumskin' => '',
		'galleryskin' => '',
		'display' => '',
		'thumbnails' => '',
		'titleposition' => '',
		'gallerytitle' => '',
		'categorytitle' => '',
		'effect' => 'horizontal',
		'event' => 'click',
		'overlaycolor' => '',
		'top'=>''
	), $atts));
	
	$category = clean_it($category);
	$gallery = clean_it($gallery);
	
	ob_start();	
	seo_album_panels($category, $albumskin, $galleryskin, $display, $thumbnails, $titleposition, $gallerytitle, $categorytitle, $effect,$event,$overlaycolor,$top);
	$output_string=ob_get_contents();
	ob_end_clean();

	return $output_string;
}
function seo_album_panels($category="", $albumSkin="", $gallerySkin="", $display="", $thumbnails="", $titlePosition="", $galleryTitle=true, $categoryTitle=true, $effect="slide",$event="mouseover",$overlaycolor="",$top="") {

	if ( $albumSkin == '' ) { $albumSkin = 'default'; }; 
	if ( $gallerySkin == '' ) { $gallerySkin = 'default'; } else { $gallerySkin = clean_it($skin); }; 
	if ( $display == '' ) { $display = 'thumb_gallery_overlay'; }; 
	if ( $thumbnails == '' ) { $thumbnails = 'bottom'; }; 
	if ( $titlePosition == '' ) { $titlePosition = 'after'; };

	$display = 'seo_' . $display;
	
	echo '
		<div class="' . $albumSkin .'-panels">
	';

	if ( $category == '' || $category == 'all' ) :
	
		
		$cats=array();
		$cats = get_seo_gallery_categories();
	
		if ( $cats !='' ) {
		foreach ($cats as $cat ) {
			
			$galleries = array();
			$galleries = get_seo_gallery_names($cat);
			
			if ($galleries[0] != '') {
				echo '<div class="' . $albumSkin . '-panels-album-loader album-loader"></div>';
				echo '<div class="' . $albumSkin . '-album-panels album-wrapper"  style="display: none;">';
				
				if ( $categoryTitle == true ) {
					echo '<h2 class="album-category">' . return_nicename($cat) . '</h2>';			
				};
				
				$count = 1;
				
				foreach ($galleries as $galleryName ) {	
					
					if ($count == 1) :
						$class = 'panel-active';
					else :
						$class = 'panel-off';
					endif;
					
					$thumb = get_seo_gallery_thumbnail($cat, $galleryName);

					
					echo '<div class="album-thumbnail ' . $class . '">';
					$display($cat, $galleryName, $gallerySkin, $thumbnails, $titlePostion, $galleryTitle,$overlaycolor,$top);			
					echo '</div>';
					$count ++;
				};
				echo '</div>';
				echo '<div style="display:none;" id="width-large"></div>';
				echo '<div style="display:none;" id="width-small"></div>';
			};
		};
		
		};
	
	
	else :
		$galleries = array();
		$galleries = get_seo_gallery_names($category);
		if ($galleries[0] != '') {

			foreach ($galleries as $galleryName ) {	
				echo '<div class="' . $albumSkin . '-panels-album-loader album-loader"></div>';
				echo '<div class="' . $albumSkin . '-panels-album album-wrapper">';
			};

			foreach ($galleries as $galleryName ) {	
				echo '<div class="album-thumbnail panel-off">';
				$display($category, $galleryName, $gallerySkin, $thumbnails, $titlePosition, $galleryTitle,$overlaycolor,$top);			
				echo '</div>';
			};
			foreach ($galleries as $galleryName ) {	
				echo '</div>';
			};
			echo '<div style="display:none;" id="width-large"></div>';
			echo '<div style="display:none;" id="width-small"></div>';
		};

	endif; 
	
	echo '</div>';
	
	$GLOBALS['seo_album_panel_skin'] = $albumSkin;
	$GLOBALS['seo_album_panel_effect'] = $effect;
	$GLOBALS['seo_album_panel_event'] = $event;
	add_action ('wp_footer', 'seo_album_panels_add_css',99);

}

// end display, now add js to footer and style to header...

function seo_album_panels_add_css () {
		$skin =	$GLOBALS['seo_album_panel_skin'];
		$effect = $GLOBALS['seo_album_panel_effect'];
		$event = $GLOBALS['seo_album_panel_event'];

		echo '<link id="seo-album-skin" rel="stylesheet" href="' . get_panels_skin_stylesheet_url($skin) . '" type="text/css" media="screen" />';
?>
	<script type="text/javascript">
	/* <![CDATA[ */
		
		jQuery(document).ready(function(){
			$(".gallery-thumbs a img").hide();
			$(".album-loader").fadeOut(400);
			$(".album-loader").css('display','none');
			$(".album-wrapper").fadeIn(1200);


			$(".album-thumbnail").mouseover(function(){
				
				if ( $(this).hasClass(".panel-off") ){
				var wide;
				var narrow;
				
				wide = $(this).parent().parent().children("#width-large").width();
				narrow = $(this).parent().parent().children("#width-small").width();
								
				$(this).stop().animate({width:wide});
				$(this).parent().children(".panel-active").stop().animate({width:narrow});
								
				$(this).removeClass("panel-off");
				$(this).addClass("panel-active");
				$(this).siblings().removeClass("panel-active");
				$(this).siblings().addClass("panel-off");
				} else {}
			});
			
			$(".panel-active").mouseout(function(){
				
				var wide;
				var narrow;
				
				wide = $(this).parent().parent().children("#width-large").width();
				narrow = $(this).parent().parent().children("#width-small").width();
								
				$(this).stop().animate({width:wide});

			});
			
			$(".gallery-thumbs a img").fadeIn();			
		});

	/* ]]> */
	</script>
<?php

};
?>