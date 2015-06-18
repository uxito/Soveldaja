<?php
/**
 * BOXY functions and definitions
 *
 * @package BOXY
 * @subpackage boxy
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 870; /* pixels */
}

if ( ! function_exists( 'boxy_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function boxy_setup() {

		// Makes theme translation ready
		load_theme_textdomain( 'boxy', BOXY_LANGUAGES_DIR );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'rpgallery', 250, 200, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
				'primary' => __( 'Primary Menu', 'boxy' ),
			) );

		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'boxy_custom_background_args', array(
					'default-color' => 'ffffff',
					'default-image' => '',
				) ) );

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

		// Add theme support for Semantic Markup
		$markup = array( 'search-form', 'comment-form', 'comment-list', );
		add_theme_support( 'html5', $markup );

		// Add theme support for title tag
		add_theme_support( 'title-tag' );
	}
endif; // boxy_setup
add_action( 'after_setup_theme', 'boxy_setup' );


/**
 * Defining constants to use through out theme code
 */
require_once get_template_directory() . '/includes/constants.php';

/**
 * Include all includes. Genius
 */
require_once BOXY_INCLUDES_DIR. '/all.php';

/* JigoShop Support */
require_once( BOXY_INCLUDES_DIR . '/jigoshop.php' );