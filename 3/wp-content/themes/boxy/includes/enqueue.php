<?php
/**
 * Enqueue scripts and styles.
 */
function boxy_fontawesome() {
	wp_deregister_style( 'redux-elusive-icon' );
	wp_deregister_style( 'redux-elusive-icon-ie7' );
	wp_enqueue_style( 'boxy-fontawesome', BOXY_PARENT_URL . '/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'boxy_fontawesome' );
add_action( 'redux/page/boxy/enqueue', 'boxy_fontawesome' );

function boxy_scripts() {
	wp_enqueue_style( 'boxy-font-ptsans', '//fonts.googleapis.com/css?family=PT+Sans:400,700' );
	wp_enqueue_style( 'boxy-font-roboto-slab', '//fonts.googleapis.com/css?family=Roboto+Slab:400,700' );
	wp_enqueue_style( 'boxy-flexslider', BOXY_PARENT_URL . '/css/flexslider.css' );
	wp_enqueue_style( 'boxy-style', get_stylesheet_uri() );

	wp_enqueue_script( 'boxy-navigation', BOXY_PARENT_URL . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'boxy-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script( 'boxy-flexsliderjs', BOXY_PARENT_URL . '/js/jquery.flexslider-min.js', array( 'jquery' ), '2.2.2', true );
	wp_enqueue_script( 'jquery-ui-tabs', false, array( 'jquery' ) );
	wp_enqueue_script( 'boxy-custom', BOXY_PARENT_URL . '/js/custom.js', array( 'jquery' ), '1.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	global $boxy;
	if( isset( $boxy['color'] ) ) {
		switch ($boxy['color']) {
			case '2':
				wp_enqueue_style( 'boxy-red', BOXY_PARENT_URL . '/css/red.css' );
				break;
			case '3':
				wp_enqueue_style( 'boxy-blue', BOXY_PARENT_URL . '/blue.css');
				break;
			default:
				wp_enqueue_style( 'boxy-style', get_stylesheet_uri() );
				break;
		}		
	} else {
		wp_enqueue_style( 'boxy-style', get_stylesheet_uri() );
	}	
}
add_action( 'wp_enqueue_scripts', 'boxy_scripts' );

function boxy_admin_style() {
	wp_enqueue_style( 'boxy-admin', BOXY_PARENT_URL . '/css/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'boxy_admin_style' );
