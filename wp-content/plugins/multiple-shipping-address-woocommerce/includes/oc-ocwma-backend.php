<?php
if (!defined('ABSPATH'))
  exit;

if (!class_exists('OCWMA_admin_menu')) {
    class OCWMA_admin_menu {
        protected static $OCWMA_instance;

            function OCWMA_submenu_page() {
                add_menu_page( 'Multiple Address Option', 'Multiple Address Option', 'manage_options', 'multiple-address',array($this, 'OCWMA_callback'));
            }

            function OCWMA_callback() {
            global $ocwma_comman;
            ?>    
                <div class="wrap">
                    <h2><u><?php echo __('Multiple address setting','multiple-shipping-address-woocommerce');?></u></h2>
                    <?php if(isset($_REQUEST['message']) && $_REQUEST['message'] == 'success'){ ?>
                        <div class="notice notice-success is-dismissible"> 
                            <p><strong><?php echo __('Record updated successfully.','multiple-shipping-address-woocommerce');?></strong></p>
                        </div>
                    <?php } ?>
                </div>
                <div class="ocwma-container">
                    <form method="post" >
                      <?php wp_nonce_field( 'ocwma_nonce_action', 'ocwma_nonce_field' ); ?>   
                            <div class="ocwma_cover_div">
                                <table class="ocwma_data_table">
                                    <h2><?php echo __('Multiple Billing Address Setting','multiple-shipping-address-woocommerce');?></h2>
                                    <tr>
                                        <th><?php echo __('Enable Multiple Billing Address','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="checkbox" name="ocwma_comman[ocwma_enable_multiple_billing_adress]" class="ocwma_enable_multi_bill_adress" value="yes"<?php if($ocwma_comman['ocwma_enable_multiple_billing_adress'] == 'yes'){echo "checked";} ?>>
                                        </td>
                                    </tr>
                                    <tr class="billing_address_setting">
                                        <th><?php echo __('MAX Billing Address','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="number" name="ocwma_max_adress" class="regular-text" value="3" disabled>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                    <tr class="billing_address_setting">
                                        <th><?php echo __('Select Billing Address Type On Checkout Page','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select name="ocwma_comman[ocwma_select_address_type]" class="regular-text">
                                                <option value="Dropdown"<?php if($ocwma_comman['ocwma_select_address_type'] == 'Dropdown'){echo "selected";}?>><?php echo __('Dropdown','multiple-shipping-address-woocommerce');?></option>
                                                <option value="Popup"<?php if($ocwma_comman['ocwma_select_address_type'] == 'Popup'){echo "selected";}?>><?php echo __('Popup','multiple-shipping-address-woocommerce');?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="billing_address_setting">
                                        <th><?php echo __('Select Billing Address position Checkout Page','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select name="ocwma_comman[ocwma_select_address_position]" class="regular-text">
                                                <option value="billing_before_form_data"<?php if($ocwma_comman['ocwma_select_address_position'] == 'billing_before_form_data'){echo "selected";}?>><?php echo __('Before Billing Form Data','multiple-shipping-address-woocommerce');?></option>
                                                <option value="billing_after_form_data"<?php if($ocwma_comman['ocwma_select_address_position'] == 'billing_after_form_data'){echo "selected";}?>><?php echo __('After Billing Form Data','multiple-shipping-address-woocommerce');?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="billing_address_setting">
                                        <th><?php echo __('Select Billing Popup Button Style Checkout Page','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select name="ocwma_comman[ocwma_select_popup_btn_style]" class="regular-text">
                                                <option value="button"<?php if($ocwma_comman['ocwma_select_popup_btn_style'] == 'button'){echo "selected";}?>><?php echo __('Button','multiple-shipping-address-woocommerce');?></option>
                                                <option value="link"<?php if($ocwma_comman['ocwma_select_popup_btn_style'] == 'link'){echo "selected";}?>><?php echo __('Link','multiple-shipping-address-woocommerce');?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="billing_address_setting">
                                        <th><?php echo __('Button Title for Billing','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="text" class="regular-text" name="ocwma_head_title" value="Add Billing Address" disabled>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="ocwma_cover_div">
                                <table class="ocwma_data_table">
                                    <h2><?php echo __('Multiple Shipping Address Setting','multiple-shipping-address-woocommerce');?></h2>
                                    <tr>
                                        <th><?php echo __('Enable Multiple Shipping Address','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="checkbox" name="ocwma_comman[ocwma_enable_multiple_shipping_adress]" class="ocwma_enable_multi_ship_adress" value="yes"<?php if($ocwma_comman['ocwma_enable_multiple_shipping_adress'] == 'yes'){echo "checked";} ?>>
                                        </td>
                                    </tr>
                                    <tr class="shipping_address_setting">
                                        <th><?php echo __('MAX Shipping Address','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="number" name="ocwma_max_shipping_adress" class="regular-text" value="3" disabled>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                    <tr class="shipping_address_setting">
                                        <th><?php echo __('Select Shipping Address Type On Checkout Page','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select name="ocwma_comman[ocwma_select_shipping_address_type]" class="regular-text">
                                                <option value="Dropdown"<?php if($ocwma_comman['ocwma_select_shipping_address_type'] == 'Dropdown'){echo "selected";}?>><?php echo __('Dropdown','multiple-shipping-address-woocommerce');?></option>
                                                <option value="Popup"<?php if($ocwma_comman['ocwma_select_shipping_address_type'] == 'Popup'){echo "selected";}?>><?php echo __('Popup','multiple-shipping-address-woocommerce');?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="shipping_address_setting">
                                        <th><?php echo __('Select Shipping Address position Checkout Page','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select name="ocwma_comman[ocwma_select_shipping_address_position]" class="regular-text">
                                                <option value="shipping_before_form_data"<?php if($ocwma_comman['ocwma_select_shipping_address_position'] == 'shipping_before_form_data'){echo "selected";}?>><?php echo __('Before Shipping Form Data','multiple-shipping-address-woocommerce');?></option>
                                                <option value="shipping_after_form_data"<?php if($ocwma_comman['ocwma_select_shipping_address_position'] == 'shipping_after_form_data'){echo "selected";}?>><?php echo __('After Shipping Form Data','multiple-shipping-address-woocommerce');?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="shipping_address_setting">
                                        <th><?php echo __('Select Shipping Popup Button Style Checkout Page','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select name="ocwma_comman[ocwma_shipping_select_popup_btn_style]" class="regular-text">
                                                <option value="button"<?php if($ocwma_comman['ocwma_shipping_select_popup_btn_style'] == 'button'){echo "selected";}?>><?php echo __('Button','multiple-shipping-address-woocommerce');?></option>
                                                <option value="link"<?php if($ocwma_comman['ocwma_shipping_select_popup_btn_style'] == 'link'){echo "selected";}?>><?php echo __('Link','multiple-shipping-address-woocommerce');?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="shipping_address_setting">
                                        <th><?php echo __('Button Title for Shipping','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="text" class="regular-text" name="ocwma_head_title_ship" value="Add Shipping Address" disabled>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="ocwma_cover_div">
                                <table class="ocwma_data_table">
                                    <h2><?php echo __('Multiple Button Style','multiple-shipping-address-woocommerce');?></h2>
                                    <tr>
                                        <th><?php echo __('Font size','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="text" class="regular-text" name="ocwma_font_size" value="15" disabled>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo __('Font color','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="text" class="color-picker" data-alpha="true" name="ocwma_comman[ocwma_font_clr]" value="<?php echo $ocwma_comman['ocwma_font_clr'];?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo __('Background Color','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="text" class="color-picker" data-alpha="true" name="ocwma_comman[ocwma_btn_bg_clr]" value="<?php echo $ocwma_comman['ocwma_btn_bg_clr']; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo __('Button Padding','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="text" class="regular-text" name="ocwma_comman[ocwma_btn_padding]" value="<?php echo $ocwma_comman['ocwma_btn_padding'];?>">
                                            <span><?php echo __('give value in px(ex.6px 8px)','multiple-shipping-address-woocommerce');?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="ocwma_cover_div">
                                <table class="ocwma_data_table">
                                    <h2><?php echo __('User Role Selection Setting','multiple-shipping-address-woocommerce');?></h2>
                                    <tr>
                                        <th><?php echo __('User Role Selection Enable/Disable','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <input type="checkbox" name="ocwma_user_role_enable_disable" class="user_role_enable_disable" value="yes" disabled>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                    <tr class="user_role_setting">
                                        <th><?php echo __('User Role Selection','multiple-shipping-address-woocommerce');?></th>
                                        <td>
                                            <select id="wg_select_user_role" name="wg_roles_select[]" multiple="multiple" style="width:350px;" disabled>
                                                <?php 
                                                    $user_roles = get_option('wg_roles_select');
                                                    
                                                    if (!empty($user_roles)) {
                                                        foreach ($user_roles as $key => $value) {
                                                            $role_names = ( mb_strlen( $value ) > 50 ) ? mb_substr( $value, 0, 49 ) . '...' : $value;
                                                            ?>
                                                                <option value="<?php echo $value;?>" selected="selected"><?php echo $role_names;?></option>
                                                            <?php   
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <label class="ocwma_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/multiple-shipping-address-woocommerce-pro/" target="_blank">link</a></label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        <input type="hidden" name="action" value="ocwma_save_option">
                        <input type="submit" value="Save changes" name="submit" class="button-primary" id="wfc-btn-space">
                    </form>  
                </div>
            <?php
            }

            function ocwma_role_ajax(){
                global $wp_roles;
                $return = array();
                
                foreach( $wp_roles->role_names as $role => $name ) {
                    $return[] = array( $role, $name );
                }

                echo json_encode( $return );
                die;
            }

            function OCWMA_recursive_sanitize_text_field( $array ) {
                foreach ( $array as $key => &$value ) {
                    if ( is_array( $value ) ) {
                        $value = $this->OCWMA_recursive_sanitize_text_field($value);
                    }else{
                        $value = sanitize_text_field( $value );
                    }
                }
                return $array;
            
            }


            function yoursite_extra_user_profile_fields( $user ) {
                $user_data = $user->data;
                $user_id = $user_data->ID;
                global $wpdb;
                $tablename=$wpdb->prefix.'ocwma_billingadress';  
                $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id);
                if(!empty($user)){   
                    ?>
                    <div class="bil_ship_address_user">
                    <div class="bil_ship_address_user_inner">
                        <div class="billing_address_main_section">
                            <div class="billing_address_main_section_inner">
                                <h2>Billing Address</h2>
                                <?php
                                foreach($user as $row){    
                                  $userdata_bil=$row->userdata;

                                  $user_data = unserialize($userdata_bil);
                                  ?>
                                  <div class="billing_address">
                                    <button class="form_option_edit_admin" data-id="<?php echo $user_id;?>"  data-eid-bil="<?php echo $row->id;?>"><?php echo __('edit','multiple-shipping-address-woocommerce');?></button>
                                    <span class="delete_bill_address"><a href="?user_id=<?php echo $user_id;?>&action=delete_ocma_admin&did=<?php echo $row->id;?>"><?php echo __('Delete','multiple-shipping-address-woocommerce');?></a></span><br>
                                    <span class="billing_address_inner">
                                      <?php echo $user_data['reference_field']."<br>".
                                      $user_data['billing_first_name'] .'&nbsp'.$user_data['billing_last_name']."<br>".
                                      $user_data['billing_company']."<br>".
                                      $user_data['billing_address_1']."<br>".
                                      $user_data['billing_address_2']."<br>".
                                      $user_data['billing_city']." ".$user_data['billing_postcode']."<br>".
                                      $user_data['billing_state'].', '.$user_data['billing_country'];
                                      ?>
                                    </span>
                                  </div>
                                  <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                }
                $user_shipping = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=".$user_id);
                if(!empty($user_shipping)){
                    ?>
                        <div class="shipping_address_main_section">
                            <div class="shipping_address_main_section_inner">
                                <h2>Shipping Address</h2>
                                <?php
                                foreach($user_shipping as $row){    
                                  $userdata_ship=$row->userdata;
                                  $user_data = unserialize($userdata_ship);  
                                  ?>
                                  <div class="shipping_address">
                                    <button class="form_option_ship_edit_admin" data-id="<?php echo $user_id;?>"  data-eid-ship="<?php echo $row->id;?>"><?php echo __('edit','multiple-shipping-address-woocommerce');?></button>
                                    <span class="delete_ship_address"><a href="?user_id=<?php echo $user_id;?>&action=delete-ship&did-ship=<?php echo $row->id;?>"><?php echo __('Delete','multiple-shipping-address-woocommerce');?></a></span><br>
                                    <span class="shipping_address_inner">
                                      <?php echo $user_data['reference_field']."<br>".
                                      $user_data['shipping_first_name'] .'&nbsp'.$user_data['shipping_last_name']."<br>".
                                      $user_data['shipping_company']."<br>".
                                      $user_data['shipping_address_1']."<br>".
                                      $user_data['shipping_address_2']."<br>".
                                      $user_data['shipping_city']." ".$user_data['shipping_postcode']."<br>".
                                      $user_data['shipping_state'].', '.$user_data['shipping_country'];
                                      ?>
                                    </span>
                                  </div>
                                  <?php
                                } 
                                ?>
                            </div>
                        </div>
                    </div>
                    </div>
                    <?php     
                }
            }


            function my_admin_footer_function($data) {
                ?>
                <div id="ocwma_billing_popup_admin" class="ocwma_billing_popup_classadmin">
                </div>
                <div id="ocwma_shipping_popup_admin" class="ocwma_shipping_popup_classadmin">
                </div>
                <?php
            }
             

            function ocwma_billing_popup_open_admin() {

                $user_id = sanitize_text_field($_REQUEST['popup_id_pro_admin']);
                $edit_id =sanitize_text_field( $_REQUEST['eid-bil-admin']);
                
                    global $wpdb;
                    $tablename=$wpdb->prefix.'ocwma_billingadress'; 
                      // echo $edit_id;
                      ob_start();
                      ?>
                      <div class="ocwma_modal-content">
                      <span class="ocwma_close">&times;</span> 
                      <?php
                      $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id." AND id=".$edit_id);
                      $user_data = unserialize($user[0]->userdata);
                        $address_fields = wc()->countries->get_address_fields(get_user_meta($user_id, 'billing_country', true));
                      ?>
                          <form method="post" id="oc_edit_billing_form">
                              <div class="ocwma_woocommerce-address-fields">
                                  <div class="ocwma_woocommerce-address-fields_field-wrapper">
                                         <input type="hidden" name="userid"  value="<?php echo $user_id ?>">
                                         <input type="hidden" name="edit_id"  value= "<?php echo  $edit_id ?>">
                                         <input type="hidden" name="type"  value="billing">
                                         <p class="form-row form-row-wide" id="reference_field" data-priority="30">
                                            <label for="reference_field" class="">
                                            <b><?php echo __('Reference Name:','multiple-shipping-address-woocommerce');?></b>
                                            <abbr class="required" title="required">*</abbr>
                                          </label>
                                            <span class="woocommerce-input-wrapper">
                                              <input type="text" class="input-text" id="oc_refname" name="reference_field" value="<?php echo $user_data['reference_field'] ?>">
                                            </span>
                                          </p>
                                      <?php
                                        foreach ($address_fields as $key => $field) {  
                                            woocommerce_form_field($key, $field, $user_data[$key]);
                                        }
                                      ?>
                                  </div>
                                  <p>
                                   <button type="submit" name="add_billing_edit" id="oc_edit_billing_form_submit" class="button" value="ocwma_billpp_save_option"><?php echo __('Update Address','multiple-shipping-address-woocommerce');?></button>   
                                  </p>
                              </div>
                          </form>
                      </div>
                      <?php
                      $edit_html = ob_get_clean();

                    $return_arr[] = array("html" => $edit_html);
                    echo json_encode($return_arr);
              die();   
            }

            
            function ocwma_validate_edit_billing_form_fields_func() {
                global $wpdb;

                $user_id = $_REQUEST['userid'];
                $tablename = $wpdb->prefix.'ocwma_billingadress';

                $address_fields = wc()->countries->get_address_fields(get_user_meta($user_id, 'billing_country', true));

                $edit_id = sanitize_text_field($_REQUEST['edit_id']);

                $ocwma_userid= $user_id;

                $billing_data = array();
                $field_errors = array();

                $billing_data['reference_field'] = sanitize_text_field($_REQUEST['reference_field']);

                if($_REQUEST['reference_field'] == '') {
                  $field_errors['oc_refname'] = '1';
                }

                foreach ($address_fields as $key => $field) {
                  $billing_data[$key] = sanitize_text_field($_REQUEST[$key]);

                  if($_REQUEST[$key] == '') {
                    if($field['required'] == 1) {
                      $field_errors[$key] = '1';
                    }
                  }
                }

                unset($field_errors['billing_state']);

                if(empty($field_errors)) {
                  $billing_data_serlized=serialize( $billing_data );
                  $condition = array(
                                  'id'=>$edit_id,
                                  'userid' =>$ocwma_userid,
                                  'type' =>sanitize_text_field($_REQUEST['type'])
                                );

                  $wpdb->update($tablename, array( 
                        'userdata' =>$billing_data_serlized),$condition);

                  $added = 'true';
                } else {
                  $added  = 'false';
                }

                $return_arr = array(
                  "added" => $added,
                  "field_errors" => $field_errors
                );

                echo json_encode($return_arr);
                exit;
            }


            function ocwma_shipping_popup_open_admin() {
                global $wpdb;

                $user_id = sanitize_text_field( $_REQUEST['popup_id_pro_ship']);
                $edit_id = sanitize_text_field($_REQUEST['eid-ship-popup']);
                //echo $edit_id;
                $tablename=$wpdb->prefix.'ocwma_billingadress';
                echo '<div class="ocwma_modal-content_ship">';
              echo '<span class="ocwma_closeship">&times;</span>'; 
              $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=".$user_id." AND id=".$edit_id);
              $user_data = unserialize($user[0]->userdata);
              $countries = new WC_Countries();
                  if ( ! isset( $country ) ) {
                    $country = $countries->get_base_country();
                  }
                  if ( ! isset( $user_id ) ) {
                    $user_id = get_current_user_id();
                  }
                  $address_fields = WC()->countries->get_address_fields( $country, 'shipping_' );
                ?>
                  <form method="post" id="oc_edit_shipping_form">
                      <div class="ocwma_woocommerce-address-fields">
                          <div class="ocwma_woocommerce-address-fields_field-wrapper">
                                <input type="hidden" name="type"  value="shipping">
                                    <input type="hidden" name="userid"  value="<?php echo $user_id ?>">
                                  <input type="hidden" name="edit_id"  value= "<?php echo $edit_id ?>">
                                  <p class="form-row form-row-wide" id="reference_field" data-priority="30">
                                    <label for="reference_field" class="">
                                      <b><?php echo __('Reference Name:','multiple-shipping-address-woocommerce');?></b>
                                      <abbr class="required" title="required">*</abbr>
                                    </label>
                                    <span class="woocommerce-input-wrapper">
                                      <input type="text" class="input-text" id="oc_refname" name="reference_field" value="<?php echo $user_data['reference_field'] ?>">
                                    </span>
                                  </p>
                                <?php
                                foreach ($address_fields as $key => $field) { 
                                 woocommerce_form_field($key, $field, $user_data[$key]);
                                }
                              ?>
                          </div>
                          <p>
                           <button type="submit" name="add_shipping_edit" class="button" id="oc_edit_shipping_form_submit" value="ocwma_shippp_save_optionn"><?php echo __('Update Address','multiple-shipping-address-woocommerce');?></button>   
                          </p>
                      </div>
                  </form>
                <?php    
              echo '</div>';
                die();
            }

            function ocwma_validate_edit_shipping_form_fields_func() {
                global $wpdb; 
                $tablename=$wpdb->prefix.'ocwma_billingadress';
                
                $edit_id = sanitize_text_field($_REQUEST['edit_id']);

                $countries = new WC_Countries();
                $country = $countries->get_base_country();

                $address_fields = WC()->countries->get_address_fields( $country, 'shipping_' );

                $ocwma_userid = $_REQUEST['userid'];

                $billing_data = array();
                $field_errors = array();

                $billing_data['reference_field'] = sanitize_text_field($_REQUEST['reference_field']);

                if($_REQUEST['reference_field'] == '') {
                  $field_errors['oc_refname'] = '1';
                }

                foreach ($address_fields as $key => $field) {
                  $billing_data[$key] = sanitize_text_field($_REQUEST[$key]);

                  if($_REQUEST[$key] == '') {
                    if($field['required'] == 1) {
                      $field_errors[$key] = '1';
                    }
                  }
                }

                unset($field_errors['shipping_state']);

                if(empty($field_errors)) {
                  $billing_data_serlized=serialize( $billing_data );

                  $condition=array(
                      'id'=>$edit_id,
                      'userid' =>$ocwma_userid,
                      'type' =>sanitize_text_field($_REQUEST['type'])
                    );
                  $wpdb->update($tablename,array( 
                  'userdata' =>$billing_data_serlized),$condition);

                  $added = 'true';
                } else {
                  $added  = 'false';
                }

                $return_arr = array(
                  "added" => $added,
                  "field_errors" => $field_errors
                );

                echo json_encode($return_arr);
                exit;
            }

            
            function OCWMA_save_options(){
                global $wpdb;
                $tablename=$wpdb->prefix.'ocwma_billingadress';
                if( isset($_REQUEST['action']) && $_REQUEST['action']=="delete_ocma_admin"){
                    $delete_id = sanitize_text_field($_REQUEST['did']);
                    $sql = "DELETE  FROM {$tablename} WHERE id='".$delete_id."'" ;
                    $wpdb->query($sql);
                    wp_redirect( admin_url( '/user-edit.php?user_id='.$_REQUEST['user_id'] ) );
                    exit;
                }
                if(isset($_REQUEST['action']) && $_REQUEST['action']=="delete-ship"){
                    $delete_id=sanitize_text_field($_REQUEST['did-ship']);
                    $sql = "DELETE  FROM {$tablename} WHERE id='".$delete_id."'" ;
                    $wpdb->query($sql);
                    wp_redirect( admin_url( '/user-edit.php?user_id='.$_REQUEST['user_id'] ) );
                    exit;
                }     

                if( current_user_can('administrator') ) { 
                    if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ocwma_save_option'){
                        if(!isset( $_POST['ocwma_nonce_field'] ) || !wp_verify_nonce( $_POST['ocwma_nonce_field'], 'ocwma_nonce_action' ) ){
                            print 'Sorry, your nonce did not verify.';
                            exit;
                        }else{

                            $isecheckbox = array(
                                'ocwma_enable_multiple_billing_adress',
                                'ocwma_enable_multiple_shipping_adress',
                                'ocwma_user_role_enable_disable',
                            );

                            foreach ($isecheckbox as $key_isecheckbox => $value_isecheckbox) {
                                if(!isset($_REQUEST['ocwma_comman'][$value_isecheckbox])){
                                    $_REQUEST['ocwma_comman'][$value_isecheckbox] ='no';
                                }
                            }   

                            $wg_roles_select = $this->OCWMA_recursive_sanitize_text_field( $_REQUEST['wg_roles_select'] );
                            update_option('wg_roles_select', $wg_roles_select, 'yes');
                                                
                            //print_r($_REQUEST);
                            foreach ($_REQUEST['ocwma_comman'] as $key_ocwma_comman => $value_ocwma_comman) {
                               // echo $key_ocwma_comman;
                                update_option($key_ocwma_comman, sanitize_text_field($value_ocwma_comman), 'yes');
                            }
                        }

                    wp_redirect( admin_url( '/admin.php?page=multiple-address' ) );
                    exit;

                    }
                }
            }

            function init() {
                add_action( 'admin_menu',  array($this, 'OCWMA_submenu_page'));
                add_action( 'init',  array($this, 'OCWMA_save_options'));
                add_action( 'wp_ajax_nopriv_wg_roles_ajax',array($this, 'ocwma_role_ajax') );
                add_action( 'wp_ajax_wg_roles_ajax', array($this, 'ocwma_role_ajax') ); 
                
                add_action('admin_footer', array( $this, 'my_admin_footer_function'));

                add_action( 'show_user_profile', array($this, 'yoursite_extra_user_profile_fields'), 999 );
                add_action( 'edit_user_profile', array($this, 'yoursite_extra_user_profile_fields'), 999 );


                add_action('wp_ajax_productscommentsbilling_admin', array( $this, 'ocwma_billing_popup_open_admin' ));
                add_action('wp_ajax_nopriv_productscommentsbilling_admin', array( $this, 'ocwma_billing_popup_open_admin'));

                add_action('wp_ajax_ocwma_validate_edit_billing_form_fields', array( $this, 'ocwma_validate_edit_billing_form_fields_func' ));
                add_action('wp_ajax_nopriv_ocwma_validate_edit_billing_form_fields', array( $this, 'ocwma_validate_edit_billing_form_fields_func'));

                add_action('wp_ajax_productscommentsshipping_admin', array( $this, 'ocwma_shipping_popup_open_admin' ));
                add_action('wp_ajax_nopriv_productscommentsshipping_admin', array( $this, 'ocwma_shipping_popup_open_admin'));

                add_action('wp_ajax_ocwma_validate_edit_shipping_form_fields', array( $this, 'ocwma_validate_edit_shipping_form_fields_func' ));
                add_action('wp_ajax_nopriv_ocwma_validate_edit_shipping_form_fields', array( $this, 'ocwma_validate_edit_shipping_form_fields_func'));
            }

            public static function OCWMA_instance() {
                if (!isset(self::$OCWMA_instance)) {
                    self::$OCWMA_instance = new self();
                    self::$OCWMA_instance->init();
                }
            return self::$OCWMA_instance;
        }
    }

 OCWMA_admin_menu::OCWMA_instance();
}

