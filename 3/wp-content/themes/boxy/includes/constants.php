<?php
/* Defining directory PATH Constants */
define( 'BOXY_PARENT_DIR', get_template_directory() );
define( 'BOXY_CHILD_DIR', get_stylesheet_directory() );
define( 'BOXY_INCLUDES_DIR', BOXY_PARENT_DIR. '/includes' );

/** Defining URL Constants */
define( 'BOXY_PARENT_URL', get_template_directory_uri() );
define( 'BOXY_CHILD_URL', get_stylesheet_directory_uri() );
define( 'BOXY_INCLUDES_URL', BOXY_PARENT_URL . '/includes' );

/*
	Check for language directory setup in Child Theme
	If not present, use parent theme's languages dir
	*/
if ( ! defined( 'BOXY_LANGUAGES_URL' ) ) /** So we can predefine to child theme */
	define( 'BOXY_LANGUAGES_URL', BOXY_PARENT_URL . '/languages' );

if ( ! defined( 'BOXY_LANGUAGES_DIR' ) ) /** So we can predefine to child theme */
	define( 'BOXY_LANGUAGES_DIR', BOXY_PARENT_DIR . '/languages' );
