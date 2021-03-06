<?php 
get_header(); 
global $post; 
wpvs_do_featured_slider($post->ID); 
$add_extra_top = false;
$wpvs_page_featured_area_type = get_post_meta( $post->ID, 'wpvs_featured_area_slider_type', true );
if( empty($wpvs_page_featured_area_type) || $wpvs_page_featured_area_type == "none") {
    $add_extra_top = true;
}
if($add_extra_top) { ?>
<div class="page-container">
<?php } if ( have_posts() ) : ?>
<div class="container row">
    <?php while ( have_posts() ) : the_post(); ?>
        <article id="main" role="main" class="side-bar-content">
            <div class="col-12">
                <?php if(has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <?php echo the_post_thumbnail('full'); ?>
                </div>
                <?php endif; ?>
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>

                <?php if(has_tag()) {
                    the_tags('Tags: ',' ','');
                } ?>
                <?php if( comments_open() ) { comments_template(); } ?>
            </div>
        </article>
        <?php get_template_part('sidebar'); ?>
    <?php endwhile;  ?>
</div>
<?php else : get_template_part('nothing-found'); endif; ?>
<?php if($add_extra_top) { ?></div><?php } ?>
<?php get_footer(); ?>