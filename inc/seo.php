<?php
/**
 * Built-in SEO. Steps aside when an SEO plugin is active.
 *
 * @package Greenline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greenline_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'THE_SEO_FRAMEWORK_VERSION' ) || defined( 'SLIM_SEO_VER' );
}

function greenline_seo_enabled() {
	$on = get_theme_mod( 'gl_seo_on', true );
	return $on && ! greenline_seo_plugin_active();
}

add_filter(
	'wp_robots',
	function ( $robots ) {
		$flags = array( 'gl_quote', 's' );
		foreach ( array_keys( $_GET ) as $key ) { // phpcs:ignore WordPress.Security.NonceVerification
			if ( in_array( sanitize_key( $key ), $flags, true ) ) {
				$robots['noindex'] = true;
				$robots['follow']  = true;
				unset( $robots['index'] );
				return $robots;
			}
		}
		if ( is_search() || is_404() ) {
			$robots['noindex'] = true;
			$robots['follow']  = true;
		}
		return $robots;
	}
);

function greenline_seo_description() {
	$description = '';
	if ( is_singular() ) {
		$description = has_excerpt() ? get_the_excerpt() : wp_strip_all_tags( strip_shortcodes( (string) get_post_field( 'post_content' ) ) );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$description = wp_strip_all_tags( term_description() );
	}
	if ( ! $description ) {
		$description = greenline_opt( 'gl_seo_desc' );
	}
	if ( ! $description ) {
		$description = get_bloginfo( 'description' );
	}
	if ( ! $description ) {
		$description = greenline_opt( 'gl_footer_tagline' );
	}
	return wp_trim_words( trim( preg_replace( '/\s+/', ' ', (string) $description ) ), 32, '…' );
}

function greenline_seo_canonical() {
	if ( is_front_page() ) {
		return home_url( '/' );
	}
	if ( is_singular() ) {
		return get_permalink();
	}
	if ( is_category() || is_tag() || is_tax() ) {
		$link = get_term_link( get_queried_object() );
		return is_wp_error( $link ) ? '' : $link;
	}
	if ( is_home() && get_option( 'page_for_posts' ) ) {
		return get_permalink( (int) get_option( 'page_for_posts' ) );
	}
	if ( is_search() || is_404() ) {
		return '';
	}
	return home_url( '/' );
}

function greenline_seo_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		return get_the_post_thumbnail_url( null, 'large' );
	}
	$url = greenline_opt( 'gl_seo_image' );
	if ( $url ) {
		return $url;
	}
	$logo = get_theme_mod( 'custom_logo' );
	return $logo ? wp_get_attachment_image_url( (int) $logo, 'large' ) : '';
}

function greenline_seo_customize( $wp_customize ) {
	$wp_customize->add_section(
		'gl_sec_seo',
		array(
			'title'       => __( 'SEO', 'greenline' ),
			'panel'       => 'greenline_panel',
			'priority'    => 70,
			'description' => __( 'Adds the description, social preview, and business details. This turns itself off when Yoast, Rank Math, AIOSEO, SEOPress, The SEO Framework, or Slim SEO is active.', 'greenline' ),
		)
	);

	$wp_customize->add_setting( 'gl_seo_on', array( 'default' => true, 'sanitize_callback' => 'wp_validate_boolean' ) );
	$wp_customize->add_control( 'gl_seo_on', array( 'label' => __( 'Enable built-in SEO', 'greenline' ), 'section' => 'gl_sec_seo', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'gl_seo_desc', array( 'default' => greenline_text_default( 'gl_seo_desc' ), 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'gl_seo_desc', array( 'label' => __( 'Default description', 'greenline' ), 'description' => __( 'Used on the homepage and on pages that have no excerpt.', 'greenline' ), 'section' => 'gl_sec_seo', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'gl_seo_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'gl_seo_image', array( 'label' => __( 'Social share image', 'greenline' ), 'section' => 'gl_sec_seo' ) ) );
}
add_action( 'customize_register', 'greenline_seo_customize', 20 );

add_action(
	'wp_head',
	function () {
		if ( ! greenline_seo_enabled() || is_customize_preview() ) {
			return;
		}
		remove_action( 'wp_head', 'rel_canonical' );

		$description = greenline_seo_description();
		$canonical   = greenline_seo_canonical();
		$title       = wp_get_document_title();
		$image       = greenline_seo_image();
		$type        = is_singular( 'post' ) ? 'article' : 'website';

		if ( $canonical ) {
			$paged = (int) get_query_var( 'paged' );
			if ( $paged > 1 && ! is_singular() ) {
				$canonical = strtok( get_pagenum_link( $paged ), '?' );
			}
			echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
		}
		if ( $description ) {
			echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
		}

		$open_graph = array(
			'og:locale'      => get_locale(),
			'og:type'        => $type,
			'og:title'       => $title,
			'og:description' => $description,
			'og:url'         => $canonical,
			'og:site_name'   => get_bloginfo( 'name' ),
			'og:image'       => $image,
		);
		foreach ( $open_graph as $key => $value ) {
			if ( $value ) {
				echo '<meta property="' . esc_attr( $key ) . '" content="' . esc_attr( $value ) . '">' . "\n";
			}
		}

		$twitter = array(
			'twitter:card'        => $image ? 'summary_large_image' : 'summary',
			'twitter:title'       => $title,
			'twitter:description' => $description,
			'twitter:image'       => $image,
		);
		foreach ( $twitter as $key => $value ) {
			if ( $value ) {
				echo '<meta name="' . esc_attr( $key ) . '" content="' . esc_attr( $value ) . '">' . "\n";
			}
		}

		if ( is_front_page() ) {
			$same = array_values( array_filter( array( greenline_opt( 'gl_social_facebook' ), greenline_opt( 'gl_social_instagram' ), greenline_opt( 'gl_social_youtube' ) ) ) );
			$business = array_filter(
				array(
					'@context'  => 'https://schema.org',
					'@type'     => 'LocalBusiness',
					'@id'       => home_url( '/#business' ),
					'name'      => get_bloginfo( 'name' ),
					'url'       => home_url( '/' ),
					'telephone' => greenline_opt( 'gl_phone_display' ),
					'email'     => greenline_opt( 'gl_contact_email' ),
					'image'     => $image,
					'address'   => array(
						'@type'         => 'PostalAddress',
						'streetAddress' => greenline_opt( 'gl_contact_address' ),
					),
					'sameAs'    => $same,
				)
			);
			echo '<script type="application/ld+json">' . wp_json_encode( $business, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP ) . '</script>' . "\n";
			echo '<script type="application/ld+json">' . wp_json_encode(
				array_filter(
					array(
						'@context' => 'https://schema.org',
						'@type'    => 'WebSite',
						'name'     => get_bloginfo( 'name' ),
						'url'      => home_url( '/' ),
					)
				),
				JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP
			) . '</script>' . "\n";
		}
	},
	1
);
