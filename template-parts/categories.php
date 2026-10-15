<?php
/** Equipment categories grid, sourced from the Customizer repeater. @package Greenline */
$items = greenline_get_repeater( 'gl_categories_repeater' );
if ( empty( $items ) ) return;
?>
<section class="gl-section" id="equipment">
	<div class="gl-container">
		<div class="gl-section__head">
			<span class="gl-eyebrow"><?php echo esc_html( greenline_opt( 'gl_cat_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( greenline_opt( 'gl_cat_heading' ) ); ?></h2>
			<p><?php echo esc_html( greenline_opt( 'gl_cat_sub' ) ); ?></p>
		</div>

		<div class="gl-category-grid">
			<?php foreach ( $items as $item ) :
				$badge = $item['badge'] ?? '';
				$link  = $item['link'] ?? '#';
				$image = $item['image'] ?? '';
				$title = $item['title'] ?? '';
				if ( '' === $title ) continue;
				?>
				<a class="gl-category-card" href="<?php echo esc_url( $link ); ?>">
					<?php if ( $badge ) : ?><span class="gl-badge gl-badge--<?php echo esc_attr( sanitize_title( $badge ) ); ?>"><?php echo esc_html( $badge ); ?></span><?php endif; ?>
					<div class="gl-category-card__media">
						<?php if ( $image ) : ?>
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>">
						<?php else : ?>
							<div class="gl-image-placeholder"><span class="dashicons dashicons-forklift"></span></div>
						<?php endif; ?>
					</div>
					<div class="gl-category-card__footer">
						<span><?php echo esc_html( $title ); ?></span>
						<span class="gl-category-card__arrow dashicons dashicons-arrow-right-alt"></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
