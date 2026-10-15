<?php
/**
 * Handles the front-end "Get My Free Quote" form submission.
 *
 * @package Greenline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function greenline_handle_quote_form() {
	if ( ! isset( $_POST['gl_quote_submit'] ) ) return;
	if ( ! isset( $_POST['greenline_quote_nonce'] ) || ! wp_verify_nonce( $_POST['greenline_quote_nonce'], 'greenline_quote_form' ) ) return;

	$name    = isset( $_POST['gl_name'] ) ? sanitize_text_field( wp_unslash( $_POST['gl_name'] ) ) : '';
	$email   = isset( $_POST['gl_email'] ) ? sanitize_email( wp_unslash( $_POST['gl_email'] ) ) : '';
	$phone   = isset( $_POST['gl_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['gl_phone'] ) ) : '';
	$interest= isset( $_POST['gl_interest'] ) ? sanitize_text_field( wp_unslash( $_POST['gl_interest'] ) ) : '';
	$method  = isset( $_POST['gl_contact_method'] ) ? sanitize_text_field( wp_unslash( $_POST['gl_contact_method'] ) ) : '';
	$message = isset( $_POST['gl_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['gl_message'] ) ) : '';

	if ( empty( $name ) || empty( $email ) ) return;

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

	// Redirect (PRG pattern) so refreshing doesn't resubmit, and show a success state.
	wp_safe_redirect( add_query_arg( 'gl_quote', 'sent', remove_query_arg( array( 'gl_quote' ) ) ) . '#quote' );
	exit;
}
add_action( 'template_redirect', 'greenline_handle_quote_form' );
