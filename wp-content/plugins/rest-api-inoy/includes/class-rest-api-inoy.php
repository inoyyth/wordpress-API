<?php
namespace Inoy_Rest_Api;
/**
* Main class.
*
* @package Rest_Api_Inoy
*/
class Rest_Api_Inoy {
    /**
     * Returns the instance.
     */

    
     
    public static function get_instance() {
        static $instance = null;
        if ( is_null( $instance ) ) {
            $instance = new self();
        }
        return $instance;
    }
    /**
     * Constructor method.
     */
    private function __construct() {
        $this->includes();
    }
    // Includes
    public function includes() {
        // $version = $this->version;?        include_once REST_API_INOY_PLUGIN_DIR . '/includes/rest-api-field.php';
        include_once REST_API_INOY_PLUGIN_DIR . '/includes/rest-api-post.php';
        include_once REST_API_INOY_PLUGIN_DIR . '/includes/rest-api-field.php';
        include_once REST_API_INOY_PLUGIN_DIR . '/includes/rest-api-method.php';
        include_once REST_API_INOY_PLUGIN_DIR . '/includes/menus-api.php';
        include_once REST_API_INOY_PLUGIN_DIR . '/includes/inquiry-api.php';
    }
}