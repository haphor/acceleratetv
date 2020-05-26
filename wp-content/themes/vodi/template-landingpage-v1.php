<?php
/**
 * The template for displaying Landing Page v1.
 * 
 * Template name: Landing page v1
 *
 * @package vodi
 */

get_header();

do_action( 'vodi_before_main_content' ); ?>

<div id="primary" class="content-area">
    <main class="site-main">
        <?php while ( have_posts() ) : the_post();

            do_action( 'vodi_landing_v1_before' );

            get_template_part( 'templates/contents/content', 'page' );

            do_action( 'vodi_landing_v1_after' );

        endwhile; // End of the loop. ?>        
    </main>
</div> <?php

do_action( 'vodi_after_main_content' );

    get_footer();