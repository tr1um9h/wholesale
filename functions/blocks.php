<?php
	/**
	 * Blocks
	 *
	 * @package      CultivateClient
	 * @author       CultivateWP
	 * @since        1.0.0
	 * @license      GPL-2.0+
	 **/


	/**
	 * Load Blocks
	 */
	function load_blocks() {
		$theme  = wp_get_theme();
		$blocks = get_blocks();
		foreach( $blocks as $block ) {
			if ( file_exists( get_stylesheet_directory() . '/blocks/' . $block . '/block.json' ) ) {
				register_block_type( get_stylesheet_directory() . '/blocks/' . $block . '/block.json' );
//				wp_register_style( 'block-' . $block, get_stylesheet_directory_uri() . '/blocks/' . $block . '/style.css', null, $theme->get( 'Version' ) );

				if ( file_exists( get_stylesheet_directory() . '/blocks/' . $block . '/init.php' ) ) {
					include_once get_stylesheet_directory() . '/blocks/' . $block . '/init.php';
				}
			}
		}
	}
	add_action( 'init', 'load_blocks', 5 );



	/**
	 * Get Blocks
	 */
	function get_blocks() {
		$theme   = wp_get_theme();
		$blocks  = get_option( 'solutions_blocks' );
		$version = get_option( 'solutions_blocks_version' );
		if ( empty( $blocks ) || version_compare( $theme->get( 'Version' ), $version ) || ( function_exists( 'wp_get_environment_type' ) && 'production' !== wp_get_environment_type() ) ) {
			$blocks = scandir( get_stylesheet_directory() . '/blocks/' );
			$blocks = array_values( array_diff( $blocks, array( '..', '.', '.DS_Store', '_base-block' ) ) );

			update_option( 'solutions_blocks', $blocks );
			update_option( 'solutions_blocks_version', $theme->get( 'Version' ) );
		}
		return $blocks;
	}

	/**
	 * Block categories
	 *
	 * @since 1.0.0
	 */
	function block_categories( $categories ) {

		// Check to see if we already have a CultivateWP category
		$include = true;
		foreach( $categories as $category ) {
			if( 'foac-blocks' === $category['slug'] ) {
				$include = false;
			}
		}

		if( $include ) {
			$categories = array_merge(
				$categories,
				[
					[
						'slug'  => 'solutions-blocks',
						'title' => __( 'Solutions Blocks', 'solutions' ),
					]
				]
			);
		}

		return $categories;
	}
	add_filter( 'block_categories_all', 'block_categories' );
