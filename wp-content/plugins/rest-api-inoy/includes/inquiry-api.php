<?php
function save_inquiry($request_data) {
    global $wpdb;
    $table = $wpdb->prefix . 'customer_inquiry';
    
    $param = $request_data->get_params();
    $result = array();
    $data = array(
        'name' => $param['name'],
        'email' => $param['email'],
        'phone' => $param['phone'],
        'type_works' => $param['type_works'],
        'starting_project' => $param['starting_project'],
        'budget' => $param['budget'],
        'location' => $param['location'],
        'contact_via' => $param['contact_via'],
        'datetime' => date('Y-m-d H:i:s')
    );

    $insert = $wpdb->insert($table, $data);
    if ($insert) {
        $result = array('status' => 200);
    } else {
        $result = array('status' => 500);
    }

    return json_encode($result);
}

add_action( 'rest_api_init', function () {
        register_rest_route( REST_API_INOY_ROUTE, '/inquiry', array(
        'methods' => 'POST',
        'callback' => 'save_inquiry',
        'permission_callback' => '__return_true'
    ) );
} );