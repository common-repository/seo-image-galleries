<?php 

function main_galleries() {

		if(empty($_REQUEST['seo_menu_action'])){
            $currentAction = '';
        }else{
            $currentAction = $_REQUEST['seo_menu_action'];
        };

		if(empty($_REQUEST['seo_edit_type'])){
            $currentEdit = '';
        }else{
            $currentEdit = $_REQUEST['seo_edit_type'];
        };

		if(empty($_REQUEST['seo_gallery'])){
            $currentGallery = '';
        }else{
            $currentGallery = $_REQUEST['seo_gallery'];
        };

		if(empty($_REQUEST['seo_category'])){
            $currentCategory = '';
        }else{
            $currentCategory = $_REQUEST['seo_category'];
        };
		
?>

<div id="seo-galleries" class="wrap">
	<h2 class="mainTitle">SEO Image Galleries - <span><button class="modalInput button-secondary" rel="#quickadd">Quick Add</button></span></h2>
	<ul id="seo-menu">
		<li><a class="button-secondary" href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=galleries-manage">Manage Galleries</a>
		</li>
		<!--<li><a class="button-secondary" href="</?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=categories-manage">Manage Categories</a>
		</li>-->
		<li><a class="button-secondary" href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=create-new">Add Categories/Galleries</a>
		</li>
		<!--<li><a class="button-secondary" href="</?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=test-galleries.php">Test Page</a>
		</li>-->
		<li><a class="button-secondary" href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=display-instructions">Display Instructions</a>
		</li>
		<li><a class="button-secondary" href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=options-manage">SEO Image Gallery Options</a>
		</li>
		<li><a href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/index.php?page=main_galleries_add_admin&seo_menu_action=help">Help</a>
		</li>	
	</ul>
	<div class="postbox metabox-holder">

		<?php	if ( $currentAction != '' ) :
		
			include (SEO_IMAGE_PLUGIN_BASEDIR . '/admin-pages/' . $currentAction . '.php');
		else : 
			include (SEO_IMAGE_PLUGIN_BASEDIR . '/admin-pages/galleries-manage.php');
			
			?>
			
			<?php
			
			
			
		endif;
		?>
	</div>
</div>

<?php include ('quickadd.php'); ?>

<?php }; ?>