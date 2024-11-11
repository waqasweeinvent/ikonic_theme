<?php get_header(); ?>

<div class="project-filter">
    <h2>Filter Projects</h2>
    <form id="project-filter-form">
        <input type="text" id="project_name" name="project_name" placeholder="Project Name" />
        <input type="date" id="start_date" name="start_date" placeholder="Start Date" />
        <input type="date" id="end_date" name="end_date" placeholder="End Date" />
        <button type="submit">Filter</button>
    </form>
</div>

<div id="projects-list">
    <?php
    $args = array(
        'post_type' => 'project',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
    ?>
        <div class="project-item">
            <h3><?php the_title(); ?></h3>
            <p><?php echo get_post_meta(get_the_ID(), '_project_name', true); ?></p>
            <p><?php echo get_post_meta(get_the_ID(), '_project_description', true); ?></p>
            <p>Start Date: <?php echo get_post_meta(get_the_ID(), '_project_start_date', true); ?></p>
            <p>End Date: <?php echo get_post_meta(get_the_ID(), '_project_end_date', true); ?></p>
            <p>Project URL: <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_project_url', true)); ?>" target="_blank">View Project</a></p>
        </div>
    <?php endwhile; ?>
    <?php else : ?>
        <p>No projects found</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
