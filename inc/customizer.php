<?php
/**
 * Greenline Customizer
 * A deep, user-friendly Customizer covering every editable piece of the
 * front page — colors, hero copy, stats, financing box, service CTA,
 * showroom, footer, contact info — with zero code required to run the site.
 *
 * @package Greenline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once GREENLINE_DIR . '/inc/class-repeater-control.php';
require_once GREENLINE_DIR . '/inc/class-section-order-control.php';

/**
 * Register one repeater block: a setting holding JSON + its Greenline_Repeater_Control.
 */
function greenline_register_repeater( $wp_customize, $section, $setting_id, $default, $sanitize_cb, $schema, $item_label, $label, $priority = 10, $max_items = 0 ) {
	$wp_customize->add_setting( $setting_id, array(
		'default'           => wp_json_encode( $default ),
		'sanitize_callback'  => $sanitize_cb,
		'transport'          => 'refresh',
	) );
	$wp_customize->add_control( new Greenline_Repeater_Control( $wp_customize, $setting_id, array(
		'section'    => $section,
		'label'      => $label,
		'schema'     => $schema,
		'item_label' => $item_label,
		'priority'   => $priority,
		'max_items'  => $max_items,
	) ) );
}

/**
 * Small helper: register a batch of simple text/textarea/url settings in one go.
 *
 * @param WP_Customize_Manager $wp_customize
 * @param string $section
 * @param array  $fields  id => [label, default, type(text|textarea|url|number), description]
 */
function greenline_register_fields( $wp_customize, $section, $fields, $priority_start = 10 ) {
	$i = $priority_start;
	foreach ( $fields as $id => $f ) {
		$type    = isset( $f['type'] ) ? $f['type'] : 'text';
		// Central defaults file wins so the Customizer and the front end can
		// never show two different "default" values for the same field.
		$default = greenline_text_default( $id );
		if ( '' === $default && isset( $f['default'] ) ) {
			$default = $f['default'];
		}
		$sanitize = 'sanitize_text_field';
		if ( 'textarea' === $type ) $sanitize = 'sanitize_textarea_field';
		if ( 'url' === $type )      $sanitize = 'esc_url_raw';
		if ( 'number' === $type )   $sanitize = 'absint';
		if ( 'email' === $type )    $sanitize = 'sanitize_email';

		$wp_customize->add_setting( $id, array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
			'transport'         => 'refresh',
		) );

		$control_type = ( 'textarea' === $type ) ? 'textarea' : ( 'number' === $type ? 'number' : 'text' );

		$wp_customize->add_control( $id, array(
			'label'       => $f['label'],
			'section'     => $section,
			'type'        => $control_type,
			'description' => isset( $f['description'] ) ? $f['description'] : '',
			'priority'    => $i,
		) );
		$i += 10;
	}
}

