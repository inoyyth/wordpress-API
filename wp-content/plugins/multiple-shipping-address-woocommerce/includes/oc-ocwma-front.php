<?php
if (!defined('ABSPATH'))
  exit;

if (!class_exists('OCWMA_front')) {

    class OCWMA_front {

        protected static $instance;


          function get_adress_book_endpoint_url( $address_book ) {
              $url = wc_get_endpoint_url( 'edit-address', 'shipping', get_permalink() );
              return add_query_arg( 'address-book', $address_book, $url );
          }

        
          function ocwma_wc_address_book_add_to_menu( $items ) {
              foreach ( $items as $key => $value ) {
                  if ( 'edit-address' === $key ) {
                      $items[ $key ] = __( 'Address Book', 'woo-address-book' );
                  }
              }
              return $items;
          }


          function ocwma_popup_div_footer() {
            global $ocwma_comman;
          ?>
              <div id="ocwma_billing_popup" class="ocwma_billing_popup_class">
              </div>
              <div id="ocwma_shipping_popup" class="ocwma_shipping_popup_class">
              </div>

              <?php
              $user_id  = get_current_user_id();
              global $wpdb;
              $tablename=$wpdb->prefix.'ocwma_billingadress';
              $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id);
              if($ocwma_comman['ocwma_enable_multiple_billing_adress'] == 'yes'){
              ?>
              <div id="address_selection_popup_main" class="address_selection_popup_main">
                <div class="billing_popup_header">
                  <h3><?php echo __('Choice Billing Address','multiple-shipping-address-woocommerce');?></h3>
                </div>
                <div class="address_selection_popup_inner">
                  <span class="ocwma_close_choice_section"><?php echo __('×','multiple-shipping-address-woocommerce');?></span>
                  <div class="address_selection_popup_body">
                    <?php
                      foreach($user as $row){  

                        $userdata_bil = $row->userdata;
                        $user_data = unserialize($userdata_bil);
                        /*echo "<pre>";
                        print($user_data['reference_field']);
                        echo "</pre>";*/
                        ?>
                        <div class="address_line">
                          <div class="address_line_inner">
                            <h5><?php echo $user_data['reference_field'];?></h5>
                            <ul>
                              <li><?php echo $user_data['billing_first_name'] .'&nbsp'.$user_data['billing_last_name'];?></li>
                              <li><?php echo $user_data['billing_company'];?></li>
                              <li><?php echo $user_data['billing_address_1'];?></li>
                              <li><?php echo $user_data['billing_address_2'];?></li>
                              <li><?php echo $user_data['billing_city'].'&nbsp'.$user_data['billing_postcode'];?></li>
                              <li><?php echo $user_data['billing_state'].', '.$user_data['billing_country'];?></li>
                            </ul>
                            <div class="address_select_button">
                              <a href="javascript:void(0)" class="choice_address" data-id="<?php echo $row->id; ?>"><?php echo __('Choice This Address','multiple-shipping-address-woocommerce');?></a>
                            </div>
                          </div>
                        </div>
                        <?php
                      }
                    ?>
                  </div>
                </div>
              </div>

              <?php 
              }    
              $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=".$user_id);
              if($ocwma_comman['ocwma_enable_multiple_shipping_adress'] == 'yes'){
              ?>
              <div class="shipping_address_selection_popup_main">
                <div class="shipping_popup_header">
                  <h3><?php echo __('Choice Billing Address','multiple-shipping-address-woocommerce');?></h3>
                </div>
                <div class="shipping_address_selection_popup_inner">
                  <span class="shipping_ocwma_close_choice_section">×</span>
                  <div class="shipping_address_selection_popup_body">
                    <?php
                       foreach($user as $row){   
                        
                        $userdata_bil=$row->userdata;
                        $user_data = unserialize($userdata_bil);

                        ?>
                        <div class="shipping_address_line">
                          <div class="shipping_address_line_inner">
                            <h5><?php echo $user_data['reference_field'];?></h5>
                            <ul>
                              <li><?php echo $user_data['shipping_first_name'] .'&nbsp'.$user_data['shipping_last_name'];?></li>
                              <li><?php echo $user_data['shipping_company'];?></li>
                              <li><?php echo $user_data['shipping_address_1'];?></li>
                              <li><?php echo $user_data['shipping_address_2'];?></li>
                              <li><?php echo $user_data['shipping_city'].'&nbsp'.$user_data['shipping_postcode'];?></li>
                              <li><?php echo $user_data['shipping_state'].', '.$user_data['shipping_country'];?></li>
                            </ul>
                            <div class="shipping_address_select_button">
                              <a href="javascript:void(0)" class="choice_shipping_address" data-id="<?php echo $row->id; ?>"><?php echo __('Choice This Address','multiple-shipping-address-woocommerce');?></a>
                            </div>
                          </div>
                        </div>
                        <?php
                      }
                    ?>
                  </div>
                </div>
              </div>
              <?php   
              }  
          }

              
          function ocwma_my_account_endpoint_content() {  
          $user_id = get_current_user_id();
          global $wpdb,$ocwma_comman;
          $tablename=$wpdb->prefix.'ocwma_billingadress';  
          $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id);
            echo '<div class="ocwmadefalte"></div>';
            echo '<div class="ocwma_table_custom">';
            if($ocwma_comman['ocwma_enable_multiple_billing_adress'] == 'yes'){
              echo '<div class="ocwma_table_bill">';
              if(!empty($user)){   
                foreach($user as $row){    
                  $userdata_bil=$row->userdata;
                  $defalt_addd=$row->Defalut;

                  $user_data = unserialize($userdata_bil);  
                  if($defalt_addd==1){
                    $checked = "checkeddd";
                  } else{
                    $checked = "";
                  }
                  ?>
                  <div class="billing_address">
                    <button class="defalut_address <?php echo $checked;?>"  data-value="<?php echo $defalt_addd;?>" data-add_id="<?php echo $row->id;?>"  data-type="billing"><?php echo __('DefalutAddress','multiple-shipping-address-woocommerce');?></button><button class="form_option_edit" data-id="<?php echo $user_id;?>"  data-eid-bil="<?php echo $row->id;?>"><?php echo __('edit','multiple-shipping-address-woocommerce');?></button>
                    <span class="delete_bill_address"><a href="?action=delete_ocma&did=<?php echo $row->id;?>"><?php echo __('Delete','multiple-shipping-address-woocommerce');?></a></span><br>
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
              }
              echo '</div>';
            }
            $user_shipping = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=".$user_id);
            if($ocwma_comman['ocwma_enable_multiple_shipping_adress'] == 'yes'){
              echo '<div class="ocwma_table_ship">';
              if(!empty($user_shipping)){
                foreach($user_shipping as $row){    
                  $userdata_ship=$row->userdata;
                  $defalt_addd=$row->Defalut;
                   if($defalt_addd==1){
                    $checked = "checkeddd";
                  } else{
                    $checked = "";
                  }
                  $user_data = unserialize($userdata_ship);  
                  ?>
                  <div class="shipping_address">
                    <button class="defalt_addd_shipping <?php echo $checked;?>"  data-value="<?php echo $defalt_addd;?>" data-add_id="<?php echo $row->id;?>"  data-type="shipping"><?php echo __('DefalutAddress','multiple-shipping-address-woocommerce');?></button><button class="form_option_ship_edit" data-id="<?php echo $user_id;?>"  data-eid-ship="<?php echo $row->id;?>"><?php echo __('edit','multiple-shipping-address-woocommerce');?></button>
                    <span class="delete_ship_address"><a href="?action=delete-ship&did-ship=<?php echo $row->id;?>"><?php echo __('Delete','multiple-shipping-address-woocommerce');?></a></span><br>
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
              }
              echo '</div>';  
            } 
            echo '</div>'; 
              
            ?>
            <div class="cus_menu">
              <?php
              if($ocwma_comman['ocwma_enable_multiple_billing_adress'] == 'yes'){
                ?>
                <div class="billling-button">
                  <button class="form_option_billing" data-id="<?php echo $user_id; ?>" style="background-color: <?php echo $ocwma_comman['ocwma_btn_bg_clr'];?>; color: <?php echo $ocwma_comman['ocwma_font_clr'];?>; padding: <?php echo $ocwma_comman['ocwma_btn_padding'];?>; font-size: <?php echo "15px" ?>;">Add Billing Address</button>
                </div>
                <?php
              }
              if($ocwma_comman['ocwma_enable_multiple_shipping_adress'] == 'yes'){
              ?>
                <div class="shipping-button">
                  <button class="form_option_shipping" data-id="<?php echo $user_id; ?>" style="background-color: <?php echo $ocwma_comman['ocwma_btn_bg_clr'];?>; color: <?php echo $ocwma_comman['ocwma_font_clr'];?>; padding: <?php echo $ocwma_comman['ocwma_btn_padding'];?>; font-size: <?php echo "15px" ?>;">Add Shipping Address</button>
                </div>
                <?php
              }
              ?>
            </div>
              <?php      
          }


          function ocwma_billing_popup_open() {

                  $user_id = sanitize_text_field($_REQUEST['popup_id_pro']);
                  $edit_id =sanitize_text_field( $_REQUEST['eid-bil']);
                
                    global $wpdb,$ocwma_comman;
                    $tablename=$wpdb->prefix.'ocwma_billingadress'; 
                    if(empty($edit_id)){

                    $user = $wpdb->get_results( "SELECT count(*) as count FROM {$tablename} WHERE type='billing'  AND userid=".$user_id );   
                    $save_adress=$user[0]->count;
                    $max_count= 3;
                      if($save_adress >= $max_count){
                        echo '<div class="ocwma_modal-content">';
                        echo '<span class="ocwma_close">&times;</span>';
                        echo "<h3 class='ocwma_border'>you can add maximum 3 addresses !</h3>";
                        echo '</div>';
                        echo '</div>';
                      }else{
                        echo '<div class="ocwma_modal-content">';
                        echo '<span class="ocwma_close">&times;</span>';
                        
                          $address_fields = wc()->countries->get_address_fields(get_user_meta(get_current_user_id(), 'billing_country', true));
                  		    
                          //echo '<pre>';
                          //print_r($address_fields);

                          ?>
                            <form method="post" id="oc_add_billing_form">
                                <div class="ocwma_woocommerce-address-fields">
                                    <div class="ocwma_woocommerce-address-fields_field-wrapper">
                                      <input type="hidden" name="type"  value="billing">
                                      <p class="form-row form-row-wide" id="reference_field" data-priority="30">
                                        <label for="reference_field" class="">
                                          <b><?php echo __('Reference Name:','multiple-shipping-address-woocommerce');?></b>
                                          <abbr class="required" title="required">*</abbr>
                                        </label>
                                        <span class="woocommerce-input-wrapper">
                                          <input type="text" class="input-text" name="reference_field" id="oc_refname">
                                        </span>
                                      </p>
                                        <?php
                                          foreach ($address_fields as $key => $field) {
                                            woocommerce_form_field($key, $field, wc_get_post_data_by_key($key));
                                          }
                                        ?>
                                    </div>
                                    <p>
                                     <button type="submit" name="add_billing" id="oc_add_billing_form_submit" class="button" value="ocwma_billpp_save_option"><?php echo __('Save Address','multiple-shipping-address-woocommerce');?></button>
                                    </p>
                                </div>
                            </form>
                          <?php    
                        echo '</div>';
                        echo '</div>';
                      }
                   }else{
                      // echo $edit_id;
                   	  ob_start();
                   	  ?>
                      <div class="ocwma_modal-content">
                      <span class="ocwma_close">&times;</span> 
                      <?php
                      $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id." AND id=".$edit_id);
                      $user_data = unserialize($user[0]->userdata);
                        $address_fields = wc()->countries->get_address_fields(get_user_meta(get_current_user_id(), 'billing_country', true));
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
                      </div>

                      <?php
                      $edit_html = ob_get_clean();

					$return_arr[] = array("html" => $edit_html);
					echo json_encode($return_arr);

                  }
              die();   
          }


          function ocwma_shipping_popup_open() {

            $user_id =sanitize_text_field( $_REQUEST['popup_id_pro']);
            $edit_id = sanitize_text_field($_REQUEST['eid-ship']);
            //echo $edit_id;
            global $wpdb,$ocwma_comman;
                $tablename=$wpdb->prefix.'ocwma_billingadress';
            if(empty($edit_id)){
              $user = $wpdb->get_results( "SELECT count(*) as count FROM {$tablename} WHERE type='shipping'  AND userid=".$user_id );
                  $save_adress=$user[0]->count;
                  $max_count= 3;
                  if($save_adress >= $max_count){
                    echo '<div class="ocwma_modal-content">';
                    echo '<span class="ocwma_close">&times;</span>';
                    echo "<h3 class='ocwma_border'>you can add maximum 3 addresses ! !</h3>";
                    echo '</div>';
                    echo '</div>';
                  }else{
                    echo '<div class="ocwma_modal-content">';
                    echo '<span class="ocwma_close">&times;</span>'; 
                      $countries = new WC_Countries();
                        if ( ! isset( $country ) ) {
                          $country = $countries->get_base_country();
                        }
                        if ( ! isset( $user_id ) ) {
                          $user_id = get_current_user_id();
                        }
                        $address_fields = WC()->countries->get_address_fields( $country, 'shipping_' );
                      ?>
                        <form method="post" id="oc_add_shipping_form">
                            <div class="ocwma_woocommerce-address-fields">
                                <div class="ocwma_woocommerce-address-fields_field-wrapper">
                                        <input type="hidden" name="type"  value="shipping">
                                        <p class="form-row form-row-wide" id="reference_field" data-priority="30">
	                                        <label for="reference_field" class="">
                                            <b><?php echo __('Reference Name:','multiple-shipping-address-woocommerce');?></b>
                                            <abbr class="required" title="required">*</abbr>
                                          </label>
	                                        <span class="woocommerce-input-wrapper">
	                                          <input type="text" class="input-text" id="oc_refname" name="reference_field">
	                                        </span>
                                      	</p>
                                      <?php
                                      foreach ($address_fields as $key => $field) {  
                                         woocommerce_form_field($key, $field, wc_get_post_data_by_key($key));         
                                      }
                                    ?>
                                </div>
                                <p>
                                 <button type="submit" name="add_shipping" id="oc_add_shipping_form_submit" class="button" value="ocwma_shippp_save_optionn"><?php echo __('Save Address','multiple-shipping-address-woocommerce');?></button>   
                                </p>
                            </div>
                        </form>
                      <?php    
                    echo '</div>';
                    echo '</div>'; 
                  }  
            }else{
              echo '<div class="ocwma_modal-content">';
              echo '<span class="ocwma_close">&times;</span>'; 
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
              echo '</div>';  
                  }       
            die();
          }

          /* billigdata */
          
          function ocwma_billing_data_select(){
            $user_id = get_current_user_id();
            $select_id = sanitize_text_field($_REQUEST['sid']);
            global $wpdb;
              $tablename=$wpdb->prefix.'ocwma_billingadress'; 
              $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id." AND id=".$select_id);
              $user_data = unserialize($user[0]->userdata);
             echo json_encode($user_data);
             exit();
          }

          /* shipping */
          
          function ocwma_shipping_data_select(){
            $user_id = get_current_user_id();
            $select_id = sanitize_text_field($_REQUEST['sid']);
            global $wpdb;
              $tablename=$wpdb->prefix.'ocwma_billingadress'; 
              $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=".$user_id." AND id=".$select_id);
              $user_data = unserialize($user[0]->userdata);
             echo json_encode($user_data);
             exit();
          }
      
      
          

        function OCWMA_all_billing_address(){
          $user_id  = get_current_user_id();
          global $wpdb,$ocwma_comman;
          $tablename=$wpdb->prefix.'ocwma_billingadress';
          if (is_user_logged_in()) {
            if($ocwma_comman['ocwma_enable_multiple_billing_adress'] == 'yes'){
              if($ocwma_comman['ocwma_select_address_type'] == 'Dropdown'){
                ?>
                <select class="ocwma_select">
                      <option>...Choose address...</option>
                        <?php
                          $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id);
                        foreach($user as $row){  

                          $userdata_bil=$row->userdata;
                          $user_data = unserialize($userdata_bil);
                          if($row->Defalut == 1){
                            $valid =  "selected";
                          }else{
                             $valid =  "";
                          }?> 
                          <option value="<?php echo $row->id ?>" <?php echo  $valid; ?>>  <?php echo $user_data['reference_field'] ?></option>
                        <?php } ?>
                </select>
                <button class="form_option_billing" data-id="<?php echo $user_id; ?>" style="background-color: <?php echo $ocwma_comman['ocwma_btn_bg_clr'];?>; color: <?php echo $ocwma_comman['ocwma_font_clr'];?>; padding: <?php echo $ocwma_comman['ocwma_btn_padding'];?>; font-size: <?php echo "15px" ?>;">Add Billing Address</button>

                <?php
              }elseif ($ocwma_comman['ocwma_select_address_type'] == 'Popup') {
                if($ocwma_comman['ocwma_select_popup_btn_style'] == 'button'){
                  ?>
                  <a href="javascript:void(0)" class="choice_bil_address"><?php echo __('Choice Billing Address','multiple-shipping-address-woocommerce');?></a>
                  <?php
                }
                if($ocwma_comman['ocwma_select_popup_btn_style'] == 'link'){
                  ?>
                  <a href="javascript:void(0)" id="choice_bil_address" class="choice_bil_address"><?php echo __('Choice Billing Address','multiple-shipping-address-woocommerce');?></a>
                  <?php
                }
              }
            }
          }
          
          
        }
        

        function   OCWMA_all_shipping_address(){
          $user_id  = get_current_user_id();
          global $wpdb,$ocwma_comman;
          $tablename=$wpdb->prefix.'ocwma_billingadress';  
          if (is_user_logged_in()) {
            if($ocwma_comman['ocwma_enable_multiple_shipping_adress'] == 'yes'){
              if($ocwma_comman['ocwma_select_shipping_address_type'] == 'Dropdown'){
                ?>
                 <select class="ocwma_select_shipping">
                  <option>...Choose address...</option>
                  <?php
                     $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=".$user_id);
                           foreach($user as $row){   
                             if($row->Defalut == 1){
                              $valid =  "selected";
                            }else{
                               $valid =  "";
                            }
                            $userdata_bil=$row->userdata;
                            $user_data = unserialize($userdata_bil);

                            ?> <option value="<?php echo $row->id ?>" <?php echo $valid; ?>>  <?php echo $user_data['reference_field'] ?></option><?php }
                            ?>
                  </select>
                  <button class="form_option_shipping" data-id="<?php echo $user_id; ?>" style="background-color: <?php echo $ocwma_comman['ocwma_btn_bg_clr'];?>; color: <?php echo $ocwma_comman['ocwma_font_clr'];?>; padding: <?php echo $ocwma_comman['ocwma_btn_padding'];?>; font-size: <?php echo "15px" ?>;">Add Shipping Address</button>
       
                <?php
              }elseif ($ocwma_comman['ocwma_select_shipping_address_type'] == 'Popup') {
                if($ocwma_comman['ocwma_shipping_select_popup_btn_style'] == 'button'){
                  ?>
                  <a href="javascript:void(0)" class="choice_sheep_address"><?php echo __('Choice shipping Address','multiple-shipping-address-woocommerce');?></a>
                  <?php
                }
                if($ocwma_comman['ocwma_shipping_select_popup_btn_style'] == 'link'){
                  ?>
                  <a href="javascript:void(0)" id="choice_sheep_address" class="choice_sheep_address"><?php echo __('Choice shipping Address','multiple-shipping-address-woocommerce');?></a>
                  <?php
                }
              }
            }
          }
        }

          function OCWMA_save_options(){
              global $wpdb; 
              $tablename=$wpdb->prefix.'ocwma_billingadress';
               
              if( isset($_REQUEST['action']) && $_REQUEST['action']=="delete_ocma"){
                  $delete_id=sanitize_text_field($_REQUEST['did']);
                  $sql = "DELETE  FROM {$tablename} WHERE id='".$delete_id."'" ;
                  $wpdb->query($sql);
                  wp_safe_redirect( wc_get_endpoint_url( 'edit-address', '', wc_get_page_permalink( 'myaccount' ) ) );
                  exit;
              }  
  
              if(isset($_REQUEST['action']) && $_REQUEST['action']=="delete-ship"){
                  $delete_id=sanitize_text_field($_REQUEST['did-ship']);
                  $sql = "DELETE  FROM {$tablename} WHERE id='".$delete_id."'" ;
                  
                  $wpdb->query($sql);
                  wp_safe_redirect( wc_get_endpoint_url( 'edit-address', '', wc_get_page_permalink( 'myaccount' ) ) );
                  exit;
              }             
          }


          function ocwma_validate_billing_form_fields_func() {
            global $wpdb; 
            $tablename=$wpdb->prefix.'ocwma_billingadress';
            
            $address_fields = wc()->countries->get_address_fields(get_user_meta(get_current_user_id(), 'billing_country', true));

            $ocwma_userid= get_current_user_id();

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
              $wpdb->insert($tablename, array(
                  'userid' =>$ocwma_userid,
                  'userdata' =>$billing_data_serlized,
                  'type' =>sanitize_text_field($_REQUEST['type']), 
              ));

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

          function ocwma_validate_shipping_form_fields_func() {

            global $wpdb; 

            $tablename=$wpdb->prefix.'ocwma_billingadress';
            $countries = new WC_Countries();
            $country = $countries->get_base_country();

            $address_fields = WC()->countries->get_address_fields( $country, 'shipping_' );

            $ocwma_userid= get_current_user_id();

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
              $wpdb->insert($tablename, array(
                  'userid' =>$ocwma_userid,
                  'userdata' =>$billing_data_serlized,
                  'type' =>sanitize_text_field($_REQUEST['type']), 
              ));

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


          function ocwma_validate_edit_billing_form_fields_func() {
            global $wpdb;
            $tablename = $wpdb->prefix.'ocwma_billingadress';

            $address_fields = wc()->countries->get_address_fields(get_user_meta(get_current_user_id(), 'billing_country', true));

            $edit_id = sanitize_text_field($_REQUEST['edit_id']);

            $ocwma_userid= get_current_user_id();

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


          function ocwma_validate_edit_shipping_form_fields_func() {
            global $wpdb; 
            $tablename=$wpdb->prefix.'ocwma_billingadress';
            
            $edit_id = sanitize_text_field($_REQUEST['edit_id']);

            $countries = new WC_Countries();
            $country = $countries->get_base_country();

            $address_fields = WC()->countries->get_address_fields( $country, 'shipping_' );

            $ocwma_userid= get_current_user_id();

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
          function ocwma_default_address(){

            global $wpdb; 

            $tablename=$wpdb->prefix.'ocwma_billingadress';

            $defaltadd_id = ($_REQUEST['defalteaddd_id']);
            $dealteadd_type = $_REQUEST['dealteadd_type'];
             $ocwma_userid= get_current_user_id();
           

               $condition=array(
                  'userid'=>$ocwma_userid,
                  'type'=>$dealteadd_type,
               );
              $wpdb->update( 
                $tablename, 
                array( 
                    'Defalut' => '0', 
                    
                ),$condition);

              $condition=array(
                  'id'=>$defaltadd_id,
                    'type'=>$dealteadd_type,
               );

              $wpdb->update( 
                $tablename, 
                array( 
                    'Defalut' => '1', 
                ),$condition);

             exit;
          }

          function ocwma_default_address_shipping(){

            global $wpdb; 

            $tablename=$wpdb->prefix.'ocwma_billingadress';

            $defaltadd_id = ($_REQUEST['defalteaddd_id']);
            $dealteadd_type = $_REQUEST['dealteadd_type'];
             $ocwma_userid= get_current_user_id();
           

               $condition=array(
                  'userid'=>$ocwma_userid,
                  'type'=>$dealteadd_type,
               );
              $wpdb->update( 
                $tablename, 
                array( 
                    'Defalut' => '0', 
                    
                ),$condition);

              $condition=array(
                  'id'=>$defaltadd_id,
                    'type'=>$dealteadd_type,
               );

              $wpdb->update( 
                $tablename, 
                array( 
                    'Defalut' => '1', 
                ),$condition);

             exit;
          }
          
          function ocwma_choice_address(){
            $user_id = get_current_user_id();
            $select_id = sanitize_text_field($_REQUEST['sid']);
            global $wpdb;
              $tablename=$wpdb->prefix.'ocwma_billingadress'; 
              $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id." AND id=".$select_id);
              $user_data = unserialize($user[0]->userdata);
             echo json_encode($user_data);
             exit();
          }


          function ocwma_choice_shipping_address(){
            $user_id = get_current_user_id();
            $select_id = sanitize_text_field($_REQUEST['sid']);
            global $wpdb;
              $tablename=$wpdb->prefix.'ocwma_billingadress'; 
              $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=".$user_id." AND id=".$select_id);
              $user_data = unserialize($user[0]->userdata);
             echo json_encode($user_data);
             exit();
          }

          
          function init() {
            global $wpdb,$ocwma_comman;
              $charset_collate = $wpdb->get_charset_collate();
              $tablename = $wpdb->prefix.'ocwma_billingadress'; 
              $sql = "CREATE TABLE $tablename (
                  id mediumint(9) NOT NULL AUTO_INCREMENT,
                  userid TEXT NOT NULL,
                  userdata TEXT NOT NULL,
                  type TEXT NOT NULL,
                  Defalut int  DEFAULT '0',
                  PRIMARY KEY (id)
              ) $charset_collate;";

              require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
              dbDelta( $sql );

              add_filter( 'woocommerce_account_menu_items', array( $this, 'ocwma_wc_address_book_add_to_menu' ),10);
              add_action( 'woocommerce_account_edit-address_endpoint',array( $this, 'ocwma_my_account_endpoint_content'));
              add_action('wp_footer', array( $this, 'ocwma_popup_div_footer' ));
              add_action('wp_ajax_productscommentsbilling', array( $this, 'ocwma_billing_popup_open' ));
              add_action('wp_ajax_nopriv_productscommentsbilling', array( $this, 'ocwma_billing_popup_open'));
              add_action('wp_ajax_productscommentsshipping', array( $this, 'ocwma_shipping_popup_open' ));
              add_action('wp_ajax_nopriv_productscommentsshipping', array( $this, 'ocwma_shipping_popup_open'));
              
              if ($ocwma_comman['ocwma_select_address_position'] == 'billing_before_form_data') {
                
                add_action('woocommerce_before_checkout_billing_form', array( $this, 'OCWMA_all_billing_address'));
              }elseif ($ocwma_comman['ocwma_select_address_position'] == 'billing_after_form_data'){

                add_action('woocommerce_after_checkout_billing_form', array( $this, 'OCWMA_all_billing_address'));
              }

              if ($ocwma_comman['ocwma_select_shipping_address_position'] == 'shipping_before_form_data') {
                
                add_action('woocommerce_before_checkout_shipping_form', array( $this, 'OCWMA_all_shipping_address'));
              }elseif ($ocwma_comman['ocwma_select_shipping_address_position'] == 'shipping_after_form_data'){

                add_action('woocommerce_after_checkout_shipping_form', array( $this, 'OCWMA_all_shipping_address'));
              }

              add_action('wp_ajax_productscommentsbilling_select', array( $this, 'ocwma_billing_data_select' ));
              add_action('wp_ajax_nopriv_productscommentsbilling_select', array( $this,'ocwma_billing_data_select'));
              add_action('wp_ajax_productscommentsshipping_select', array( $this, 'ocwma_shipping_data_select' ));
              add_action('wp_ajax_nopriv_productscommentsshipping_select', array( $this,'ocwma_shipping_data_select'));
              add_action('wp_ajax_ocwma_validate_billing_form_fields', array( $this, 'ocwma_validate_billing_form_fields_func' ));
              add_action('wp_ajax_nopriv_ocwma_validate_billing_form_fields', array( $this, 'ocwma_validate_billing_form_fields_func'));
              add_action('wp_ajax_ocwma_validate_shipping_form_fields', array( $this, 'ocwma_validate_shipping_form_fields_func' ));
              add_action('wp_ajax_nopriv_ocwma_validate_shipping_form_fields', array( $this, 'ocwma_validate_shipping_form_fields_func'));
              add_action('wp_ajax_ocwma_validate_edit_billing_form_fields', array( $this, 'ocwma_validate_edit_billing_form_fields_func' ));
              add_action('wp_ajax_nopriv_ocwma_validate_edit_billing_form_fields', array( $this, 'ocwma_validate_edit_billing_form_fields_func'));
              add_action('wp_ajax_ocwma_validate_edit_shipping_form_fields', array( $this, 'ocwma_validate_edit_shipping_form_fields_func' ));
              add_action('wp_ajax_nopriv_ocwma_validate_edit_shipping_form_fields', array( $this, 'ocwma_validate_edit_shipping_form_fields_func'));
              add_action('wp_ajax_ocwma_default_address', array( $this, 'ocwma_default_address' ));
              add_action('wp_ajax_nopriv_ocwma_default_address', array( $this, 'ocwma_default_address'));
              add_action('wp_ajax_ocwma_default_address_shipping', array( $this, 'ocwma_default_address_shipping' ));
              add_action('wp_ajax_nopriv_ocwma_default_address_shipping', array( $this, 'ocwma_default_address_shipping'));

              add_action('wp_ajax_ocwma_choice_address', array( $this, 'ocwma_choice_address' ));
              add_action('wp_ajax_nopriv_ocwma_choice_address', array( $this, 'ocwma_choice_address'));

              add_action('wp_ajax_ocwma_choice_shipping_address', array( $this, 'ocwma_choice_shipping_address' ));
              add_action('wp_ajax_nopriv_ocwma_choice_shipping_address', array( $this, 'ocwma_choice_shipping_address'));

              add_action( 'init',  array($this, 'OCWMA_save_options'));
          }
          

          public static function instance() {
            if (!isset(self::$instance)) {
                self::$instance = new self();
                self::$instance->init();
            }
            return self::$instance;
          } 
    }

 OCWMA_front::instance();
}