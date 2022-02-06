<?php

add_filter( 'rest_allow_anonymous_comments', '__return_true' );

remove_filter('the_excerpt', 'wpautop');

add_action( 'rest_api_init', 'register_post_fields' );
// Register post fields.
function register_post_fields() {
    register_rest_field('post', 'post_views', array(
        'get_callback' => 'get_post_views',
        'update_callback' => 'update_post_views',
        'schema' => array(
            'description' => __( 'Post views.' ),
            'type'        => 'integer'
    ),
    ) );
}

register_rest_field( 'user', 'user_email',
    array(
        'get_callback'    => function ( $user ) {
            $account = get_user_by('id', $user['id']);
            return $account->data->user_email;
        },
        'update_callback' => null,
        'schema'          => null,
    )
);

register_rest_field( 'user', 'birth_date',
    array(
        'get_callback'    => 'getUserMeta',
        'update_callback' => 'setUserMeta',
        'schema' => array(
            'description' => 'The birth date of the user.',
            'type' => 'string',
            'context' => array('view', 'edit')
        )
    )
);

register_rest_field( 'user', 'phone_number',
    array(
        'get_callback'    => 'getUserMeta',
        'update_callback' => 'setUserMeta',
        'schema' => array(
            'description' => 'The phone number of the user.',
            'type' => 'string',
            'context' => array('view', 'edit')
        )
    )
);

register_rest_field( 'user', 'phone_number',
    array(
        'get_callback'    => 'getUserMeta',
        'update_callback' => 'setUserMeta',
        'schema' => array(
            'description' => 'The phone number of the user.',
            'type' => 'string',
            'context' => array('view', 'edit')
        )
    )
);

register_rest_field( 'user', 'gender',
    array(
        'get_callback'    => 'getUserMeta',
        'update_callback' => 'setUserMeta',
        'schema' => array(
            'description' => 'The gender of the user.',
            'type' => 'string',
            'context' => array('view', 'edit')
        )
    )
);

//Get post views
function get_post_views($post_obj) {
    $post_id = $post_obj['id'];
    return get_post_meta($post_id, 'views', true);
}

// Update post views
function update_post_views( $value, $post, $key ) {
    $post_id = update_post_meta( $post->ID, $key, $value );

    if ( false === $post_id ) {
        return new WP_Error(
          'rest_post_views_failed',
          __( 'Failed to update post views.' ),
          array( 'status' => 500 )
        );
    }

    return true;
}

function getUserMeta($user, $field_name, $request) {
    global $wpdb;
    $table = $wpdb->prefix . 'usermeta';
    $id = $user['id'];
    $meta_value = $wpdb->get_var( "SELECT meta_value FROM $table WHERE user_id = $id AND meta_key = '$field_name'" );
    if ($field_name === 'birth_date') {
        return date('Y-m-d', strtotime($meta_value));
    }
    return $meta_value;
}

function setUserMeta($value, $user, $field_name) {
    global $wpdb;
    $table = $wpdb->prefix . 'usermeta';
    if ($field_name === 'birth_date') {
        $value = str_replace('-', '', $value);
    }
    $data_update = array('meta_value' => $value);
    $data_where = array('user_id' => $user->ID, 'meta_key' => $field_name);
    $query = $wpdb->update($table, $data_update, $data_where);
    if ($query) {
        return true;
    }
    return false;
}

//Register Post Featured Image
add_action( 'rest_api_init', 'register_post_featured_image_fields' );
function register_post_featured_image_fields() {
    register_rest_field( 'post',
        'featured_image',
        [
            'get_callback'    => function($object, $field_name, $request){
                if($request->get_param('featured_image_size')){
                    $requestSize = $request->get_param('featured_image_size');
                }
                if( $object['featured_media'] ){
                    $img_meta = wp_get_attachment_metadata( $object['featured_media'] );
                    if(isset($requestSize) && !empty($img_meta['sizes'][$requestSize])){
                        $size = $requestSize;
                    }else{
                        $size = 'original';
                    }
                    $img = wp_get_attachment_image_src($object['featured_media'], $size);
                    return [
                        'url' => $img[0],
                    ];
                }
                return false;
            }
        ]
    );
}

//Register Page Featured Image
add_action( 'rest_api_init', 'register_page_featured_image_fields' );
function register_page_featured_image_fields() {
    register_rest_field( 'page',
        'featured_image',
        [
            'get_callback'    => function($object, $field_name, $request){
                if($request->get_param('featured_image_size')){
                    $requestSize = $request->get_param('featured_image_size');
                }
                if( $object['featured_media'] ){
                    $img_meta = wp_get_attachment_metadata( $object['featured_media'] );
                    if(isset($requestSize) && !empty($img_meta['sizes'][$requestSize])){
                        $size = $requestSize;
                    }else{
                        $size = 'original';
                    }
                    $img = wp_get_attachment_image_src($object['featured_media'], $size);
                    return [
                        'url' => $img[0]
                    ];
                }
                return false;
            }
        ]
    );
}

//Register Testimonial Featured Image
add_action( 'rest_api_init', 'register_testimonial_featured_image_fields' );
function register_testimonial_featured_image_fields() {
    register_rest_field( 'testimonial',
        'featured_image',
        [
            'get_callback'    => function($object, $field_name, $request){
                if($request->get_param('featured_image_size')){
                    $requestSize = $request->get_param('featured_image_size');
                }
                if( $object['featured_media'] ){
                    $img_meta = wp_get_attachment_metadata( $object['featured_media'] );
                    if(isset($requestSize) && !empty($img_meta['sizes'][$requestSize])){
                        $size = $requestSize;
                    }else{
                        $size = 'original';
                    }
                    $img = wp_get_attachment_image_src($object['featured_media'], $size);
                    return [
                        'url' => $img[0]
                    ];
                }
                return false;
            }
        ]
    );
}

//Register Testimonial Featured Image
add_action( 'rest_api_init', 'register_project_featured_image_fields' );
function register_project_featured_image_fields() {
    register_rest_field( 'projects',
        'featured_image',
        [
            'get_callback'    => function($object, $field_name, $request){
                if($request->get_param('featured_image_size')){
                    $requestSize = $request->get_param('featured_image_size');
                }
                if( $object['featured_media'] ){
                    $img_meta = wp_get_attachment_metadata( $object['featured_media'] );
                    if(isset($requestSize) && !empty($img_meta['sizes'][$requestSize])){
                        $size = $requestSize;
                    }else{
                        $size = 'original';
                    }
                    $img = wp_get_attachment_image_src($object['featured_media'], $size);
                    return [
                        'url' => $img[0]
                    ];
                }
                return false;
            }
        ]
    );
}
// // Enable the option show in rest
// add_filter( 'acf/rest_api/field_settings/show_in_rest', '__return_true' );

// // Enable the option edit in rest
// add_filter( 'acf/rest_api/field_settings/edit_in_rest', '__return_true' );


?>