<?php
/**
 * Options available for Typography sub menu of Theme Options
 * 
 */

$typography_options = apply_filters( 'vodi_typography_options_args', array(
    'title'     => esc_html__( 'Typography', 'vodi' ),
    'icon'      => 'fas fa-font',
    'fields'    => array()
) );