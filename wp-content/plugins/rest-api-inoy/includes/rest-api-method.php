<?php

use JWT_Auth\Jwt_Auth_Public;

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/countview/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'posts_count_view',
        'permission_callback' => '__return_true'
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/big-banner/', array(
        'methods' => 'GET',
        'callback' => 'getBigBanner',
        'permission_callback' => '__return_true'
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/post-block/', array(
        'methods' => 'GET',
        'callback' => 'getPostBlock',
        'permission_callback' => '__return_true'
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/posts-popular/', array(
        'methods' => 'GET',
        'callback' => 'getPostPopular',
        'permission_callback' => '__return_true'
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/email-subscription', array(
    'methods' => 'POST',
    'callback' => 'saveEmailSubscription',
    'permission_callback' => '__return_true'
) );
} );

//get custom page from CPTUI
add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/custom-pages/', array(
        'methods' => 'GET',
        'callback' => 'getCustomPages',
        'permission_callback' => '__return_true'
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/custom-pages-detail/', array(
        'methods' => 'GET',
        'callback' => 'getCustomPagesDetail',
        'permission_callback' => '__return_true'
    ) );
} );

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/profile-picture/(?P<id>\d+)', array(
    'methods' => 'PUT',
    'callback' => 'update_profile_picture',
    'permission_callback' => '__return_true'
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/set-default-address/(?P<user_id>\d+)', array(
    'methods' => 'PUT',
    'callback' => 'update_default_address',
    'permission_callback' => '__return_true'
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/province/', array(
    'methods' => 'GET',
    'callback' => 'get_province',
    'permission_callback' => '__return_true'
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/city/(?P<province_id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_city',
    'permission_callback' => '__return_true'
    ));
});

add_action( 'rest_api_init', function () {
    register_rest_route( REST_API_INOY_ROUTE, '/district/(?P<city_id>[\d\D][\w\W]+)', array(
    'methods' => 'GET',
    'callback' => 'get_district',
    'permission_callback' => '__return_true'
    ));
});

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

function update_profile_picture($request_data) {
    global $wpdb;
    $table = $wpdb->prefix . 'usermeta';
    
    $params = $request_data->get_params();
    $body = $request_data->get_json_params();
    $image = $body['image_url'];
    $user_id = $params['id'];
    $result = array();
   
    $data = array(
        'full' => $image,
        '500' => str_replace('/upload/', '/upload/c_scale,h_500,w_500/', $image),
        '192' => str_replace('/upload/', '/upload/c_scale,h_192,w_192/', $image),
        '96' => str_replace('/upload/', '/upload/c_scale,h_96,w_96/', $image),
        '250' => str_replace('/upload/', '/upload/c_scale,h_250,w_250/', $image),
        '24' => str_replace('/upload/', '/upload/c_scale,h_24,w_24/', $image),
        '48' => str_replace('/upload/', '/upload/c_scale,h_48,w_48/', $image),
    );
    
    $update = $wpdb->update(
        $table, 
        array('meta_value'=>serialize($data)), 
        array('user_id' => $user_id, 'meta_key' => 'wp_user_avatars')
    );

    if ($update) {
        $result = array('status' => 200, 'data' => str_replace('/upload/', '/upload/c_scale,h_96,w_96/', $image));
    } else {
        $result = array('status' => 500);
    }

    return new WP_REST_Response($result, 200);
}

function arraySliceInclude($data, $position, $inserted) {
    array_splice( $data, $position, 0, $inserted );
    return $data;
}

function update_default_address(WP_REST_Request $request) {
    global $wpdb;
    $table = $wpdb->prefix . 'usermeta';
    $params = $request->get_json_params();
    foreach($params as $k=>$v) {
        $data_update = array('meta_value' => $v);
        $data_where = array('user_id' => $request['user_id'], 'meta_key' => $k);
        $query = $wpdb->update($table, $data_update, $data_where);
    }
    
    return new WP_REST_Response(['message' => 'success'], 200);
}

function get_province() {
    global $wpdb;
    $table = $wpdb->prefix . 'wilayah_2020';
    $query = $wpdb->get_results("SELECT kode,nama FROM {$table} WHERE CHAR_LENGTH(kode)=2 ORDER BY nama ASC");
    $result = array();

    return new WP_REST_Response(array('code'=>200, 'data' => $query), 200);
}

function get_city(WP_REST_Request $request) {
    global $wpdb;
    $province_id = $request['province_id'];
    $table = $wpdb->prefix . 'wilayah_2020';
    $query = $wpdb->get_results("SELECT kode,nama FROM {$table} WHERE LEFT(kode,2)={$province_id} AND CHAR_LENGTH(kode)=5 ORDER BY nama ASC");
    $result = array();
    
    return new WP_REST_Response(array('code'=>200, 'data' => $query), 200);
}

function get_district(WP_REST_Request $request) {
    global $wpdb;
    $city_id = $request['city_id'];
    $table = $wpdb->prefix . 'wilayah_2020';
    $query = $wpdb->get_results("SELECT kode,nama FROM {$table} WHERE LEFT(kode,5)={$city_id} AND CHAR_LENGTH(kode)=13 ORDER BY nama");
    $result = array();
    
    return new WP_REST_Response(array('code'=>200, 'data' => $query), 200);
}