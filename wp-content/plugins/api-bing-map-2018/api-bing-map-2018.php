<?php 
/* Plugin Name: API Bing Map 2018
*  Plugin URI: https://wordpress.org/plugins/api-bing-map-2018/
*  Description: Simple, and practical API Bing Map 2018 - it is intended to have similar functionality as google maps
*  Version: 1.3.0
*  Author: Dan
*  Author URI: http://tuskcode.com
*  License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

const PLUGIN_VERSION = '1.3.0';

add_action('admin_menu',    'tuskcode_map_bing_map_menu_admin_option');
add_action('widgets_init',  'tuskcode_map_load_widget');
add_shortcode( 'tuskcode-bing-map', 'tuskcode_map_displayInfo_function' );
add_action( 'wp_footer',    'tuskcode_map_putScriptInFooter', 5);
add_action('admin_head',    'tuskcode_map_putStyleInHeader');

function tuskcode_map_bing_map_menu_admin_option(){
    add_menu_page(  'API Bing Map - 2018', 'API Bing Map - 2018', 
                    'manage_options', 
                    'api-bing-map-2018-admin-menu', 
                    'tuskcode_map_admin_menu', 
                    plugins_url('/admin/images/icons/plugin-icon.png', __FILE__),
                    200);
}

function tuskcode_map_load_widget(){
    register_widget( 'api_bing_map_2018');
}

class api_bing_map_2018 extends WP_Widget{
    
    function __construct(){
        parent::__construct( 'tuskcode_bing_map', 'API Bing Map 2018',  array('description' => 'Bing Map ') );       
    }

    //front end
    public function widget( $args, $instance ){
        $title = apply_filters( 'widget_title', $instance['title'] );
                
        echo $args['before_widget'];
        
        if( ! empty( $title ) ){
            echo $args['before_title'].$title.$args['after_title'];
        }

        //this is where you display the content of the widget
        $display = " <div class='".get_option('tuskcode_bing_map_class', '')."' id='myMap' style='width: ".get_option('tuskcode_bing_map_width', '100%')."; height: "
            .get_option('tuskcode_bing_map_height', '350px')."'></div> ";
        echo $display;
        //----------------------------
        echo $args['after_widget'];

    }

    //back end 

    public function form( $instance ){
        if( isset( $instance['title'] ) ){
            $title = $instance['title'];
        }else{
            $title = __('', 'wpb_widget_domain');
        }
        $html_class = $instance['html_class'];

        ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>"
                     type="text" value="<?php echo esc_attr( $title ); ?>" />
 
            </p>   
        <?php        
    }

    //updating widget
    public function update( $new_instance, $old_instance){
        $instance = array();
        if( ! empty( $new_instance['title'] ) ){
            $instance['title'] = strip_tags( $new_instance['title'] );
        }else{
            $instance['title'] = '';            
        }
        
        return $instance;  
    }

}

//end of widget section 
//start the 

    function tuskcode_map_displayInfo_function(){
        $display_map = " <div class='".get_option('bing_map_class', '')."' id='myMap' style='width: "
                        .get_option('tuskcode_bing_map_width', '100%')."; height: ".get_option('tuskcode_bing_map_height', '350px')."'></div>";
        return $display_map;     
    }

    function tuskcode_map_putStyleInHeader(){
        $css_url = plugins_url('admin/css/style.css?v='.PLUGIN_VERSION , __FILE__);   
        wp_enqueue_style('style', $css_url, 'all');
      //  echo '<link rel="stylesheet" href="style.css" type="text/css" media="all" />';
    }  
    
    function getCoordinates( $add, $key ){
        $address = $add;
        $keyBing = $key;
        
        //$prepAddr = urlencode( $prepAddr );
        $prepAddr = str_replace(' ','%20',$address);

        $geocode = file_get_contents('https://dev.virtualearth.net/REST/v1/Locations?q='.$prepAddr.'&o=xml&key='.$keyBing );

        $xml = simplexml_load_string( $geocode );
        $latitude = '';
        $longitude = '';

        if( isset( $xml->ResourceSets->ResourceSet->Resources->Location->GeocodePoint->Latitude )){
            $latitude =  $xml->ResourceSets->ResourceSet->Resources->Location->GeocodePoint->Latitude;
            $longitude =  $xml->ResourceSets->ResourceSet->Resources->Location->GeocodePoint->Longitude;
        }
      

        $arr = array();
        if( ($latitude == null) || ($longitude == null)  || ($latitude === '') || ( $longitude === '') ){
            $arr[0] = '';
            $arr[1] = '';
        }else{
            $arr[0] = $latitude;
            $arr[1] = $longitude;
        }  
        
        return $arr;
    }

    function tuskcode_map_putScriptInFooter(){ 
        $img_url = plugins_url('/images/icons/icon1.png', __FILE__ );
        $icon_url = plugins_url('/images/icons/');

        $map_api_key =          get_option('tuskcode_bing_map_api_key', '');      
     //   $map_address =          get_option('tuskcode_bing_map_address', '');
        $map_width =            get_option('tuskcode_bing_map_width', '100%');
        $map_height =           get_option('tuskcode_bing_map_height', '350px');
        $map_pin =              get_option('tuskcode_bing_map_pin', 'default.png');
        $map_type =             get_option('tuskcode_bing_map_type', 'street');
        $map_zoom =             get_option('tuskcode_bing_map_zoom', '15');
      //  $map_custom_pin_url =   get_option('tuskcode_bing_map_custom_pin_url', '');
        $map_scroll =           get_option('tuskcode_bing_map_scroll');
        $map_pins =             get_option('tuskcode_bing_map_pins', '[]');
        $map_center_lat =       get_option('tuskcode_bing_map_center_lat', '' );
        $map_center_long =      get_option('tuskcode_bing_map_center_long', '' );

        $map_pins = json_decode( $map_pins, true );
       // var_dump( $map_pins );

        $icon_url = plugins_url('/admin/images/icons/', __FILE__).$map_pin;

    
        //get center of the map by finding the median for latitude and longitude;
        $med_lat = 0;
        $med_long = 0;

        //if lat is empty then find the center of the map with valid coordinates     
        $validLocation = 0;
        if( sizeof( $map_pins ) > 0){
            foreach( $map_pins as $pin ){
                $med_lat += doubleval( $pin['lat'] );
                $med_long += doubleval( $pin['long'] ); 
                
                if( $pin['lat'] !== '' ){
                    $validLocation++;
                }
            }
            if( $validLocation > 0){
                $med_lat = $med_lat / $validLocation;
                $med_long = $med_long / $validLocation;
            }
        }
        ?>

        <script type='text/javascript'>
            var BingMapsKey = '<?php echo $map_api_key;?>';
    
	//	var address = '<?php // if( $map_address == '') {echo '24, Chester Street, London';}else{ echo $map_address;}?>';

     //   var geocodeRequest = "https://dev.virtualearth.net/REST/v1/Locations?query=" + encodeURIComponent(address) + "&jsonp=GeocodeCallback&key=" + BingMapsKey;
		var mapRequest = "https://www.bing.com/api/maps/mapcontrol?key="+ BingMapsKey + "&callback=loadMapScenario";
		
        var $bing_map = document.getElementById('myMap');

        //check if bing map is loaded in this page
        if( $bing_map !== null ){
            //get the address coordinates
            CallRestService( mapRequest, loadMapScenario );	
            console.log('active');
        }

        function CallRestService(request) {
            
            var script = document.createElement("script");
            script.setAttribute("type", "text/javascript");
            script.setAttribute("src", request);
            document.body.appendChild(script);
            
        }

        var infobox;

        function loadMapScenario() { 
            //map types available: aerial, canvasDark, canvasLight, birdseye, street, grayscale
            var maps = document.querySelectorAll('#myMap');
 
            var address_latitude;
            var address_longitude;
            <?php
            if( $map_center_lat == '' ){         ?>
                address_latitude = "<?php echo ($med_lat == 0) ? '35.493980' : strval( $med_lat);?>";
                address_longitude ="<?php echo ($med_long == 0) ? '-78.044324' : strval( $med_long);?>";
            <?php }else{ ?>
                address_latitude = <?php echo strval($map_center_lat);?>;
                address_longitude = <?php echo strval($map_center_long);?>;
            <?php } ?>

            console.log( address_latitude );
            console.log( address_longitude );
        
            for( var i = 0; i < maps.length; i++ ){

                var map = new Microsoft.Maps.Map( maps[i], { 
                    center: new Microsoft.Maps.Location( address_latitude, address_longitude), 
                    mapTypeId: Microsoft.Maps.MapTypeId.<?php echo $map_type;?>,
                    disableScrollWheelZoom: <?php echo ( $map_scroll == '') ? 'false' : 'true' ?>, 
                    zoom: <?php echo $map_zoom ?>,					                    
                });

                var center = map.getCenter();

                infobox = new Microsoft.Maps.Infobox( map.getCenter(), {
                    visible: false
                });

                infobox.setMap( map );

                //add metadata for pin( title, and description)   
                <?php 
                    foreach( $map_pins as $key=>$pin ){
                        $pin_title =    $pin['title'];
                        $pin_desc =     $pin['desc'];
                        $pin_lat =      $pin['lat'];
                        $pin_long =     $pin['long']; 
                        $pin_url =      $pin['url'];

                        if( empty( $pin_lat ) ){
                            continue;
                        }
                    ?>
                    var customPin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location("<?php echo $pin_lat; ?>", "<?php echo $pin_long;?>"),{
                        <?php 
                        if( $pin_url !== '' ){
                            if( strpos( $pin_url, 'custom-icons/') > 0 ){
                                $pin_location = plugins_url('admin/', __FILE__).$pin_url;
                                echo 'icon:"'.$pin_location.'",';
                            }else{
                                echo 'icon: "'.$pin_url.'",';
                            }                         
                        }else{
                            if( strpos($icon_url, "default.png" ) === false ){
                                echo 'icon: "'.$icon_url.'",';}
                        }?>     
                    });   

                    <?php
 
                    if( ( $pin_title !== '' ) && ( $pin_desc !== '' )){
                        ?>                    
                        customPin.metadata = {
                            title: '<?php echo $pin_title;?>',
                            description: '<?php echo str_replace( 'bing_map_nl', '<br/>', $pin_desc);?>'
                        };

                        
                <?php
                      }
                      ?>
                    Microsoft.Maps.Events.addHandler( customPin, 'click', pushpinClicked );
                    map.entities.push( customPin );
                      <?php
                    }
                ?>

                
            }                 
        }

        function pushpinClicked(e) {
        //Make sure the infobox has metadata to display.
        if (e.target.metadata) {
            //Set the infobox options with the metadata of the pushpin.
            infobox.setOptions({
                location: e.target.getLocation(),
                title: e.target.metadata.title,
                description: e.target.metadata.description,
                visible: true
            });
        }
    }          
        </script> 

            <?php
    }              
    
    function tuskcode_map_admin_menu(){
        if( array_key_exists('bing_map_center_submit', $_POST ) ){
            $map_center_lat = $_POST['bing_map_center_latitude'];
            $map_center_long = $_POST['bing_map_center_longitude'];
            $map_admin_hidden_zoom = $_POST['bing_map_admin_hidden_zoom'];

            update_option('tuskcode_bing_map_center_lat', $map_center_lat );
            update_option('tuskcode_bing_map_center_long', $map_center_long );
            update_option('tuskcode_bing_map_zoom', $map_admin_hidden_zoom );
        }

        if( array_key_exists('submit_bing_map', $_POST ) ){
            $map_api_key = trim( sanitize_text_field( $_POST['map_api_key'] ) ); 
            $map_width = trim( sanitize_text_field( $_POST['map_width'] ) );
            $map_height = trim( sanitize_text_field(  $_POST['map_height']) );
            $map_pin = trim( $_POST['map_pin'] );
            $map_type = trim( $_POST['map_type']);
            $map_zoom = trim( $_POST['map_zoom']);
            $map_class = trim( sanitize_text_field( $_POST['map_class']));
           
            if( $_POST['map_scroll'] == null ){
                $map_scroll = '';
            }else{
                $map_scroll = 'checked';
            }
            $pins = array();
            $json_pins = '';

            //store pins with coordinates and details
            if( isset( $_POST['map_point_title'] )){
                if( is_array( $_POST['map_point_title']) ){
                    $pins_title = $_POST['map_point_title'];
                    $pins_desc = $_POST['map_point_description'];                    
                    $pins_address = $_POST['map_pin_address'];
                    $pins_custom_url = $_POST['map_pin_custom_url'];
                    
                    foreach( $pins_title  as $key=>$value ){

                        $pin_title = trim( sanitize_text_field( $value ));
                        $pin_desc = preg_replace("/\n/", "bing_map_nl", $pins_desc[ $key ]);
                        $pin_desc = trim( sanitize_text_field( $pin_desc ));
                        $pin_address = trim( sanitize_text_field( $pins_address[ $key ]));
                        $pin_url = trim( esc_attr( $pins_custom_url[ $key ]) );
                        $bing_pin_latitude = '';
                        $bing_pin_longitude = '';

                        if( isset( $_POST['bing_input_latitude']) ){
                            $bing_pin_latitude = trim($_POST['bing_input_latitude'][ $key ] );
                            $bing_pin_longitude = trim( $_POST['bing_input_longitude'][ $key ] );                        
                        }

                        if( ! empty( $pin_address )){  

                            $coordinates = getCoordinates( $pin_address, $map_api_key );                          
                            $pin_lat = strval( json_decode($coordinates[0] ) );
                            $pin_long = strval( json_decode($coordinates[1]) );                            
                        }else{
                            $pin_lat = $bing_pin_latitude;
                            $pin_long = $bing_pin_longitude;
                        }                                                

                        // || ( ! empty( $pin_desc )) || (! empty( $pin_lat )) || (! empty( $pin_long )) 
                        if( ( ! empty( $pin_title ) ) || (! empty( $pin_address)) || ( ! empty( $bing_pin_latitude )) ){
                          //  $pin_arr = [ $pin_title, $pin_desc, $pin_lat, $pin_long, $pin_address, $pin_url ];
                          //  $pins[ $key ] = $pin_arr;
                            
                            $pins[ $key ][ 'title' ]    = $pin_title;
                            $pins[ $key ][ 'desc' ]     = $pin_desc;
                            $pins[ $key ][ 'lat' ]      = $pin_lat;
                            $pins[ $key ][ 'long' ]     = $pin_long;
                            $pins[ $key ][ 'address' ]  = $pin_address;
                            $pins[ $key ][ 'url' ]      = $pin_url;
                            
                        }

                    }
                    $json_pins = json_encode( $pins );
                    update_option('tuskcode_bing_map_pins', $json_pins );
                }
            }else{
               // echo 'not set';
            }

            update_option('tuskcode_bing_map_api_key', $map_api_key );
            update_option('tuskcode_bing_map_width', $map_width );
            update_option('tuskcode_bing_map_height', $map_height );
            update_option('tuskcode_bing_map_pin', $map_pin );
            update_option('tuskcode_bing_map_type', $map_type );
            update_option('tuskcode_bing_map_zoom', $map_zoom );
            update_option('tuskcode_bing_map_class', $map_class );
            update_option('tuskcode_bing_map_scroll', $map_scroll );
            
            
            ?>
            <div class="notice notice-success is-dismissible">
                 <b>Settings have been saved </b>
            </div>
            <?php

        }
 
        $map_api_key =  get_option('tuskcode_bing_map_api_key', '');      
        $map_width =    get_option('tuskcode_bing_map_width', '');
        $map_height =   get_option('tuskcode_bing_map_height', '');
        $map_pin =      get_option('tuskcode_bing_map_pin', 'default.png');
        $map_type =     get_option('tuskcode_bing_map_type', '');
        $map_zoom =     get_option('tuskcode_bing_map_zoom', '15');
        $map_class =    get_option('tuskcode_bing_map_class', '' );
        $map_scroll =   get_option('tuskcode_bing_map_scroll');
        $map_pins =     get_option('tuskcode_bing_map_pins', '[]');

        $map_center_lat = get_option('tuskcode_bing_map_center_lat', '' );
        $map_center_long = get_option('tuskcode_bing_map_center_long', '' );

        $map_pins = json_decode( $map_pins, true );

        $images_url = plugins_url('/admin/images/icons/', __FILE__ );
        $clear_custom_url = plugins_url('/admin/images/clear.png', __FILE__ );

        ?>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="HH7J3U2U9YYQ2">
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">

        </form>
        <p style="display: inline;"> <b> Any donations will help me keep plugins free, and develop new ones.  
        Suggestions, or support are welcome at developer@tuskcode.com ----> Credit: Icons are provided by <a href="https://mapicons.mapsmarker.com" target="_blank"> mapicons.mapsmarker.com </a></b></p>
        <p> <span> Free API Key: <a href="https://www.bingmapsportal.com/" target="_blank"> www.bingmapsportal.com </a> and follow the instructions! </span></p>

            <div class='wrap'>


                <h2> Bing Map Settings </h2>
                <form id='wrap_form' action='' method='POST' >
                    <input type="submit" name="submit_bing_map" class="button button-primary" value="Save Map Settings" >

                    <p id="p_map_key">
                        <label for="map_key">API Key </label>
                            <input type='text' id='map_key' name="map_api_key"  value="<?php print $map_api_key;?>" />
                         
                    </p> 

                    <p id="p_map_pin" >
                        <label for="map_pin">Map Pin: </label>
                        <select id="map_pin" name='map_pin' >
                            <option value='default.png'>  Default </option>
                            <option value="black.png" <?php if($map_pin == 'black.png'){ echo 'selected';}?>> Black </option>
                            <option value="blue.png" <?php if($map_pin == 'blue.png'){ echo 'selected';}?>>  Blue </option>
                            <option value="blue-pin.png" <?php if($map_pin == 'blue-pin.png'){ echo 'selected';}?>> Blue Pin</option>
                            <option value="google.png" <?php if($map_pin == 'google.png'){ echo 'selected';}?>>  Google </option>
                            <option value="green.png" <?php if($map_pin == 'green.png'){ echo 'selected';}?>> Green </option>
                            <option value="light-blue.png" <?php if($map_pin == 'light-blue.png'){ echo 'selected';}?>> Light Blue </option>
                            <option value="yellow.png" <?php if($map_pin == 'yellow.png'){ echo 'selected';}?>> Yellow </option>
                            <option value="white.png" <?php if($map_pin == 'white.png'){ echo 'selected';}?>> White</option>
                            <option value="orange.png" <?php if($map_pin == 'orange.png'){ echo 'selected';}?>> Orange </option>
                            <option value="violet.png" <?php if($map_pin == 'violet.png'){ echo 'selected';}?>> Violet </option>
                            <option value="orange-pin.png" <?php if($map_pin == 'orange-pin.png'){ echo 'selected';}?> > Orange Pin</option>
                            <option value="red-blue-base.png" <?php if($map_pin == 'red-blue-base.png'){ echo 'selected';}?>> Red Blue Base</option>
                            <option value="red-vibe.png" <?php if($map_pin == 'red-vibe.png'){ echo 'selected';}?>> Red Vibe</option>

                        </select>
                        <img  id='p_map_pin_img' src="<?php                                                     
                            if( $map_pin == ''){
                                echo $images_url.'default.png';}else{ echo $images_url.$map_pin;}?>" width='40px' height='40px' alt="map icon" />
                    </p> 

                    <!-- map types available: aerial, canvasDark, canvasLight, birdseye, street, grayscale -->
                    <p id="p_map_type">
                        <label for="map_type"> Map Type:</label>
                        <select id="map_type" name="map_type">
                            <option value="default" > Default </option>
                            <option value="aerial" <?php if($map_type === 'aerial'){ echo 'selected';}?>> Aerial </option>
                            <option value="birdseye" <?php if($map_type === 'birdseye'){ echo 'selected';}?> > Bird's Eye </option>
                            <option value="canvasDark" <?php if($map_type === 'canvasDark'){ echo 'selected';}?>> Canvas Dark </option>
                            <option value="canvasLight" <?php if($map_type === 'canvasLight'){ echo 'selected';}?>> Canvas Light </option>                            
                            <option value="grayscale" <?php if($map_type === 'grayscale'){ echo 'selected';}?>> Grayscale </option>
                            <option value="street" <?php if($map_type === 'street'){ echo 'selected';}?>> Street </option>
                        </select>                        
                    </p> 

                    <p id="p_map_zoom">
                        <label for="map_zoom">Map Zoom: </label>
                        <input type='range'  min='3' max='20' name="map_zoom" id="map_zoom" value="<?php echo $map_zoom;?>"/> <span id='value_map_zoom'> </span>
                    </p>

                    <p id="p_map_width">
                        <label for="map_width"> Map Width: </label>
                        <input  id="map_width"  name="map_width" value="<?php if( $map_width==''){ print '100%';} else{ print $map_width;}?>" />
                        <span> &nbsp *** Can be of type: px, %, em, cm, mm, vh, vw, pt ***</span>
                    </p>
                    <p id="p_map_height">
                        <label for="map_height"> Map Height: </label>
                        <input name="map_height" id="map_height"  value="<?php if( $map_height==''){ print '350px';} else{ print $map_height;}?>" />
                        <span> &nbsp *** Can be of type: px, %, em, cm, mm, vh, vw, pt ***</span>
                    </p>
                    <p id="p_map_class">
                        <label for="map_class">HTML Attribute Class: </label>
                        <input type='text' id='map_class' name='map_class' value="<?php echo $map_class;?>" />
                    </p>

                    <p id="p_map_scroll">
                        <label for="map_scroll"> Disable Map Scroll: </label>
                        <input type="checkbox" id="map_scroll" name="map_scroll" <?php echo $map_scroll;?> />
                        
                    </p>
                    
                    <hr>

                    <p id='p_map_shortcode'>
                        <label for="map_shortcode">Short Code</label>
                        <input type='text' id='map_shortcode' value="[tuskcode-bing-map]"  readonly />
                        <span> &nbsp *** Copy and paste the short code inside any page body *** </span>
                    </p>

                    <p id='p_map_new_coordinates' >
                            <p> 
                            <input type='button' value='Add new Pin on Map' class='button button-primary' id='new_map_pin' /> 
                           <span id='info-new-pin'> *** Pin will be saved only if the address, or coordinates fields are not empty *** </span>  </p>  
                    </p>

                    <div id='new-block'>
                    <?php
                    
                        foreach( $map_pins as $key => $map_pin ){
                            ?>
                            
                            <div id='new-pin-container'>
                                      
                                <button class='delete' id='btn-delete-pin'> Delete Pin </button>  
                              
                                <div id='map_pins_address'>
                                    <p>
                                        <label for='map_pin_address'>  Pin Address: </label>
                                        <input type='text' name='map_pin_address[]' id='map_pin_address' value="<?php echo stripslashes($map_pin['address']);?>"  />
                                    </p>
                                    <p> 
                                        <label for="bing-input-latitude"> Latitude: </label>
                                        <input type='text' name='bing_input_latitude[]' id='bing-input-latitude' value="<?php echo $map_pin['lat'];?>"/>

                                        <label for='bing-input-longitude' id='bing-label-longitude'> Longitude: </label>
                                        <input type='text' name = 'bing_input_longitude[]' id='bing-input-longitude' value="<?php echo $map_pin['long'];?>" />
                                    </p>
                                   
                                        <p>
                                            <label for='map_pin_custom_pin_url'> Custom Pin URL: </label>
                                            <input type='text' name='map_pin_custom_url[]' id='map_pin_custom_pin_url' value="<?php echo $map_pin['url'];?>" />
                                            <?php 
                                                if( trim($map_pin['url']) !== '' ){
                                                    ?>
                                                    <img src="<?php
                                                        if( strpos( $map_pin['url'], 'custom-icons' ) > 0 ){
                                                            echo plugins_url('admin/', __FILE__).$map_pin['url'];
                                                        }else{
                                                            echo $map_pin['url'];
                                                        }                                                 
                                                    ?>" id='custom_pin_url_img' width='32px' height='32px' />    

                                                <?php
                                                }
                                            ?>
                                            <button id='bing-open-modal' class='button button-secondary'> Open Library </button>
                                    
                                        </p>
                                        
                                    </div>

                                    <div id='map_point_info'>   
                                        
                                        <label for='map_point_title'>Title:  </label> 
                                        <input type='text' id='map_point_title' name='map_point_title[]' value="<?php echo stripslashes($map_pin['title']); ?>" />

                                        <label for="map_point_description"> Description: </label> <br />
                                        <textarea rows='2' cols='20' id='map_point_description' name='map_point_description[]'><?php echo stripslashes(str_replace("bing_map_nl", "&#13;&#10;", $map_pin['desc']));?></textarea>
                                    </div>
                                
                               
                            </div>

                            <?php   
                        }
                        
                    ?>
                    </div>


                <!--- MODAL -->
                <div class="bing-main-modal show">
                    <div class="bing-second-modal">
                        <div id="bing-second-modal-search">
                            <p> <input type='text' id='bing-icon-search' name='bing-icon-search' />  SEARCH <span id='bing-close-modal'>
                                 <img src="<?php echo plugins_url('admin/images/icons/close-button.png', __FILE__);?>" id="bing-close-modal"  alt="close"> </span> 
                            <img src='#' id='bing-selected-icon' width='0' height='0' />
                            <input type="text" name="bing-icon-select" id="bing-icon-select" readonly /> 
                            <button id="bing-icon-select-btn" class='button button-secondary'> SELECT</button> </p>
                            
                        </div>
                        <div id="bing-icons-block">
                        <?php 
                            //   $files_dir = array_slice( scandir( ICONSDIR ), 2 );
                            //  $files_dir = glob( ICONSDIR.'/*');
                            $files_dir = simplexml_load_file( dirname(__FILE__).'/admin/images/icons.xml');
                           // print_r( $files_dir );

                           $custom_icon_url = 'admin/images/custom-icons/';
                            
                            $bing_icon_blocks = '';
                            foreach( $files_dir as $file ){ 
                                $filename = substr( $file, 0, sizeof( $file ) - 4 );                   
                                $bing_icon_blocks .= '<div id="bing-block-icon" data-title="'.$filename.'"  data-url="'.plugins_url($custom_icon_url.$file, __FILE__).'"
                                data-value="'.$file.'"> <img id="bing-custom-icon" src="'. plugins_url('admin/images/custom-icons/'.$file, __FILE__ ).'" title="'.$file.'"/>  </div>';
                            }
                            echo $bing_icon_blocks;

                        ?>
                        </div>
                    </div>
                </div>


                <!-- END OF MODAL -->


                    <p id="forgetUpdate"> <strong> *** Don't forget to save after making changes *** </strong> </p>
                    <input type="submit" id='submit-settings' name="submit_bing_map" class="button button-primary" value="Save Map Settings" >
                    

                </form>

                <?php
                        $display = "<div id='bing-admin-wrapper'> <div class='".get_option('bing_map_class', '')." bing-admin-map' id='adminMap'". 
                                " style='width: ".get_option('tuskcode_bing_map_width', '100%')."; height: ".get_option('tuskcode_bing_map_height', '350px')."'></div>";

                        echo $display;
                            
                        ?>
                            <form method='POST'>
                                <p> 
                                    <input type='button' value='Reset Center' id='reset-center-map' name='reset_center_map' class='button button-primary' />
                                    Latitude: <input type='text' name='bing_map_center_latitude' value ="<?php echo $map_center_lat;?>" id='bing-map-center-latitude' />
                                    Longitude: <input type='text'  name='bing_map_center_longitude' value="<?php echo $map_center_long;?>" id='bing-map-center-longitude'  />
                                    <input type='hidden' readonly name='bing_map_admin_hidden_zoom' value="<?php echo $map_zoom;?>" id='bing-map-admin-hidden-zoom' />
                                    Center Map: <input type='submit' id="bing-map-center-submit" class='button button-primary' name='bing_map_center_submit' value='Center ' /> </p>
                                    <p> *** Make sure you center the map based on the 'Map Zoom setting' - first set the map zoom then center it, as it may be confusing (do not set zoom (in/out) over the map when centering) *** </p>

                            </form>
                </div>


            </div>
           
      
            <script  src="<?php echo plugins_url('admin/js/main.js', __FILE__ );?>"></script>  
     

           <!-- //=================== map admin section ============================== -->
            <?php
                $icon_url = plugins_url('admin/images/icons/'.get_option('tuskcode_bing_map_pin', 'default.png'), __FILE__ );
    
                //get center of the map by finding the median for latitude and longitude;
                $med_lat = 0;
                $med_long = 0;

                //if lat is empty then find the center of the map with valid coordinates     
                $validLocation = 0;
                if( sizeof( $map_pins ) > 0){
                    foreach( $map_pins as $pin ){
                        $med_lat += doubleval( $pin['lat'] );
                        $med_long += doubleval( $pin['long'] ); 
                        
                        if( $pin['lat'] !== '' ){
                            $validLocation++;
                        }
                    }
                    if( $validLocation > 0){
                        $med_lat = $med_lat / $validLocation;
                        $med_long = $med_long / $validLocation;
                    }
                }
                ?>

            <script type='text/javascript'>
                var BingMapsKey = '<?php echo $map_api_key;?>';
    
		        var mapRequest = "https://www.bing.com/api/maps/mapcontrol?key="+ BingMapsKey + "&callback=loadMapScenario";
		
                var $bing_map = document.getElementById('adminMap');

                //check if bing map is loaded in this page
                if( $bing_map !== null ){
                    //get the address coordinates
                    CallRestService( mapRequest, loadMapScenario );	
                    console.log('active');
                }

                function CallRestService(request) {
                    
                    var script = document.createElement("script");
                    script.setAttribute("type", "text/javascript");
                    script.setAttribute("src", request);
                    document.body.appendChild(script);
                    
                }

                var infobox;

                function loadMapScenario() { 
                    //map types available: aerial, canvasDark, canvasLight, birdseye, street, grayscale
                    var mapAdmin = document.querySelector('#adminMap');
                    var mapSubmit = document.querySelector('#bing-map-center-submit');
                    var address_latitude;
                    var address_longitude;
                    <?php
                    if( $map_center_lat == '' ){         ?>
                        address_latitude = "<?php echo ($med_lat == 0) ? '35.493980' : strval( $med_lat);?>";
                        address_longitude ="<?php echo ($med_long == 0) ? '-78.044324' : strval( $med_long);?>"
                   <?php }else{ ?>
                        address_latitude = <?php echo strval($map_center_lat);?>;
                        address_longitude = <?php echo strval($map_center_long);?>;
                   <?php } ?>

                    console.log( address_latitude );
                    console.log( address_longitude );
        
                    var map = new Microsoft.Maps.Map( mapAdmin, { 
                            center: new Microsoft.Maps.Location( address_latitude, address_longitude), 
                            mapTypeId: Microsoft.Maps.MapTypeId.<?php echo $map_type;?>,
                            disableScrollWheelZoom: <?php echo ( $map_scroll == '') ? 'false' : 'true' ?>, 
                            zoom: <?php echo $map_zoom ?>,
                           // showZoomButtons: false,
                           // disableZooming: true,
                            showLocateMeButton: false,					                    
                    });

                    mapSubmit.addEventListener('click', function( event ){
                      //  event.preventDefault();
                        var mapCenterLatitude = document.querySelector('#bing-map-center-latitude');
                        var mapCenterLongitude = document.querySelector('#bing-map-center-longitude');
                        mapCenterLatitude.setAttribute('value', map.getCenter().latitude );
                        mapCenterLongitude.setAttribute('value', map.getCenter().longitude );
                        
                    })

                    var center = map.getCenter();

                    Microsoft.Maps.Events.addHandler(map, 'viewchangeend', function(e){
                        var zoomLevel = map.getZoom();
                        document.getElementById('map_zoom').value = zoomLevel;
                        document.getElementById('value_map_zoom').textContent = zoomLevel;
                        document.getElementById('bing-map-admin-hidden-zoom').value = zoomLevel;
                    //    console.log( map.getZoom() );

                    });

                    infobox = new Microsoft.Maps.Infobox( map.getCenter(), {
                            visible: false
                    });

                        infobox.setMap( map );

                        //add metadata for pin( title, and description)   
                        <?php 
                            foreach( $map_pins as $key=>$pin ){
                                $pin_title =    $pin['title'];
                                $pin_desc =     $pin['desc'];
                                $pin_lat =      $pin['lat'];
                                $pin_long =     $pin['long']; 
                                $pin_url =      $pin['url'];

                                if( empty( $pin_lat ) ){
                                    continue;
                                }
                            ?>
                            var customPin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location("<?php echo $pin_lat; ?>", "<?php echo $pin_long;?>"),{
                                <?php 
                                if( $pin_url !== '' ){
                                    if( strpos( $pin_url, 'custom-icons/') > 0 ){
                                        $pin_location = plugins_url( 'admin/'.$pin_url, __FILE__ );                                        
                                        echo 'icon:"'.$pin_location.'",';
                                    }else{
                                        echo 'icon: "'.$pin_url.'",';
                                    }                         
                                }else{
                                    if( strpos($icon_url, "default.png" ) === false ){
                                        echo 'icon: "'.$icon_url.'",';}
                                }?>     
                            });   

                            <?php
        
                            if( ( $pin_title !== '' ) && ( $pin_desc !== '' )){
                                ?>                    
                                customPin.metadata = {
                                    title: '<?php echo $pin_title;?>',
                                    description: '<?php echo str_replace( 'bing_map_nl', '<br/>', $pin_desc);?>'
                                };

                                
                            <?php
                            }
                            ?>
                            Microsoft.Maps.Events.addHandler( customPin, 'click', pushpinClicked );
                            map.entities.push( customPin );
                            <?php
                        }
                            ?>
                   
                }

                    function pushpinClicked(e) {
                        //Make sure the infobox has metadata to display.
                        if (e.target.metadata) {
                            //Set the infobox options with the metadata of the pushpin.
                            infobox.setOptions({
                                location: e.target.getLocation(),
                                title: e.target.metadata.title,
                                description: e.target.metadata.description,
                                visible: true
                            });
                        }
                    }  

            
        </script> 

    <!--    //============ end of map admin section =================================== -->
        <?php
    }
    


