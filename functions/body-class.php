<?php
	function add_slug_body_class($classes)
	{
		global $post;
		if (isset($post)) {
			if ($post->post_parent) {
				$parent = get_post($post->post_parent);
				$classes[] = $post->post_type . '-' . $post->post_name . ' parent-' . $post->post_type . '-' . $parent->post_name;
			} else {
				$classes[] = $post->post_type . '-' . $post->post_name;
			}
		}
        if ( is_page() && has_block( 'foac/thank-you', $post->ID ) ) {
            $classes[] = 'has-thank-you-block';
        }
		return $classes;
	}

	add_filter('body_class', 'add_slug_body_class');
