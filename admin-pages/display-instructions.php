<h3>Display Mulitple Galleries Using Albums</h3>
<div class="pane">
	<p>You can easily list all galleries, sorted alphabetically by category by using the [seo_album] shortcode.</p>
	<p>Each one will display using the gallery's thumbnail as a link. The gallery will appear, using the overlay display.</p>
	<p>Or list all the galleries in a single category with [seo_album category="categoryname"].</p>
	<p>The albums can take lots of options, a skin name, thumbnail placement, whether to display a title, whether to put the title before or after the thumbnails.</p>
	<p>A full explanation can be found <a href="http://support.photographyblogsites.com/documentation/plugins/seo-image-galleries/using-albums/" target="_blank">here</a>.</p>
</div>
<h3>Displaying Single Galleries</h3>
<div class="pane">
	<p>To display a single gallery, you need the category name and the gallery name. To add a gallery to any post, page or widget - copy and paste the shortcodes directly into the visual editor as you edit the post.</p> 
	<p>To use in a template - use the Template Tag</p>
	<p>Example use of the standard shortcode: [seo_thumb_gallery category="CategoryName" gallery="GalleryName"]
	</p>
	<p>Example use of the standard template tag: seo_thumb_gallery('CategoryName', 'GalleryName'); </p>
	<p>The shortcode for each gallery is displayed on the <a href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=galleries-manage">Manage Galleries</a> page.</p>
</div>
<h3>Available Displays</h3>
<div class="pane">
	<ul id="display-header" class="display-list">
		<li class="display-name">Display Name</li>
		<li class="display-shortcode">Shortcode</li>
		<li class="display-template">Template Tag</li>
	</ul>
<?php
	
$displayArray = get_seo_gallery_displays();
if ($displayArray) sort ($displayArray, SORT_NUMERIC);
foreach ($displayArray as $display) {
	echo '<ul class="display-list">';
	echo '<li class="display-name">' . seo_display_nicename($display) . '</li>'; 
	echo '<li class="display-shortcode">[' . seo_display_function_name($display). '] </li>';
	echo '<li class="display-template">' . seo_display_function_name($display). '(); </li>';  
	echo '</ul>';
}
?>
</div>
<h3>Available Skins</h3>
<div class="pane">
	<p>The plugin comes with two skins - 'default' and 'black'.</p> 
	<p>If none is mentioned, the default is used which has a white background.</p>
	<p>You can add 'skin="black"' to the shortcode to get a black background.</p>
	<p>You can also create custom skins, even a custom default that will override the built in default (so you can be lazy and not have to enter a skin name).</p>
	<p>Detailed instructions on custom skins can be found <a href="http://support.photographyblogsites.com/documentation/plugins/seo-image-galleries/creating-custom-skins/" target="_blank">here</a>.</p>
	<p>You can also create custom skins for your albums. <a href="http://support.photographyblogsites.com/documentation/plugins/seo-image-galleries/custom-skins-for-albums/" target="_blank">Details here</a>.</p>
</div>

<h3>Advanced Usage</h3>
<div class="pane">
	<p>Every type of display will let you add some additional options such as size and whether the thumbnails should be on top of or below the image being displayed.</p>
	<p>You can also select any of the available skins, which give the gallery a different look.</p>
	<p>EXAMPLE [seo_thumb_gallery category'CategoryName' gallery="GalleryName" size="small" thumbnails="top" skin="black"]</p>
	<p>Detailed instructions including all the options for each display can be found <a href="http://support.photographyblogsites.com/documentation/plugins/seo-image-galleries/adding-galleries-to-your-site/" target="_blank">here</a>.</p>
	<p>The exact code for each gallery can be found under the 'Display Options' tab as you edit each gallery</p>
</div>
<h3>Available Options</h3>
<div class="pane">
	<p>SIZE:</p>
	<ol>
		<li>'small' (displays a gallery 620px wide)</li>
		<li>'medium' (displays a gallery 880px wide)</li>
		<li>'large' (displays a gallery 960px wide)</li>
	</ol>
	<p>THUMBNAILS:</p>
	<ol>
		<li>not using this option will place the thumbnails on the bottom</li>
		<li>'top' (places the thumbnails on top of the image being viewed)</li>
		<li>'bottom' (places the thumbnails below the image being viewed)</li>
	</ol>	
	<p>SKIN:</p>
	<ol>
		<li>not adding a skin name will make the player use the default skin</li>
		<li>'default' (uses the default skin)</li>
		<li>'black' (uses the black skin)</li>
		<li>'my_custom_skin' you can create custom skins</li>
		<li>'basic' (uses the default skin that ships with the plugin, overriding any custom skins named black)</li>
		<li>'basicblack' (uses the black skin that ships with the plugin, overriding any custom skins named default)</li>
	</ol>	
</div>
