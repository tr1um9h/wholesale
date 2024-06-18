<?php
	/**
	 * Header Navbar (bootstrap5)
	 *
	 * @package Understrap
	 * @since 1.1.0
	 */

	// Exit if accessed directly.
	defined( 'ABSPATH' ) || exit;

	$container = get_theme_mod( 'understrap_container_type' );
?>

<nav id="main-nav" class="navbar navbar-expand-md navbar-light bg-white" aria-labelledby="main-nav-label">

  <h2 id="main-nav-label" class="screen-reader-text">
		<?php esc_html_e( 'Main Navigation', 'understrap' ); ?>
  </h2>


  <div class="<?php echo esc_attr( $container ); ?>">

    <!-- Your site branding in the menu -->
		<?php get_template_part( 'global-templates/navbar-branding' ); ?>

    <div class="navbar-nav ms-auto">
      <ul class="list-unstyled">
        <li>
          <a class="btn btn-radical-red" href="https://tpo.loansimple.com/#/content/login" target="_blank">Login</a>
        </li>
        <li>
          <a class="btn btn-koromiko" href="#signup"> Sign Up</a>
        </li>
      </ul>
      <div class="phone">
        <span>Contact Us</span><br>
        <span>E:</span> tposupport@loansimple.com<br>
        <span>P:</span> 1-855-735-4875
      </div>
    </div>

  </div><!-- .container(-fluid) -->

</nav><!-- #main-nav -->
