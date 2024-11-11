<?php
/*
Template Name: Blog
*/
get_header(); ?>
<main>
    <h1>Blog Page</h1>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h2><?php the_title(); ?></h2>
        <div><?php the_excerpt(); ?></div>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
