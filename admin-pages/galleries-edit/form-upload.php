	<p>Select one at a time, but you can upload them all at once.</p>
	<form name="image-upload" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);?>" method = "post">
		<?php wp_nonce_field( 'seo_gallery_upload', 'seo_gallery_upload', false, true ); ?>

		<input id="my_file_element" type="file" name="file_1" class="button-secondary">
		<input type="hidden" name="upload_cat" value="<?php echo $currentCategory; ?>" />
		<input type="hidden" name="upload_gallery" value="<?php echo $currentGallery; ?>" />

		<p>Files:</p>
		<div id="files_list">
		<!-- This is where the output will appear -->
		</div>
		<div class="save">
		<input type="hidden" name="upload-submit" value="1" />

		<p class="submit"><input type="submit" value="Upload All Images" class="button-primary"></p>
		</div>
	</form>

<script>
	<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
	var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 10 );
	<!-- Pass in the file element -->
	multi_selector.addElement( document.getElementById( 'my_file_element' ) );
</script>
