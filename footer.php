<?php
	/**
	 * The template for displaying the footer
	 *
	 * Contains the closing of the #content div and all content after
	 *
	 * @package Understrap
	 */

	// Exit if accessed directly.
	defined('ABSPATH') || exit;

	$container = get_theme_mod('understrap_container_type');
?>

<?php get_template_part('sidebar-templates/sidebar', 'footerfull'); ?>

<footer>
  <div class="wrapper" id="wrapper-footer">
    <div class="<?php echo esc_attr($container); ?>">
      <p class="disclaimer">
        &copy;<script>document.write(new Date().getFullYear());</script> <?php understrap_site_info(); ?>
      </p>
    </div>
  </div><!-- #wrapper-footer -->
</footer>

<?php // Closing div#page from header.php. ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>

