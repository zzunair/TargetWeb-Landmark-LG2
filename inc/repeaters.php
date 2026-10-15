<?php
/**
 * Default content + helpers for every repeater block on the homepage.
 * Because the defaults are baked in here, the site shows a fully built
 * demo page the moment the theme is activated — no import step required.
 * Everything is then editable from Appearance > Customize.
 *
 * @package Greenline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Read + decode a repeater setting. Always returns an array.
 */
function greenline_get_repeater( $key ) {
	$raw = get_theme_mod( $key, '' );
	if ( empty( $raw ) ) return array();
	$data = json_decode( $raw, true );
	return is_array( $data ) ? $data : array();
}

/**
 * Default data sets — these double as the Customizer setting defaults,
 * so the homepage is fully populated on first activation.
 */
function greenline_default_categories() {
	$img = GREENLINE_URI . '/assets/images/categories/';
	return array(
		array( 'title' => 'Zero-Turn Mowers', 'badge' => 'Best Seller', 'link' => '#equipment', 'image' => $img . 'zero-turn-mowers.svg' ),
		array( 'title' => 'Riding Mowers',     'badge' => '',            'link' => '#equipment', 'image' => $img . 'riding-mowers.svg' ),
		array( 'title' => 'Push Mowers',       'badge' => '',            'link' => '#equipment', 'image' => $img . 'push-mowers.svg' ),
		array( 'title' => 'Chainsaws',         'badge' => '',            'link' => '#equipment', 'image' => $img . 'chainsaws.svg' ),
		array( 'title' => 'Trimmers',          'badge' => '',            'link' => '#equipment', 'image' => $img . 'trimmers.svg' ),
		array( 'title' => 'Leaf Blowers',      'badge' => '',            'link' => '#equipment', 'image' => $img . 'leaf-blowers.svg' ),
		array( 'title' => 'Generators',        'badge' => 'New',         'link' => '#equipment', 'image' => $img . 'generators.svg' ),
		array( 'title' => 'Utility Vehicles',  'badge' => '',            'link' => '#equipment', 'image' => $img . 'utility-vehicles.svg' ),
		array( 'title' => 'Snow Equipment',    'badge' => 'Seasonal',    'link' => '#equipment', 'image' => $img . 'snow-equipment.svg' ),
	);
}

function greenline_default_services() {
	return array(
		array( 'title' => 'Equipment Sales', 'description' => 'Expert guidance to match you with the right machine for your property or crew.', 'icon' => 'tag', 'icon_image' => '', 'link' => '#' ),
		array( 'title' => 'Equipment Service', 'description' => 'Factory-trained technicians handling tune-ups, diagnostics, and repairs.', 'icon' => 'admin-tools', 'icon_image' => '', 'link' => '#' ),
		array( 'title' => 'Parts Department', 'description' => 'Genuine OEM parts, in-stock and ready — with fast special-order options.', 'icon' => 'yes-alt', 'icon_image' => '', 'link' => '#' ),
		array( 'title' => 'Financing', 'description' => 'Flexible monthly payments with quick approval for qualified buyers.', 'icon' => 'money-alt', 'icon_image' => '', 'link' => '#' ),
		array( 'title' => 'Pickup & Delivery', 'description' => 'We come to you. Free local pickup on qualifying service tickets.', 'icon' => 'car', 'icon_image' => '', 'link' => '#' ),
		array( 'title' => 'Seasonal Maintenance', 'description' => 'Spring startups, winterization, and preventive plans to protect your investment.', 'icon' => 'admin-generic', 'icon_image' => '', 'link' => '#' ),
	);
}

function greenline_default_features() {
	return array(
		array( 'title' => 'Experienced Team', 'description' => 'Decades of combined expertise on the sales floor and in the shop.', 'icon' => 'groups', 'icon_image' => '' ),
		array( 'title' => 'Honest Advice', 'description' => 'We recommend what fits your job — not what pads a sale.', 'icon' => 'yes', 'icon_image' => '' ),
		array( 'title' => 'Competitive Pricing', 'description' => 'Fair, transparent pricing on new equipment, parts, and labor.', 'icon' => 'tag', 'icon_image' => '' ),
		array( 'title' => 'Large Inventory', 'description' => 'Hundreds of units in stock across every major category.', 'icon' => 'awards', 'icon_image' => '' ),
		array( 'title' => 'Fast Turnaround', 'description' => 'Most repairs completed in 3–5 business days.', 'icon' => 'performance', 'icon_image' => '' ),
		array( 'title' => 'Local Support', 'description' => 'Real people, right here in your community — for the life of your machine.', 'icon' => 'location-alt', 'icon_image' => '' ),
	);
}

