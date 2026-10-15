<?php
/** "What we do" services grid, sourced from the Customizer repeater. @package Greenline */
$items = greenline_get_repeater( 'gl_services_repeater' );
if ( empty( $items ) ) return;
?>
<section class="gl-section gl-section--alt">
	<div class="gl-container">
		<div class="gl-section__head">
			<span class="gl-eyebrow"><?php echo esc_html( greenline_opt( 'gl_svc_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( greenline_opt( 'gl_svc_heading' ) ); ?></h2>
		</div>

		<div class="gl-services-grid">
			<?php foreach ( $items as $item ) :
				$title = $item['title'] ?? '';
				if ( '' === $title ) continue;
				$icon       = $item['icon'] ?? '';
				$icon_image = $item['icon_image'] ?? '';
				$link       = $item['link'] ?? '#';
				?>
				<div class="gl-service-card">
					<?php if ( $icon_image ) : ?>
						<span class="gl-service-card__icon gl-service-card__icon--image"><img src="<?php echo esc_url( $icon_image ); ?>" alt=""></span>
					<?php elseif ( $icon ) : ?>
						<span class="gl-service-card__icon"><span class="dashicons dashicons-<?php echo esc_attr( $icon ); ?>"></span></span>
					<?php endif; ?>
					<h3><?php echo esc_html( $title ); ?></h3>
					<p><?php echo esc_html( $item['description'] ?? '' ); ?></p>
					<a class="gl-link-arrow" href="<?php echo esc_url( $link ); ?>"><?php _e( 'Learn more', 'greenline' ); ?> <span class="dashicons dashicons-arrow-right-alt"></span></a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
