<?php

namespace Inoy_Rest_Api;
/*
Plugin Name: WP Inoy
Plugin URI:  https://revanishop.com
Description: how to extent WP RSET api from your custom plugin.
Version:     1.0
Author:      Inoy Yth
Author URI:  https://revanishop.com
License:     GPL2 etc
License URI: https://revanishop.com

Copyright YEAR PLUGIN_AUTHOR_NAME (email : your email address)
(Plugin Name) is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
(Plugin Name) is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with (Plugin Name). If not, see (http://link to your plugin license).
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

//Define constants.
define( 'REST_API_INOY_PLUGIN_VERSION', '1.0.0');
define( 'REST_API_INOY_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'REST_API_INOY_ROUTE', 'inoy-rest-api/v1/');

//Include the main class.
require plugin_dir_path( __FILE__ ) . 'includes/class-rest-api-inoy.php';

//Main instance of plugin.
function rest_inoy() {
	return Rest_Api_Inoy::get_instance();
}

//Global for backwards compability.
$GLOBALS['rest_inoy'] = rest_inoy();

