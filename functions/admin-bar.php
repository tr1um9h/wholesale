<?php
add_theme_support('admin-bar', array('callback' => '__return_false'));


// Remove items from the admin bar

function remove_from_admin_bar($wp_admin_bar): void
{
  $wp_admin_bar->remove_node('gform-forms');
  $wp_admin_bar->remove_node('updates');
  $wp_admin_bar->remove_node('comments');
  $wp_admin_bar->remove_node('new-content');
  $wp_admin_bar->remove_node('search');
  $wp_admin_bar->remove_node('wp-logo');

}

add_action('admin_bar_menu', 'remove_from_admin_bar', 999);
