<?php
/**
 * Filter functions for General Section of Theme Options
 */

if( ! function_exists( 'redux_toggle_scrollup' ) ) {
    function redux_toggle_scrollup() {
        global $vodi_options;

        if( isset( $vodi_options['scrollup'] ) && $vodi_options['scrollup'] == '1' ) {
            $scrollup = true;
        } else {
            $scrollup = false;
        }

        return $scrollup;
    }
}

if( ! function_exists( 'redux_toggle_register_image_size' ) ) {
    function redux_toggle_register_image_size() {
        global $vodi_options;

        if( isset( $vodi_options['register_image_size'] ) && $vodi_options['register_image_size'] == '1' ) {
            $enable = true;
        } else {
            $enable = false;
        }

        return $enable;
    }
}

if ( ! function_exists( 'redux_set_register_image_size_args' ) ) {
    function redux_set_register_image_size_args( $image_size_args ) {
        global $vodi_options;

        if ( isset( $vodi_options['enabled_register_image_size'] ) ) {
            $disabled_image_size_args = $vodi_options['enabled_register_image_size']['disabled'];
            foreach ( $disabled_image_size_args as $key => $value ) {
                if( isset( $image_size_args[$key] ) ) {
                    unset( $image_size_args[$key] );
                }
            }
        }

        return $image_size_args;
    }
}