<?php
	add_action('admin_head', 'admin_styles');
	function admin_styles()
	{
		echo '<style>
            .wp-block {max-width: 90%;}
            .block-library-block__reusable-block-container .wp-block, .block-list-appender .wp-block {width: 100%; max-width: 100%;}
            .wp-block[data-align="wide"] {max-width: 1280px;}
            </style>';
	}