function greenline_customize_register( $wp_customize ) {

	/* ================= PANEL ================= */
	$wp_customize->add_panel( 'greenline_panel', array(
		'title'       => __( '⚙ TargetWeb - Landmark Theme Options', 'greenline' ),
		'description' => __( 'Every section of the homepage is editable here — no code needed. Repeatable content (categories, services, testimonials, FAQs) lives under their own menu items in the sidebar.', 'greenline' ),
		'priority'    => 1,
	) );

	/* ================= HOMEPAGE SECTION ORDER ================= */
	$wp_customize->add_section( 'gl_sec_order', array(
		'title'       => __( '↕ Homepage Section Order', 'greenline' ),
		'panel'       => 'greenline_panel',
		'priority'    => 2,
		'description' => __( 'Drag with the ↑ / ↓ buttons to reorder the homepage, or uncheck a section to hide it completely.', 'greenline' ),
	) );
	$section_items = array();
	foreach ( greenline_section_registry() as $id => $info ) {
		$section_items[ $id ] = $info['label'];
	}
	$wp_customize->add_setting( 'gl_section_order', array(
		'default'           => wp_json_encode( greenline_default_section_order() ),
		'sanitize_callback' => 'greenline_sanitize_section_order',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new Greenline_Section_Order_Control( $wp_customize, 'gl_section_order', array(
		'section' => 'gl_sec_order',
		'label'   => __( 'Section Order', 'greenline' ),
		'items'   => $section_items,
	) ) );

	/* ================= COLORS ================= */
	$wp_customize->add_section( 'gl_sec_colors', array(
		'title' => __( 'Colors', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 5,
	) );
	$colors = array(
		'gl_color_cream'       => array( 'Background — Cream',        '#F6F4EC' ),
		'gl_color_cream_alt'   => array( 'Background — Section Alt',  '#EDF0E8' ),
		'gl_color_dark'        => array( 'Header / Footer — Dark',    '#152018' ),
		'gl_color_green'       => array( 'Primary Green (buttons)',   '#1F3D2A' ),
		'gl_color_green_bright'=> array( 'Bright Green (accent text)','#3EA65A' ),
		'gl_color_orange'      => array( 'Orange (badges / financing)','#E8792D' ),
		'gl_color_text'        => array( 'Body Text',                 '#1A1D18' ),
		'gl_color_text_light'  => array( 'Muted / Secondary Text',    '#6B7066' ),
		'gl_color_border'      => array( 'Borders / Dividers',        '#E2E4DB' ),
	);
	$p = 10;
	foreach ( $colors as $id => $c ) {
		$wp_customize->add_setting( $id, array( 'default' => $c[1], 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'refresh' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
			'label' => $c[0], 'section' => 'gl_sec_colors', 'priority' => $p,
		) ) );
		$p += 10;
	}

	/* ================= HEADER ================= */
	$wp_customize->add_section( 'gl_sec_header', array( 'title' => __( 'Header', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 10 ) );
	greenline_register_fields( $wp_customize, 'gl_sec_header', array(
		'gl_header_since_badge' => array( 'label' => 'Top badge text', 'default' => '✦ Family-Owned Since 1998' ),
		'gl_phone_display' => array( 'label' => 'Phone number (displayed)', 'default' => '(555) 412-9087' ),
		'gl_phone_link'    => array( 'label' => 'Phone number (tel: link, digits only)', 'default' => '5554129087' ),
		'gl_header_cta_text' => array( 'label' => 'Header button text', 'default' => 'Request a Quote' ),
		'gl_header_cta_link' => array( 'label' => 'Header button link', 'default' => '#quote', 'type' => 'url' ),
	) );

	/* ================= HERO ================= */
	$wp_customize->add_section( 'gl_sec_hero', array( 'title' => __( 'Hero Section', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 15 ) );
	greenline_register_fields( $wp_customize, 'gl_sec_hero', array(
		'gl_hero_badge'       => array( 'label' => 'Eyebrow badge', 'default' => 'Family-Owned Since 1998' ),
		'gl_hero_heading_pre' => array( 'label' => 'Heading — plain part before highlight', 'default' => 'Your Local ' ),
		'gl_hero_heading_hl'  => array( 'label' => 'Heading — highlighted part (bright green)', 'default' => 'Outdoor Power' ),
		'gl_hero_heading_post'=> array( 'label' => 'Heading — plain part after highlight', 'default' => ' Equipment Experts' ),
		'gl_hero_subtext'     => array( 'label' => 'Subheading paragraph', 'type' => 'textarea', 'default' => 'From residential lawn care to commercial landscaping equipment, we help you find the right machine — backed by expert service and flexible financing.' ),
		'gl_hero_btn1_text'   => array( 'label' => 'Primary button text', 'default' => 'Request a Free Quote' ),
		'gl_hero_btn1_link'   => array( 'label' => 'Primary button link', 'default' => '#quote', 'type' => 'url' ),
		'gl_hero_btn2_text'   => array( 'label' => 'Secondary button text', 'default' => 'Schedule a Visit' ),
		'gl_hero_btn2_link'   => array( 'label' => 'Secondary button link', 'default' => '#contact', 'type' => 'url' ),
		'gl_hero_rating_value'=> array( 'label' => 'Rating value', 'default' => '4.9' ),
		'gl_hero_rating_count'=> array( 'label' => 'Review count text', 'default' => '1,240 reviews' ),
		'gl_hero_guarantee'   => array( 'label' => 'Guarantee badge — small label', 'default' => 'Backed by our' ),
		'gl_hero_guarantee_bold' => array( 'label' => 'Guarantee badge — bold text', 'default' => '2-Year Service Guarantee' ),
		'gl_stat1_number' => array( 'label' => 'Stat 1 — number', 'default' => '25+' ),
		'gl_stat1_label'  => array( 'label' => 'Stat 1 — label', 'default' => 'Years Local' ),
		'gl_stat2_number' => array( 'label' => 'Stat 2 — number', 'default' => '12,000+' ),
		'gl_stat2_label'  => array( 'label' => 'Stat 2 — label', 'default' => 'Happy Customers' ),
		'gl_stat3_number' => array( 'label' => 'Stat 3 — number', 'default' => '40+' ),
		'gl_stat3_label'  => array( 'label' => 'Stat 3 — label', 'default' => 'Top Brands' ),
	) );
	$wp_customize->add_setting( 'gl_hero_image', array( 'default' => greenline_text_default( 'gl_hero_image' ), 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'gl_hero_image', array(
		'label' => __( 'Hero photo', 'greenline' ), 'section' => 'gl_sec_hero', 'priority' => 200,
	) ) );

	/* ================= TRUST BAR ================= */
	$wp_customize->add_section( 'gl_sec_trustbar', array( 'title' => __( 'Trust Bar (dark strip)', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 20 ) );
	$trust_defaults = array(
		array( 'groups', 'Family-Owned' ),
		array( 'money', 'Financing Available' ),
		array( 'awards', 'Certified Technicians' ),
		array( 'yes-alt', 'Genuine OEM Parts' ),
		array( 'performance', 'Fast Repairs' ),
		array( 'tag', 'Top Brands' ),
	);
	$fields = array();
	foreach ( $trust_defaults as $i => $t ) {
		$n = $i + 1;
		$fields["gl_trust_icon_$n"] = array( 'label' => "Item $n — dashicon name", 'default' => $t[0] );
		$fields["gl_trust_text_$n"] = array( 'label' => "Item $n — text", 'default' => $t[1] );
	}
	greenline_register_fields( $wp_customize, 'gl_sec_trustbar', $fields );

	/* ================= SECTION HEADERS ================= */
	$wp_customize->add_section( 'gl_sec_headings', array( 'title' => __( 'Section Titles', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 25 ) );
	greenline_register_fields( $wp_customize, 'gl_sec_headings', array(
		'gl_cat_eyebrow' => array( 'label' => 'Categories — eyebrow', 'default' => 'Shop by Category' ),
		'gl_cat_heading' => array( 'label' => 'Categories — heading', 'default' => 'Equipment for every job, every season' ),
		'gl_cat_sub'     => array( 'label' => 'Categories — subtext', 'type' => 'textarea', 'default' => 'Browse our full lineup of residential and commercial-grade outdoor power equipment from the brands you trust.' ),
		'gl_svc_eyebrow' => array( 'label' => 'Services — eyebrow', 'default' => 'What We Do' ),
		'gl_svc_heading' => array( 'label' => 'Services — heading', 'default' => 'A full-service dealership under one roof' ),
		'gl_feat_eyebrow'=> array( 'label' => 'Why Choose Us — eyebrow', 'default' => 'Why Choose Us' ),
		'gl_feat_heading'=> array( 'label' => 'Why Choose Us — heading', 'default' => 'Neighbors who happen to know equipment' ),
		'gl_test_eyebrow'=> array( 'label' => 'Testimonials — eyebrow', 'default' => 'Testimonials' ),
		'gl_test_heading'=> array( 'label' => 'Testimonials — heading', 'default' => 'Trusted by neighbors, contractors, and pros' ),
		'gl_faq_eyebrow' => array( 'label' => 'FAQ — eyebrow', 'default' => 'FAQ' ),
		'gl_faq_heading' => array( 'label' => 'FAQ — heading', 'default' => 'Answers to common questions' ),
		'gl_quote_eyebrow'=> array( 'label' => 'Quote form — eyebrow', 'default' => 'Free Quote' ),
		'gl_quote_heading'=> array( 'label' => 'Quote form — heading', 'default' => "Tell us what you're looking for" ),
		'gl_quote_sub'   => array( 'label' => 'Quote form — subtext', 'type' => 'textarea', 'default' => 'Share a few details and one of our specialists will follow up within one business day with the right equipment options, pricing, and financing terms — no pressure.' ),
	) );

	/* ================= EQUIPMENT CATEGORIES (repeater) ================= */
	$wp_customize->add_section( 'gl_sec_categories', array( 'title' => __( '🧩 Equipment Categories', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 27,
		'description' => __( 'Add, remove, and reorder the category tiles shown in "Shop by Category." Click a row to expand it.', 'greenline' ) ) );
	greenline_register_repeater( $wp_customize, 'gl_sec_categories', 'gl_categories_repeater', greenline_default_categories(), 'greenline_sanitize_categories_repeater',
		array(
			array( 'key' => 'title', 'label' => 'Name', 'type' => 'text' ),
			array( 'key' => 'image', 'label' => 'Photo', 'type' => 'image' ),
			array( 'key' => 'badge', 'label' => 'Badge', 'type' => 'select', 'options' => array( '', 'Best Seller', 'New', 'Seasonal' ) ),
			array( 'key' => 'link', 'label' => 'Link', 'type' => 'url' ),
		),
		'Category', __( 'Categories', 'greenline' ), 10, 24
	);

	/* ================= SERVICES (repeater) ================= */
	$wp_customize->add_section( 'gl_sec_services_repeater', array( 'title' => __( '🧩 Services ("What We Do")', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 28,
		'description' => __( 'Add, remove, and reorder the 6 service cards.', 'greenline' ) ) );
	greenline_register_repeater( $wp_customize, 'gl_sec_services_repeater', 'gl_services_repeater', greenline_default_services(), 'greenline_sanitize_services_repeater',
		array(
			array( 'key' => 'title', 'label' => 'Title', 'type' => 'text' ),
			array( 'key' => 'description', 'label' => 'Description', 'type' => 'textarea' ),
			array( 'key' => 'icon', 'label' => 'Icon (choose "None" to remove it)', 'type' => 'icon' ),
			array( 'key' => 'icon_image', 'label' => 'Or upload a custom icon image (overrides the icon above)', 'type' => 'image' ),
			array( 'key' => 'link', 'label' => 'Link', 'type' => 'url' ),
		),
		'Service', __( 'Services', 'greenline' ), 10, 12
	);

	/* ================= WHY CHOOSE US (repeater) ================= */
	$wp_customize->add_section( 'gl_sec_features_repeater', array( 'title' => __( '🧩 Why Choose Us Tiles', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 29,
		'description' => __( 'Add, remove, and reorder the feature tiles.', 'greenline' ) ) );
	greenline_register_repeater( $wp_customize, 'gl_sec_features_repeater', 'gl_features_repeater', greenline_default_features(), 'greenline_sanitize_features_repeater',
		array(
			array( 'key' => 'title', 'label' => 'Title', 'type' => 'text' ),
			array( 'key' => 'description', 'label' => 'Description', 'type' => 'textarea' ),
			array( 'key' => 'icon', 'label' => 'Icon (choose "None" to remove it)', 'type' => 'icon' ),
			array( 'key' => 'icon_image', 'label' => 'Or upload a custom icon image (overrides the icon above)', 'type' => 'image' ),
		),
		'Feature', __( 'Features', 'greenline' ), 10, 12
	);

	/* ================= TESTIMONIALS (repeater) ================= */
	$wp_customize->add_section( 'gl_sec_testimonials_repeater', array( 'title' => __( '🧩 Testimonials', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 33,
		'description' => __( 'Add, remove, and reorder customer testimonials shown in the slider.', 'greenline' ) ) );
	greenline_register_repeater( $wp_customize, 'gl_sec_testimonials_repeater', 'gl_testimonials_repeater', greenline_default_testimonials(), 'greenline_sanitize_testimonials_repeater',
		array(
			array( 'key' => 'name', 'label' => 'Client Name', 'type' => 'text' ),
			array( 'key' => 'role', 'label' => 'Role / Title', 'type' => 'text' ),
			array( 'key' => 'rating', 'label' => 'Rating (1–5)', 'type' => 'number' ),
			array( 'key' => 'quote', 'label' => 'Quote', 'type' => 'textarea' ),
			array( 'key' => 'image', 'label' => 'Photo', 'type' => 'image' ),
		),
		'Testimonial', __( 'Testimonials', 'greenline' ), 10, 10
	);

	/* ================= FAQs (repeater) ================= */
	$wp_customize->add_section( 'gl_sec_faqs_repeater', array( 'title' => __( '🧩 FAQs', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 37,
		'description' => __( 'Add, remove, and reorder frequently asked questions.', 'greenline' ) ) );
	greenline_register_repeater( $wp_customize, 'gl_sec_faqs_repeater', 'gl_faqs_repeater', greenline_default_faqs(), 'greenline_sanitize_faqs_repeater',
		array(
			array( 'key' => 'question', 'label' => 'Question', 'type' => 'text' ),
			array( 'key' => 'answer', 'label' => 'Answer', 'type' => 'textarea' ),
		),
		'FAQ', __( 'FAQs', 'greenline' ), 10, 16
	);

	/* ================= FINANCING CTA ================= */
	$wp_customize->add_section( 'gl_sec_financing', array( 'title' => __( 'Financing CTA', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 30 ) );
	greenline_register_fields( $wp_customize, 'gl_sec_financing', array(
		'gl_fin_badge'    => array( 'label' => 'Eyebrow badge', 'default' => 'Flexible Financing' ),
		'gl_fin_heading'  => array( 'label' => 'Heading', 'default' => 'Bring home the right equipment. Pay for it your way.' ),
		'gl_fin_sub'      => array( 'label' => 'Subtext', 'type' => 'textarea', 'default' => 'Choose from low monthly payments, seasonal deferrals, and 0% APR promotions on qualifying models. Approvals in minutes, not days.' ),
		'gl_fin_stat1_v'  => array( 'label' => 'Stat 1 value', 'default' => '0%' ),
		'gl_fin_stat1_l'  => array( 'label' => 'Stat 1 label', 'default' => 'APR available' ),
		'gl_fin_stat2_v'  => array( 'label' => 'Stat 2 value', 'default' => '60mo' ),
		'gl_fin_stat2_l'  => array( 'label' => 'Stat 2 label', 'default' => 'Terms up to' ),
		'gl_fin_stat3_v'  => array( 'label' => 'Stat 3 value', 'default' => '24hr' ),
		'gl_fin_stat3_l'  => array( 'label' => 'Stat 3 label', 'default' => 'Fast approval' ),
		'gl_fin_stat4_v'  => array( 'label' => 'Stat 4 value', 'default' => '$0' ),
		'gl_fin_stat4_l'  => array( 'label' => 'Stat 4 label', 'default' => 'Down options' ),
		'gl_fin_btn1_text'=> array( 'label' => 'Button 1 text', 'default' => 'Apply for Financing' ),
		'gl_fin_btn1_link'=> array( 'label' => 'Button 1 link', 'default' => '#quote', 'type' => 'url' ),
		'gl_fin_btn2_text'=> array( 'label' => 'Button 2 text', 'default' => 'Talk to us' ),
		'gl_fin_btn2_link'=> array( 'label' => 'Button 2 link', 'default' => 'tel:5554129087', 'type' => 'url' ),
	) );

	/* ================= SERVICE CTA (repair band) ================= */
	$wp_customize->add_section( 'gl_sec_servicecta', array( 'title' => __( 'Service & Repair Band', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 35 ) );
	greenline_register_fields( $wp_customize, 'gl_sec_servicecta', array(
		'gl_sc_badge'   => array( 'label' => 'Eyebrow badge', 'default' => 'Service & Repair' ),
		'gl_sc_heading' => array( 'label' => 'Heading', 'default' => 'Keep your equipment running like the day you bought it' ),
		'gl_sc_body'    => array( 'label' => 'Body text', 'type' => 'textarea', 'default' => 'From routine tune-ups to major repairs, our certified technicians work on every brand we sell — and most that we don\'t. Book a spot before the busy season fills up.' ),
		'gl_sc_bullet1' => array( 'label' => 'Bullet 1', 'default' => 'Free pickup & delivery on qualifying tickets' ),
		'gl_sc_bullet2' => array( 'label' => 'Bullet 2', 'default' => 'Same-day diagnostic on most units' ),
		'gl_sc_bullet3' => array( 'label' => 'Bullet 3', 'default' => '90-day workmanship guarantee' ),
		'gl_sc_btn1_text' => array( 'label' => 'Button 1 text', 'default' => 'Schedule Service' ),
		'gl_sc_btn1_link' => array( 'label' => 'Button 1 link', 'default' => '#quote', 'type' => 'url' ),
		'gl_sc_btn2_text' => array( 'label' => 'Button 2 text', 'default' => 'Call the shop' ),
		'gl_sc_btn2_link' => array( 'label' => 'Button 2 link', 'default' => 'tel:5554129087', 'type' => 'url' ),
	) );
	$wp_customize->add_setting( 'gl_sc_image', array( 'default' => greenline_text_default( 'gl_sc_image' ), 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'gl_sc_image', array(
		'label' => __( 'Technician photo', 'greenline' ), 'section' => 'gl_sec_servicecta', 'priority' => 200,
	) ) );

	/* ================= CONTACT / QUOTE ================= */
	$wp_customize->add_section( 'gl_sec_contact', array( 'title' => __( 'Contact Info', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 40 ) );
	greenline_register_fields( $wp_customize, 'gl_sec_contact', array(
		'gl_contact_email' => array( 'label' => 'Contact email', 'type' => 'email', 'default' => 'hello@greenlinepower.com' ),
		'gl_contact_address' => array( 'label' => 'Street address', 'default' => '2140 Riverbend Rd, Springfield' ),
		'gl_form_recipient' => array( 'label' => 'Quote form sends to (email)', 'type' => 'email', 'default' => get_option( 'admin_email' ) ),
	) );

	/* ================= SHOWROOM ================= */
	$wp_customize->add_section( 'gl_sec_showroom', array( 'title' => __( 'Showroom Section', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 45 ) );
	greenline_register_fields( $wp_customize, 'gl_sec_showroom', array(
		'gl_show_badge'   => array( 'label' => 'Eyebrow badge', 'default' => 'Visit Us' ),
		'gl_show_heading' => array( 'label' => 'Heading', 'default' => 'Come see the showroom' ),
		'gl_show_meta'    => array( 'label' => 'Meta line under address', 'default' => 'Free parking · Wheelchair accessible' ),
		'gl_show_directions_link' => array( 'label' => 'Directions link (Google Maps URL)', 'default' => 'https://maps.google.com', 'type' => 'url' ),
		'gl_hours_weekday' => array( 'label' => 'Mon–Fri hours', 'default' => '7:30 AM – 6:00 PM' ),
		'gl_hours_saturday'=> array( 'label' => 'Saturday hours', 'default' => '8:00 AM – 4:00 PM' ),
		'gl_hours_sunday'  => array( 'label' => 'Sunday hours', 'default' => 'Closed' ),
	) );
	$wp_customize->add_setting( 'gl_show_image', array( 'default' => greenline_text_default( 'gl_show_image' ), 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'gl_show_image', array(
		'label' => __( 'Storefront photo', 'greenline' ), 'section' => 'gl_sec_showroom', 'priority' => 200,
	) ) );

	/* ================= FOOTER ================= */
	$wp_customize->add_section( 'gl_sec_footer', array( 'title' => __( 'Footer', 'greenline' ), 'panel' => 'greenline_panel', 'priority' => 50 ) );
	greenline_register_fields( $wp_customize, 'gl_sec_footer', array(
		'gl_footer_tagline' => array( 'label' => 'Tagline under logo', 'type' => 'textarea', 'default' => 'Your trusted local outdoor power equipment dealer, proudly serving the community since 1998.' ),
		'gl_footer_newsletter_heading' => array( 'label' => 'Newsletter heading', 'default' => 'Get Seasonal Offers' ),
		'gl_footer_newsletter_sub' => array( 'label' => 'Newsletter subtext', 'type' => 'textarea', 'default' => 'Financing specials, tune-up reminders, and dealer-only pricing — a few times a season.' ),
		'gl_footer_copyright' => array( 'label' => 'Copyright line', 'default' => '© ' . date( 'Y' ) . ' Greenline Power Equipment Co. All rights reserved.' ),
		'gl_social_facebook'  => array( 'label' => 'Facebook URL', 'type' => 'url', 'default' => '' ),
		'gl_social_instagram' => array( 'label' => 'Instagram URL', 'type' => 'url', 'default' => '' ),
		'gl_social_youtube'   => array( 'label' => 'YouTube URL', 'type' => 'url', 'default' => '' ),
	) );

	/* ================= SITE IDENTITY EXTRAS ================= */
	$wp_customize->add_setting( 'gl_site_tagline_small', array( 'default' => 'Power Equipment Co.', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'gl_site_tagline_small', array(
		'label' => __( 'Small text under logo name (header)', 'greenline' ), 'section' => 'title_tagline', 'type' => 'text', 'priority' => 25,
	) );
}
add_action( 'customize_register', 'greenline_customize_register' );
