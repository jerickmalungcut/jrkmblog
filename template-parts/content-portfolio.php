<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    </header>

    <div class="entry-content">
        <?php the_content(); ?>
        <?php if ($project_url = get_post_meta(get_the_ID(), 'project_url', true)) : ?>
            <p><strong>Project URL:</strong> <a href="<?php echo esc_url($project_url); ?>" target="_blank"><?php echo esc_html($project_url); ?></a></p>
        <?php endif; ?>
    </div>
</article>