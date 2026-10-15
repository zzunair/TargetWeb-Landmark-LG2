<?php
/** Testimonials slider, sourced from the Customizer repeater. @package Greenline */
$items = greenline_get_repeater( 'gl_testimonials_repeater' );
if ( empty( $items ) ) return;
?>
<section class="gl-section gl-section--alt">
	<div class="gl-container">
		<div class="gl-section__head">
			<span class="gl-eyebrow"><?php echo esc_html( greenline_opt( 'gl_test_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( greenline_opt( 'gl_test_heading' ) ); ?></h2>
		</div>

		<div class="gl-testimonial-slider" data-gl-slider>
			<div class="gl-testimonial-slider__track">
				<?php foreach ( $items as $index => $item ) :
					$name   = $item['name'] ?? '';
					if ( '' === $name ) continue;
					$role   = $item['role'] ?? '';
					$rating = $item['rating'] ?? 5;
					$image  = $item['image'] ?? '';
					?>
					<div class="gl-testimonial-card" data-slide="<?php echo esc_attr( $index ); ?>">
						<?php greenline_stars( $rating ); ?>
						<blockquote>&ldquo;<?php echo esc_html( $item['quote'] ?? '' ); ?>&rdquo;</blockquote>
						<div class="gl-testimonial-card__author">
							<?php if ( $image ) : ?>
								<img class="gl-avatar" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $name ); ?>">
							<?php else : ?>
								<span class="gl-avatar gl-avatar--placeholder"><?php echo esc_html( mb_substr( $name, 0, 1 ) ); ?></span>
							<?php endif; ?>
							<div>
								<strong><?php echo esc_html( $name ); ?></strong>
								<span><?php echo esc_html( $role ); ?></span>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php if ( count( $items ) > 1 ) : ?>
				<div class="gl-testimonial-slider__dots">
					<?php foreach ( $items as $index => $item ) : ?>
						<button class="gl-dot <?php echo 0 === $index ? 'is-active' : ''; ?>" data-goto="<?php echo esc_attr( $index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Go to testimonial %d', 'greenline' ), $index + 1 ) ); ?>"></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
