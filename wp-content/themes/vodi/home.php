<?php
/**
 * Template Name: Blog Post
 * Template Post Type: post, page, product
 * 
 * The template for displaying all posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#blog-category
 *
 * @package Accelerate Tv
*/
 
get_header(); 

do_action( 'vodi_before_main_content' );

?> 

<div id="primary">
 <div class="container">
  <main id="main" class="site-main main_blog">

  <?php
   // Costum Features Category
   $costumFeatures = new WP_Query( 'cat=616&posts_per_page=4' );
			
   // Features Category
   $features = new WP_Query( 'cat=229&posts_per_page=20' );
			
			// Music Category
   $music = new WP_Query( 'cat=614&posts_per_page=2' );
   
   // Sport Category
   $sport = new WP_Query( 'cat=615&posts_per_page=2' );
  ?>
		<div id="custom_features">
			<div class="latest customLatest">
				<?php while($costumFeatures->have_posts()) :
							$costumFeatures->the_post();
							?>
								<article style="background-image: url('<?php echo get_the_post_thumbnail_url($post_id, 'large'); ?>');">
									<div>
										<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
										<small><?php the_time('F jS, Y') ?></small>
									</div>
								</article>
						<?php
							endwhile;
							wp_reset_postdata();
						?>
			</div>
		</div> <!-- #latest_features -->
   <div id="latest_features">
    <h2>LATEST FEATURES</h2>
    <div class="latest latestFeatured">

     <?php while($features->have_posts()) :
        $features->the_post();
        ?>
         <article style="background-image: url('<?php echo get_the_post_thumbnail_url($post_id, 'large'); ?>');">
          <div>
           <h6><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h6>
           <small><?php the_time('F jS, Y') ?></small>
          </div>
         </article>
       <?php
        endwhile;
        wp_reset_postdata();
       ?>
    </div>
   </div> <!-- #latest_features -->
   <div class="other_cat">
    <div class="other_cat_content">
     <h2><?php echo get_cat_name(614);?></h2>
     <a href="<?php echo get_category_link(614); ?>">SEE MORE</a>

     <div class="major_cat">
      <?php while($music->have_posts()) :
         $music->the_post();
         ?>
          <article>
           <div class="image">
            <?php the_post_thumbnail(); ?>
           </div>
           <div class="cat_content">
            <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
            <small><?php the_time('F jS, Y') ?></small>
            <p>
             <?php 
             $excerpt= get_the_excerpt();
             echo wp_trim_words( $excerpt, 40, '...' ); 
             ?>
            </p>
           </div>
          </article>
        <?php
         endwhile;
         wp_reset_postdata();
        ?>
     </div>
    </div>
	   <div class="other_cat_sidebar">
		   <?php if (is_active_sidebar('blog_follow')) : ?>
		   <div class="blog-ads">
			   <div class="follow-bg">
				   <?php dynamic_sidebar('blog_follow'); ?>			   
			   </div>
		   </div>
		   <?php endif;?>
		   <?php if (is_active_sidebar('music_blog_ad')) : ?>
		   <div class="blog-ads">
			   <?php dynamic_sidebar('music_blog_ad'); ?>
		   </div>
		   <?php endif;?>
	   </div>
   </div>

   <div class="full_blog_ads">
    <?php if (is_active_sidebar('blog_full_ad')) : ?>
      <div class="blog-ads">
       <?php dynamic_sidebar('blog_full_ad'); ?>
      </div>
    <?php endif;?>
   </div>

   <div class="other_cat">
    <div class="other_cat_content">
     <h2><?php echo get_cat_name(615);?></h2>
     <a href="<?php echo get_category_link(615); ?>">SEE MORE</a>

     <div class="major_cat">
      <?php while($sport->have_posts()) :
         $sport->the_post();
         ?>
          <article>
           <div class="image">
            <?php the_post_thumbnail(); ?>
           </div>
           <div class="cat_content">
            <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
            <small><?php the_time('F jS, Y') ?></small>
            <p>
             <?php 
             $excerpt= get_the_excerpt();
             echo wp_trim_words( $excerpt, 40, '...' ); 
             ?>
            </p>
           </div>
          </article>
        <?php
         endwhile;
         wp_reset_postdata();
        ?>
     </div>
    </div>
	   <div class="other_cat_sidebar sport_ads">
		   <?php if (is_active_sidebar('sport_blog_ad')) : ?>
		   <div class="blog-ads">
			   <?php dynamic_sidebar('sport_blog_ad'); ?>
		   </div>
		   <?php endif;?>
	   </div>
   </div>
  </main><!-- #main -->
  <?php // get_sidebar(); ?>
 </div>
</div><!-- #primary -->
<?php get_footer(); ?>
