<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Life Is Good
 * @since Life Is Good 1.0
 */
?>
		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php get_sidebar( 'main' ); ?>

			<div class="site-info ">
				<?php do_action( 'lifeisgood_credits' ); ?>
				<p class="left"><?php _e( 'Life Is Good', 'lifeisgood' ); ?> <?php _e( 'Theme by', 'lifeisgood' ); ?> <a href="<?php echo esc_url( __( 'http://www.daniel-klose.com/', 'lifeisgood' ) ); ?>" title="<?php esc_attr_e( 'Daniel-Klose.com', 'lifeisgood' ); ?>"><?php _e( 'Daniel-Klose.com', 'lifeisgood' ); ?></a></p>
				<p class="right"><a href="<?php echo esc_url( __( 'http://wordpress.org/', 'lifeisgood' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'lifeisgood' ); ?>"><?php printf( __( 'Proudly powered by %s', 'lifeisgood' ), 'WordPress' ); ?></a></p>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>