<?php
get_header();
?>
<div class="portfolio-item">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            get_template_part('template-parts/content', 'portfolio');
        endwhile;
    endif;
    ?>
</div>
<?php
get_footer();
?>