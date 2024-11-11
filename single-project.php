<?php
/**
 * Template for displaying a single Project post
 */

get_header(); ?>

<div class="project-single-container">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();

            if (function_exists('get_field')) {
                $project_name = get_field('project_name');
                $project_description = get_field('project_description');
                $project_start_date = get_field('project_start_date');
                $project_end_date = get_field('project_end_date');
                $project_url = get_field('project_url');
            } else {
                $project_name = get_post_meta(get_the_ID(), '_project_name', true);
                $project_description = get_post_meta(get_the_ID(), '_project_description', true);
                $project_start_date = get_post_meta(get_the_ID(), '_project_start_date', true);
                $project_end_date = get_post_meta(get_the_ID(), '_project_end_date', true);
                $project_url = get_post_meta(get_the_ID(), '_project_url', true);
            }
    ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="project-header">
                <h1 class="project-title"><?php echo esc_html($project_name); ?></h1>
            </header>

            <div class="project-content">
                <?php if ($project_description) : ?>
                    <p class="project-description"><?php echo esc_html($project_description); ?></p>
                <?php endif; ?>

                <div class="project-dates">
                    <?php if ($project_start_date) : ?>
                        <p><strong>Start Date:</strong> <?php echo esc_html($project_start_date); ?></p>
                    <?php endif; ?>
                    <?php if ($project_end_date) : ?>
                        <p><strong>End Date:</strong> <?php echo esc_html($project_end_date); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($project_url) : ?>
                    <p class="project-url">
                        <strong>Project URL:</strong> 
                        <a href="<?php echo esc_url($project_url); ?>" target="_blank"><?php echo esc_html($project_url); ?></a>
                    </p>
                <?php endif; ?>
            </div>
        </article>

    <?php
        endwhile;
    else :
        echo '<p>No project found.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>
