<?php
/**
 * Plugin Name: Multiple Shipping Address Woocommerce
 * Description: This plugin allows create to users multiple address.
 * Version: 1.0
 * Author: Ocean Infotech
 * Author URI: https://www.xeeshop.com
 * Copyright: 2019 
 */
if (!defined('ABSPATH')) {
  die('-1');
}
if (!defined('OCWMA_PLUGIN_NAME')) {
  define('OCWMA_PLUGIN_NAME', 'Woo Call Price');
}
if (!defined('OCWMA_PLUGIN_VERSION')) {
  define('OCWMA_PLUGIN_VERSION', '1.0.0');
}
if (!defined('OCWMA_PLUGIN_FILE')) {
  define('OCWMA_PLUGIN_FILE', __FILE__);
}
if (!defined('OCWMA_PLUGIN_DIR')) {
  define('OCWMA_PLUGIN_DIR',plugins_url('', __FILE__));
}
if (!defined('OCWMA_DOMAIN')) {
  define('OCWMA_DOMAIN', 'multiple-shipping-address-woocommerce');
}
if (!defined('OCWMA_BASE_NAME')) {
define('OCWMA_BASE_NAME', plugin_basename(OCWMA_PLUGIN_FILE));
}

//Main class  
if (!class_exists('OCWMA')) {

  class OCWMA {

    protected static $OCWMA_instance;
           /**
       * Constructor.
       *
       * @version 3.2.3
       */
    //Load required js,css and other files
    function __construct() {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        //check plugin activted or not
        add_action('admin_init', array($this, 'OCWMA_check_plugin_state'));
    }

    //Add JS and CSS on Backend
    function OCWMA_load_admin_script_style() {
      wp_enqueue_style( 'OCWMA_admin_css', OCWMA_PLUGIN_DIR . '/css/admin_style.css', false, '1.0.0' );
      wp_enqueue_style( 'wp-color-picker' );
      wp_enqueue_script( 'wp-color-picker-alpha', OCWMA_PLUGIN_DIR . '/js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), '1.0.0', true );
      wp_enqueue_script( 'OCWMA_admin_js',OCWMA_PLUGIN_DIR . '/js/admin.js', array( 'jquery', 'select2') );
      wp_localize_script( 'ajaxloadpost', 'ajax_postajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

      $translation_arrayimg = OCWMA_PLUGIN_DIR;
      wp_localize_script( 'OCWMA_admin_js', 'OCWMAscript_admin', 
                array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'objectname' => $translation_arrayimg,
                )
      );
      
      wp_enqueue_style( 'woocommerce_admin_styles-css', WP_PLUGIN_URL. '/woocommerce/assets/css/admin.css',false,'1.0',"all");
    }

    function OCWMA_load_script_style() {
      wp_enqueue_style( 'OCWMA_front_css',OCWMA_PLUGIN_DIR . '/css/style.css', false, '1.0.0' );
      wp_enqueue_script( 'OCWMA_front_js',OCWMA_PLUGIN_DIR . '/js/front.js', array("jquery"), '1.0.0' );
      

      $translation_array_img = OCWMA_PLUGIN_DIR;
      wp_localize_script( 'OCWMA_front_js', 'OCWMAscript', 
                array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'object_name' => $translation_array_img,
                )
      );
    }

    function OCWMA_show_notice() {

        if ( get_transient( get_current_user_id() . 'ocwmaerror' ) ) {

          deactivate_plugins( plugin_basename( __FILE__ ) );

          delete_transient( get_current_user_id() . 'ocwmaerror' );

          echo '<div class="error"><p> This plugin is deactivated because it require <a href="plugin-install.php?tab=search&s=woocommerce">WooCommerce</a> plugin installed and activated.</p></div>';

        }
    }


    function OCWMA_check_plugin_state(){
      if ( ! ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) ) {
        set_transient( get_current_user_id() . 'ocwmaerror', 'message' );
      }
    }


    function init() {
      add_action('admin_notices', array($this, 'OCWMA_show_notice'));
      add_action('admin_enqueue_scripts', array($this, 'OCWMA_load_admin_script_style'));
      add_action('wp_enqueue_scripts',  array($this, 'OCWMA_load_script_style'));
      add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
    }

    function plugin_row_meta( $links, $file ) {
        if (OCWMA_BASE_NAME === $file ) {
            $row_meta = array(
                'rating'    =>  '<a href="#" target="_blank">Documentation</a> | <a href="https://www.xeeshop.com/support-us/?utm_source=aj_plugin&utm_medium=plugin_support&utm_campaign=aj_support&utm_content=aj_wordpress" target="_blank">Support</a> | <a href="https://wordpress.org/support/plugin/multiple-shipping-address-woocommerce/reviews/?filter=5" target="_blank"><img src="'.OCWMA_PLUGIN_DIR.'/images/star.png" class="OCWMA_rating_div"></a>',
            );

            return array_merge( $links, $row_meta );
        }

        return (array) $links;
    }


    //Load all includes files
    function includes() {
      //Add Option backend on product page
      include_once('includes/oc-ocwma-comman.php');
      //Admn site Layout
      include_once('includes/oc-ocwma-backend.php');
      include_once('includes/oc-ocwma-kit.php');
      //Custom Functions
      include_once('includes/oc-ocwma-front.php');


    }


    //Plugin Rating
    public static function OCWMA_do_activation() {
      set_transient('ocwma-first-rating', true, MONTH_IN_SECONDS);
    }


    public static function OCWMA_instance() {
      if (!isset(self::$OCWMA_instance)) {
        self::$OCWMA_instance = new self();
        self::$OCWMA_instance->init();
        self::$OCWMA_instance->includes();
      }
      return self::$OCWMA_instance;
    }
  }
  add_action('plugins_loaded', array('OCWMA', 'OCWMA_instance'));

  register_activation_hook(OCWMA_PLUGIN_FILE, array('OCWMA', 'OCWMA_do_activation'));
}