<?php
/**
 * Default fallback template — standard blog loop.
 *
 * @package Greenline
 */

get_header();
?>
<main id="primary" class="gl-main gl-container gl-container--narrow gl-blog-wrap">
	<?php if ( have_posts() ) : ?>
		<div class="gl-blog-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'gl-blog-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="gl-blog-card__media"><?php the_post_thumbnail( 'greenline-card' ); ?></a>
					<?php endif; ?>
					<div class="gl-blog-card__body">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
						<a class="gl-link-arrow" href="<?php the_permalink(); ?>"><?php _e( 'Read more', 'greenline' ); ?> <span class="dashicons dashicons-arrow-right-alt"></span></a>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
		<div class="gl-pagination"><?php the_posts_pagination(); ?></div>
	<?php else : ?>
		<p><?php _e( 'Nothing found.', 'greenline' ); ?></p>
	<?php endif; ?>
</main>
<?php get_sidebar(); get_footer(); ?>
