=== Plugin Name ===
Contributors: martythornley
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=11225299
Tags: photo, photos, picture, pictures, image, images, gallery, galleries, image galleries, seo, search engine optimization, jquery, jquery image galleries, plugin, google, portfolio, slideshow, media
Version: 2.0.1 beta
Tested up to: 3.0.1
Stable tag: trunk

SEO Image Galleries adds SEO enhanced image galleries using customizable ALT attributes and displays images using jQuery, HTML and CSS - no flash.

== Description ==

SEO Image Galleries provides SEO enhanced image galleries. ALT attributes and URL's can be customized to allow for keyword rich names, even without trying. The added gallery admin section allows the user to upload and organize unlimited galleries and images, customize all settings, etc.

The default version comes with two displays: a thumbnail gallery that is embedded in the page and an overlay version which pops the same thumbnail gallery out into a full screen view using an overlay.

The default version also comes with two skins. Every display will be skinable with CSS, including the option to add a skin within any theme folder.

**NEW!! Too much to list!**

Now uses timthumb.php to dynamically create thumbnails on the fly for much quicker page load time.
Improved backend with better deletion of galleries.
Improved jQuery loading, fixing conflicts with some plugins that happened before.
Images can be horizontal or vertical in the same gallery.
Galleries now sized to fit images that are proportional to 1000px wide by 667px high, full frame dimensions right out of the camera.
Lots of little fixes

**Why Beta??**

This plugin was developed for custom sites and for PhotographyBlogSites.com. The skins included within are meant as a guide but may not be perfect for every site. 
It is easy to reskin the galleries using css and that is where the strength of this plugin comes in.
Because I haven't fully tested every feature in the default, out-of-the-box version you find here, I am offering it up as-is with the beta warning.
It functions really well though and if you know a little CSS you will be fine.

**Shortcodes and Template Tags**

`[seo_album]`

Or choose just one category:

`[seo_album category="category_name"]` 

**Display single galleries**

`[seo_thumb_gallery category="category_name" gallery="gallery_name"]`

Displays the gallery called 'gallery_name' from the 'category_name' category.

`[seo_thumb_gallery_overlay category="category_name" gallery="gallery_name"]`

Displays the gallery's thumbnail as a link. The gallery will pop open in an overlay.

**Using the Template Tag in your theme**

`<?php seo_thumb_gallery('category_name', 'gallery_name'); ?>`

Displays the gallery called 'gallery_name' from the 'category_name' category.

`<?php seo_thumb_gallery('category_name', 'gallery_name'); ?>`

Displays the gallery's thumbnail as a link. The gallery will pop open in an overlay.

`<?php seo_album(); ?>`

`<?php seo_album('category'); ?>`

**Display Options**

You can also control the skin being used, the position of thumbnails and the display size.

For the albums, you can choose all those same options as well as whether to display the titles at all, whether the title should come before or after the thumbnail and more.

See official <a href="http://support.photographyblogsites.com/documentation/plugins/seo-image-galleries/">DOCUMENTATION</a> for full details.

**note** 

If you rename the galleries, the template tags and shortcodes for displaying single galleries will need to be updated in order to work. 

The 'seo_album' function will work automatically, only needing updating if you were displaying a category and rename that category.

== Installation ==

1. Automatically install through the Plugin Browser or...
1. Upload entire `seo-image-gallery` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.

== Usage ==

First, go to the settings panel and customize the folder name. By default it is 'seo-galleries'. You should rename to something that is relevant to your site's keywords. Ex: 'Los Angeles Web Designer'

= CREATING GALLERIES WITHIN THE PLUGIN: =

1. Create categories.
1. Create Galleries within the categories.
1. Add images to those galleries
1. Add shortcodes to posts or pages where you want the gallery or album to be displayed.
1. Or - add the template tags to theme files.

= FTP ACCESS =

If you have ftp access, you can simply upload folders of images into the 'seo-galleries' folder (or whatever you might have renamed it to).
The first level of folders will be categories. Inside those category folders will be gallery folders. The gallery folders contain images.

All folders should be named using only lowercase letters and dashes between full words. Example 'my-cateogy-name' and 'my-gallery-name'. These will display on the site as 'My Category Name' and 'My Gallery Name'.

= USING SKINS =

There are two default skins - 'default' (which is used by not naming any skin or by naming 'default' as the skin) or 'black'.

You can now add a skin to any theme that will over-ride the defaults without having to edit the built in ones:

1. Create a folder inside your theme folder named 'seo-gallery-skins'.
1. Inside that folder, create a second folder named after the display you want to skin. For the standard thumbnail gallery, it should be called 'thumbnail-gallery'. This is the type of player (eventually there can be lots of player types.)
1. Inside that create a folder with any name, for example 'new'.
1. Inside THAT create a file called style.css. If you need to reference any background images, just create a folder at that same level so you can keep the skin contained.
1. Add your skin to the shortcodes or template tags as described in the instructions. The plugin will add your skin's name as the prefix to that main wrapper instead of 'default'.
1. The main wrapper will become '.new-gallery' where the default is '.default-gallery'.
1. To start - you might want to copy and paste the entire default stylesheet and replace the word 'default' with your skin name. 
1. Use your new style.css to style any of the elements you want to change.
1. For now the widths are all set by 'widths.css' within the main plugin folder but those can be overridden with your skin as well.

== Frequently Asked Questions ==
<a href="http://photographyblogsites.com/wordpress-plugins/seo-image-galleries/">Documentation</a>
<a href="http://support.photographyblogsites.com/forum/seo-image-galleries/">Support Forum</a>

