<?php
/** Service & Repair band. @package Greenline */
$img = greenline_opt( 'gl_sc_image' );
?>
<section class="gl-section">
	<div class="gl-container">
		<div class="gl-service-cta">
			<div class="gl-service-cta__media">
				<?php if ( $img ) : ?>
					<img src="<?php echo esc_url( $img ); ?>" alt="">
				<?php else : ?>
					<div class="gl-image-placeholder"><span class="dashicons dashicons-admin-tools"></span></div>
				<?php endif; ?>
			</div>
			<div class="gl-service-cta__copy">
				<span class="gl-eyebrow-badge">
					<span class="dashicons dashicons-admin-tools"></span>
					<?php echo esc_html( greenline_opt( 'gl_sc_badge' ) ); ?>
				</span>
				<h2><?php echo esc_html( greenline_opt( 'gl_sc_heading' ) ); ?></h2>
				<p><?php echo esc_html( greenline_opt( 'gl_sc_body' ) ); ?></p>
				<ul class="gl-check-list">
					<li><span class="dashicons dashicons-yes-alt"></span><?php echo esc_html( greenline_opt( 'gl_sc_bullet1' ) ); ?></li>
					<li><span class="dashicons dashicons-yes-alt"></span><?php echo esc_html( greenline_opt( 'gl_sc_bullet2' ) ); ?></li>
					<li><span class="dashicons dashicons-yes-alt"></span><?php echo esc_html( greenline_opt( 'gl_sc_bullet3' ) ); ?></li>
				</ul>
				<div class="gl-service-cta__actions">
					<a class="gl-btn gl-btn--primary" href="<?php echo esc_url( greenline_opt( 'gl_sc_btn1_link', '#quote' ) ); ?>">
						<?php echo esc_html( greenline_opt( 'gl_sc_btn1_text' ) ); ?> <span class="dashicons dashicons-arrow-right-alt"></span>
					</a>
					<a class="gl-btn gl-btn--outline" href="<?php echo esc_url( greenline_opt( 'gl_sc_btn2_link', '#' ) ); ?>">
						<span class="dashicons dashicons-phone"></span> <?php echo esc_html( greenline_opt( 'gl_sc_btn2_text' ) ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
