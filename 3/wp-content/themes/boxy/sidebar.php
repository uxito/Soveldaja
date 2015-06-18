<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package boxy
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="sidebar widget-area offset-by-one five columns" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
