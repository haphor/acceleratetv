<?php

function wpvs_theme_custom_rest_video_category_queries( $args, $request ) {
    if( isset($request['tvshows']) && $request['tvshows'] ) {
        $args['meta_query'] = array(
            array(
                'key'     => 'cat_has_seasons',
                'value'   => true,
                'compare' => '='
            )
        );
    }
    return $args;
}
add_filter( 'rest_rvs_video_category_query', 'wpvs_theme_custom_rest_video_category_queries', 10, 2);