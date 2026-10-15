<?php
/**
 * Default page template.
 *
 * @package Greenline
 */

get_header();
?>
<main id="primary" class="gl-main gl-container gl-container--narrow gl-page-wrap">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<header class="gl-page-header"><h1><?php the_title(); ?></h1></header>
			<div class="gl-page-content"><?php the_content(); ?></div>
		</article>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
