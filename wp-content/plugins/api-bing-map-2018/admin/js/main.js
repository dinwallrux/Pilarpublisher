    "use strict";
    
   // bing_

    var $select = document.querySelector('#map_pin');
    var $option = null;
    var $map_pin = document.querySelector('#p_map_pin_img');
    var $url = [];
    var $value_map_zoom = document.querySelector('#value_map_zoom');
    var $input_map_zoom = document.querySelector('#map_zoom');
    var $btn_delete_pin = document.querySelectorAll('#btn-delete-pin');
    var custom_input_opened = false;
    var custom_input_opened_obj;
    var idCounter = 0;
    
    for( var i = 0; i < $btn_delete_pin.length; i++ ){
        $btn_delete_pin[i].addEventListener('click', function(e){
            e.preventDefault();                           
            var child_title, child_desc, child_address, btn_parent, btn_submit, point_info, map_pins_address, 
            
            btn_parent = this.parentElement;
            
            
            child_title = btn_parent.querySelector('#map_point_title').setAttribute('value', '');
            child_desc = btn_parent.querySelector('#map_point_description');
            child_desc.setAttribute('value', '');
            child_desc.textContent = '';
            child_address = btn_parent.querySelector('#map_pin_address').setAttribute('value', ''); 
            btn_parent.querySelector('#bing-input-latitude').setAttribute('value', '');


            document.querySelector('#submit-settings').click();                                                 
            
        })
    }

    $value_map_zoom.textContent = $input_map_zoom.value;
    $value_map_zoom.style.fontWeight = '700';

    $input_map_zoom.addEventListener('input', function(){
        $value_map_zoom.textContent = this.value;                         
    });

    $input_map_zoom.addEventListener('change', function(){
        $value_map_zoom.textContent = this.value;          
    });
    

    $select.addEventListener('change', function(){
        $option = this.options[this.selectedIndex].value;
        $url = $map_pin.src.split('/');
        $url.pop();
        $url.push( $option );
        $map_pin.src = $url.join( '/' );
    });


    //adding a pinpin
    var new_pin;

    new_pin = document.querySelector('#new_map_pin');

    new_pin.addEventListener('click', function(){

        var div_new_block, div_map_point_info;
        var div_coordinates, div_info, lbl_latitude, input_latitude, lbl_longitude, input_longitude;

        var div_point_info, info_title_lbl, info_title_input, info_desc_lbl, info_desc_txtarea, horRule;
        var p_new_pin;
        var pin_input_address, lbl_address;
        var lbl_custom_pin, input_custom_pin_url;
        var btn_delete, para_pin_url, para_pin_address, btn_open_library, bing_input_custom_pin,
        bing_input_custom_pin;
        var btn_reset_center_map;

        //----corrdinates setup -------------------
        var  bing_p_coordinates, bing_label_latitude, bing_input_latitude, bing_label_longitude, bing_input_longitude;

        bing_p_coordinates = document.createElement('p');
        bing_p_coordinates.id = 'bing-p-coordinates';

        bing_label_latitude = document.createElement('label');
        bing_label_latitude.setAttribute('for', 'bing-input-latitude');
        bing_label_latitude.textContent = 'Latitude: ';
        
        bing_input_latitude = document.createElement('input');
        bing_input_latitude.id = 'bing-input-latitude';
        bing_input_latitude.type = 'text';
        bing_input_latitude.name = 'bing_input_latitude[]';

        bing_label_longitude = document.createElement('label');
        bing_label_longitude.setAttribute('for', 'bing-input-longitude');
        bing_label_longitude.setAttribute('id', 'bing-label-longitude');
        bing_label_longitude.textContent = 'Longitude: ';

        bing_input_longitude = document.createElement('input');
        bing_input_longitude.id = 'bing-input-longitude';
        bing_input_longitude.type = 'text';
        bing_input_longitude.name = 'bing_input_longitude[]';

        bing_p_coordinates.appendChild( bing_label_latitude );
        bing_p_coordinates.appendChild( bing_input_latitude );

        bing_p_coordinates.appendChild( bing_label_longitude );
        bing_p_coordinates.appendChild( bing_input_longitude );

        //end of coordinates setup


        div_new_block = document.querySelector('#new-block');
        
        p_new_pin = document.createElement('p');
        p_new_pin.style.fontWeight = 800;
        p_new_pin.textContent = 'New Pin';
        

        div_coordinates = document.createElement('div');
        div_coordinates.id = 'map_coordinates';

        pin_input_address = document.createElement('input');
        pin_input_address.id = 'map_pin_address';
        pin_input_address.name = 'map_pin_address[]';
        pin_input_address.type = 'text';
        //  pin_input_address.required = 'required';

        lbl_address = document.createElement('label');
        lbl_address.setAttribute('for', 'map_pin_address');
        lbl_address.textContent = 'Pin Address: ';

        para_pin_address = document.createElement('p');
        para_pin_address.id = 'searchBoxContainer'
        para_pin_address.appendChild( lbl_address);
        para_pin_address.appendChild( pin_input_address );    


        lbl_custom_pin = document.createElement('label');
        lbl_custom_pin.textContent = 'Custom Pin URL: ';
        lbl_custom_pin.setAttribute('for', 'map_pin_custom_url');

        input_custom_pin_url = document.createElement('input');
        input_custom_pin_url.id= 'map_pin_custom_url';
        input_custom_pin_url.name = 'map_pin_custom_url[]';
        input_custom_pin_url.type = 'text';

        btn_open_library = document.createElement('button'); //click event is at the button where the modal is set
        btn_open_library.setAttribute('class', 'button button-secondary');
        btn_open_library.id = 'bing-open-modal';
        btn_open_library.textContent = 'Open Library'

        para_pin_url = document.createElement('p');
        para_pin_url.appendChild( lbl_custom_pin );
        para_pin_url.appendChild( input_custom_pin_url );
        para_pin_url.appendChild( btn_open_library );

        //map point info block 
        div_point_info = document.createElement('div');
        div_point_info.id = 'map_point_info';

        //pin title
        info_title_lbl = document.createElement('label');
        info_title_lbl.setAttribute('for','map_point_title');
        info_title_lbl.textContent = 'Title: ';

        info_title_input = document.createElement('input');
        info_title_input.type = 'text';
        info_title_input.id = 'map_point_title';
        info_title_input.name = 'map_point_title[]';
        //------- end of title -------

        //pin description
        info_desc_lbl = document.createElement('label');
        info_desc_lbl.setAttribute('for', 'map_point_description');
        info_desc_lbl.textContent = 'Description: ';

        info_desc_txtarea = document.createElement('textarea');
        info_desc_txtarea.rows = '3';
        info_desc_txtarea.cols = '20';
        info_desc_txtarea.id = 'map_point_description';
        info_desc_txtarea.name = 'map_point_description[]';

        btn_delete = document.createElement('button');  
        btn_delete.class='delete';
        btn_delete.id='btn-delete-pin';
        btn_delete.textContent = 'Delete Pin';;

        // ------- end of description -----------
        // ---- end of map point info ----

        //add points to div
        div_coordinates.appendChild( p_new_pin );

        div_coordinates.appendChild( btn_delete );
        div_coordinates.appendChild( para_pin_address );
        div_coordinates.appendChild( bing_p_coordinates );

        //  div_coordinates.appendChild( lbl_custom_pin );
        div_coordinates.appendChild( para_pin_url );
        
            
        div_point_info.appendChild( info_title_lbl );
        div_point_info.appendChild( info_title_input );
        div_point_info.appendChild( info_desc_lbl );
        div_point_info.appendChild( info_desc_txtarea );
        //-----------------------------------------

        //add horizontal rule before each pin created;
        //   horRule = document.createElement('hr');
        var pin_block = document.createElement('div');
        pin_block.id = 'pin_block';
                                
        // pin_block.appendChild( horRule );
        
        pin_block.appendChild( div_coordinates );
        pin_block.appendChild( div_point_info );
      
        
        
        div_new_block.insertBefore( pin_block, div_new_block.firstChild );

        btn_open_library.addEventListener( 'click', function (e){
            e.preventDefault();
            bing_main_modal.style.display = 'block';    
            bing_icon_search.focus();

            custom_input_opened = true;
            custom_input_opened_obj = input_custom_pin_url;

        });

        var bingMapKey = document.querySelector('#map_key').value;
        var mapSuggestReq = 'https://www.bing.com/api/maps/mapcontrol?key='+bingMapKey+'&callback=loadMapSuggestAddress';	
        
        CallRestService( mapSuggestReq, loadMapSuggestAddress );
        //----------- add suggest address to input ----------------
      


        // ========== end of suggest address to input ======================
        /*
        btn_bing_icon_select.addEventListener('click', function(e){
            e.preventDefault();
            var sel_img = input_bing_icon_select.value.trim()
            if( sel_img !== '' ){
                 sel_img = 'images/custom-icons/' + sel_img;
                 input_custom_pin_url.setAttribute('value', sel_img );
                
                bing_main_modal.style.display = 'none'; 
               // bing_close_modal.click();
                
            }
            
        });
        */
        
    });

