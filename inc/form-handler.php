<?php
/**
 * Handles the front-end "Get My Free Quote" form submission.
 *
 * @package Greenline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * The TargetWeb CRM plugin owns the quote card when it is enabled.
 */
function greenline_crm_ready() {
	if ( ! class_exists( 'TW_CRM_Frontend' ) || ! class_exists( 'TW_CRM_Settings' ) ) {
		return false;
	}
	$settings = TW_CRM_Settings::get_settings();
	return ! empty( $settings['enabled'] );
}

function greenline_quote_redirect( $status ) {
	$url = remove_query_arg( array( 'gl_quote' ) );
	$url = add_query_arg( 'gl_quote', $status, $url );
	wp_safe_redirect( $url . '#quote' );
	exit;
}

function greenline_quote_limited() {
	$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key   = 'gl_quote_' . md5( $ip );
	$count = (int) get_transient( $key );
	if ( $count >= 8 ) {
		return true;
	}
	set_transient( $key, $count + 1, HOUR_IN_SECONDS );
	return false;
}

function greenline_handle_quote_form() {
	if ( ! isset( $_POST['gl_quote_submit'] ) ) return;
	if ( ! isset( $_POST['greenline_quote_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['greenline_quote_nonce'] ) ), 'greenline_quote_form' ) ) {
		greenline_quote_redirect( 'error' );
	}

	if ( ! empty( $_POST['gl_website'] ) ) {
		greenline_quote_redirect( 'sent' );
	}
	if ( greenline_quote_limited() ) {
		greenline_quote_redirect( 'limit' );
	}

	$name      = isset( $_POST['gl_name'] ) ? sanitize_text_field( wp_unslash( $_POST['gl_name'] ) ) : '';
	$raw_email = isset( $_POST['gl_email'] ) ? sanitize_text_field( wp_unslash( $_POST['gl_email'] ) ) : '';
	$email     = sanitize_email( $raw_email );
	$phone     = isset( $_POST['gl_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['gl_phone'] ) ) : '';
	$interest  = isset( $_POST['gl_interest'] ) ? sanitize_text_field( wp_unslash( $_POST['gl_interest'] ) ) : '';
	$method    = isset( $_POST['gl_contact_method'] ) ? sanitize_text_field( wp_unslash( $_POST['gl_contact_method'] ) ) : '';
	$message   = isset( $_POST['gl_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['gl_message'] ) ) : '';

	if ( '' === $name ) {
		greenline_quote_redirect( 'error' );
	}
	if ( '' === trim( $raw_email ) || ! is_email( $raw_email ) || '' === $email ) {
		greenline_quote_redirect( 'email' );
	}

	$to      = greenline_opt( 'gl_form_recipient', get_option( 'admin_email' ) );
	$subject = sprintf( __( 'New Quote Request — %s', 'greenline' ), $name );
	$body    = "New quote request from the website:\n\n"
		. "Name: {$name}\n"
		. "Email: {$email}\n"
		. "Phone: {$phone}\n"
		. "Interested Equipment: {$interest}\n"
		. "Preferred Contact Method: {$method}\n\n"
		. "Message:\n{$message}\n";

	$headers = array( "Reply-To: {$name} <{$email}>" );
	wp_mail( $to, $subject, $body, $headers );

	greenline_quote_redirect( 'sent' );
}
add_action( 'template_redirect', 'greenline_handle_quote_form' );
