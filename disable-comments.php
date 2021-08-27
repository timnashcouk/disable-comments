<?php
/**
 * Plugin Name:     TN Disable Comments
 * Plugin URI:      https://timnash.co.uk/
 * Description:     Disables Comments, without any fuss
 * Author:          Tim Nash
 * Author URI:      https://timnash.co.uk
 * Version:         1.0.0
 */

   /*
	* Remove Comment Interface
	* Remove comments from admin interface
	*
	* @return null
	*/

function tn_remove_comment_interface() {
		// Prevent direct access to the comment files.
		global $pagenow;

	if ( 'edit-comments.php' === $pagenow || 'options-discussion.php' === $pagenow ) {
		wp_safe_redirect( admin_url() );
		exit;
	}

		// Remove comment metabox from dashboard.
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

		/*
		 * Filters post types to allow modifying should a post type use comments for some other purpose
		 * function tn_example_enable_orders_comments($post_types){
		 *  // make sure order comments are still enabled.
		 *  return array_diff($post_types, ['orders']);
		 * }
		 * add_filter( 'tn_disabled_comment_post_types', 'tn_example_enable_orders_comments', 1 );
		 */
		$post_types = apply_filters( 'tn_disabled_comment_post_types', get_post_types() );

		// Remove support for comments & trackback from post types.
	foreach ( $post_types as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}
add_action( 'admin_init', 'tn_remove_comment_interface' );

	/*
	* Remove Comments
	* Remove comments from front end of the site
	* @return null
	*/

function tn_remove_comments() {
	// Close comments on the front-end.
	add_filter( 'comments_open', '__return_false', 20, 2 );
	add_filter( 'pings_open', '__return_false', 20, 2 );

	// Hide existing comments.
	add_filter( 'comments_array', '__return_empty_array', 10, 2 );

	// Remove comments page and option page in menu.
	add_action(
		'admin_menu',
		function () {
			remove_menu_page( 'edit-comments.php' );
			remove_submenu_page( 'options-general.php', 'options-discussion.php' );
		}
	);

	if ( is_admin_bar_showing() ) {
		remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
	}
}
add_action( 'init', 'tn_remove_comments' );
