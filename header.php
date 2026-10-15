<?php
/**
 * Header
 *
 * @package Greenline
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php _e( 'Skip to content', 'greenline' ); ?></a>

<header class="gl-header">
	<div class="gl-container gl-header__inner">

		<div class="gl-header__brand">
			<?php if ( has_custom_logo() ) : ?>
				<div class="gl-header__logo"><?php the_custom_logo(); ?></div>
			<?php else : ?>
				<a class="gl-header__logo-fallback" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="gl-logo-mark" aria-hidden="true">
						<span class="dashicons dashicons-marker"></span>
					</span>
					<span class="gl-logo-text">
						<strong><?php bloginfo( 'name' ); ?></strong>
						<small><?php echo esc_html( greenline_opt( 'gl_site_tagline_small', 'Power Equipment Co.' ) ); ?></small>
					</span>
				</a>
			<?php endif; ?>
		</div>

		<nav class="gl-header__nav" aria-label="<?php esc_attr_e( 'Primary Menu', 'greenline' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'gl-nav-menu',
				'fallback_cb'    => 'greenline_default_menu_fallback',
			) );
			?>
		</nav>

		<div class="gl-header__actions">
			<a class="gl-phone-pill" href="tel:<?php echo esc_attr( greenline_opt( 'gl_phone_link', '5554129087' ) ); ?>">
				<span class="dashicons dashicons-phone"></span>
				<?php echo esc_html( greenline_opt( 'gl_phone_display', '(555) 412-9087' ) ); ?>
			</a>
			<a class="gl-btn gl-btn--primary gl-btn--sm" href="<?php echo esc_url( greenline_opt( 'gl_header_cta_link', '#quote' ) ); ?>">
				<?php echo esc_html( greenline_opt( 'gl_header_cta_text', 'Request a Quote' ) ); ?>
				<span class="dashicons dashicons-arrow-right-alt"></span>
			</a>
		</div>

		<button class="gl-mobile-toggle" aria-expanded="false" aria-controls="gl-mobile-menu" aria-label="<?php esc_attr_e( 'Toggle menu', 'greenline' ); ?>">
			<span></span><span></span><span></span>
		</button>
	</div>

	<div id="gl-mobile-menu" class="gl-mobile-menu">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'gl-mobile-menu__list',
			'fallback_cb'    => 'greenline_default_menu_fallback',
		) );
		?>
		<a class="gl-btn gl-btn--primary" href="<?php echo esc_url( greenline_opt( 'gl_header_cta_link', '#quote' ) ); ?>">
			<?php echo esc_html( greenline_opt( 'gl_header_cta_text', 'Request a Quote' ) ); ?>
		</a>
	</div>
</header>

<?php
function greenline_default_menu_fallback() {
	echo '<ul class="gl-nav-menu"><li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'greenline' ) . '</a></li></ul>';
}
