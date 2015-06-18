<?php
/**
 * The Front Page template file.
 *
 * This is the front page template file, use to display static page
 * when set 'Front page displays' to a page in Reading Settings
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package BOXY
 */
if ( 'posts' == get_option( 'show_on_front' ) ) {
	include get_home_template();
} else {
	get_header();

	if ( isset( $boxy ) ) {
		$slides = isset($boxy['slides']) ? $boxy['slides'] : '';
		$output = '';

		$output .= '<div class="flex-container">';
		$output .= '<div class="flexslider">';
		$output .= '<ul class="slides">';

		foreach ( (array)$slides as $slide ) {
			$output .= '<li>';
			if ( isset( $slide['image'] ) && $slide['image'] != '' ) {
				$slide_image = $slide['image'];
			} else {
				$slide_image = $boxy_home['slide'];
			}

			if ( isset( $slide['description'] ) && $slide['description'] != '' ) {
				$slide_description = $slide['description'];
			} else {
				$slide_description = $boxy_home['caption'];
			}
			$output .= '<div class="flex-image"><img src="' . esc_url( $slide_image ) . '" alt="" ></div>';
			$output .= '<div class="flex-caption">' . $slide_description . '</div>';
			$output .= '</li>';
		}

		$output .= '</ul>';
		$output .= '</div><!-- .flexslider -->';
		$output .= '</div><!-- .flex-container -->';

		echo $output;

		$output = '';
		$output = '<div class="services">';
		$output .= '<div class="container">';
		$service_icon = $boxy_home['service-icon'];
		$service_title = $boxy_home['service-title'];
		$service_description = $boxy_home['service-description'];
		$dummy_service = '';
		$dummy_service .= '<div class="one-third column" class="service">';
		$dummy_service .= '<div class="service-title"><p><i class="' . esc_attr( $boxy_home['service-icon'] ) . '"></i></p>';
		$dummy_service .= '<h3>' . esc_html( $boxy_home['service-title'] ) . '</h3></div>';
		$dummy_service .= '<div class="service">' . $boxy_home['service-description'] . '</div>';
		$dummy_service .= '</div><!-- .one-third -->';

		if ( isset( $boxy['service-icon-1'], $boxy['service-title-1'], $boxy['service-description-1'] ) && ( $boxy['service-icon-1'] != '' && $boxy['service-title-1'] != '' && $boxy['service-description-1'] != '' )  ) {
			$output .= '<div class="one-third column" class="service">';
			$output .= '<div class="service-title"><p><i class="' . esc_attr( $boxy['service-icon-1'] ) . '"></i></p>';
			$output .= '<h3>' . esc_html( $boxy['service-title-1'] ) . '</h3></div>';
			$output .= '<div class="service">' . $boxy['service-description-1'] . '</div>';
			$output .= '</div><!-- .one-third -->';
		} else {
			$output .= $dummy_service;
		}

		if ( isset( $boxy['service-icon-2'], $boxy['service-title-2'], $boxy['service-description-2'] ) && ( $boxy['service-icon-2'] != '' && $boxy['service-title-2'] != '' && $boxy['service-description-2'] != '' )  ) {
			$output .= '<div class="one-third column" class="service">';
			$output .= '<div class="service-title"><p><i class="' . esc_attr( $boxy['service-icon-2'] ) . '"></i></p>';
			$output .= '<h3>' . esc_html( $boxy['service-title-2'] ) . '</h3></div>';
			$output .= '<div class="service">' . $boxy['service-description-2'] . '</div>';
			$output .= '</div><!-- .one-third -->';
		} else {
			$output .= $dummy_service;
		}

		if ( isset( $boxy['service-icon-3'], $boxy['service-title-3'], $boxy['service-description-3'] ) && ( $boxy['service-icon-3'] != '' && $boxy['service-title-3'] != '' && $boxy['service-description-3'] != '' )  ) {
			$output .= '<div class="one-third column" class="service">';
			$output .= '<div class="service-title"><p><i class="' . esc_attr( $boxy['service-icon-3'] ) . '"></i></p>';
			$output .= '<h3>' . esc_html( $boxy['service-title-3'] ) . '</h3></div>';
			$output .= '<div class="service">' . $boxy['service-description-3'] . '</div>';
			$output .= '</div><!-- .one-third -->';
		} else {
			$output .= $dummy_service;
		}
		$output .= '</div><!-- .container -->';
		$output .= '</div><!-- .services -->';

		echo $output;

?>
		<div id="content" class="site-content container">

				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">
					<?php boxy_recent_posts(); ?>

					<?php if ( isset( $boxy['clients'] ) && is_array( $boxy['clients'] ) && !empty( $boxy['clients'] ) ) : ?>
						<div class="sixteen columns">
							<div class="flex-container clients">
								<ul class="slides">
								<?php foreach ( $boxy['clients'] as $client ) :
									$client_logo = ( $client['image'] != '' ) ? $client['image']: $boxy_home['client'];
								?>
									<li><img src="<?php echo esc_url( $client_logo ); ?>"></li>
								<?php endforeach; ?>
								</ul>
							</div>
						</div><!-- .span12 -->
					<br class="clear"/>
						<div class="gap"></div>
					<?php endif;
	}
?>

				</main><!-- #main -->
			</div><!-- #primary -->
<?php
	get_footer();
}
?>
