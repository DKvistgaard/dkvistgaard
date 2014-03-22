<?php get_header(); ?>

    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
    ?>
            <main class="content">
                <div class="container">
                    <?php the_content(); ?>
                </div>
            </main>
    <?php
        }
    }
    ?>

<?php get_footer(); ?>