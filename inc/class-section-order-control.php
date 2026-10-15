<?php
/**
 * A "section order" Customizer control — a fixed list of homepage sections
 * that can be reordered (↑ / ↓) and toggled on/off, the same idea as
 * dragging sections in a Shopify theme editor. Unlike the repeater control,
 * rows can't be added or deleted here — the set of sections is fixed by the
 * theme — only their order and visibility change.
 *
 * @package Greenline
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) return;

class Greenline_Section_Order_Control extends WP_Customize_Control {

	public $type = 'greenline-section-order';

	/** @var array id => label, in default order */
	public $items = array();

	public function enqueue() {
		wp_enqueue_style( 'greenline-customizer-controls', GREENLINE_URI . '/assets/css/customizer-controls.css', array(), GREENLINE_VERSION );
		wp_enqueue_script( 'greenline-customizer-controls', GREENLINE_URI . '/assets/js/customizer-controls.js', array( 'jquery', 'customize-controls' ), GREENLINE_VERSION, true );
	}

	public function render_content() {
		$value = $this->value();
		?>
		<div class="gl-section-order-control">
			<?php if ( $this->label ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( $this->description ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>

			<div class="gl-section-order" data-items="<?php echo esc_attr( wp_json_encode( $this->items ) ); ?>">
				<div class="gl-section-order__list"></div>
				<input type="hidden" class="gl-section-order__value" <?php $this->link(); ?> value="<?php echo esc_attr( $value ); ?>">
			</div>
		</div>
		<?php
	}
}
