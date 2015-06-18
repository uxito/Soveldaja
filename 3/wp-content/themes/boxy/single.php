<?php
/**
 * The Template for displaying all single posts.
 *
 * @package BOXY
 */

get_header(); ?>

	<div class="sixteen columns">
		<div class="breadcrumb">
			<?php if ( $boxy['breadcrumb'] && function_exists( 'boxy_breadcrumbs' ) ) : ?>
				<div id="breadcrumb" role="navigation">
					<?php boxy_breadcrumbs(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div id="primary" class="content-area eleven columns">
		<main id="main" class="site-main" role="main">
		
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php boxy_post_nav(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>
	
<?php get_footer(); ?>