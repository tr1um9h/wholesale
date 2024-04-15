<?php

	function child_remove_page_templates($page_templates)
	{
		unset($page_templates['page-templates/blank.php']);
		unset($page_templates['page-templates/both-sidebarspage.php']);
		unset($page_templates['page-templates/empty.php']);
		unset($page_templates['page-templates/left-sidebarpage.php']);
		unset($page_templates['page-templates/right-sidebarpage.php']);
		unset($page_templates['page-templates/fullwidthpage.php']);
		return $page_templates;
	}

	add_filter('theme_post_templates', 'child_remove_page_templates', 20, 3);
	add_filter('theme_page_templates', 'child_remove_page_templates', 20, 3);
