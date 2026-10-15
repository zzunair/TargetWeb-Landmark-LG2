<?php
/** Financing dark CTA band. @package Greenline */
?>
<section class="gl-section">
	<div class="gl-container">
		<div class="gl-financing">
			<div class="gl-financing__copy">
				<span class="gl-eyebrow-badge gl-eyebrow-badge--on-dark">
					<span class="dashicons dashicons-money-alt"></span>
					<?php echo esc_html( greenline_opt( 'gl_fin_badge' ) ); ?>
				</span>
				<h2><?php echo esc_html( greenline_opt( 'gl_fin_heading' ) ); ?></h2>
				<p><?php echo esc_html( greenline_opt( 'gl_fin_sub' ) ); ?></p>
				<div class="gl-financing__actions">
					<a class="gl-btn gl-btn--orange" href="<?php echo esc_url( greenline_opt( 'gl_fin_btn1_link', '#quote' ) ); ?>">
						<?php echo esc_html( greenline_opt( 'gl_fin_btn1_text' ) ); ?> <span class="dashicons dashicons-arrow-right-alt"></span>
					</a>
					<a class="gl-btn gl-btn--ghost-dark" href="<?php echo esc_url( greenline_opt( 'gl_fin_btn2_link', '#' ) ); ?>">
						<span class="dashicons dashicons-phone"></span> <?php echo esc_html( greenline_opt( 'gl_fin_btn2_text' ) ); ?>
					</a>
				</div>
			</div>
			<div class="gl-financing__stats">
				<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
					<div class="gl-financing__stat">
						<strong><?php echo esc_html( greenline_opt( "gl_fin_stat{$i}_v" ) ); ?></strong>
						<span><?php echo esc_html( greenline_opt( "gl_fin_stat{$i}_l" ) ); ?></span>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</div>
</section>
