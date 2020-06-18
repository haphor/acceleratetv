<?php
if($full_screen_access) {
    $full_screen_content .= '</div></div>';
    echo $full_screen_content;
} else { if ( have_posts() ) : while ( have_posts() ) : the_post(); $widget_videos = array($post->ID); 
$display_video_details = true;      
if( $video_restricted_content == 'videocontent' && ! $show_video_content ) {
    $display_video_details = false;
}
?>
<div class="video-page-container">
    <div class="wide-container row">
        <section id="main" class="side-bar-content">
            <?php if($show_video_content) : 
                if( $wpvs_autoplay ) {
                    $wpvs_autoplay_timer = get_option('wpvs_autoplay_timer', 5);
                    $seconds_label = sprintf(__('starts in <span id="wpvs-autoplay-count">%d</span> seconds', 'vs-netflix'), $wpvs_autoplay_timer);
                    $custom_content .= '<div id="wpvs-autoplay-countdown"><a href="" id="wpvs-next-video-title"></a>'.$seconds_label.'<label id="wpvs-cancel-next-video"><span class="dashicons dashicons-no-alt"></span></label></div>';
                }
            ?>
                <div class="row">
                    <div class="wpvs-youtube-video-wrapper border-box">
                        <div id="wpvs-main-video" class="videoWrapper">
                        <?php echo $custom_content; ?>
                        </div>
                    </div>
                 </div>
            <?php else : if($rvs_trailer_enabled && !empty($video_html_code['trailer'])) : ?>
                <div class="row">
                    <div class="wpvs-youtube-video-wrapper border-box">
                        <div class="videoWrapper">
                        <?php echo $video_html_code['trailer']; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
                <div class="row">
                    <div class="col-12 wpvs-custom-content-box">
                    <?php echo $custom_content; ?>
                    </div>
                </div>
            <?php endif ;?>
            <div id="main-content" class="col-12">
                <?php if( $display_video_details ) { ?>
                    <h1><?php the_title(); ?></h1>
                    <div class="wpvs-top-video-controls">
                    <?php if( $show_video_content && $members_can_download && ! empty($video_download_link) ) { ?>
                            <a class="button" href="<?php echo $video_download_link; ?>" download><span class="dashicons dashicons-download"></span> <?php echo $download_link_text; ?></a>
                    <?php } if($wpvs_my_list_enabled) : ?>
                        <label class="button wpvs-add-to-list <?=($add_to_my_list_button['add']) ? '':'remove';?>" data-videoid="<?php echo $add_to_my_list_button['id']; ?>" data-videotype="<?php echo $add_to_my_list_button['type']; ?>"><?php echo $add_to_my_list_button['html']; ?></label>
                        <?php endif; ?>
                    </div>
                <?php } if(current_user_can( 'manage_options' )) { ?>
                    <div>
                        <?php if($no_access_preview) { ?>
                            <a href="<?php the_permalink(); ?>"><span class="dashicons dashicons-visibility"></span> Video Preview</a>
                            <em class="vs-note">Only site administrators can see this.</em>
                        <?php } else { ?>
                            <a href="?vsp=noaccess"><span class="dashicons dashicons-visibility"></span> No Access Preview</a>
                            <em class="vs-note">Only site administrators can see this.</em>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if( $display_video_details ) { ?>
                    <?php echo wpvs_theme_get_video_information($post->ID); ?>
                    <?php the_content(); ?>
                    <?php rvs_get_video_details($post->ID, true); ?>
                    <?php if($wpvs_video_review_ratings) {
                        comments_template('/template/reviews.php');
                    } else {
                        comments_template();
                    } ?>
                <?php } ?>
                <?php endwhile; endif;  ?>
            </div>
        </section>
        <?php if( $display_video_details ) { get_template_part('sidebar'); } ?>
    </div>
</div>
<?php 
if( $display_video_details && $wpvs_show_more_videos_below_standard ) {
    get_template_part('template/category-videos'); 
} ?>
<?php } get_footer(); ?>