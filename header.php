<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <div class="container">
        <h1 class="site-title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
        <?php
        if (has_nav_menu('primary')) {
            wp_nav_menu(array(
                'theme_location' => 'primary', 
                'container'      => 'nav',
                'container_class'=> 'nav-menu',
                'menu_class'     => 'menu',
                'depth'          => 2, 
                'fallback_cb'    => false, 
                'walker'         => new Custom_Walker_Nav_Menu()
            ));
        }
        ?>
    </div>
</header>