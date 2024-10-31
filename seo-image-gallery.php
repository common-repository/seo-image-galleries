<?php
/*
Plugin Name: SEO Image Galleries
Plugin URI: http://photographyblogsites.com/wordpress-plugins/seo-image-galleries/
Description: Create and edit stylish image galleries with keyword rich ALT tags and URLs - using HTML, CSS & Javascript rather than Flash.
Version: 2.0.1 beta
Author: Marty Thornley
Author URI: http://martythornley.com
*/

/*  Copyright 2009  Marty Thornley  (email : marty@martythornley.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

// DEFINE THIS PLUGIN'S DIRECTORY
if (!defined ('SEO_IMAGE_PLUGIN_BASEDIR')) { define ('SEO_IMAGE_PLUGIN_BASEDIR', dirname(__FILE__)); };

// DEFINE THIS PLUGIN'S URL
$pluginURL = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
if (!defined ('SEO_IMAGE_PLUGIN_URL')) { define ('SEO_IMAGE_PLUGIN_URL', $pluginURL); };

 
// CREATES FOLDERS, DEFINES CONSTANST & GLOBALS, ETC. - keep #1
require_once(dirname(__FILE__).'/functions/plugin-create.php');

// DEFINES ALL FUNCTIONS USED WITHIN PLUGIN ITSELF
require_once(dirname(__FILE__).'/functions/plugin-functions.php');

// DEFINES ALL FUNCTIONS USED WITHIN PLUGIN ITSELF - need this before display functions
require_once(dirname(__FILE__).'/functions/skin-functions.php');

// DEFINES ALL FUNCTIONS USED TO ACTUALLY DISPLAY THE GALLERIES
$displayArray = get_seo_gallery_displays();
foreach ($displayArray as $display) {
	require_once (dirname(__FILE__)."/displays/$display"); 
}

// DEFINES ALL ADMIN MENUS
require_once(dirname(__FILE__).'/admin-menus.php');

?>