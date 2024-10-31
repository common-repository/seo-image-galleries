	<h3>To Display in a post, page or widget - copy and paste one of the following shortcodes directly into the visual editor:</h3>

		<ul>
			<li>
				<p>'thumb_gallery' display & default skin:</p>
				<div class="gallery-code">
					<p>&#91;seo_thumb_gallery category="<?php echo return_nicename($currentCategory); ?>" gallery="<?php echo return_nicename($currentGallery); ?>"&#93;
					</p>
				</div>
			</li>
			<li>
				<p>'thumb_gallery' display with another skin, add the skin's name:</p>
				<div class="gallery-code">
					<p>&#91;seo_thumb_gallery category="<?php echo return_nicename($currentCategory); ?>" gallery="<?php echo return_nicename($currentGallery); ?>" skin="black"&#93;
					</p>
				</div>
			</li>
			<li>
				<p>'thumb_gallery' display using sizes - small,medium,large (defaults to large):</p>
				<div class="gallery-code">
					<p>&#91;seo_thumb_gallery category="<?php echo return_nicename($currentCategory); ?>" gallery="<?php echo return_nicename($currentGallery); ?>" skin="black" size="small"&#93;
					</p>
				</div>
			</li>
			<li>
				<p>'thumb_gallery_overlay' display & the default skin:</p>
				<div class="gallery-code">
					<p>&#91;seo_thumb_gallery_overlay category="<?php echo return_nicename($currentCategory); ?>" gallery="<?php echo return_nicename($currentGallery); ?>"&#93;
					</p>
				</div>
			</li>
			<li>
				<p>'thumb_gallery' display with another skin, add the skin's name:</p>
				<div class="gallery-code">
					<p>&#91;seo_thumb_gallery_overlay category="<?php echo return_nicename($currentCategory); ?>" gallery="<?php echo return_nicename($currentGallery); ?>" skin="black"&#93;
					</p>
				</div>
			</li>			
		</ul>
	<h3>To use in a template file, use the template tags:</h3>

		<ul>
			<li>
				<p>Using the default skin:</p>
				<div class="gallery-code">
					<p>&lt;&#63;php&#32;seo_thumb_gallery&#32;&#40;&#39;<?php echo return_nicename($currentCategory); ?>&#39;&#44;&#32;&#39;<?php echo return_nicename($currentGallery); ?>&#39;&#41;&#59;&#32;&#63;&gt;
					</p>
				</div>
			</li>
			<li>
				<p>Using a custom skin, add the skin's name:</p>
				<div class="gallery-code">
					<p>&lt;&#63;php&#32;seo_thumb_gallery&#32;&#40;&#39;<?php echo return_nicename($currentCategory); ?>&#39;&#44;&#32;&#39;<?php echo return_nicename($currentGallery); ?>&#39;&#44;&#32;&#39;black&#39;&#41;&#59;&#32;&#63;&gt;
					</p>
				</div>
			</li>
		</ul>	