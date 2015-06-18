<?php
/**
 * The home template file.
 *
 * This is home template file is used to display blog posts
 * when Reading Settings set to 'Your latest posts'.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package BOXY
 */
global $boxy;
get_header(); ?>
<?php if( is_front_page() ) : ?>
	<div id="content" class="site-content container">
<?php endif; ?>

	<div id="primary" class="content-area eleven columns">
		<main id="main" class="site-main" role="main">

		<?php if ( $boxy['breadcrumb'] && function_exists( 'boxy_breadcrumbs' ) ) : ?>			
			<div id="breadcrumb" role="navigation">
				<?php boxy_breadcrumbs(); ?>
			</div>
		<?php endif; ?>
				
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php 
				if( $boxy['pagenavi'] && function_exists( 'boxy_pagination' ) ) : 
					boxy_pagination();
				else :
					boxy_posts_nav();
				endif; 
			?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>
		
<?php get_footer(); ?>