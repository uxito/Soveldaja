<?php
/**
 * Theme Functions
 *
 * Various functions to use through out site such as breadcrumb, pagination, etc
 *
 * @package BOXY
 *
 * @since 1.0
 *
 */

	// cleaning up excerpt
	add_filter( 'excerpt_more', 'boxy_excerpt_more' );

	// This removes the annoying […] to a Read More link
	function boxy_excerpt_more( $excerpt ) {
		global $post;
		// edit here if you like
		$output = sprintf( __( '<p class="readmore"><a href="%1$s" title="Read %2$s">Read more &raquo;</a></p>','boxy' ), esc_attr( get_permalink( $post->ID ) ), esc_attr( get_the_title( $post->ID ) ) );
		return $output;
	}

	function boxy_excerpt_length( $length ) {
		return 20;
	}
	add_filter( 'excerpt_length', 'boxy_excerpt_length', 999 );

	add_action( 'wp_head', 'boxy_custom_css' );

	function boxy_custom_css() {
		global $boxy;
		if( isset( $boxy['custom-css'] ) ) {
			$custom_css = '<style type="text/css">' . $boxy['custom-css'] . '</style>';
			echo $custom_css;
		}
	}