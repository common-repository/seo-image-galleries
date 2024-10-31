<div class="section">
	<form name="theform" method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);?>">
		<?php wp_nonce_field( 'seo_gallery_options', 'seo_gallery_options', false, true ); ?>
		<div class="postbox">
			<h3>Change Display Name:</h3>
			<div class="pad15">
				<p>
					<input size="20" type="text" name="current_gallery" value="<?php echo return_nicename($currentGallery); ?>">
					<input type="hidden" name="gallery_fix" value="<?php echo $currentGallery; ?>" />
				</p>
				<p>NOTE: Changing this will effect any place where the galleries displayed. You will need to update the codes with the new names. See instructions for details.
				</p>
			</div>
		</div>
		<div class="postbox">
			<h3>Move to new Category:</h3>
			<div class="pad15">
				<p>
				<?php $cat_options = get_seo_gallery_categories(); ?>
					<select name="move_category">
					<?php foreach ($cat_options as $cat_option) { ?>
						<option <?php if ($cat_option == $currentCategory ) { echo 'selected="yes"'; }; ?>><?php echo return_nicename($cat_option); ?></option>
					<?php }?>
					</select>
				</p>
				<p>NOTE: Changing this will effect any place where the galleries displayed. You will need to update the codes with the new names. See instructions for details.
				</p>
			</div>
		</div>
		<div class="postbox">
			<h3>Gallery Thumbnail:</h3>
			<div class="pad15">
				<p>
					<input type="hidden" name="thumb_fix" value="<?php echo $gallery_thumbnail; ?>" />
			
				<?php if ($gallery_thumbnail != '') : ?>
					<img class="thumbnails" src="<?php echo $gallery_thumbnail . '?' . rand(1,9999); ?>" />
				<?php else : ?>
					<p class="thumbnails">No Thumbnail yet.</p>
				<?php endif; ?>
				</p>
				<p>Upload New (gif/jpeg/png):<br />
					<input type="file" name="gallery_thumbnail">
				</p>
			</div>
		</div>

		<div class="save">
			<input type="hidden" name="options-submit" value="1" />
			<p class="submit"><input class="button-primary" type="Submit" name="Submit" value="Save Options" /></p>
		</div>
	</form>
	<p>NOTE: Thumbnails are only used with certain shortcodes, for example the [seo_album] shortcode. See instructions for use.</p>
			<div class="postbox">
			<h3>Delete This Gallery</h3>
			<div class="pad15">
				<?php $delete_nonce = wp_create_nonce( 'delete_nonce'); ?>
				<a class="button-secondary delete" href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=delete&delete_type=gallery&current_delete_category=<?php echo $currentCategory; ?>&delete_name=<?php echo $currentGallery; ?>&delete_nonce=<?php echo $delete_nonce; ?>">Delete This Gallery</a>
			</div>
		</div>
</div>
	