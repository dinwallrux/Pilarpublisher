<?php

if( !defined('WP_UNINSTALL_PLUGIN') ){
    die;
}

delete_option('tuskcode_bing_map_api_key');      
//delete_option('tuskcode_bing_map_address');
delete_option('tuskcode_bing_map_width');
delete_option('tuskcode_bing_map_height');
delete_option('tuskcode_bing_map_pin');
delete_option('tuskcode_bing_map_type');
delete_option('tuskcode_bing_map_zoom');
//delete_option('bing_map_custom_pin_url');
delete_option('tuskcode_bing_map_scroll');
delete_option('widget_tuskcode_bing_map');
delete_option('tuskcode_bing_map_pins');



