<?php

//Add project post type to page builder defaults
function create_siteorgin_defaults($defaults){
	// Post types
	$defaults['post-types'] = array('page', 'post', 'project');
	return $defaults;
}
add_filter( 'siteorigin_panels_settings_defaults', 'create_siteorgin_defaults' );

//Remove the built-in posts carousel widget
function create_panels_widgets( $widgets ){
	unset($widgets['SiteOrigin_Widget_PostCarousel_Widget']);
	return $widgets;
}
add_filter( 'siteorigin_panels_widgets', 'create_panels_widgets', 11);



function create_filter_siteorigin_active_widgets($active){
    $active['so-price-table-widget'] = true;
	$active['so-headline-widget'] = true;
	$active['so-social-media-buttons-widget'] = true;
	$active['so-post-carousel-widget'] = false;
    return $active;
}
add_filter('siteorigin_widgets_active_widgets', 'create_filter_siteorigin_active_widgets');

function create_siteoriginpanels_row_attributes($attr, $row) {
  if(!empty($row['style']['class'])) {
    if(empty($attr['style'])) $attr['style'] = '';
    $attr['style'] .= 'margin-bottom: 0px;';
    $attr['style'] .= 'margin-left: 0px;';
    $attr['style'] .= 'margin-right: 0px;';
  }

  return $attr;
}
add_filter('siteorigin_panels_row_attributes', 'create_siteoriginpanels_row_attributes', 10, 2);


//Add custom row styles
function create_panels_row_background_styles($fields) {
 
  $fields['custom_row_id'] = array(
	     'name'      => __('Custom ID', 'create'),
	     'type'      => 'text',
	     'group'     => 'attributes',
	     'priority'  => 1,
  );

  $fields['equal_column_height'] = array(
        'name'      => __('Equal Column Height', 'create'),
        'type'      => 'select',
        'group'     => 'layout',
        'default'   => 'no',
        'priority'  => 10,
        'options'   => array(
             "no"      => __("No", "create"),
             "yes"   => __("Yes", "create"),
              ),
  );

  $fields['padding_top'] = array(
        'name'      => __('Padding Top', 'create'),
        'type'      => 'measurement',
        'group'     => 'layout',
        'priority'  => 8.4,
  );
  $fields['padding_bottom'] = array(
        'name'      => __('Padding Bottom', 'create'),
        'type'      => 'measurement',
        'group'     => 'layout',
        'priority'  => 8.5,
  );
  $fields['padding_left'] = array(
        'name'      => __('Padding Left', 'create'),
        'type'      => 'measurement',
        'group'     => 'layout',
        'priority'  => 9,
      );
  $fields['padding_right'] = array(
        'name'      => __('Padding Right', 'create'),
        'type'      => 'measurement',
        'group'     => 'layout',
        'priority'  => 9,
      );
  $fields['background_image'] = array(
        'name'      => __('Background Image', 'create'),
        'group'     => 'design',
        'type'      => 'image',
        'priority'  => 5,
      );
  $fields['background_image_position'] = array(
        'name'      => __('Background Image Position', 'create'),
        'type'      => 'select',
        'group'     => 'design',
        'default'   => 'center top',
        'priority'  => 6,
        'options'   => array(
               "left top"       => __("Left Top", "create"),
               "left center"    => __("Left Center", "create"),
               "left bottom"    => __("Left Bottom", "create"),
               "center top"     => __("Center Top", "create"),
               "center center"  => __("Center Center", "create"),
               "center bottom"  => __("Center Bottom", "create"),
               "right top"      => __("Right Top", "create"),
               "right center"   => __("Right Center", "create"),
               "right bottom"   => __("Right Bottom", "create")
                ),
      );
  $fields['background_image_style'] = array(
        'name'      => __('Background Image Style', 'create'),
        'type'      => 'select',
        'group'     => 'design',
        'default'   => 'cover',
        'priority'  => 6,
        'options'   => array(
             "cover"      => __("Cover", "create"),
             "parallax"   => __("Parallax", "create"),
             "no-repeat"  => __("No Repeat", "create"),
             "repeat"     => __("Repeat", "create"),
             "repeat-x"   => __("Repeat-X", "create"),
             "repeat-y"   => __("Repeat-y", "create"),
              ),
        );
  $fields['border_top'] = array(
        'name'      => __('Border Top Size', 'create'),
        'type'      => 'measurement',
        'group'     => 'design',
        'priority'  => 8,
  );
  $fields['border_top_color'] = array(
        'name'      => __('Border Top Color', 'create'),
        'type'      => 'color',
        'group'     => 'design',
        'priority'  => 8.5,
      );
  $fields['border_bottom'] = array(
        'name'      => __('Border Bottom Size', 'create'),
        'type'      => 'measurement',
        'group'     => 'design',
        'priority'  => 9,
  );
  $fields['border_bottom_color'] = array(
        'name' => __('Border Bottom Color', 'create'),
        'type' => 'color',
        'group' => 'design',
        'priority' => 9.5,
  );
  return $fields;
}
add_filter('siteorigin_panels_row_style_fields', 'create_panels_row_background_styles');

function create_panels_remove_row_background_styles($fields) {
 unset( $fields['background_image_attachment'] );
 unset( $fields['background_display'] );
 //unset( $fields['padding'] );
 unset( $fields['border_color'] );
 return $fields;
}
add_filter('siteorigin_panels_row_style_fields', 'create_panels_remove_row_background_styles');

function create_panels_row_background_styles_attributes($attributes, $args) {

  if(!empty($args['background_image'])) {
    $url = wp_get_attachment_image_src( $args['background_image'], 'full' );
	$unique_class = 'row-'.uniqid();
    if(empty($url) || $url[0] == site_url() ) {
		$bg_img = $args['background_image'];
      } else {
		$bg_img = $url[0];
      }
	  $attributes['style'] .= 'background-image: url(' . $bg_img . ');';
      if(!empty($args['background_image_style'])) {
            switch( $args['background_image_style'] ) {
              case 'no-repeat':
                $attributes['style'] .= 'background-repeat: no-repeat;';
				$attributes['style'] .= 'background-position: ' . $args['background_image_position'] .';';
                break;
              case 'repeat':
                $attributes['style'] .= 'background-repeat: repeat;';
                break;
              case 'repeat-x':
                $attributes['style'] .= 'background-repeat: repeat-x;';
                break;
              case 'repeat-y':
                $attributes['style'] .= 'background-repeat: repeat-y;';
                break;
              case 'cover':
                $attributes['style'] .= 'background-size: cover;';
				$attributes['style'] .= 'background-position: ' . $args['background_image_position'] .';';
                break;
              case 'parallax':
				//$attributes['style'] = '';
				wp_enqueue_script( 'create-parallax-scroll');
                $attributes['class'][] .= 'parallax-section';
				$attributes['class'][] .= $unique_class;
				$attributes['data-parallax-image'] = $bg_img;
				$attributes['data-parallax-id'] = '.'.$unique_class;
                break;
            }
        }
  }
  
  if(!empty($args['padding_top'])) {
    if( function_exists('is_numeric' ) ) {
      if (is_numeric($args['padding_top'])) {
        $attributes['style'] .= 'padding-top: '.esc_attr($args['padding_top']).'px; ';
      } else {
         $attributes['style'] .= 'padding-top: '.esc_attr($args['padding_top']).'; ';
      }
    } else {
       $attributes['style'] .= 'padding-top: '.esc_attr($args['padding_top']).'; ';
    }
  }
  if(!empty($args['padding_bottom'])){
    if( function_exists('is_numeric' ) ) {
      if (is_numeric($args['padding_bottom'])) {
        $attributes['style'] .= 'padding-bottom: '.esc_attr($args['padding_bottom']).'px; ';
      } else {
        $attributes['style'] .= 'padding-bottom: '.esc_attr($args['padding_bottom']).'; ';
      }
    } else {
      $attributes['style'] .= 'padding-bottom: '.esc_attr($args['padding_bottom']).'; ';
    }
 }
 
 if(!empty($args['padding_left'])){
   $attributes['style'] .= 'padding-left: '.esc_attr($args['padding_left']).'; ';
 }
 if(!empty($args['padding_right'])){
   $attributes['style'] .= 'padding-right: '.esc_attr($args['padding_right']).'; ';
 }
 if(!empty($args['border_top'])){
   $attributes['style'] .= 'border-top: '.esc_attr($args['border_top']).' solid; ';
 }
 if(!empty($args['border_top_color'])){
   $attributes['style'] .= 'border-top-color: '.$args['border_top_color'].'; ';
 }
 if(!empty($args['border_bottom'])){
   $attributes['style'] .= 'border-bottom: '.esc_attr($args['border_bottom']).' solid; ';
 }
  if(!empty($args['border_bottom_color'])){
   $attributes['style'] .= 'border-bottom-color: '.$args['border_bottom_color'].'; ';
 }

if(!empty($args['custom_row_id'])){
   $attributes['data-row-id'] = $args['custom_row_id'];
 }

if(!empty($args['equal_column_height'])){
	if($args['equal_column_height']=="yes"){
   		$attributes['class'][] = 'equal-column-height';
	}
 }

  return $attributes;
}
add_filter('siteorigin_panels_row_style_attributes', 'create_panels_row_background_styles_attributes', 10, 2);





//////////////////////////////////////////////
//Prebuilt Layouts
//////////////////////////////////////////////

