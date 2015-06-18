<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package BOXY
 */

/*
 	* Breadcrumbs function based on http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
 	* Thanks Dimox
 	* Integerated with options panel, instead of hardcoded option as in original
 	*/

/**
 * Generates Breadcrumb Navigation
 */

if ( ! function_exists( 'boxy_breadcrumbs' ) ) {

	function boxy_breadcrumbs() {
		global $boxy;
		/* === OPTIONS === */
		$text['home']     = '<i class="fa fa-home"></i>'; // text for the 'Home' link
		$text['category'] = 'Archive by Category "%s"'; // text for a category page
		$text['search']   = 'Search Results for "%s" Query'; // text for a search results page
		$text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
		$text['author']   = 'Articles Posted by %s'; // text for an author page
		$text['404']      = 'Error 404'; // text for the 404 page

		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		//$delimiter   = ( isset( $boxy['breadcrumb-char'] ) && $boxy['breadcrumb-char'] != '' ) ? $boxy['breadcrumb-char'] : ' &raquo; '; // delimiter between crumbs
		if ( isset( $boxy['breadcrumb-char'] ) && $boxy['breadcrumb-char'] != '' ) {
			switch ( $boxy['breadcrumb-char'] ) {
			case '2' :
				$delimiter = ' / ';
				break;
			case '3':
				$delimiter = ' > ';
				break;
			case '1':
			default:
				$delimiter = ' &raquo; ';
				break;
			}
		}

		$before      = '<span class="current">'; // tag before the current crumb
		$after       = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post;
		$homeLink = home_url() . '/';
		$linkBefore = '<span typeof="v:Breadcrumb">';
		$linkAfter = '</span>';
		$linkAttr = ' rel="v:url" property="v:title"';
		$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

		if ( is_home() || is_front_page() ) {

			if ( $showOnHome == 1 ) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

		} else {

			echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf( $link, $homeLink, $text['home'] ) . $delimiter;

			if ( is_category() ) {
				$thisCat = get_category( get_query_var( 'cat' ), false );
				if ( $thisCat->parent != 0 ) {
					$cats = get_category_parents( $thisCat->parent, TRUE, $delimiter );
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
					$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
					echo $cats;
				}
				echo $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;

			} elseif ( is_search() ) {
				echo $before . sprintf( $text['search'], get_search_query() ) . $after;

			} elseif ( is_day() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;
				echo $before . get_the_time( 'd' ) . $after;

			} elseif ( is_month() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
				echo $before . get_the_time( 'F' ) . $after;

			} elseif ( is_year() ) {
				echo $before . get_the_time( 'Y' ) . $after;

			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug = $post_type->rewrite;
					printf( $link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name );
					if ( $showCurrent == 1 ) echo $delimiter . $before . get_the_title() . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents( $cat, TRUE, $delimiter );
					if ( $showCurrent == 0 ) $cats = preg_replace( "#^(.+)$delimiter$#", "$1", $cats );
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
					$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
					echo $cats;
					if ( $showCurrent == 1 ) echo $before . get_the_title() . $after;
				}

			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object( get_post_type() );
				echo $before . $post_type->labels->singular_name . $after;

			} elseif ( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				$cat = get_the_category( $parent->ID ); $cat = $cat[0];
				$cats = get_category_parents( $cat, TRUE, $delimiter );
				$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
				$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
				echo $cats;
				printf( $link, get_permalink( $parent ), $parent->post_title );
				if ( $showCurrent == 1 ) echo $delimiter . $before . get_the_title() . $after;

			} elseif ( is_page() && !$post->post_parent ) {
				if ( $showCurrent == 1 ) echo $before . get_the_title() . $after;

			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page = get_page( $parent_id );
					$breadcrumbs[] = sprintf( $link, get_permalink( $page->ID ), get_the_title( $page->ID ) );
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					echo $breadcrumbs[$i];
					if ( $i != count( $breadcrumbs )-1 ) echo $delimiter;
				}
				if ( $showCurrent == 1 ) echo $delimiter . $before . get_the_title() . $after;

			} elseif ( is_tag() ) {
				echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;

			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo $before . sprintf( $text['author'], $userdata->display_name ) . $after;

			} elseif ( is_404() ) {
				echo $before . $text['404'] . $after;
			}

			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
				echo __( 'Page', 'boxy' ) . ' ' . get_query_var( 'paged' );
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}

			echo '</div>';

		}
	} // end boxy_breadcrumbs()

}

