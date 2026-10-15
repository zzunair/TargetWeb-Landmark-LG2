<?php
/** Showroom section — photo + hours + map card. @package Greenline */
$img = greenline_opt( 'gl_show_image' );
?>
<section class="gl-section gl-section--alt" id="contact">
	<div class="gl-container">
		<div class="gl-section__head gl-section__head--left">
			<span class="gl-eyebrow"><?php echo esc_html( greenline_opt( 'gl_show_badge' ) ); ?></span>
			<h2><?php echo esc_html( greenline_opt( 'gl_show_heading' ) ); ?></h2>
		</div>

		<div class="gl-showroom-grid">
			<div class="gl-showroom-photo">
				<?php if ( $img ) : ?>
					<img src="<?php echo esc_url( $img ); ?>" alt="<?php bloginfo( 'name' ); ?>">
				<?php else : ?>
					<div class="gl-image-placeholder"><span class="dashicons dashicons-store"></span></div>
				<?php endif; ?>
				<div class="gl-showroom-photo__pin">
					<span class="dashicons dashicons-location"></span>
					<span>
						<strong><?php echo esc_html( greenline_opt( 'gl_contact_address' ) ); ?></strong>
						<small><?php echo esc_html( greenline_opt( 'gl_show_meta' ) ); ?></small>
					</span>
					<a class="gl-btn gl-btn--primary gl-btn--sm" href="<?php echo esc_url( greenline_opt( 'gl_show_directions_link', '#' ) ); ?>" target="_blank" rel="noopener">
						<?php _e( 'Directions', 'greenline' ); ?> <span class="dashicons dashicons-arrow-right-alt"></span>
					</a>
				</div>
			</div>

			<div class="gl-showroom-card">
				<h3><?php _e( 'Store Hours', 'greenline' ); ?></h3>
				<ul class="gl-hours-list">
					<li><span class="dashicons dashicons-clock"></span> <?php _e( 'Mon – Fri', 'greenline' ); ?> <b><?php echo esc_html( greenline_opt( 'gl_hours_weekday' ) ); ?></b></li>
					<li><span class="dashicons dashicons-clock"></span> <?php _e( 'Saturday', 'greenline' ); ?> <b><?php echo esc_html( greenline_opt( 'gl_hours_saturday' ) ); ?></b></li>
					<li><span class="dashicons dashicons-clock"></span> <?php _e( 'Sunday', 'greenline' ); ?> <b><?php echo esc_html( greenline_opt( 'gl_hours_sunday' ) ); ?></b></li>
				</ul>
				<a class="gl-showroom-card__row" href="tel:<?php echo esc_attr( greenline_opt( 'gl_phone_link' ) ); ?>"><span class="dashicons dashicons-phone"></span><?php echo esc_html( greenline_opt( 'gl_phone_display' ) ); ?></a>
				<a class="gl-showroom-card__row" href="mailto:<?php echo esc_attr( greenline_opt( 'gl_contact_email' ) ); ?>"><span class="dashicons dashicons-email"></span><?php echo esc_html( greenline_opt( 'gl_contact_email' ) ); ?></a>
				<div class="gl-social-row gl-social-row--card">
					<?php greenline_social_icons(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
