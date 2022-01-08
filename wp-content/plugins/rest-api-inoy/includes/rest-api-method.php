<?php

use JWT_Auth\Jwt_Auth_Public;

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/countview/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'posts_count_view',
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/big-banner/', array(
        'methods' => 'GET',
        'callback' => 'getBigBanner',
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/post-block/', array(
        'methods' => 'GET',
        'callback' => 'getPostBlock',
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/posts-popular/', array(
        'methods' => 'GET',
        'callback' => 'getPostPopular',
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/email-subscription', array(
    'methods' => 'POST',
    'callback' => 'saveEmailSubscription',
) );
} );

//get custom page from CPTUI
add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/custom-pages/', array(
        'methods' => 'GET',
        'callback' => 'getCustomPages',
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/custom-pages-detail/', array(
        'methods' => 'GET',
        'callback' => 'getCustomPagesDetail',
    ) );
} );

function posts_count_view( $data ) : \WP_REST_Response {
    $post = get_post( $data['id'] );

    if ( empty( $post ) ) {
        return new WP_Error( 'posts_count_view', 'Invalid post', array( 'status' => 404 ) );
    }

    // Now update the ACF field (or whatever you wish)
    $count = (int) get_field('views', $post->ID);
    $count++;
    update_field('views', $count, $post->ID);

    return new WP_REST_Response($count);
}

function getBigBanner(WP_REST_Request $request)  {
    $params = $request->get_params();
    $slug =  isset($params['slug']) ?  $params['slug'] : 'homepage';
    $term = get_term_by('slug', $slug, 'bigbanner');
    $banner_meta = get_term_meta( $term->term_id, 'banner', true);
    $banner = $banner_meta ? esc_url( wp_get_attachment_url($banner_meta, 'large', false, false)) : '';
    $data = [
        'id' => $term->term_id,
        'name' => $term->name,
        'slug' => $term->slug,
        'image' => $banner
    ];

    return new WP_REST_Response($data);
}

function getPostBlock(WP_REST_Request $request) {
    $params = $request->get_params();
    $slug =  isset($params['slug']) ? $params['slug'] : 'homepage-top';
    $posts = get_posts(
        array(
            'posts_per_page' => 3,
            'post_type' => 'page',
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_block',
                    'field' => 'slug',
                    'terms' => $slug,
                )
            ),
            'orderby' => 'post_date',
            'order'   => 'DESC',
        )
    );

    $response = [];
    $controller = new WP_REST_Posts_Controller('post');

    foreach ($posts as $post) {
        $data = $controller->prepare_item_for_response($post,$request);
        $response[] = $controller->prepare_response_for_collection($data);
    }

    return new WP_REST_Response($response, 200);
}

function getPostPopular(WP_REST_Request $request)  {
    $footer_popular_length = 3;
    $args['meta_key'] = 'views';
    $args['posts_per_page']  = $footer_popular_length;
    $args['orderby'] = 'meta_value_num';
    $args['order']  = 'DESC';
    
    $get_post = get_posts($args);
    $get_rest_post = [];
    if (count($get_post) < $footer_popular_length) {
        $rest_lenght = $footer_popular_length - count($get_post);
        unset($args['meta_key']);
        unset($args['orderby']);
        $args['posts_per_page']  = $rest_lenght;
        $args['orderby'] = 'date';
        $get_rest_post = get_posts($args);
    }

    $posts = array_merge($get_post, $get_rest_post);
    
    $response = [];
    $controller = new WP_REST_Posts_Controller('post');

    foreach ($posts as $post) {
        $data = $controller->prepare_item_for_response($post,$request);
        $response[] = $controller->prepare_response_for_collection($data);
    }

    return new WP_REST_Response($response, 200);
}

function saveEmailSubscription(WP_REST_Request $request)  {
    global $wpdb;
    $table = $wpdb->prefix . 'email_queue';
    
    $param = $request->get_params();
    $result = array();
  
    $exists_email = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}email_queue WHERE email='".$param['email']."'", OBJECT );
    // var_dump($exists_email->id);die;
    if ($exists_email->id) {
        $result = array('status' => 200);
    } else {
        $data = array(
            'email' => $param['email'],
            // 'cc' => '',
            // 'bcc' => '',
            'message' => '',
            'status' => 'pending',
            'date' => $param['date'],
            // 'headers' => ''
        );
        $insert = $wpdb->insert($table, $data);
        if ($insert) {
            $result = array('status' => 200);
        } else {
            $result = array('status' => 500);
        }
    }

    return json_encode($result);
}

function getCustomPages(WP_REST_Request $request) {
    // try {
    //     $jwt = new Jwt_Auth_Public('jwt', 'v1');
    //     $user = $jwt->validate_token(true);
    //     if (isset($user->errors)) {
    //     $error = array(
    //             'jwt_auth_bad_request',
    //             'User ID not found in the token',
    //             array(
    //                 'status' => 403,
    //             )
    //         );

    //         return new WP_REST_Response($error, 403);
    //     } 
    // } catch(Exception $e) {
    //     return new WP_REST_Response($e, 500);
    // }
    $params = $request->get_params();
    $page_type =  isset($params['page_type']) ? $params['page_type'] : 'page';
    $per_page =  isset($params['per_page']) ? $params['per_page'] : 10;
    $posts = get_posts(
        array(
            'posts_per_page' => $per_page,
            'post_type' => $page_type,
            // 'tax_query' => array(
            //     array(
            //         'taxonomy' => 'post_block',
            //         'field' => 'slug',
            //         'terms' => $slug,
            //     )
            // ),
            'orderby' => 'post_date',
            'order'   => 'DESC',
        )
    );

    $response = [];
    $controller = new WP_REST_Posts_Controller('post');

    foreach ($posts as $post) {
        $data = $controller->prepare_item_for_response($post,$request);
        $response[] = $controller->prepare_response_for_collection($data);
    }

    return new WP_REST_Response($response, 200);
}

function getCustomPagesDetail(WP_REST_Request $request) {
    $params = $request->get_params();
    $page_type =  isset($params['page_type']) ? $params['page_type'] : 'page';
    $id =  isset($params['id']) ? $params['id'] : 1;
    $posts = get_posts(
        array(
            'post_type' => $page_type,
            'post__in' => array($id),
            'orderby' => 'post_date',
            'order'   => 'DESC',
        )
    );

    $response = [];
    $controller = new WP_REST_Posts_Controller('post');

    foreach ($posts as $post) {
        $data = $controller->prepare_item_for_response($post,$request);
        $response[] = $controller->prepare_response_for_collection($data);
    }

    return new WP_REST_Response($response, 200);
}