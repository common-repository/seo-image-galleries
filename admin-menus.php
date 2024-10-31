<?php

// Get all admin Menus. To edit specific areas, edit the file below:
require_once(dirname(__FILE__).'/admin-pages/main.php');


add_action('init', 'add_sessions');

function add_sessions() {
	if ( !headers_sent() && !session_id() ) session_start();
};

add_action('admin_menu' , 'main_galleries_add_admin');

function main_galleries_add_admin() {

	add_menu_page('SEO Image Galleries', 'SEO Image Galleries', 'delete_posts', 'main_galleries_add_admin', 'main_galleries','','4.99');


};

add_action('admin_head', 'seo_admin_add_header'); 

function seo_admin_add_header() {

	echo '<link rel="stylesheet" href="' . SEO_IMAGE_PLUGIN_URL . 'admin-pages/style/seo-style.css" type="text/css" media="screen" />';
	
};

add_action ('admin_footer', 'seo_admin_add_footer'); 

function seo_admin_add_footer() {
?>
<script type="text/javascript">
/* <![CDATA[ */

	jQuery(document).ready(function() {

		$("#seo-galleries #accordion").tabs("#seo-galleries #accordion > div.pane", { 
			tabs: 'div.editor-links', 
			effect: 'slide', 
			initialIndex: null
		});
		
		$("#seo-galleries #tabs").tabs("#seo-galleries #panels .pane", { 
			tabs: '#seo-galleries h3.tabs', 
			effect: 'fade', 
		});

		var triggers = $(".modalInput").overlay({ 
 
    		// some expose tweaks suitable for modal dialogs 
   			 expose: { 
       			color: '#333', 
        		loadSpeed: 200, 
        		opacity: 0.9 
    		}, 
 
    		closeOnClick: false
		});

	});
/* ]]> */
</script>
<?php
};	


?>