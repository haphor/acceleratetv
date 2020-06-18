<?php /* Template Name: Full Width Stretched */
get_header(); 
global $post; 
wpvs_do_featured_slider($post->ID); 
$remove_top_spacing = get_post_meta($post->ID, '_vs_top_spacing', true);
$add_extra_top = false;
$wpvs_page_featured_area_type = get_post_meta( $post->ID, 'wpvs_featured_area_slider_type', true );
if( (empty($wpvs_page_featured_area_type) || $wpvs_page_featured_area_type == "none" ) && ! $remove_top_spacing ) {
    $add_extra_top = true;
}
if($add_extra_top) { ?>
<div class="page-container">
<?php } if ( have_posts() ) : ?>
<div class="full-width-stretched">
    <div class="col-12">
    <?php while ( have_posts() ) : the_post();
        the_content();
        if( comments_open() ) { 
            comments_template(); 
        }
    endwhile; ?>
    </div>
</div>
<?php else : get_template_part('nothing-found'); endif; ?>
<?php if($add_extra_top) { ?></div><?php } ?>
<?php get_footer(); ?>