<?php get_header(); ?>

<div class="banner">
    <img src="<?php echo esc_url(get_theme_mod('banner_image')); ?>" alt="Front Page Banner" class="banner-image max-h-screen w-full">
    <div class="container flex justify-between items-center w-full mx-auto absolute z-50 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
        <h1 class="flex-1 text-5xl text-white font-bold"><?php echo esc_html(get_theme_mod('banner_title', 'Welcome to My Website')); ?></h1>
        <img class="flex-1 w-[400px] h-auto" src="<?php echo get_template_directory_uri(); ?>/assets/gadgets.png" alt="Banner image">
    </div>
    
</div>

<?php get_footer(); ?>