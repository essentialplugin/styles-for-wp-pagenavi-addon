<?php
/**
 * Plugin Name:		Styles For WP Pagenavi Addon
 * Plugin URI:		https://www.essentialplugin.com/wordpress-plugin/styles-wp-pagenavi-addon/
 * Description:		Adds a more styling options to Wp-PageNavi WordPress plugin OR  the_posts_pagination(); WordPress navigation function
 * Version:			1.2.4
 * Author:			Essential Plugin
 * Author URI:		https://profiles.wordpress.org/essentialplugin/
 * Text Domain:		styles-for-wp-pagenavi-addon
 * Domain Path:		/languages/
 * Tested up to:	6.8.1
 * Requires PHP:	7.4
 *
 * @package Styles For WP Pagenavi Addon
 * @author Essential Plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! defined('SFWPPA_VERSION') ) {
    define( 'SFWPPA_VERSION', '1.2.4' ); // Plugin version
}
if ( ! defined( 'SFWPPA_VERSION_DIR' ) ) {
    define( 'SFWPPA_VERSION_DIR', dirname( __FILE__ ) ); // Plugin dir
}
if ( ! defined( 'SFWPPA_URL' ) ) {
    define( 'SFWPPA_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}
if (!defined( 'SFWPPA_SITE_LINK' ) ) {
	define('SFWPPA_SITE_LINK', 'https://essentialplugin.com'); // Plugin link
}

function sfwppa_load_textdomain() {

	global $wp_version;

	// Set filter for plugin's languages directory
	$sfwppa_lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	$sfwppa_lang_dir = apply_filters( 'sfwppa_languages_directory', $sfwppa_lang_dir );

	// Traditional WordPress plugin locale filter.
	$get_locale = get_locale();

	if ( $wp_version >= 4.7 ) {
		$get_locale = get_user_locale();
	}

	// Traditional WordPress plugin locale filter
	$locale = apply_filters( 'plugin_locale',  $get_locale, 'styles-for-wp-pagenavi-addon' );
	$mofile = sprintf( '%1$s-%2$s.mo', 'styles-for-wp-pagenavi-addon', $locale );

	// Setup paths to current locale file
	$mofile_global  = WP_LANG_DIR . '/plugins/' . basename( SFWPPA_VERSION_DIR ) . '/' . $mofile;

	if ( file_exists( $mofile_global ) ) { // Look in global /wp-content/languages/plugin-name folder
		load_textdomain( 'styles-for-wp-pagenavi-addon', $mofile_global );
	} else { // Load the default language files
		load_plugin_textdomain( 'styles-for-wp-pagenavi-addon', false, $sfwppa_lang_dir );
	}
}
add_action('init', 'sfwppa_load_textdomain'); 

/**
 * Activation Hook
 * 
 * Register plugin activation hook.
 * 
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'sfwppa_ticker_install' );

/**
 * Plugin Activation Function
 * Does the initial setup, sets the default values for the plugin options
 * 
 * @since 1.0.0
 */
function sfwppa_ticker_install() {
	
	// IMP to call to generate new rules
	flush_rewrite_rules();

}

global $sfwppa_options;

// Function file
require_once( SFWPPA_VERSION_DIR . '/includes/sfwppa-function.php' );
$sfwppa_options = sfwppa_get_settings();

// Admin Class
require_once( SFWPPA_VERSION_DIR . '/includes/admin/class-sfwppa-admin.php' );

// Script
require_once( SFWPPA_VERSION_DIR . '/includes/class-sfwppa-script.php' );
