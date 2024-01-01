<?php

/**
 * Swingster functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Swingster
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function swingster_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Swingster, use a find and replace
		* to change 'swingster' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('swingster', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'swingster'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'swingster_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'swingster_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function swingster_content_width()
{
	$GLOBALS['content_width'] = apply_filters('swingster_content_width', 640);
}
add_action('after_setup_theme', 'swingster_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function swingster_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'swingster'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'swingster'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'swingster_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function swingster_scripts()
{
	wp_enqueue_style('swingster-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('swingster-style', 'rtl', 'replace');

	wp_enqueue_script('swingster-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'swingster_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}


// Admin Style Enqueue Start

function enqueue_admin_styles($hook)
{
	wp_enqueue_style('dashboard-style', get_template_directory_uri() . '/assets/admin/css/s-dashboard-style.css');
	if ($hook == 'toplevel_page_swinster-settings') {
		wp_enqueue_style('custom-admin-menu-style', get_template_directory_uri() . '/assets/admin/css/s-swingster-style.css');
	}
}

add_action('admin_enqueue_scripts', 'enqueue_admin_styles');

// Admin Style Enqueue End


// Public Style Enqueue Start

function combine_public_styles()
{
	// Include the minify_css.php file
	include_once(get_template_directory() . '/inc/minify_css.php');
	$theme_version = wp_get_theme()->get('Version');
	$combined_file = '/assets/public/css/all-styles.min.css'; // File to combine and minify all styles

	// Array of your CSS files
	$css_files = array(
		'base-style',
		'header-style',
		'footer-style',
		'404-style',
		'checkout-style',
		'thankyou-style',
		'single-style',
		'cart-style',
		'shop-style',
		'home-style',
		'custom-style'
	);

	// Minify and combine the CSS content
	$minified_css = ''; // Initialize variable to store minified CSS

	foreach ($css_files as $css_file) {
		$file_path = get_template_directory() . '/assets/public/css/s-' . $css_file . '.css';

		// Get the contents of each CSS file and append to $minified_css
		if (file_exists($file_path)) {
			$css_content = file_get_contents($file_path);
			$minified_css .= minify_css($css_content); // Minify each CSS file
		}
	}

	// Write the minified contents to the new file
	if (!empty($minified_css)) {
		file_put_contents(get_template_directory() . $combined_file, $minified_css);

		// Enqueue the minified combined file
		wp_enqueue_style('all-styles', get_template_directory_uri() . $combined_file, array(), $theme_version, 'all');
	}
}

add_action('wp_enqueue_scripts', 'combine_public_styles');


// Public Style Enqueue End

// Adding a Custom Menu in dashboard start

function swinster_add_menu_option()
{
	// Use add_menu_page for a top-level menu or add_submenu_page for a submenu

	// Add as a top-level menu option
	add_menu_page(
		'Swinster', // Page title
		'Swinster', // Menu title
		'manage_options', // Capability required to access
		'swinster-settings', // Menu slug
		'swinster_settings_page', // Function to display the page
		'data:image/svg+xml;base64,' . base64_encode('<svg width="105" height="92" viewBox="0 0 105 92" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M102.749 0.720164L0 41.9883L24.5 50L93.5 15L48.5 62L57.5 69.5L83.1197 89.975L104.095 1.87974C104.283 1.09052 103.502 0.4178 102.749 0.720164Z" fill="#D9D9D9"/>
		<path d="M88.2611 18.8521L44.559 59.9835L36.8469 89.9751L28.2778 53.1282L88.2611 18.8521Z" fill="#D9D9D9"/>
		<path d="M47 65.5L58.5 75L39 92L47 65.5Z" fill="#D9D9D9"/>
		</svg>
		'), // Custom SVG icon
		30 // Menu position
	);

	// Add Homepage as a submenu under Swinster
	add_submenu_page(
		'swinster-settings', // Parent menu slug
		'Homepage', // Page title
		'Homepage', // Menu title
		'manage_options', // Capability required to access
		'swinster-homepage', // Menu slug
		'swinster_homepage_settings_page' // Function to display the page
	);
}
add_action('admin_menu', 'swinster_add_menu_option');

// Add a custom class to the Swinster menu item
function add_custom_class_to_swinster_menu_item()
{
	global $menu;

	foreach ($menu as $key => $item) {
		if ($item[2] === 'swinster-settings') {
			$menu[$key][4] .= ' sw-menu__item'; // Append your custom class here
		}
	}
}
add_action('admin_menu', 'add_custom_class_to_swinster_menu_item');


// Main Theme setting home

// Function to render the settings page content
function swinster_settings_page()
{
	// Load the content from the 'dashboard/home.php' file
	include_once(get_template_directory() . '/template-parts/admin/swingster.php');
}

// Function to render the settings page content
function swinster_homepage_settings_page()
{
	// Load the content from the 'dashboard/home.php' file
	include_once(get_template_directory() . '/template-parts/admin/home.php');
}

// Adding a Custom Menu in dashboard end
