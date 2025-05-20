<?php
/**
 * Plugin generic functions file
 *
 * @package Styles For WP Pagenavi Addon
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get plugin default settings
 * 
 * @since 1.0.0
 */
function sfwppa_get_default_settings() {

	$sfwppa_options = apply_filters( 'sfwppa_options_default_values', array(
											'menu_arr'			=>	'',
											'font_size'			=>	'',
											'font_color'		=>	'',
											'border_color'		=>	'',
											'active_bg_color'	=>	'',
											'hover_bg_color'	=>	'',
											'active_text_color'	=>	'',
											'hover_text_color'	=>	'',
	) );

	return $sfwppa_options;
}

/**
 * Update default settings
 * 
 * @since 1.0.0
 */
function sfwppa_set_default_settings() {

	global $sfwppa_options;

	$sfwppa_options = sfwppa_get_default_settings();

	// Update default options
	update_option( 'sfwppa_options', $sfwppa_options );
}

/**
 * Get Settings From Option Page
 * Handles to return all settings value
 * 
 * @since 1.0.0
*/
function sfwppa_get_settings() {

	$options = get_option('sfwppa_options');
	
	$settings = is_array($options) 	? $options : array();
	
	return $settings;
}

/**
 * Get an option
 * Looks to see if the specified setting exists, returns default if not
 * 
 * @since 1.0.0
 */
function sfwppa_get_option( $key = '', $default = false ) {

	global $sfwppa_options;

	$default_setting = sfwppa_get_default_settings();

	if( ! isset( $sfwppa_options[ $key ] ) && isset( $default_setting[ $key ] ) && ! $default ) {
		$value = $default_setting[ $key ];
	} else {
		$value = ! empty( $sfwppa_options[ $key ] ) ? $sfwppa_options[ $key ] : $default;
	}

	$value = apply_filters( 'sfwppa_get_option', $value, $key, $default );

	return apply_filters( 'sfwppa_get_option_' . $key, $value, $key, $default );
}

/**
 * Function template  designs
 * 
 * @since 1.0
 */
function sfwppa_menu_popup_layout() {
	$menu_arr = array(
					'style-1'		=> __('Style 1', 'Styles For WP Pagenavi Addon'),
					'style-2'		=> __('Style 2', 'Styles For WP Pagenavi Addon'),
					'style-3'		=> __('Style 3', 'Styles For WP Pagenavi Addon'),
					'style-4'		=> __('Style 4', 'Styles For WP Pagenavi Addon'),
					'style-5'		=> __('Style 5', 'Styles For WP Pagenavi Addon'),
	);
	return apply_filters('sfwppa_menu_popup_layout', $menu_arr );
}

/**
 * Function to get plugin image sizes array
 * 
 * @since 1.0
 */
// Simple Usage - 1 callback per filter
add_filter('wp_pagenavi_class_previouspostslink', 'sfwppa_pagination_previouspostslink_class');
add_filter('wp_pagenavi_class_nextpostslink', 'sfwppa_pagination_nextpostslink_class');
add_filter('wp_pagenavi_class_page', 'sfwppa_pagination_page_class');
add_filter('wp_pagenavi_class_first', 'sfwppa_first');
add_filter('wp_pagenavi_class_last', 'sfwppa_last');
add_filter('wp_pagenavi_class_extend', 'sfwppa_extend');
add_filter('wp_pagenavi_class_pages', 'sfwppa_pages');
add_filter( 'body_class', 'sfwppa_body_class' );

function sfwppa_pagination_previouspostslink_class($class_name) {
  return 'sfwppa-pages sfwppa-link sfwppa-link-previous';
}

function sfwppa_pagination_nextpostslink_class($class_name) {
  return 'sfwppa-pages sfwppa-link sfwppa-link-next';
}

function sfwppa_pagination_page_class($class_name) {
  return 'sfwppa-pages sfwppa-current-page';
}
function sfwppa_first($class_name) {
  return 'sfwppa-pages sfwppa-first';
}
function sfwppa_last($class_name) {
  return 'sfwppa-pages sfwppa-last';
}
function sfwppa_extend($class_name) {
  return 'sfwppa-pages sfwppa-extend';
}
function sfwppa_pages($class_name) {
  return 'sfwppa-pages';
}
function sfwppa_body_class($classes) {   
	global $sfwppa_options;
	
	$style = sfwppa_get_option('menu_arr');

	$classes[] = 'sfwppa-navi-style sfwppa-'.$style;
	return $classes;
}