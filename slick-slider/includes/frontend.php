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


<div class="erstellbar-slider" id="<?php echo $id ?>" data-slick="<?php echo $module->getSliderOptions() ?>">
    <?php if ($settings->slide_content_type === 'images'): ?>
        <?php foreach ($settings->images as $image_id): ?>
            <div class="erstellbar-slides">
                <?php echo wp_get_attachment_image($image_id, 'large') ?>
            </div>
        <?php endforeach ?>
    <?php endif; ?>
</div>