<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package BOXY
 */
?>

	</div><!-- #content -->
</div>

	<footer id="colophon" class="site-footer" role="contentinfo">
	<?php
global $boxy;
if ( $boxy['footer-widgets'] ) : ?>
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<?php get_template_part( 'footer', 'widgets' ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
		<div class="footer-bottom">
			<div class="container">
				<div class="sixteen columns">
					<div class="site-info">
						<?php printf( __( 'Proudly powered by %s', 'boxy' ), '<a href="http://wordpress.org">WordPress</a>' ); ?>
						<span class="sep"> | </span>
						<?php printf( __( 'Theme %1$s by %2$s', 'boxy' ), 'Boxy', '<a href="http://www.webulousthemes.com/" rel="designer">Webulous Themes</a>' ); ?>
					</div><!-- .site-info -->
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
