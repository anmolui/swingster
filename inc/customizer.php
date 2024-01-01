<?php

/**
 * Swingster Theme Customizer
 *
 * @package Swingster
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function swingster_customize_register($wp_customize)
{
	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

	if (isset($wp_customize->selective_refresh)) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'swingster_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'swingster_customize_partial_blogdescription',
			)
		);
	}
}
add_action('customize_register', 'swingster_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function swingster_customize_partial_blogname()
{
	bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function swingster_customize_partial_blogdescription()
{
	bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function swingster_customize_preview_js()
{
	wp_enqueue_script('swingster-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), _S_VERSION, true);
}
add_action('customize_preview_init', 'swingster_customize_preview_js');

// Swingster Customizer Menus adding Start

// 'text': Text input field.
// 'textarea': Larger textarea input.
// 'checkbox': Checkbox input.
// 'radio': Radio button input.
// 'select': Dropdown select input.
// 'dropdown-pages': Dropdown of pages select input.
// 'image': Image upload input.
// 'color': Color picker input.
// 'file': File upload input.
// 'date': Date picker input.
// 'number': Numeric input.
// 'custom': Custom control for more advanced customization.

// Define functions for each panel and their respective sections

// Swingster Customizer Menu

function swingster_customize_panel($wp_customize) {
    // Add a panel for organizing settings
    $wp_customize->add_panel('swingster_menu_panel', array(
        'title' => __('Swingster', 'swingster'),
        'priority' => 30,
    ));

    // Call functions for sections within this panel
    swingster_customize_header_section($wp_customize);
    swingster_customize_main_section($wp_customize);
    swingster_customize_footer_section($wp_customize);
}

// Header Customizer Menu inside Swingster

function swingster_customize_header_section($wp_customize) {
    // Add a section for the header inside the panel
    $wp_customize->add_section('swingster_header_section', array(
        'title' => __('Header', 'swingster'),
        'priority' => 10,
        'panel' => 'swingster_menu_panel',
    ));

    // Add a setting and control for the header text
    $wp_customize->add_setting('header_text_setting', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('header_text_control', array(
        'label' => __('Header Text', 'swingster'),
        'section' => 'swingster_header_section',
        'settings' => 'header_text_setting',
        'type' => 'text',
    ));
}

// Main Customizer Menu inside Swingster

function swingster_customize_main_section($wp_customize) {
    // Add a section for the main content inside the panel
    $wp_customize->add_section('swingster_main_section', array(
        'title' => __('Main Content', 'swingster'),
        'priority' => 20,
        'panel' => 'swingster_menu_panel',
    ));

    // Add a setting and control for the main content text
    $wp_customize->add_setting('main_content_setting', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('main_content_control', array(
        'label' => __('Main Content Text', 'swingster'),
        'section' => 'swingster_main_section',
        'settings' => 'main_content_setting',
        'type' => 'text',
    ));
}

// Footer Customizer Menu inside Swingster

function swingster_customize_footer_section($wp_customize) {
    // Add a section for the footer inside the panel
    $wp_customize->add_section('swingster_footer_section', array(
        'title' => __('Footer', 'swingster'),
        'priority' => 30,
        'panel' => 'swingster_menu_panel',
    ));

    // Add a setting and control for the footer text
    $wp_customize->add_setting('footer_text_setting', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('footer_text_control', array(
        'label' => __('Footer Text', 'swingster'),
        'section' => 'swingster_footer_section',
        'settings' => 'footer_text_setting',
        'type' => 'text',
    ));
}

add_action('customize_register', 'swingster_customize_panel');

// Swingster Customizer Menus adding End