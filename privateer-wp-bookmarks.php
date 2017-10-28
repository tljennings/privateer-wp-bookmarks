<?php
namespace Ninja\Privateer\Wp\Plugins\Bookmarks;
/*
Plugin Name: Privateer WP Bookmarks
Description: Let users bookmark post types on your WordPress website
Version: 0.0.1
Author: The Privateer (aka Tony Jennings)
Author URI: https://www.privateer.ninja
License: MIT
*/

defined('\\ABSPATH') or die('Permission Denied');

try {

	const PLUGIN_PREFIX = 'pws_wpbm_';
	const PLUGIN_OPTIONS_NAME = 'pws_wpbm_settings';

	class Bookmark_Exception extends \Exception{}
	class Bookmark_Admin_Exception extends Bookmark_Exception {}
	class Bookmark_Front_Exception extends Bookmark_Exception {}

	$plugin_file_path = plugin_dir_path( __FILE__ );
	$plugin_url_path = plugin_dir_url( __FILE__ );
	$plugin_file_name = basename( __FILE__ );

	if ( false === include_once $plugin_file_path . 'include/interfaces.php' ) {
		throw new Bookmark_Exception('Failed to load interfaces', 10001);
	}

	if ( false === include_once $plugin_file_path . 'include/class-core.php' ) {
		throw new Bookmark_Exception('Failed to load core', 10001);
	}

	if ( is_admin() ) {
		if ( false === include_once $plugin_file_path . 'include/class-admin.php' ) {
			throw new Bookmark_Exception('Failed to load admin', 10001);
		}
		if ( false === include_once $plugin_file_path . 'include/helpers/class-settings-handler.php' ) {
			throw new Bookmark_Exception('Failed to load settings-handler', 10001);
		}
		if ( false === include_once $plugin_file_path . 'include/helpers/class-meta-box-handler.php' ) {
			throw new Bookmark_Exception('Failed to load meta-box-handler', 10001 );
		}

		$admin = Admin::get_instance(
			$plugin_file_path, $plugin_url_path, $plugin_file_name,
			PLUGIN_PREFIX , PLUGIN_OPTIONS_NAME
		);

		register_activation_hook( __FILE__, array($admin, 'activate') );
		register_deactivation_hook( __FILE__, array($admin, 'deactivate') );

		new Settings_Handler( $admin );
		new Meta_Box_Handler( $admin );

	} else {
		if ( false === include_once $plugin_file_path . 'include/class-front-end.php' ) {
			throw new Bookmark_Exception('Failed to load front end', 10001);
		}

		Front_End::get_instance(
			$plugin_file_path, $plugin_url_path, $plugin_file_name,
			PLUGIN_PREFIX, PLUGIN_OPTIONS_NAME
		);
	}
} catch ( \Exception $e ) {
	$die_on_error = false;
	if ( defined( '\\WP_DEBUG' ) && \WP_DEBUG ) {
		$die_on_error = true;
		if ( defined( '\\WP_DEBUG_LOG' ) && \WP_DEBUG_LOG ) {
			$die_on_error = false;
		}
	}

	$die_on_error = apply_filters( PLUGIN_PREFIX . 'die_on_exception', $die_on_error, $e );

	$code = $e->getCode();
	$file = $e->getFile();
	$line = $e->getLine();
	$message = $e->getMessage();
	$trace = $e->getTrace();
	$previous = $e->getPrevious();
	if ( ! is_null( $previous ) ) {
		$p_code = $previous->getCode();
		$p_file = $previous->getFile();
		$p_line = $previous->getLine();
		$p_message = $previous->getMessage();
		$p_trace = print_r($previous->getTrace(), true);
		$previous = <<<TXT
Previous Exception #{$p_code} in {$p_file} on line {$p_line}
{$p_message}
{$p_trace}
TXT;

	} else {
		$previous = 'None';
	}
	$out = <<<TXT
----------------------------------------------------
Privateer Wp Bookmarks Exception #{$code} {$message}
File: {$file} (line: {$line})
{$trace}
{$previous}
----------------------------------------------------
TXT;

	if ( $die_on_error ) {
		wp_die( $out, 'Privateer WP BookMarks Exception #' . $code . ':' . $message );
	} else {
		error_log( $out );
	}
}