//=====================================================================================================
        /* javascript for modal */

        var open_modal, bing_main_modal, bing_icon_search, bing_icons_block, all_icon_blocks,
        bing_close_modal, input_bing_icon_select, input_open_library;
        var bing_input_custom_pin, btn_bing_icon_select, img_bing_selected_icon;

    
        open_modal = document.querySelectorAll('#bing-open-modal');
        bing_main_modal = document.querySelector('.bing-main-modal');
        bing_icon_search = document.querySelector('#bing-icon-search');
        bing_icons_block = document.querySelector('#bing-icons-block');
        all_icon_blocks = document.querySelectorAll('#bing-block-icon');
        input_bing_icon_select = document.querySelector('#bing-icon-select');
        bing_close_modal = document.querySelector('#bing-close-modal');
        btn_bing_icon_select = document.querySelector('#bing-icon-select-btn');
        img_bing_selected_icon = document.querySelector('#bing-selected-icon');

        //add event listener for icon click
        for( var j = 0; j < all_icon_blocks.length; j++ ){
            all_icon_blocks[j].addEventListener('click', function(){
                input_bing_icon_select.value = this.getAttribute('data-value');
                img_bing_selected_icon.src = this.getAttribute('data-url');
                img_bing_selected_icon.style.width = '32px';
                img_bing_selected_icon.style.height = '37px';
            })
        }
    
        btn_bing_icon_select.addEventListener('click', function(e){
            e.preventDefault();
            var sel_img = input_bing_icon_select.value.trim();
            var icon_selected;
            if( sel_img !== '' ){
                 sel_img = 'images/custom-icons/' + sel_img;
                if(custom_input_opened == true ){
                    custom_input_opened_obj.setAttribute('value', sel_img );
                }else{
                    bing_input_custom_pin.setAttribute('value', sel_img );
                    icon_selected = bing_input_custom_pin.parentElement;
                    icon_selected = icon_selected.querySelector('#custom_pin_url_img');

                    if(icon_selected !== null ){
                        icon_selected.src = img_bing_selected_icon.src;
                    }
                }
                
                bing_main_modal.style.display = 'none'; 
                bing_close_modal.click();
                
            }
            
        });
      
        var btn_reset_center_map = document.getElementById('reset-center-map');
        btn_reset_center_map.addEventListener('click', function(e){
            e.preventDefault();
            document.getElementById('bing-map-center-latitude').value = '';
            document.getElementById('bing-map-center-longitude').value = '';
            document.getElementById('bing-map-center-submit').click();
        })
    
        //close modal
        bing_close_modal.addEventListener('click', function(e){            
            bing_main_modal.style.display = 'none';   
        });
    
        for( var k = 0; k < open_modal.length; k++ ){
            open_modal[k].addEventListener('click', function( e ){
                e.preventDefault();
                bing_main_modal.style.display = 'block';    
                bing_icon_search.focus();
    
                var pin_parent = this.parentElement;
                bing_input_custom_pin = pin_parent.querySelector('#map_pin_custom_pin_url');
                custom_input_opened = false;
            });
        }
    
        window.addEventListener('click', function( event ){
            if(event.target == bing_main_modal){
                bing_main_modal.style.display = 'none';
            }               
        });
    
        bing_icon_search.addEventListener('keyup', function(){                
            var data_title = '';
            var search_value = this.value;
            
            for( var i = 0; i < all_icon_blocks.length; i++ ){
                data_title = all_icon_blocks[i].getAttribute('data-title');
                if( data_title.indexOf( search_value ) < 0 ){
                    all_icon_blocks[i].style.display = 'none';
                }else{
                    all_icon_blocks[i].style.display = 'inline-block';
                }
            }                       
        });

