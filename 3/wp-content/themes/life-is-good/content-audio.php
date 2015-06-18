<?php
/**
 * The template for displaying posts in the Audio post format.
 *
 * @package WordPress
 * @subpackage Life Is Good
 * @since Life Is Good 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail("lifeisgood-post-thumb-big"); ?>
		</div>
		<?php endif; ?>

		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="audio-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'lifeisgood' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'lifeisgood' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		</div><!-- .audio-content -->
	</div><!-- .entry-content -->

	<?php if ( is_single() ) : ?> <footer class="entry-meta">
		<?php lifeisgood_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'lifeisgood' ), '<span class="edit-link">', '</span>' ); ?>

		<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
	</footer><!-- .entry-meta -->
	<?php endif; // is_single() ?>
</article><!-- #post -->
