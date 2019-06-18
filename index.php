<?php get_header(); ?>

<!-- GWL : THIS IS INDEX.PHP -->

<!-- START PAGE CONTENT -->

<?php // --- START THE LOOP ---

	if ( have_posts() ) : while ( have_posts() ) : the_post();

		?><h1><?php echo the_title(); ?></h1><?php

		the_content();

	endwhile; else : ?>

		<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>

	<?php endif;

// --- END THE LOOP --- ?>

<!-- END PAGE CONTENT -->

<?php get_footer();