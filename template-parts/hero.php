<?php
/** Hero section. @package Greenline */
?>
<section class="gl-hero">
	<div class="gl-container gl-hero__grid">
		<div class="gl-hero__copy">
			<span class="gl-eyebrow-badge">
				<span class="dashicons dashicons-star-filled"></span>
				<?php echo esc_html( greenline_opt( 'gl_hero_badge', 'Family-Owned Since 1998' ) ); ?>
			</span>
			<h1 class="gl-hero__heading">
				<?php echo esc_html( greenline_opt( 'gl_hero_heading_pre' ) ); ?><span class="gl-text-accent"><?php echo esc_html( greenline_opt( 'gl_hero_heading_hl' ) ); ?></span><?php echo esc_html( greenline_opt( 'gl_hero_heading_post' ) ); ?>
			</h1>
			<p class="gl-hero__sub"><?php echo esc_html( greenline_opt( 'gl_hero_subtext' ) ); ?></p>
			<div class="gl-hero__actions">
				<a class="gl-btn gl-btn--primary gl-btn--lg" href="<?php echo esc_url( greenline_opt( 'gl_hero_btn1_link', '#quote' ) ); ?>">
					<?php echo esc_html( greenline_opt( 'gl_hero_btn1_text' ) ); ?> <span class="dashicons dashicons-arrow-right-alt"></span>
				</a>
				<a class="gl-btn gl-btn--outline gl-btn--lg" href="<?php echo esc_url( greenline_opt( 'gl_hero_btn2_link', '#contact' ) ); ?>">
					<span class="dashicons dashicons-calendar-alt"></span> <?php echo esc_html( greenline_opt( 'gl_hero_btn2_text' ) ); ?>
				</a>
			</div>
			<div class="gl-hero__stats">
				<div class="gl-stat"><strong><?php echo esc_html( greenline_opt( 'gl_stat1_number' ) ); ?></strong><span><?php echo esc_html( greenline_opt( 'gl_stat1_label' ) ); ?></span></div>
				<div class="gl-stat"><strong><?php echo esc_html( greenline_opt( 'gl_stat2_number' ) ); ?></strong><span><?php echo esc_html( greenline_opt( 'gl_stat2_label' ) ); ?></span></div>
				<div class="gl-stat"><strong><?php echo esc_html( greenline_opt( 'gl_stat3_number' ) ); ?></strong><span><?php echo esc_html( greenline_opt( 'gl_stat3_label' ) ); ?></span></div>
			</div>
		</div>

		<div class="gl-hero__media">
			<div class="gl-hero__image-wrap">
				<?php $hero_img = greenline_opt( 'gl_hero_image' ); ?>
				<?php if ( $hero_img ) : ?>
					<img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php bloginfo( 'name' ); ?>">
				<?php else : ?>
					<div class="gl-image-placeholder gl-image-placeholder--hero"><span class="dashicons dashicons-format-image"></span></div>
				<?php endif; ?>

				<div class="gl-floating-card gl-floating-card--rating">
					<span class="gl-stars-inline">★★★★★</span>
					<strong><?php echo esc_html( greenline_opt( 'gl_hero_rating_value', '4.9' ) ); ?></strong>
					<span>· <?php echo esc_html( greenline_opt( 'gl_hero_rating_count', '1,240 reviews' ) ); ?></span>
				</div>

				<div class="gl-floating-card gl-floating-card--guarantee">
					<span class="gl-floating-card__icon"><span class="dashicons dashicons-shield"></span></span>
					<span>
						<small><?php echo esc_html( greenline_opt( 'gl_hero_guarantee', 'Backed by our' ) ); ?></small>
						<strong><?php echo esc_html( greenline_opt( 'gl_hero_guarantee_bold', '2-Year Service Guarantee' ) ); ?></strong>
					</span>
				</div>
			</div>
		</div>
	</div>
</section>
