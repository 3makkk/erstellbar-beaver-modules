<?php

/**
 * This file should be used to render each module instance.
 * You have access to two variables in this file:
 *
 * $module An instance of your module class.
 * $settings The module's settings.
 *
 * Example:
 */
?>

<?php do_action(ERSTELLBAR_SLUG. '_before_slick_slider'); ?>
<div class="erstellbar-slider" id="<?php echo $id ?>" data-slick="<?php echo $module->getSliderOptions() ?>">
    <?php if ($settings->slide_content_type === 'images'): ?>
        <?php foreach ($settings->images as $image_id): ?>
            <div class="erstellbar-slides">
                <?php echo wp_get_attachment_image($image_id, 'large') ?>
            </div>
        <?php endforeach ?>
    <?php elseif($settings->slide_content_type == 'posts'): ?>
        <?php $query = FLBuilderLoop::query($settings); ?>
        <?php if ($query->have_posts()): ?>
                <?php while ($query->have_posts()): $query->the_post(); ?>
                    <div class="erstellbar-slides">
                        <?php do_action(ERSTELLBAR_SLUG. '_before_slick_slider_image'); ?>
                        <a href="<?php echo $module->permalink(get_post()); ?>">
                        <?php the_post_thumbnail(); ?>
                        </a>

                        <?php do_action(ERSTELLBAR_SLUG. '_before_slick_slider_title'); ?>
                        <a href="<?php echo $module->permalink(get_post()); ?>">
                        <h5 class="erstellbar-slides-title"><?php the_title()?></h5>
                        </a>
                        <?php do_action(ERSTELLBAR_SLUG. '_before_slick_slider_content'); ?>

                        <?php the_content()?>

                        <?php do_action(ERSTELLBAR_SLUG. '_after_slick_slider_content'); ?>
                    </div>
                <?php endwhile; ?>
        <?php endif;
        wp_reset_postdata(); ?>
    <?php else: ?>
        <?php foreach ($settings->custom_slides as $custom_slide): ?>
            <div class="erstellbar-slides">
                <?php echo $custom_slide ?>
            </div>
        <?php endforeach ?>
    <?php endif; ?>
</div>
<?php do_action(ERSTELLBAR_SLUG. '_after_slick_slider'); ?>