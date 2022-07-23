<?php
/**
 * @var $accordion
 * @var $toggle
 * @var $style
 */
?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<div class="ct-accordion <?php echo $style; ?>" data-toggle="<?php echo ($toggle ? "true" : "false"); ?>">

    <?php foreach ($accordion as $panel) : ?>

        <div class="ct-panel">

            <div class="ct-panel-title"><?php echo esc_html($panel['title']); ?></div>

            <div class="ct-panel-content"><?php echo do_shortcode($panel['panel_content']); ?></div>

        </div>

        <?php

    endforeach;

    ?>

</div>