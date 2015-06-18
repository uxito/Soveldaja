<?php
/**
 * Life Is Good functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Life Is Good
 * @since Life Is Good 1.0
 */

/**
 * Sets up the content width value based on the theme's design.
 * @see lifeisgood_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) )
	$content_width = 700;



/**
 * Life Is Good only works in WordPress 3.8 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.8', '<' ) )
	require get_template_directory() . '/inc/back-compat.php';

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Life Is Good supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Life Is Good 1.0
 *
 * @return void
 */
function lifeisgood_setup() {
	/*
	 * Makes Life Is Good available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Life Is Good, use a find and
	 * replace to change 'lifeisgood' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'lifeisgood', get_template_directory() . '/languages' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'fonts/genericons.css', lifeisgood_fonts_url() ) );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Switches default core markup for search form, comment form, and comments
	// to output valid HTML5.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'audio', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'lifeisgood' ) );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1000, 500, true );
	add_image_size('lifeisgood-post-thumb-big', 1000, 500, true);

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'lifeisgood_setup' );

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Raleway by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since Life Is Good 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function lifeisgood_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$raleway = _x( 'on', 'Raleway font: on or off', 'lifeisgood' );

	if ( 'off' !== $raleway) {
		$font_families = array();

		if ( 'off' !== $raleway )
			$font_families[0] = 'Raleway:400,700,800,900';
			$font_families[1] = 'Josefin Sans:400';
			$font_families[2] = 'Yanone Kaffeesatz:400';


		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Enqueues scripts and styles for front end.
 *
 * @since Life Is Good 1.0
 *
 * @return void
 */
function lifeisgood_scripts_styles() {
	// Adds JavaScript to pages with the comment form to support sites with
	// threaded comments (when in use).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Adds Masonry to handle vertical alignment of footer widgets.
	if ( is_active_sidebar( 'sidebar-1' ) )
		wp_enqueue_script( 'jquery-masonry' );

	// Loads JavaScript file with functionality specific to Life Is Good.
	wp_enqueue_script( 'lifeisgood-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '2013-07-18', true );

	// Loads FitVids for better responsive videos.
	wp_enqueue_script('fitvids', get_template_directory_uri().'/js/jquery.fitvids.js', array('jquery'), '1.0', true);

	// Loads Flexslider for gallery slideshow.
	wp_enqueue_style('flexslider', get_template_directory_uri().'/css/flexslider.css', false, '2.0', 'all' );
	wp_enqueue_script('flexslider', get_template_directory_uri().'/js/jquery.flexslider-min.js', array('jquery'), '2.0', true);

	// Add Raleway font, used in the main stylesheet.
	wp_enqueue_style( 'lifeisgood-fonts', lifeisgood_fonts_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/fonts/genericons.css', array(), '3.03' );

	// Loads our main stylesheet.
	wp_enqueue_style( 'lifeisgood-style', get_stylesheet_uri(), array(), '2014-07-03' );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'lifeisgood-ie', get_template_directory_uri() . '/css/ie.css', array( 'lifeisgood-style' ), '2013-07-18' );
	wp_style_add_data( 'lifeisgood-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'lifeisgood_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Life Is Good 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function lifeisgood_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'lifeisgood' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'lifeisgood_wp_title', 10, 2 );

/**
 * Registers one widget area.
 *
 * @since Life Is Good 1.0
 *
 * @return void
 */
function lifeisgood_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'lifeisgood' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the footer section of the site.', 'lifeisgood' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'lifeisgood_widgets_init' );

if ( ! function_exists( 'lifeisgood_paging_nav' ) ) :
/**
 * Displays navigation to next/previous set of posts when applicable.
 *
 * @since Life Is Good 1.0
 *
 * @return void
 */
function lifeisgood_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'lifeisgood' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'lifeisgood' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'lifeisgood' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'lifeisgood_post_nav' ) ) :
/**
 * Displays navigation to next/previous post when applicable.
*
* @since Life Is Good 1.0
*
* @return void
*/
function lifeisgood_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'lifeisgood' ); ?></h1>
		<div class="nav-links">

			<div class="previous"><?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'lifeisgood' ) ); ?></div>
			<div class="next"><?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'lifeisgood' ) ); ?></div>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'lifeisgood_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own lifeisgood_entry_meta() to override in a child theme.
 *
 * @since Life Is Good 1.0
 *
 * @return void
 */
function lifeisgood_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'lifeisgood' ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		lifeisgood_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'lifeisgood' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'lifeisgood' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	 // Post author
	/* if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'lifeisgood' ), get_the_author() ) ),
			get_the_author()
		);
	} */
}
endif;

