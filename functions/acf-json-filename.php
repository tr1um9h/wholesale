<?php

	function custom_acf_json_filename( $filename, $post, $load_path ) {
		$filename = str_replace(
			array(
				' ',
				'_',
			),
			array(
				'-',
				'-'
			),
			$post['title']
		);

		$filename = strtolower( $filename ) . '.json';

		return $filename;
	}
	add_filter( 'acf/json/save_file_name', 'custom_acf_json_filename', 10, 3 );
