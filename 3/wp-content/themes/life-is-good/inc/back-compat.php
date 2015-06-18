<?php
/**
 * Life Is Good back compat functionality.
 *
 * Prevents Life Is Good from running on WordPress versions prior to 3.8,
 * since this theme is not meant to be backwards compatible.
 *
 * @package WordPress
 * @subpackage Life Is Good
 * @since Life Is Good 1.0
 */

/**
 * Prevent switching to Life Is Good on old versions of WordPress. Switches
 * to the default theme.
 *
 * @since Life Is Good 1.0
 *
 * @return void
 */
function lifeisgood_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'lifeisgood_upgrade_notice' );
}
add_action( 'after_switch_theme', 'lifeisgood_switch_theme' );

/**
 * Prints an update nag after an unsuccessful attempt to switch to
 * Life Is Good on WordPress versions prior to 3.8.
 *
 * @since Life Is Good 1.0
 *
 * @return void
 */
function lifeisgood_upgrade_notice() {
	$message = sprintf( __( 'Life Is Good requires at least WordPress version 3.8. You are running version %s. Please upgrade and try again.', 'lifeisgood' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 3.8.
 *
 * @since Life Is Good 1.0
 *
 * @return void
 */
function lifeisgood_customize() {
	wp_die( sprintf( __( 'Life Is Good requires at least WordPress version 3.8. You are running version %s. Please upgrade and try again.', 'lifeisgood' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'lifeisgood_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 3.8.
 *
 * @since Life Is Good 1.0
 *
 * @return void
 */
function lifeisgood_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Life Is Good requires at least WordPress version 3.8. You are running version %s. Please upgrade and try again.', 'lifeisgood' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'lifeisgood_preview' );