<?php
/** FAQ accordion, sourced from the Customizer repeater. @package Greenline */
$items = greenline_get_repeater( 'gl_faqs_repeater' );
if ( empty( $items ) ) return;
?>
<section class="gl-section gl-section--alt" id="faq">
	<div class="gl-container gl-container--narrow">
		<div class="gl-section__head">
			<span class="gl-eyebrow"><?php echo esc_html( greenline_opt( 'gl_faq_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( greenline_opt( 'gl_faq_heading' ) ); ?></h2>
		</div>

		<div class="gl-faq-list" data-gl-accordion>
			<?php foreach ( $items as $index => $item ) :
				$question = $item['question'] ?? '';
				if ( '' === $question ) continue;
				?>
				<div class="gl-faq-item <?php echo 0 === $index ? 'is-open' : ''; ?>">
					<button class="gl-faq-item__question" aria-expanded="<?php echo 0 === $index ? 'true' : 'false'; ?>">
						<span><?php echo esc_html( $question ); ?></span>
						<span class="dashicons dashicons-arrow-down-alt2"></span>
					</button>
					<div class="gl-faq-item__answer">
						<p><?php echo esc_html( $item['answer'] ?? '' ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
