<?php
/**
 * The template for displaying Coming Soon.
 * 
 * Template name: Coming Soon
 *
 * @package vodi
 */

get_header();

    do_action( 'vodi_before_main_content' ); ?>

<div class="comingsoon-bg-image" <?php echo vodi_comingsoon_bg_image(); ?>></div>
<div id="primary" class="content-area">
    <main class="site-main">
        
        <?php while ( have_posts() ) : the_post();

            do_action( 'vodi_comingsoon_before' );

            get_template_part( 'templates/contents/content', 'page' );

            do_action( 'vodi_comingsoon_after' );

        endwhile; // End of the loop. ?>              
    </main>
</div> <?php

do_action( 'vodi_after_main_content' );

 get_footer();