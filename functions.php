<?php

function jrkm_enqueue_styles() {
    wp_enqueue_style('jrkm-style', get_stylesheet_uri()); // Main CSS
    wp_enqueue_style('tailwindcss', get_template_directory_uri() . '/tailwind-output.css'); // Tailwind CSS
    wp_enqueue_script('jrkm-script', get_template_directory_uri() . '/js/main.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'jrkm_enqueue_styles');


//Theme Support
function jrkm_setup() {
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption'));
    register_nav_menus(array(
        'primary'   =>  __('Primary Menu', 'jrkm-blog'),
    ));
}

add_action('after_theme_setup', 'jrkm_setup');



//Adding Customizer Support
function jrkm_customize_register($wp_customize) {
    // Section for Header Customizations
    $wp_customize->add_section('jrkm_colors', array(
        'title' => __('Header Settings', 'jrkm-blog'),
        'priority' => 30,
    ));

     // Setting for Header Background Color
    $wp_customize->add_setting('header_background_color', array(
        'default' => '#111',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));

    // Control for Header Background Color
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_background_color_control', array(
        'label' => __('Header Background Color', 'jrkm-blog'),
        'section' => 'jrkm_colors',
        'settings' => 'header_background_color',
    )));

    //Logo Upload
    $wp_customize->add_section('jrkm_logo', array(
        'title' =>  __('Logo', 'jrkm-blog'),
        'priority'  =>  20,
    ));

    // Setting for Site Logo
    $wp_customize->add_setting('jrkm_logo', array(
        'default'   =>  '',
        'sanitize_callback' =>  'absint',
        'transport' =>  'refresh',
    ));

    // Control for Site Logo
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'jrkm_logo_control', array(
        'label' =>  __('Upload Logo', 'jrkm-blog'),
        'section'   =>  'jrkm_header_section',
        'settings'  =>  'jrkm_logo',
        'mime_type' =>  'image',
    )));

    // Footer Background Color
    $wp_customize->add_setting('footer_background_color', array(
        'default' => '#333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_background_color_control', array(
        'label' => __('Footer Background Color', 'jrkm-blog'),
        'section' => 'jrkm_colors',
        'settings' => 'footer_background_color',
    )));

    // ============  Banner image for Front page

    //Adding section for banner image
    $wp_customize->add_section('banner_section', array(
        'title' =>  __('Banner Settings', 'jrkm'),
        'priority'  =>  10,
    ));

    //Adding setting for the banner image
    $wp_customize->add_setting('banner_image', array(
        'default'   =>  '',
        'sanitize_callback' =>  'esc_url_raw',
    ));

    //Adding upload control for the banner image
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'banner_image_control',
        array(
            'label' =>  __('Banner Image', 'jrkm'),
            'section'   =>  'banner_section',
            'settings'  =>  'banner_image',
        )
    ));

    //Add setting for banner title
    $wp_customize->add_setting('banner_title', array(
        'default'   =>  __('Welcome to my Blog Website', 'jrkm'),
        'sanitize_callback' =>  'sanitize_text_field',
    ));

    //Add control for the banner title
    $wp_customize->add_control('banner_title_control', array(
        'label' =>  __('Banner Title', 'jrkm'),
        'section'   =>  'banner_section',
        'settings' => 'banner_title',
        'type'     => 'text',
    ));
    
}
add_action('customize_register', 'jrkm_customize_register');

//Adding Widgets Areas

function jrkm_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'jrkm-blog'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'jrkm-blog'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'jrkm_widgets_init');

//Adding custom post types
function jrkm_custom_post_types() {
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => __('Portfolios', 'jrkm-blog'),
            'singular_name' => __('Portfolio', 'jrkm-blog'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'portfolio'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'jrkm_custom_post_types');


//Adding custom fields
//For adding custom fields, you can either write custom code or use a plugin like Advanced Custom Fields (ACF).
function jrkm_add_portfolio_meta_box() {
    add_meta_box(
        'portfolio_meta_box',
        __('Portfolio Details', 'jrkm-blog'),
        'jrkm_portfolio_meta_box_callback',
        'portfolio',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'jrkm_add_portfolio_meta_box');

function jrkm_portfolio_meta_box_callback($post) {
    wp_nonce_field(basename(__FILE__), 'jrkm_nonce');
    $stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="project_url"><?php _e('Project URL', 'jrkm-blog'); ?></label>
        <input type="text" name="project_url" id="project_url" value="<?php if (isset($stored_meta['project_url'])) echo esc_attr($stored_meta['project_url'][0]); ?>" />
    </p>
    <?php
}

function jrkm_save_portfolio_meta($post_id) {
    if (!isset($_POST['jrkm_nonce']) || !wp_verify_nonce($_POST['jrkm_nonce'], basename(__FILE__))) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['project_url'])) {
        update_post_meta($post_id, 'project_url', sanitize_text_field($_POST['project_url']));
    }
}
add_action('save_post', 'jrkm_save_portfolio_meta');

//Post Thumbnails and Custom Logo
function jrkm_theme_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
    ));
}
add_action('after_setup_theme', 'jrkm_theme_setup');

//Adding support for Woocommerce
function jrkm_add_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'jrkm_add_woocommerce_support');