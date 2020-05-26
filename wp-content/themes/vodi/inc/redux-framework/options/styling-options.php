<?php
/**
 * Options available for Styling sub menu of Theme Options
 * 
 */

$styling_options = apply_filters( 'vodi_styling_options_args', array(
    'title'     => esc_html__( 'Styling', 'vodi' ),
    'icon'      => 'fas fa-palette',
    'fields'    => array()
) );