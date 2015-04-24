<?php
/**
 * lti Theme Customizer
 *
 * @package lti
 */

if (!function_exists('lti_customize_register')) :
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function lti_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'lti_customize_register' );
endif;

if (!function_exists('lti_customize_preview_js')) :
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function lti_customize_preview_js() {
	wp_enqueue_script( 'lti_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'lti_customize_preview_js' );

endif;
