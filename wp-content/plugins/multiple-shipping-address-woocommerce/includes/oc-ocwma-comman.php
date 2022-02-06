<?php
if (!defined('ABSPATH'))
  exit;

if (!class_exists('OCWMA_comman')) {

    class OCWMA_comman {

        protected static $instance;

        public static function instance() {
            if (!isset(self::$instance)) {
                self::$instance = new self();
                self::$instance->init();
            }
             return self::$instance;
        }
         function init() {
            global $ocwma_comman;
            $optionget = array(
                'ocwma_enable_multiple_billing_adress' => 'yes',
                'ocwma_select_address_type' => 'Dropdown',
                'ocwma_select_address_position' => 'billing_before_form_data',
                'ocwma_enable_multiple_shipping_adress' => 'yes',
                'ocwma_select_shipping_address_type' => 'Dropdown',
                'ocwma_select_shipping_address_position' => 'shipping_before_form_data',
                'ocwma_font_clr' => '#ffffff',
                'ocwma_btn_bg_clr' => '#000000',
                'ocwma_btn_padding' => '8px 10px',
                'ocwma_select_popup_btn_style' => 'button',
                'ocwma_shipping_select_popup_btn_style' => 'button',
            );
           
            foreach ($optionget as $key_optionget => $value_optionget) {
               $ocwma_comman[$key_optionget] = get_option( $key_optionget,$value_optionget );
            }
        }
    }

    OCWMA_comman::instance();
}
?>