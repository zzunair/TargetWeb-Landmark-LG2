<?php
/**
 * Footer
 *
 * @package Greenline
 */
?>
	<footer class="gl-footer">
		<div class="gl-container gl-footer__grid">

			<div class="gl-footer__brand">
				<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
					<div class="gl-logo-text gl-logo-text--footer">
						<strong><?php bloginfo( 'name' ); ?></strong>
						<small><?php echo esc_html( greenline_opt( 'gl_site_tagline_small', 'Power Equipment Co.' ) ); ?></small>
					</div>
				<?php endif; ?>
				<p class="gl-footer__tagline"><?php echo esc_html( greenline_opt( 'gl_footer_tagline' ) ); ?></p>
				<div class="gl-social-row">
					<?php greenline_social_icons(); ?>
				</div>
			</div>

			<div class="gl-footer__col">
				<h4><?php _e( 'Shop', 'greenline' ); ?></h4>
				<?php wp_nav_menu( array( 'theme_location' => 'footer-shop', 'container' => false, 'menu_class' => 'gl-footer__list', 'fallback_cb' => false ) ); ?>
			</div>

			<div class="gl-footer__col">
				<h4><?php _e( 'Services', 'greenline' ); ?></h4>
				<?php wp_nav_menu( array( 'theme_location' => 'footer-services', 'container' => false, 'menu_class' => 'gl-footer__list', 'fallback_cb' => false ) ); ?>
			</div>

			<div class="gl-footer__col">
				<h4><?php _e( 'Company', 'greenline' ); ?></h4>
				<?php wp_nav_menu( array( 'theme_location' => 'footer-company', 'container' => false, 'menu_class' => 'gl-footer__list', 'fallback_cb' => false ) ); ?>
			</div>

			<div class="gl-footer__col gl-footer__newsletter">
				<h4><?php echo esc_html( greenline_opt( 'gl_footer_newsletter_heading', 'Get Seasonal Offers' ) ); ?></h4>
				<p><?php echo esc_html( greenline_opt( 'gl_footer_newsletter_sub' ) ); ?></p>
				<form class="gl-newsletter-form" method="post" action="#">
					<input type="email" name="gl_newsletter_email" placeholder="<?php esc_attr_e( 'Your email', 'greenline' ); ?>" required>
					<button type="submit"><?php _e( 'Join', 'greenline' ); ?></button>
				</form>
			</div>
		</div>

		<div class="gl-container gl-footer__bottom">
			<p><?php echo esc_html( greenline_opt( 'gl_footer_copyright' ) ); ?></p>
			<div class="gl-footer__legal">
				<a href="#"><?php _e( 'Privacy', 'greenline' ); ?></a>
				<a href="#"><?php _e( 'Terms', 'greenline' ); ?></a>
				<a href="#"><?php _e( 'Accessibility', 'greenline' ); ?></a>
			</div>
		</div>
	</footer>

<?php wp_footer(); ?>
</body>
</html>
