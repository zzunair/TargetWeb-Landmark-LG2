<?php
/**
 * 404 template.
 *
 * @package Greenline
 */

get_header();
?>
<main id="primary" class="gl-main gl-container gl-container--narrow gl-404">
	<span class="gl-eyebrow-badge">404</span>
	<h1><?php _e( "This page took a detour.", 'greenline' ); ?></h1>
	<p><?php _e( "The page you're looking for doesn't exist or has moved.", 'greenline' ); ?></p>
	<a class="gl-btn gl-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Back to Home', 'greenline' ); ?></a>
</main>
<?php get_footer(); ?>
