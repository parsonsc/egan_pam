<?php
/*
Plugin Name: News
Description: News
Author: Chris Parsons
Version: 1.0
Author URI: 
*/

class Worksa {
	//var $meta_fields = array("p30-length");
	
	function Worksa()
	{
        $labels = array(
            'name'                       => _x( 'Disciplines', 'taxonomy general name' ),
            'singular_name'              => _x( 'Discipline', 'taxonomy singular name' ),
            'search_items'               => __( 'Search Disciplines' ),
            'popular_items'              => __( 'Popular Disciplines' ),
            'all_items'                  => __( 'All Disciplines' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Discipline' ),
            'update_item'                => __( 'Update Discipline' ),
            'add_new_item'               => __( 'Add New Discipline' ),
            'new_item_name'              => __( 'New Discipline Name' ),
            'separate_items_with_commas' => __( 'Separate disciplines with commas' ),
            'add_or_remove_items'        => __( 'Add or remove disciplines' ),
            'choose_from_most_used'      => __( 'Choose from the most used disciplines' ),
            'not_found'                  => __( 'No disciplines found.' ),
            'menu_name'                  => __( 'Disciplines' ),
        );        
        $args = array(
            'hierarchical'          => true,
            'labels'                => $labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite' 				=> array('slug' => 'good-work-about', 'with_front' => false)
        );

        register_taxonomy( 'worksac', array( 'brand', 'digital','social','fundraising','comms' ), $args );
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
		register_post_type('worksa', array(
			'labels' => array(
				'name' => __( 'Work' ),
				'singular_name' => __( 'Work' ),
				'add_new' => _x('Add New', 'worksa'),
				'add_new_item' => __('Add New worksa'),
				'edit_item' => __('Edit Work'),
				'new_item' => __('New Work'),
				'view_item' => __('View Work'),
				'search_items' => __('Search Work'),
				'not_found' =>  __('No Work found'),
				'not_found_in_trash' => __('No Work found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => 'News'				
			),
			'public' => false,
			'label' => __('Work'),
			'singular_label' => __('Work'),
			'public' => true,
			'exclude_from_search' => true,
			'show_ui' => true, // UI in admin panel
			'_builtin' => false, // It's a custom post type, not built in
			'_edit_link' => 'post.php?post=%d',
			'capability_type' => 'post',
			'hierarchical' => false,		
			'query_var' => "works",
            'rewrite' => array('slug' => 'News'),
            'taxonomies' => array('worksac'),
            'has_archive' => false,
            'show_in_nav_menus' => false,
			'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes'),
		));
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
        
		add_action( 'load-post.php', array(&$this, 'work_custom_meta') );
        add_action( 'load-post-new.php', array(&$this, 'work_custom_meta') );
		add_action("save_post", array(&$this, "save_work_meta"), 10, 2);	
        add_action( 'admin_enqueue_scripts', array(&$this, 'work_image_enqueue') );        
		//add_action('add_meta_boxes', 'client_custom_meta' );
		
	}
	
    
    function work_image_enqueue($hook) {
        if ( 'post-new.php' != $hook && 'edit.php' != $hook && 'post.php' != $hook ) {
            return;
        }
        wp_enqueue_media();
 
        // Registers and enqueues the required javascript.
        wp_register_script( 'client-box-image', plugin_dir_url( __FILE__ ) . 'work-image.js', array( 'jquery' ), null, true );
        wp_localize_script( 'client-box-image', 'client_image',
            array(
                'title' => __( 'Choose or Upload an Image', 'work' ),
                'button' => __( 'Use this image', 'work' ),
            )
        );
        wp_enqueue_script( 'client-box-image' );
    }    
    
	function work_custom_meta() {
    	add_meta_box( 'work_meta', 'Work promo', array(&$this, "work_meta_callback"), "worksa", "normal", "high");

	}
		
	function work_meta_callback($post){
		global $post;
		$custom = get_post_custom($post->ID);
		$clienttitle = isset($custom["clienttitle"][0])? $custom["clienttitle"][0] : '' ;
        $clientdesc = isset($custom["clientdesc"][0])? $custom["clientdesc"][0] : '' ;
        $clientimage = isset($custom["clientimage"][0])? $custom["clientimage"][0] : '' ;
        $fullwidth = isset($custom["fullwidth"][0])? $custom["fullwidth"][0] : 0 ;
		$nonce = wp_create_nonce(basename(__FILE__));
?>
	<div style="padding:5px 15px;">
		<label for="job_title">Short title </label>
		<input type="text" name="clienttitle" size="70" autocomplete="on" value="<?php echo $clienttitle; ?>" />
	</div>	
	<div style="padding:5px 15px;">
		<label for="job_title">Short Description </label>
		<input type="text" name="clientdesc" size="70" autocomplete="on" value="<?php echo $clientdesc; ?>" />
	</div>
	<div style="padding:5px 15px;">
        <label for="clientimage" class="prfx-row-title"><?php _e( 'Front image', 'work' )?></label>
        <input type="text" name="clientimage" id="clientimage" value="<?php echo $clientimage; ?>" />
        <input type="button" id="clientimage_button" class="button" value="<?php _e( 'Choose or Upload an Image', 'work' )?>" />
    </div>
	<div style="padding:5px 15px;">
		<label for="fullwidth">Full width</label>
		<input type="checkbox" name="fullwidth"  value="1" <?php echo ((int)$fullwidth == 1) ? 'checked="checked"' : ''; ?>" />
	</div>	
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<input type="hidden" name="work_meta_box_nonce" value="<?php echo $nonce;?>" />  
	<p>&nbsp;</p>	
<?php
	}


	
	function save_work_meta(){
		global $post;
		// verify nonce
		
		if (!isset($_POST['work_meta_box_nonce']) || !wp_verify_nonce($_POST['work_meta_box_nonce'], basename(__FILE__))) {
			return $post->ID;
		}
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post->ID;
		}
		// check permissions
		
		if (!current_user_can('edit_post', $post->ID)) {
			return $post->ID;
		}
      
		$fields = array('clienttitle', 'clientdesc', 'clientimage', 'fullwidth');
		foreach ($fields as $field) {
			$old = get_post_meta($post->ID, $field, true);
			$new = $_POST[$field];
            if ($field == 'fullwidth'){
                if (!isset( $_POST['fullwidth'])) $new = 0;
                //echo $new.'|'.$old.'xx';
                //if ((int)$new != -1) echo 'bb';
                //if (isset($old) && empty($old)) echo 'dd';
            }
			if (((int)$new != -1 && $new != $old) || isset($old) && empty($old)) {
                //echo 'a';
				update_post_meta($post->ID, $field, $new);
			} elseif ('' == $new && $old) {
                //echo 'b';
				delete_post_meta($post->ID, $field, $old);
			}
		}
        //exit;
	}
}

// Initiate the plugin
add_action("init", "WorkInit");
function WorkInit() { global $clblock; $clblock = new Worksa(); }
