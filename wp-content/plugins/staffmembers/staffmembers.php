<?php
/*
Plugin Name: Staff Members
Description: Staff Member for TheGoodAgency website
Author: David Gurney
Version: 1.0
Author URI: http://www.thegoodagency.co.uk
*/

class StaffMember {
	//var $meta_fields = array("p30-length");
	
	function StaffMember()
	{
		// Register custom post types
		register_post_type('staff_member', array(
			'labels' => array(
				'name' => __( 'Staff members' ),
				'singular_name' => __( 'Staff member' ),
				'add_new' => _x('Add New', 'staff_member'),
				'add_new_item' => __('Add New Staff member'),
				'edit_item' => __('Edit Staff member'),
				'new_item' => __('New Staff member'),
				'view_item' => __('View Staff member'),
				'search_items' => __('Search Staff members'),
				'not_found' =>  __('No Staff members found'),
				'not_found_in_trash' => __('No Staff members found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => 'Staff members'				
			),
			'public' => true,
			'label' => __('Staff members'),
			'singular_label' => __('Staff member'),
			'public' => true,
			'exclude_from_search' => true,
			'show_ui' => true, // UI in admin panel
			'_builtin' => false, // It's a custom post type, not built in
			'_edit_link' => 'post.php?post=%d',
			'capability_type' => 'post',
			'hierarchical' => false,			
			'query_var' => "staff_member",
			'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes', 'author'),
		));
		
		add_filter("manage_edit-staff_member_columns", array(&$this, "staff_member_edit_columns"));
		add_action("manage_posts_custom_column",  array(&$this, "staff_member_custom_columns"));
		add_action("admin_init", array(&$this, "staff_member_admin_init"));
		add_action("save_post", array(&$this, "save_staff_member_meta"), 10, 2);		
		if (class_exists('MultiPostThumbnails')) {
			new MultiPostThumbnails(array(
			'label' => 'Blogger thumb',
			'id' => 'blogger-thumb',
			'post_type' => 'staff_member'
			)
		);	
		}
	}
	
	function staff_member_admin_init(){
		add_meta_box("staff_member_meta", "Job Title", array(&$this, "staff_member_meta_options"), "staff_member", "normal", "high");
	}
	
	function staff_member_meta_options(){
		global $post;
		$custom = get_post_custom($post->ID);
		$job_title = $custom["job_title"][0];
		$nonce = wp_create_nonce(basename(__FILE__));
?>
	<div style="float:left;padding:5px 15px;">
		<label for="job_title">Job title </label>
		<input type="text" name="job_title" size="70" autocomplete="on" value="<?php echo $job_title; ?>" />
		<input type="hidden" name="staff_meta_box_nonce" value="<?php echo $nonce;?>" />  
	</div>	
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>	
<?php
	}
	
	function save_staff_member_meta(){
		global $post;
		// verify nonce
		
		if (!isset($_POST['staff_meta_box_nonce']) || !wp_verify_nonce($_POST['staff_meta_box_nonce'], basename(__FILE__))) {
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

		$fields = array('job_title');
		foreach ($fields as $field) {
			$old = get_post_meta($post->ID, $field, true);
			$new = $_POST[$field];
			if ($new && $new != $old) {
				update_post_meta($post->ID, $field, $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post->ID, $field, $old);
			}
		}
	}

	function staff_member_edit_columns($columns){
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Name",
			"job_title" => "Job Title",
		);
		return $columns;
	}

	function staff_member_custom_columns($column){
		global $post;
		switch ($column){
			case "job_title":
				$custom = get_post_custom();
				echo $custom["job_title"][0];
				break;	
		}
	}		
	
}

// Initiate the plugin
add_action("init", "StaffMemberInit");
function StaffMemberInit() { global $sblock; $sblock = new StaffMember(); }