function create_prebuilt_layouts($layouts){
    $layouts['home-agency'] = array(
        'name' => __('Home: Agency', 'create'),  
        'description' => __('Layout for demo Home: Agency page.', 'create'),
		'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/home_agency.jpg',
        'widgets' => 
		  array (
		    0 => 
		    array (
		      'title' => '',
		      'text' => '[rev_slider alias="home-slider-agency"]',
		      'filter' => false,
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Text',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 0,
		        'id' => 0,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    1 => 
		    array (
		      'type' => 'visual',
		      'title' => '',
		      'text' => '<h1 style="text-align: center;"><span style="color: #bb9f7c;">Create</span> is a multi-purpose WordPress theme that gives you the power to create many different styles of websites. </h1>',
		      'filter' => '1',
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Black_Studio_TinyMCE',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 1,
		        'id' => 1,
		        'style' => 
		        array (
		          'widget_css' => 'line-height: 3.8em !important;',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    2 => 
		    array (
		      'title' => '',
		      'show_filter' => 'no',
		      'filter_alignment' => 'center',
		      'count' => '4',
		      'thumb_proportions' => 'landscape',
		      'layout' => 'masonry without gutter',
		      'columns' => '4',
		      'skills' => 
		      array (
		        'illustration' => '',
		        'mobile' => '',
		        'motion' => '',
		        'photography' => '',
		        'web' => '',
		      ),
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'hover_effect' => 'effect-1',
		      'hover_color' => '#1aafaf',
		      'hover_text_color' => '',
		      'show_skills' => 'yes',
		      'show_load_more' => 'no',
		      'enable_lightbox' => 'no',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Portfolio',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 0,
		        'id' => 2,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    3 => 
		    array (
		      'features' => 
		      array (
		        0 => 
		        array (
		          'container_color' => '',
		          'icon' => 'fontawesome-list-alt',
		          'icon_color' => '#bb9f7c',
		          'icon_image' => '0',
		          'title' => 'Page Builder',
		          'text' => 'Create comes with a page builder that allows you to create pages exactly how you want. ',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        1 => 
		        array (
		          'container_color' => '',
		          'icon' => 'fontawesome-tablet',
		          'icon_color' => '#bb9f7c',
		          'icon_image' => '0',
		          'title' => 'Responsive Layout',
		          'text' => 'Create is a responsive theme. Its layout adjusts to look great on any screen size or device.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        2 => 
		        array (
		          'container_color' => '',
		          'icon' => 'fontawesome-eye',
		          'icon_color' => '#bb9f7c',
		          'icon_image' => '0',
		          'title' => 'Retina Ready',
		          'text' => 'Built with the latest technology in mind, rest assured that your site will look crisp on retina displays.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        3 => 
		        array (
		          'container_color' => '',
		          'icon' => 'fontawesome-tasks',
		          'icon_color' => '#bb9f7c',
		          'icon_image' => '0',
		          'title' => 'Multiple Headers',
		          'text' => 'Packed with 5 different header layouts, you can use this theme to create many different styles of websites.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        4 => 
		        array (
		          'container_color' => '',
		          'icon' => 'fontawesome-cog',
		          'icon_color' => '#bb9f7c',
		          'icon_image' => '0',
		          'title' => 'Powerful Options',
		          'text' => 'Create comes with tons of options built right into the WordPress Customizer. So you can give your site a unique look.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        5 => 
		        array (
		          'container_color' => '',
		          'icon' => 'fontawesome-th-list',
		          'icon_color' => '#bb9f7c',
		          'icon_image' => '0',
		          'title' => 'Built-in Mega Menu',
		          'text' => 'There is a mega menu built in for those sites that have a lot of pages. You can easily add icons to menu items.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		      ),
		      'container_shape' => 'round',
		      'container_size' => 25,
		      'icon_size' => 25,
		      'per_row' => 3,
		      'responsive' => true,
		      'title_link' => false,
		      'icon_link' => false,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Features_Widget',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 0,
		        'id' => 3,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    4 => 
		    array (
		      'type' => 'visual',
		      'title' => '',
		      'text' => '<h1>Our <span style="color: #ffffff;">customers\'</span> happiness is what matters to us.</h1>',
		      'filter' => '1',
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Black_Studio_TinyMCE',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 0,
		        'id' => 4,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'padding' => '50px',
		          'background' => '#232323',
		          'background_display' => 'tile',
		          'font_color' => '#9e9e9e',
		        ),
		      ),
		    ),
		    5 => 
		    array (
		      'title' => '',
		      'count' => '4',
		      'layout' => 'carousel',
		      'columns' => '1',
		      'alignment' => 'center',
		      'order' => 'rand',
		      'carousel-nav-color' => '#ffffff',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Testimonials',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 1,
		        'id' => 5,
		        'style' => 
		        array (
		          'padding' => '50px',
		          'background' => '#1aafaf',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    6 => 
		    array (
		      'type' => 'visual',
		      'title' => '',
		      'text' => '<h1 style="text-align: center;">We\'ve been known to <span style="color: #000000;">share</span> our thoughts.</h1>',
		      'filter' => '1',
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Black_Studio_TinyMCE',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 0,
		        'id' => 6,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'padding' => '0px',
		          'background' => '#ffffff',
		          'background_display' => 'tile',
		          'font_color' => '#878787',
		        ),
		      ),
		    ),
		    7 => 
		    array (
		      'title' => '',
		      'count' => '9',
		      'layout' => 'carousel',
		      'columns' => '3',
		      'alignment' => 'left',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'show_excerpt' => 'no',
		      'carousel-nav-color' => '#1aafaf',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Blog',
		        'raw' => false,
		        'grid' => 6,
		        'cell' => 0,
		        'id' => 7,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    8 => 
		    array (
		      'type' => 'html',
		      'title' => '',
		      'text' => '<h3 style="text-align: center;">Unlimited Parallax Sections</h3>
		<p style="text-align: center;">Create unlimited parallax sections for your pages. It\'s as easy as adding a new page builder row, uploading an image, and choosing "parallax from the drop down.</p>',
		      'filter' => '1',
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Black_Studio_TinyMCE',
		        'raw' => false,
		        'grid' => 7,
		        'cell' => 1,
		        'id' => 8,
		        'style' => 
		        array (
		          'padding' => '0px',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    9 => 
		    array (
		      'text' => 'LEARN MORE',
		      'url' => '#',
		      'new_window' => false,
		      'button_icon' => 
		      array (
		        'icon_selected' => '',
		        'icon_color' => '',
		        'icon' => '0',
		      ),
		      'design' => 
		      array (
		        'align' => 'center',
		        'theme' => 'flat',
		        'button_color' => '#bb9f7c',
		        'text_color' => '#ffffff',
		        'hover' => true,
		        'font_size' => '1',
		        'rounding' => '0.25',
		        'padding' => '1',
		      ),
		      'attributes' => 
		      array (
		        'id' => '',
		        'title' => '',
		        'onclick' => '',
		      ),
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Button_Widget',
		        'raw' => false,
		        'grid' => 7,
		        'cell' => 1,
		        'id' => 9,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    10 => 
		    array (
		      'title' => 'Use Create to build your next site.',
		      'sub_title' => false,
		      'design' => 
		      array (
		        'background_color' => '#1aafaf',
		        'border_color' => '',
		        'button_align' => 'right',
		      ),
		      'button' => 
		      array (
		        'text' => 'BUY CREATE NOW',
		        'url' => 'http://themetrust.com/themes/create',
		        'button_icon' => 
		        array (
		          'icon_selected' => '',
		          'icon_color' => '',
		          'icon' => '0',
		        ),
		        'design' => 
		        array (
		          'theme' => 'wire',
		          'button_color' => '#ffffff',
		          'text_color' => '#1aafaf',
		          'hover' => true,
		          'font_size' => '1',
		          'rounding' => '0.25',
		          'padding' => '1',
		        ),
		        'attributes' => 
		        array (
		          'id' => '',
		          'title' => '',
		          'onclick' => '',
		        ),
		      ),
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Cta_Widget',
		        'raw' => false,
		        'grid' => 8,
		        'cell' => 0,
		        'id' => 10,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		  ),
		  'grids' => 
		  array (
		    0 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    1 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'equal_column_height' => 'no',
		        'padding_top' => '70px',
		        'padding_bottom' => '70px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    2 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full-stretched',
		        'background' => '#f9f8f4',
		        'equal_column_height' => 'no',
		        'padding_top' => '0px',
		        'padding_bottom' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    3 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'equal_column_height' => 'no',
		        'padding_top' => '70px',
		        'padding_bottom' => '60px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    4 => 
		    array (
		      'cells' => 2,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'yes',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    5 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full',
		        'equal_column_height' => 'no',
		        'padding_top' => '50px',
		        'padding_bottom' => '50px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    6 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full',
		        'equal_column_height' => 'no',
		        'padding_top' => '0px',
		        'padding_bottom' => '50px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    7 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full',
		        'equal_column_height' => 'no',
		        'padding_top' => '140px',
		        'padding_bottom' => '140px',
		        'background_image' => 957,
		        'background_image_position' => 'left top',
		        'background_image_style' => 'parallax',
		      ),
		    ),
		    8 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full',
		        'background' => '#1aafaf',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		  ),
		  'grid_cells' => 
		  array (
		    0 => 
		    array (
		      'grid' => 0,
		      'weight' => 1,
		    ),
		    1 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.10471092077087999772100346262959646992385387420654296875,
		    ),
		    2 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.7745182012847899866159195880754850804805755615234375,
		    ),
		    3 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.120770877944330001785289141480461694300174713134765625,
		    ),
		    4 => 
		    array (
		      'grid' => 2,
		      'weight' => 1,
		    ),
		    5 => 
		    array (
		      'grid' => 3,
		      'weight' => 1,
		    ),
		    6 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.58580182951797998835985481491661630570888519287109375,
		    ),
		    7 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.41419817048202001164014518508338369429111480712890625,
		    ),
		    8 => 
		    array (
		      'grid' => 5,
		      'weight' => 1,
		    ),
		    9 => 
		    array (
		      'grid' => 6,
		      'weight' => 1,
		    ),
		    10 => 
		    array (
		      'grid' => 7,
		      'weight' => 0.204186413902050001301091697314404882490634918212890625,
		    ),
		    11 => 
		    array (
		      'grid' => 7,
		      'weight' => 0.59162717219589999739781660537119023501873016357421875,
		    ),
		    12 => 
		    array (
		      'grid' => 7,
		      'weight' => 0.204186413902050001301091697314404882490634918212890625,
		    ),
		    13 => 
		    array (
		      'grid' => 8,
		      'weight' => 1,
		    ),
		  ),
    );

	$layouts['home-pro'] = array(
		'name' => __('Home: Professional', 'create'),
		'description' => __('Layout for demo Home: Professional page.', 'create'),
		'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/home_pro.jpg',
        'widgets' => 
		  array (
		    0 => 
		    array (
		      'title' => '',
		      'text' => '[rev_slider alias="home_slider_pro"]',
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Text',
		        'grid' => 0,
		        'cell' => 0,
		        'id' => 0,
		        'style' => 
		        array (
		          'background_image_attachment' => false,
		          'background_display' => 'tile',
		        ),
		      ),
		      'filter' => false,
		    ),
		    1 => 
		    array (
		      'type' => 'visual',
		      'title' => '',
		      'text' => '<h3 style="text-align: center;"><span style="color: #242424;">THE ONLY THEME YOU NEED</span></h3><p style="text-align: center;">Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>',
		      'filter' => '1',
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Black_Studio_TinyMCE',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 0,
		        'id' => 1,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'widget_css' => '	',
		          'padding' => '70px',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    2 => 
		    array (
		      'type' => 'visual',
		      'title' => '',
		      'text' => '<p><img class="alignright size-full wp-image-520" src="http://create.themetrust.com/wp-content/uploads/2015/07/macbook-pro-cropped-right.jpg" alt="macbook-pro-cropped-right" width="1293" height="951" /></p>',
		      'filter' => '1',
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Black_Studio_TinyMCE',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 1,
		        'id' => 2,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    3 => 
		    array (
		      'features' => 
		      array (
		        0 => 
		        array (
		          'container_color' => '',
		          'icon' => 'elegantline-layers',
		          'icon_color' => '#ffffff',
		          'icon_image' => '0',
		          'title' => 'Page Builder',
		          'text' => 'Create comes with a page builder that allows you to create pages exactly how you want. ',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        1 => 
		        array (
		          'container_color' => '',
		          'icon' => 'elegantline-mobile',
		          'icon_color' => '#ffffff',
		          'icon_image' => '0',
		          'title' => 'Responsive Layout',
		          'text' => 'Create is a responsive theme. Its layout adjusts to look great on any screen size or device.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        2 => 
		        array (
		          'container_color' => '',
		          'icon' => 'elegantline-laptop',
		          'icon_color' => '#ffffff',
		          'icon_image' => '0',
		          'title' => 'Retina Ready',
		          'text' => 'Built with the latest technology in mind, rest assured that your site will look crisp on retina displays.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        3 => 
		        array (
		          'container_color' => '',
		          'icon' => 'elegantline-browser',
		          'icon_color' => '#ffffff',
		          'icon_image' => '0',
		          'title' => 'Multiple Headers',
		          'text' => 'Packed with 5 different header layouts, you can use this theme to create many different styles of websites.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        4 => 
		        array (
		          'container_color' => '',
		          'icon' => 'elegantline-gears',
		          'icon_color' => '#ffffff',
		          'icon_image' => '0',
		          'title' => 'Powerful Options',
		          'text' => 'Create comes with tons of options built right into the WordPress Customizer. So you can give your site a unique look.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        5 => 
		        array (
		          'container_color' => '',
		          'icon' => 'elegantline-genius',
		          'icon_color' => '#ffffff',
		          'icon_image' => '0',
		          'title' => 'Built-in Mega Menu',
		          'text' => 'There is a mega menu built in for those sites that have a lot of pages. You can easily add icons to menu items.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		      ),
		      'container_shape' => 'round',
		      'container_size' => 25,
		      'icon_size' => 25,
		      'per_row' => 3,
		      'responsive' => true,
		      'title_link' => false,
		      'icon_link' => false,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Features_Widget',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 0,
		        'id' => 3,
		        'style' => 
		        array (
		          'class' => 'left',
		          'widget_css' => 'p{opacity: .5}',
		          'padding' => '50px',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    4 => 
		    array (
		      'title' => 'Some of our latest work.',
		      'sub_title' => '',
		      'design' => 
		      array (
		        'background_color' => '#ba9e78',
		        'border_color' => false,
		        'button_align' => 'right',
		      ),
		      'button' => 
		      array (
		        'text' => 'View More',
		        'url' => '',
		        'button_icon' => 
		        array (
		          'icon_selected' => '',
		          'icon_color' => false,
		          'icon' => 0,
		        ),
		        'design' => 
		        array (
		          'theme' => 'flat',
		          'button_color' => '#ffffff',
		          'text_color' => '#ba9e78',
		          'hover' => true,
		          'font_size' => '1',
		          'rounding' => '0.25',
		          'padding' => '1',
		          'align' => 'center',
		        ),
		        'attributes' => 
		        array (
		          'id' => '',
		          'title' => '',
		          'onclick' => '',
		        ),
		        'new_window' => false,
		      ),
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Cta_Widget',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 0,
		        'id' => 4,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    5 => 
		    array (
		      'title' => '',
		      'show_filter' => 'no',
		      'filter_alignment' => 'center',
		      'count' => '3',
		      'thumb_proportions' => 'landscape',
		      'layout' => 'rows without gutter',
		      'columns' => '3',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'hover_effect' => 'effect-1',
		      'hover_color' => '',
		      'hover_text_color' => '',
		      'show_skills' => 'yes',
		      'show_load_more' => 'no',
		      'enable_lightbox' => 'no',
		      'skills' => 
		      array (
		      ),
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Portfolio',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 0,
		        'id' => 5,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    6 => 
		    array (
		      'type' => 'visual',
		      'title' => '',
		      'text' => '<h3 style="text-align: center;"><span style="color: #242424;">FROM THE BLOG</span></h3><p style="text-align: center;">This is a blog widget that you can add anywhere. Display recent posts as a grid or carousel.</p>',
		      'filter' => '1',
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Black_Studio_TinyMCE',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 0,
		        'id' => 6,
		        'style' => 
		        array (
		          'padding' => '50px',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    7 => 
		    array (
		      'title' => '',
		      'count' => '3',
		      'layout' => 'grid',
		      'columns' => '3',
		      'alignment' => 'left',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'show_excerpt' => 'yes',
		      'carousel-nav-color' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Blog',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 0,
		        'id' => 7,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    8 => 
		    array (
		      'type' => 'visual',
		      'title' => '',
		      'text' => '<h3 style="text-align: center;">OUR CUSTOMERS <span style="color: #ba9e78;"><strong>LOVE</strong></span> US</h3>',
		      'filter' => '1',
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Black_Studio_TinyMCE',
		        'raw' => false,
		        'grid' => 6,
		        'cell' => 1,
		        'id' => 8,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    9 => 
		    array (
		      'title' => '',
		      'count' => '3',
		      'layout' => 'carousel',
		      'columns' => '1',
		      'alignment' => 'center',
		      'order' => 'menu_order',
		      'carousel-nav-color' => '#ba9e78',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Testimonials',
		        'raw' => false,
		        'grid' => 6,
		        'cell' => 1,
		        'id' => 9,
		        'style' => 
		        array (
		          'padding' => '30pxpx',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		  ),
		  'grids' => 
		  array (
		    0 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    1 => 
		    array (
		      'cells' => 2,
		      'style' => 
		      array (
		        'gutter' => '0px',
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'yes',
		        'padding_top' => '60px',
		        'padding_bottom' => '60px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    2 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full',
		        'equal_column_height' => 'no',
		        'padding_top' => '140px',
		        'padding_bottom' => '140px',
		        'background_image' => 544,
		        'background_image_position' => 'left top',
		        'background_image_style' => 'parallax',
		      ),
		    ),
		    3 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full',
		        'background' => '#ba9e78',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    4 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full-stretched',
		        'background' => '#f9f8f4',
		        'equal_column_height' => 'no',
		        'padding_top' => '0px',
		        'padding_bottom' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    5 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'equal_column_height' => 'no',
		        'padding_top' => '40px',
		        'padding_bottom' => '40px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    6 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#f4f4f4',
		        'equal_column_height' => 'no',
		        'padding_top' => '100px',
		        'padding_bottom' => '100px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'parallax',
		      ),
		    ),
		  ),
		  'grid_cells' => 
		  array (
		    0 => 
		    array (
		      'grid' => 0,
		      'weight' => 1,
		    ),
		    1 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.5,
		    ),
		    2 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.5,
		    ),
		    3 => 
		    array (
		      'grid' => 2,
		      'weight' => 1,
		    ),
		    4 => 
		    array (
		      'grid' => 3,
		      'weight' => 1,
		    ),
		    5 => 
		    array (
		      'grid' => 4,
		      'weight' => 1,
		    ),
		    6 => 
		    array (
		      'grid' => 5,
		      'weight' => 1,
		    ),
		    7 => 
		    array (
		      'grid' => 6,
		      'weight' => 0.278206541712607224869913125075981952250003814697265625,
		    ),
		    8 => 
		    array (
		      'grid' => 6,
		      'weight' => 0.44358691657478555026017374984803609549999237060546875,
		    ),
		    9 => 
		    array (
		      'grid' => 6,
		      'weight' => 0.278206541712607224869913125075981952250003814697265625,
		    ),
		  ),
		);
		
		$layouts['home-full'] = array(
			'name' => __('Home: Fullscreen Slider', 'create'),
			'description' => __('Layout for demo Home: Fullscreen Slider page.', 'create'),
			'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/home_full.jpg',
	        'widgets' => 
			  array (
			    0 => 
			    array (
			      'title' => '',
			      'text' => '[rev_slider alias="full-screen"]',
			      'panels_info' => 
			      array (
			        'class' => 'WP_Widget_Text',
			        'grid' => 0,
			        'cell' => 0,
			        'id' => 0,
			        'style' => 
			        array (
			          'background_image_attachment' => false,
			          'background_display' => 'tile',
			        ),
			      ),
			      'filter' => false,
			    ),
			    1 => 
			    array (
			      'features' => 
			      array (
			        0 => 
			        array (
			          'container_color' => false,
			          'icon' => 'elegantline-layers',
			          'icon_color' => '#98643c',
			          'icon_image' => 0,
			          'title' => 'Page Builder',
			          'text' => 'Create comes with a page builder that allows you to create pages exactly how you want. ',
			          'more_text' => '',
			          'more_url' => '',
			        ),
			        1 => 
			        array (
			          'container_color' => false,
			          'icon' => 'elegantline-mobile',
			          'icon_color' => '#98643c',
			          'icon_image' => 0,
			          'title' => 'Responsive Layout',
			          'text' => 'Create is a responsive theme. Its layout adjusts to look great on any screen size or device.',
			          'more_text' => '',
			          'more_url' => '',
			        ),
			        2 => 
			        array (
			          'container_color' => false,
			          'icon' => 'elegantline-laptop',
			          'icon_color' => '#98643c',
			          'icon_image' => 0,
			          'title' => 'Retina Ready',
			          'text' => 'Built with the latest technology in mind, rest assured that your site will look crisp on retina displays.',
			          'more_text' => '',
			          'more_url' => '',
			        ),
			      ),
			      'container_shape' => 'round',
			      'container_size' => 25,
			      'icon_size' => 25,
			      'per_row' => 1,
			      'responsive' => true,
			      'title_link' => false,
			      'icon_link' => false,
			      'new_window' => false,
			      'panels_info' => 
			      array (
			        'class' => 'SiteOrigin_Widget_Features_Widget',
			        'raw' => false,
			        'grid' => 1,
			        'cell' => 0,
			        'id' => 1,
			        'style' => 
			        array (
			          'class' => 'right v-center',
			          'background_display' => 'tile',
			        ),
			      ),
			    ),
			    2 => 
			    array (
			      'image_fallback' => '',
			      'image' => 159,
			      'size' => 'full',
			      'title' => '',
			      'alt' => '',
			      'url' => '',
			      'bound' => true,
			      'new_window' => false,
			      'full_width' => false,
			      'panels_info' => 
			      array (
			        'class' => 'SiteOrigin_Widget_Image_Widget',
			        'raw' => false,
			        'grid' => 1,
			        'cell' => 1,
			        'id' => 2,
			        'style' => 
			        array (
			          'class' => 'v-center',
			          'background_display' => 'tile',
			        ),
			      ),
			    ),
			    3 => 
			    array (
			      'features' => 
			      array (
			        0 => 
			        array (
			          'container_color' => false,
			          'icon' => 'elegantline-browser',
			          'icon_color' => '#98643c',
			          'icon_image' => 0,
			          'title' => 'Multiple Headers',
			          'text' => 'Packed with 5 different header layouts, you can use this theme to create many different styles of websites.',
			          'more_text' => '',
			          'more_url' => '',
			        ),
			        1 => 
			        array (
			          'container_color' => false,
			          'icon' => 'elegantline-gears',
			          'icon_color' => '#98643c',
			          'icon_image' => 0,
			          'title' => 'Powerful Options',
			          'text' => 'Create comes with tons of options built right into the WordPress Customizer. So you can give your site a unique look.',
			          'more_text' => '',
			          'more_url' => '',
			        ),
			        2 => 
			        array (
			          'container_color' => false,
			          'icon' => 'elegantline-genius',
			          'icon_color' => '#98643c',
			          'icon_image' => 0,
			          'title' => 'Built-in Mega Menu',
			          'text' => 'There is a mega menu built in for those sites that have a lot of pages. You can easily add icons to menu items.',
			          'more_text' => '',
			          'more_url' => '',
			        ),
			      ),
			      'container_shape' => 'round',
			      'container_size' => 25,
			      'icon_size' => 25,
			      'per_row' => 1,
			      'responsive' => true,
			      'title_link' => false,
			      'icon_link' => false,
			      'new_window' => false,
			      'panels_info' => 
			      array (
			        'class' => 'SiteOrigin_Widget_Features_Widget',
			        'raw' => false,
			        'grid' => 1,
			        'cell' => 2,
			        'id' => 3,
			        'style' => 
			        array (
			          'class' => 'left v-center',
			          'background_display' => 'tile',
			        ),
			      ),
			    ),
			    4 => 
			    array (
			      'type' => 'visual',
			      'title' => '',
			      'text' => '<h3 style="text-align: center;">Our Latest Work</h3><p style="text-align: center;"><span style="color: #999999;">Create unlimited parallax sections for your pages. It\'s as easy as adding a new page build row, uploading and image, and choosing "parallax from the drop down.</span></p>',
			      'filter' => '1',
			      'panels_info' => 
			      array (
			        'class' => 'WP_Widget_Black_Studio_TinyMCE',
			        'raw' => false,
			        'grid' => 2,
			        'cell' => 1,
			        'id' => 4,
			        'style' => 
			        array (
			          'padding' => '0px',
			          'background_display' => 'tile',
			          'font_color' => '#ffffff',
			        ),
			      ),
			    ),
			    5 => 
			    array (
			      'text' => 'VIEW MORE',
			      'url' => '#',
			      'new_window' => false,
			      'button_icon' => 
			      array (
			        'icon_selected' => '',
			        'icon_color' => '',
			        'icon' => '0',
			      ),
			      'design' => 
			      array (
			        'align' => 'center',
			        'theme' => 'flat',
			        'button_color' => '#bb9f7c',
			        'text_color' => '#ffffff',
			        'hover' => true,
			        'font_size' => '1',
			        'rounding' => '0.25',
			        'padding' => '1',
			      ),
			      'attributes' => 
			      array (
			        'id' => '',
			        'title' => '',
			        'onclick' => '',
			      ),
			      'panels_info' => 
			      array (
			        'class' => 'SiteOrigin_Widget_Button_Widget',
			        'raw' => false,
			        'grid' => 2,
			        'cell' => 1,
			        'id' => 5,
			        'style' => 
			        array (
			          'background_display' => 'tile',
			        ),
			      ),
			    ),
			    6 => 
			    array (
			      'title' => '',
			      'show_filter' => 'no',
			      'filter_alignment' => 'center',
			      'count' => '3',
			      'thumb_proportions' => 'square',
			      'layout' => 'rows without gutter',
			      'columns' => '3',
			      'orderby' => 'date',
			      'order' => 'DESC',
			      'hover_effect' => 'effect-1',
			      'hover_color' => '',
			      'hover_text_color' => '',
			      'show_skills' => 'no',
			      'show_load_more' => 'no',
			      'enable_lightbox' => 'no',
			      'skills' => 
			      array (
			      ),
			      'panels_info' => 
			      array (
			        'class' => 'TTrust_Portfolio',
			        'raw' => false,
			        'grid' => 3,
			        'cell' => 0,
			        'id' => 6,
			        'style' => 
			        array (
			          'background_display' => 'tile',
			        ),
			      ),
			    ),
			    7 => 
			    array (
			      'headline' => 
			      array (
			        'text' => 'What People Are Saying',
			        'font' => 'default',
			        'color' => '#000000',
			        'align' => 'center',
			      ),
			      'sub_headline' => 
			      array (
			        'text' => 'Display testimonials as a slider or grid.',
			        'font' => 'default',
			        'color' => '#aaaaaa',
			        'align' => 'center',
			      ),
			      'divider' => 
			      array (
			        'style' => 'solid',
			        'weight' => 'thin',
			        'color' => '#bc9f7a',
			      ),
			      'panels_info' => 
			      array (
			        'class' => 'SiteOrigin_Widget_Headline_Widget',
			        'raw' => false,
			        'grid' => 4,
			        'cell' => 0,
			        'id' => 7,
			        'style' => 
			        array (
			          'padding' => '20px',
			          'background_display' => 'tile',
			        ),
			      ),
			    ),
			    8 => 
			    array (
			      'title' => '',
			      'count' => '3',
			      'layout' => 'grid',
			      'columns' => '3',
			      'alignment' => 'center',
			      'order' => 'rand',
			      'carousel-nav-color' => '',
			      'panels_info' => 
			      array (
			        'class' => 'TTrust_Testimonials',
			        'raw' => false,
			        'grid' => 4,
			        'cell' => 0,
			        'id' => 8,
			        'style' => 
			        array (
			          'background_display' => 'tile',
			        ),
			      ),
			    ),
			    9 => 
			    array (
			      'features' => 
			      array (
			        0 => 
			        array (
			          'container_color' => false,
			          'icon' => 'fontawesome-list-alt',
			          'icon_color' => '#ffffff',
			          'icon_image' => 0,
			          'title' => 'Multiple Site Layouts',
			          'text' => 'Choose from full-width, boxed, side header, top header, and more.',
			          'more_text' => '',
			          'more_url' => '',
			        ),
			        1 => 
			        array (
			          'container_color' => false,
			          'icon' => 'fontawesome-desktop',
			          'icon_color' => '#ffffff',
			          'icon_image' => 0,
			          'title' => 'One-page Option',
			          'text' => 'Create a navigation that scrolls to different sections on a single page.',
			          'more_text' => '',
			          'more_url' => '',
			        ),
			      ),
			      'container_shape' => 'round',
			      'container_size' => 25,
			      'icon_size' => 25,
			      'per_row' => 1,
			      'responsive' => true,
			      'title_link' => false,
			      'icon_link' => false,
			      'new_window' => false,
			      'panels_info' => 
			      array (
			        'class' => 'SiteOrigin_Widget_Features_Widget',
			        'raw' => false,
			        'grid' => 5,
			        'cell' => 0,
			        'id' => 9,
			        'style' => 
			        array (
			          'class' => 'left',
			          'padding' => '20%',
			          'background' => '#ba9e78',
			          'background_display' => 'tile',
			          'font_color' => '#ffffff',
			        ),
			      ),
			    ),
			    10 => 
			    array (
			      'features' => 
			      array (
			        0 => 
			        array (
			          'container_color' => false,
			          'icon' => 'fontawesome-th',
			          'icon_color' => '#ffffff',
			          'icon_image' => 0,
			          'title' => 'Portfolio Options',
			          'text' => 'Packed with tons of portfolio options: masonry or grid layout, load more button, and more.',
			          'more_text' => '',
			          'more_url' => '',
			        ),
			        1 => 
			        array (
			          'container_color' => false,
			          'icon' => 'fontawesome-star-o',
			          'icon_color' => '#ffffff',
			          'icon_image' => 0,
			          'title' => 'Top-notch Support',
			          'text' => 'Read the documentation, but still have questions? We\'re here to help.',
			          'more_text' => '',
			          'more_url' => '',
			        ),
			      ),
			      'container_shape' => 'round',
			      'container_size' => 25,
			      'icon_size' => 25,
			      'per_row' => 1,
			      'responsive' => true,
			      'title_link' => false,
			      'icon_link' => false,
			      'new_window' => false,
			      'panels_info' => 
			      array (
			        'class' => 'SiteOrigin_Widget_Features_Widget',
			        'raw' => false,
			        'grid' => 5,
			        'cell' => 1,
			        'id' => 10,
			        'style' => 
			        array (
			          'class' => 'left',
			          'padding' => '20%',
			          'background' => '#232323',
			          'background_image_attachment' => 200,
			          'background_display' => 'tile',
			          'font_color' => '#ffffff',
			        ),
			      ),
			    ),
			    11 => 
			    array (
			      'features' => 
			      array (
			        0 => 
			        array (
			          'container_color' => false,
			          'icon' => 'fontawesome-hand-o-up',
			          'icon_color' => '#ffffff',
			          'icon_image' => 0,
			          'title' => 'One-click Demo Install',
			          'text' => 'We make it easy for you to get started with all of the layouts you see here in the demo.',
			          'more_text' => '',
			          'more_url' => '',
			        ),
			        1 => 
			        array (
			          'container_color' => false,
			          'icon' => 'fontawesome-file-text',
			          'icon_color' => '#ffffff',
			          'icon_image' => 0,
			          'title' => 'Detailed Documentation',
			          'text' => 'Create has a lot features. We\'ve taken the time to explain how to use them.',
			          'more_text' => '',
			          'more_url' => '',
			        ),
			      ),
			      'container_shape' => 'round',
			      'container_size' => 25,
			      'icon_size' => 25,
			      'per_row' => 1,
			      'responsive' => true,
			      'title_link' => false,
			      'icon_link' => false,
			      'new_window' => false,
			      'panels_info' => 
			      array (
			        'class' => 'SiteOrigin_Widget_Features_Widget',
			        'raw' => false,
			        'grid' => 5,
			        'cell' => 2,
			        'id' => 11,
			        'style' => 
			        array (
			          'class' => 'left',
			          'padding' => '20%',
			          'background' => '#232323',
			          'background_display' => 'tile',
			          'font_color' => '#ffffff',
			        ),
			      ),
			    ),
			    12 => 
			    array (
			      'headline' => 
			      array (
			        'text' => 'Recent News',
			        'font' => 'default',
			        'color' => '#000000',
			        'align' => 'center',
			      ),
			      'sub_headline' => 
			      array (
			        'text' => 'Display recent posts as a carousel or grid.',
			        'font' => 'default',
			        'color' => '#aaaaaa',
			        'align' => 'center',
			      ),
			      'divider' => 
			      array (
			        'style' => 'solid',
			        'weight' => 'thin',
			        'color' => '#bc9f7a',
			      ),
			      'panels_info' => 
			      array (
			        'class' => 'SiteOrigin_Widget_Headline_Widget',
			        'raw' => false,
			        'grid' => 6,
			        'cell' => 0,
			        'id' => 12,
			        'style' => 
			        array (
			          'padding' => '20px',
			          'background_display' => 'tile',
			        ),
			      ),
			    ),
			    13 => 
			    array (
			      'title' => '',
			      'count' => '7',
			      'layout' => 'carousel',
			      'columns' => '3',
			      'alignment' => 'left',
			      'orderby' => 'date',
			      'order' => 'DESC',
			      'show_excerpt' => 'yes',
			      'carousel-nav-color' => '',
			      'panels_info' => 
			      array (
			        'class' => 'TTrust_Blog',
			        'raw' => false,
			        'grid' => 6,
			        'cell' => 0,
			        'id' => 13,
			        'style' => 
			        array (
			          'background_display' => 'tile',
			        ),
			      ),
			    ),
			  ),
			  'grids' => 
			  array (
			    0 => 
			    array (
			      'cells' => 1,
			      'style' => 
			      array (
			        'row_stretch' => 'full-stretched',
			        'equal_column_height' => 'no',
			        'background_image_position' => 'left top',
			        'background_image_style' => 'cover',
			      ),
			    ),
			    1 => 
			    array (
			      'cells' => 3,
			      'style' => 
			      array (
			        'bottom_margin' => '0px',
			        'gutter' => '0px',
			        'equal_column_height' => 'yes',
			        'padding_top' => '60px',
			        'padding_bottom' => '50px',
			        'background_image_position' => 'left top',
			        'background_image_style' => 'cover',
			      ),
			    ),
			    2 => 
			    array (
			      'cells' => 3,
			      'style' => 
			      array (
			        'bottom_margin' => '0px',
			        'row_stretch' => 'full',
			        'equal_column_height' => 'no',
			        'padding_top' => '100px',
			        'padding_bottom' => '100px',
			        'background_image' => 118,
			        'background_image_position' => 'left top',
			        'background_image_style' => 'parallax',
			      ),
			    ),
			    3 => 
			    array (
			      'cells' => 1,
			      'style' => 
			      array (
			        'bottom_margin' => '0px',
			        'gutter' => '0px',
			        'row_stretch' => 'full-stretched',
			        'equal_column_height' => 'no',
			        'background_image_position' => 'left top',
			        'background_image_style' => 'cover',
			      ),
			    ),
			    4 => 
			    array (
			      'cells' => 1,
			      'style' => 
			      array (
			        'bottom_margin' => '0px',
			        'gutter' => '0px',
			        'equal_column_height' => 'no',
			        'padding_top' => '50px',
			        'padding_bottom' => '50px',
			        'background_image_position' => 'left top',
			        'background_image_style' => 'cover',
			      ),
			    ),
			    5 => 
			    array (
			      'cells' => 3,
			      'style' => 
			      array (
			        'bottom_margin' => '0px',
			        'gutter' => '0px',
			        'row_stretch' => 'full-stretched',
			        'background' => '#eaeaea',
			        'equal_column_height' => 'yes',
			        'padding_top' => '0px',
			        'padding_bottom' => '0px',
			        'padding_left' => '0px',
			        'padding_right' => '0px',
			        'background_image_position' => 'left top',
			        'background_image_style' => 'cover',
			      ),
			    ),
			    6 => 
			    array (
			      'cells' => 1,
			      'style' => 
			      array (
			        'equal_column_height' => 'no',
			        'padding_top' => '50px',
			        'padding_bottom' => '50px',
			        'background_image_position' => 'left top',
			        'background_image_style' => 'cover',
			      ),
			    ),
			  ),
			  'grid_cells' => 
			  array (
			    0 => 
			    array (
			      'grid' => 0,
			      'weight' => 1,
			    ),
			    1 => 
			    array (
			      'grid' => 1,
			      'weight' => 0.333333333333333314829616256247390992939472198486328125,
			    ),
			    2 => 
			    array (
			      'grid' => 1,
			      'weight' => 0.333333333333333314829616256247390992939472198486328125,
			    ),
			    3 => 
			    array (
			      'grid' => 1,
			      'weight' => 0.333333333333333314829616256247390992939472198486328125,
			    ),
			    4 => 
			    array (
			      'grid' => 2,
			      'weight' => 0.204186413902050001301091697314404882490634918212890625,
			    ),
			    5 => 
			    array (
			      'grid' => 2,
			      'weight' => 0.59162717219589999739781660537119023501873016357421875,
			    ),
			    6 => 
			    array (
			      'grid' => 2,
			      'weight' => 0.204186413902050001301091697314404882490634918212890625,
			    ),
			    7 => 
			    array (
			      'grid' => 3,
			      'weight' => 1,
			    ),
			    8 => 
			    array (
			      'grid' => 4,
			      'weight' => 1,
			    ),
			    9 => 
			    array (
			      'grid' => 5,
			      'weight' => 0.333333333333333314829616256247390992939472198486328125,
			    ),
			    10 => 
			    array (
			      'grid' => 5,
			      'weight' => 0.333333333333333314829616256247390992939472198486328125,
			    ),
			    11 => 
			    array (
			      'grid' => 5,
			      'weight' => 0.333333333333333314829616256247390992939472198486328125,
			    ),
			    12 => 
			    array (
			      'grid' => 6,
			      'weight' => 1,
			    ),
			  ),
			);
			
			$layouts['home-one-page'] = array(
				'name' => __('Home: One Page', 'create'),
				'description' => __('Layout for demo Home: One Page page.', 'create'),
				'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/home_one.jpg',
		        'widgets' => 
				  array (
				    0 => 
				    array (
				      'title' => '',
				      'text' => '[rev_slider alias="one-page-slider"]',
				      'filter' => false,
				      'panels_info' => 
				      array (
				        'class' => 'WP_Widget_Text',
				        'raw' => false,
				        'grid' => 0,
				        'cell' => 0,
				        'id' => 0,
				        'style' => 
				        array (
				          'background_display' => 'tile',
				        ),
				      ),
				    ),
				    1 => 
				    array (
				      'type' => 'visual',
				      'title' => '',
				      'text' => '<h2 style="text-align: center;">MY <span style="color: #bb9f7c;">WORK</span></h2>',
				      'filter' => '1',
				      'panels_info' => 
				      array (
				        'class' => 'WP_Widget_Black_Studio_TinyMCE',
				        'raw' => false,
				        'grid' => 1,
				        'cell' => 0,
				        'id' => 1,
				        'style' => 
				        array (
				          'background_display' => 'tile',
				          'font_color' => '#ffffff',
				        ),
				      ),
				    ),
				    2 => 
				    array (
				      'title' => '',
				      'show_filter' => 'yes',
				      'filter_alignment' => 'center',
				      'count' => '8',
				      'thumb_proportions' => 'square',
				      'layout' => 'rows with gutter',
				      'columns' => '4',
				      'skills' => 
				      array (
				        'illustration' => 'illustration',
				        'mobile' => 'mobile',
				        'motion' => '',
				        'photography' => 'photography',
				        'web' => 'web',
				      ),
				      'orderby' => 'date',
				      'order' => 'DESC',
				      'hover_effect' => 'effect-1',
				      'hover_color' => '#bb9f7c',
				      'hover_text_color' => '',
				      'show_skills' => 'no',
				      'show_load_more' => 'no',
				      'enable_lightbox' => 'yes',
				      'panels_info' => 
				      array (
				        'class' => 'TTrust_Portfolio',
				        'raw' => false,
				        'grid' => 1,
				        'cell' => 0,
				        'id' => 2,
				        'style' => 
				        array (
				          'background_display' => 'tile',
				          'font_color' => '#ffffff',
				        ),
				      ),
				    ),
				    3 => 
				    array (
				      'type' => 'visual',
				      'title' => '',
				      'text' => '<h2><span style="color: #1f1f1f;">ABOUT <span style="color: #bb9f7c;">ME</span></span></h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc malesuada lectus libero, ac sagittis nisi dapibus ac. Nunc dictum imperdiet lorem. Quisque vehicula nec arcu nec rutrum. Duis sit amet mattis magna. In felis dui, elementum in tortor dictum, eleifend commodo purus. Nulla eget turpis purus. In ultrices est a pellentesque rutrum. Suspendisse egestas pharetra eros a commodo. Aenean ac ante id odio cursus tempor. Vivamus sit amet ante massa.</p>',
				      'filter' => '1',
				      'panels_info' => 
				      array (
				        'class' => 'WP_Widget_Black_Studio_TinyMCE',
				        'raw' => false,
				        'grid' => 2,
				        'cell' => 0,
				        'id' => 3,
				        'style' => 
				        array (
				          'padding' => '0px',
				          'background_display' => 'center',
				        ),
				      ),
				    ),
				    4 => 
				    array (
				      'networks' => 
				      array (
				        0 => 
				        array (
				          'name' => 'twitter',
				          'url' => 'https://twitter.com/',
				          'icon_color' => '#ffffff',
				          'button_color' => '#78bdf1',
				        ),
				        1 => 
				        array (
				          'name' => 'dribbble',
				          'url' => 'https://dribbble.com/',
				          'icon_color' => '#ffffff',
				          'button_color' => '#f26798',
				        ),
				        2 => 
				        array (
				          'name' => 'envelope',
				          'url' => 'mailto:fakeemail@themetrust.com',
				          'icon_color' => '#ffffff',
				          'button_color' => '#99c4e6',
				        ),
				      ),
				      'design' => 
				      array (
				        'new_window' => true,
				        'theme' => 'wire',
				        'hover' => true,
				        'icon_size' => '1',
				        'rounding' => '0.5',
				        'padding' => '1',
				        'align' => 'left',
				        'margin' => '0.1',
				      ),
				      'panels_info' => 
				      array (
				        'class' => 'SiteOrigin_Widget_SocialMediaButtons_Widget',
				        'raw' => false,
				        'grid' => 2,
				        'cell' => 0,
				        'id' => 4,
				        'style' => 
				        array (
				          'background_display' => 'tile',
				        ),
				      ),
				    ),
				    5 => 
				    array (
				      'type' => 'visual',
				      'title' => '',
				      'text' => '<h2 style="text-align: center;"><span style="color: #1f1f1f;">MY <span style="color: #bb9f7c;">CLIENTS</span></span></h2><p> </p>',
				      'filter' => '1',
				      'panels_info' => 
				      array (
				        'class' => 'WP_Widget_Black_Studio_TinyMCE',
				        'raw' => false,
				        'grid' => 3,
				        'cell' => 0,
				        'id' => 5,
				        'style' => 
				        array (
				          'background_display' => 'tile',
				        ),
				      ),
				    ),
				    6 => 
				    array (
				      'title' => '',
				      'count' => '3',
				      'layout' => 'grid',
				      'columns' => '3',
				      'alignment' => 'center',
				      'order' => 'rand',
				      'carousel-nav-color' => '',
				      'panels_info' => 
				      array (
				        'class' => 'TTrust_Testimonials',
				        'grid' => 3,
				        'cell' => 0,
				        'id' => 6,
				        'style' => 
				        array (
				          'background_image_attachment' => false,
				          'background_display' => 'tile',
				        ),
				      ),
				    ),
				    7 => 
				    array (
				      'type' => 'visual',
				      'title' => '',
				      'text' => '<p><img class="aligncenter size-full wp-image-998" src="http://create.themetrust.com/wp-content/uploads/2015/08/company_logos.png" alt="company_logos" width="3000" height="300" /></p>',
				      'filter' => '',
				      'panels_info' => 
				      array (
				        'class' => 'WP_Widget_Black_Studio_TinyMCE',
				        'raw' => false,
				        'grid' => 4,
				        'cell' => 0,
				        'id' => 7,
				        'style' => 
				        array (
				          'background_display' => 'tile',
				        ),
				      ),
				    ),
				    8 => 
				    array (
				      'map_center' => '350 5th Ave, New York, NY 10118',
				      'settings' => 
				      array (
				        'map_type' => 'interactive',
				        'width' => '640',
				        'height' => '680',
				        'zoom' => 12,
				        'scroll_zoom' => true,
				        'draggable' => true,
				      ),
				      'markers' => 
				      array (
				        'marker_at_center' => true,
				        'marker_icon' => 1063,
				      ),
				      'styles' => 
				      array (
				        'style_method' => 'raw_json',
				        'styled_map_name' => '',
				        'raw_json_map_styles' => '[{"featureType":"landscape","elementType":"geometry","stylers":[{"hue":"#ededed"},{"saturation":-100},{"lightness":36},{"visibility":"on"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#000000"},{"saturation":-100},{"lightness":-100},{"visibility":"off"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#000000"},{"saturation":-100},{"lightness":-100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#000000"},{"saturation":-100},{"lightness":-100},{"visibility":"simplified"}]},{"featureType":"administrative","elementType":"labels","stylers":[{"hue":"#000000"},{"saturation":0},{"lightness":-100},{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"hue":"#000000"},{"saturation":0},{"lightness":-100},{"visibility":"on"}]},{"featureType":"transit","elementType":"labels","stylers":[{"hue":"#000000"},{"saturation":0},{"lightness":-100},{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"hue":"#000000"},{"saturation":-100},{"lightness":-100},{"visibility":"off"}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"on"}]},{"featureType":"landscape.natural","elementType":"all","stylers":[{"hue":"#e0e0e0"},{"saturation":-100},{"lightness":-8},{"visibility":"off"}]}]',
				      ),
				      'directions' => 
				      array (
				        'origin' => '',
				        'destination' => '',
				        'travel_mode' => 'driving',
				      ),
				      'api_key_section' => 
				      array (
				        'api_key' => '',
				      ),
				      'panels_info' => 
				      array (
				        'class' => 'SiteOrigin_Widget_GoogleMap_Widget',
				        'raw' => false,
				        'grid' => 5,
				        'cell' => 0,
				        'id' => 8,
				        'style' => 
				        array (
				          'background_display' => 'tile',
				        ),
				      ),
				    ),
				    9 => 
				    array (
				      'type' => 'visual',
				      'title' => '',
				      'text' => '<h2><span style="color: #ffffff;">CONTACT</span><span style="color: #1f1f1f;"> <span style="color: #bb9f7c;">ME</span></span></h2><p>Interdum et malesuada fames ac ante ipsum primis in faucibus. Vestibulum viverra, eros nec luctus facilisis, nisi nisl tempus purus, vitae congue enim mi pulvinar orci. Quisque diam ex, faucibus sed tortor a, dignissim consequat risus.</p><p>1234 Main St.<br /> New York, NY 10021</p><p>T: 555-456-7892 <em>New York Office<br /> E: contact@create-digital.com</em></p>',
				      'filter' => '1',
				      'panels_info' => 
				      array (
				        'class' => 'WP_Widget_Black_Studio_TinyMCE',
				        'raw' => false,
				        'grid' => 5,
				        'cell' => 1,
				        'id' => 9,
				        'style' => 
				        array (
				          'padding' => '60px',
				          'background' => '#282828',
				          'background_display' => 'tile',
				          'font_color' => '#bababa',
				        ),
				      ),
				    ),
				  ),
				  'grids' => 
				  array (
				    0 => 
				    array (
				      'cells' => 1,
				      'style' => 
				      array (
				        'bottom_margin' => '0px',
				        'row_stretch' => 'full-stretched',
				        'custom_row_id' => 'hello',
				        'equal_column_height' => 'no',
				        'background_image_position' => 'left top',
				        'background_image_style' => 'cover',
				      ),
				    ),
				    1 => 
				    array (
				      'cells' => 1,
				      'style' => 
				      array (
				        'bottom_margin' => '0px',
				        'row_stretch' => 'full',
				        'background' => '#282828',
				        'custom_row_id' => 'my-work',
				        'equal_column_height' => 'no',
				        'padding_top' => '70px',
				        'padding_bottom' => '70px',
				        'background_image_position' => 'left top',
				        'background_image_style' => 'cover',
				      ),
				    ),
				    2 => 
				    array (
				      'cells' => 2,
				      'style' => 
				      array (
				        'row_stretch' => 'full',
				        'custom_row_id' => 'about-me',
				        'equal_column_height' => 'no',
				        'padding_top' => '150px',
				        'padding_bottom' => '150px',
				        'background_image' => 996,
				        'background_image_position' => 'left top',
				        'background_image_style' => 'parallax',
				      ),
				    ),
				    3 => 
				    array (
				      'cells' => 1,
				      'style' => 
				      array (
				        'row_stretch' => 'full',
				        'custom_row_id' => 'testimonials',
				        'equal_column_height' => 'no',
				        'padding_top' => '60px',
				        'padding_bottom' => '50px',
				        'background_image_position' => 'left top',
				        'background_image_style' => 'cover',
				      ),
				    ),
				    4 => 
				    array (
				      'cells' => 1,
				      'style' => 
				      array (
				        'bottom_margin' => '0px',
				        'row_stretch' => 'full',
				        'background' => '#bb9f7c',
				        'equal_column_height' => 'no',
				        'padding_top' => '40px',
				        'padding_bottom' => '10px',
				        'background_image_position' => 'left top',
				        'background_image_style' => 'cover',
				      ),
				    ),
				    5 => 
				    array (
				      'cells' => 2,
				      'style' => 
				      array (
				        'gutter' => '0px',
				        'row_stretch' => 'full-stretched',
				        'custom_row_id' => 'contact-me',
				        'equal_column_height' => 'yes',
				        'padding_top' => '0px',
				        'padding_bottom' => '0px',
				        'background_image_position' => 'center bottom',
				        'background_image_style' => 'cover',
				      ),
				    ),
				  ),
				  'grid_cells' => 
				  array (
				    0 => 
				    array (
				      'grid' => 0,
				      'weight' => 1,
				    ),
				    1 => 
				    array (
				      'grid' => 1,
				      'weight' => 1,
				    ),
				    2 => 
				    array (
				      'grid' => 2,
				      'weight' => 0.49622299651568002598622797449934296309947967529296875,
				    ),
				    3 => 
				    array (
				      'grid' => 2,
				      'weight' => 0.50377700348431997401377202550065703690052032470703125,
				    ),
				    4 => 
				    array (
				      'grid' => 3,
				      'weight' => 1,
				    ),
				    5 => 
				    array (
				      'grid' => 4,
				      'weight' => 1,
				    ),
				    6 => 
				    array (
				      'grid' => 5,
				      'weight' => 0.5,
				    ),
				    7 => 
				    array (
				      'grid' => 5,
				      'weight' => 0.5,
				    ),
				  ),
				);
				
				
				$layouts['home-portfolio'] = array(
					'name' => __('Home: Portfolio', 'create'),
					'description' => __('Layout for demo Home: Portfolio page.', 'create'),
					'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/home_portfolio.jpg',
			        'widgets' => 
					  array (
					    0 => 
					    array (
					      'title' => '',
					      'text' => '[rev_slider alias="home-portfolio"]',
					      'panels_info' => 
					      array (
					        'class' => 'WP_Widget_Text',
					        'grid' => 0,
					        'cell' => 0,
					        'id' => 0,
					        'style' => 
					        array (
					          'background_image_attachment' => false,
					          'background_display' => 'tile',
					        ),
					      ),
					      'filter' => false,
					    ),
					    1 => 
					    array (
					      'title' => '',
					      'show_filter' => 'yes',
					      'filter_alignment' => 'center',
					      'count' => '9',
					      'thumb_proportions' => 'square',
					      'layout' => 'rows with gutter',
					      'columns' => '3',
					      'skills' => 
					      array (
					        'illustration' => '',
					        'mobile' => '',
					        'motion' => '',
					        'photography' => '',
					        'web' => '',
					      ),
					      'orderby' => 'menu_order',
					      'order' => 'DESC',
					      'hover_effect' => 'effect-1',
					      'hover_color' => '',
					      'hover_text_color' => '',
					      'show_skills' => 'yes',
					      'show_load_more' => 'yes',
					      'enable_lightbox' => 'no',
					      'panels_info' => 
					      array (
					        'class' => 'TTrust_Portfolio',
					        'raw' => false,
					        'grid' => 1,
					        'cell' => 0,
					        'id' => 1,
					        'style' => 
					        array (
					          'background_display' => 'tile',
					        ),
					      ),
					    ),
					  ),
					  'grids' => 
					  array (
					    0 => 
					    array (
					      'cells' => 1,
					      'style' => 
					      array (
					        'bottom_margin' => '0px',
					        'row_stretch' => 'full-stretched',
					        'equal_column_height' => 'no',
					        'background_image_position' => 'left top',
					        'background_image_style' => 'cover',
					      ),
					    ),
					    1 => 
					    array (
					      'cells' => 1,
					      'style' => 
					      array (
					        'row_stretch' => 'full',
					        'equal_column_height' => 'no',
					        'padding_top' => '30px',
					        'padding_bottom' => '40px',
					        'background_image_position' => 'left top',
					        'background_image_style' => 'cover',
					      ),
					    ),
					  ),
					  'grid_cells' => 
					  array (
					    0 => 
					    array (
					      'grid' => 0,
					      'weight' => 1,
					    ),
					    1 => 
					    array (
					      'grid' => 1,
					      'weight' => 1,
					    ),
					  ),
					);
					
					$layouts['home-shop'] = array(
						'name' => __('Home: Shop', 'create'),
						'description' => __('Layout for demo Home: Shop page.', 'create'),
						'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/home_shop.jpg',
				        'widgets' => 
						  array (
						    0 => 
						    array (
						      'title' => '',
						      'text' => '[rev_slider alias="shop-slider"]',
						      'panels_info' => 
						      array (
						        'class' => 'WP_Widget_Text',
						        'grid' => 0,
						        'cell' => 0,
						        'id' => 0,
						        'style' => 
						        array (
						          'background_image_attachment' => false,
						          'background_display' => 'tile',
						        ),
						      ),
						      'filter' => false,
						    ),
						    1 => 
						    array (
						      'type' => 'html',
						      'title' => '',
						      'text' => '<span style="font-size: 36px;"><strong>Watches</strong></span>

						<span style="color: #cccccc;">Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet.</span>

						<a href=\'http://create.themetrust.com/product-category/watches/\' class=\'tt-button\' style="background: #bb9f7c;">SHOP WATCHES</a>',
						      'filter' => '1',
						      'panels_info' => 
						      array (
						        'class' => 'WP_Widget_Black_Studio_TinyMCE',
						        'raw' => false,
						        'grid' => 1,
						        'cell' => 0,
						        'id' => 1,
						        'style' => 
						        array (
						          'padding' => '50px',
						          'background' => '#a0a0a0',
						          'background_image_attachment' => 844,
						          'background_display' => 'tile',
						          'font_color' => '#ffffff',
						        ),
						      ),
						    ),
						    2 => 
						    array (
						      'type' => 'html',
						      'title' => '',
						      'text' => '<span style="font-size: 36px;"><strong>Bags</strong></span>

						<span style="color: #cccccc;">Lorem ipsum dolor sit amet. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. </span>

						<a href=\'http://create.themetrust.com/product-category/bags/\' class=\'tt-button\' style="background: #bb9f7c;">SHOP BAGS</a>',
						      'filter' => '1',
						      'panels_info' => 
						      array (
						        'class' => 'WP_Widget_Black_Studio_TinyMCE',
						        'raw' => false,
						        'grid' => 1,
						        'cell' => 1,
						        'id' => 2,
						        'style' => 
						        array (
						          'padding' => '50px',
						          'background' => '#444444',
						          'background_image_attachment' => 842,
						          'background_display' => 'cover',
						          'font_color' => '#ffffff',
						        ),
						      ),
						    ),
						    3 => 
						    array (
						      'type' => 'visual',
						      'title' => '',
						      'text' => '<p><span style="font-size: 36px;"><strong>Shoes</strong></span></p><p><span style="color: #999999;">Imperdiet doming id quod mazim placerat facer am liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. </span></p><p><a class="tt-button" style="background: #bb9f7c;" href="http://create.themetrust.com/product-category/shoes/">SHOP SHOES</a></p>',
						      'filter' => '1',
						      'panels_info' => 
						      array (
						        'class' => 'WP_Widget_Black_Studio_TinyMCE',
						        'raw' => false,
						        'grid' => 1,
						        'cell' => 2,
						        'id' => 3,
						        'style' => 
						        array (
						          'padding' => '50px',
						          'background' => '#515151',
						          'background_image_attachment' => 840,
						          'background_display' => 'cover',
						          'font_color' => '#ffffff',
						        ),
						      ),
						    ),
						    4 => 
						    array (
						      'headline' => 
						      array (
						        'text' => 'Featured Items from Our Shop',
						        'font' => 'default',
						        'color' => '#000000',
						        'align' => 'center',
						      ),
						      'sub_headline' => 
						      array (
						        'text' => 'Lorem ipsum dolor sit amet, consec tetuer adipis elit, aliquam eget nibh etlibura. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.',
						        'font' => 'default',
						        'color' => '#7c7c7c',
						        'align' => 'center',
						      ),
						      'divider' => 
						      array (
						        'style' => 'solid',
						        'weight' => 'thin',
						        'color' => '#bb9f7c',
						      ),
						      'panels_info' => 
						      array (
						        'class' => 'SiteOrigin_Widget_Headline_Widget',
						        'raw' => false,
						        'grid' => 2,
						        'cell' => 1,
						        'id' => 4,
						        'style' => 
						        array (
						          'background_display' => 'tile',
						        ),
						      ),
						    ),
						    5 => 
						    array (
						      'title' => '',
						      'count' => '4',
						      'layout' => 'grid',
						      'columns' => '4',
						      'orderby' => 'date',
						      'order' => 'DESC',
						      'categories' => 
						      array (
						        'bags' => '',
						        'jewelry' => '',
						        'notebooks' => '',
						        'shoes' => '',
						        'watches' => '',
						      ),
						      'show_featured' => 'no',
						      'alignment' => 'left',
						      'carousel-nav-color' => '',
						      'panels_info' => 
						      array (
						        'class' => 'TTrust_Products',
						        'raw' => false,
						        'grid' => 3,
						        'cell' => 0,
						        'id' => 5,
						        'style' => 
						        array (
						          'background_display' => 'tile',
						        ),
						      ),
						    ),
						    6 => 
						    array (
						      'title' => 'Newsletter',
						      'sub_title' => 'Lorem ipsum dolor sit amet, consec tetuer adipis elit, aliquam eget nibh etlibura.',
						      'design' => 
						      array (
						        'background_color' => '#bb9f7c',
						        'border_color' => '',
						        'button_align' => 'right',
						      ),
						      'button' => 
						      array (
						        'text' => 'SIGN UP',
						        'url' => '#',
						        'new_window' => '',
						        'button_icon' => 
						        array (
						          'icon_selected' => 'fontawesome-envelope-o',
						          'icon_color' => '#bb9f7c',
						          'icon' => '',
						        ),
						        'design' => 
						        array (
						          'theme' => 'flat',
						          'button_color' => '#ffffff',
						          'text_color' => '#bb9f7c',
						          'hover' => true,
						          'font_size' => '1',
						          'rounding' => '0.25',
						          'padding' => '1',
						        ),
						        'attributes' => 
						        array (
						          'id' => '',
						          'title' => '',
						          'onclick' => '',
						        ),
						      ),
						      'panels_info' => 
						      array (
						        'class' => 'SiteOrigin_Widget_Cta_Widget',
						        'raw' => false,
						        'grid' => 4,
						        'cell' => 0,
						        'id' => 6,
						        'style' => 
						        array (
						          'background_display' => 'tile',
						          'font_color' => '#ffffff',
						        ),
						      ),
						    ),
						  ),
						  'grids' => 
						  array (
						    0 => 
						    array (
						      'cells' => 1,
						      'style' => 
						      array (
						        'row_stretch' => 'full-stretched',
						        'equal_column_height' => 'no',
						        'background_image_position' => 'left top',
						        'background_image_style' => 'cover',
						      ),
						    ),
						    1 => 
						    array (
						      'cells' => 3,
						      'style' => 
						      array (
						        'bottom_margin' => '50px',
						        'gutter' => '30px',
						        'equal_column_height' => 'yes',
						        'padding_top' => '30px',
						        'padding_bottom' => '50px',
						        'background_image_position' => 'left top',
						        'background_image_style' => 'cover',
						      ),
						    ),
						    2 => 
						    array (
						      'cells' => 3,
						      'style' => 
						      array (
						        'bottom_margin' => '60px',
						        'equal_column_height' => 'no',
						        'background_image_position' => 'left top',
						        'background_image_style' => 'cover',
						      ),
						    ),
						    3 => 
						    array (
						      'cells' => 1,
						      'style' => 
						      array (
						        'bottom_margin' => '50px',
						        'equal_column_height' => 'no',
						        'background_image_position' => 'left top',
						        'background_image_style' => 'cover',
						      ),
						    ),
						    4 => 
						    array (
						      'cells' => 1,
						      'style' => 
						      array (
						        'bottom_margin' => '80px',
						        'equal_column_height' => 'no',
						        'padding_bottom' => '80px',
						        'background_image_position' => 'left top',
						        'background_image_style' => 'cover',
						      ),
						    ),
						  ),
						  'grid_cells' => 
						  array (
						    0 => 
						    array (
						      'grid' => 0,
						      'weight' => 1,
						    ),
						    1 => 
						    array (
						      'grid' => 1,
						      'weight' => 0.333333333333333314829616256247390992939472198486328125,
						    ),
						    2 => 
						    array (
						      'grid' => 1,
						      'weight' => 0.333333333333333314829616256247390992939472198486328125,
						    ),
						    3 => 
						    array (
						      'grid' => 1,
						      'weight' => 0.333333333333333314829616256247390992939472198486328125,
						    ),
						    4 => 
						    array (
						      'grid' => 2,
						      'weight' => 0.25020678246485006379629112416296266019344329833984375,
						    ),
						    5 => 
						    array (
						      'grid' => 2,
						      'weight' => 0.50020678246484007178906949775409884750843048095703125,
						    ),
						    6 => 
						    array (
						      'grid' => 2,
						      'weight' => 0.249586435070310030948093071856419555842876434326171875,
						    ),
						    7 => 
						    array (
						      'grid' => 3,
						      'weight' => 1,
						    ),
						    8 => 
						    array (
						      'grid' => 4,
						      'weight' => 1,
						    ),
						  ),
						);
				
						$layouts['about-us'] = array(
							'name' => __('About Us', 'create'),
							'description' => __('Layout for demo About Us page.', 'create'),
							'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/about_us.jpg',
					        'widgets' => 
							  array (
							    0 => 
							    array (
							      'type' => 'visual',
							      'title' => '',
							      'text' => '<h2 style="text-align: right;">WE <span style="color: #ba9e78;">CREATE</span> AMAZING THINGS</h2><p style="text-align: right;"><span style="font-size: 21px; color: #737373;">The Create WordPress theme will change the way you build websites.</span></p>',
							      'filter' => '1',
							      'panels_info' => 
							      array (
							        'class' => 'WP_Widget_Black_Studio_TinyMCE',
							        'raw' => false,
							        'grid' => 0,
							        'cell' => 0,
							        'id' => 0,
							        'style' => 
							        array (
							          'background_display' => 'tile',
							          'font_color' => '#ffffff',
							        ),
							      ),
							    ),
							    1 => 
							    array (
							      'type' => 'visual',
							      'title' => '',
							      'text' => '<h3 style="text-align: center;"><span style="color: #242424;">ABOUT</span></h3>',
							      'filter' => '1',
							      'panels_info' => 
							      array (
							        'class' => 'WP_Widget_Black_Studio_TinyMCE',
							        'raw' => false,
							        'grid' => 1,
							        'cell' => 1,
							        'id' => 1,
							        'style' => 
							        array (
							          'background_display' => 'tile',
							        ),
							      ),
							    ),
							    2 => 
							    array (
							      'type' => 'visual',
							      'title' => '',
							      'text' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis molestie leo, sed efficitur dui. Nulla cursus turpis quis mattis rutrum. Suspendisse lobortis pulvinar mauris eget placerat. Suspendisse in dolor vitae risus maximus feugiat quis nec nisi. Phasellus ut auctor ante, scelerisque scelerisque eros. Fusce vitae orci eu nisl pellentesque faucibus lacinia sed erat. Nunc consequat erat sit amet felis gravida venenatis. Duis in neque in mi consequat aliquet in id eros. Aliquam vel lorem ut tellus eleifend luctus.</p>',
							      'filter' => '1',
							      'panels_info' => 
							      array (
							        'class' => 'WP_Widget_Black_Studio_TinyMCE',
							        'raw' => false,
							        'grid' => 1,
							        'cell' => 1,
							        'id' => 2,
							        'style' => 
							        array (
							          'background_display' => 'tile',
							        ),
							      ),
							    ),
							    3 => 
							    array (
							      'features' => 
							      array (
							        0 => 
							        array (
							          'container_color' => '#ffffff',
							          'icon' => 'fontawesome-desktop',
							          'icon_color' => '#a58c6a',
							          'icon_image' => 0,
							          'title' => 'Web Design',
							          'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis molestie leo, sed efficitur dui. Nulla cursus turpis quis mattis rutrum. Suspendisse lobortis pulvinar mauris eget placerat.',
							          'more_text' => '',
							          'more_url' => '',
							        ),
							        1 => 
							        array (
							          'container_color' => '#ffffff',
							          'icon' => 'fontawesome-tablet',
							          'icon_color' => '#a58c6a',
							          'icon_image' => 0,
							          'title' => 'Mobile',
							          'text' => 'Donec sed dolor maximus nunc sagittis vehicula. Phasellus at ornare arcu, eu elementum risus. Mauris varius semper purus, non eleifend quam convallis ac. Vivamus sodales justo id sapien aliquam tempus. ',
							          'more_text' => '',
							          'more_url' => '',
							        ),
							        2 => 
							        array (
							          'container_color' => '#ffffff',
							          'icon' => 'fontawesome-camera',
							          'icon_color' => '#a58c6a',
							          'icon_image' => 0,
							          'title' => 'Photography',
							          'text' => 'Nam sit amet faucibus sapien. Vivamus quis mollis orci, eu sollicitudin urna. Donec turpis justo, iaculis sit amet lorem eu, rhoncus cursus ipsum. Ut laoreet accumsan arcu consequat consectetur.',
							          'more_text' => '',
							          'more_url' => '',
							        ),
							      ),
							      'container_shape' => 'rounded-hex',
							      'container_size' => 84,
							      'icon_size' => 24,
							      'per_row' => 3,
							      'responsive' => true,
							      'title_link' => false,
							      'icon_link' => false,
							      'new_window' => false,
							      'panels_info' => 
							      array (
							        'class' => 'SiteOrigin_Widget_Features_Widget',
							        'raw' => false,
							        'grid' => 2,
							        'cell' => 0,
							        'id' => 3,
							        'style' => 
							        array (
							          'background_display' => 'tile',
							          'font_color' => '#ffffff',
							        ),
							      ),
							    ),
							    4 => 
							    array (
							      'type' => 'visual',
							      'title' => '',
							      'text' => '<h3 style="text-align: center;"><span style="color: #242424;">OUR TEAM</span></h3><p style="text-align: center;">Donec quis molestie leo, sed efficitur dui. Nulla cursus turpis quis mattis rutrum. Suspendisse lobortis pulvinar mauris eget placerat. Suspendisse in dolor vitae risus maximus feugiat quis nec nisi.</p><p style="text-align: center;"> </p>',
							      'filter' => '1',
							      'panels_info' => 
							      array (
							        'class' => 'WP_Widget_Black_Studio_TinyMCE',
							        'raw' => false,
							        'grid' => 3,
							        'cell' => 1,
							        'id' => 4,
							        'style' => 
							        array (
							          'background_display' => 'tile',
							        ),
							      ),
							    ),
							    5 => 
							    array (
							      'image_fallback' => '',
							      'image' => 261,
							      'size' => 'full',
							      'title' => '',
							      'alt' => '',
							      'url' => '',
							      'bound' => true,
							      'new_window' => false,
							      'full_width' => false,
							      'panels_info' => 
							      array (
							        'class' => 'SiteOrigin_Widget_Image_Widget',
							        'raw' => false,
							        'grid' => 4,
							        'cell' => 0,
							        'id' => 5,
							        'style' => 
							        array (
							          'background_display' => 'tile',
							        ),
							      ),
							    ),
							    6 => 
							    array (
							      'type' => 'visual',
							      'title' => '',
							      'text' => '<p class="member-role"><span style="color: #242424;"><strong>Frank Thompson</strong></span><br />CEO</p><p class="member-role">Suspendisse lobortis pulvinar mauris eget placerat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis molestie leo, sed efficitur dui. Nulla cursus turpis quis mattis rutrum. </p>',
							      'filter' => '1',
							      'panels_info' => 
							      array (
							        'class' => 'WP_Widget_Black_Studio_TinyMCE',
							        'raw' => false,
							        'grid' => 4,
							        'cell' => 0,
							        'id' => 6,
							        'style' => 
							        array (
							          'background_display' => 'tile',
							        ),
							      ),
							    ),
							    7 => 
							    array (
							      'networks' => 
							      array (
							        0 => 
							        array (
							          'name' => 'twitter',
							          'url' => 'https://twitter.com/',
							          'icon_color' => '#ffffff',
							          'button_color' => '#78bdf1',
							        ),
							        1 => 
							        array (
							          'name' => 'linkedin',
							          'url' => 'https://www.linkedin.com/',
							          'icon_color' => '#ffffff',
							          'button_color' => '#0177b4',
							        ),
							        2 => 
							        array (
							          'name' => 'google-plus',
							          'url' => 'https://plus.google.com/',
							          'icon_color' => '#ffffff',
							          'button_color' => '#dd4b39',
							        ),
							        3 => 
							        array (
							          'name' => 'envelope',
							          'url' => 'mailto:',
							          'icon_color' => '#ffffff',
							          'button_color' => '#99c4e6',
							        ),
							      ),
							      'design' => 
							      array (
							        'new_window' => true,
							        'theme' => 'flat',
							        'hover' => true,
							        'icon_size' => '1',
							        'rounding' => '0.25',
							        'padding' => '0.5',
							        'align' => 'left',
							        'margin' => '0.1',
							      ),
							      'panels_info' => 
							      array (
							        'class' => 'SiteOrigin_Widget_SocialMediaButtons_Widget',
							        'raw' => false,
							        'grid' => 4,
							        'cell' => 0,
							        'id' => 7,
							        'style' => 
							        array (
							          'padding' => '0px',
							          'background_display' => 'tile',
							        ),
							      ),
							    ),
							    8 => 
							    array (
							      'image_fallback' => '',
							      'image' => 246,
							      'size' => 'full',
							      'title' => '',
							      'alt' => '',
							      'url' => '',
							      'bound' => true,
							      'new_window' => false,
							      'full_width' => false,
							      'panels_info' => 
							      array (
							        'class' => 'SiteOrigin_Widget_Image_Widget',
							        'raw' => false,
							        'grid' => 4,
							        'cell' => 1,
							        'id' => 8,
							        'style' => 
							        array (
							          'background_display' => 'tile',
							        ),
							      ),
							    ),
							    9 => 
							    array (
							      'type' => 'visual',
							      'title' => '',
							      'text' => '<p class="member-role"><span style="color: #242424;"><strong>Abby Smith</strong></span><br />Lead Designer</p><p class="member-role">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis molestie leo, sed efficitur dui. Nulla cursus turpis quis mattis rutrum. Suspendisse lobortis pulvinar mauris eget placerat.</p>',
							      'filter' => '1',
							      'panels_info' => 
							      array (
							        'class' => 'WP_Widget_Black_Studio_TinyMCE',
							        'raw' => false,
							        'grid' => 4,
							        'cell' => 1,
							        'id' => 9,
							        'style' => 
							        array (
							          'background_display' => 'tile',
							        ),
							      ),
							    ),
							    10 => 
							    array (
							      'networks' => 
							      array (
							        0 => 
							        array (
							          'name' => 'twitter',
							          'url' => 'https://twitter.com/',
							          'icon_color' => '#ffffff',
							          'button_color' => '#78bdf1',
							        ),
							        1 => 
							        array (
							          'name' => 'linkedin',
							          'url' => 'https://www.linkedin.com/',
							          'icon_color' => '#ffffff',
							          'button_color' => '#0177b4',
							        ),
							        2 => 
							        array (
							          'name' => 'google-plus',
							          'url' => 'https://plus.google.com/',
							          'icon_color' => '#ffffff',
							          'button_color' => '#dd4b39',
							        ),
							        3 => 
							        array (
							          'name' => 'envelope',
							          'url' => 'mailto:',
							          'icon_color' => '#ffffff',
							          'button_color' => '#99c4e6',
							        ),
							      ),
							      'design' => 
							      array (
							        'new_window' => true,
							        'theme' => 'flat',
							        'hover' => true,
							        'icon_size' => '1',
							        'rounding' => '0.25',
							        'padding' => '0.5',
							        'align' => 'left',
							        'margin' => '0.1',
							      ),
							      'panels_info' => 
							      array (
							        'class' => 'SiteOrigin_Widget_SocialMediaButtons_Widget',
							        'raw' => false,
							        'grid' => 4,
							        'cell' => 1,
							        'id' => 10,
							        'style' => 
							        array (
							          'padding' => '0px',
							          'background_display' => 'tile',
							        ),
							      ),
							    ),
							    11 => 
							    array (
							      'image_fallback' => '',
							      'image' => 262,
							      'size' => 'full',
							      'title' => '',
							      'alt' => '',
							      'url' => '',
							      'bound' => true,
							      'new_window' => false,
							      'full_width' => false,
							      'panels_info' => 
							      array (
							        'class' => 'SiteOrigin_Widget_Image_Widget',
							        'raw' => false,
							        'grid' => 4,
							        'cell' => 2,
							        'id' => 11,
							        'style' => 
							        array (
							          'background_display' => 'tile',
							        ),
							      ),
							    ),
							    12 => 
							    array (
							      'type' => 'visual',
							      'title' => '',
							      'text' => '<p class="member-role"><span style="color: #242424;"><strong>Brian Carson</strong></span><br />Lead Developer</p><p class="member-role">Suspendisse in dolor vitae risus maximus feugiat quis nec nisi. Nulla cursus turpis quis mattis rutrum. Suspendisse lobortis pulvinar mauris eget placerat.</p>',
							      'filter' => '1',
							      'panels_info' => 
							      array (
							        'class' => 'WP_Widget_Black_Studio_TinyMCE',
							        'raw' => false,
							        'grid' => 4,
							        'cell' => 2,
							        'id' => 12,
							        'style' => 
							        array (
							          'background_display' => 'tile',
							        ),
							      ),
							    ),
							    13 => 
							    array (
							      'networks' => 
							      array (
							        0 => 
							        array (
							          'name' => 'twitter',
							          'url' => 'https://twitter.com/',
							          'icon_color' => '#ffffff',
							          'button_color' => '#78bdf1',
							        ),
							        1 => 
							        array (
							          'name' => 'linkedin',
							          'url' => 'https://www.linkedin.com/',
							          'icon_color' => '#ffffff',
							          'button_color' => '#0177b4',
							        ),
							        2 => 
							        array (
							          'name' => 'google-plus',
							          'url' => 'https://plus.google.com/',
							          'icon_color' => '#ffffff',
							          'button_color' => '#dd4b39',
							        ),
							        3 => 
							        array (
							          'name' => 'envelope',
							          'url' => 'mailto:',
							          'icon_color' => '#ffffff',
							          'button_color' => '#99c4e6',
							        ),
							      ),
							      'design' => 
							      array (
							        'new_window' => true,
							        'theme' => 'flat',
							        'hover' => true,
							        'icon_size' => '1',
							        'rounding' => '0.25',
							        'padding' => '0.5',
							        'align' => 'left',
							        'margin' => '0.1',
							      ),
							      'panels_info' => 
							      array (
							        'class' => 'SiteOrigin_Widget_SocialMediaButtons_Widget',
							        'raw' => false,
							        'grid' => 4,
							        'cell' => 2,
							        'id' => 13,
							        'style' => 
							        array (
							          'padding' => '0px',
							          'background_display' => 'tile',
							        ),
							      ),
							    ),
							    14 => 
							    array (
							      'map_center' => '350 5th Avenue, New York, NY 10118',
							      'settings' => 
							      array (
							        'map_type' => 'interactive',
							        'width' => '640',
							        'height' => '480',
							        'zoom' => 12,
							        'scroll_zoom' => true,
							        'draggable' => true,
							      ),
							      'markers' => 
							      array (
							        'marker_at_center' => true,
							        'marker_icon' => 1063,
							      ),
							      'styles' => 
							      array (
							        'style_method' => 'raw_json',
							        'styled_map_name' => '',
							        'raw_json_map_styles' => '[{"featureType":"all","elementType":"all","stylers":[{"hue":"#ffaa00"},{"saturation":"-33"},{"lightness":"10"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"labels.text","stylers":[{"visibility":"on"}]}]',
							      ),
							      'directions' => 
							      array (
							        'origin' => '',
							        'destination' => '',
							        'travel_mode' => 'driving',
							      ),
							      'api_key_section' => 
							      array (
							        'api_key' => '',
							      ),
							      'panels_info' => 
							      array (
							        'class' => 'SiteOrigin_Widget_GoogleMap_Widget',
							        'grid' => 5,
							        'cell' => 0,
							        'id' => 14,
							        'style' => 
							        array (
							          'background_image_attachment' => false,
							          'background_display' => 'tile',
							        ),
							      ),
							    ),
							  ),
							  'grids' => 
							  array (
							    0 => 
							    array (
							      'cells' => 1,
							      'style' => 
							      array (
							        'bottom_margin' => '0px',
							        'row_stretch' => 'full',
							        'equal_column_height' => 'no',
							        'padding_top' => '250px',
							        'padding_bottom' => '250px',
							        'background_image' => 264,
							        'background_image_position' => 'left top',
							        'background_image_style' => 'parallax',
							      ),
							    ),
							    1 => 
							    array (
							      'cells' => 3,
							      'style' => 
							      array (
							        'bottom_margin' => '0px',
							        'row_stretch' => 'full',
							        'background' => '#f4f4f4',
							        'equal_column_height' => 'no',
							        'padding_top' => '60px',
							        'padding_bottom' => '50px',
							        'background_image_position' => 'left top',
							        'background_image_style' => 'cover',
							      ),
							    ),
							    2 => 
							    array (
							      'cells' => 1,
							      'style' => 
							      array (
							        'bottom_margin' => '0px',
							        'row_stretch' => 'full',
							        'equal_column_height' => 'no',
							        'padding_top' => '70px',
							        'padding_bottom' => '50px',
							        'background_image' => 302,
							        'background_image_position' => 'left top',
							        'background_image_style' => 'parallax',
							      ),
							    ),
							    3 => 
							    array (
							      'cells' => 3,
							      'style' => 
							      array (
							        'bottom_margin' => '0px',
							        'row_stretch' => 'full',
							        'equal_column_height' => 'no',
							        'padding_top' => '50px',
							        'padding_bottom' => '0px',
							        'background_image_position' => 'left top',
							        'background_image_style' => 'cover',
							      ),
							    ),
							    4 => 
							    array (
							      'cells' => 3,
							      'style' => 
							      array (
							        'bottom_margin' => '50px',
							        'gutter' => '30px',
							        'equal_column_height' => 'no',
							        'padding_top' => '0px',
							        'padding_bottom' => '0px',
							        'background_image_position' => 'left top',
							        'background_image_style' => 'cover',
							      ),
							    ),
							    5 => 
							    array (
							      'cells' => 1,
							      'style' => 
							      array (
							        'row_stretch' => 'full-stretched',
							        'equal_column_height' => 'no',
							        'background_image_position' => 'left top',
							        'background_image_style' => 'cover',
							      ),
							    ),
							  ),
							  'grid_cells' => 
							  array (
							    0 => 
							    array (
							      'grid' => 0,
							      'weight' => 1,
							    ),
							    1 => 
							    array (
							      'grid' => 1,
							      'weight' => 0.2002534854245900108882239010199555195868015289306640625,
							    ),
							    2 => 
							    array (
							      'grid' => 1,
							      'weight' => 0.5994930291508200337347034292179159820079803466796875,
							    ),
							    3 => 
							    array (
							      'grid' => 1,
							      'weight' => 0.2002534854245900108882239010199555195868015289306640625,
							    ),
							    4 => 
							    array (
							      'grid' => 2,
							      'weight' => 1,
							    ),
							    5 => 
							    array (
							      'grid' => 3,
							      'weight' => 0.2002534854245900108882239010199555195868015289306640625,
							    ),
							    6 => 
							    array (
							      'grid' => 3,
							      'weight' => 0.5994930291508200337347034292179159820079803466796875,
							    ),
							    7 => 
							    array (
							      'grid' => 3,
							      'weight' => 0.2002534854245900108882239010199555195868015289306640625,
							    ),
							    8 => 
							    array (
							      'grid' => 4,
							      'weight' => 0.333333333333333314829616256247390992939472198486328125,
							    ),
							    9 => 
							    array (
							      'grid' => 4,
							      'weight' => 0.333333333333333314829616256247390992939472198486328125,
							    ),
							    10 => 
							    array (
							      'grid' => 4,
							      'weight' => 0.333333333333333314829616256247390992939472198486328125,
							    ),
							    11 => 
							    array (
							      'grid' => 5,
							      'weight' => 1,
							    ),
							  ),
							);
							
							$layouts['about-us-blocks'] = array(
								'name' => __('About Us Blocks', 'create'),
								'description' => __('Layout for demo About Us: Blocks page.', 'create'),
								'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/about_us_blocks.jpg',
						        'widgets' => 
								  array (
								    0 => 
								    array (
								      'type' => 'visual',
								      'title' => '',
								      'text' => '<h1 style="text-align: center;">ABOUT US</h1><p style="text-align: center;"><span style="font-size: 21px; color: #737373;">The Create WordPress theme will change the way you build websites.</span></p>',
								      'filter' => '1',
								      'panels_info' => 
								      array (
								        'class' => 'WP_Widget_Black_Studio_TinyMCE',
								        'raw' => false,
								        'grid' => 0,
								        'cell' => 0,
								        'id' => 0,
								        'style' => 
								        array (
								          'background_display' => 'tile',
								          'font_color' => '#0a0a0a',
								        ),
								      ),
								    ),
								    1 => 
								    array (
								      'type' => 'visual',
								      'title' => '',
								      'text' => '<h3>HOW WE WORK</h3><p><span style="color: #808080;">Donec sed dolor maximus nunc sagittis vehicula. Phasellus at ornare arcu, eu elementum risus. Mauris varius semper purus, non eleifend quam convallis ac. Vivamus sodales justo id sapien aliquam tempus.</span></p>',
								      'filter' => '1',
								      'panels_info' => 
								      array (
								        'class' => 'WP_Widget_Black_Studio_TinyMCE',
								        'raw' => false,
								        'grid' => 1,
								        'cell' => 0,
								        'id' => 1,
								        'style' => 
								        array (
								          'padding' => '50px',
								          'background' => '#262626',
								          'background_display' => 'tile',
								          'font_color' => '#ffffff',
								        ),
								      ),
								    ),
								    2 => 
								    array (
								      'min_height' => '250',
								      'panels_info' => 
								      array (
								        'class' => 'TTrust_Spacer',
								        'raw' => false,
								        'grid' => 1,
								        'cell' => 1,
								        'id' => 2,
								        'style' => 
								        array (
								          'background_image_attachment' => 343,
								          'background_display' => 'cover',
								        ),
								      ),
								    ),
								    3 => 
								    array (
								      'type' => 'visual',
								      'title' => '',
								      'text' => '<h3>OUR PROCESS</h3><p><span style="color: #808080;">Vivamus sodales justo id sapien aliquam tempus. Donec sed dolor maximus nunc sagittis vehicula. Phasellus at ornare arcu, eu elementum risus. Mauris varius semper purus, non eleifend quam convallis ac. </span></p>',
								      'filter' => '1',
								      'panels_info' => 
								      array (
								        'class' => 'WP_Widget_Black_Studio_TinyMCE',
								        'raw' => false,
								        'grid' => 1,
								        'cell' => 2,
								        'id' => 3,
								        'style' => 
								        array (
								          'padding' => '50px',
								          'background' => '#262626',
								          'background_display' => 'tile',
								          'font_color' => '#ffffff',
								        ),
								      ),
								    ),
								    4 => 
								    array (
								      'min_height' => '250',
								      'panels_info' => 
								      array (
								        'class' => 'TTrust_Spacer',
								        'raw' => false,
								        'grid' => 2,
								        'cell' => 0,
								        'id' => 4,
								        'style' => 
								        array (
								          'background_image_attachment' => 351,
								          'background_display' => 'cover',
								        ),
								      ),
								    ),
								    5 => 
								    array (
								      'type' => 'visual',
								      'title' => '',
								      'text' => '<h3>WHAT WE DO</h3><p><span style="color: #e5b89c;">Donec sed dolor maximus nunc sagittis vehicula. Phasellus at ornare arcu, eu elementum risus. Mauris varius semper purus, non eleifend quam convallis ac. Vivamus sodales justo id sapien aliquam tempus.</span></p>',
								      'filter' => '1',
								      'panels_info' => 
								      array (
								        'class' => 'WP_Widget_Black_Studio_TinyMCE',
								        'raw' => false,
								        'grid' => 2,
								        'cell' => 1,
								        'id' => 5,
								        'style' => 
								        array (
								          'padding' => '50px',
								          'background' => '#e56934',
								          'background_display' => 'tile',
								          'font_color' => '#ffffff',
								        ),
								      ),
								    ),
								    6 => 
								    array (
								      'min_height' => '250',
								      'panels_info' => 
								      array (
								        'class' => 'TTrust_Spacer',
								        'raw' => false,
								        'grid' => 2,
								        'cell' => 2,
								        'id' => 6,
								        'style' => 
								        array (
								          'background_image_attachment' => 359,
								          'background_display' => 'cover',
								        ),
								      ),
								    ),
								    7 => 
								    array (
								      'type' => 'visual',
								      'title' => '',
								      'text' => '<h3 style="text-align: center;"><span style="color: #242424;">OUR SERVICES</span></h3><p style="text-align: center;">Nulla cursus turpis quis mattis rutrum. Suspendisse lobortis pulvinar. </p>',
								      'filter' => '1',
								      'panels_info' => 
								      array (
								        'class' => 'WP_Widget_Black_Studio_TinyMCE',
								        'raw' => false,
								        'grid' => 3,
								        'cell' => 1,
								        'id' => 7,
								        'style' => 
								        array (
								          'background_display' => 'tile',
								        ),
								      ),
								    ),
								    8 => 
								    array (
								      'features' => 
								      array (
								        0 => 
								        array (
								          'container_color' => false,
								          'icon' => 'fontawesome-desktop',
								          'icon_color' => '#ea6035',
								          'icon_image' => 0,
								          'title' => 'Web Design',
								          'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis molestie leo, sed efficitur dui. Nulla cursus turpis quis mattis rutrum. Suspendisse lobortis pulvinar mauris eget placerat.',
								          'more_text' => '',
								          'more_url' => '',
								        ),
								        1 => 
								        array (
								          'container_color' => false,
								          'icon' => 'fontawesome-tablet',
								          'icon_color' => '#ea6035',
								          'icon_image' => 0,
								          'title' => 'Mobile',
								          'text' => 'Donec sed dolor maximus nunc sagittis vehicula. Phasellus at ornare arcu, eu elementum risus. Mauris varius semper purus, non eleifend quam convallis ac. Vivamus sodales justo id sapien aliquam tempus. ',
								          'more_text' => '',
								          'more_url' => '',
								        ),
								        2 => 
								        array (
								          'container_color' => false,
								          'icon' => 'fontawesome-camera',
								          'icon_color' => '#ea6035',
								          'icon_image' => 0,
								          'title' => 'Photography',
								          'text' => 'Nam sit amet faucibus sapien. Vivamus quis mollis orci, eu sollicitudin urna. Donec turpis justo, iaculis sit amet lorem eu, rhoncus cursus ipsum. Ut laoreet accumsan arcu consequat consectetur.',
								          'more_text' => '',
								          'more_url' => '',
								        ),
								      ),
								      'container_shape' => 'round',
								      'container_size' => 30,
								      'icon_size' => 30,
								      'per_row' => 3,
								      'responsive' => true,
								      'title_link' => false,
								      'icon_link' => false,
								      'new_window' => false,
								      'panels_info' => 
								      array (
								        'class' => 'SiteOrigin_Widget_Features_Widget',
								        'raw' => false,
								        'grid' => 4,
								        'cell' => 0,
								        'id' => 8,
								        'style' => 
								        array (
								          'padding' => '0px',
								          'background_display' => 'tile',
								          'font_color' => '#242424',
								        ),
								      ),
								    ),
								    9 => 
								    array (
								      'type' => 'visual',
								      'title' => '',
								      'text' => '<h3 style="text-align: center;"><span style="color: #242424;">OUR TEAM</span></h3><p style="text-align: center;">Donec quis molestie leo, sed efficitur dui. Nulla cursus turpis quis mattis rutrum. Suspendisse lobortis pulvinar mauris eget placerat. Suspendisse in dolor vitae risus maximus feugiat quis nec nisi.</p><p style="text-align: center;"> </p>',
								      'filter' => '1',
								      'panels_info' => 
								      array (
								        'class' => 'WP_Widget_Black_Studio_TinyMCE',
								        'raw' => false,
								        'grid' => 5,
								        'cell' => 1,
								        'id' => 9,
								        'style' => 
								        array (
								          'background_display' => 'tile',
								        ),
								      ),
								    ),
								    10 => 
								    array (
								      'image_fallback' => '',
								      'image' => 261,
								      'size' => 'full',
								      'title' => '',
								      'alt' => '',
								      'url' => '',
								      'bound' => true,
								      'new_window' => false,
								      'full_width' => false,
								      'panels_info' => 
								      array (
								        'class' => 'SiteOrigin_Widget_Image_Widget',
								        'raw' => false,
								        'grid' => 6,
								        'cell' => 0,
								        'id' => 10,
								        'style' => 
								        array (
								          'background_display' => 'tile',
								        ),
								      ),
								    ),
								    11 => 
								    array (
								      'type' => 'visual',
								      'title' => '',
								      'text' => '<p class="member-role"><span style="color: #242424;"><strong>Frank Thompson</strong></span><br />CEO</p><p class="member-role">Suspendisse lobortis pulvinar mauris eget placerat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis molestie leo, sed efficitur dui. Nulla cursus turpis quis mattis rutrum. </p>',
								      'filter' => '1',
								      'panels_info' => 
								      array (
								        'class' => 'WP_Widget_Black_Studio_TinyMCE',
								        'raw' => false,
								        'grid' => 6,
								        'cell' => 0,
								        'id' => 11,
								        'style' => 
								        array (
								          'background_display' => 'tile',
								        ),
								      ),
								    ),
								    12 => 
								    array (
								      'networks' => 
								      array (
								        0 => 
								        array (
								          'name' => 'twitter',
								          'url' => 'https://twitter.com/',
								          'icon_color' => '#ffffff',
								          'button_color' => '#cccccc',
								        ),
								        1 => 
								        array (
								          'name' => 'linkedin',
								          'url' => 'https://www.linkedin.com/',
								          'icon_color' => '#ffffff',
								          'button_color' => '#cccccc',
								        ),
								        2 => 
								        array (
								          'name' => 'google-plus',
								          'url' => 'https://plus.google.com/',
								          'icon_color' => '#ffffff',
								          'button_color' => '#cccccc',
								        ),
								        3 => 
								        array (
								          'name' => 'envelope',
								          'url' => 'mailto:',
								          'icon_color' => '#ffffff',
								          'button_color' => '#cccccc',
								        ),
								      ),
								      'design' => 
								      array (
								        'new_window' => true,
								        'theme' => 'flat',
								        'hover' => true,
								        'icon_size' => '1',
								        'rounding' => '0.25',
								        'padding' => '0.5',
								        'align' => 'left',
								        'margin' => '0.1',
								      ),
								      'panels_info' => 
								      array (
								        'class' => 'SiteOrigin_Widget_SocialMediaButtons_Widget',
								        'raw' => false,
								        'grid' => 6,
								        'cell' => 0,
								        'id' => 12,
								        'style' => 
								        array (
								          'padding' => '0px',
								          'background_display' => 'tile',
								        ),
								      ),
								    ),
								    13 => 
								    array (
								      'image_fallback' => '',
								      'image' => 246,
								      'size' => 'full',
								      'title' => '',
								      'alt' => '',
								      'url' => '',
								      'bound' => true,
								      'new_window' => false,
								      'full_width' => false,
								      'panels_info' => 
								      array (
								        'class' => 'SiteOrigin_Widget_Image_Widget',
								        'raw' => false,
								        'grid' => 6,
								        'cell' => 1,
								        'id' => 13,
								        'style' => 
								        array (
								          'background_display' => 'tile',
								        ),
								      ),
								    ),
								    14 => 
								    array (
								      'type' => 'visual',
								      'title' => '',
								      'text' => '<p class="member-role"><span style="color: #242424;"><strong>Abby Smith</strong></span><br />Lead Designer</p><p class="member-role">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis molestie leo, sed efficitur dui. Nulla cursus turpis quis mattis rutrum. Suspendisse lobortis pulvinar mauris eget placerat.</p>',
								      'filter' => '1',
								      'panels_info' => 
								      array (
								        'class' => 'WP_Widget_Black_Studio_TinyMCE',
								        'raw' => false,
								        'grid' => 6,
								        'cell' => 1,
								        'id' => 14,
								        'style' => 
								        array (
								          'background_display' => 'tile',
								        ),
								      ),
								    ),
								    15 => 
								    array (
								      'networks' => 
								      array (
								        0 => 
								        array (
								          'name' => 'twitter',
								          'url' => 'https://twitter.com/',
								          'icon_color' => '#ffffff',
								          'button_color' => '#cccccc',
								        ),
								        1 => 
								        array (
								          'name' => 'linkedin',
								          'url' => 'https://www.linkedin.com/',
								          'icon_color' => '#ffffff',
								          'button_color' => '#cccccc',
								        ),
								        2 => 
								        array (
								          'name' => 'google-plus',
								          'url' => 'https://plus.google.com/',
								          'icon_color' => '#ffffff',
								          'button_color' => '#cccccc',
								        ),
								        3 => 
								        array (
								          'name' => 'envelope',
								          'url' => 'mailto:',
								          'icon_color' => '#ffffff',
								          'button_color' => '#cccccc',
								        ),
								      ),
								      'design' => 
								      array (
								        'new_window' => true,
								        'theme' => 'flat',
								        'hover' => true,
								        'icon_size' => '1',
								        'rounding' => '0.25',
								        'padding' => '0.5',
								        'align' => 'left',
								        'margin' => '0.1',
								      ),
								      'panels_info' => 
								      array (
								        'class' => 'SiteOrigin_Widget_SocialMediaButtons_Widget',
								        'raw' => false,
								        'grid' => 6,
								        'cell' => 1,
								        'id' => 15,
								        'style' => 
								        array (
								          'padding' => '0px',
								          'background_display' => 'tile',
								        ),
								      ),
								    ),
								    16 => 
								    array (
								      'image_fallback' => '',
								      'image' => 262,
								      'size' => 'full',
								      'title' => '',
								      'alt' => '',
								      'url' => '',
								      'bound' => true,
								      'new_window' => false,
								      'full_width' => false,
								      'panels_info' => 
								      array (
								        'class' => 'SiteOrigin_Widget_Image_Widget',
								        'raw' => false,
								        'grid' => 6,
								        'cell' => 2,
								        'id' => 16,
								        'style' => 
								        array (
								          'background_display' => 'tile',
								        ),
								      ),
								    ),
								    17 => 
								    array (
								      'type' => 'visual',
								      'title' => '',
								      'text' => '<p class="member-role"><span style="color: #242424;"><strong>Brian Carson</strong></span><br />Lead Developer</p><p class="member-role">Suspendisse in dolor vitae risus maximus feugiat quis nec nisi. Nulla cursus turpis quis mattis rutrum. Suspendisse lobortis pulvinar mauris eget placerat.</p>',
								      'filter' => '1',
								      'panels_info' => 
								      array (
								        'class' => 'WP_Widget_Black_Studio_TinyMCE',
								        'raw' => false,
								        'grid' => 6,
								        'cell' => 2,
								        'id' => 17,
								        'style' => 
								        array (
								          'background_display' => 'tile',
								        ),
								      ),
								    ),
								    18 => 
								    array (
								      'networks' => 
								      array (
								        0 => 
								        array (
								          'name' => 'twitter',
								          'url' => 'https://twitter.com/',
								          'icon_color' => '#ffffff',
								          'button_color' => '#cccccc',
								        ),
								        1 => 
								        array (
								          'name' => 'linkedin',
								          'url' => 'https://www.linkedin.com/',
								          'icon_color' => '#ffffff',
								          'button_color' => '#cccccc',
								        ),
								        2 => 
								        array (
								          'name' => 'google-plus',
								          'url' => 'https://plus.google.com/',
								          'icon_color' => '#ffffff',
								          'button_color' => '#cccccc',
								        ),
								        3 => 
								        array (
								          'name' => 'envelope',
								          'url' => 'mailto:',
								          'icon_color' => '#ffffff',
								          'button_color' => '#cccccc',
								        ),
								      ),
								      'design' => 
								      array (
								        'new_window' => true,
								        'theme' => 'flat',
								        'hover' => true,
								        'icon_size' => '1',
								        'rounding' => '0.25',
								        'padding' => '0.5',
								        'align' => 'left',
								        'margin' => '0.1',
								      ),
								      'panels_info' => 
								      array (
								        'class' => 'SiteOrigin_Widget_SocialMediaButtons_Widget',
								        'raw' => false,
								        'grid' => 6,
								        'cell' => 2,
								        'id' => 18,
								        'style' => 
								        array (
								          'padding' => '0px',
								          'background_display' => 'tile',
								        ),
								      ),
								    ),
								  ),
								  'grids' => 
								  array (
								    0 => 
								    array (
								      'cells' => 1,
								      'style' => 
								      array (
								        'bottom_margin' => '0px',
								        'row_stretch' => 'full',
								        'equal_column_height' => 'no',
								        'padding_top' => '180px',
								        'padding_bottom' => '180px',
								        'background_image' => 340,
								        'background_image_position' => 'left top',
								        'background_image_style' => 'cover',
								      ),
								    ),
								    1 => 
								    array (
								      'cells' => 3,
								      'style' => 
								      array (
								        'bottom_margin' => '0px',
								        'gutter' => '0px',
								        'row_stretch' => 'full-stretched',
								        'equal_column_height' => 'yes',
								        'padding_top' => '0px',
								        'padding_bottom' => '0px',
								        'padding_left' => '0px',
								        'padding_right' => '0px',
								        'background_image_position' => 'left top',
								        'background_image_style' => 'cover',
								      ),
								    ),
								    2 => 
								    array (
								      'cells' => 3,
								      'style' => 
								      array (
								        'bottom_margin' => '0px',
								        'gutter' => '0px',
								        'row_stretch' => 'full-stretched',
								        'equal_column_height' => 'yes',
								        'padding_top' => '0px',
								        'padding_bottom' => '0px',
								        'padding_left' => '0px',
								        'padding_right' => '0px',
								        'background_image_position' => 'left top',
								        'background_image_style' => 'cover',
								      ),
								    ),
								    3 => 
								    array (
								      'cells' => 3,
								      'style' => 
								      array (
								        'bottom_margin' => '0px',
								        'gutter' => '0px',
								        'row_stretch' => 'full',
								        'equal_column_height' => 'no',
								        'padding_top' => '50px',
								        'padding_bottom' => '0px',
								        'background_image_position' => 'left top',
								        'background_image_style' => 'cover',
								      ),
								    ),
								    4 => 
								    array (
								      'cells' => 1,
								      'style' => 
								      array (
								        'bottom_margin' => '0px',
								        'gutter' => '0px',
								        'row_stretch' => 'full',
								        'equal_column_height' => 'no',
								        'padding_top' => '50px',
								        'padding_bottom' => '50px',
								        'background_image_position' => 'left top',
								        'background_image_style' => 'parallax',
								      ),
								    ),
								    5 => 
								    array (
								      'cells' => 3,
								      'style' => 
								      array (
								        'bottom_margin' => '0px',
								        'row_stretch' => 'full',
								        'background' => '#f2f2f2',
								        'equal_column_height' => 'no',
								        'padding_top' => '50px',
								        'padding_bottom' => '0px',
								        'background_image_position' => 'left top',
								        'background_image_style' => 'cover',
								      ),
								    ),
								    6 => 
								    array (
								      'cells' => 3,
								      'style' => 
								      array (
								        'bottom_margin' => '50px',
								        'gutter' => '30px',
								        'row_stretch' => 'full',
								        'background' => '#f2f2f2',
								        'equal_column_height' => 'no',
								        'padding_top' => '0px',
								        'padding_bottom' => '50px',
								        'background_image_position' => 'left top',
								        'background_image_style' => 'cover',
								      ),
								    ),
								  ),
								  'grid_cells' => 
								  array (
								    0 => 
								    array (
								      'grid' => 0,
								      'weight' => 1,
								    ),
								    1 => 
								    array (
								      'grid' => 1,
								      'weight' => 0.333333333333333314829616256247390992939472198486328125,
								    ),
								    2 => 
								    array (
								      'grid' => 1,
								      'weight' => 0.333333333333333314829616256247390992939472198486328125,
								    ),
								    3 => 
								    array (
								      'grid' => 1,
								      'weight' => 0.333333333333333314829616256247390992939472198486328125,
								    ),
								    4 => 
								    array (
								      'grid' => 2,
								      'weight' => 0.333333333333333314829616256247390992939472198486328125,
								    ),
								    5 => 
								    array (
								      'grid' => 2,
								      'weight' => 0.333333333333333314829616256247390992939472198486328125,
								    ),
								    6 => 
								    array (
								      'grid' => 2,
								      'weight' => 0.333333333333333314829616256247390992939472198486328125,
								    ),
								    7 => 
								    array (
								      'grid' => 3,
								      'weight' => 0.2002534854245900108882239010199555195868015289306640625,
								    ),
								    8 => 
								    array (
								      'grid' => 3,
								      'weight' => 0.5994930291508200337347034292179159820079803466796875,
								    ),
								    9 => 
								    array (
								      'grid' => 3,
								      'weight' => 0.2002534854245900108882239010199555195868015289306640625,
								    ),
								    10 => 
								    array (
								      'grid' => 4,
								      'weight' => 1,
								    ),
								    11 => 
								    array (
								      'grid' => 5,
								      'weight' => 0.2002534854245900108882239010199555195868015289306640625,
								    ),
								    12 => 
								    array (
								      'grid' => 5,
								      'weight' => 0.5994930291508200337347034292179159820079803466796875,
								    ),
								    13 => 
								    array (
								      'grid' => 5,
								      'weight' => 0.2002534854245900108882239010199555195868015289306640625,
								    ),
								    14 => 
								    array (
								      'grid' => 6,
								      'weight' => 0.333333333333333314829616256247390992939472198486328125,
								    ),
								    15 => 
								    array (
								      'grid' => 6,
								      'weight' => 0.333333333333333314829616256247390992939472198486328125,
								    ),
								    16 => 
								    array (
								      'grid' => 6,
								      'weight' => 0.333333333333333314829616256247390992939472198486328125,
								    ),
								  ),
								);
								
								$layouts['contact-us'] = array(
									'name' => __('Contact Us', 'create'),
									'description' => __('Layout for demo Contact Us page.', 'create'),
									'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/contact_us.jpg',
							        'widgets' => 
									  array (
									    0 => 
									    array (
									      'map_center' => '350 5th Ave, New York, NY 10118',
									      'settings' => 
									      array (
									        'map_type' => 'interactive',
									        'width' => '640',
									        'height' => '480',
									        'zoom' => 12,
									        'scroll_zoom' => true,
									        'draggable' => true,
									      ),
									      'markers' => 
									      array (
									        'marker_at_center' => true,
									        'marker_icon' => 1065,
									      ),
									      'styles' => 
									      array (
									        'style_method' => 'raw_json',
									        'styled_map_name' => '',
									        'raw_json_map_styles' => '[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]',
									      ),
									      'directions' => 
									      array (
									        'origin' => '',
									        'destination' => '',
									        'travel_mode' => 'driving',
									      ),
									      'api_key_section' => 
									      array (
									        'api_key' => '',
									      ),
									      'panels_info' => 
									      array (
									        'class' => 'SiteOrigin_Widget_GoogleMap_Widget',
									        'grid' => 0,
									        'cell' => 0,
									        'id' => 0,
									        'style' => 
									        array (
									          'background_image_attachment' => false,
									          'background_display' => 'tile',
									        ),
									      ),
									    ),
									    1 => 
									    array (
									      'type' => 'visual',
									      'title' => '',
									      'text' => '<h3><span style="color: #242424;">Contact Us</span></h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus posuere interdum diam eget semper. Pellentesque purus turpis, vehicula et posuere ultrices, dictum vitae turpis. Cras porta enim justo, a tempus arcu ullamcorper in.</p><p>[contact-form-7 id="732" title="Contact form 1"]</p>',
									      'filter' => '1',
									      'panels_info' => 
									      array (
									        'class' => 'WP_Widget_Black_Studio_TinyMCE',
									        'raw' => false,
									        'grid' => 1,
									        'cell' => 0,
									        'id' => 1,
									        'style' => 
									        array (
									          'background_display' => 'tile',
									        ),
									      ),
									    ),
									    2 => 
									    array (
									      'type' => 'visual',
									      'title' => '',
									      'text' => '<h4><span style="color: #242424;">Address</span></h4><p>1234 Main St.<br />New York, NY 10021</p><h4><span style="color: #242424;">Phone</span></h4><p>555-456-7892 <em>New York Office<br /></em>555-376-4532 Los Angeles<em> Office</em></p><h4><span style="color: #242424;">Email</span></h4><p>contact@create-digital.com</p>',
									      'filter' => '1',
									      'panels_info' => 
									      array (
									        'class' => 'WP_Widget_Black_Studio_TinyMCE',
									        'raw' => false,
									        'grid' => 1,
									        'cell' => 1,
									        'id' => 2,
									        'style' => 
									        array (
									          'padding' => '50px',
									          'background' => '#f7f7f7',
									          'background_display' => 'tile',
									        ),
									      ),
									    ),
									  ),
									  'grids' => 
									  array (
									    0 => 
									    array (
									      'cells' => 1,
									      'style' => 
									      array (
									        'bottom_margin' => '60px',
									        'row_stretch' => 'full-stretched',
									        'equal_column_height' => 'no',
									        'background_image_position' => 'left top',
									        'background_image_style' => 'cover',
									      ),
									    ),
									    1 => 
									    array (
									      'cells' => 2,
									      'style' => 
									      array (
									        'bottom_margin' => '60px',
									        'equal_column_height' => 'no',
									        'padding_bottom' => '60px',
									        'background_image_position' => 'left top',
									        'background_image_style' => 'cover',
									      ),
									    ),
									  ),
									  'grid_cells' => 
									  array (
									    0 => 
									    array (
									      'grid' => 0,
									      'weight' => 1,
									    ),
									    1 => 
									    array (
									      'grid' => 1,
									      'weight' => 0.63971539456661996592146124385180883109569549560546875,
									    ),
									    2 => 
									    array (
									      'grid' => 1,
									      'weight' => 0.360284605433379978567387524890364147722721099853515625,
									    ),
									  ),
									);
									
									$layouts['pricing'] = array(
										'name' => __('Pricing', 'create'),
										'description' => __('Layout for demo Pricing page.', 'create'),
										'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/pricing.jpg',
								        'widgets' => 
										  array (
										    0 => 
										    array (
										      'type' => 'visual',
										      'title' => '',
										      'text' => '<h2 style="text-align: center;"><span style="color: #333333;">We Give You the <span style="color: #bb9f7c;">Best</span> Value</span></h2><p style="text-align: center;"><span style="font-size: 21px;">This is an example pricing page. It\'s super easy to create beautiful pricing tables. You have options to set colors, features, icons and more.</span></p>',
										      'filter' => '1',
										      'panels_info' => 
										      array (
										        'class' => 'WP_Widget_Black_Studio_TinyMCE',
										        'raw' => false,
										        'grid' => 0,
										        'cell' => 1,
										        'id' => 0,
										        'style' => 
										        array (
										          'background_display' => 'tile',
										        ),
										      ),
										    ),
										    1 => 
										    array (
										      'title' => false,
										      'columns' => 
										      array (
										        0 => 
										        array (
										          'featured' => '',
										          'title' => 'Silver',
										          'subtitle' => 'Budget Plan',
										          'image' => '',
										          'price' => '$59',
										          'per' => 'per month',
										          'button' => 'BUY NOW',
										          'url' => '#',
										          'features' => 
										          array (
										            0 => 
										            array (
										              'text' => '1 GB Storage',
										              'hover' => '',
										              'icon_new' => 'fontawesome-database',
										              'icon_color' => '',
										            ),
										            1 => 
										            array (
										              'text' => '2 Domain Names',
										              'hover' => '',
										              'icon_new' => 'fontawesome-globe',
										              'icon_color' => '',
										            ),
										            2 => 
										            array (
										              'text' => '3 FTP Users',
										              'hover' => '',
										              'icon_new' => 'fontawesome-user',
										              'icon_color' => '',
										            ),
										            3 => 
										            array (
										              'text' => '100 GB Bandwidth',
										              'hover' => '',
										              'icon_new' => 'fontawesome-exchange',
										              'icon_color' => '',
										            ),
										          ),
										        ),
										        1 => 
										        array (
										          'featured' => 'on',
										          'title' => 'Gold',
										          'subtitle' => 'Best Value',
										          'image' => '',
										          'price' => '$99',
										          'per' => 'per month',
										          'button' => 'BUY NOW',
										          'url' => '#',
										          'features' => 
										          array (
										            0 => 
										            array (
										              'text' => '3 GB Storage',
										              'hover' => '',
										              'icon_new' => 'fontawesome-database',
										              'icon_color' => '',
										            ),
										            1 => 
										            array (
										              'text' => '5 Domain Names',
										              'hover' => '',
										              'icon_new' => 'fontawesome-globe',
										              'icon_color' => '',
										            ),
										            2 => 
										            array (
										              'text' => '5 FTP Users',
										              'hover' => '',
										              'icon_new' => 'fontawesome-user',
										              'icon_color' => '',
										            ),
										            3 => 
										            array (
										              'text' => '1000 GB Bandwidth',
										              'hover' => '',
										              'icon_new' => 'fontawesome-exchange',
										              'icon_color' => '',
										            ),
										          ),
										        ),
										        2 => 
										        array (
										          'featured' => '',
										          'title' => 'Platinum',
										          'subtitle' => 'Business & Enterpise',
										          'image' => '',
										          'price' => '$129',
										          'per' => 'per month',
										          'button' => 'BUY NOW',
										          'url' => '#',
										          'features' => 
										          array (
										            0 => 
										            array (
										              'text' => '10 GB Storage',
										              'hover' => '',
										              'icon_new' => 'fontawesome-database',
										              'icon_color' => '',
										            ),
										            1 => 
										            array (
										              'text' => '10 Domain Names',
										              'hover' => '',
										              'icon_new' => 'fontawesome-globe',
										              'icon_color' => '',
										            ),
										            2 => 
										            array (
										              'text' => '10 FTP Users',
										              'hover' => '',
										              'icon_new' => 'fontawesome-user',
										              'icon_color' => '',
										            ),
										            3 => 
										            array (
										              'text' => '50000 GB Bandwidth',
										              'hover' => '',
										              'icon_new' => 'fontawesome-exchange',
										              'icon_color' => '',
										            ),
										          ),
										        ),
										      ),
										      'theme' => 'flat',
										      'header_color' => '#5e5e5e',
										      'featured_header_color' => '#bb9f7c',
										      'button_color' => '#bb9f7c',
										      'featured_button_color' => '#bb9f7c',
										      'button_new_window' => false,
										      'panels_info' => 
										      array (
										        'class' => 'SiteOrigin_Widget_PriceTable_Widget',
										        'raw' => false,
										        'grid' => 1,
										        'cell' => 0,
										        'id' => 1,
										        'style' => 
										        array (
										          'background_display' => 'tile',
										        ),
										      ),
										    ),
										  ),
										  'grids' => 
										  array (
										    0 => 
										    array (
										      'cells' => 3,
										      'style' => 
										      array (
										        'equal_column_height' => 'no',
										        'padding_top' => '70px',
										        'padding_bottom' => '0px',
										        'background_image_position' => 'left top',
										        'background_image_style' => 'cover',
										      ),
										    ),
										    1 => 
										    array (
										      'cells' => 1,
										      'style' => 
										      array (
										        'equal_column_height' => 'no',
										        'padding_top' => '20px',
										        'padding_bottom' => '60px',
										        'background_image_position' => 'left top',
										        'background_image_style' => 'cover',
										      ),
										    ),
										  ),
										  'grid_cells' => 
										  array (
										    0 => 
										    array (
										      'grid' => 0,
										      'weight' => 0.14912461852642000526003585036960430443286895751953125,
										    ),
										    1 => 
										    array (
										      'grid' => 0,
										      'weight' => 0.69952473554990002302389484611921943724155426025390625,
										    ),
										    2 => 
										    array (
										      'grid' => 0,
										      'weight' => 0.1513506459236799994716449191400897689163684844970703125,
										    ),
										    3 => 
										    array (
										      'grid' => 1,
										      'weight' => 1,
										    ),
										  ),
										);
										
										$layouts['testimonials'] = array(
											'name' => __('Testimonials', 'create'),
											'description' => __('Layout for demo Testimonials page.', 'create'),
											'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/testimonials.jpg',
									        'widgets' => 
											  array (
											    0 => 
											    array (
											      'type' => 'visual',
											      'title' => '',
											      'text' => '<h2 style="text-align: center;">TESTIMONIALS</h2><p style="text-align: center;"><span style="color: #82acb8;"><span style="font-size: 21px; line-height: 31.5px;">Read what our customers have to say about us.</span></span></p>',
											      'filter' => '1',
											      'panels_info' => 
											      array (
											        'class' => 'WP_Widget_Black_Studio_TinyMCE',
											        'grid' => 0,
											        'cell' => 0,
											        'id' => 0,
											        'style' => 
											        array (
											          'background_image_attachment' => false,
											          'background_display' => 'tile',
											          'font_color' => '#ffffff',
											        ),
											      ),
											    ),
											    1 => 
											    array (
											      'title' => '',
											      'count' => '9',
											      'layout' => 'grid',
											      'columns' => '3',
											      'alignment' => 'center',
											      'order' => 'rand',
											      'carousel-nav-color' => '',
											      'panels_info' => 
											      array (
											        'class' => 'TTrust_Testimonials',
											        'raw' => false,
											        'grid' => 1,
											        'cell' => 0,
											        'id' => 1,
											        'style' => 
											        array (
											          'background_display' => 'tile',
											        ),
											      ),
											    ),
											  ),
											  'grids' => 
											  array (
											    0 => 
											    array (
											      'cells' => 1,
											      'style' => 
											      array (
											        'bottom_margin' => '0px',
											        'row_stretch' => 'full',
											        'equal_column_height' => 'no',
											        'padding_top' => '250px',
											        'padding_bottom' => '250px',
											        'background_image' => 1098,
											        'background_image_position' => 'left top',
											        'background_image_style' => 'parallax',
											      ),
											    ),
											    1 => 
											    array (
											      'cells' => 1,
											      'style' => 
											      array (
											        'equal_column_height' => 'no',
											        'padding_top' => '60px',
											        'padding_bottom' => '60px',
											        'background_image_position' => 'left top',
											        'background_image_style' => 'cover',
											      ),
											    ),
											  ),
											  'grid_cells' => 
											  array (
											    0 => 
											    array (
											      'grid' => 0,
											      'weight' => 1,
											    ),
											    1 => 
											    array (
											      'grid' => 1,
											      'weight' => 1,
											    ),
											  ),
											);
											
											$layouts['home-masonry'] = array(
												'name' => __('Home: Masonry', 'create'),
												'description' => __('Layout for demo Home: Masonry page.', 'create'),
												'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/home_masonry.jpg',
												'widgets' => 
												  array (
												    0 => 
												    array (
												      'title' => '',
												      'text' => '<h2><span style="color: #000000;">Hi. I\'m Jason.</span></h2>
												I\'m a freelance designer, specializing in mobile UI design. Checkout my work below and feel free to get in touch if you want to work with me.

												<a class="button" style="background-color: #1e73be">Get In Touch</a>',
												      'text_selected_editor' => 'html',
												      'autop' => true,
												      '_sow_form_id' => '58c0270d1a692',
												      'panels_info' => 
												      array (
												        'class' => 'SiteOrigin_Widget_Editor_Widget',
												        'raw' => false,
												        'grid' => 0,
												        'cell' => 0,
												        'id' => 0,
												        'widget_id' => '94200889-34ad-4bd2-b252-11358ed95771',
												        'style' => 
												        array (
												          'animation_type' => 'fadeInLeft',
												          'animation_offset' => '10',
												          'animation_iteration' => '1',
												          'class' => 'v-center',
												          'padding' => '50px 70px 50px 70px',
												          'background' => '#f4f4f4',
												          'background_display' => 'tile',
												        ),
												      ),
												    ),
												    1 => 
												    array (
												      'min_height' => '500',
												      'panels_info' => 
												      array (
												        'class' => 'TTrust_Spacer',
												        'raw' => false,
												        'grid' => 0,
												        'cell' => 1,
												        'id' => 1,
												        'widget_id' => '5f8d1ad0-b464-4d50-bb67-0ff20e506cd7',
												        'style' => 
												        array (
												          'animation_type' => 'fadeInRight',
												          'animation_offset' => '10',
												          'animation_iteration' => '1',
												          'background_image_attachment' => 213,
												          'background_display' => 'cover',
												        ),
												      ),
												    ),
												    2 => 
												    array (
												      'title' => '',
												      'show_filter' => 'no',
												      'filter_alignment' => 'center',
												      'count' => '4',
												      'thumb_proportions' => 'square',
												      'layout' => 'masonry with gutter',
												      'columns' => '4',
												      'skills' => 
												      array (
												        'mobile' => 'mobile',
												      ),
												      'orderby' => 'date',
												      'order' => 'DESC',
												      'hover_effect' => 'effect-4',
												      'hover_color' => '#1e73be',
												      'hover_text_color' => '',
												      'show_skills' => 'no',
												      'show_load_more' => 'no',
												      'load_more_color' => '',
												      'load_more_text_color' => '',
												      'enable_lightbox' => 'no',
												      'panels_info' => 
												      array (
												        'class' => 'TTrust_Portfolio',
												        'grid' => 1,
												        'cell' => 0,
												        'id' => 2,
												        'widget_id' => '682e7f18-a9b3-4b1f-9f75-30291352fe6f',
												        'style' => 
												        array (
												          'animation_type' => 'fadeIn',
												          'animation_delay' => '1s',
												          'animation_offset' => '10',
												          'animation_iteration' => '1',
												          'background_image_attachment' => false,
												          'background_display' => 'tile',
												        ),
												      ),
												    ),
												    3 => 
												    array (
												      'title' => '',
												      'networks' => 
												      array (
												        0 => 
												        array (
												          'name' => 'twitter',
												          'url' => 'https://twitter.com/',
												          'icon_title' => '',
												          'icon_color' => '#ffffff',
												          'button_color' => '#ffffff',
												        ),
												        1 => 
												        array (
												          'name' => 'facebook',
												          'url' => 'https://www.facebook.com/',
												          'icon_title' => '',
												          'icon_color' => '#ffffff',
												          'button_color' => '#ffffff',
												        ),
												        2 => 
												        array (
												          'name' => 'dribbble',
												          'url' => 'https://dribbble.com/',
												          'icon_title' => '',
												          'icon_color' => '#ffffff',
												          'button_color' => '#ffffff',
												        ),
												      ),
												      'design' => 
												      array (
												        'new_window' => true,
												        'theme' => 'wire',
												        'icon_size' => '2',
												        'rounding' => '1.5',
												        'padding' => '0.5',
												        'align' => 'center',
												        'margin' => '0.4',
												        'so_field_container_state' => 'open',
												        'hover' => false,
												      ),
												      '_sow_form_id' => '58c04eb43f7d8',
												      'panels_info' => 
												      array (
												        'class' => 'SiteOrigin_Widget_SocialMediaButtons_Widget',
												        'raw' => false,
												        'grid' => 2,
												        'cell' => 0,
												        'id' => 3,
												        'widget_id' => 'd64c305b-285e-4354-876a-cc71ecfb6492',
												        'style' => 
												        array (
												          'animation_type' => 'fadeIn',
												          'animation_delay' => '1s',
												          'animation_offset' => '10',
												          'animation_iteration' => '1',
												          'class' => 'v-center',
												          'padding' => '80px 0px 80px 0px',
												          'background' => '#1e73be',
												          'background_image_attachment' => 223,
												          'background_display' => 'cover',
												        ),
												      ),
												    ),
												  ),
												  'grids' => 
												  array (
												    0 => 
												    array (
												      'cells' => 2,
												      'style' => 
												      array (
												        'bottom_margin' => '10px',
												        'gutter' => '20px',
												        'mobile_padding' => '0px 0px 0px 0px',
												        'equal_column_height' => 'yes',
												        'padding_top' => '40px',
												        'padding_bottom' => '0px',
												        'padding_left' => '11px',
												        'padding_right' => '12px',
												        'background_image_position' => 'center top',
												        'background_image_style' => 'parallax',
												        'use_background_video' => '',
												        'video_overlay' => 'none',
												        'overlay_pattern' => 'dots',
												        'fade_in' => true,
												        'pause_after' => '120',
												        'pause_play_button' => true,
												        'pauseplay_xpos' => 'right',
												        'pauseplay_ypos' => 'top',
												      ),
												    ),
												    1 => 
												    array (
												      'cells' => 1,
												      'style' => 
												      array (
												        'bottom_margin' => '10px',
												        'equal_column_height' => 'no',
												        'background_image_position' => 'center top',
												        'background_image_style' => 'cover',
												        'use_background_video' => '',
												        'video_overlay' => 'none',
												        'overlay_pattern' => 'dots',
												        'fade_in' => true,
												        'pause_after' => '120',
												        'pause_play_button' => true,
												        'pauseplay_xpos' => 'right',
												        'pauseplay_ypos' => 'top',
												      ),
												    ),
												    2 => 
												    array (
												      'cells' => 1,
												      'style' => 
												      array (
												        'gutter' => '20px',
												        'equal_column_height' => 'yes',
												        'padding_left' => '10px',
												        'padding_right' => '10px',
												        'background_image_position' => 'center top',
												        'background_image_style' => 'cover',
												        'use_background_video' => '',
												        'video_overlay' => 'none',
												        'overlay_pattern' => 'dots',
												        'fade_in' => true,
												        'pause_after' => '120',
												        'pause_play_button' => true,
												        'pauseplay_xpos' => 'right',
												        'pauseplay_ypos' => 'top',
												      ),
												    ),
												  ),
												  'grid_cells' => 
												  array (
												    0 => 
												    array (
												      'grid' => 0,
												      'weight' => 0.5,
												    ),
												    1 => 
												    array (
												      'grid' => 0,
												      'weight' => 0.5,
												    ),
												    2 => 
												    array (
												      'grid' => 1,
												      'weight' => 1,
												    ),
												    3 => 
												    array (
												      'grid' => 2,
												      'weight' => 1,
												    ),
												  ),
												
												$layouts['home-modern'] = array(
													'name' => __('Home: Modern Agency', 'create'),
													'description' => __('Layout for demo Home: Modern Agency page.', 'create'),
													'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/home_modern.jpg',
													'widgets' => 
													  array (
													    0 => 
													    array (
													      'headline' => 
													      array (
													        'text' => 'We Make Amazing Interfaces',
													        'destination_url' => '',
													        'tag' => 'h1',
													        'color' => '#ffffff',
													        'hover_color' => false,
													        'font' => 'Raleway:300',
													        'font_size' => '60px',
													        'font_size_unit' => 'px',
													        'align' => 'center',
													        'line_height' => '1.1em',
													        'line_height_unit' => 'em',
													        'margin' => false,
													        'margin_unit' => 'px',
													        'so_field_container_state' => 'open',
													        'new_window' => false,
													      ),
													      'sub_headline' => 
													      array (
													        'text' => '',
													        'destination_url' => '',
													        'tag' => 'h3',
													        'color' => false,
													        'hover_color' => false,
													        'font' => 'default',
													        'font_size' => false,
													        'font_size_unit' => 'px',
													        'align' => 'center',
													        'line_height' => false,
													        'line_height_unit' => 'px',
													        'margin' => false,
													        'margin_unit' => 'px',
													        'so_field_container_state' => 'closed',
													        'new_window' => false,
													      ),
													      'divider' => 
													      array (
													        'style' => 'none',
													        'color' => '#EEEEEE',
													        'thickness' => 1,
													        'align' => 'center',
													        'width' => '80%',
													        'width_unit' => '%',
													        'margin' => false,
													        'margin_unit' => 'px',
													        'so_field_container_state' => 'open',
													      ),
													      'order' => 
													      array (
													        0 => 'headline',
													        1 => 'divider',
													        2 => 'sub_headline',
													      ),
													      'fittext' => true,
													      '_sow_form_id' => '58bd93e161d18',
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Headline_Widget',
													        'raw' => false,
													        'grid' => 0,
													        'cell' => 1,
													        'id' => 0,
													        'widget_id' => 'b3472c86-974e-427a-83ab-33d5697d2881',
													        'style' => 
													        array (
													          'animation_type' => 'fadeInUp',
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'padding' => '0px 0px 20px 0px',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    1 => 
													    array (
													      'text' => 'Learn More',
													      'url' => '',
													      'button_icon' => 
													      array (
													        'icon_selected' => '',
													        'icon_color' => false,
													        'icon' => 0,
													        'so_field_container_state' => 'open',
													      ),
													      'design' => 
													      array (
													        'width' => false,
													        'width_unit' => 'px',
													        'align' => 'center',
													        'theme' => 'flat',
													        'button_color' => '#0069d3',
													        'text_color' => '#ffffff',
													        'hover' => true,
													        'font' => 'default',
													        'font_size' => '1',
													        'rounding' => '1.5',
													        'padding' => '1',
													        'so_field_container_state' => 'open',
													      ),
													      'attributes' => 
													      array (
													        'id' => '',
													        'classes' => '',
													        'title' => '',
													        'onclick' => '',
													        'so_field_container_state' => 'closed',
													      ),
													      '_sow_form_id' => '58bd946c025cd',
													      'new_window' => false,
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Button_Widget',
													        'raw' => false,
													        'grid' => 0,
													        'cell' => 1,
													        'id' => 1,
													        'widget_id' => 'c767824a-4208-4a41-b68d-8729225840a2',
													        'style' => 
													        array (
													          'animation_type' => 'fadeIn',
													          'animation_delay' => '1s',
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    2 => 
													    array (
													      'title' => '',
													      'text' => '<h2 class="p1"><span style="color: #333333;">Specializing in Mobile Design</span></h2><p class="p1"><span class="s1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis euismod nisi, sit amet lobortis elit interdum sit amet. Ut facilisis turpis et urna pharetra, id aliquam felis rutrum. In a mi quam. Nunc sollicitudin nisl ac ex pretium, quis consequat ex volutpat. </span></p>',
													      'text_selected_editor' => 'tinymce',
													      'autop' => true,
													      '_sow_form_id' => '58bdc925b8808',
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Editor_Widget',
													        'raw' => false,
													        'grid' => 1,
													        'cell' => 0,
													        'id' => 2,
													        'widget_id' => 'a8d473f3-4d78-485b-8f2a-b384aa4b155a',
													        'style' => 
													        array (
													          'animation_type' => 'fadeInLeft',
													          'animation_delay' => '1s',
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'class' => 'v-center',
													          'padding' => '0px 30px 0px 0px',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    3 => 
													    array (
													      'title' => '',
													      'text' => '<p><img class="alignright size-large wp-image-173" src="http://demos.themetrust.com/create-2/wp-content/uploads/sites/28/2017/03/iPhone_6_plus_perspective-Gold-3-4-1024x905.jpg" alt="" width="1024" height="905" /></p>',
													      'text_selected_editor' => 'tinymce',
													      '_sow_form_id' => '58bdc1f93ef09',
													      'autop' => false,
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Editor_Widget',
													        'raw' => false,
													        'grid' => 1,
													        'cell' => 1,
													        'id' => 3,
													        'widget_id' => '9e5b65cd-464f-43ef-9a98-cc2b0bd828ee',
													        'style' => 
													        array (
													          'animation_type' => 'fadeInRight',
													          'animation_delay' => '1s',
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'padding' => '0px 0px 0px 0px',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    4 => 
													    array (
													      'features' => 
													      array (
													        0 => 
													        array (
													          'container_color' => false,
													          'icon' => 'typicons-device-tablet',
													          'icon_title' => '',
													          'icon_color' => '#1e73be',
													          'icon_image' => 0,
													          'icon_image_size' => 'full',
													          'title' => 'iPhone',
													          'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam auctor erat non diam dapibus.',
													          'more_text' => '',
													          'more_url' => '',
													        ),
													        1 => 
													        array (
													          'container_color' => false,
													          'icon' => 'typicons-vendor-apple',
													          'icon_title' => '',
													          'icon_color' => '#1e73be',
													          'icon_image' => 0,
													          'icon_image_size' => 'full',
													          'title' => 'Apple Watch',
													          'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam auctor erat non diam dapibus.',
													          'more_text' => '',
													          'more_url' => '',
													        ),
													      ),
													      'fonts' => 
													      array (
													        'title_options' => 
													        array (
													          'font' => 'default',
													          'size' => false,
													          'size_unit' => 'px',
													          'color' => false,
													          'so_field_container_state' => 'closed',
													        ),
													        'text_options' => 
													        array (
													          'font' => 'default',
													          'size' => false,
													          'size_unit' => 'px',
													          'color' => false,
													          'so_field_container_state' => 'closed',
													        ),
													        'more_text_options' => 
													        array (
													          'font' => 'default',
													          'size' => false,
													          'size_unit' => 'px',
													          'color' => false,
													          'so_field_container_state' => 'closed',
													        ),
													        'so_field_container_state' => 'closed',
													      ),
													      'container_shape' => 'round',
													      'container_size' => '24px',
													      'container_size_unit' => 'px',
													      'icon_size' => '24px',
													      'icon_size_unit' => 'px',
													      'per_row' => 2,
													      'responsive' => true,
													      '_sow_form_id' => '58bdd24bacafa',
													      'title_link' => false,
													      'icon_link' => false,
													      'new_window' => false,
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Features_Widget',
													        'raw' => false,
													        'grid' => 2,
													        'cell' => 0,
													        'id' => 4,
													        'widget_id' => 'd5686058-1693-4ae2-8eec-2fac86080091',
													        'style' => 
													        array (
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'class' => 'left',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    5 => 
													    array (
													      'features' => 
													      array (
													        0 => 
													        array (
													          'container_color' => false,
													          'icon' => 'typicons-brush',
													          'icon_title' => '',
													          'icon_color' => '#1e73be',
													          'icon_image' => 0,
													          'icon_image_size' => 'full',
													          'title' => 'Design',
													          'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam auctor erat non diam dapibus.',
													          'more_text' => '',
													          'more_url' => '',
													        ),
													        1 => 
													        array (
													          'container_color' => false,
													          'icon' => 'typicons-device-laptop',
													          'icon_title' => '',
													          'icon_color' => '#1e73be',
													          'icon_image' => 0,
													          'icon_image_size' => 'full',
													          'title' => 'Coding',
													          'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam auctor erat non diam dapibus.',
													          'more_text' => '',
													          'more_url' => '',
													        ),
													      ),
													      'fonts' => 
													      array (
													        'title_options' => 
													        array (
													          'font' => 'default',
													          'size' => false,
													          'size_unit' => 'px',
													          'color' => false,
													          'so_field_container_state' => 'closed',
													        ),
													        'text_options' => 
													        array (
													          'font' => 'default',
													          'size' => false,
													          'size_unit' => 'px',
													          'color' => false,
													          'so_field_container_state' => 'closed',
													        ),
													        'more_text_options' => 
													        array (
													          'font' => 'default',
													          'size' => false,
													          'size_unit' => 'px',
													          'color' => false,
													          'so_field_container_state' => 'closed',
													        ),
													        'so_field_container_state' => 'closed',
													      ),
													      'container_shape' => 'round',
													      'container_size' => '24px',
													      'container_size_unit' => 'px',
													      'icon_size' => '24px',
													      'icon_size_unit' => 'px',
													      'per_row' => 2,
													      'responsive' => true,
													      '_sow_form_id' => '58bee5449d2d9',
													      'title_link' => false,
													      'icon_link' => false,
													      'new_window' => false,
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Features_Widget',
													        'raw' => false,
													        'grid' => 2,
													        'cell' => 0,
													        'id' => 5,
													        'widget_id' => 'd5686058-1693-4ae2-8eec-2fac86080091',
													        'style' => 
													        array (
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'class' => 'left',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    6 => 
													    array (
													      'headline' => 
													      array (
													        'text' => 'Design Matters',
													        'destination_url' => '',
													        'tag' => 'h2',
													        'color' => '#4c4c4c',
													        'hover_color' => false,
													        'font' => 'Raleway:700',
													        'font_size' => false,
													        'font_size_unit' => 'px',
													        'align' => 'left',
													        'line_height' => false,
													        'line_height_unit' => 'px',
													        'margin' => '0px',
													        'margin_unit' => 'px',
													        'so_field_container_state' => 'open',
													        'new_window' => false,
													      ),
													      'sub_headline' => 
													      array (
													        'text' => '',
													        'destination_url' => '',
													        'tag' => 'h3',
													        'color' => false,
													        'hover_color' => false,
													        'font' => 'default',
													        'font_size' => false,
													        'font_size_unit' => 'px',
													        'align' => 'center',
													        'line_height' => false,
													        'line_height_unit' => 'px',
													        'margin' => false,
													        'margin_unit' => 'px',
													        'so_field_container_state' => 'closed',
													        'new_window' => false,
													      ),
													      'divider' => 
													      array (
													        'style' => 'solid',
													        'color' => '#EEEEEE',
													        'thickness' => 1,
													        'align' => 'center',
													        'width' => '80%',
													        'width_unit' => '%',
													        'margin' => false,
													        'margin_unit' => 'px',
													        'so_field_container_state' => 'closed',
													      ),
													      'order' => 
													      array (
													        0 => 'headline',
													        1 => 'divider',
													        2 => 'sub_headline',
													      ),
													      '_sow_form_id' => '58bdd0d11c199',
													      'fittext' => false,
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Headline_Widget',
													        'raw' => false,
													        'grid' => 2,
													        'cell' => 1,
													        'id' => 6,
													        'widget_id' => 'f85c15f9-a690-4a3d-b9b1-cc90afff9b2e',
													        'style' => 
													        array (
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'padding' => '0px 0px 0px 0px',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    7 => 
													    array (
													      'title' => '',
													      'text' => '<p class="p1"><span class="s1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis euismod nisi, sit amet lobortis elit interdum sit amet. Ut facilisis turpis et urna pharetra, id aliquam felis rutrum. In a mi quam. Nunc sollicitudin nisl ac ex pretium, quis consequat ex volutpat. Curabitur rutrum ligula viverra ligula dignissim feugiat. Duis a quam tortor.</span></p>',
													      'text_selected_editor' => 'tinymce',
													      'autop' => true,
													      '_sow_form_id' => '58bdd0d4d4c45',
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Editor_Widget',
													        'raw' => false,
													        'grid' => 2,
													        'cell' => 1,
													        'id' => 7,
													        'widget_id' => 'a8d473f3-4d78-485b-8f2a-b384aa4b155a',
													        'style' => 
													        array (
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'padding' => '0px 30px 0px 0px',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    8 => 
													    array (
													      'text' => 'Learn More',
													      'url' => '',
													      'button_icon' => 
													      array (
													        'icon_selected' => '',
													        'icon_color' => false,
													        'icon' => 0,
													        'so_field_container_state' => 'open',
													      ),
													      'design' => 
													      array (
													        'width' => false,
													        'width_unit' => 'px',
													        'align' => 'left',
													        'theme' => 'wire',
													        'button_color' => '#353535',
													        'text_color' => '#ffffff',
													        'hover' => true,
													        'font' => 'default',
													        'font_size' => '1',
													        'rounding' => '1.5',
													        'padding' => '1',
													        'so_field_container_state' => 'open',
													      ),
													      'attributes' => 
													      array (
													        'id' => '',
													        'classes' => '',
													        'title' => '',
													        'onclick' => '',
													        'so_field_container_state' => 'closed',
													      ),
													      'new_window' => false,
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Button_Widget',
													        'raw' => false,
													        'grid' => 2,
													        'cell' => 1,
													        'id' => 8,
													        'widget_id' => '976ca30f-cdbf-4d51-96bc-1388a86cbfd6',
													        'style' => 
													        array (
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'mobile_padding' => '0px 0px 30px 0px',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    9 => 
													    array (
													      'title' => '',
													      'show_filter' => 'no',
													      'filter_alignment' => 'center',
													      'count' => '3',
													      'thumb_proportions' => 'square',
													      'layout' => 'rows with gutter',
													      'columns' => '3',
													      'skills' => 
													      array (
													        'mobile' => 'mobile',
													      ),
													      'orderby' => 'date',
													      'order' => 'DESC',
													      'hover_effect' => 'effect-1',
													      'hover_color' => '#1e73be',
													      'hover_text_color' => '',
													      'show_skills' => 'no',
													      'show_load_more' => 'no',
													      'load_more_color' => '',
													      'load_more_text_color' => '',
													      'enable_lightbox' => 'no',
													      'panels_info' => 
													      array (
													        'class' => 'TTrust_Portfolio',
													        'raw' => false,
													        'grid' => 3,
													        'cell' => 0,
													        'id' => 9,
													        'widget_id' => '116650f3-dae2-4465-9a2f-80711263c1e2',
													        'style' => 
													        array (
													          'animation_type' => 'fadeIn',
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    10 => 
													    array (
													      'headline' => 
													      array (
													        'text' => 'Or Process',
													        'destination_url' => '',
													        'tag' => 'h2',
													        'color' => '#4c4c4c',
													        'hover_color' => false,
													        'font' => 'Raleway:700',
													        'font_size' => false,
													        'font_size_unit' => 'px',
													        'align' => 'left',
													        'line_height' => false,
													        'line_height_unit' => 'px',
													        'margin' => '0px',
													        'margin_unit' => 'px',
													        'so_field_container_state' => 'open',
													        'new_window' => false,
													      ),
													      'sub_headline' => 
													      array (
													        'text' => '',
													        'destination_url' => '',
													        'tag' => 'h3',
													        'color' => false,
													        'hover_color' => false,
													        'font' => 'default',
													        'font_size' => false,
													        'font_size_unit' => 'px',
													        'align' => 'center',
													        'line_height' => false,
													        'line_height_unit' => 'px',
													        'margin' => false,
													        'margin_unit' => 'px',
													        'so_field_container_state' => 'closed',
													        'new_window' => false,
													      ),
													      'divider' => 
													      array (
													        'style' => 'solid',
													        'color' => '#EEEEEE',
													        'thickness' => 1,
													        'align' => 'center',
													        'width' => '80%',
													        'width_unit' => '%',
													        'margin' => false,
													        'margin_unit' => 'px',
													        'so_field_container_state' => 'closed',
													      ),
													      'order' => 
													      array (
													        0 => 'headline',
													        1 => 'divider',
													        2 => 'sub_headline',
													      ),
													      '_sow_form_id' => '58c82d7704f15',
													      'fittext' => false,
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Headline_Widget',
													        'raw' => false,
													        'grid' => 4,
													        'cell' => 0,
													        'id' => 10,
													        'widget_id' => 'f85c15f9-a690-4a3d-b9b1-cc90afff9b2e',
													        'style' => 
													        array (
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'padding' => '0px 0px 0px 0px',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    11 => 
													    array (
													      'title' => '',
													      'text' => '<p class="p1"><span class="s1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis euismod nisi, sit amet lobortis elit interdum sit amet. Ut facilisis turpis et urna pharetra, id aliquam felis rutrum. In a mi quam. Nunc sollicitudin nisl ac ex pretium, quis consequat ex volutpat. Curabitur rutrum ligula viverra ligula dignissim feugiat. Duis a quam tortor.</span></p>',
													      'text_selected_editor' => 'tinymce',
													      'autop' => true,
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Editor_Widget',
													        'raw' => false,
													        'grid' => 4,
													        'cell' => 0,
													        'id' => 11,
													        'widget_id' => 'a8d473f3-4d78-485b-8f2a-b384aa4b155a',
													        'style' => 
													        array (
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'padding' => '0px 30px 0px 0px',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    12 => 
													    array (
													      'text' => 'Learn More',
													      'url' => '',
													      'button_icon' => 
													      array (
													        'icon_selected' => '',
													        'icon_color' => false,
													        'icon' => 0,
													        'so_field_container_state' => 'open',
													      ),
													      'design' => 
													      array (
													        'width' => false,
													        'width_unit' => 'px',
													        'align' => 'left',
													        'theme' => 'wire',
													        'button_color' => '#353535',
													        'text_color' => '#ffffff',
													        'hover' => true,
													        'font' => 'default',
													        'font_size' => '1',
													        'rounding' => '1.5',
													        'padding' => '1',
													        'so_field_container_state' => 'open',
													      ),
													      'attributes' => 
													      array (
													        'id' => '',
													        'classes' => '',
													        'title' => '',
													        'onclick' => '',
													        'so_field_container_state' => 'closed',
													      ),
													      'new_window' => false,
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Button_Widget',
													        'raw' => false,
													        'grid' => 4,
													        'cell' => 0,
													        'id' => 12,
													        'widget_id' => '976ca30f-cdbf-4d51-96bc-1388a86cbfd6',
													        'style' => 
													        array (
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'mobile_padding' => '0px 0px 30px 0px',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    13 => 
													    array (
													      'title' => '',
													      'progress-bars' => 
													      array (
													        0 => 
													        array (
													          'title' => 'Design',
													          'value' => '90',
													          'color' => '#1e73be',
													        ),
													        1 => 
													        array (
													          'title' => 'Development',
													          'value' => '75',
													          'color' => '#1e73be',
													        ),
													        2 => 
													        array (
													          'title' => 'Ideation',
													          'value' => '95',
													          'color' => '#1e73be',
													        ),
													      ),
													      '_sow_form_id' => '58c82d1403314',
													      'panels_info' => 
													      array (
													        'class' => 'Create_Progress_Bars_Widget',
													        'raw' => false,
													        'grid' => 4,
													        'cell' => 1,
													        'id' => 13,
													        'widget_id' => 'a68ae2aa-c492-4336-9885-11bdcc8a0b25',
													        'style' => 
													        array (
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'padding' => '20px 20px 20px 20px',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    14 => 
													    array (
													      'headline' => 
													      array (
													        'text' => 'Want to Work with Us?',
													        'destination_url' => '',
													        'tag' => 'h2',
													        'color' => '#ffffff',
													        'hover_color' => false,
													        'font' => 'Raleway:300',
													        'font_size' => '45px',
													        'font_size_unit' => 'px',
													        'align' => 'center',
													        'line_height' => '1.1em',
													        'line_height_unit' => 'em',
													        'margin' => false,
													        'margin_unit' => 'px',
													        'so_field_container_state' => 'open',
													        'new_window' => false,
													      ),
													      'sub_headline' => 
													      array (
													        'text' => '',
													        'destination_url' => '',
													        'tag' => 'h3',
													        'color' => false,
													        'hover_color' => false,
													        'font' => 'default',
													        'font_size' => false,
													        'font_size_unit' => 'px',
													        'align' => 'center',
													        'line_height' => false,
													        'line_height_unit' => 'px',
													        'margin' => false,
													        'margin_unit' => 'px',
													        'so_field_container_state' => 'closed',
													        'new_window' => false,
													      ),
													      'divider' => 
													      array (
													        'style' => 'none',
													        'color' => '#EEEEEE',
													        'thickness' => 1,
													        'align' => 'center',
													        'width' => '80%',
													        'width_unit' => '%',
													        'margin' => false,
													        'margin_unit' => 'px',
													        'so_field_container_state' => 'open',
													      ),
													      'order' => 
													      array (
													        0 => 'headline',
													        1 => 'divider',
													        2 => 'sub_headline',
													      ),
													      'fittext' => true,
													      '_sow_form_id' => '58c00814c7df0',
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Headline_Widget',
													        'raw' => false,
													        'grid' => 5,
													        'cell' => 1,
													        'id' => 14,
													        'widget_id' => 'b3472c86-974e-427a-83ab-33d5697d2881',
													        'style' => 
													        array (
													          'animation_type' => 'fadeInUp',
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'padding' => '0px 0px 20px 0px',
													          'background_display' => 'tile',
													        ),
													      ),
													    ),
													    15 => 
													    array (
													      'text' => 'Get in Touch',
													      'url' => '',
													      'button_icon' => 
													      array (
													        'icon_selected' => '',
													        'icon_color' => false,
													        'icon' => 0,
													        'so_field_container_state' => 'open',
													      ),
													      'design' => 
													      array (
													        'width' => false,
													        'width_unit' => 'px',
													        'align' => 'center',
													        'theme' => 'wire',
													        'button_color' => '#ffffff',
													        'text_color' => '#1e73be',
													        'hover' => true,
													        'font' => 'default',
													        'font_size' => '1',
													        'rounding' => '1.5',
													        'padding' => '1',
													        'so_field_container_state' => 'open',
													      ),
													      'attributes' => 
													      array (
													        'id' => '',
													        'classes' => '',
													        'title' => '',
													        'onclick' => '',
													        'so_field_container_state' => 'closed',
													      ),
													      '_sow_form_id' => '58c00818d8f25',
													      'panels_info' => 
													      array (
													        'class' => 'SiteOrigin_Widget_Button_Widget',
													        'grid' => 5,
													        'cell' => 1,
													        'id' => 15,
													        'widget_id' => 'c767824a-4208-4a41-b68d-8729225840a2',
													        'style' => 
													        array (
													          'animation_type' => 'fadeIn',
													          'animation_offset' => '10',
													          'animation_iteration' => '1',
													          'background_image_attachment' => false,
													          'background_display' => 'tile',
													        ),
													      ),
													      'new_window' => false,
													    ),
													  ),
													  'grids' => 
													  array (
													    0 => 
													    array (
													      'cells' => 3,
													      'style' => 
													      array (
													        'bottom_margin' => '0px',
													        'padding' => '200px 0px 200px 0px',
													        'mobile_padding' => '150px 0px 100px 0px',
													        'row_stretch' => 'full',
													        'equal_column_height' => 'no',
													        'background_image_position' => 'center top',
													        'background_image_style' => 'cover',
													        'border_bottom' => '0px',
													        'use_background_video' => true,
													        'mp4_url' => 'https://s3.amazonaws.com/theme-trust/create/videos/Mock-up.mp4',
													        'webm_url' => 'http://demos.themetrust.com/create-2/wp-content/uploads/sites/28/2017/03/sketch-video-still-1.jpg',
													        'poster_image' => 'http://demos.themetrust.com/create-2/wp-content/uploads/sites/28/2017/03/sketch-video-still-1.jpg',
													        'video_overlay' => 'solid',
													        'overlay_opacity' => '60',
													        'overlay_color' => '#000000',
													        'overlay_pattern' => 'dots',
													        'fade_in' => true,
													        'pause_after' => '0',
													        'pause_play_button' => '',
													        'pauseplay_xpos' => 'right',
													        'pauseplay_ypos' => 'top',
													      ),
													    ),
													    1 => 
													    array (
													      'cells' => 2,
													      'style' => 
													      array (
													        'row_stretch' => 'full',
													        'background' => '#f5f5f5',
													        'equal_column_height' => 'yes',
													        'padding_top' => '70px',
													        'padding_bottom' => '70px',
													        'background_image_position' => 'right bottom',
													        'background_image_style' => 'no-repeat',
													        'use_background_video' => '',
													        'video_overlay' => 'none',
													        'overlay_pattern' => 'dots',
													        'fade_in' => true,
													        'pause_after' => '120',
													        'pause_play_button' => true,
													        'pauseplay_xpos' => 'right',
													        'pauseplay_ypos' => 'top',
													      ),
													    ),
													    2 => 
													    array (
													      'cells' => 2,
													      'style' => 
													      array (
													        'equal_column_height' => 'no',
													        'padding_top' => '50px',
													        'padding_bottom' => '50px',
													        'padding_left' => '30px',
													        'padding_right' => '30px',
													        'background_image_position' => 'center top',
													        'background_image_style' => 'cover',
													        'use_background_video' => '',
													        'video_overlay' => 'none',
													        'overlay_pattern' => 'dots',
													        'fade_in' => true,
													        'pause_after' => '120',
													        'pause_play_button' => true,
													        'pauseplay_xpos' => 'right',
													        'pauseplay_ypos' => 'top',
													      ),
													    ),
													    3 => 
													    array (
													      'cells' => 1,
													      'style' => 
													      array (
													        'equal_column_height' => 'no',
													        'padding_bottom' => '30px',
													        'background_image_position' => 'center top',
													        'background_image_style' => 'cover',
													        'use_background_video' => '',
													        'video_overlay' => 'none',
													        'overlay_pattern' => 'dots',
													        'fade_in' => true,
													        'pause_after' => '120',
													        'pause_play_button' => true,
													        'pauseplay_xpos' => 'right',
													        'pauseplay_ypos' => 'top',
													      ),
													    ),
													    4 => 
													    array (
													      'cells' => 2,
													      'style' => 
													      array (
													        'equal_column_height' => 'no',
													        'padding_top' => '0px',
													        'padding_bottom' => '50px',
													        'padding_left' => '30px',
													        'padding_right' => '30px',
													        'background_image_position' => 'center top',
													        'background_image_style' => 'cover',
													        'use_background_video' => '',
													        'video_overlay' => 'none',
													        'overlay_pattern' => 'dots',
													        'fade_in' => true,
													        'pause_after' => '120',
													        'pause_play_button' => true,
													        'pauseplay_xpos' => 'right',
													        'pauseplay_ypos' => 'top',
													      ),
													    ),
													    5 => 
													    array (
													      'cells' => 3,
													      'style' => 
													      array (
													        'row_stretch' => 'full',
													        'background' => '#1e73be',
													        'equal_column_height' => 'no',
													        'padding_top' => '12%',
													        'padding_bottom' => '12%',
													        'background_image_position' => 'center top',
													        'background_image_style' => 'cover',
													        'use_background_video' => '',
													        'video_overlay' => 'none',
													        'overlay_pattern' => 'dots',
													        'fade_in' => true,
													        'pause_after' => '120',
													        'pause_play_button' => true,
													        'pauseplay_xpos' => 'right',
													        'pauseplay_ypos' => 'top',
													      ),
													    ),
													  ),
													  'grid_cells' => 
													  array (
													    0 => 
													    array (
													      'grid' => 0,
													      'weight' => 0.20271535580524,
													    ),
													    1 => 
													    array (
													      'grid' => 0,
													      'weight' => 0.59035580524344999,
													    ),
													    2 => 
													    array (
													      'grid' => 0,
													      'weight' => 0.20692883895131001,
													    ),
													    3 => 
													    array (
													      'grid' => 1,
													      'weight' => 0.5,
													    ),
													    4 => 
													    array (
													      'grid' => 1,
													      'weight' => 0.5,
													    ),
													    5 => 
													    array (
													      'grid' => 2,
													      'weight' => 0.5,
													    ),
													    6 => 
													    array (
													      'grid' => 2,
													      'weight' => 0.5,
													    ),
													    7 => 
													    array (
													      'grid' => 3,
													      'weight' => 1,
													    ),
													    8 => 
													    array (
													      'grid' => 4,
													      'weight' => 0.5,
													    ),
													    9 => 
													    array (
													      'grid' => 4,
													      'weight' => 0.5,
													    ),
													    10 => 
													    array (
													      'grid' => 5,
													      'weight' => 0.19994407158836999,
													    ),
													    11 => 
													    array (
													      'grid' => 5,
													      'weight' => 0.60011185682325996,
													    ),
													    12 => 
													    array (
													      'grid' => 5,
													      'weight' => 0.19994407158836999,
													    ),
													  ),
													),
													
													$layouts['home-startup'] = array(
														'name' => __('Home: Startup', 'create'),
														'description' => __('Layout for demo Home: Startup.', 'create'),
														'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/home_startup.jpg',
														'widgets' => 
														  array (
														    0 => 
														    array (
														      'headline' => 
														      array (
														        'text' => 'We Design. We Create. We Innovate.',
														        'tag' => 'h2',
														        'color' => '#ffffff',
														        'font' => 'Raleway:500',
														        'font_size' => false,
														        'font_size_unit' => 'px',
														        'align' => 'left',
														        'line_height' => false,
														        'line_height_unit' => 'px',
														        'margin' => false,
														        'margin_unit' => 'px',
														        'so_field_container_state' => 'open',
														      ),
														      'sub_headline' => 
														      array (
														        'text' => 'DOING WHAT WE LOVE',
														        'tag' => 'p',
														        'color' => '#ffffff',
														        'font' => 'default',
														        'font_size' => false,
														        'font_size_unit' => 'px',
														        'align' => 'left',
														        'line_height' => false,
														        'line_height_unit' => 'px',
														        'margin' => '5px',
														        'margin_unit' => 'px',
														        'so_field_container_state' => 'open',
														      ),
														      'divider' => 
														      array (
														        'style' => 'none',
														        'color' => '#EEEEEE',
														        'thickness' => 1,
														        'align' => 'center',
														        'width' => '80%',
														        'width_unit' => '%',
														        'margin' => false,
														        'margin_unit' => 'px',
														        'so_field_container_state' => 'closed',
														      ),
														      'order' => 
														      array (
														        0 => 'sub_headline',
														        1 => 'headline',
														        2 => 'divider',
														      ),
														      '_sow_form_id' => '58b6d4040c289',
														      'fittext' => false,
														      'panels_info' => 
														      array (
														        'class' => 'SiteOrigin_Widget_Headline_Widget',
														        'raw' => false,
														        'grid' => 0,
														        'cell' => 0,
														        'id' => 0,
														        'widget_id' => '1536f06f-6cf0-45b9-af21-5d70187b6b77',
														        'style' => 
														        array (
														          'animation_type' => 'fadeInUp',
														          'animation_offset' => '10',
														          'animation_iteration' => '1',
														          'padding' => '0px 0px 15px 0px',
														          'background_display' => 'tile',
														        ),
														      ),
														    ),
														    1 => 
														    array (
														      'text' => 'Learn More',
														      'url' => '',
														      'button_icon' => 
														      array (
														        'icon_selected' => '',
														        'icon_color' => false,
														        'icon' => 0,
														        'so_field_container_state' => 'open',
														      ),
														      'design' => 
														      array (
														        'width' => false,
														        'width_unit' => 'px',
														        'align' => 'left',
														        'theme' => 'flat',
														        'button_color' => '#54b2c9',
														        'text_color' => '#ffffff',
														        'hover' => true,
														        'font' => 'default',
														        'font_size' => '1',
														        'rounding' => '1.5',
														        'padding' => '1',
														        'so_field_container_state' => 'open',
														      ),
														      'attributes' => 
														      array (
														        'id' => '',
														        'classes' => '',
														        'title' => '',
														        'onclick' => '',
														        'so_field_container_state' => 'closed',
														      ),
														      '_sow_form_id' => '58b5db26b5e4a',
														      'new_window' => false,
														      'panels_info' => 
														      array (
														        'class' => 'SiteOrigin_Widget_Button_Widget',
														        'raw' => false,
														        'grid' => 0,
														        'cell' => 0,
														        'id' => 1,
														        'widget_id' => '5596e5b9-7cb6-4d53-a6ff-3b782136759c',
														        'style' => 
														        array (
														          'animation_type' => 'fadeInUp',
														          'animation_delay' => '1s',
														          'animation_offset' => '10',
														          'animation_iteration' => '1',
														          'background_display' => 'tile',
														        ),
														      ),
														    ),
														    2 => 
														    array (
														      'features' => 
														      array (
														        0 => 
														        array (
														          'container_color' => false,
														          'icon' => 'ionicons-android-bulb',
														          'icon_title' => '',
														          'icon_color' => '#545454',
														          'icon_image' => 0,
														          'icon_image_size' => 'full',
														          'title' => 'Innovation',
														          'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam auctor erat non diam dapibus, ac dignissim leo aliquet.',
														          'more_text' => '',
														          'more_url' => '',
														        ),
														        1 => 
														        array (
														          'container_color' => false,
														          'icon' => 'ionicons-android-done',
														          'icon_title' => '',
														          'icon_color' => '#545454',
														          'icon_image' => 0,
														          'icon_image_size' => 'full',
														          'title' => 'Sucess',
														          'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam auctor erat non diam dapibus, ac dignissim leo aliquet.',
														          'more_text' => '',
														          'more_url' => '',
														        ),
														        2 => 
														        array (
														          'container_color' => false,
														          'icon' => 'ionicons-android-alarm-clock',
														          'icon_title' => '',
														          'icon_color' => '#545454',
														          'icon_image' => 0,
														          'icon_image_size' => 'full',
														          'title' => 'Dedication',
														          'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam auctor erat non diam dapibus, ac dignissim leo aliquet.',
														          'more_text' => '',
														          'more_url' => '',
														        ),
														        3 => 
														        array (
														          'container_color' => false,
														          'icon' => 'ionicons-android-create',
														          'icon_title' => '',
														          'icon_color' => '#545454',
														          'icon_image' => 0,
														          'icon_image_size' => 'full',
														          'title' => 'Design',
														          'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam auctor erat non diam dapibus, ac dignissim leo aliquet.',
														          'more_text' => '',
														          'more_url' => '',
														        ),
														      ),
														      'fonts' => 
														      array (
														        'title_options' => 
														        array (
														          'font' => 'default',
														          'size' => false,
														          'size_unit' => 'px',
														          'color' => false,
														          'so_field_container_state' => 'closed',
														        ),
														        'text_options' => 
														        array (
														          'font' => 'default',
														          'size' => false,
														          'size_unit' => 'px',
														          'color' => false,
														          'so_field_container_state' => 'closed',
														        ),
														        'more_text_options' => 
														        array (
														          'font' => 'default',
														          'size' => false,
														          'size_unit' => 'px',
														          'color' => false,
														          'so_field_container_state' => 'closed',
														        ),
														        'so_field_container_state' => 'closed',
														      ),
														      'container_shape' => 'round',
														      'container_size' => '20px',
														      'container_size_unit' => 'px',
														      'icon_size' => '24px',
														      'icon_size_unit' => 'px',
														      'per_row' => 4,
														      'responsive' => true,
														      '_sow_form_id' => '58b5deb379f18',
														      'title_link' => false,
														      'icon_link' => false,
														      'new_window' => false,
														      'panels_info' => 
														      array (
														        'class' => 'SiteOrigin_Widget_Features_Widget',
														        'raw' => false,
														        'grid' => 1,
														        'cell' => 0,
														        'id' => 2,
														        'widget_id' => '960cbbae-5ead-4f22-83a2-ca7b07760cd2',
														        'style' => 
														        array (
														          'animation_type' => 'fadeIn',
														          'animation_offset' => '10',
														          'animation_iteration' => '1',
														          'class' => 'left',
														          'background_display' => 'tile',
														          'font_color' => '#595959',
														        ),
														      ),
														    ),
														    3 => 
														    array (
														      'title' => '',
														      'text' => '<h2>We Innovate.</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis euismod nisi, sit amet lobortis elit interdum sit amet. Ut facilisis turpis et urna pharetra, id aliquam felis rutrum. In a mi quam. Nunc sollicitudin nisl ac ex pretium, quis consequat ex volutpat. Curabitur rutrum ligula viverra ligula dignissim feugiat. Duis a quam tortor.</p>',
														      'text_selected_editor' => 'tinymce',
														      'autop' => true,
														      '_sow_form_id' => '58b5ea491f1ef',
														      'panels_info' => 
														      array (
														        'class' => 'SiteOrigin_Widget_Editor_Widget',
														        'raw' => false,
														        'grid' => 2,
														        'cell' => 0,
														        'id' => 3,
														        'widget_id' => '0a1b92e7-0e2b-4fe7-a9c0-87f4f0cef7f5',
														        'style' => 
														        array (
														          'animation_type' => 'fadeIn',
														          'animation_offset' => '10',
														          'animation_iteration' => '1',
														          'class' => 'v-center',
														          'padding' => '17% 17% 17% 17%',
														          'background_display' => 'tile',
														          'font_color' => '#2d2d2d',
														        ),
														      ),
														    ),
														    4 => 
														    array (
														      'min_height' => '150',
														      'panels_info' => 
														      array (
														        'class' => 'TTrust_Spacer',
														        'raw' => false,
														        'grid' => 2,
														        'cell' => 1,
														        'id' => 4,
														        'widget_id' => '6f60b107-af15-4731-bfaf-6a55a6f3d8a6',
														        'style' => 
														        array (
														          'animation_type' => 'fadeIn',
														          'animation_offset' => '10',
														          'animation_iteration' => '1',
														          'background_image_attachment' => 16,
														          'background_display' => 'cover',
														        ),
														      ),
														    ),
														    5 => 
														    array (
														      'min_height' => '150',
														      'panels_info' => 
														      array (
														        'class' => 'TTrust_Spacer',
														        'raw' => false,
														        'grid' => 3,
														        'cell' => 0,
														        'id' => 5,
														        'widget_id' => '6f60b107-af15-4731-bfaf-6a55a6f3d8a6',
														        'style' => 
														        array (
														          'animation_type' => 'fadeIn',
														          'animation_offset' => '10',
														          'animation_iteration' => '1',
														          'background_image_attachment' => 21,
														          'background_display' => 'cover',
														        ),
														      ),
														    ),
														    6 => 
														    array (
														      'title' => '',
														      'text' => '<h2>Ideas.</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis euismod nisi, sit amet lobortis elit interdum sit amet. Ut facilisis turpis et urna pharetra, id aliquam felis rutrum. In a mi quam. Nunc sollicitudin nisl ac ex pretium, quis consequat ex volutpat. Curabitur rutrum ligula viverra ligula dignissim feugiat. Duis a quam tortor.</p>',
														      'text_selected_editor' => 'tinymce',
														      'autop' => true,
														      '_sow_form_id' => '58b6cac4ce5a3',
														      'panels_info' => 
														      array (
														        'class' => 'SiteOrigin_Widget_Editor_Widget',
														        'raw' => false,
														        'grid' => 3,
														        'cell' => 1,
														        'id' => 6,
														        'widget_id' => '0a1b92e7-0e2b-4fe7-a9c0-87f4f0cef7f5',
														        'style' => 
														        array (
														          'animation_type' => 'fadeIn',
														          'animation_offset' => '10',
														          'animation_iteration' => '1',
														          'class' => 'v-center',
														          'padding' => '17% 17% 17% 17%',
														          'background_display' => 'tile',
														          'font_color' => '#2d2d2d',
														        ),
														      ),
														    ),
														    7 => 
														    array (
														      'title' => '',
														      'text' => '<h2>What Makes us Great</h2><p>Nunc sollicitudin nisl ac ex pretium, quis consequat ex volutpat. Curabitur rutrum ligula viverra ligula dignissim feugiat. Duis a quam tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis euismod nisi, sit amet lobortis elit interdum sit amet. </p>',
														      'text_selected_editor' => 'tinymce',
														      'autop' => true,
														      '_sow_form_id' => '58c82f5b9c1ac',
														      'panels_info' => 
														      array (
														        'class' => 'SiteOrigin_Widget_Editor_Widget',
														        'raw' => false,
														        'grid' => 4,
														        'cell' => 0,
														        'id' => 7,
														        'widget_id' => '0a1b92e7-0e2b-4fe7-a9c0-87f4f0cef7f5',
														        'style' => 
														        array (
														          'animation_type' => 'fadeInLeft',
														          'animation_offset' => '10',
														          'animation_iteration' => '1',
														          'class' => 'v-center',
														          'padding' => '15% 12% 12% 12%',
														          'background_display' => 'tile',
														          'font_color' => '#2d2d2d',
														        ),
														      ),
														    ),
														    8 => 
														    array (
														      'title' => '',
														      'progress-bars' => 
														      array (
														        0 => 
														        array (
														          'title' => 'Talent',
														          'value' => '95',
														          'color' => '#3f87a8',
														        ),
														        1 => 
														        array (
														          'title' => 'Creativity',
														          'value' => '87',
														          'color' => '#4fa2a1',
														        ),
														        2 => 
														        array (
														          'title' => 'Hard Work',
														          'value' => '100',
														          'color' => '#49a581',
														        ),
														      ),
														      '_sow_form_id' => '58c82fd863a29',
														      'panels_info' => 
														      array (
														        'class' => 'Create_Progress_Bars_Widget',
														        'raw' => false,
														        'grid' => 4,
														        'cell' => 1,
														        'id' => 8,
														        'widget_id' => '058934e7-9e0d-4b60-9be7-92ba724f1dbb',
														        'style' => 
														        array (
														          'animation_type' => 'fadeInRight',
														          'animation_offset' => '10',
														          'animation_iteration' => '1',
														          'class' => 'v-center',
														          'padding' => '12% 12% 12% 12%',
														          'background_display' => 'tile',
														        ),
														      ),
														    ),
														    9 => 
														    array (
														      'title' => '',
														      'text' => '<p style="text-align: center;"><span style="color: #999999;">OUR VISION</span></p><h2 style="text-align: center;">We Have a Passion for Success</h2><p style="text-align: center;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis euismod nisi, sit amet lobortis elit interdum sit amet. Ut facilisis turpis et urna pharetra, id aliquam felis rutrum. In a mi quam. Nunc sollicitudin nisl ac ex pretium, quis consequat ex volutpat. Curabitur rutrum ligula viverra ligula dignissim feugiat. Duis a quam tortor.</p>',
														      'text_selected_editor' => 'tmce',
														      'autop' => true,
														      '_sow_form_id' => '58b6cbbe10661',
														      'panels_info' => 
														      array (
														        'class' => 'SiteOrigin_Widget_Editor_Widget',
														        'raw' => false,
														        'grid' => 5,
														        'cell' => 1,
														        'id' => 9,
														        'widget_id' => '0a1b92e7-0e2b-4fe7-a9c0-87f4f0cef7f5',
														        'style' => 
														        array (
														          'animation_type' => 'fadeIn',
														          'animation_offset' => '10',
														          'animation_iteration' => '1',
														          'class' => 'v-center',
														          'padding' => '0% 10% 0% 10%',
														          'background_display' => 'tile',
														          'font_color' => '#2d2d2d',
														        ),
														      ),
														    ),
														    10 => 
														    array (
														      'text' => 'Get In Touch',
														      'url' => '',
														      'button_icon' => 
														      array (
														        'icon_selected' => '',
														        'icon_color' => false,
														        'icon' => 0,
														        'so_field_container_state' => 'open',
														      ),
														      'design' => 
														      array (
														        'width' => false,
														        'width_unit' => 'px',
														        'align' => 'center',
														        'theme' => 'flat',
														        'button_color' => '#1f92c4',
														        'text_color' => '#ffffff',
														        'hover' => true,
														        'font' => 'default',
														        'font_size' => '1',
														        'rounding' => '1.5',
														        'padding' => '1',
														        'so_field_container_state' => 'open',
														      ),
														      'attributes' => 
														      array (
														        'id' => '',
														        'classes' => '',
														        'title' => '',
														        'onclick' => '',
														        'so_field_container_state' => 'closed',
														      ),
														      '_sow_form_id' => '58b6ccedeb3dd',
														      'new_window' => false,
														      'panels_info' => 
														      array (
														        'class' => 'SiteOrigin_Widget_Button_Widget',
														        'raw' => false,
														        'grid' => 5,
														        'cell' => 1,
														        'id' => 10,
														        'widget_id' => '5596e5b9-7cb6-4d53-a6ff-3b782136759c',
														        'style' => 
														        array (
														          'animation_type' => 'fadeIn',
														          'animation_offset' => '10',
														          'animation_iteration' => '1',
														          'padding' => '0px 0px 0px 0px',
														          'background_display' => 'tile',
														        ),
														      ),
														    ),
														  ),
														  'grids' => 
														  array (
														    0 => 
														    array (
														      'cells' => 2,
														      'style' => 
														      array (
														        'bottom_margin' => '0px',
														        'padding' => '200px 0px 200px 0px',
														        'mobile_padding' => '150px 0px 100px 0px',
														        'row_stretch' => 'full',
														        'equal_column_height' => 'no',
														        'background_image' => 6,
														        'background_image_position' => 'center top',
														        'background_image_style' => 'parallax',
														        'use_background_video' => '',
														        'video_overlay' => 'none',
														        'overlay_pattern' => 'dots',
														        'fade_in' => true,
														        'pause_after' => '120',
														        'pause_play_button' => true,
														        'pauseplay_xpos' => 'right',
														        'pauseplay_ypos' => 'top',
														      ),
														    ),
														    1 => 
														    array (
														      'cells' => 1,
														      'style' => 
														      array (
														        'bottom_margin' => '0px',
														        'row_stretch' => 'full',
														        'background' => '#f7f7f7',
														        'equal_column_height' => 'yes',
														        'padding_top' => '70px',
														        'padding_bottom' => '70px',
														        'background_image_position' => 'center top',
														        'background_image_style' => 'cover',
														        'use_background_video' => '',
														        'video_overlay' => 'none',
														        'overlay_pattern' => 'dots',
														        'fade_in' => true,
														        'pause_after' => '120',
														        'pause_play_button' => true,
														        'pauseplay_xpos' => 'right',
														        'pauseplay_ypos' => 'top',
														      ),
														    ),
														    2 => 
														    array (
														      'cells' => 2,
														      'style' => 
														      array (
														        'bottom_margin' => '0px',
														        'gutter' => '0px',
														        'row_stretch' => 'full-stretched',
														        'equal_column_height' => 'yes',
														        'padding_left' => '0px',
														        'padding_right' => '0px',
														        'background_image_position' => 'center top',
														        'background_image_style' => 'cover',
														        'use_background_video' => '',
														        'video_overlay' => 'none',
														        'overlay_pattern' => 'dots',
														        'fade_in' => true,
														        'pause_after' => '120',
														        'pause_play_button' => true,
														        'pauseplay_xpos' => 'right',
														        'pauseplay_ypos' => 'top',
														      ),
														    ),
														    3 => 
														    array (
														      'cells' => 2,
														      'style' => 
														      array (
														        'bottom_margin' => '0px',
														        'gutter' => '0px',
														        'row_stretch' => 'full-stretched',
														        'equal_column_height' => 'yes',
														        'padding_left' => '0px',
														        'padding_right' => '0px',
														        'background_image_position' => 'center top',
														        'background_image_style' => 'cover',
														        'use_background_video' => '',
														        'video_overlay' => 'none',
														        'overlay_pattern' => 'dots',
														        'fade_in' => true,
														        'pause_after' => '120',
														        'pause_play_button' => true,
														        'pauseplay_xpos' => 'right',
														        'pauseplay_ypos' => 'top',
														      ),
														    ),
														    4 => 
														    array (
														      'cells' => 2,
														      'style' => 
														      array (
														        'bottom_margin' => '0px',
														        'gutter' => '0px',
														        'row_stretch' => 'full-stretched',
														        'background' => '#f4f4f4',
														        'equal_column_height' => 'yes',
														        'padding_left' => '0px',
														        'padding_right' => '0px',
														        'background_image_position' => 'center top',
														        'background_image_style' => 'cover',
														        'use_background_video' => '',
														        'video_overlay' => 'none',
														        'overlay_pattern' => 'dots',
														        'fade_in' => true,
														        'pause_after' => '120',
														        'pause_play_button' => true,
														        'pauseplay_xpos' => 'right',
														        'pauseplay_ypos' => 'top',
														      ),
														    ),
														    5 => 
														    array (
														      'cells' => 3,
														      'style' => 
														      array (
														        'bottom_margin' => '0px',
														        'gutter' => '0px',
														        'padding' => '10% 10% 10% 10%',
														        'row_stretch' => 'full-stretched',
														        'background' => '#f9f9f9',
														        'equal_column_height' => 'yes',
														        'background_image_position' => 'center top',
														        'background_image_style' => 'cover',
														        'use_background_video' => '',
														        'video_overlay' => 'none',
														        'overlay_pattern' => 'dots',
														        'fade_in' => true,
														        'pause_after' => '120',
														        'pause_play_button' => true,
														        'pauseplay_xpos' => 'right',
														        'pauseplay_ypos' => 'top',
														      ),
														    ),
														  ),
														  'grid_cells' => 
														  array (
														    0 => 
														    array (
														      'grid' => 0,
														      'weight' => 0.71625391941487004,
														    ),
														    1 => 
														    array (
														      'grid' => 0,
														      'weight' => 0.28374608058513001,
														    ),
														    2 => 
														    array (
														      'grid' => 1,
														      'weight' => 1,
														    ),
														    3 => 
														    array (
														      'grid' => 2,
														      'weight' => 0.5,
														    ),
														    4 => 
														    array (
														      'grid' => 2,
														      'weight' => 0.5,
														    ),
														    5 => 
														    array (
														      'grid' => 3,
														      'weight' => 0.5,
														    ),
														    6 => 
														    array (
														      'grid' => 3,
														      'weight' => 0.5,
														    ),
														    7 => 
														    array (
														      'grid' => 4,
														      'weight' => 0.5,
														    ),
														    8 => 
														    array (
														      'grid' => 4,
														      'weight' => 0.5,
														    ),
														    9 => 
														    array (
														      'grid' => 5,
														      'weight' => 0.2002861230329,
														    ),
														    10 => 
														    array (
														      'grid' => 5,
														      'weight' => 0.5994277539342,
														    ),
														    11 => 
														    array (
														      'grid' => 5,
														      'weight' => 0.2002861230329,
														    ),
														  ),
													   ),
													
														$layouts['home-minimal-portfolio'] = array(
															'name' => __('Home: Minimal Portfolio', 'create'),
															'description' => __('Layout for demo Home: Minimal Portfolio.', 'create'),
															'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/home_minimal_portfolio.jpg',
															'widgets' => 
															  array (
															    0 => 
															    array (
															      'headline' => 
															      array (
															        'text' => 'Mobile Design &amp; Interaction',
															        'destination_url' => '',
															        'tag' => 'h1',
															        'color' => '#0a0a0a',
															        'hover_color' => false,
															        'font' => 'Lato:700',
															        'font_size' => '60px',
															        'font_size_unit' => 'px',
															        'align' => 'left',
															        'line_height' => '1.1em',
															        'line_height_unit' => 'em',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'sub_headline' => 
															      array (
															        'text' => '',
															        'destination_url' => '',
															        'tag' => 'p',
															        'color' => '#686868',
															        'hover_color' => false,
															        'font' => 'Droid Serif',
															        'font_size' => '20px',
															        'font_size_unit' => 'px',
															        'align' => 'left',
															        'line_height' => false,
															        'line_height_unit' => 'px',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'divider' => 
															      array (
															        'style' => 'none',
															        'color' => '#EEEEEE',
															        'thickness' => 1,
															        'align' => 'center',
															        'width' => '80%',
															        'width_unit' => '%',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															      ),
															      'order' => 
															      array (
															        0 => 'headline',
															        1 => 'divider',
															        2 => 'sub_headline',
															      ),
															      'fittext' => true,
															      '_sow_form_id' => '58c2d4fa59f39',
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Headline_Widget',
															        'raw' => false,
															        'grid' => 0,
															        'cell' => 0,
															        'id' => 0,
															        'widget_id' => '58b40d2a-48bc-4103-8a12-cdf5cf40e444',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    1 => 
															    array (
															      'title' => '',
															      'text' => '<p><span style="font-size: 24px;"><em><span style="font-family: georgia, palatino, serif;">We design and create engaging mobile experiences.</span></em></span></p>',
															      'text_selected_editor' => 'tinymce',
															      'autop' => true,
															      '_sow_form_id' => '58c2d77a7020f',
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Editor_Widget',
															        'grid' => 0,
															        'cell' => 0,
															        'id' => 1,
															        'widget_id' => 'a69073a0-a1ff-4a13-b31e-09c0723f6cbd',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_image_attachment' => false,
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    2 => 
															    array (
															      'title' => '',
															      'show_filter' => 'no',
															      'filter_alignment' => 'center',
															      'count' => '4',
															      'thumb_proportions' => 'square',
															      'layout' => 'masonry with gutter',
															      'columns' => '4',
															      'skills' => 
															      array (
															        'mobile' => 'mobile',
															      ),
															      'orderby' => 'date',
															      'order' => 'DESC',
															      'hover_effect' => 'effect-4',
															      'hover_color' => '',
															      'hover_text_color' => '',
															      'show_skills' => 'no',
															      'show_load_more' => 'no',
															      'load_more_color' => '',
															      'load_more_text_color' => '',
															      'enable_lightbox' => 'no',
															      'panels_info' => 
															      array (
															        'class' => 'TTrust_Portfolio',
															        'raw' => false,
															        'grid' => 1,
															        'cell' => 0,
															        'id' => 2,
															        'widget_id' => '1c3a70a3-a10e-491f-90d5-4b53c6711110',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_duration' => '1s',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    3 => 
															    array (
															      'text' => 'View More Work',
															      'url' => '',
															      'button_icon' => 
															      array (
															        'icon_selected' => '',
															        'icon_color' => '#0a0a0a',
															        'icon' => 0,
															        'so_field_container_state' => 'open',
															      ),
															      'design' => 
															      array (
															        'width' => false,
															        'width_unit' => 'px',
															        'align' => 'right',
															        'theme' => 'flat',
															        'button_color' => '#ffffff',
															        'text_color' => '#0a0a0a',
															        'hover' => true,
															        'font' => 'default',
															        'font_size' => '1',
															        'rounding' => '0.25',
															        'padding' => '0.5',
															        'so_field_container_state' => 'open',
															      ),
															      'attributes' => 
															      array (
															        'id' => '',
															        'classes' => '',
															        'title' => '',
															        'onclick' => '',
															        'so_field_container_state' => 'closed',
															      ),
															      '_sow_form_id' => '58c2df844655e',
															      'new_window' => false,
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Button_Widget',
															        'raw' => false,
															        'grid' => 1,
															        'cell' => 0,
															        'id' => 3,
															        'widget_id' => 'c363d932-3adb-48e7-9cd5-461e9d662d13',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_duration' => '1s',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    4 => 
															    array (
															      'headline' => 
															      array (
															        'text' => 'Articles',
															        'destination_url' => '',
															        'tag' => 'h3',
															        'color' => '#0a0a0a',
															        'hover_color' => false,
															        'font' => 'Lato:700',
															        'font_size' => '40px',
															        'font_size_unit' => 'px',
															        'align' => 'left',
															        'line_height' => false,
															        'line_height_unit' => 'px',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'sub_headline' => 
															      array (
															        'text' => '',
															        'destination_url' => '',
															        'tag' => 'p',
															        'color' => '#686868',
															        'hover_color' => false,
															        'font' => 'Droid Serif',
															        'font_size' => '20px',
															        'font_size_unit' => 'px',
															        'align' => 'left',
															        'line_height' => false,
															        'line_height_unit' => 'px',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'divider' => 
															      array (
															        'style' => 'none',
															        'color' => '#EEEEEE',
															        'thickness' => 1,
															        'align' => 'center',
															        'width' => '80%',
															        'width_unit' => '%',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															      ),
															      'order' => 
															      array (
															        0 => 'headline',
															        1 => 'divider',
															        2 => 'sub_headline',
															      ),
															      '_sow_form_id' => '58c2dd620be28',
															      'fittext' => false,
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Headline_Widget',
															        'raw' => false,
															        'grid' => 2,
															        'cell' => 0,
															        'id' => 4,
															        'widget_id' => '58b40d2a-48bc-4103-8a12-cdf5cf40e444',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    5 => 
															    array (
															      'title' => '',
															      'text' => '<p><span style="font-size: 18px;"><em><span style="font-family: georgia, palatino, serif;">We believe in sharing our experience and what we have learned. Below you can read posts from our blog.</span></em></span></p>',
															      'text_selected_editor' => 'tinymce',
															      'autop' => true,
															      '_sow_form_id' => '58c2dd8d51ddd',
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Editor_Widget',
															        'raw' => false,
															        'grid' => 2,
															        'cell' => 0,
															        'id' => 5,
															        'widget_id' => 'a69073a0-a1ff-4a13-b31e-09c0723f6cbd',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    6 => 
															    array (
															      'title' => '',
															      'count' => '2',
															      'category' => '',
															      'layout' => 'grid',
															      'columns' => '2',
															      'alignment' => 'left',
															      'orderby' => 'date',
															      'order' => 'DESC',
															      'show_excerpt' => 'no',
															      'carousel-nav-color' => '',
															      'panels_info' => 
															      array (
															        'class' => 'TTrust_Blog',
															        'raw' => false,
															        'grid' => 3,
															        'cell' => 0,
															        'id' => 6,
															        'widget_id' => '25218aa0-a98c-4cbb-bf21-79703be227f8',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    7 => 
															    array (
															      'text' => 'Read More Articles',
															      'url' => '',
															      'button_icon' => 
															      array (
															        'icon_selected' => '',
															        'icon_color' => '#0a0a0a',
															        'icon' => 0,
															        'so_field_container_state' => 'open',
															      ),
															      'design' => 
															      array (
															        'width' => false,
															        'width_unit' => 'px',
															        'align' => 'right',
															        'theme' => 'flat',
															        'button_color' => '#ffffff',
															        'text_color' => '#0a0a0a',
															        'hover' => true,
															        'font' => 'default',
															        'font_size' => '1',
															        'rounding' => '0.25',
															        'padding' => '0.5',
															        'so_field_container_state' => 'open',
															      ),
															      'attributes' => 
															      array (
															        'id' => '',
															        'classes' => '',
															        'title' => '',
															        'onclick' => '',
															        'so_field_container_state' => 'open',
															      ),
															      '_sow_form_id' => '58c2e005b1203',
															      'new_window' => false,
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Button_Widget',
															        'raw' => false,
															        'grid' => 3,
															        'cell' => 0,
															        'id' => 7,
															        'widget_id' => 'c363d932-3adb-48e7-9cd5-461e9d662d13',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'padding' => '0px 0px 0px 0px',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    8 => 
															    array (
															      'headline' => 
															      array (
															        'text' => 'Our Clients',
															        'destination_url' => '',
															        'tag' => 'h3',
															        'color' => '#0a0a0a',
															        'hover_color' => false,
															        'font' => 'Lato:700',
															        'font_size' => '40px',
															        'font_size_unit' => 'px',
															        'align' => 'left',
															        'line_height' => false,
															        'line_height_unit' => 'px',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'sub_headline' => 
															      array (
															        'text' => '',
															        'destination_url' => '',
															        'tag' => 'p',
															        'color' => '#686868',
															        'hover_color' => false,
															        'font' => 'Droid Serif',
															        'font_size' => '20px',
															        'font_size_unit' => 'px',
															        'align' => 'left',
															        'line_height' => false,
															        'line_height_unit' => 'px',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'divider' => 
															      array (
															        'style' => 'none',
															        'color' => '#EEEEEE',
															        'thickness' => 1,
															        'align' => 'center',
															        'width' => '80%',
															        'width_unit' => '%',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															      ),
															      'order' => 
															      array (
															        0 => 'headline',
															        1 => 'divider',
															        2 => 'sub_headline',
															      ),
															      '_sow_form_id' => '58c845ca9020d',
															      'fittext' => false,
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Headline_Widget',
															        'raw' => false,
															        'grid' => 4,
															        'cell' => 0,
															        'id' => 8,
															        'widget_id' => '58b40d2a-48bc-4103-8a12-cdf5cf40e444',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    9 => 
															    array (
															      'title' => '',
															      'text' => '<p><span style="font-size: 18px;"><em><span style="font-family: georgia, palatino, serif;">We work with some of the best companies in the world. They believe in what we can do.</span></em></span></p>',
															      'text_selected_editor' => 'tinymce',
															      'autop' => true,
															      '_sow_form_id' => '58c845d8a95fb',
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Editor_Widget',
															        'raw' => false,
															        'grid' => 4,
															        'cell' => 0,
															        'id' => 9,
															        'widget_id' => 'a69073a0-a1ff-4a13-b31e-09c0723f6cbd',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    10 => 
															    array (
															      'type' => 'visual',
															      'title' => '',
															      'text' => '<p><img class="alignleft size-large wp-image-328" src="http://demos.themetrust.com/create-2/wp-content/uploads/sites/28/2017/03/company_logos-1024x123.jpg" alt="" width="1024" height="123" /></p>',
															      'filter' => '1',
															      'panels_info' => 
															      array (
															        'class' => 'WP_Widget_Black_Studio_TinyMCE',
															        'raw' => false,
															        'grid' => 5,
															        'cell' => 0,
															        'id' => 10,
															        'widget_id' => '5b61589e-2a29-4562-982a-863a800a61af',
															        'style' => 
															        array (
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															  ),
															  'grids' => 
															  array (
															    0 => 
															    array (
															      'cells' => 2,
															      'style' => 
															      array (
															        'padding' => '200px 10px 100px 10px',
															        'mobile_padding' => '150px 0px 70px 0px',
															        'equal_column_height' => 'no',
															        'background_image_position' => 'center top',
															        'background_image_style' => 'cover',
															        'use_background_video' => '',
															        'video_overlay' => 'none',
															        'overlay_pattern' => 'dots',
															        'fade_in' => true,
															        'pause_after' => '120',
															        'pause_play_button' => true,
															        'pauseplay_xpos' => 'right',
															        'pauseplay_ypos' => 'top',
															      ),
															    ),
															    1 => 
															    array (
															      'cells' => 1,
															      'style' => 
															      array (
															        'equal_column_height' => 'no',
															        'background_image_position' => 'center top',
															        'background_image_style' => 'cover',
															        'use_background_video' => '',
															        'video_overlay' => 'none',
															        'overlay_pattern' => 'dots',
															        'fade_in' => true,
															        'pause_after' => '120',
															        'pause_play_button' => true,
															        'pauseplay_xpos' => 'right',
															        'pauseplay_ypos' => 'top',
															      ),
															    ),
															    2 => 
															    array (
															      'cells' => 2,
															      'style' => 
															      array (
															        'padding' => '2% 0% 5% 1%',
															        'equal_column_height' => 'no',
															        'background_image_position' => 'center top',
															        'background_image_style' => 'cover',
															        'use_background_video' => '',
															        'video_overlay' => 'none',
															        'overlay_pattern' => 'dots',
															        'fade_in' => true,
															        'pause_after' => '120',
															        'pause_play_button' => true,
															        'pauseplay_xpos' => 'right',
															        'pauseplay_ypos' => 'top',
															      ),
															    ),
															    3 => 
															    array (
															      'cells' => 1,
															      'style' => 
															      array (
															        'equal_column_height' => 'no',
															        'background_image_position' => 'center top',
															        'background_image_style' => 'cover',
															        'use_background_video' => '',
															        'video_overlay' => 'none',
															        'overlay_pattern' => 'dots',
															        'fade_in' => true,
															        'pause_after' => '120',
															        'pause_play_button' => true,
															        'pauseplay_xpos' => 'right',
															        'pauseplay_ypos' => 'top',
															      ),
															    ),
															    4 => 
															    array (
															      'cells' => 2,
															      'style' => 
															      array (
															        'padding' => '0% 0% 1% 2%',
															        'equal_column_height' => 'no',
															        'background_image_position' => 'center top',
															        'background_image_style' => 'cover',
															        'use_background_video' => '',
															        'video_overlay' => 'none',
															        'overlay_pattern' => 'dots',
															        'fade_in' => true,
															        'pause_after' => '120',
															        'pause_play_button' => true,
															        'pauseplay_xpos' => 'right',
															        'pauseplay_ypos' => 'top',
															      ),
															    ),
															    5 => 
															    array (
															      'cells' => 1,
															      'style' => 
															      array (
															        'padding' => '0% 0% 7% 2%',
															        'equal_column_height' => 'no',
															        'background_image_position' => 'center top',
															        'background_image_style' => 'cover',
															        'use_background_video' => '',
															        'video_overlay' => 'none',
															        'overlay_pattern' => 'dots',
															        'fade_in' => true,
															        'pause_after' => '120',
															        'pause_play_button' => true,
															        'pauseplay_xpos' => 'right',
															        'pauseplay_ypos' => 'top',
															      ),
															    ),
															  ),
															  'grid_cells' => 
															  array (
															    0 => 
															    array (
															      'grid' => 0,
															      'weight' => 0.81632179698467999,
															    ),
															    1 => 
															    array (
															      'grid' => 0,
															      'weight' => 0.18367820301532001,
															    ),
															    2 => 
															    array (
															      'grid' => 1,
															      'weight' => 1,
															    ),
															    3 => 
															    array (
															      'grid' => 2,
															      'weight' => 0.43076772633526,
															    ),
															    4 => 
															    array (
															      'grid' => 2,
															      'weight' => 0.56923227366474005,
															    ),
															    5 => 
															    array (
															      'grid' => 3,
															      'weight' => 1,
															    ),
															    6 => 
															    array (
															      'grid' => 4,
															      'weight' => 0.43076772633526,
															    ),
															    7 => 
															    array (
															      'grid' => 4,
															      'weight' => 0.56923227366474005,
															    ),
															    8 => 
															    array (
															      'grid' => 5,
															      'weight' => 1,
															    ),
															  ),
														),
														
														$layouts['home-coffee-shop'] = array(
															'name' => __('Home: Coffee Shop', 'create'),
															'description' => __('Layout for demo Home: Coffee Shop.', 'create'),
															'screenshot' => get_template_directory_uri() . '/images/page-builder-screenshots/home_coffee_shop.jpg',
															'widgets' => 
															  array (
															    0 => 
															    array (
															      'headline' => 
															      array (
															        'text' => 'The Bean Factory',
															        'destination_url' => '',
															        'tag' => 'h2',
															        'color' => '#ffffff',
															        'hover_color' => false,
															        'font' => 'Raleway:300',
															        'font_size' => '70px',
															        'font_size_unit' => 'px',
															        'align' => 'center',
															        'line_height' => '1em',
															        'line_height_unit' => 'em',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'sub_headline' => 
															      array (
															        'text' => 'The Best Coffee in the World',
															        'destination_url' => '',
															        'tag' => 'h3',
															        'color' => '#ffffff',
															        'hover_color' => false,
															        'font' => 'Montserrat',
															        'font_size' => '20px',
															        'font_size_unit' => 'px',
															        'align' => 'center',
															        'line_height' => false,
															        'line_height_unit' => 'px',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'divider' => 
															      array (
															        'style' => 'none',
															        'color' => '#EEEEEE',
															        'thickness' => 1,
															        'align' => 'center',
															        'width' => '80%',
															        'width_unit' => '%',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															      ),
															      'order' => 
															      array (
															        0 => 'sub_headline',
															        1 => 'divider',
															        2 => 'headline',
															      ),
															      '_sow_form_id' => '58b70aa32c084',
															      'fittext' => false,
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Headline_Widget',
															        'raw' => false,
															        'grid' => 0,
															        'cell' => 1,
															        'id' => 0,
															        'widget_id' => '4c0ee43d-2cef-45e4-b31b-75d2b895747c',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    1 => 
															    array (
															      'icon' => 'fontawesome-coffee',
															      'color' => '#3d3d3d',
															      'size' => false,
															      'size_unit' => 'px',
															      'alignment' => 'center',
															      'url' => '',
															      '_sow_form_id' => '58c32218a6ecd',
															      'new_window' => false,
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Icon_Widget',
															        'raw' => false,
															        'grid' => 1,
															        'cell' => 1,
															        'id' => 1,
															        'widget_id' => '97a5b9f8-35cd-4d40-9bf0-7e91738f1e12',
															        'style' => 
															        array (
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    2 => 
															    array (
															      'headline' => 
															      array (
															        'text' => 'Our Story',
															        'destination_url' => '',
															        'tag' => 'h2',
															        'color' => '#262626',
															        'hover_color' => false,
															        'font' => 'Raleway:300',
															        'font_size' => '45px',
															        'font_size_unit' => 'px',
															        'align' => 'center',
															        'line_height' => '1em',
															        'line_height_unit' => 'em',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'sub_headline' => 
															      array (
															        'text' => '',
															        'destination_url' => '',
															        'tag' => 'h3',
															        'color' => '#919191',
															        'hover_color' => false,
															        'font' => 'Cabin',
															        'font_size' => '17px',
															        'font_size_unit' => 'px',
															        'align' => 'center',
															        'line_height' => false,
															        'line_height_unit' => 'px',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'divider' => 
															      array (
															        'style' => 'none',
															        'color' => '#EEEEEE',
															        'thickness' => 1,
															        'align' => 'center',
															        'width' => '80%',
															        'width_unit' => '%',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'closed',
															      ),
															      'order' => 
															      array (
															        0 => 'sub_headline',
															        1 => 'divider',
															        2 => 'headline',
															      ),
															      '_sow_form_id' => '58b711d0db331',
															      'fittext' => false,
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Headline_Widget',
															        'raw' => false,
															        'grid' => 1,
															        'cell' => 1,
															        'id' => 2,
															        'widget_id' => '4c0ee43d-2cef-45e4-b31b-75d2b895747c',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'padding' => '0px 0px 30px 0px',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    3 => 
															    array (
															      'title' => '',
															      'text' => '<p style="text-align: left;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis euismod nisi, sit amet lobortis elit interdum sit amet. Ut facilisis turpis et urna pharetra, id aliquam felis rutrum. In a mi quam. Nunc sollicitudin nisl ac ex pretium, quis consequat ex volutpat. Curabitur rutrum ligula viverra ligula dignissim feugiat. Duis a quam tortor.</p>',
															      'text_selected_editor' => 'tinymce',
															      'autop' => true,
															      '_sow_form_id' => '58b7331422730',
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Editor_Widget',
															        'raw' => false,
															        'grid' => 2,
															        'cell' => 0,
															        'id' => 3,
															        'widget_id' => 'edd31694-8691-42c6-a0fa-06d1dc22e00d',
															        'style' => 
															        array (
															          'animation_type' => 'fadeInLeft',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'padding' => '0px 0px 0px 0px',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    4 => 
															    array (
															      'title' => '',
															      'text' => '<p style="text-align: left;">Curabitur rutrum ligula viverra ligula dignissim feugiat. Duis a quam tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis euismod nisi, sit amet lobortis elit interdum sit amet. Ut facilisis turpis et urna pharetra, id aliquam felis rutrum. In a mi quam. Nunc sollicitudin nisl ac ex pretium, quis consequat ex volutpat. </p>',
															      'text_selected_editor' => 'tinymce',
															      'autop' => true,
															      '_sow_form_id' => '58b7331f94719',
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Editor_Widget',
															        'raw' => false,
															        'grid' => 2,
															        'cell' => 1,
															        'id' => 4,
															        'widget_id' => 'edd31694-8691-42c6-a0fa-06d1dc22e00d',
															        'style' => 
															        array (
															          'animation_type' => 'fadeInRight',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'padding' => '0px 0px 0px 0px',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    5 => 
															    array (
															      'headline' => 
															      array (
															        'text' => 'Delicious Espresso',
															        'destination_url' => '',
															        'tag' => 'h2',
															        'color' => '#ffffff',
															        'hover_color' => false,
															        'font' => 'Raleway:300',
															        'font_size' => '30px',
															        'font_size_unit' => 'px',
															        'align' => 'left',
															        'line_height' => '1em',
															        'line_height_unit' => 'em',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'sub_headline' => 
															      array (
															        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis euismod nisi, sit amet lobortis elit interdum sit amet. Ut facilisis turpis et urna pharetra, id aliquam felis rutrum. In a mi quam. Nunc sollicitudin nisl ac ex pretium, quis consequat ex volutpat. ',
															        'destination_url' => '',
															        'tag' => 'p',
															        'color' => '#9e9e9e',
															        'hover_color' => false,
															        'font' => 'default',
															        'font_size' => false,
															        'font_size_unit' => 'px',
															        'align' => 'left',
															        'line_height' => '1.7em',
															        'line_height_unit' => 'em',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'divider' => 
															      array (
															        'style' => 'none',
															        'color' => '#EEEEEE',
															        'thickness' => 1,
															        'align' => 'center',
															        'width' => '80%',
															        'width_unit' => '%',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'closed',
															      ),
															      'order' => 
															      array (
															        0 => 'divider',
															        1 => 'headline',
															        2 => 'sub_headline',
															      ),
															      '_sow_form_id' => '58c4794e9ae05',
															      'fittext' => false,
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Headline_Widget',
															        'raw' => false,
															        'grid' => 3,
															        'cell' => 0,
															        'id' => 5,
															        'widget_id' => '4c0ee43d-2cef-45e4-b31b-75d2b895747c',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'class' => 'v-center',
															          'padding' => '0px 80px 0px 80px',
															          'background' => '#303030',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    6 => 
															    array (
															      'min_height' => '400',
															      'panels_info' => 
															      array (
															        'class' => 'TTrust_Spacer',
															        'raw' => false,
															        'grid' => 3,
															        'cell' => 1,
															        'id' => 6,
															        'widget_id' => '86ccc03d-7378-4c25-b540-e0e788c662c9',
															        'style' => 
															        array (
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_image_attachment' => 283,
															          'background_display' => 'cover',
															        ),
															      ),
															    ),
															    7 => 
															    array (
															      'min_height' => '400',
															      'panels_info' => 
															      array (
															        'class' => 'TTrust_Spacer',
															        'raw' => false,
															        'grid' => 4,
															        'cell' => 0,
															        'id' => 7,
															        'widget_id' => '86ccc03d-7378-4c25-b540-e0e788c662c9',
															        'style' => 
															        array (
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_image_attachment' => 274,
															          'background_display' => 'cover',
															        ),
															      ),
															    ),
															    8 => 
															    array (
															      'headline' => 
															      array (
															        'text' => 'Artisan Pastries',
															        'destination_url' => '',
															        'tag' => 'h2',
															        'color' => '#ffffff',
															        'hover_color' => false,
															        'font' => 'Raleway:300',
															        'font_size' => '30px',
															        'font_size_unit' => 'px',
															        'align' => 'left',
															        'line_height' => '1em',
															        'line_height_unit' => 'em',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'sub_headline' => 
															      array (
															        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis euismod nisi, sit amet lobortis elit interdum sit amet. Ut facilisis turpis et urna pharetra, id aliquam felis rutrum. In a mi quam. Nunc sollicitudin nisl ac ex pretium, quis consequat ex volutpat. ',
															        'destination_url' => '',
															        'tag' => 'p',
															        'color' => '#9e9e9e',
															        'hover_color' => false,
															        'font' => 'default',
															        'font_size' => false,
															        'font_size_unit' => 'px',
															        'align' => 'left',
															        'line_height' => '1.7em',
															        'line_height_unit' => 'em',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'divider' => 
															      array (
															        'style' => 'none',
															        'color' => '#EEEEEE',
															        'thickness' => 1,
															        'align' => 'center',
															        'width' => '80%',
															        'width_unit' => '%',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'closed',
															      ),
															      'order' => 
															      array (
															        0 => 'divider',
															        1 => 'headline',
															        2 => 'sub_headline',
															      ),
															      '_sow_form_id' => '58c482233066c',
															      'fittext' => false,
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Headline_Widget',
															        'raw' => false,
															        'grid' => 4,
															        'cell' => 1,
															        'id' => 8,
															        'widget_id' => '4c0ee43d-2cef-45e4-b31b-75d2b895747c',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'class' => 'v-center',
															          'padding' => '0px 80px 0px 80px',
															          'background' => '#303030',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    9 => 
															    array (
															      'headline' => 
															      array (
															        'text' => 'Menu',
															        'destination_url' => '',
															        'tag' => 'h2',
															        'color' => '#262626',
															        'hover_color' => false,
															        'font' => 'Raleway:300',
															        'font_size' => '45px',
															        'font_size_unit' => 'px',
															        'align' => 'center',
															        'line_height' => '1em',
															        'line_height_unit' => 'em',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'sub_headline' => 
															      array (
															        'text' => '',
															        'destination_url' => '',
															        'tag' => 'h3',
															        'color' => '#919191',
															        'hover_color' => false,
															        'font' => 'Cabin',
															        'font_size' => '17px',
															        'font_size_unit' => 'px',
															        'align' => 'center',
															        'line_height' => false,
															        'line_height_unit' => 'px',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'divider' => 
															      array (
															        'style' => 'solid',
															        'color' => '#595959',
															        'thickness' => 1,
															        'align' => 'center',
															        'width' => '40%',
															        'width_unit' => '%',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															      ),
															      'order' => 
															      array (
															        0 => 'headline',
															        1 => 'divider',
															        2 => 'sub_headline',
															      ),
															      '_sow_form_id' => '58c5e93803fbc',
															      'fittext' => false,
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Headline_Widget',
															        'raw' => false,
															        'grid' => 5,
															        'cell' => 1,
															        'id' => 9,
															        'widget_id' => '4c0ee43d-2cef-45e4-b31b-75d2b895747c',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'padding' => '0px 0px 30px 0px',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    10 => 
															    array (
															      'title' => '',
															      'text' => '<h5 style="text-align: center;"><span style="color: #000000;">Espresso $2.50</span></h5>
															<p style="text-align: center;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eget quam orci. Quisque porta varius dui, quis posuere nibh mollis quis.</p>

															<h5 style="text-align: center;"><span style="color: #000000;">Americano $3.00</span></h5>
															<p style="text-align: center;">Mauris commodo rhoncus porttitor. Maecenas et euismod elit. Nulla facilisi. Vivamus lacus libero, ultrices non ullamcorper ac, tempus sit amet enim.</p>

															<h5 style="text-align: center;"><span style="color: #000000;">Lattee $3.50</span></h5>
															<p style="text-align: center;">Vivamus sagittis est eu diam fringilla nec tristique metus vestibulum. Donec magna purus, pellentesque vel lobortis ut, convallis.</p>

															<h5 style="text-align: center;"><span style="color: #000000;">Cappucino $4.00</span></h5>
															<p style="text-align: center;">Ut facilisis turpis et urna pharetra, id aliquam felis rutrum. In a mi quam. Nunc sollicitudin nisl ac ex pretium, quis consequat ex volutpat.</p>
															',
															      'text_selected_editor' => 'html',
															      'autop' => true,
															      '_sow_form_id' => '58c5436444c54',
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Editor_Widget',
															        'raw' => false,
															        'grid' => 5,
															        'cell' => 1,
															        'id' => 10,
															        'widget_id' => 'f4ceee5d-011a-494d-a7a6-37db99533f7d',
															        'style' => 
															        array (
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    11 => 
															    array (
															      'text' => 'See Full Menu',
															      'url' => '',
															      'button_icon' => 
															      array (
															        'icon_selected' => '',
															        'icon_color' => false,
															        'icon' => 0,
															        'so_field_container_state' => 'open',
															      ),
															      'design' => 
															      array (
															        'width' => false,
															        'width_unit' => 'px',
															        'align' => 'center',
															        'theme' => 'wire',
															        'button_color' => '#474747',
															        'text_color' => '#ffffff',
															        'hover' => true,
															        'font' => 'default',
															        'font_size' => '1',
															        'rounding' => '0.25',
															        'padding' => '1',
															        'so_field_container_state' => 'open',
															      ),
															      'attributes' => 
															      array (
															        'id' => '',
															        'classes' => '',
															        'title' => '',
															        'onclick' => '',
															        'so_field_container_state' => 'closed',
															      ),
															      '_sow_form_id' => '58c84e100d348',
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Button_Widget',
															        'grid' => 5,
															        'cell' => 1,
															        'id' => 11,
															        'widget_id' => 'bfba7a74-7b31-437d-a850-dadb4a91d723',
															        'style' => 
															        array (
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_image_attachment' => false,
															          'background_display' => 'tile',
															        ),
															      ),
															      'new_window' => false,
															    ),
															    12 => 
															    array (
															      'headline' => 
															      array (
															        'text' => 'Come Visit Us',
															        'destination_url' => '',
															        'tag' => 'h2',
															        'color' => '#ffffff',
															        'hover_color' => false,
															        'font' => 'Raleway:300',
															        'font_size' => '45px',
															        'font_size_unit' => 'px',
															        'align' => 'center',
															        'line_height' => '1em',
															        'line_height_unit' => 'em',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'sub_headline' => 
															      array (
															        'text' => '',
															        'destination_url' => '',
															        'tag' => 'h3',
															        'color' => '#ffffff',
															        'hover_color' => false,
															        'font' => 'Cabin',
															        'font_size' => '20px',
															        'font_size_unit' => 'px',
															        'align' => 'center',
															        'line_height' => false,
															        'line_height_unit' => 'px',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															        'new_window' => false,
															      ),
															      'divider' => 
															      array (
															        'style' => 'none',
															        'color' => '#EEEEEE',
															        'thickness' => 1,
															        'align' => 'center',
															        'width' => '80%',
															        'width_unit' => '%',
															        'margin' => false,
															        'margin_unit' => 'px',
															        'so_field_container_state' => 'open',
															      ),
															      'order' => 
															      array (
															        0 => 'sub_headline',
															        1 => 'divider',
															        2 => 'headline',
															      ),
															      '_sow_form_id' => '58b71b6d790e6',
															      'fittext' => false,
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Headline_Widget',
															        'raw' => false,
															        'grid' => 6,
															        'cell' => 1,
															        'id' => 12,
															        'widget_id' => '4c0ee43d-2cef-45e4-b31b-75d2b895747c',
															        'style' => 
															        array (
															          'animation_type' => 'fadeIn',
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															        ),
															      ),
															    ),
															    13 => 
															    array (
															      'title' => '',
															      'text' => '<p style="text-align: center;">350 5th Ave<br />New York, NY 10118</p>',
															      'text_selected_editor' => 'tinymce',
															      'autop' => true,
															      '_sow_form_id' => '58c5fa7d50b78',
															      'panels_info' => 
															      array (
															        'class' => 'SiteOrigin_Widget_Editor_Widget',
															        'raw' => false,
															        'grid' => 6,
															        'cell' => 1,
															        'id' => 13,
															        'widget_id' => 'a41ee737-6231-45ed-ac93-a3eae78b9fbc',
															        'style' => 
															        array (
															          'animation_offset' => '10',
															          'animation_iteration' => '1',
															          'background_display' => 'tile',
															          'font_color' => '#e0e0e0',
															        ),
															      ),
															    ),
															  ),
															  'grids' => 
															  array (
															    0 => 
															    array (
															      'cells' => 3,
															      'style' => 
															      array (
															        'row_stretch' => 'full',
															        'equal_column_height' => 'no',
															        'padding_top' => '20%',
															        'padding_bottom' => '25%',
															        'background_image' => 298,
															        'background_image_position' => 'center top',
															        'background_image_style' => 'cover',
															        'use_background_video' => '',
															        'video_overlay' => 'solid',
															        'overlay_pattern' => 'dots',
															        'fade_in' => true,
															        'pause_after' => '120',
															        'pause_play_button' => true,
															        'pauseplay_xpos' => 'right',
															        'pauseplay_ypos' => 'top',
															      ),
															    ),
															    1 => 
															    array (
															      'cells' => 3,
															      'style' => 
															      array (
															        'bottom_margin' => '0px',
															        'row_stretch' => 'full',
															        'equal_column_height' => 'no',
															        'padding_top' => '3%',
															        'background_image_position' => 'center top',
															        'background_image_style' => 'cover',
															        'use_background_video' => '',
															        'video_overlay' => 'solid',
															        'overlay_pattern' => 'dots',
															        'fade_in' => true,
															        'pause_after' => '120',
															        'pause_play_button' => true,
															        'pauseplay_xpos' => 'right',
															        'pauseplay_ypos' => 'top',
															      ),
															    ),
															    2 => 
															    array (
															      'cells' => 2,
															      'style' => 
															      array (
															        'bottom_margin' => '0px',
															        'equal_column_height' => 'no',
															        'padding_bottom' => '5%',
															        'padding_left' => '10%',
															        'padding_right' => '10%',
															        'background_image_position' => 'center top',
															        'background_image_style' => 'cover',
															        'use_background_video' => '',
															        'video_overlay' => 'solid',
															        'overlay_pattern' => 'dots',
															        'fade_in' => true,
															        'pause_after' => '120',
															        'pause_play_button' => true,
															        'pauseplay_xpos' => 'right',
															        'pauseplay_ypos' => 'top',
															      ),
															    ),
															    3 => 
															    array (
															      'cells' => 2,
															      'style' => 
															      array (
															        'bottom_margin' => '0px',
															        'gutter' => '20px',
															        'equal_column_height' => 'yes',
															        'background_image_position' => 'center top',
															        'background_image_style' => 'cover',
															        'use_background_video' => '',
															        'video_overlay' => 'none',
															        'overlay_pattern' => 'dots',
															        'fade_in' => true,
															        'pause_after' => '120',
															        'pause_play_button' => true,
															        'pauseplay_xpos' => 'right',
															        'pauseplay_ypos' => 'top',
															      ),
															    ),
															    4 => 
															    array (
															      'cells' => 2,
															      'style' => 
															      array (
															        'gutter' => '20px',
															        'equal_column_height' => 'yes',
															        'background_image_position' => 'center top',
															        'background_image_style' => 'cover',
															        'use_background_video' => '',
															        'video_overlay' => 'none',
															        'overlay_pattern' => 'dots',
															        'fade_in' => true,
															        'pause_after' => '120',
															        'pause_play_button' => true,
															        'pauseplay_xpos' => 'right',
															        'pauseplay_ypos' => 'top',
															      ),
															    ),
															    5 => 
															    array (
															      'cells' => 3,
															      'style' => 
															      array (
															        'equal_column_height' => 'no',
															        'padding_top' => '6%',
															        'padding_bottom' => '6%',
															        'background_image_position' => 'center top',
															        'background_image_style' => 'cover',
															        'use_background_video' => '',
															        'video_overlay' => 'none',
															        'overlay_pattern' => 'dots',
															        'fade_in' => true,
															        'pause_after' => '120',
															        'pause_play_button' => true,
															        'pauseplay_xpos' => 'right',
															        'pauseplay_ypos' => 'top',
															      ),
															    ),
															    6 => 
															    array (
															      'cells' => 3,
															      'style' => 
															      array (
															        'bottom_margin' => '0px',
															        'row_stretch' => 'full',
															        'equal_column_height' => 'no',
															        'padding_top' => '20%',
															        'padding_bottom' => '20%',
															        'background_image' => 286,
															        'background_image_position' => 'center top',
															        'background_image_style' => 'parallax',
															        'use_background_video' => '',
															        'video_overlay' => 'solid',
															        'overlay_pattern' => 'dots',
															        'fade_in' => true,
															        'pause_after' => '120',
															        'pause_play_button' => true,
															        'pauseplay_xpos' => 'right',
															        'pauseplay_ypos' => 'top',
															      ),
															    ),
															  ),
															  'grid_cells' => 
															  array (
															    0 => 
															    array (
															      'grid' => 0,
															      'weight' => 0.20011242270939,
															    ),
															    1 => 
															    array (
															      'grid' => 0,
															      'weight' => 0.59977515458121999,
															    ),
															    2 => 
															    array (
															      'grid' => 0,
															      'weight' => 0.20011242270939,
															    ),
															    3 => 
															    array (
															      'grid' => 1,
															      'weight' => 0.20011242270939,
															    ),
															    4 => 
															    array (
															      'grid' => 1,
															      'weight' => 0.59977515458121999,
															    ),
															    5 => 
															    array (
															      'grid' => 1,
															      'weight' => 0.20011242270939,
															    ),
															    6 => 
															    array (
															      'grid' => 2,
															      'weight' => 0.5,
															    ),
															    7 => 
															    array (
															      'grid' => 2,
															      'weight' => 0.5,
															    ),
															    8 => 
															    array (
															      'grid' => 3,
															      'weight' => 0.5,
															    ),
															    9 => 
															    array (
															      'grid' => 3,
															      'weight' => 0.5,
															    ),
															    10 => 
															    array (
															      'grid' => 4,
															      'weight' => 0.5,
															    ),
															    11 => 
															    array (
															      'grid' => 4,
															      'weight' => 0.5,
															    ),
															    12 => 
															    array (
															      'grid' => 5,
															      'weight' => 0.25117845117845,
															    ),
															    13 => 
															    array (
															      'grid' => 5,
															      'weight' => 0.49898989898989998,
															    ),
															    14 => 
															    array (
															      'grid' => 5,
															      'weight' => 0.24983164983164999,
															    ),
															    15 => 
															    array (
															      'grid' => 6,
															      'weight' => 0.20011242270939,
															    ),
															    16 => 
															    array (
															      'grid' => 6,
															      'weight' => 0.59977515458121999,
															    ),
															    17 => 
															    array (
															      'grid' => 6,
															      'weight' => 0.20011242270939,
															    ),
															  ),
														),
											);								
		
	
    return $layouts;

}
add_filter('siteorigin_panels_prebuilt_layouts','create_prebuilt_layouts');



?>