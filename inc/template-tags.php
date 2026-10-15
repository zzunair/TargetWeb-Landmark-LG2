<?php
/**
 * Small reusable output helpers.
 *
 * @package Greenline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Render a dashicon by name, e.g. greenline_icon( 'tag' ).
 */
function greenline_icon( $name, $class = '' ) {
	if ( empty( $name ) ) return;
	echo '<span class="dashicons dashicons-' . esc_attr( $name ) . ' ' . esc_attr( $class ) . '"></span>';
}

/**
 * Star rating markup, 1–5.
 */
function greenline_stars( $rating = 5 ) {
	$rating = max( 1, min( 5, (int) $rating ) );
	$out = '<span class="gl-stars" aria-label="' . esc_attr( $rating ) . ' out of 5 stars">';
	for ( $i = 1; $i <= 5; $i++ ) {
		$out .= '<span class="dashicons dashicons-star-filled ' . ( $i <= $rating ? 'is-filled' : 'is-empty' ) . '"></span>';
	}
	$out .= '</span>';
	echo $out;
}

/**
 * Footer / header social icon links, only prints icons that have a URL set.
 */
function greenline_social_icons() {
	$socials = array(
		'facebook'  => array( greenline_opt( 'gl_social_facebook' ), 'facebook-alt' ),
		'instagram' => array( greenline_opt( 'gl_social_instagram' ), 'instagram' ),
		'youtube'   => array( greenline_opt( 'gl_social_youtube' ), 'youtube' ),
	);
	foreach ( $socials as $key => $data ) {
		list( $url, $icon ) = $data;
		if ( empty( $url ) ) continue;
		printf(
			'<a class="gl-social-icon" href="%s" target="_blank" rel="noopener noreferrer" aria-label="%s"><span class="dashicons dashicons-%s"></span></a>',
			esc_url( $url ),
			esc_attr( ucfirst( $key ) ),
			esc_attr( $icon )
		);
	}
}

/**
 * Safe accessor for post meta with a fallback.
 */
function greenline_meta( $post_id, $key, $default = '' ) {
	$val = get_post_meta( $post_id, $key, true );
	return ( '' === $val || false === $val ) ? $default : $val;
}
