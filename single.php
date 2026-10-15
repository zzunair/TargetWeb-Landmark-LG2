<?php
/**
 * Single post template.
 *
 * @package Greenline
 */

get_header();
?>
<main id="primary" class="gl-main gl-container gl-container--narrow gl-page-wrap">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<header class="gl-page-header">
				<h1><?php the_title(); ?></h1>
				<p class="gl-post-meta"><?php echo esc_html( get_the_date() ); ?> · <?php the_author(); ?></p>
			</header>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="gl-post-thumb"><?php the_post_thumbnail( 'greenline-wide' ); ?></div>
			<?php endif; ?>
			<div class="gl-page-content"><?php the_content(); ?></div>
		</article>
		<?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
	<?php endwhile; ?>
</main>
<?php get_sidebar(); get_footer(); ?>
