<?php
/** Free quote section — contact cards + form. @package Greenline */
$categories = greenline_get_repeater( 'gl_categories_repeater' );
$sent = isset( $_GET['gl_quote'] ) && 'sent' === $_GET['gl_quote'];
?>
<section class="gl-section" id="quote">
	<div class="gl-container gl-quote-grid">
		<div class="gl-quote-intro">
			<span class="gl-eyebrow"><?php echo esc_html( greenline_opt( 'gl_quote_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( greenline_opt( 'gl_quote_heading' ) ); ?></h2>
			<p><?php echo esc_html( greenline_opt( 'gl_quote_sub' ) ); ?></p>

			<div class="gl-contact-cards">
				<a class="gl-contact-card" href="tel:<?php echo esc_attr( greenline_opt( 'gl_phone_link', '5554129087' ) ); ?>">
					<span class="dashicons dashicons-phone"></span>
					<span><small><?php _e( 'Call us direct', 'greenline' ); ?></small><strong><?php echo esc_html( greenline_opt( 'gl_phone_display' ) ); ?></strong></span>
				</a>
				<a class="gl-contact-card" href="mailto:<?php echo esc_attr( greenline_opt( 'gl_contact_email' ) ); ?>">
					<span class="dashicons dashicons-email"></span>
					<span><small><?php _e( 'Email the team', 'greenline' ); ?></small><strong><?php echo esc_html( greenline_opt( 'gl_contact_email' ) ); ?></strong></span>
				</a>
				<a class="gl-contact-card" href="<?php echo esc_url( greenline_opt( 'gl_show_directions_link', '#' ) ); ?>" target="_blank" rel="noopener">
					<span class="dashicons dashicons-location"></span>
					<span><small><?php _e( 'Visit the showroom', 'greenline' ); ?></small><strong><?php echo esc_html( greenline_opt( 'gl_contact_address' ) ); ?></strong></span>
				</a>
			</div>
		</div>

		<div class="gl-quote-form-wrap">
			<?php if ( $sent ) : ?>
				<div class="gl-form-success">
					<span class="dashicons dashicons-yes-alt"></span>
					<p><?php _e( "Thanks — we've got your request and will follow up within one business day.", 'greenline' ); ?></p>
				</div>
			<?php else : ?>
			<form class="gl-quote-form" method="post" action="<?php echo esc_url( home_url( '/' ) ); ?>#quote">
				<?php wp_nonce_field( 'greenline_quote_form', 'greenline_quote_nonce' ); ?>
				<input type="hidden" name="gl_quote_submit" value="1">
				<div class="gl-form-row gl-form-row--split">
					<div class="gl-form-field">
						<label><?php _e( 'Full Name', 'greenline' ); ?></label>
						<input type="text" name="gl_name" placeholder="Jane Doe" required>
					</div>
					<div class="gl-form-field">
						<label><?php _e( 'Email', 'greenline' ); ?></label>
						<input type="email" name="gl_email" placeholder="jane@example.com" required>
					</div>
				</div>
				<div class="gl-form-row gl-form-row--split">
					<div class="gl-form-field">
						<label><?php _e( 'Phone', 'greenline' ); ?></label>
						<input type="tel" name="gl_phone" placeholder="(555) 123-4567">
					</div>
					<div class="gl-form-field">
						<label><?php _e( 'Interested Equipment', 'greenline' ); ?></label>
						<select name="gl_interest">
							<?php if ( $categories ) : foreach ( $categories as $cat ) :
								$cat_title = $cat['title'] ?? '';
								if ( '' === $cat_title ) continue;
								?>
								<option value="<?php echo esc_attr( $cat_title ); ?>"><?php echo esc_html( $cat_title ); ?></option>
							<?php endforeach; else : ?>
								<option value="General"><?php _e( 'General Inquiry', 'greenline' ); ?></option>
							<?php endif; ?>
						</select>
					</div>
				</div>
				<div class="gl-form-field">
					<label><?php _e( 'Preferred Contact Method', 'greenline' ); ?></label>
					<div class="gl-pill-radio-group">
						<label class="gl-pill-radio"><input type="radio" name="gl_contact_method" value="Phone" checked><span><?php _e( 'Phone', 'greenline' ); ?></span></label>
						<label class="gl-pill-radio"><input type="radio" name="gl_contact_method" value="Email"><span><?php _e( 'Email', 'greenline' ); ?></span></label>
						<label class="gl-pill-radio"><input type="radio" name="gl_contact_method" value="Text"><span><?php _e( 'Text', 'greenline' ); ?></span></label>
					</div>
				</div>
				<div class="gl-form-field">
					<label><?php _e( 'Message', 'greenline' ); ?></label>
					<textarea name="gl_message" rows="3" placeholder="<?php esc_attr_e( 'Tell us about your lawn size, terrain, timeline, or any questions.', 'greenline' ); ?>"></textarea>
				</div>
				<button type="submit" class="gl-btn gl-btn--primary gl-btn--block">
					<?php _e( 'Get My Free Quote', 'greenline' ); ?> <span class="dashicons dashicons-arrow-right-alt"></span>
				</button>
				<p class="gl-form-disclaimer"><?php _e( 'No spam, ever. We\'ll only contact you about your request.', 'greenline' ); ?></p>
			</form>
			<?php endif; ?>
		</div>
	</div>
</section>
