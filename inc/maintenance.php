<?php
/**
 * Maintenance mode. Public visitors are sent to /maintenance/.
 * Administrators can keep browsing. A timer reopens the site on its own.
 *
 * @package Greenline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function greenline_maintenance_mod( $key, $default = '' ) {
	return get_theme_mod( 'gl_maintenance_' . $key, $default );
}

function greenline_sanitize_maintenance_end( $value ) {
	$value = sanitize_text_field( $value );
	if ( '' === $value ) {
		return '';
	}
	$dt = DateTimeImmutable::createFromFormat( 'Y-m-d\TH:i', $value, wp_timezone() );
	if ( ! $dt ) {
		$dt = DateTimeImmutable::createFromFormat( 'Y-m-d\TH:i:s', $value, wp_timezone() );
	}
	return $dt ? $dt->format( 'Y-m-d\TH:i' ) : '';
}

function greenline_maintenance_end_timestamp() {
	$raw = (string) greenline_maintenance_mod( 'timer_end', '' );
	if ( '' === $raw ) {
		return 0;
	}
	$dt = DateTimeImmutable::createFromFormat( 'Y-m-d\TH:i', $raw, wp_timezone() );
	return $dt ? $dt->getTimestamp() : 0;
}

function greenline_maintenance_active() {
	if ( ! greenline_maintenance_mod( 'enabled', false ) ) {
		return false;
	}
	if ( ! greenline_maintenance_mod( 'timer_enabled', false ) ) {
		return true;
	}
	$end = greenline_maintenance_end_timestamp();
	if ( ! $end ) {
		return true;
	}
	return time() < $end;
}

function greenline_maintenance_request_path() {
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$path = wp_parse_url( $uri, PHP_URL_PATH );
	$path = is_string( $path ) ? $path : '';
	$home = wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	$home = is_string( $home ) ? untrailingslashit( $home ) : '';
	if ( $home && '/' !== $home && 0 === strpos( $path, $home ) ) {
		$path = substr( $path, strlen( $home ) );
	}
	return trim( $path, '/' );
}

function greenline_maintenance_customize( $wp_customize ) {
	$wp_customize->add_section(
		'gl_maintenance',
		array(
			'title'       => __( 'Maintenance Mode', 'greenline' ),
			'description' => __( 'While this is on, every public URL redirects to the maintenance page. Administrators can still browse the site. With the timer on, the site opens again at the end time.', 'greenline' ),
			'priority'    => 80,
		)
	);

	$wp_customize->add_setting( 'gl_maintenance_enabled', array( 'default' => false, 'sanitize_callback' => 'wp_validate_boolean' ) );
	$wp_customize->add_control( 'gl_maintenance_enabled', array( 'label' => __( 'Enable maintenance mode', 'greenline' ), 'section' => 'gl_maintenance', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'gl_maintenance_headline', array( 'default' => "We'll be back soon.", 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'gl_maintenance_headline', array( 'label' => __( 'Headline', 'greenline' ), 'section' => 'gl_maintenance', 'type' => 'text' ) );

	$wp_customize->add_setting( 'gl_maintenance_message', array( 'default' => "We're making some updates. Check back shortly.", 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'gl_maintenance_message', array( 'label' => __( 'Message', 'greenline' ), 'section' => 'gl_maintenance', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'gl_maintenance_timer_enabled', array( 'default' => false, 'sanitize_callback' => 'wp_validate_boolean' ) );
	$wp_customize->add_control( 'gl_maintenance_timer_enabled', array( 'label' => __( 'Enable countdown timer', 'greenline' ), 'description' => __( 'Shows a countdown and turns maintenance off when the end time is reached.', 'greenline' ), 'section' => 'gl_maintenance', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'gl_maintenance_timer_end', array( 'default' => '', 'sanitize_callback' => 'greenline_sanitize_maintenance_end' ) );
	$wp_customize->add_control(
		'gl_maintenance_timer_end',
		array(
			'label'           => __( 'Timer end', 'greenline' ),
			'description'     => __( 'Uses the site timezone. Leave empty to keep maintenance on until you turn it off.', 'greenline' ),
			'section'         => 'gl_maintenance',
			'type'            => 'datetime-local',
			'active_callback' => function () {
				return (bool) get_theme_mod( 'gl_maintenance_timer_enabled', false );
			},
		)
	);
}
add_action( 'customize_register', 'greenline_maintenance_customize', 20 );

function greenline_render_maintenance_page() {
	$end      = greenline_maintenance_mod( 'timer_enabled', false ) ? greenline_maintenance_end_timestamp() : 0;
	$retry    = ( $end && $end > time() ) ? ( $end - time() ) : 3600;
	$headline = greenline_maintenance_mod( 'headline', "We'll be back soon." );
	$message  = greenline_maintenance_mod( 'message', "We're making some updates. Check back shortly." );
	$home     = home_url( '/' );

	status_header( 503 );
	nocache_headers();
	header( 'Retry-After: ' . (int) $retry, true );
	header( 'X-Robots-Tag: noindex, nofollow', true );

	?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?php echo esc_html( get_bloginfo( 'name' ) ); ?> — <?php esc_html_e( 'Maintenance', 'greenline' ); ?></title>
<style>
body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:32px 20px;background:#152018;color:#f6f4ec;font-family:Inter,Segoe UI,sans-serif;text-align:center}
main{max-width:560px}
h1{font-size:2rem;line-height:1.2;margin:0 0 12px}
p{margin:0;color:#a3b0a6;font-size:1.05rem;line-height:1.6}
.timer{display:flex;gap:14px;justify-content:center;margin-top:28px}
.timer div{min-width:68px;background:#1f3d2a;border-radius:12px;padding:12px 8px}
.timer strong{display:block;font-size:1.6rem;color:#e8792d}
.timer span{font-size:.72rem;letter-spacing:.06em;text-transform:uppercase;color:#a3b0a6}
</style>
</head>
<body<?php echo $end ? ' data-end="' . esc_attr( $end ) . '" data-home="' . esc_url( $home ) . '"' : ''; ?>>
<main>
<h1><?php echo esc_html( $headline ); ?></h1>
<p><?php echo esc_html( $message ); ?></p>
<?php if ( $end ) : ?>
<div class="timer" aria-live="polite">
<div><strong data-d>0</strong><span><?php esc_html_e( 'Days', 'greenline' ); ?></span></div>
<div><strong data-h>0</strong><span><?php esc_html_e( 'Hours', 'greenline' ); ?></span></div>
<div><strong data-m>0</strong><span><?php esc_html_e( 'Minutes', 'greenline' ); ?></span></div>
<div><strong data-s>0</strong><span><?php esc_html_e( 'Seconds', 'greenline' ); ?></span></div>
</div>
<script>
(function(){
	var end = parseInt(document.body.getAttribute('data-end'), 10) * 1000;
	var home = document.body.getAttribute('data-home') || '/';
	var d = document.querySelector('[data-d]'), h = document.querySelector('[data-h]'), m = document.querySelector('[data-m]'), s = document.querySelector('[data-s]');
	function tick(){
		var left = Math.max(0, end - Date.now()), sec = Math.floor(left / 1000);
		d.textContent = String(Math.floor(sec / 86400));
		h.textContent = String(Math.floor((sec % 86400) / 3600));
		m.textContent = String(Math.floor((sec % 3600) / 60));
		s.textContent = String(sec % 60);
		if (left <= 0) { window.location.replace(home); }
	}
	tick();
	setInterval(tick, 1000);
})();
</script>
<?php endif; ?>
</main>
</body>
</html>
	<?php
	exit;
}

function greenline_maintenance_guard() {
	$is_page = ( 'maintenance' === greenline_maintenance_request_path() );

	if ( ! greenline_maintenance_active() ) {
		if ( $is_page ) {
			wp_safe_redirect( home_url( '/' ) );
			exit;
		}
		return;
	}

	if ( $is_page ) {
		greenline_render_maintenance_page();
	}

	if ( is_customize_preview() || current_user_can( 'manage_options' ) ) {
		return;
	}

	wp_safe_redirect( home_url( '/maintenance/' ), 302 );
	exit;
}
add_action( 'template_redirect', 'greenline_maintenance_guard', 0 );

function greenline_maintenance_block_rest( $result ) {
	if ( is_wp_error( $result ) || ! greenline_maintenance_active() || current_user_can( 'manage_options' ) ) {
		return $result;
	}
	return new WP_Error( 'maintenance', __( 'Site is under maintenance.', 'greenline' ), array( 'status' => 503 ) );
}
add_filter( 'rest_authentication_errors', 'greenline_maintenance_block_rest', 120 );

function greenline_maintenance_block_ajax() {
	if ( ! wp_doing_ajax() || ! greenline_maintenance_active() || current_user_can( 'manage_options' ) ) {
		return;
	}
	status_header( 503 );
	header( 'X-Robots-Tag: noindex, nofollow', true );
	wp_die( esc_html__( 'Site is under maintenance.', 'greenline' ), '', array( 'response' => 503 ) );
}
add_action( 'admin_init', 'greenline_maintenance_block_ajax' );
