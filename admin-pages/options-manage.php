<?php

$shortname = SIG_SHORTNAME; // sig - seo image galleries
	
	// Custom Uplaod Directory
	$current_upload = get_option($shortname.'custom_upload');
	
	if ($current_upload == '' && file_exists (SEO_GALLERY_CONTENT_BASEPATH . '/seo-galleries')) {
		$current_upload = 'seo-galleries';
		update_option($shortname.'custom_upload', $current_upload);
	}
	
	$custom_upload = get_option($shortname.'custom_upload');
	
	// Alt Tag Options
	$alt_options = get_option($shortname.'alt_options');
	$custom_alt = get_option($shortname.'custom_alt');
	
	// set to Use All by default, in case they don't choose anything.
	if ($alt_options == '') { update_option($shortname.'alt_options', 'use-all-but-site'); };

	if ($_POST['options-submit']){
	
	if ( !wp_verify_nonce( $_POST[ 'theme_admin' ], plugin_basename(__FILE__) ) ) : 
?>

<div class="updated">
	<p>There was a problem. Please try again.</p>
</div>

<?php 
	else :
	
		if (isset ($_POST['bulk_rename']) && $_POST['bulk_rename'] == 'yes') { 
			rename_all_galleries();
		}

	
		if (isset ($_POST['alt_options'])) { 
			$alt_options = htmlspecialchars($_POST['alt_options']);
			update_option($shortname.'alt_options', $alt_options);
		}	
		
		if (isset ($_POST['custom_alt'])) { 
			$custom_alt = htmlspecialchars($_POST['custom_alt']);
			update_option($shortname.'custom_alt', $custom_alt);
		}
		
		if (isset ($_POST['custom_upload'])) { 
			$current_upload = get_option($shortname.'custom_upload');
			// update_option($shortname.'custom_upload', $upload_holder);

			$custom_upload = htmlspecialchars($_POST['custom_upload']);
			$custom_upload = clean_it($custom_upload);
			update_option($shortname.'custom_upload', $custom_upload);

		
			$oldDIR = SEO_GALLERY_CONTENT_BASEPATH . '/' . $current_upload . '/';
			$newDIR = SEO_GALLERY_CONTENT_BASEPATH . '/' . $custom_upload . '/';
		
			rename($oldDIR, $newDIR);
		
			if ( SEO_GALLERY_CONTENT_PATH != $newDIR ) { define( 'SEO_GALLERY_CONTENT_PATH', $newDIR ); };

		}	
		
		$alt_options = get_option($shortname.'alt_options');
		$custom_alt = get_option($shortname.'custom_alt');
		$custom_upload = get_option($shortname.'custom_upload');
?>

<div class="updated"><p>Your new options have been successfully saved.</p></div>

<?php 
	endif; 
} 

	$message = 'The default alt and title tags for your image will be the site name, followed by the category, follwed by the gallery name, ending with the post or page title.<br / > ( alt="My Site - Category Name - Gallery Name - Post Title" ) ';
	
	if (isset($alt_options) && $alt_options !='') : 
	
	$message = 'The default alt and title tags for your image will be ';
	
	if ($alt_options == 'site-name') :		
		$message = $message . 'the site name as entered under Settings->General<br />( alt="My Site" )';
	elseif ($alt_options == 'post-titles') : 
		$message = $message . 'the title of the post or page the gallery is displayed in.<br />( alt="Post Title" ) ';
	elseif ($alt_options == 'gallery-names') : 
		$message = $message . 'the category followed by the gallery<br />( alt="Category Name - Gallery Name" )';
	elseif ($alt_options == 'use-custom') : 
		$message = $message . 'the custom phrase entered below.<br />( alt="Custom Phrase" )';
	elseif ($alt_options == 'use-all') : 
		$message = $message . 'the site name, followed by the category, follwed by the gallery name, ending with the post or page title. <br / > ( alt="My Site - Category Name - Gallery Name - Post Title" ) ';
	endif; 
	
	else : $message = 'the site name, followed by the category, follwed by the gallery name, ending with the post or page title. <br / > ( alt="My Site - Category Name - Gallery Name - Post Title" ) ';
	
	endif;
	
	
	if ($custom_upload != '') : 
		$current_folder = $custom_upload;
	else :
		$current_folder = 'seo-galleries';
	endif;	
