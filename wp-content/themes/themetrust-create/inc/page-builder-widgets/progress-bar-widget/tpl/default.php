<?php
/**
 * @var $progress_bars
 */
?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<div class="ct-progress-bars">

    <?php foreach ($progress_bars as $progress_bar) :

        $color_style = '';
        $color = $progress_bar['color'];
        if ($color)
            $color_style = ' style="background:' . esc_attr($color) . ';"';

        ?>

        <div class="ct-progress-bar">

            <div class="ct-progress-title">
                <?php echo esc_html($progress_bar['title']) ?><span><?php echo esc_attr($progress_bar['value']); ?>%</span>
            </div>

            <div class="ct-progress-bar-wrap">

                <div <?php echo $color_style; ?> class="ct-progress-bar-content"
                                                 data-perc="<?php echo esc_attr($progress_bar['value']); ?>"></div>

                <div class="ct-progress-bar-bg"></div>

            </div>

        </div>

    <?php

    endforeach;

    ?>

</div>