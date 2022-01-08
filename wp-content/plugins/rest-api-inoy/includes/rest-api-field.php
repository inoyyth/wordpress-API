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