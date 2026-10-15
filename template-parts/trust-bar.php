<?php
/** Dark trust bar strip. @package Greenline */
?>
<div class="gl-trustbar">
	<div class="gl-container gl-trustbar__row">
		<?php for ( $i = 1; $i <= 6; $i++ ) :
			$icon = greenline_opt( "gl_trust_icon_$i" );
			$text = greenline_opt( "gl_trust_text_$i" );
			if ( empty( $text ) ) continue;
			?>
			<div class="gl-trustbar__item">
				<span class="dashicons dashicons-<?php echo esc_attr( $icon ); ?>"></span>
				<span><?php echo esc_html( $text ); ?></span>
			</div>
		<?php endfor; ?>
	</div>
</div>
