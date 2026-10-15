<?php
/**
 * Comments template.
 *
 * @package Greenline
 */
if ( post_password_required() ) return;
?>
<div class="gl-comments">
	<?php if ( have_comments() ) : ?>
		<h3><?php comments_number( __( 'No Comments', 'greenline' ), __( '1 Comment', 'greenline' ), __( '% Comments', 'greenline' ) ); ?></h3>
		<ol class="gl-comment-list"><?php wp_list_comments( array( 'style' => 'ol' ) ); ?></ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>
	<?php comment_form(); ?>
</div>
