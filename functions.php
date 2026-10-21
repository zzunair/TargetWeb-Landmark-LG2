<?php
/**
 * Greenline Power Equipment Theme functions
 *
 * @package Greenline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'GREENLINE_VERSION', '1.0.3' );
define( 'GREENLINE_DIR', get_template_directory() );
define( 'GREENLINE_URI', get_template_directory_uri() );

/**
 * Theme setup
 */
function greenline_setup() {
	load_theme_textdomain( 'greenline', GREENLINE_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'greenline' ),
			'footer-shop'     => __( 'Footer — Shop Column', 'greenline' ),
			'footer-services' => __( 'Footer — Services Column', 'greenline' ),
			'footer-company'  => __( 'Footer — Company Column', 'greenline' ),
		)
	);

	add_image_size( 'greenline-hero', 900, 620, true );
	add_image_size( 'greenline-card', 500, 500, true );
	add_image_size( 'greenline-wide', 1200, 700, true );
}
add_action( 'after_setup_theme', 'greenline_setup' );

/**
 * Enqueue styles & scripts
 */
function greenline_scripts() {
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'greenline-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap', array(), null );
	wp_enqueue_style( 'greenline-style', GREENLINE_URI . '/style.css', array(), GREENLINE_VERSION );
	wp_enqueue_style( 'greenline-main', GREENLINE_URI . '/assets/css/main.css', array( 'greenline-style' ), GREENLINE_VERSION );

	wp_enqueue_script( 'greenline-main', GREENLINE_URI . '/assets/js/main.js', array(), GREENLINE_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Feed the dynamic color palette from the Customizer to CSS custom properties.
	$colors = greenline_get_color_vars();
	wp_add_inline_style( 'greenline-main', $colors );
}
add_action( 'wp_enqueue_scripts', 'greenline_scripts' );

/**
 * Build a small inline stylesheet of CSS variables driven by the Customizer,
 * so every color on the site can be changed with zero code edits.
 */
function greenline_get_color_vars() {
	$map = array(
		'--gl-cream'      => greenline_opt( 'gl_color_cream', '#F6F4EC' ),
		'--gl-cream-alt'  => greenline_opt( 'gl_color_cream_alt', '#EDF0E8' ),
		'--gl-dark'       => greenline_opt( 'gl_color_dark', '#152018' ),
		'--gl-green'      => greenline_opt( 'gl_color_green', '#1F3D2A' ),
		'--gl-green-bright'=> greenline_opt( 'gl_color_green_bright', '#3EA65A' ),
		'--gl-orange'     => greenline_opt( 'gl_color_orange', '#E8792D' ),
		'--gl-text'       => greenline_opt( 'gl_color_text', '#1A1D18' ),
		'--gl-text-light' => greenline_opt( 'gl_color_text_light', '#6B7066' ),
		'--gl-border'     => greenline_opt( 'gl_color_border', '#E2E4DB' ),
		'--gl-white'      => '#FFFFFF',
	);
	$css = ':root{';
	foreach ( $map as $var => $val ) {
		$css .= esc_attr( $var ) . ':' . esc_attr( $val ) . ';';
	}
	$css .= '}';
	return $css;
}

/**
 * Shorthand helper for theme_mod lookups. If no $default is passed,
 * falls back to the centralized default in inc/field-defaults.php —
 * this is what guarantees content shows on a fresh front-end load even
 * if that specific field was never opened/saved in the Customizer.
 */
function greenline_opt( $key, $default = null ) {
	if ( null === $default ) {
		$default = greenline_text_default( $key );
	}
	return get_theme_mod( $key, $default );
}

/**
 * Widget areas
 */
function greenline_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar', 'greenline' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'greenline_widgets_init' );

/**
 * Includes
 */
require GREENLINE_DIR . '/inc/field-defaults.php';
require GREENLINE_DIR . '/inc/repeaters.php';
require GREENLINE_DIR . '/inc/customizer.php';
require GREENLINE_DIR . '/inc/demo-content.php';
require GREENLINE_DIR . '/inc/template-tags.php';
require GREENLINE_DIR . '/inc/form-handler.php';
require GREENLINE_DIR . '/inc/seo.php';
require GREENLINE_DIR . '/inc/maintenance.php';

/**
 * Excerpt length for blog
 */
function greenline_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'greenline_excerpt_length' );

/**
 * Register block editor / customizer color palette (nice-to-have, keeps Gutenberg on-brand)
 */
function greenline_editor_color_palette() {
	add_theme_support(
		'editor-color-palette',
		array(
			array( 'name' => 'Forest Green', 'slug' => 'gl-green', 'color' => greenline_opt( 'gl_color_green', '#1F3D2A' ) ),
			array( 'name' => 'Bright Green', 'slug' => 'gl-green-bright', 'color' => greenline_opt( 'gl_color_green_bright', '#3EA65A' ) ),
			array( 'name' => 'Signal Orange', 'slug' => 'gl-orange', 'color' => greenline_opt( 'gl_color_orange', '#E8792D' ) ),
			array( 'name' => 'Cream', 'slug' => 'gl-cream', 'color' => greenline_opt( 'gl_color_cream', '#F6F4EC' ) ),
			array( 'name' => 'Dark', 'slug' => 'gl-dark', 'color' => greenline_opt( 'gl_color_dark', '#152018' ) ),
		)
	);
}
add_action( 'after_setup_theme', 'greenline_editor_color_palette' );
