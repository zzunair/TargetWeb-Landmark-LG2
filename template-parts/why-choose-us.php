<?php
/** Why Choose Us feature tiles, sourced from the Customizer repeater. @package Greenline */
$items = greenline_get_repeater( 'gl_features_repeater' );
if ( empty( $items ) ) return;
?>
<section class="gl-section">
	<div class="gl-container">
		<div class="gl-section__head">
			<span class="gl-eyebrow"><?php echo esc_html( greenline_opt( 'gl_feat_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( greenline_opt( 'gl_feat_heading' ) ); ?></h2>
		</div>

		<div class="gl-features-grid">
			<?php foreach ( $items as $item ) :
				$title = $item['title'] ?? '';
				if ( '' === $title ) continue;
				$icon       = $item['icon'] ?? '';
				$icon_image = $item['icon_image'] ?? '';
				?>
				<div class="gl-feature-tile">
					<?php if ( $icon_image ) : ?>
						<span class="gl-feature-tile__icon gl-feature-tile__icon--image"><img src="<?php echo esc_url( $icon_image ); ?>" alt=""></span>
					<?php elseif ( $icon ) : ?>
						<span class="gl-feature-tile__icon"><span class="dashicons dashicons-<?php echo esc_attr( $icon ); ?>"></span></span>
					<?php endif; ?>
					<div>
						<h3><?php echo esc_html( $title ); ?></h3>
						<p><?php echo esc_html( $item['description'] ?? '' ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
