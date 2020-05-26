<?php
global $vs_dropdown_details;
$rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
$rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
$wpvs_show_recently_added = get_theme_mod('wpvs_show_recently_added', 0);
$videos_per_slide = get_theme_mod('vs_videos_per_slider', '10');?>
<div id="vs-netflix-slide-loader" class="drop-loading"><label class="net-loader"></label></div>
<div id="video-list-container" class="ease5 home-video-list">
<?php
    if( is_user_logged_in() ) {
        global $wpvs_my_list_enabled;
        global $wpvs_current_user;
        $show_my_list = get_theme_mod('wpvs_my_list_show_on_home', 1);
        $users_continue_watching_list = get_user_meta($wpvs_current_user->ID, 'wpvs_users_continue_watching_list', true);
        if( ! empty($users_continue_watching_list) ) {
            $continue_watching_videos = array();
            foreach($users_continue_watching_list as $continue_video) {
                $video_id = $continue_video['id'];
                $video_post = get_post($video_id);
                if($video_post && $video_post->post_type == "rvs_video") {
                    $percent_complete = $continue_video['percent_complete'];
                    $video_home_link = wpvs_get_video_link($video_id);
                    $video_thumbnail = vs_netflix_get_video_thumbnail($video_id);
                    $continue_watching_videos[] = array(
                        'id' => $video_id,
                        'title' => $video_post->post_title,
                        'link' => $video_home_link,
                        'image' => $video_thumbnail,
                        'description' => $video_post->post_excerpt,
                        'type' => 'video',
                        'percent_complete' => $percent_complete
                    );
                }
            }

            if( ! empty($continue_watching_videos) ) {
                $continue_watching_item_count = count($continue_watching_videos); ?>
                <div class="video-category slide-category slide-container">
                    <h3><?php _e('Continue Watching', 'vs-netflix'); ?></h3>
                    <div class="video-list-slider" data-items="<?php echo $continue_watching_item_count; ?>">
                        <?php foreach($continue_watching_videos as $slide) { ?>
                            <a class="video-slide" href="<?php echo $slide['link']; ?>">
                                <div class="video-slide-image border-box">
                                    <img src="<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>"/>
                                    <span class="wpvs-cw-progress-bar border-box" style="width: <?php echo $slide['percent_complete']; ?>%"></span>
                                </div>
                                <div class="video-slide-details border-box">
                                    <h4><?php echo $slide['title']; ?></h4>
                                    <p class="slide-text"><?php echo $slide['description']; ?></p>
                                </div>
                                <?php if($vs_dropdown_details) : ?>
                                    <label class="show-vs-drop ease3" data-video="<?php echo $slide['id']; ?>" data-type="<?php echo $slide['type']; ?>"><span class="dashicons dashicons-arrow-down-alt2"></span></label>
                                <?php endif; ?>

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
            <?php } }
        }
        if( $wpvs_my_list_enabled && $show_my_list ) {
            $my_list_home_title = get_theme_mod('wpvs_my_list_home_title', __('My List', 'vs-netflix'));
            $users_video_list = get_user_meta($wpvs_current_user->ID, 'wpvs-user-video-list', true);
            $my_list_videos = array();
            if( ! empty($users_video_list) ) {
                foreach($users_video_list as $saved_video) {
                    if($saved_video['type'] == 'video') {
                        $video_id = $saved_video['id'];
                        $video_post = get_post($video_id);
                        if($video_post && $video_post->post_type == "rvs_video") {
                            $video_home_link = wpvs_get_video_link($video_id);
                            $video_thumbnail = vs_netflix_get_video_thumbnail($video_id);
                            $my_list_videos[] = array(
                                'id' => $video_id,
                                'title' => $video_post->post_title,
                                'link' => $video_home_link,
                                'image' => $video_thumbnail,
                                'description' => $video_post->post_excerpt,
                                'type' => 'video'
                            );
                        }

                    } else {
                        $term_id = intval($saved_video['id']);
                        $wpvs_term = get_term($term_id, 'rvs_video_category');
                        if( $wpvs_term ) {
                            $wpvs_term_title = $wpvs_term->name;
                            $wpvs_term_link =  get_term_link($term_id);
                            $show_thumbnail_image = vs_netflix_get_show_thumbnail($term_id);
                            if( ! empty($wpvs_term->parent) ) {
                                $wpvs_parent_term = get_term(intval($wpvs_term->parent), 'rvs_video_category' );
                                if( ! empty($wpvs_parent_term) && ! is_wp_error($wpvs_parent_term) ) {
                                    $wpvs_term_title .= ' ('.$wpvs_parent_term->name.')';
                                }
                            }
                            $my_list_videos[] = array(
                                'id' => $term_id,
                                'title' => $wpvs_term_title,
                                'link' => $wpvs_term_link,
                                'image' => $show_thumbnail_image,
                                'description' => $wpvs_term->description,
                                'type' => 'show'
                            );
                        }
                    }
                }
            }

            if( ! empty($my_list_videos) ) {
                $my_list_item_count = count($my_list_videos); ?>
                <div class="video-category slide-category slide-container">
                    <h3><?php echo $my_list_home_title; ?></h3>
                    <div class="video-list-slider" data-items="<?php echo $my_list_item_count; ?>">
                        <?php foreach($my_list_videos as $slide) { ?>
                            <a class="video-slide" href="<?php echo $slide['link']; ?>">
                                <div class="video-slide-image border-box"><img src="<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>"/></div>
                                <div class="video-slide-details border-box">
                                    <h4><?php echo $slide['title']; ?></h4>
                                    <p class="slide-text"><?php echo $slide['description']; ?></p>
                                </div>
                                <?php if($vs_dropdown_details) : ?>
                                    <label class="show-vs-drop ease3" data-video="<?php echo $slide['id']; ?>" data-type="<?php echo $slide['type']; ?>"><span class="dashicons dashicons-arrow-down-alt2"></span></label>
                                <?php endif; ?>
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
            <?php } }
        }
    }

    if($wpvs_show_recently_added) {
        $recently_added_video_args = array(
            'post_type' => 'rvs_video',
            'posts_per_page' => $videos_per_slide,
            'meta_query' => array(
                'relation' => 'OR',
                 array(
                     'key' => 'wpvs_hide_from_recently_added',
                     'value' => '0',
                     'compare' => '='

                 ),
                 array(
                     'key' => 'wpvs_hide_from_recently_added',
                     'compare' => 'NOT EXISTS'
                 )
             )
        );
        $recently_added_video_list = get_posts($recently_added_video_args);
        if( ! empty($recently_added_video_list) ) {
            echo wpvs_create_netflix_slider_from_videos($recently_added_video_list, __('Recently Added', 'vs-netflix'), null, array());
        }
    }
    $video_categories = get_terms(array(
        'taxonomy' => 'rvs_video_category',
        'hide_empty' => false,
        'meta_key' => 'video_cat_order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
            'relation' => 'OR',
             array(
                 'key' => 'video_cat_hide',
                 'value' => '0',
                 'compare' => '='

             ),
             array(
                 'key' => 'video_cat_hide',
                 'compare' => 'NOT EXISTS'
             )
         )
    ));
    if( ! empty($video_categories) ) {
        global $wpvs_genre_slug_settings;
        foreach($video_categories as $video_category) {
            $video_slides = wpvs_generate_term_slide_thumbnails($video_category);
            $video_list = array();
            if( empty($video_slides) ) {
                $video_args = array(
                    'post_type' => 'rvs_video',
                    'posts_per_page' => $videos_per_slide,
                    'tax_query' => array(
                          array(
                             'taxonomy' => 'rvs_video_category',
                             'field' => 'term_id',
                             'terms' => $video_category->term_id
                        )
                    ),
                    'meta_query' => array(
                        'relation' => 'OR',
                         array(
                             'key' => 'rvs_hide_on_home',
                             'value' => '0',
                             'compare' => '='

                         ),
                         array(
                             'key' => 'rvs_hide_on_home',
                             'compare' => 'NOT EXISTS'
                         )
                     )
                );
                if( $rvs_video_order_settings == 'random' ) {
                    $video_args['orderby'] = 'rand';
                    $video_args['order'] = 'ASC';
                }
                if($rvs_video_order_settings == 'videoorder') {
                    $video_args['meta_key'] = 'rvs_video_post_order';
                    $video_args['orderby'] = 'meta_value_num';
                    $video_args['order'] = $rvs_video_order_direction;
                }
                if( $rvs_video_order_settings == 'alpha' ) {
                    $video_args['orderby'] = 'title';
                    $video_args['order'] = $rvs_video_order_direction;
                }
                $video_list = get_posts($video_args);
                if( ! empty($video_list) ) {
                    foreach($video_list as $video) {
                        $video_home_link = wpvs_get_video_link($video->ID);
                        $video_thumbnail = vs_netflix_get_video_thumbnail($video->ID);
                        $open_in_new_tab = get_post_meta($video->ID, 'wpvs_open_video_in_new_tab', true);
                        $video_slides[] = array(
                            'id'=> $video->ID,
                            'title' => $video->post_title,
                            'link' => $video_home_link,
                            'image' => $video_thumbnail,
                            'description' => $video->post_excerpt,
                            'type' => 'video',
                            'new_tab' => $open_in_new_tab
                        );
                    }
                }
            }

            if(!empty($video_slides)) {
                $item_count = count($video_slides);
                $title_category_url = '/'.$wpvs_genre_slug_settings['slug'].'/'.$video_category->slug;
                $title_category_link = home_url($title_category_url);
            ?>
            <div class="video-category slide-category slide-container">
                <a href="<?php echo esc_url($title_category_link); ?>"><h3><?php echo $video_category->name; ?> <span class="dashicons dashicons-arrow-right-alt2"></span></h3></a>
                <div class="video-list-slider" data-items="<?php echo $item_count; ?>">
                    <?php foreach($video_slides as $slide) { ?>
                        <a class="video-slide" href="<?php echo $slide['link']; ?>" <?php if($slide['new_tab']) { echo 'target="_blank"'; } ?>>
                            <div class="video-slide-image border-box"><img src="<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>"/></div>
                            <div class="video-slide-details border-box">
                                <h4><?php echo $slide['title']; ?></h4>
                                <p class="slide-text"><?php echo $slide['description']; ?></p>
                            </div>
                            <?php if($vs_dropdown_details) : ?>
                                <label class="show-vs-drop ease3" data-video="<?php echo $slide['id']; ?>" data-type="<?php echo $slide['type']; ?>"><span class="dashicons dashicons-arrow-down-alt2"></span></label>
                            <?php endif; ?>
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
    <?php } } } } ?>
</div>
<?php if ( have_posts() ) : ?>
<div id="main-home" class="row container">
    <div class="col-12">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
        <?php endwhile; ?>
    </div>
</div>
<?php endif; wp_reset_query(); ?>
