<?php 

if ($_POST['upload-submit']){
	
	if ( !wp_verify_nonce( $_POST[ 'seo_gallery_upload' ], 'seo_gallery_upload' ) ) : ?>
<div class="updated">
	<p>There was a problem. Please try again.</p>
</div>
	<?php else :
	
	if (isset ( $_POST['upload_gallery'] ) ) {
		$upload_gallery = clean_it($_POST['upload_gallery']) ;
	};
	
	if (isset ( $_POST['upload_cat'] ) ) {
		$upload_cat = clean_it($_POST['upload_cat']) ;		
	};
	
	renumber_gallery($upload_cat, $upload_gallery);
	
	$imageArray = get_seo_gallery_images($upload_cat, $upload_gallery);
	
	if ($imageArray) :
		$highest = get_image_order(end($imageArray));
	else : 
		$highest = format_number(0);
	endif;
	$newNumbers = format_number($highest + 1);
	
foreach ($_FILES as $file) {

if (isset ($file) && $file['name'] != '') { 
		
		$file_name = $file['name'];
		$temp_file = $file['tmp_name'];
		$file_type = $file['type'];

		if($file_type=="image/gif" || $file_type=="image/jpeg" || $file_type=="image/pjpeg" || $file_type=="image/png") :
			$length=filesize($temp_file);
			$fd = fopen($temp_file,'rb');
			$file_content=fread($fd, $length);
			fclose($fd);

			$wud = wp_upload_dir();

			$ext = get_imageext($file_name);
			
			$newName = $newNumbers . '_' . clean_it($upload_gallery);
			
			if (file_exists($wud[path].'/'.$newName)){
				$newNameFix = $newName . rand(1,9999) . '.' . $ext;
				$upload = wp_upload_bits( $newNameFix, '', $file_content);
				$upload = $wud[path].'/'.$newNameFix;
			}
			else
			{
				$newNameFix =  $newName . '.' . $ext;
				$upload = wp_upload_bits( $newNameFix, '', $file_content);
				$upload = $wud[path].'/'.$newNameFix;
			}
			
			rename ($upload, SEO_GALLERY_CONTENT_PATH . $upload_cat . '/' . $upload_gallery . '/' . $newNameFix);
			// $errorImage .= $newNameFix . 'was uploaded succesfully.';
		else :  
			$errorImage .= 'Error in Image Upload'; 
		endif;
		
};
$newNumbers++;
};
	endif; // end wp_nonce check
}; // end if uplaod-submit

if ($errorImage) { ?>
	<div class="updated">
		<?php echo $errorImage; ?>
	</div>
<?
};

?>