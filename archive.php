<?php get_header(); ?>

<!-- GWL: THIS IS ARCHIVE.PHP -->

<h1><?php echo gmfw_return_page_title(); ?></h1>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

	<header>

		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

		<p class="caps">Posted on: <time datetime="<?php echo get_the_date('Y-m-d'); ?>" pubdate><?php echo get_the_date('Y-m-d'); ?></time></p>

	</header> <!-- end article header -->

	<section class="post_content">

		<?php // the_post_thumbnail( 'wpbs-featured' ); ?>

		<?php the_excerpt(); ?>

	</section>

	<footer>
	</footer>

</article>

<?php endwhile; ?>

<nav class="wp-prev-next">

	<?php echo paginate_links( ); ?>

	<?php /*
	<ul class="pager">
		<li class="previous"><?php next_posts_link('&laquo; Older Entries'); ?></li>
		<li class="next"><?php previous_posts_link('Newer Entries &raquo;'); ?></li>
	</ul>
	*/ ?>

</nav>

<?php else : ?>

<article id="post-not-found">
    <header>
    	<h1>No posts yet</h1>
    </header>
    <section class="post_content">
    	<p>Sorry, there don't seem to be any posts here.</p>
    </section>
    <footer>
    </footer>
</article>

<?php endif; ?>

<?php get_footer();