?>
<div class="wrap">
	<h2>SEO Image Gallery Options</h2>
	<form name="theform" method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);?>">
		<?php wp_nonce_field( plugin_basename( __FILE__ ), 'theme_admin', false, true ); ?>
		<div id="major-publishing-actions">
			<p class="submit"><input class="button-primary"type="submit" name="submit" value="Save Options" /></p>
		</div>
		<h3>Name Your Upload Folder</h3>
		<table class="form-table">
			<tr>
				<td width="200">The upload folder will appear in the URL of the images themselves. If you don't choose a name, the folder will be called 'seo-galleries'.<br />By changing this to a keyword relevant to your site, it will help improve the SEO of your images.
				</td>
				<td>You current upload folder name is:<br />
					<input size="80" type="text" name="custom_upload" value="<?php echo return_nicename($current_folder); ?>">
					<p>Enter full words or words separated by '-' symbols.</p>
					<p>All text will automatically be formatted into lowercase words separated by '-'.</p>
				</td>
			</tr>
		</table>
		<h3>Alt and Title Tags for images</h3>
		<p><?php echo $message; ?></p>
		<table class="form-table">
			<tr>
				<td width="200">Define the alt and title tags with these options:</td>
				<td>
				<?php $alt_options = get_option($shortname.'alt_options'); ?>

					<p>
						<input type="radio" name="alt_options" value="use-all-but-site" <?php if ($alt_options == "use-all-but-site") { echo 'checked'; }; ?>/>RECOMMENDED: Use the category, gallery, then post title ( alt="Category Name - Gallery Name - Post Title" )<br />
						<input type="radio" name="alt_options" value="use-all" <?php if ($alt_options == "use-all") { echo 'checked'; }; ?>/>Use all ( alt="Category Name - Gallery Name - Post Title - Site Name" )<br />
						<input type="radio" name="alt_options" value="site-name" <?php if ($alt_options == "site-name") { echo 'checked'; }; ?>/>Use only the Site's Name ( alt="Site Name" )<br />
						<input type="radio" name="alt_options" value="post-titles" <?php if ($alt_options == "post-titles") { echo 'checked'; }; ?>/>Use only the post or page titles ( alt="Post Title" )<br />
						<input type="radio" name="alt_options" value="gallery-names" <?php if ($alt_options == "gallery-names") { echo 'checked'; }; ?>/>Use only the category and gallery names ( alt="Category Name - Gallery Name" )<br />
						<input type="radio" name="alt_options" value="use-custom" <?php if ($alt_options == "use-custom") { echo 'checked'; }; ?>/>Use the custom phrase entered below ( alt="Custom Phrase" )<br />
					</p>
				</td>
			</tr>
			<tr>
				<td  width="200">Your Custom Alt and Title tag phrase:</td>
				<td>Enter a phrase to use for every image in the galleries:<br />
					<input size="80" type="text" name="custom_alt" value="<?php echo $custom_alt; ?>">
				</td>
			</tr>
		</table>
		<h3>Bulk Rename All Images</h3>
		<p><?php echo $renameMessage; ?></p>
		<table class="form-table">
			<tr>
				<td colspan="2">
					<p>Checking this option will rename every image in every gallery.</p>
					<p>They will retain the order you have them in and the proper extension (.jpg, .gif, .png) <br /> 
					and give them a 3-digit number followed by the gallery name.</p>
					<p>EX: 001_galleryName.jpg, 002_galleryName.jpg, etc.</p>
				</td>
			</tr>
			<tr>
				<td width="200">
				</td>
				<td>
					<p>
						<input type="checkbox" name="bulk_rename" value="yes" />Yes, rename all images.
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p><span style="color:red">WARNING - While this is recommended, this CAN NOT BE UNDONE!!!!</span></p>
					<p>You will not lose any images, but they will no longer have the names you used when they were uploaded.
					</p>
				</td>
			</tr>
		</table>
		<input type="hidden" name="options-submit" value="1" />
		<div id="major-publishing-actions">
			<p class="submit"><input class="button-primary"type="submit" name="submit" value="Save Options" /></p>
		</div>
	</form>
</div>