<?php get_header(); ?>

<!-- GWL: THIS IS SINGLE.PHP -->

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

	<header>

		<?php

		// If there's a featured image, display it

		// - Featured images should be 900 px wide
		// - Height can vary, 250px looks nice

		if ( has_post_thumbnail() ) { ?>
			<img src="<?php the_post_thumbnail_url( ); ?>" style="margin-top: 1em; width: 900px;">
		<?php } ?>

		<h1><?php echo gmfw_return_page_title(); ?></h1>

	</header>

	<section class="post_content clearfix" itemprop="articleBody">

		<p class="caps"><strong><?php the_date(); ?></strong></p>

		<?php the_content(); ?>

		<?php // wp_link_pages(); ?>

	</section> <!-- end article section -->

	<footer>

		<?php // the_tags('<p class="tags"><span class="tags-title">' . __("Tags","wpbootstrap") . ':</span> ', ' ', '</p>'); ?>

		<?php
		/*
		// only show edit button if user has permission to edit posts
		if( $user_level > 0 ) {
		?>
		<a href="<?php echo get_edit_post_link(); ?>" class="btn btn-success edit-post"><i class="icon-pencil icon-white"></i> <?php _e("Edit post","wpbootstrap"); ?></a>
		<?php }
		*/ ?>

	</footer>

</article>

<?php // comments_template('',true); ?>

<?php endwhile; ?>

<?php /*
<nav class="wp-prev-next">
	<ul class="pager">
		<li class="previous"><?php next_posts_link('&laquo; Older Entries'); ?></li>
		<li class="next"><?php previous_posts_link('Newer Entries &raquo;'); ?></li>
	</ul>
</nav>
*/ ?>

<?php else : ?>

<article id="post-not-found">
    <header>
    	<h1>Not found</h1>
    </header>
    <section class="post_content">
    	<p>Sorry, but that page couldn't be found.</p>
    </section>
    <footer>
    </footer>
</article>

<?php endif; ?>

<?php get_footer();