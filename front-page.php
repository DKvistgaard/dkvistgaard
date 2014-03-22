<?php get_header(); ?>

    <section class="latest-posts">

        <div class="container">

            <?php
            $args = array(
                'numberposts' => -1,
                'order_by' => 'post_date',
                'order' => 'DESC',
                'post_type' => 'post',
                'post_status' => 'publish'
            );
            $posts = get_posts($args);

            foreach ($posts as $post) {
                setup_postdata($post);
            ?>

                <article class="post-single">
                    <header class="post-head">
                        <h2><?php the_title(); ?></h2>
                    </header>
                    <?php the_excerpt(); ?>
                    <footer class="post-meta">
                        <time><?php the_date('jS \of\ F Y'); ?></time>
                    </footer>
                </article>

            <?php
            }
            ?>

        </div>

    </section>

<?php get_footer(); ?>