<?php
$settings->posts_per_page = $settings->count;
$query = FLBuilderLoop::query($settings);
?>

    <?php if ($query->have_posts()): ?>
        <?php do_action(ERSTELLBAR_SLUG . '_before_newsflash'); ?>

        <?php if ($settings->show_title): ?>
            <h3 class="newsflash-title"><?php echo $settings->title_text; ?></h3>
            <?php do_action(ERSTELLBAR_SLUG . '_after_newsflash_title'); ?>
        <?php endif; ?>

        <div class="newsflash">
            <?php while ($query->have_posts()): $query->the_post(); ?>
                <div class="news">
                    <?php do_action(ERSTELLBAR_SLUG . '_before_newsflash_news_title'); ?>
                    <h5 class="newsflash-news-title"><?php the_title() ?></h5>
                    <?php do_action(ERSTELLBAR_SLUG . '_before_newsflash_news_content'); ?>
                    <?php if ($settings->show_excerpt): ?>
                        <?php the_excerpt(); ?>
                        <a href="<?php the_permalink() ?>"
                           class="read-more"><?php _e('Read more ›', ERSTELLBAR_SLUG); ?></a>
                    <?php else: ?>
                        <?php the_content(); ?>
                    <?php endif; ?>
                    <?php do_action(ERSTELLBAR_SLUG . '_after_newsflash_news_content'); ?>
                </div>
            <?php endwhile; ?>
        </div>
        <?php do_action(ERSTELLBAR_SLUG . '_after_newsflash'); ?>
    <?php endif;
    wp_reset_postdata(); ?>
