<?php
function custom_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'custom-theme')
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');
function register_my_menus() {
    register_nav_menus(array(
        'primary-menu' => 'Primary Menu', 
    ));
}
add_action('init', 'register_my_menus');

function custom_theme_enqueue_styles() {
    wp_enqueue_style('custom-theme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_styles');

function mytheme_enqueue_ajax_filter_script() {
    wp_enqueue_script('mytheme-ajax-filter', get_template_directory_uri() . '/main.js', array('jquery'), null, true);
    wp_localize_script('mytheme-ajax-filter', 'mytheme_ajax_obj', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_ajax_filter_script');

function register_project_post_type() {
    $labels = array(
        'name'                  => 'Projects',
        'singular_name'         => 'Project',
        'menu_name'             => 'Projects',
        'name_admin_bar'        => 'Project',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Project',
        'new_item'              => 'New Project',
        'edit_item'             => 'Edit Project',
        'view_item'             => 'View Project',
        'all_items'             => 'All Projects',
        'search_items'          => 'Search Projects',
        'not_found'             => 'No projects found.',
        'not_found_in_trash'    => 'No projects found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'project'),
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
    );

    register_post_type('project', $args);
}

add_action('init', 'register_project_post_type');

function project_custom_meta_boxes() {
    add_meta_box(
        'project_details',
        'Project Details',
        'project_custom_meta_box_html',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'project_custom_meta_boxes');

function project_custom_meta_box_html($post) {
    $project_name = get_post_meta($post->ID, '_project_name', true);
    $project_description = get_post_meta($post->ID, '_project_description', true);
    $project_start_date = get_post_meta($post->ID, '_project_start_date', true);
    $project_end_date = get_post_meta($post->ID, '_project_end_date', true);
    $project_url = get_post_meta($post->ID, '_project_url', true);
    ?>
    <label>Project Name:</label>
    <input type="text" name="project_name" value="<?php echo esc_attr($project_name); ?>" style="width:100%;"><br><br>

    <label>Project Description:</label>
    <textarea name="project_description" style="width:100%;"><?php echo esc_textarea($project_description); ?></textarea><br><br>

    <label>Project Start Date:</label>
    <input type="date" name="project_start_date" value="<?php echo esc_attr($project_start_date); ?>"><br><br>

    <label>Project End Date:</label>
    <input type="date" name="project_end_date" value="<?php echo esc_attr($project_end_date); ?>"><br><br>

    <label>Project URL:</label>
    <input type="url" name="project_url" value="<?php echo esc_url($project_url); ?>" style="width:100%;">
    <?php
}

function save_project_custom_meta_data($post_id) {
    if (array_key_exists('project_name', $_POST)) {
        update_post_meta($post_id, '_project_name', sanitize_text_field($_POST['project_name']));
    }
    if (array_key_exists('project_description', $_POST)) {
        update_post_meta($post_id, '_project_description', sanitize_textarea_field($_POST['project_description']));
    }
    if (array_key_exists('project_start_date', $_POST)) {
        update_post_meta($post_id, '_project_start_date', sanitize_text_field($_POST['project_start_date']));
    }
    if (array_key_exists('project_end_date', $_POST)) {
        update_post_meta($post_id, '_project_end_date', sanitize_text_field($_POST['project_end_date']));
    }
    if (array_key_exists('project_url', $_POST)) {
        update_post_meta($post_id, '_project_url', esc_url_raw($_POST['project_url']));
    }
}
add_action('save_post', 'save_project_custom_meta_data');

function register_project_api_endpoint() {
    register_rest_route('api/v1', '/projects/', array(
        'methods' => 'GET',
        'callback' => 'get_projects_data',
        'permission_callback' => '__return_true', 
    ));
}
add_action('rest_api_init', 'register_project_api_endpoint');

function get_projects_data(WP_REST_Request $request) {
    $args = array(
        'post_type' => 'project',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    $projects = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $project_name = get_post_meta(get_the_ID(), '_project_name', true);
            $project_description = get_post_meta(get_the_ID(), '_project_description', true);
            $project_start_date = get_post_meta(get_the_ID(), '_project_start_date', true);
            $project_end_date = get_post_meta(get_the_ID(), '_project_end_date', true);
            $project_url = get_post_meta(get_the_ID(), '_project_url', true);

            $projects[] = array(
                'title' => get_the_title(),
                'project_name' => $project_name,
                'project_description' => $project_description,
                'project_start_date' => $project_start_date,
                'project_end_date' => $project_end_date,
                'project_url' => $project_url,
            );
        }
    }

    return new WP_REST_Response($projects, 200);
}


class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }
}

function mytheme_ajax_project_filter() {
    $args = array(
        'post_type' => 'project',
        'posts_per_page' => -1,
    );

    if (isset($_POST['project_name']) && !empty($_POST['project_name'])) {
        // $args['s'] = sanitize_text_field($_POST['project_name']);
        $args['meta_query'][] = array(
            'key' => '_project_name',
            'value' => sanitize_text_field($_POST['project_name']),
            'compare' => 'LIKE'
        );
    }
    
    if (isset($_POST['start_date']) && !empty($_POST['start_date'])) {
        $args['meta_query'][] = array(
            'key' => '_project_start_date',
            'value' => sanitize_text_field($_POST['start_date']),
            'compare' => '>=',
            'type' => 'DATE'
        );
    }
    
    if (isset($_POST['end_date']) && !empty($_POST['end_date'])) {
        $args['meta_query'][] = array(
            'key' => '_project_end_date',
            'value' => sanitize_text_field($_POST['end_date']),
            'compare' => '<=',
            'type' => 'DATE'
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="project-item">
                <h3><?php the_title(); ?></h3>
                <p><?php echo get_post_meta(get_the_ID(), '_project_name', true); ?></p>
                <p><?php echo get_post_meta(get_the_ID(), '_project_description', true); ?></p>
                <p>Start Date: <?php echo get_post_meta(get_the_ID(), '_project_start_date', true); ?></p>
                <p>End Date: <?php echo get_post_meta(get_the_ID(), '_project_end_date', true); ?></p>
                <p>Project URL: <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_project_url', true)); ?>" target="_blank">View Project</a></p>
            </div>
            <?php
        }
    } else {
        echo '<p>No projects found</p>';
    }
    wp_die();
}

add_action('wp_ajax_filter_projects', 'mytheme_ajax_project_filter');
add_action('wp_ajax_nopriv_filter_projects', 'mytheme_ajax_project_filter');

function custom_theme_sidebar() {
    register_sidebar(array(
        'name'          => 'Homepage Sidebar',
        'id'            => 'homepage_sidebar',
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'custom_theme_sidebar');
?>
