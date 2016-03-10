<?php $query = FLBuilderLoop::query($settings); ?>

<?php if ($query->have_posts()): ?>
    <div class="newsflash">
        <?php while ($query->have_posts()): $query->the_post(); ?>
            <div class="news">
                <h5 class="newsflash-title"><?php the_title()?></h5>
                <?php the_content()?>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif;
wp_reset_postdata(); ?>
