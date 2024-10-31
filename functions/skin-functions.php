<?php 

function get_skins_stylesheet_url($galleryType, $skin) {
	
	$folder = get_skins_stylesheet_folder_url($galleryType, $skin);
	$style_url = $folder . '/style.css';
	return $style_url;
};

function get_skins_folders() {

// FOLDERS TO CHECK:
	
	$skin_sizes = array();
	$skin_sizes['default'] = get_stylesheet_directory() . '/skins';

	if (file_exists(get_stylesheet_directory() . '/seo-gallery-skins')) {
		$skin_sizes['stylesheet'] =  TEMPLATEPATH . '/seo-gallery-skins';
	};

	if (file_exists(get_template_directory() . '/seo-gallery-skins')) {
		$skin_sizes['template']  =  TEMPLATEPATH . '/seo-gallery-skins';
	};

// look in Premium Skins Folder

	if (file_exists(SEO_GALLERY_SKINS_BASEPATH)) {
		$skin_sizes['premium'] =  SEO_GALLERY_SKINS_BASEPATH;		
	};
	
	foreach ($skin_sizes as $key => $value ) {
		
		if (file_exists($value)) :
			$contents = glob($value.'/*');
			$folders = array_filter($contents, 'is_dir');
			$i=0;
			foreach ($folders as $folder) {
				if ( basename($folder) != 'images') {
					$folderArray[$key][$i] = basename($folder);
					$i++;
				};		
			};
		else : 
			$folderArray[$key] = '';
		endif;
	
		if ($folderArray[$key]) { sort($folderArray[$key]); };
			
	}
	
	return $folderArray;

};

function get_skins_stylesheet_folder_url($galleryType, $skin) {

//	A way to shortcut direct to installed seo_gallery default theme
	if ( $skin == 'basic' ) :
	
		$skin_folder_url =  SEO_IMAGE_PLUGIN_URL . 'skins/' . $galleryType . '/default';

//	or shortcut direct to installed seo_gallery black theme
	elseif ( $skin == 'basicblack' ) :
	
		$skin_folder_url =  SEO_IMAGE_PLUGIN_URL . 'skins/' . $galleryType . '/black';

// look in stylesheet folder ( can ftp to child theme folder for first priority - this way skins can be distributed with themes )
	elseif (file_exists(get_stylesheet_directory() . '/seo-gallery-skins/' . $galleryType . '/' . $skin)) :
		$skin_folder_url =  get_bloginfo('stylesheet_directory') . '/seo-gallery-skins/' . $galleryType . '/' . $skin;

// look in theme template folder ( can ftp up to theme folder for second priority - this way skins can be distributed with themes )

	elseif (file_exists(get_template_directory() . '/seo-gallery-skins/' . $skin)) :
		$skin_folder_url =  get_bloginfo('template_directory') . '/seo-gallery-skins/' . $galleryType . '/' . $skin;

// look in Premium Skins Folder

	elseif (file_exists(SEO_GALLERY_SKINS_BASEPATH . $galleryType . '/' . $skin)) :
		$skin_folder_url =  SEO_GALLERY_SKINS_URL . $galleryType . '/' . $skin;

// look in plugins skins folder (Free Skins that come with plugin will be last to be used) 
	elseif (file_exists(SEO_IMAGE_PLUGIN_BASEDIR . '/skins/' . $galleryType . '/' . $skin)) :
		$skin_folder_url =  SEO_IMAGE_PLUGIN_URL . 'skins/' . $galleryType . '/' . $skin;		
	
	else : // IF NO SKINS ARE AVAILABLE, USE DEFAULT...
		$skin_folder_url =  SEO_IMAGE_PLUGIN_URL . 'skins/' . $galleryType . '/default';
	
	endif;		

return $skin_folder_url;

}

function get_album_skin_stylesheet_url($skin) {
	$skin = clean_it($skin);
	if ( $skin == '' ) { $skin = 'default'; };

// look in stylesheet folder ( can ftp to child theme folder for first priority - this way skins can be distributed with themes )
	if (file_exists(get_stylesheet_directory() . '/seo-gallery-skins/albums/' . $skin . '/style.css')) :
		$skin_url =  get_bloginfo('stylesheet_directory') . '/seo-gallery-skins/albums/' . $skin . '/style.css';

// look in theme template folder ( can ftp up to theme folder for second priority - this way skins can be distributed with themes )

	elseif (file_exists(get_template_directory() . '/seo-gallery-skins/' . $skin . '/style.css')) :
		$skin_url =  get_bloginfo('template_directory') . '/seo-gallery-skins/albums/' . $skin . '/style.css';

// look in Premium Skins Folder

	elseif (file_exists(SEO_GALLERY_SKINS_BASEPATH . 'albums/' . $skin . '/style.css')) :
		$skin_url =  SEO_GALLERY_SKINS_URL . 'albums/' . $skin . '/style.css';

// look in plugins skins folder (Free Skins that come with plugin will be last to be used) 
	elseif (file_exists(SEO_IMAGE_PLUGIN_BASEDIR . '/skins/albums/' . $skin . '/style.css')) :
		$skin_url =  SEO_IMAGE_PLUGIN_URL . 'skins/albums/' . $skin . '/style.css';		
	
	else : // IF NO SKINS ARE AVAILABLE, USE DEFAULT...
		$skin_url =  SEO_IMAGE_PLUGIN_URL . 'skins/albums/' . $skin . '/style.css';
	
	endif;		

return $skin_url;

}

function get_panels_skin_stylesheet_url($skin='',$effect='') {
	$skin = clean_it($skin);
	if ( $skin == '' ) { $skin = 'default'; };
	if ( $effect == '' ) { $effect = 'slide'; };
// look in stylesheet folder ( can ftp to child theme folder for first priority - this way skins can be distributed with themes )
	if (file_exists(get_stylesheet_directory() . '/seo-gallery-skins/panels-' . $effect . '/' . $skin . '/style.css')) :
		$skin_url =  get_bloginfo('stylesheet_directory') . '/seo-gallery-skins/panels-' . $effect . '/' . $skin . '/style.css';

// look in theme template folder ( can ftp up to theme folder for second priority - this way skins can be distributed with themes )

	elseif (file_exists(get_template_directory() . '/seo-gallery-skins/panels-' . $effect . '/' . $skin . '/style.css')) :
		$skin_url =  get_bloginfo('template_directory') . '/seo-gallery-skins/albums//panels-' . $effect . '/' . $skin . '/style.css';

// look in Premium Skins Folder

	elseif (file_exists(SEO_GALLERY_SKINS_BASEPATH . 'panels-' . $effect . '/' . $skin . '/style.css')) :
		$skin_url =  SEO_GALLERY_SKINS_URL . 'albums/panels-' . $effect . '/' . $skin . '/style.css';

// look in plugins skins folder (Free Skins that come with plugin will be last to be used) 
	elseif (file_exists(SEO_IMAGE_PLUGIN_BASEDIR . '/skins/panels-' . $effect . '/' . $skin . '/style.css')) :
		$skin_url =  SEO_IMAGE_PLUGIN_URL . 'skins/panels-' . $effect . '/' . $skin . '/style.css';		
	
	else : // IF NO SKINS ARE AVAILABLE, USE DEFAULT...
		$skin_url =  SEO_IMAGE_PLUGIN_URL . 'skins/panels-' . $effect . '/' . $skin . '/style.css';
	
	endif;		

return $skin_url;

}
?>