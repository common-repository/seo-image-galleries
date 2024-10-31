<div class="modal" id="quickadd">
	<h3>Add New Category</h3>
	<div class="pane">
		<div class="section">
			<form name="create-form" method="post" enctype="multipart/form-data" action="<?php echo get_bloginfo('wpurl')?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=create-new&create_type=category">
		<?php wp_nonce_field( 'create_nonce', 'create_nonce', false, true ); ?>
				<p id="addNew" class="submit">New Category Name:
					<input size="20" type="text" name="create_name" value="">
					<input type="hidden" name="options-submit" value="1" />
					<input class="button-primary"type="Submit" name="Submit" value="Create" />
				</p>
			</form>
		</div>
	</div>
	<h3>Create New Gallery</h3>
	<div class="pane">
		<div class="section">
			<form name="create-form" method="post" enctype="multipart/form-data" action="<?php echo get_bloginfo('wpurl')?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=create-new&create_type=gallery">
				<p id="addNew" class="submit">New Gallery Name:
				<?php wp_nonce_field( 'create_nonce', 'create_nonce', false, true ); ?>
					<input size="20" type="text" name="create_name" value="">
				<?php $cats = get_seo_gallery_categories(); ?>
					<select name="create_current_cat">
  				<?php foreach ($cats as $cat) { ?>
						<option value="<?php echo $cat; ?>"><?php echo return_nicename($cat); ?></option>			
				<?php };?>
					</select>
					<input type="hidden" name="create_type" value="gallery" />
					<input type="hidden" name="options-submit" value="1" />
					<input class="button-primary"type="Submit" name="Submit-Gallery" value="Create" />
				</p>
			</form>
		</div>
	</div>
	<p>
		<button type="button" class="close"> Cancel </button>
	</p>
</div>