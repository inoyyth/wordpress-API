<?php
function get_menu(WP_REST_Request $request) {
    # Change 'menu' to your own navigation slug.
    $slug = $request['slug'];
    
    return wp_get_nav_menu_items($slug);
}

add_action( 'rest_api_init', function () {
        register_rest_route( REST_API_INOY_ROUTE, '/menu', array(
        'methods' => 'GET',
        'callback' => 'get_menu',
        'permission_callback' => '__return_true'
    ) );
} );