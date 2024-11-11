<?php get_header(); ?>
<div class="homepage-content">
    <div class="header-image">
        <img src="<?php echo get_template_directory_uri(); ?>/header-image.jfif" alt="Header Image">
    </div>

    <div class="content-with-sidebar">
        <main class="main-content">
            <h2>Welcome to Our Homepage</h2>
            <p>This is the main content area of the homepage.</p>
        </main>
        <aside class="homepage-sidebar">
            <h3 class="widget-title">Recent Projects</h3>
            <ul class="project-list">
                <?php
                $args = array(
                    'post_type' => 'project',
                    'posts_per_page' => 5, 
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                $projects = new WP_Query($args);
                
                if ($projects->have_posts()) :
                    while ($projects->have_posts()) : $projects->the_post(); ?>
                        <li class="project-item">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </li>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <li>No projects found.</li>
                <?php endif; ?>
            </ul>
        </aside>
    </div>
</div>

<?php get_footer(); ?>