function greenline_default_testimonials() {
	$img = GREENLINE_URI . '/assets/images/avatars/';
	return array(
		array( 'name' => 'Mark Delaney', 'role' => 'Homeowner', 'rating' => 5, 'quote' => 'Bought my zero-turn here two years ago and just brought it back for its first service. Same friendly faces, no upsell nonsense. This is how a local dealer should feel.', 'image' => $img . 'avatar-1.svg' ),
		array( 'name' => 'Denise Coyle', 'role' => 'Landscaping Contractor', 'rating' => 5, 'quote' => 'We run six machines through Greenline for fleet service. Fast turnaround and they always call before doing anything extra.', 'image' => $img . 'avatar-2.svg' ),
		array( 'name' => 'Robert Kim', 'role' => 'Homeowner', 'rating' => 5, 'quote' => "Financing was approved same day and delivery was free. Couldn't ask for an easier buying experience.", 'image' => $img . 'avatar-3.svg' ),
	);
}

function greenline_default_faqs() {
	return array(
		array( 'question' => "Do you service equipment you didn't sell me?", 'answer' => 'Absolutely. Our technicians work on most major brands, whether you bought locally, online, or years ago from someone else.' ),
		array( 'question' => 'How does financing approval work?', 'answer' => 'Most applications are approved within 24 hours. We work with several lenders to find 0% APR and low-payment options for qualified buyers.' ),
		array( 'question' => 'Do you deliver equipment to my property?', 'answer' => 'Yes — free local delivery is included on most new equipment purchases and qualifying service tickets.' ),
		array( 'question' => 'What brands do you carry?', 'answer' => "We stock 40+ trusted brands across mowers, chainsaws, generators, UTVs, and more. Ask us if you don't see your brand online." ),
		array( 'question' => 'How long do repairs typically take?', 'answer' => 'Most repairs are completed in 3–5 business days. Rush service is available for urgent seasonal needs.' ),
		array( 'question' => 'Do you take trade-ins?', 'answer' => 'Yes, we evaluate trade-ins on the spot and apply the value toward your new purchase.' ),
	);
}

/* ---------------------------------------------------------------
 * Sanitizers — each repeater knows its own field types so line
 * breaks (textarea) survive while everything else stays plain text.
 * --------------------------------------------------------------- */

function greenline_sanitize_categories_repeater( $json ) {
	$rows = json_decode( $json, true );
	if ( ! is_array( $rows ) ) return wp_json_encode( array() );
	$allowed_badges = array( '', 'Best Seller', 'New', 'Seasonal' );
	$clean = array();
	foreach ( $rows as $row ) {
		$clean[] = array(
			'title' => sanitize_text_field( $row['title'] ?? '' ),
			'badge' => in_array( $row['badge'] ?? '', $allowed_badges, true ) ? $row['badge'] : '',
			'link'  => sanitize_text_field( $row['link'] ?? '#' ),
			'image' => esc_url_raw( $row['image'] ?? '' ),
		);
	}
	return wp_json_encode( $clean );
}

function greenline_sanitize_services_repeater( $json ) {
	$rows = json_decode( $json, true );
	if ( ! is_array( $rows ) ) return wp_json_encode( array() );
	$clean = array();
	foreach ( $rows as $row ) {
		$clean[] = array(
			'title'       => sanitize_text_field( $row['title'] ?? '' ),
			'description' => sanitize_textarea_field( $row['description'] ?? '' ),
			'icon'        => sanitize_html_class( $row['icon'] ?? '' ),
			'icon_image'  => esc_url_raw( $row['icon_image'] ?? '' ),
			'link'        => sanitize_text_field( $row['link'] ?? '#' ),
		);
	}
	return wp_json_encode( $clean );
}

function greenline_sanitize_features_repeater( $json ) {
	$rows = json_decode( $json, true );
	if ( ! is_array( $rows ) ) return wp_json_encode( array() );
	$clean = array();
	foreach ( $rows as $row ) {
		$clean[] = array(
			'title'       => sanitize_text_field( $row['title'] ?? '' ),
			'description' => sanitize_textarea_field( $row['description'] ?? '' ),
			'icon'        => sanitize_html_class( $row['icon'] ?? '' ),
			'icon_image'  => esc_url_raw( $row['icon_image'] ?? '' ),
		);
	}
	return wp_json_encode( $clean );
}

function greenline_sanitize_testimonials_repeater( $json ) {
	$rows = json_decode( $json, true );
	if ( ! is_array( $rows ) ) return wp_json_encode( array() );
	$clean = array();
	foreach ( $rows as $row ) {
		$clean[] = array(
			'name'   => sanitize_text_field( $row['name'] ?? '' ),
			'role'   => sanitize_text_field( $row['role'] ?? '' ),
			'rating' => max( 1, min( 5, intval( $row['rating'] ?? 5 ) ) ),
			'quote'  => sanitize_textarea_field( $row['quote'] ?? '' ),
			'image'  => esc_url_raw( $row['image'] ?? '' ),
		);
	}
	return wp_json_encode( $clean );
}

