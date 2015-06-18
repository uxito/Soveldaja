<?php
/**
 * The template for displaying posts in the Video post format.
 *
 * @package WordPress
 * @subpackage Life Is Good
 * @since Life Is Good 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-thumbnail">
			<?php $content = trim( get_the_content() ); ?>
			<?php lifeisgood_the_featured_video( $content ); ?>
		</div>
		<?php if ( is_single() ) : ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php endif; // is_single() ?>
		<?php if ( is_single() ) : ?> <div class="entry-meta">
			<?php lifeisgood_entry_meta(); ?>

			<?php if ( comments_open() && ! is_single() ) : ?>
			<span class="comments-link">
				<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'lifeisgood' ) . '</span>', __( 'One Comment', 'lifeisgood' ), __( 'View all % comments', 'lifeisgood' ) ); ?>
			</span><!-- .comments-link -->
			<?php endif; // comments_open() ?>
			<?php edit_post_link( __( 'Edit', 'lifeisgood' ), '<span class="edit-link">', '</span>' ); ?>

			<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
				<?php get_template_part( 'author-bio' ); ?>
			<?php endif; ?>
		</div><!-- .entry-meta --><?php endif; // is_single() ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php echo lifeisgood_content_sans_video( $content ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'lifeisgood' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->


</article><!-- #post -->
