jQuery(document).ready(function(){

	jQuery('#wg_select_user_role').select2({

        ajax: {
                url: OCWMAscript_admin.ajaxurl,
                dataType: 'json',
                delay: true,
                data: function (params) {
                    return {
                        q: params.term,
                        action: 'wg_roles_ajax'
                    };
                },
                processResults: function( data ) {
                var options = [];
                if ( data ) {
 
                    jQuery.each( data, function( index, text ) {
                        options.push( { id: text[0], text: text[1],'price': text[2]} );
                    });
 
                }
                return {
                    results: options
                };
            },
            cache: true
        },
        minimumInputLength: 0
    });


    //billing address popup
    jQuery('body').on('click','.form_option_edit_admin',function(){
        
        jQuery('body').addClass("ocwma_billing_popup_body_admin");
        jQuery('body').append('<div class="ocwqv_loading_admin"><img src="'+ OCWMAscript_admin.objectname +'/images/loader.gif" class="ocwqv_loader_admin"></div>');
        var loading = jQuery('.ocwqv_loading_admin');
        loading.show();

        var id = jQuery(this).data("id");
        var eid = jQuery(this).data("eid-bil");
        var current = jQuery(this);
        jQuery.ajax({
            url: OCWMAscript_admin.ajaxurl,
            type:'POST',
            data:'action=productscommentsbilling_admin&popup_id_pro_admin='+id+'&eid-bil-admin='+eid,
            dataType: 'JSON',
            success : function(response) {
                var loading = jQuery('.ocwqv_loading_admin');
                var html = response[0].html;
                loading.remove();
                jQuery("#ocwma_billing_popup_admin").fadeIn(300);
                jQuery("#ocwma_billing_popup_admin").html(html);
                jQuery( '#billing_country' ).trigger( 'change' );
                jQuery( '#billing_state' ).trigger( 'change' );
            },
            error: function() {
                alert('Error occured');
            }
        });
       return false; 
    });

    
    jQuery(document).on('click','.ocwma_close',function(){
        jQuery("#ocwma_billing_popup_admin").fadeOut(300);
        jQuery('body').removeClass("ocwma_billing_popup_body_admin");
    });

    jQuery('body').on('click','#oc_edit_billing_form_submit',function() {
        jQuery('#oc_edit_billing_form').attr('onsubmit','return false;');
        jQuery('#oc_edit_billing_form input').removeClass('ocwma_inerror');
        jQuery('#oc_edit_billing_form select').removeClass('ocwma_inerror');

        jQuery.ajax({
            url: OCWMAscript_admin.ajaxurl,
            type:'POST',
            data: jQuery('#oc_edit_billing_form').serialize() + "&action=ocwma_validate_edit_billing_form_fields",
            dataType: 'JSON',
            success : function(response) {
                var added = response['added'];
                var field_errors = response.field_errors;
                
                if( added == 'false' ) {
                    jQuery.each(field_errors, function(i, item) {
                        jQuery("#oc_edit_billing_form #"+i).addClass('ocwma_inerror');
                    });
                } else {
                    location.reload();
                }
            },
            error: function() {
                alert('Error occured');
            }
        });
    });



    jQuery('body').on('click','.form_option_ship_edit_admin',function(){
        jQuery('body').addClass("ocwma_shipping_popup_body_admin");
        jQuery('body').append('<div class="ocma_loading_ship"><img src="'+ OCWMAscript_admin.objectname +'/images/loader.gif" class="ocma_loader"></div>');
        var loading = jQuery('.ocma_loading_ship');
        loading.show();
        var id = jQuery(this).data("id");
        var eid = jQuery(this).data("eid-ship");
        var current = jQuery(this);
        jQuery.ajax({
            url: OCWMAscript_admin.ajaxurl,
            type:'POST',
            data:'action=productscommentsshipping_admin&popup_id_pro_ship='+id+'&eid-ship-popup='+eid,
            success : function(response) {
                var loading = jQuery('.ocma_loading_ship');
                loading.remove(); 
                jQuery( "#ocwma_shipping_popup_admin" ).fadeIn(300);
                jQuery( "#ocwma_shipping_popup_admin" ).html(response);
                jQuery( '#shipping_country' ).trigger( 'change' );
                jQuery( '#shipping_state' ).trigger( 'change' );
            },
            error: function() {
                alert('Error occured');
            }
        });
       return false; 
    });

    jQuery(document).on('click','.ocwma_closeship',function(){
        jQuery("#ocwma_shipping_popup_admin").fadeOut(300);
        jQuery('body').removeClass("ocwma_shipping_popup_body_admin");
    });


    jQuery('body').on('click','#oc_edit_shipping_form_submit',function() {
        jQuery('#oc_edit_shipping_form').attr('onsubmit','return false;');
        jQuery('#oc_edit_shipping_form input').removeClass('ocwma_inerror');
        jQuery('#oc_edit_shipping_form select').removeClass('ocwma_inerror');

        jQuery.ajax({
            url: OCWMAscript_admin.ajaxurl,
            type:'POST',
            data: jQuery('#oc_edit_shipping_form').serialize() + "&action=ocwma_validate_edit_shipping_form_fields",
            dataType: 'JSON',
            success : function(response) {
                var added = response['added'];
                var field_errors = response.field_errors;
                
                if( added == 'false' ) {
                    jQuery.each(field_errors, function(i, item) {
                        jQuery("#oc_edit_shipping_form #"+i).addClass('ocwma_inerror');
                    });
                } else {
                    //location.reload();
                }
            },
            error: function() {
                alert('Error occured');
            }
        });
    });


    var modal = document.getElementById("ocwma_billing_popup_admin");
    var modal2 = document.getElementById("ocwma_shipping_popup_admin");
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
        jQuery('body').removeClass("ocwma_billing_popup_body_admin");
      }
      if (event.target == modal2) {
        modal2.style.display = "none";
        jQuery('body').removeClass("ocwma_shipping_popup_body_admin");
      }
    }
    
});