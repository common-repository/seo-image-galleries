

	<h3>Sizing your Images:</h3>
	<?php if ( defined('SEO_IMAGE_SIZES_MESSAGE') ) : ?>
		<?php	echo SEO_IMAGE_SIZES_MESSAGE; ?>
	<?php else : ?>	
		<p>Images will fit into the area that wraps the large size image for the gallery but the proportions are meant to fit a 1000px by 667px image - the proportions of a typical full-frame image directly out of the camera.</p>
		<p>Images that are more square than this, or vertical should fit fine.</p>
		<p>Images that are more horizontal than 1000px by 667px will need a custom skin to fit properly.</p>
		<p>If you are using the default skins that come with the plugin, the actual sizes are...</p> 
		<p>Large: 530px high. Medium: 400px high. Small: 200px high.</p>
	
	<?php endif; ?>
	<h3>Hints for Improving performance:</h3>
	<p>The best methid is to size images at least high enough to fit the largest size and they will scale down if you decide to display the gallery smaller.</p>	
	<p>Images should be no bigger than the width of your site (most likely 1000px wide at the most).</p>
	<p>Save images at 72dpi.</p>
	<p>If saving as a jpg, you can try lowering the quality to 80%, even 60% without any loss in quality.</p>
	<p>Remove any image meta data attached by image editing programs.</p>