/* pin slider show and hide */
/* end of script for modal */

/* address suggest script */
        function loadMapSuggestAddress() {
            Microsoft.Maps.loadModule('Microsoft.Maps.AutoSuggest', {
                callback: onLoad,
                errorCallback: onError
            });
    

            function onLoad() {
                var options = { maxResults: 5 };
                var manager = new Microsoft.Maps.AutosuggestManager(options);
                var aElement = document.getElementById('map_pin_address');
                manager.attachAutosuggest( aElement , aElement.parentElement );
                idCounter++;
            }
            function onError(message) {
                document.getElementById('info-new-pin').innerHTML = message;
            }
          
        }
        
         function CallRestService(request) {
                
                var script = document.createElement("script");
                script.setAttribute("type", "text/javascript");
                script.setAttribute("src", request);
                document.body.appendChild(script);
                
        }
/*
        document.addEventListener('click', function(e){
            
            var actElement = document.activeElement;
            var bingMapKey = document.querySelector('#map_key').value;
            if( actElement.id === 'map_pin_address' && actElement.type === 'text' ){
             //   alert('test');
                var mapSuggestReq = 'https://www.bing.com/api/maps/mapcontrol?key='+bingMapKey+'&callback=loadMapSuggestAddress';	
               // alert( mapSuggestReq );	
                CallRestService( mapSuggestReq, loadMapSuggestAddress );
                actElement.focus();
            }
            e.preventDefault();
        });
*/

/* end of address suggest */