<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php the_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <!-- Navigation bar -->
    <header class="fixed inset-0 z-50 flex justify-center items-start py-6<?php echo is_front_page() ? ' bg-transparent text-white ' : ' bg-blue-500 text-slate-800'; ?>" style="background-color: <?php echo get_theme_mod('header_background_color', 'transparent'); ?>">
        <div class="container flex justify-between items-center">
            <div class="logo text-2xl font-bold">
            <?php
                if (get_theme_mod('jrkm_logo')) {
                    echo wp_get_attachment_image(get_theme_mod('jrkm_logo'), 'full');
                } else {
                    echo '<h1>' . get_bloginfo('name') . '</h1>';
                }
            ?>
            </div>
        
            <nav class="main-navigation">
                <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
            </nav>
        </div>

        
    </header>