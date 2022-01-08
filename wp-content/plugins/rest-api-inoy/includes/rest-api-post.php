<?php
add_filter( 'wp_insert_post_data', 'wpse_40574_populate_excerpt', 99, 2 );

function wpse_40574_populate_excerpt( $data, $postarr ) {   
    global $wpse_40574_custom_excerpt_length;
    // check if it's a valid call
    if ( !in_array( $data['post_status'], array( 'draft', 'pending', 'auto-draft' ) ) && in_array($data['post_type'], array('post','projects','page'))  ) 
    {
        // if the except is empty, call the excerpt creation function
        if ( strlen($data['post_excerpt']) == 0 ) 
            $data['post_excerpt'] = wpse_40574_create_excerpt( trim(strip_tags($data['post_content'])), 20 );
    }

    return $data;
}

/** 
 * Returns the original content string if its word count is lesser than $length, 
 * or a trimed version with the desired length.
 * Reference: see this StackOverflow Q&A - http://stackoverflow.com/q/11521456/1287812
 */
function wpse_40574_create_excerpt( $content, $length = 20 ) {
    $the_string = preg_replace( '#\s+#', ' ', $content );
    $words = explode( ' ', $the_string );

    /**
     * The following is a more efficient way to split the $content into an array of words
     * but has the caveat of spliting Url's into words ( removes the /, :, ., charachters )
     * so, not very useful in this context, could be improved though.
     * Note that $words[0] has to be used as the array to be dealt with (count, array_slice)
     */
    //preg_match_all( '/\b[\w\d-]+\b/', $content, $words );

    if( count($words) <= $length ) 
        $result = $content;
    else
        $result = implode( ' ', array_slice( $words, 0, $length ) );

    return $result;
}

// Adding excerpt for page
add_post_type_support( 'page', 'excerpt' );