<?php
/**
 * Navbar branding
 *
 * @package Understrap
 * @since 1.2.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! has_custom_logo() ) { ?>

	<?php if ( is_front_page() && is_home() ) : ?>

		<h1 class="navbar-brand mb-0">
			<a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
				<?php bloginfo( 'name' ); ?>
			</a>
		</h1>

	<?php else : ?>

		<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
			<?php bloginfo( 'name' ); ?>
		</a>

	<?php endif; ?>

	<?php
} else {
	if (has_custom_logo()) {
		$logo = get_theme_mod( 'custom_logo' );
		$image = wp_get_attachment_image_url( $logo, 'full');
		echo '<a href="'. esc_url( home_url( '/' ) ) .'" class="navbar-brand custom-logo-link">';
    echo '<img width="53" height="53" class="d-block d-lg-none d-xl-none d-xxl-none custom-text-logo img-fluid" src="' .get_stylesheet_directory_uri(). '/images/heart-logo-black.svg" alt="' . get_bloginfo() .'">';
    echo '<img width="181" height="53" class="d-none d-md-block d-lg-block d-xl-block d-xxl-block custom-text-logo img-fluid" src="' . $image . '" alt="' . get_bloginfo() .'">';
		echo '</a>';
	}
}
