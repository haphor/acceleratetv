<?php /* Template Name: Page Builder (plugin builders) */
wp_enqueue_style( 'visual-composer-custom', get_template_directory_uri() . '/css/visual-composer-custom.css' );
get_header();
global $post;
$remove_top_spacing = get_post_meta($post->ID, '_vs_top_spacing', true);
$display_spacing = true;
$wpvs_page_featured_area_type = get_post_meta( $post->ID, 'wpvs_featured_area_slider_type', true ); 
if($wpvs_page_featured_area_type == "default" || $wpvs_page_featured_area_type == "shortcode" || $remove_top_spacing) {
    $display_spacing = false;
}
wpvs_do_featured_slider($post->ID);
if($display_spacing) {
    echo '<div class="page-container"></div>';
}
if ( have_posts() ) : ?>
<div class="vs-container">
<?php while ( have_posts() ) : the_post(); ?>
    <?php the_content(); ?>
<?php endwhile;  ?>
</div>
<?php else : get_template_part('nothing-found'); endif; ?>

<?php get_footer(); ?>