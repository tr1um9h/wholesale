<?php

	/**
	 *
	 * https://wp-tutorials.tech/optimise-wordpress/disable-wordpress-rest-api-without-a-plugin/
	 *
	 * By default, the REST API is enabled - like the default WordPress behaviour.
	 *
	 * If you want to disable the API completely for non-logged-in users then just
	 * call ls_completely_disable_rest_api(), BUT BUT BUT, you probably just want
	 * to add this to your functions.php
	 *
	 *   define('LS_IS_REST_API_USER_ENUMERATION_DISABLED', true);
	 *
	 * If you want to only allow REST API calls for non-logged-in users from
	 * certain IP addresses, just pass those IP addresses in the constant
	 * LS_REST_API_IP_WHITELIST, like this:
	 *
	 *  define(
	 *     'LS_REST_API_IP_WHITELIST',
	 *     array('127.0.0.1', '::1', 'address-1', 'address-2', '...')
	 *  );
	 *
	 * If you want to write events to the system auth log for Fail2Ban to see, then:
	 *
	 *  define('LS_REST_IS_FAIL2BAN_ENABLED', true);
	 *
	 */

// Block direct access.
	defined('WPINC') || die();

	define('LS_REST_API_DEFAULT_IP_WHITELIST', ['127.0.0.1', '::1']);

	function ls_completely_disable_rest_api()
	{
		if (!defined('LS_IS_REST_API_DISABLED')) {
			define('LS_IS_REST_API_DISABLED', true);
		}
	}

	function ls_disable_rest_api_user_enumeration()
	{
		if (!defined('LS_IS_REST_API_USER_ENUMERATION_DISABLED')) {
			define('LS_IS_REST_API_USER_ENUMERATION_DISABLED', true);
		}
	}

	function ls_request_block_ip($ip_address = '')
	{
		if (empty($ip_address)) {
			$ip_address = sanitize_text_field($_SERVER['REMOTE_ADDR']);
		}

		if (!empty($ip_address)) {
			// error_log('Blocking IP: ' . $ip_address);

			$is_fail2ban_enabled = true;
			if (defined('LS_REST_IS_FAIL2BAN_ENABLED') && (LS_REST_IS_FAIL2BAN_ENABLED !== true)) {
				$is_fail2ban_enabled = false;
			}

			if ($is_fail2ban_enabled) {
				openlog('wp(' . sanitize_text_field($_SERVER['HTTP_HOST']) . ')', LOG_NDELAY | LOG_PID, LOG_AUTH);
				syslog(LOG_INFO, "REST User Enum " . $ip_address);
				closelog();
			} else {
				error_log('Found enumeration attempt, but LS_REST_IS_FAIL2BAN_ENABLED is not enabled.');
			}
		}
	}

	function ls_rest_api_init()
	{
		$is_rest_api_available = true;
		$is_attempting_user_enumeration = false;

		$is_user_an_administrator = false;
		if ($is_user_authenticated = is_user_logged_in()) {
			$is_user_an_administrator = current_user_can('administrator');
		}

		$is_user_authorised = ($is_user_authenticated && $is_user_an_administrator);

		$is_remote_ip_whitelisted = false;
		if (defined('LS_REST_API_IP_WHITELIST') && is_array(LS_REST_API_IP_WHITELIST)) {
			$is_remote_ip_whitelisted = in_array($_SERVER['REMOTE_ADDR'], LS_REST_API_IP_WHITELIST);
		} elseif (defined('LS_REST_API_DEFAULT_IP_WHITELIST') && is_array(LS_REST_API_DEFAULT_IP_WHITELIST)) {
			$is_remote_ip_whitelisted = in_array($_SERVER['REMOTE_ADDR'], LS_REST_API_DEFAULT_IP_WHITELIST);
		} else {
			// ...
		}

		$is_ip_block_requested = false;
		$is_rest_api_disabled = false;
		if (defined('LS_IS_REST_API_DISABLED')) {
			$is_rest_api_disabled = (LS_IS_REST_API_DISABLED === true);
		}

		$is_public_user_enumeration_disabled = true;
		if (defined('LS_IS_REST_API_USER_ENUMERATION_DISABLED') && (LS_IS_REST_API_USER_ENUMERATION_DISABLED !== true)) {
			$is_public_user_enumeration_disabled = false;
		}

		$is_endpoint_blocked = false;
		if (!$is_user_authenticated && !$is_remote_ip_whitelisted && $is_public_user_enumeration_disabled) {
			$prefix = rest_get_url_prefix();
			$users_path = '/' . $prefix . '/wp/v2/users';

			if ((isset($_SERVER['REQUEST_URI']) && (strpos($_SERVER['REQUEST_URI'], $users_path) !== false))
				||
				(isset($_REQUEST['rest_route']) && (strpos($_SERVER['rest_route'], $users_path) !== false))
			) {
				$is_endpoint_blocked = true;
				$is_ip_block_requested = true;
			}

		}

		$http_error_code = null;
		$is_rest_api_available = false;
		if ($is_user_authorised) {
			// ...
		} elseif ($is_remote_ip_whitelisted) {
			// ...
		} elseif ($is_rest_api_disabled) {
			$http_error_code = 404;
		} elseif (!$is_endpoint_blocked) {
			// ...
		} else {
			$http_error_code = 404;
		}

		if ($is_ip_block_requested) {
			ls_request_block_ip();
		}

		if ($http_error_code == 404) {
			header("Status: 404 Not Found");
			$GLOBALS['wp_query']->set_404();
			status_header(404);
			nocache_headers();
			include get_query_template('404');
			exit;
		} elseif (!empty($http_error_code)) {
			http_response_code($http_error_code);
			die('ERR: ' . $http_error_code);
		} else {
			// OK.
		}
	}

	add_action('rest_api_init', 'ls_rest_api_init', 100);
