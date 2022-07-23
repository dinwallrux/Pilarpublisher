<?php

/*
Widget Name: Create Progress Bar
Description: Display a set of percentage based bars.
Author: ThemeTrust and LiveMesh
Author URI: http://themetrust.com
*/
if (class_exists('SiteOrigin_Widget')) {
class Create_Progress_Bars_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'ct-progress-bars',
            __('Create Progress Bar', 'create'),
            array(
                'description' => __('Display a percentage progress bar.', 'create'),
                'panels_icon' => 'dashicons dashicons-editor-alignleft',
                'help' => ''
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'create'),
                ),
                'progress-bars' => array(
                    'type' => 'repeater',
                    'label' => __('Progress Bars', 'create'),
                    'item_name' => __('Progress Bar', 'create'),
                    'item_label' => array(
                        'selector' => "[id*='progress-bars-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => __('Bar Title', 'create'),
                            'description' => __('The title for the bar', 'create'),
                        ),

                        'value' => array(
                            'type' => 'text',
                            'label' => __('Percentage Value', 'create'),
                            'description' => __('The percentage value for the bar.', 'create'),
                        ),

                        'color' => array(
                            'type' => 'color',
                            'label' => __('Bar color', 'create'),
                        ),
                    )
                ),
            )
        );
    }

    function initialize() {

        $this->register_frontend_scripts(
            array(
                array(
                    'ct-waypoints',
                    get_template_directory_uri() . '/js/jquery.waypoints.min.js',
                    array('jquery'),
                    1.0
                ),
            )
        );


        $this->register_frontend_scripts(
            array(
                array(
                    'ct-progress-bar',
                    get_template_directory_uri() . '/inc/page-builder-widgets/progress-bar-widget/js/progress-bar' . '.js',
                    array('jquery')
                ),
            )
        );

        $this->register_frontend_styles(array(
            array(
                'ct-progress-bar',
                get_template_directory_uri() . '/inc/page-builder-widgets/progress-bar-widget/css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'progress_bars' => !empty($instance['progress-bars']) ? $instance['progress-bars'] : array()
        );
    }

}

siteorigin_widget_register('ct-progress-bars', __FILE__, 'Create_Progress_Bars_Widget');
}