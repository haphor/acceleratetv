<?php
$vs_show_overlay = false;
if( (isset($_GET['failed']) && !empty($_GET['failed']) ) || ( isset($_GET['errmsg']) && !empty($_GET['errmsg']) ) ) {
    $vs_show_overlay = true;
}
$wpvs_open_videos_in_full_screen = get_theme_mod('wpvs_open_in_full_screen', 0);
if( $wpvs_open_videos_in_full_screen && isset($_GET['wpvsopen']) && $_GET['wpvsopen'] ) {
    $vs_show_overlay = true;
}
if( isset($_GET['purchase']) && $_GET['purchase'] ) {
    $vs_show_overlay = true;
}
$play_button_setting = get_theme_mod( 'wpvs_play_button', 'play-icon');
$wpvs_full_screen_video = get_theme_mod( 'wpvs_full_screen_video', 0);
$display_video_details = true;      
if( $video_restricted_content == 'videocontent' && ! $show_video_content ) {
    $display_video_details = false;
}
if($full_screen_access) {
    $full_screen_content .= '</div></div>';
    echo $full_screen_content;
} else { if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    $video_image = vs_netflix_get_video_header_image($post->ID);
        
if($show_video_content) : 
if( $wpvs_autoplay ) {
    $wpvs_autoplay_timer = get_option('wpvs_autoplay_timer', 5);
    $seconds_label = sprintf(__('starts in <span id="wpvs-autoplay-count">%d</span> seconds', 'vs-netflix'), $wpvs_autoplay_timer);
    $custom_content .= '<div id="wpvs-autoplay-countdown"><a href="" id="wpvs-next-video-title"></a>'.$seconds_label.'<label id="wpvs-cancel-next-video"><span class="dashicons dashicons-no-alt"></span></label></div>';
}
?>
<div class="vs-full-screen-video border-box <?=($wpvs_full_screen_video) ? 'wpvs-full-screen-display' : ''?> <?=($vs_show_overlay) ? 'show-full-screen-video' : ''?>">
    <div class="wpvs-video-overlay">
        <label id="vs-video-back"><span class="dashicons dashicons-arrow-left-alt2"></span> <?php the_title(); ?></label>
    </div>
    <div id="single-netflix-video-container">
        <div id="rvs-main-video" class="row">
            <div class="videoWrapper">
            <?php echo $custom_content; ?>
            </div>
        </div>
    <!-- TRAILER -->
    <?php if($rvs_trailer_enabled && !empty($video_html_code['trailer'])) : ?>
        <div id="rvs-trailer-video" class="row" <?=($vs_show_overlay) ? 'style="display: none;"' : ''?>>
            <div class="videoWrapper">
            <?php echo $video_html_code['trailer']; ?>
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>
<?php else : ?>
<div class="vs-full-screen-video border-box <?=($wpvs_full_screen_video) ? 'wpvs-full-screen-display' : ''?> <?=($vs_show_overlay) ? 'show-full-screen-video' : ''?>">
    <div class="wpvs-video-overlay">
        <label id="vs-video-back"><span class="dashicons dashicons-arrow-left-alt2"></span> <?php the_title(); ?></label>
    </div>
    <div id="single-netflix-video-container">
        <div id="rvs-main-video" class="<?=($wpvs_full_screen_video) ? 'wpvs-full-screen-login' : ''?> row">
            <div class="col-12">
            <?php echo $custom_content; ?>
            </div>
        </div>
        <?php if($rvs_trailer_enabled && !empty($video_html_code['trailer'])) : ?>
            <div id="rvs-trailer-video" class="row" <?=($vs_show_overlay) ? 'style="display: none;"' : ''?>>
                <div class="videoWrapper">
                <?php echo $video_html_code['trailer']; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<div class="vs-video-header">
    <img class="video-image" src="<?php echo $video_image; ?>" alt="<?php the_title(); ?>" />
    <div class="vs-video-details">
        <h1><?php the_title(); ?></h1>
        <?php echo wpvs_theme_get_video_information($post->ID); ?>
        <?php if($display_video_details) { ?>
            <div class="vs-video-description">
                <?php the_content(); ?>
            </div>
        <?php } rvs_get_video_details($post->ID, true); ?>
        <?php endwhile; endif;  ?>
        <?php if($play_button_setting == 'standard') {
            $play_button_text = __('Play', 'vs-netflix');
            if( ! empty($users_continue_watching_list) ) {
                foreach($users_continue_watching_list as $continue_video) {
                    if($continue_video['id'] == $post->ID ) {
                        $play_button_text = __('Resume', 'vs-netflix');
                    }
                }
            }
        ?>
            <label id="vs-play-video" class="button wpvs-play-button"><?php echo $play_button_text; ?> <span class="dashicons dashicons-controls-play"></span></label>
        <?php } if($rvs_trailer_enabled && !empty($video_html_code['trailer'])) { ?>
            <label id="vs-play-trailer" class="button wpvs-play-button"><?php _e('Trailer', 'vs-netflix'); ?> <span class="dashicons dashicons-controls-play"></span></label>
        <?php } if( $show_video_content && $members_can_download && ! empty($video_download_link) ) { ?>
                <a class="button wpvs-play-button" href="<?php echo $video_download_link; ?>" download><span class="dashicons dashicons-download"></span> <?php echo $download_link_text; ?></a>
        <?php } if($wpvs_my_list_enabled) { ?>
            <label class="button wpvs-add-to-list enhance <?=($add_to_my_list_button['add']) ? '':'remove';?>" data-videoid="<?php echo $add_to_my_list_button['id']; ?>" data-videotype="<?php echo $add_to_my_list_button['type']; ?>"><?php echo $add_to_my_list_button['html']; ?></label>
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
    </div>
    <?php if($play_button_setting == 'play-icon') : ?>
        <label id="vs-play-video" class="vs-drop-play-button border-box"><span class="dashicons dashicons-controls-play"></span></label>
    <?php endif; ?>
</div>
<?php 
get_template_part('template/related-videos'); 
} // end fullscreen else
if( comments_open() && $wpvs_video_review_ratings ) : ?>
    <div id="wpvs-video-reviews-container" class="border-box ease3">
        <label id="close-wpvs-reviews" class="border-box wpvs-close-icon"><span class="dashicons dashicons-no-alt"></span></label>
        <div class="container row">
        <?php comments_template('/template/reviews.php'); ?>
        </div>
    </div>
<?php endif; ?>
<?php get_footer();  ?>