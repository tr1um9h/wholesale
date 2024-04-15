<?php
// Wholesale includes directory.
	$wholesale_functions_dir = 'functions';

// Array of files to include.
	$ls_includes = [
		'/setup.php',                           // Theme setup and custom theme supports.
		'/soil.php',                            // Soil Config.
		'/blocks.php',                          // Load Custom Blocks
		'/wide-gutenberg.php',                  // Wide Gutenberg.
		'/body-class.php',                      // Body Class.
		'/admin-bar.php',                       // WP Admin Bar CSS.
		'/google-fonts.php',                    // Remove Google Fonts.
		'/remove-parent-templates.php',         // Remove Parent Templates.
		'/acf-json-filename.php',               // ACF JSON Filename.
		'/disable-rest-api.php',                // Disable Rest API.
		'/custom-functions.php',                // Custom Functions.
	];

	$customizer_includes = [
		'/blocks.php',                          // Blocks.
	];

	foreach ($ls_includes as $file) {
		require_once get_theme_file_path($wholesale_functions_dir . $file);
	}

	foreach ($customizer_includes as $file) {
		require_once get_theme_file_path($wholesale_functions_dir . '/customizer-options/' . $file);
	}

	ls_disable_rest_api_user_enumeration();
