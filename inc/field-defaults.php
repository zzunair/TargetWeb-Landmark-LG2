<?php
/**
 * Central default values for every plain text/textarea/url/number
 * Customizer field in the theme.
 *
 * WHY THIS FILE EXISTS: WordPress's Customizer has two independent
 * "default" concepts. add_setting(['default' => ...]) only feeds the
 * *Customizer preview* — it has no effect on a normal front-end page
 * load. On the front end, get_theme_mod($key, $fallback) uses whatever
 * $fallback you pass at that specific call site, and if a setting was
 * never actually saved to the database (e.g. the admin never opened
 * that particular field before clicking Publish), the front end has
 * nothing to show unless that call-site fallback matches.
 *
 * Keeping one authoritative array here — read by both
 * inc/customizer.php (for the Customizer UI) and greenline_opt() (for
 * every front-end template) — makes it impossible for the two to drift
 * apart, and guarantees a freshly-activated site is fully populated
 * everywhere, not just inside an open Customizer session.
 *
 * @package Greenline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function greenline_text_defaults() {
	static $defaults = null;
	if ( null !== $defaults ) return $defaults;

	$defaults = array(
		// Header
		'gl_header_since_badge' => '✦ Family-Owned Since 1998',
		'gl_phone_display'      => '(555) 412-9087',
		'gl_phone_link'         => '5554129087',
		'gl_header_cta_text'    => 'Request a Quote',
		'gl_header_cta_link'    => '#quote',
		'gl_site_tagline_small' => 'Power Equipment Co.',

		// Hero
		'gl_hero_badge'          => 'Family-Owned Since 1998',
		'gl_hero_heading_pre'    => 'Your Local ',
		'gl_hero_heading_hl'     => 'Outdoor Power',
		'gl_hero_heading_post'   => ' Equipment Experts',
		'gl_hero_subtext'        => 'From residential lawn care to commercial landscaping equipment, we help you find the right machine — backed by expert service and flexible financing.',
		'gl_hero_btn1_text'      => 'Request a Free Quote',
		'gl_hero_btn1_link'      => '#quote',
		'gl_hero_btn2_text'      => 'Schedule a Visit',
		'gl_hero_btn2_link'      => '#contact',
		'gl_hero_rating_value'   => '4.9',
		'gl_hero_rating_count'   => '1,240 reviews',
		'gl_hero_guarantee'      => 'Backed by our',
		'gl_hero_guarantee_bold' => '2-Year Service Guarantee',
		'gl_stat1_number' => '25+',
		'gl_stat1_label'  => 'Years Local',
		'gl_stat2_number' => '12,000+',
		'gl_stat2_label'  => 'Happy Customers',
		'gl_stat3_number' => '40+',
		'gl_stat3_label'  => 'Top Brands',

		// Trust bar (dark strip)
		'gl_trust_icon_1' => 'groups',        'gl_trust_text_1' => 'Family-Owned',
		'gl_trust_icon_2' => 'money',          'gl_trust_text_2' => 'Financing Available',
		'gl_trust_icon_3' => 'awards',         'gl_trust_text_3' => 'Certified Technicians',
		'gl_trust_icon_4' => 'yes-alt',        'gl_trust_text_4' => 'Genuine OEM Parts',
		'gl_trust_icon_5' => 'performance',    'gl_trust_text_5' => 'Fast Repairs',
		'gl_trust_icon_6' => 'tag',            'gl_trust_text_6' => 'Top Brands',

		// Section titles
		'gl_cat_eyebrow'   => 'Shop by Category',
		'gl_cat_heading'   => 'Equipment for every job, every season',
		'gl_cat_sub'       => 'Browse our full lineup of residential and commercial-grade outdoor power equipment from the brands you trust.',
		'gl_svc_eyebrow'   => 'What We Do',
		'gl_svc_heading'   => 'A full-service dealership under one roof',
		'gl_feat_eyebrow'  => 'Why Choose Us',
		'gl_feat_heading'  => 'Neighbors who happen to know equipment',
		'gl_test_eyebrow'  => 'Testimonials',
		'gl_test_heading'  => 'Trusted by neighbors, contractors, and pros',
		'gl_faq_eyebrow'   => 'FAQ',
		'gl_faq_heading'   => 'Answers to common questions',
		'gl_quote_eyebrow' => 'Free Quote',
		'gl_quote_heading' => "Tell us what you're looking for",
		'gl_quote_sub'     => 'Share a few details and one of our specialists will follow up within one business day with the right equipment options, pricing, and financing terms — no pressure.',

		// Financing CTA
		'gl_fin_badge'     => 'Flexible Financing',
		'gl_fin_heading'   => 'Bring home the right equipment. Pay for it your way.',
		'gl_fin_sub'       => 'Choose from low monthly payments, seasonal deferrals, and 0% APR promotions on qualifying models. Approvals in minutes, not days.',
		'gl_fin_stat1_v'   => '0%',    'gl_fin_stat1_l' => 'APR available',
		'gl_fin_stat2_v'   => '60mo',  'gl_fin_stat2_l' => 'Terms up to',
		'gl_fin_stat3_v'   => '24hr',  'gl_fin_stat3_l' => 'Fast approval',
		'gl_fin_stat4_v'   => '$0',    'gl_fin_stat4_l' => 'Down options',
		'gl_fin_btn1_text' => 'Apply for Financing',
		'gl_fin_btn1_link' => '#quote',
		'gl_fin_btn2_text' => 'Talk to us',
		'gl_fin_btn2_link' => 'tel:5554129087',

		// Service & Repair band
		'gl_sc_badge'     => 'Service & Repair',
		'gl_sc_heading'   => 'Keep your equipment running like the day you bought it',
		'gl_sc_body'      => "From routine tune-ups to major repairs, our certified technicians work on every brand we sell — and most that we don't. Book a spot before the busy season fills up.",
		'gl_sc_bullet1'   => 'Free pickup & delivery on qualifying tickets',
		'gl_sc_bullet2'   => 'Same-day diagnostic on most units',
		'gl_sc_bullet3'   => '90-day workmanship guarantee',
		'gl_sc_btn1_text' => 'Schedule Service',
		'gl_sc_btn1_link' => '#quote',
		'gl_sc_btn2_text' => 'Call the shop',
		'gl_sc_btn2_link' => 'tel:5554129087',

		// Contact
		'gl_contact_email'   => 'hello@greenlinepower.com',
		'gl_contact_address' => '2140 Riverbend Rd, Springfield',
		'gl_form_recipient'  => get_option( 'admin_email' ),

		// Showroom
		'gl_show_badge'           => 'Visit Us',
		'gl_show_heading'         => 'Come see the showroom',
		'gl_show_meta'            => 'Free parking · Wheelchair accessible',
		'gl_show_directions_link' => 'https://maps.google.com',
		'gl_hours_weekday'        => '7:30 AM – 6:00 PM',
		'gl_hours_saturday'       => '8:00 AM – 4:00 PM',
		'gl_hours_sunday'         => 'Closed',

		// Footer
		'gl_footer_tagline'             => 'Your trusted local outdoor power equipment dealer, proudly serving the community since 1998.',
		'gl_footer_newsletter_heading'  => 'Get Seasonal Offers',
		'gl_footer_newsletter_sub'      => 'Financing specials, tune-up reminders, and dealer-only pricing — a few times a season.',
		'gl_footer_copyright'           => '© ' . date( 'Y' ) . ' Greenline Power Equipment Co. All rights reserved.',
		'gl_social_facebook'            => '',
		'gl_social_instagram'           => '',
		'gl_social_youtube'             => '',
		'gl_seo_desc'                   => 'Local outdoor power equipment dealer for sales, service, parts, and financing. Request a quote and a specialist will follow up within one business day.',

		// Image defaults (kept here too so greenline_opt() covers images consistently)
		'gl_hero_image'  => GREENLINE_URI . '/assets/images/scenes/hero.svg',
		'gl_sc_image'    => GREENLINE_URI . '/assets/images/scenes/service-repair.svg',
		'gl_show_image'  => GREENLINE_URI . '/assets/images/scenes/showroom.svg',

		// Colors (kept here too as a safety net; front-end calls already pass matching literals)
		'gl_color_cream'        => '#F6F4EC',
		'gl_color_cream_alt'    => '#EDF0E8',
		'gl_color_dark'         => '#152018',
		'gl_color_green'        => '#1F3D2A',
		'gl_color_green_bright' => '#3EA65A',
		'gl_color_orange'       => '#E8792D',
		'gl_color_text'         => '#1A1D18',
		'gl_color_text_light'   => '#6B7066',
		'gl_color_border'       => '#E2E4DB',
	);

	return $defaults;
}

/**
 * Look up a single field's central default. Returns '' if unknown.
 */
function greenline_text_default( $key ) {
	$defaults = greenline_text_defaults();
	return isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
}
