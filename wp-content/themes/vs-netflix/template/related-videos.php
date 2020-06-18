<?php
global $post;
global $vs_dropdown_details;
$rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
$rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
$video_categories = wp_get_post_terms( $post->ID, 'rvs_video_category', array( 'fields' => 'all', 'orderby' => 'term_id' ));
$wpvs_show_related_videos = get_theme_mod('wpvs_show_related_videos', true);
$wpvs_related_videos_count = get_theme_mod('wpvs_related_videos_count', 7); ?>
<div class="row">
<?php if($wpvs_show_related_videos) :
    if( ! empty($video_categories) ) {
        $cat_position = (count($video_categories) - 1);
        $use_category = $video_categories[$cat_position]->term_id;
        $video_cat_name = $video_categories[$cat_position]->name;
        $same_cat_args = array(
            'post_type' => 'rvs_video',
            'posts_per_page' => $wpvs_related_videos_count,
            'post__not_in' => array($post->ID),
            'tax_query' => array(
                  array(
                      'taxonomy' => 'rvs_video_category',
                      'field' => 'term_id',
                      'terms' => $use_category
                  )
              )
        );

        if(empty(get_posts($same_cat_args))) {
            $cat_position = (count($video_categories) - 2);
            if(!isset($video_categories[$cat_position])) {
                $cat_position = (count($video_categories) - 1);
            }
            $use_category = $video_categories[$cat_position]->term_id;

            $video_cat_name = $video_categories[$cat_position]->name;
            $same_cat_args = array(
                'post_type' => 'rvs_video',
                'posts_per_page' => $wpvs_related_videos_count,
                'post__not_in' => array($post->ID),
                'tax_query' => array(
                      array(
                          'taxonomy' => 'rvs_video_category',
                          'field' => 'term_id',
                          'terms' => $use_category
                      )
                  )
            );
        }
    }

$other_video_array = array($post->ID);

if( $rvs_video_order_settings == 'random' ) {
    $same_cat_args['orderby'] = 'rand';
    $same_cat_args['order'] = 'ASC';
}
if($rvs_video_order_settings == 'videoorder') {
    $same_cat_args['meta_key'] = 'rvs_video_post_order';
    $same_cat_args['orderby'] = 'meta_value_num';
    $same_cat_args['order'] = $rvs_video_order_direction;
}

if($rvs_video_order_settings == 'alpha') {
    $same_cat_args['orderby'] = 'title';
    $same_cat_args['order'] = $rvs_video_order_direction;
}

if( ! empty($same_cat_args) && isset($same_cat_args['post_type']) ) {
    $same_cat_videos = get_posts($same_cat_args);
    $same_cat_count = count($same_cat_videos);
}
?>

<!-- SAME CATEGORY VIDEOS -->
<?php if(!empty($same_cat_videos)) { ?>
<div class="video-category slide-category slide-container">
    <h3><?php echo $video_cat_name; ?></h3>
    <div class="video-list-slider" data-items="<?php echo $same_cat_count; ?>">
        <?php foreach($same_cat_videos as $cat_video) {
            $video_link = wpvs_get_video_link($cat_video->ID);
            $video_thumbnail = vs_netflix_get_video_thumbnail($cat_video->ID);
            $open_in_new_tab = get_post_meta($cat_video->ID, 'wpvs_open_video_in_new_tab', true);
            ?>
            <a class="video-slide" href="<?php echo $video_link; ?>" <?= ($open_in_new_tab) ? 'target="_blank"' : '' ?>>
                <div class="video-slide-image border-box"><img src="<?php echo $video_thumbnail; ?>" alt="<?php echo $cat_video->post_title; ?>" /></div>
                <div class="video-slide-details border-box">
                    <h4><?php echo $cat_video->post_title; ?></h4>
                    <p class="slide-text"><?php echo $cat_video->post_excerpt; ?></p>
                </div>
                <?php if($vs_dropdown_details) { ?>
                <label class="show-vs-drop ease3" data-video="<?php echo $cat_video->ID ?>" data-type="video"><span class="dashicons dashicons-arrow-down-alt2"></span></label>
                <?php } ?>
            </a>
        <?php $other_video_array[] = $cat_video->ID; } ?>
    </div>
</div>
<?php if($vs_dropdown_details) { ?>
<div class="vs-video-description-drop border-box">
    <label class="wpvs-close-video-drop"><span class="dashicons dashicons-no-alt"></span></label>
    <div class="drop-loading border-box">
        <label class="net-loader"></label>
    </div>
</div>
<?php } } endif;

$vs_show_recently_added = get_theme_mod('vs_show_recently_added', true);
$wpvs_recently_added_count = get_theme_mod('wpvs_recently_added_count', 7);
if($vs_show_recently_added) :
    $video_args = array(
        'post_type' => 'rvs_video',
        'posts_per_page' => $wpvs_recently_added_count,
        'post__not_in' => $other_video_array
    );
    $other_videos = get_posts($video_args);
    $other_vid_count = count($other_videos);
    ?>
    <!-- RECENTLY ADDED VIDEOS -->
    <?php if(!empty($other_videos)) { ?>
    <div class="video-category slide-category slide-container">
        <h3><?php _e('Recently Added', 'vs-netflix'); ?></h3>
        <div class="video-list-slider" data-items="<?php echo $other_vid_count; ?>">
            <?php foreach($other_videos as $video) {
                $video_link = wpvs_get_video_link($video->ID);
                $video_thumbnail = vs_netflix_get_video_thumbnail($video->ID);
                $open_in_new_tab = get_post_meta($video->ID, 'wpvs_open_video_in_new_tab', true);
                ?>
                <a class="video-slide" href="<?php echo $video_link; ?>" <?= ($open_in_new_tab) ? 'target="_blank"' : '' ?>>
                    <div class="video-slide-image border-box"><img src="<?php echo $video_thumbnail; ?>" alt="<?php echo $video->post_title; ?>" /></div>
                    <div class="video-slide-details border-box">
                        <h4><?php echo $video->post_title; ?></h4>
                        <p class="slide-text"><?php echo $video->post_excerpt; ?></p>
                    </div>
                    <?php if($vs_dropdown_details) { ?>
                    <label class="show-vs-drop ease3" data-video="<?php echo $video->ID ?>" data-type="video"><span class="dashicons dashicons-arrow-down-alt2"></span></label>
                    <?php } ?>
                </a>
            <?php } ?>
        </div>
    </div>
    <?php if($vs_dropdown_details) { ?>
    <div class="vs-video-description-drop border-box">
        <label class="wpvs-close-video-drop"><span class="dashicons dashicons-no-alt"></span></label>
        <div class="drop-loading border-box">
            <label class="net-loader"></label>
        </div>
    </div>
    <?php } } endif; ?>
</div>