function greenline_sanitize_faqs_repeater( $json ) {
	$rows = json_decode( $json, true );
	if ( ! is_array( $rows ) ) return wp_json_encode( array() );
	$clean = array();
	foreach ( $rows as $row ) {
		$clean[] = array(
			'question' => sanitize_text_field( $row['question'] ?? '' ),
			'answer'   => sanitize_textarea_field( $row['answer'] ?? '' ),
		);
	}
	return wp_json_encode( $clean );
}

/**
 * Curated icon set offered in every icon-picker field — kept small and
 * on-brand rather than dumping all ~300 Dashicons on a non-technical user.
 * An empty string is always offered too, rendered as "None" — that's how
 * someone removes an icon entirely.
 */
function greenline_icon_choices() {
	return array(
		'tag', 'admin-tools', 'yes-alt', 'money-alt', 'car', 'admin-generic',
		'groups', 'yes', 'awards', 'performance', 'location-alt', 'shield',
		'star-filled', 'admin-home', 'phone', 'email', 'clock', 'chart-bar',
		'lightbulb', 'forklift', 'store', 'admin-users', 'flag', 'thumbs-up',
	);
}

/* ---------------------------------------------------------------
 * Homepage section order / visibility — lets the whole page be
 * rearranged or have sections hidden, entirely from the Customizer.
 * --------------------------------------------------------------- */

/**
 * Master list of every homepage section: id => label + its template part.
 * "hero" is intentionally not removable from this list's meaning — it can
 * still be toggled off if truly wanted, nothing is hard-locked.
 */
function greenline_section_registry() {
	return array(
		'hero'          => array( 'label' => 'Hero',                        'template' => 'hero' ),
		'trust_bar'     => array( 'label' => 'Trust Bar (dark strip)',       'template' => 'trust-bar' ),
		'categories'    => array( 'label' => 'Equipment Categories',        'template' => 'categories' ),
		'services'      => array( 'label' => 'Services ("What We Do")',     'template' => 'services' ),
		'why_choose_us' => array( 'label' => 'Why Choose Us',                'template' => 'why-choose-us' ),
		'financing'     => array( 'label' => 'Financing CTA',                'template' => 'financing' ),
		'testimonials'  => array( 'label' => 'Testimonials',                'template' => 'testimonials' ),
		'service_cta'   => array( 'label' => 'Service & Repair Band',        'template' => 'service-cta' ),
		'faq'           => array( 'label' => 'FAQ',                         'template' => 'faq' ),
		'quote_form'    => array( 'label' => 'Free Quote Form',             'template' => 'quote-form' ),
		'showroom'      => array( 'label' => 'Showroom / Contact',          'template' => 'showroom' ),
	);
}

function greenline_default_section_order() {
	$order = array();
	foreach ( array_keys( greenline_section_registry() ) as $id ) {
		$order[] = array( 'id' => $id, 'enabled' => true );
	}
	return $order;
}

/**
 * Returns the section order as a clean list of ['id'=>..,'enabled'=>bool],
 * guaranteed to contain every known section exactly once (adds any missing
 * ones — e.g. after a theme update introduces a new section — at the end).
 */
function greenline_get_section_order() {
	$raw = get_theme_mod( 'gl_section_order', '' );
	$saved = json_decode( $raw, true );
	$registry = greenline_section_registry();

	if ( ! is_array( $saved ) ) {
		return greenline_default_section_order();
	}

	$seen = array();
	$clean = array();
	foreach ( $saved as $row ) {
		$id = $row['id'] ?? '';
		if ( ! isset( $registry[ $id ] ) || isset( $seen[ $id ] ) ) continue;
		$seen[ $id ] = true;
		$clean[] = array( 'id' => $id, 'enabled' => ! empty( $row['enabled'] ) );
	}
	foreach ( array_keys( $registry ) as $id ) {
		if ( ! isset( $seen[ $id ] ) ) {
			$clean[] = array( 'id' => $id, 'enabled' => true );
		}
	}
	return $clean;
}

function greenline_sanitize_section_order( $json ) {
	$rows = json_decode( $json, true );
	$registry = greenline_section_registry();
	if ( ! is_array( $rows ) ) return wp_json_encode( greenline_default_section_order() );

	$seen = array();
	$clean = array();
	foreach ( $rows as $row ) {
		$id = sanitize_key( $row['id'] ?? '' );
		if ( ! isset( $registry[ $id ] ) || isset( $seen[ $id ] ) ) continue;
		$seen[ $id ] = true;
		$clean[] = array( 'id' => $id, 'enabled' => ! empty( $row['enabled'] ) );
	}
	foreach ( array_keys( $registry ) as $id ) {
		if ( ! isset( $seen[ $id ] ) ) {
			$clean[] = array( 'id' => $id, 'enabled' => true );
		}
	}
	return wp_json_encode( $clean );
}
