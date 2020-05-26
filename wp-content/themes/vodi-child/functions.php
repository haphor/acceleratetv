<?php
/**
 * Vodi Child
 *
 * @package vodi-child
 */

/**
 * Include all your custom code here
 */
if( ! function_exists( 'vodi_child_scripts' ) ) {
    function vodi_child_scripts() {
        wp_enqueue_style( 'vodi-custom-google-fonts', 'https://fonts.googleapis.com/css?family=Rajdhani:300,400,500,600,700&display=swap' );
    }
}

add_action( 'wp_enqueue_scripts', 'vodi_child_scripts', 100 );

function accelerate_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Follow', 'accelerate' ),
		'id'            => 'blog_follow',
		'description'   => esc_html__( 'Add widgets here.', 'accelerate' ),
		'before_widget' => '<div class="row widget %2$s">',
		'after_widget'  => '</div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Music Blog Ads', 'accelerate' ),
		'id'            => 'music_blog_ad',
		'description'   => esc_html__( 'Add widgets here.', 'accelerate' ),
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
        register_sidebar( array(
                'name'          => esc_html__( 'Blog Ful Ads', 'accelerate' ),
                'id'            => 'blog_full_ad',
                'description'   => esc_html__( 'Add widgets here.', 'accelerate' ),
                'before_title'  => '<h1 class="widget-title">',
                'after_title'   => '</h1>',
        ) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sport Blog Ads', 'accelerate' ),
		'id'            => 'sport_blog_ad',
		'description'   => esc_html__( 'Add widgets here.', 'accelerate' ),
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'accelerate_widgets_init' );