= Is it compatible with WordPress MU/MultiSite? =
Yes. It has been tested on single user, MU and up to 3.0.1 single and MultiSite. In fact it is primarily built for PhotographyBlogSites.com which uses 3.0.1 MultiSite.

= I had been using it with MU before, now my images are all gone. =
They are not gone, but there has been a change in the location of the folders for MU users. In the Beta version, the folders were directly in the 'blogs.dir/id/' folder. Now they have been moved to the 'blgos.dir/id/files/' folder. By simply moving the folders to the new location, you can keep using the galleries you already had.

If you are on an MU site and do not have access to the content folders, unfortunately you will have to re-upload the images.


== Changelog ==

= 2.0.1 beta =

fixed bug in default skins

= 2.0.beta =

Too many to mention...
Added timthumb support
fixed lots of bugs

= 1.2.6 =

Fixed bug in options for seo_album.

= 1.2.5 =

Yet more tweaks to make the overlay fade in nicer.
Added check for custuom skins, to allow custom skins to control height and width of galleries.

= 1.2.4 =

Small change to seo_image_alt - removed clean function that messed up apostrophes
Fixed yet another missed bug in fading in of albums. One of these days I'll get it right. :)

= 1.2.3 =

Fix for image uploads. In some situations, files with same names were having issues.
Quick fix for gallery fadein when loading. Should have been set to be invisible, then fade in.
Fixed some error catching when categories or images are not added yet - just to make thing less messy when things go wrong.

= 1.2.2 =

A couple fixes to improve custom skins.

= 1.2.1 =

Some quick fixes to the default skins. 
Nothing major.

= 1.2.0 =

Added seo_album functions
Added fade in for all galleries to hide the loading images
Removed size option from overlay display - will always use large size
Added options for whether or not to display title and whether it should befor or after gallery
Fixed bug in Quickadd overlay and other places that had troubles in installs with WordPress in subfolders

= 1.1.2 =

Cleaned up and fixed some things with the built in skins, especially the overlays.
Removed the witdh and height from images, allowing skins to better control sizes.
Made it possible for custom skins to allow vertical images that do not take up the entire width.

= 1.1.1 =

Quick bug fix for custom skins to play nice when images do not take up the whole gallery.

= 1.1.0 =

Much improved skin interface. Shouldn't change anything for older ones though.
Improved different size displays.
Should now work with vertical images as well - fitting them by height, then centering them within the gallery.

= 1.0.4 =

Fixed nonce feilds that were causing renumbering and deleting to not work.
Fixed problem where displaying same gallery multiple times caused gallery names to be confused.

= 1.0.3 =

Major fixes
Image renumbering was deleting all pics - problem solved.
Image uploads were not recognized until reloading the page because of the order od files - problem solved.
Reordered and cleaned up file structures and image renumbering functions.

= 1.0.2 =

Removed an accidental error check that printed some error messages to the screen. Sorry :)

= 1.0.1 =

bug fix - after creating new gallery a link still used an old file name

= 1.0.0 =

Official Release!!!
Added new display function seo_thumb_gallery_overlay()
Moved all displays to a folder that will automatically activate any new players added there.
Introduces the SEO Image Gallery API, for creating new custom displays and skins
Improved file nameing and structure
Moved files for MU installs in to the '/files/' folder to properly use the built in file redirects.

= 0.9.0 =

removed typo from edit galleries page
fixed some typos in markup, extra class names and related css for edit-galleries page.
Improved Tabbed interface for Edit Gallery pages, replacing the sliding panels.
Added better instructions for displaying galleries to each Gallery page.
Added ability to get the installed skins at anytime, using skin='basic' and skin='basicblack'
Both default players now scale to any size image - up to 920px wide and match height of first pic
Now has three player sizes: small (620px wide), medium (880px wide) and large (920px wide)

= 0.8.3 =

In cleanng up javascript, forgot to rename a few things effecting the sliding menus in 'manage categories' and 'manage galleries' pages.

= 0.8.2 =

Fixed another glitch in javascript, making it so in some situations, the 'quick add' link was not working correctly.
Cleaned up Javascript, consolidating a few redundancies and adding the DOM functions through the wp_footer.
Cleaned up some of the filenames and id/class names that were left from demos and examples.

= 0.8.1 =

Fixed a typo in admin-pages/main.php
'<?' Instead of '<?php' on line 74 was preventing installation in some server settings. Bug fixed.

Changed Javascript in admin section to be properly loaded using wp_enque_script()

= 0.8 =

Finally a real default thumbnail gallery skin
Plus one alternate - 'black'
use [seo_gallery category="category" gallery="gallery"]
or [seo_gallery category="category" gallery="gallery" skin="black"]

Improved instructions and cleaned up admin area.

skin-functions.php:
fixed bugs in skins functions - wasn't effecting normal use of plugin, just the way skins were found.

display-functions.php:
fixed display size of images. It was set at always 700 wide by 400 high.
Now displays based on user input or defaults to automatically use the first image's size.

Made sure skin css files were only being added to page once, instead of for each gallery.

added jquery tools js file to plugin, since file from jquery tools site was loading REALY slow.
added wp_enque_script to call jquery tools. Had been just adding it from jquery tools site and hard coding it. But now will play nice with wordpress.

= 0.7.1 =

fixed bug in gallery display.
in display-functions.php, changed line 25 

from:
`if ( $thumbnails == 'bottom' || $thumbnails == '' ) {`
 
to:
`if ( $thumbnails == 'bottom' || $thumbnails == '' ) { ` 