if ( ! function_exists( 'boxy_posts_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @return void
	 */
	function boxy_posts_nav() {
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'boxy' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'boxy' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'boxy' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
	}
endif;

if ( ! function_exists( 'boxy_post_nav' ) ) :
	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * @return void
	 */
	function boxy_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'boxy' ); ?></h1>
		<div class="nav-links">
			<?php
		previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'boxy' ) );
		next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link',     'boxy' ) );
?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
	}
endif;

if ( ! function_exists( 'boxy_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 */
	function boxy_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'boxy' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'boxy' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<span class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) { echo get_avatar( $comment, $args['avatar_size'] ); } ?>
					<?php printf( __( '%s', 'boxy' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</span><!-- .comment-author -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'boxy' ); ?></p>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
		comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>',
				) ) );
?>

			<span class="comment-metadata">
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<time datetime="<?php comment_time( 'c' ); ?>">
						<?php printf( _x( '- %1$s at %2$s', '1: date, 2: time', 'boxy' ), get_comment_date(), get_comment_time() ); ?>
					</time>
				</a>
				<?php edit_comment_link( __( 'Edit', 'boxy' ), '<span class="edit-link">', '</span>' ); ?>
			</span><!-- .comment-metadata -->
		</article><!-- .comment-body -->

	<?php
		endif;
	}
endif; // ends check for boxy_comment()

if ( ! function_exists( 'boxy_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function boxy_posted_on() {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		printf( __( '<span class="posted-on"><i class="fa fa-clock-o"></i> %1$s</span><span class="byline"> %2$s</span>', 'boxy' ),
			sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
				esc_url( get_permalink() ),
				$time_string
			),
			sprintf( '<span class="author vcard"><i class="fa fa-user"></i> <a class="url fn n" href="%1$s">%2$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_html( get_the_author() )
			)
		);
		if ( ! post_password_required() && ( comments_open() ) ) : ?>
		<span class="comments-link"><i class="fa fa-comments"></i> <?php comments_popup_link( __( 'Leave a comment', 'boxy' ), __( '1 Comment', 'boxy' ), __( '% Comments', 'boxy' ) ); ?></span>
	<?php
		endif;
?>

	<?php edit_post_link( __( '<span class="edit-link"><i class="fa fa-edit"></i> Edit</span>', 'boxy' ), '', '' ); ?>
	<?php
		if ( ! is_single() ) {
			printf( __( '<span class="read-more-link"><i class="fa fa-link"></i> %1$s</span>', 'boxy' ),
				sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
					esc_url( get_permalink() ),
					__( 'More', 'boxy' )
				)
			);
		}
?>
	<?php
	}
endif;

if ( ! function_exists( 'boxy_post_date' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function boxy_post_date() {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		printf( __( '<span class="posted-on"><i class="fa fa-clock-o"></i> %1$s</span>', 'boxy' ),
			sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
				esc_url( get_permalink() ),
				$time_string
			)
		);
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 */
function boxy_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
				'hide_empty' => 1,
			) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so boxy_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so boxy_categorized_blog should return false.
		return false;
	}
}

// Recent Posts with featured Images to be displayed on home page
if ( ! function_exists( 'boxy_recent_posts' ) ) {
	function boxy_recent_posts() {
		$output = '';
		$output .= '<div class="flex-recent-posts">';
		$output .= '<ul class="slides">';
		// WP_Query arguments
		$args = array (
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'posts_per_page'         => get_option( 'posts_per_page' ) - ( get_option( 'posts_per_page' ) % 3 ),
			'ignore_sticky_posts'    => true,
			'order'                  => 'DESC',
		);

		// The Query
		$query = new WP_Query( $args );

		// The Loop
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$output .= '<li>';
				$output .= '<div class="recent-post">';
				$output .= '<a class="post-readmore" href="'. get_permalink() . '" title="Read '.get_the_title().'">';
				if ( has_post_thumbnail() ) {
					$output .= get_the_post_thumbnail($query->post->ID, 'rpgallery');
				}
				else {
					$output .= '<img src="' . get_stylesheet_directory_uri() . '/images/thumbnail-default.png" alt="" >';
				}
				$output .= '<h4>'. get_the_title() . '</h4>';
				$output .= '<div class="rp-thumb"></div><!-- .rp-thumb -->';
				$output .= '</a>';
				$output .= '</div>';
				$output .= '</li>';

			}
		}

		// Restore original Post Data
		wp_reset_postdata();
		$output .= '</ul>';
		$output .= '</div>';
		echo $output;
	}
}

/**
 * Flush out the transients used in boxy_categorized_blog.
 */
function boxy_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'boxy_category_transient_flusher' );
add_action( 'save_post',     'boxy_category_transient_flusher' );
