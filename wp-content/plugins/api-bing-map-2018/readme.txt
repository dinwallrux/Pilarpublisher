=== API Bing Map 2018 ===
Contributors: dan009
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=HH7J3U2U9YYQ2
Tags: bing map, bing maps, api bing map, map, maps, bing, 
Requires at least: 4.6
Tested up to: 5.0.3
Stable tag: 1.3.0
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Designed to create accesible maps from bing, with multiple options of pins, width, height, custom pins, and address.

== Description ==

API Bing Map 2018 is trying to prove that bing maps are reliable maps nowadays with plenty of options in the bag. 
This plugin comes with multiple pin location, coordinates, address, width, height, map zoom, custom pin url, HTML Class attribute, and map type.
In order to use this Plugin you need to register to bing website to get and API Key.
It can be added on the sidebars or footer with the widget option, or directly to a page body using the shortcode [tuskcode-bing-map]
For support or suggestions please email me at: developer@tuskcode.com

== Installation ==
1. Upload the plugin files to the `/wp-content/plugins/api_bing_map_2018` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Under the admin menu page 'API Bing Map 2018' you can configure the plugin.
4. In the 'API Bing Map 2018' page make sure to add API key from bing maps website, a link will be displayed beside the input.
5. After all the custom setting have been applied, grab the shortcode [tuskcode-bing-map] and place it in any of your pages body to display the map
6. To place it under the footer, or sidebar section, go under Appearance->widgets and grab the widget with the name 'API Bing Map 2018' and place it where you desire.
7. For support or suggestions please email me at: developer@tuskcode.com


== Frequently Asked Questions ==

= The map is not showing =
Make sure under the 'API Bing Map 2018' setting page you have a valid Bing API KEY from [here](https://www.bingmapsportal.com/), and address

= Address Suggestion is not working =
Address suggestion is only working for new pins, one at the time

= Center Map is not saved =
You should center your map after adding and saving all your pins.
Then center it to desired position ( zoom ) and press 'Center' button

= How to use a custom pin =
Find your custom pin online, copy the image address, make sure it ends with .png, .jpg etc and place in the setting page in the field 'Custom Pin URL'

= Can I set different sizes to my map =
Yes. Width and height can be specified with the dimensions specified in the settings page

= What is the 'HTML Attribute Class for? =
This field can be used to customise the map if you have CSS knowledge

= How can I have a pin with no address =
Simply find the coordinates of your location, and paste them in the fields - Latitude, and Longitude, leaving the address input empty

= Support =
For support or suggestions please email me at: developer@tuskcode.com

= Credits =
Custom icons are provided by https://mapicons.mapsmarker.com


== Screenshots ==

1. settings-page.png
2. widget-page-location.png

== Changelog ==

= 20-January-2019 =
* Fix mixed content 

= 11-September-2018 1.2.0 =
* Fixed map center 
* Added Reset map Center
* Added address suggestion for new pin

= 29-August-2018 1.1.8 =
* Added Latitude, Longitude attributes to new pins
* Center the map for desired location

= 10-August-2018 1.1.6 = 
* Added 600+ custom icons
* Modified new icon layout

= 02-July-2018 1.1.1 =
* Fix uninstall

=  02-July-2018 1.1.0 =
* Added option disable/enable map scroll

=  02-July-2018 - 1.0.4 =
* Fix https request 

= 1.0.3 =
* Fix - Get address coordinates only if the map is present in the page
* Fix - Async javascript request

= 1.0.2 =
* Fix - Show display default.png

= 1.0.1 =
* No changes made yet

== Upgrade Notice ==

= 1.0.3 =
* Simple fixes, no features added 

= 1.0.4 =
* Fix https request 

= 1.1.0 =
* Added option disable/enable map scroll

= 1.1.1 =
* Fix uninstall


== A brief Markdown Example ==

1. Multiple Pins
2. Custom width and height
3. Custom Pin image
4. HTML Class
5. Map Zoom
6. Map Type selection
7. Widget
8. Disable/Enable Scroll on map
9. Short Code [tuskcode-bing-map]
10. Added 600+ custom icons
11. Latitude and Longitude fields for new pins
12. Center map on desired location
13. Address Suggestion