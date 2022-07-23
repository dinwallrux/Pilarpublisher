<?php

/*
Widget Name: Create Accordion
Description: Displays collapsible content.
Author: ThemeTrust & Live Mesh
Author URI: http://themetrust.com
*/

if (class_exists('SiteOrigin_Widget')) {
class CREATE_Accordion_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'create-accordion',
            __('Create Accordion', 'create'),
            array(
                'description' => __('Displays collapsible content.', 'create'),
                'panels_icon' => 'dashicons dashicons-list-view',
                'help' => ''
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'create'),
                ),

                'style' => array(
                    'type' => 'select',
                    'label' => __('Choose Accordion Style', 'create'),
                    'state_emitter' => array(
                        'callback' => 'select',
                        'args' => array('style')
                    ),
                    'default' => 'style1',
                    'options' => array(
                        'style1' => __('Gray', 'create'),
                        'style2' => __('Contrast', 'create'),
                        'style3' => __('Minimal', 'create'),
                    )
                ),

                'toggle' => array(
                    'type' => 'checkbox',
                    'label' => __('Allow to function like toggle?', 'create'),
                    'description' => __('Check if multiple panels can be opened.', 'create')
                ),

                'accordion' => array(
                    'type' => 'repeater',
                    'label' => __('Accordion', 'create'),
                    'item_name' => __('Panel', 'create'),
                    'item_label' => array(
                        'selector' => "[id*='accordion-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => __('Panel Title', 'create'),
                            'description' => __('The title for the panel.', 'create'),
                        ),

                        'panel_content' => array(
                            'type' => 'tinymce',
                            'label' => __('Panel Content', 'create'),
                            'description' => __('The content in the panel.', 'create'),
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
                    'create-accordion',
                    get_template_directory_uri() . '/inc/page-builder-widgets/accordion-widget/js/accordion' . '.js',
                    array('jquery')
                ),
            )
        );

        $this->register_frontend_styles(array(
            array(
                'create-accordion',
                get_template_directory_uri() . '/inc/page-builder-widgets/accordion-widget/css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'style' => $instance['style'],
            'toggle' => $instance['toggle'],
            'accordion' => !empty($instance['accordion']) ? $instance['accordion'] : array()
        );
    }

}

siteorigin_widget_register('create-accordion', __FILE__, 'CREATE_Accordion_Widget');
}