<?php
/*
Author: David Gurney
URL: htp://www.goodagency.co.uk/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

require_once( 'library/goodagency.php' );

// USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
require_once( 'library/custom-post-type.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*********************
LAUNCH goodagency
Let's get everything up and running.
*********************/

function goodagency_ahoy() {

  // launching operation cleanup
  add_action( 'init', 'goodagency_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'goodagency_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'goodagency_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'goodagency_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'goodagency_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'goodagency_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'goodagency_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  goodagency_theme_support();
  
} 

// let's get this party started
add_action( 'after_setup_theme', 'goodagency_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/


/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function goodagency_register_sidebars() {

} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function goodagency_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; 
   
} // don't remove this bracket!

/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
/*
function goodagency_fonts() {
  wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
  wp_enqueue_style( 'googleFonts');
}

add_action('wp_print_styles', 'goodagency_fonts');
*/


/* DON'T DELETE THIS CLOSING TAG */ ?>