if ( ! function_exists( 'lifeisgood_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own lifeisgood_entry_date() to override in a child theme.
 *
 * @since Life Is Good 1.0
 *
 * @param boolean $echo Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function lifeisgood_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'lifeisgood' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'lifeisgood' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'lifeisgood_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 *
 * @since Life Is Good 1.0
 *
 * @return void
 */
function lifeisgood_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'lifeisgood_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Returns the URL from the post.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Life Is Good 1.0
 *
 * @return string The Link format URL.
 */
function lifeisgood_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Extends the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since Life Is Good 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function lifeisgood_body_class( $classes ) {
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';

	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';

	return $classes;
}
add_filter( 'body_class', 'lifeisgood_body_class' );

/**
 * Adjusts content_width value for video post formats and attachment templates.
 *
 * @since Life Is Good 1.0
 *
 * @return void
 */
function lifeisgood_content_width() {
	global $content_width;

	if ( is_attachment() )
		$content_width = 724;
	elseif ( has_post_format( 'audio' ) )
		$content_width = 700;
}
add_action( 'template_redirect', 'lifeisgood_content_width' );

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Life Is Good 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 */
function lifeisgood_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'lifeisgood_customize_register' );

/**
 * Add custom background for the Customizer.
 *
 * @since Life Is Good 1.0
 *
 * @return void
 */

$backargs = array(
	'default-color' => 'EBEBEB',
);
add_theme_support( 'custom-background', $backargs );

/**
 * Binds JavaScript handlers to make Customizer preview reload changes
 * asynchronously.
 *
 * @since Life Is Good 1.0
 */
function lifeisgood_customize_preview_js() {
	wp_enqueue_script( 'lifeisgood-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
}
add_action( 'customize_preview_init', 'lifeisgood_customize_preview_js' );

/**
 * Extract video from content for video post format.
 *
 * @since Life Is Good 1.0
 */
function lifeisgood_the_featured_video( $content ) {
	$tmp1 = explode( "\n", $content );
	$tmp2 = array_shift( $tmp1 );
	$url = trim( $tmp2 );
	if ( 0 === strpos( $url, 'http://' ) || preg_match ( '#^<(script|iframe|embed|object)#i', $url )) {
 		echo apply_filters( 'the_content', $url );
 	}
}

function lifeisgood_content_sans_video( $content ) {
	$tmp1 = explode( "\n", $content );
	$tmp2 = array_shift( $tmp1 );
	$url = trim( $tmp2 );
	if ( 0 === strpos( $url, 'http://' ) || preg_match ( '#^<(script|iframe|embed|object)#i', $url )) {
 		$content = trim( str_replace( $url, '', $content ) );
 	}
	return $content;
}


/**
 * Gets gallery attachments from post content
 *
 * @param int $post Post ID or object.
 * @return mixed False on failure, array with attachment objects on success
 * @since Life Is Good 1.0
 */
function lifeisgood_get_gallery_attachments( $post = null ) {

	$post = get_post( $post );
	if ( !$post )
		return false;

	$gallery_attachments = array();
	$pattern = get_shortcode_regex();
	preg_match_all( "/$pattern/s", $post->post_content , $matches, PREG_SET_ORDER );

	if ( !empty( $matches ) ) {
		foreach ( $matches as $match ) {
			if ( $match[2] == 'gallery' ) {
				// allow [[gallery]] syntax for escaping a tag
				if ( !( $match[1] == '[' && $match[6] == ']' ) ) {

					$attr = shortcode_parse_atts( $match[3] );

					if ( ! empty( $attr['ids'] ) ) {
						// 'ids' is explicitly ordered, unless you specify otherwise.
						if ( empty( $attr['orderby'] ) )
							$attr['orderby'] = 'post__in';
						$attr['include'] = $attr['ids'];
					}

					if ( isset( $attr['orderby'] ) ) {
						$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
						if ( !$attr['orderby'] )
							unset( $attr['orderby'] );
					}

					$defaults = array(
						'order'      => 'ASC',
						'orderby'    => 'menu_order ID',
						'id'         => $post->ID,
						'include'    => '',
						'exclude'    => ''
					);
					$args = wp_parse_args( $attr, $defaults );
					extract( $args );
					$id = intval( $id );
					if ( 'RAND' == $order )
						$orderby = 'none';

					if ( !empty( $include ) ) {
						$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
						$attachments = array();
						foreach ( $_attachments as $key => $val ) {
							$attachments[$val->ID] = $_attachments[$key];
						}
					} elseif ( !empty( $exclude ) ) {
						$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
					} else {
						$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
					}

					if ( !empty( $attachments ) )
						$gallery_attachments[] = $attachments;
				}
			}
		}
	}

	if ( !empty( $gallery_attachments ) )
		return $gallery_attachments;
	else
		return false;
}

/**
 * Removes standard gallery from gallery post format content.
 *
 * @since Life Is Good 1.0
 */
function lifeisgood_strip_gallery($content) {
    $format = get_post_format();

	if ( ! $format ) :
		return $content;
	elseif ( $format == 'gallery' ) :
		$pattern = get_shortcode_regex();
		preg_match('/'.$pattern.'/s', $content, $matches);
		if ( isset($matches[2]) && is_array($matches) && $matches[2] == 'gallery') {
		    //shortcode is being used
		    $content = str_replace( $matches['0'], '', $content );
		}
		return $content;
	else :
		 return $content;
	endif;
}
add_filter('the_content','lifeisgood_strip_gallery');