<?php
/**
 * Redux Framework functions
 *
 * @package Vodi/ReduxFramework
 */

/**
 * Setup functions for theme options
 */

function vodi_remove_demo_mode_link() {
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}

function vodi_redux_disable_dev_mode_and_remove_admin_notices( $redux ) {
    remove_action( 'admin_notices', array( $redux, '_admin_notices' ), 99 );
    $redux->args['dev_mode'] = false;
    $redux->args['forced_dev_mode_off'] = false;
}

/**
 * Enqueues font awesome for Redux Theme Options
 * 
 * @return void
 */
function redux_queue_font_awesome() {
    wp_register_style( 'fontawesome', get_template_directory_uri() . '/assets/css/fontawesome.css', array(), time(), 'all' );
    wp_enqueue_style( 'fontawesome' );
}

function vodi_redux_get_tv_show_tag_terms_options() {
    $options = array();
    $terms = get_terms( array( 'taxonomy' => 'tv_show_tag' ) );

    if ( ! empty ( $terms ) && ! is_a( $terms, 'WP_Error' ) ) {
        foreach ( $terms as $term ) {
            $options[ $term->slug ] = $term->name;
        }
    }

    return $options;
}

function vodi_redux_get_movie_tag_terms_options() {
    $options = array();
    $terms = get_terms( array( 'taxonomy' => 'movie_tag' ) );

    if ( ! empty ( $terms ) && ! is_a( $terms, 'WP_Error' ) ) {
        foreach ( $terms as $term ) {
            $options[ $term->slug ] = $term->name;
        }
    }

    return $options;
}

/**
 * Gets product attribute taxonomies
 * 
 * @return array
 */
function vodi_redux_get_all_register_image_size_options() {

    $options = array();

    if( function_exists( 'vodi_get_register_image_sizes' ) ) {
        $image_size_args = vodi_get_register_image_sizes();
        $all_keys = array_keys( $image_size_args );
        $options = array_combine( $all_keys, $all_keys );
    }

    return $options;
}

require_once get_template_directory() . '/inc/redux-framework/functions/general-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/header-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/footer-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/blog-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/movies-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/tv-shows-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/videos-functions.php';
// require_once get_template_directory() . '/inc/redux-framework/functions/404-functions.php';
// require_once get_template_directory() . '/inc/redux-framework/functions/style-functions.php';
// require_once get_template_directory() . '/inc/redux-framework/functions/typography-functions.php';