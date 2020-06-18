<?php
global $wp_query;
$has_sidebar = false;
$filter_text = $wpvs_genre_slug_settings['name-plural'];
if( ! empty($current_term) ) {
    $filter_text = $current_term->name;
}
global $cat_has_seasons;
if($cat_has_seasons) {
    $filter_text = $wpvs_genre_slug_settings['name-seasons'];
}
if( function_exists('wpvs_is_current_term_purchase') ) {
    $wpvs_is_term_purchase = wpvs_is_current_term_purchase();
    if( ! empty($wpvs_is_term_purchase) ) {
        echo '<div class="wpvs-term-checkout border-box"><div class="container row"><div class="col-12"><label id="close-wpvs-checkout" class="border-box"><span class="dashicons dashicons-no-alt"></span></label>'.$wpvs_is_term_purchase.'</div></div></div>';
    }
}
?>
<div class="category-top border-box ease3">
    <div id="category-breadcrumbs" class="border-box">
        <h3>
        <?php if(!empty($parent) && !is_wp_error($parent)) {
            $parent_link = get_term_link($parent->term_id);
            $parent_title = '<span class="dashicons dashicons-arrow-left"></span> '.$parent->name;
       } else {
            global $wpvs_video_slug_settings;
            $parent_link = home_url('/'.$wpvs_video_slug_settings['slug']);
            $parent_title = __('Browse', 'vs-netflix');
        } ?>
            <a href="<?php echo $parent_link; ?>"><?php echo $parent_title; ?></a>
        </h3>
    </div>
    <?php if(!empty($children_taxomonies)) { $has_sidebar = true; ?>
        <label id="open-sub-video-cats"><?php echo $filter_text; ?> <span class="dashicons dashicons-arrow-down"></span></label>
        <div id="select-sub-category">
            <?php foreach($children_taxomonies as $child) {
                $term_link = get_term_link($child->term_id);
                if($wp_query->get_queried_object_id() == $child->term_id) {
                    echo '<a class="sub-video-cat active" href="'.$term_link.'">'.$child->name.' <span class="dashicons dashicons-arrow-right"></span></a>';
                } else {
                    echo '<a class="sub-video-cat" href="'.$term_link.'">'.$child->name.' <span class="dashicons dashicons-arrow-right"></span></a>';
                }

            } ?>
        </div>
    <?php } ?>
</div>
<?php if( ! empty($current_term) ) { ?>
    <div class="row video-cat-description border-box">
        <h2><?php echo $current_term->name; ?></h2>
        <?php echo term_description(); ?>
    </div>
<?php } ?>
<div id="vs-netflix-slide-loader" class="drop-loading"><label class="net-loader"></label></div>
<div id="video-list-container" class="ease5">
<?php
    if(!empty($children_taxomonies)) {
        global $wpvs_genre_slug_settings;
        global $vs_dropdown_details;
        $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
        $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
        $videos_per_slide = get_theme_mod('vs_videos_per_slider', '10');
        foreach($children_taxomonies as $child) {
            $video_slides = array();
            $video_list = array();
            $contains_shows = get_term_meta($child->term_id, 'cat_contains_shows', true);
            $children_shows = get_terms( 'rvs_video_category', array('parent' => $child->term_id) );
            if($contains_shows) {
                if( ! empty($children_shows) ) {
                    foreach($children_shows as $show_child) {
                        $child_has_seasons = get_term_meta($show_child->term_id, 'cat_has_seasons', true);
                        if($child_has_seasons) {
                            $child_link = get_term_link($show_child->term_id);
                            $child_thumbnail_image = vs_netflix_get_show_thumbnail($show_child->term_id);
                            $video_slides[] = array(
                                'id'=> $show_child->term_id,
                                'title' => $show_child->name,
                                'link' => $child_link,
                                'image' => $child_thumbnail_image,
                                'description' => $show_child->description,
                                'type' => 'show',
                                'new_tab' => 0
                            );
                        }
                    }
                }

            } else if( ! empty($children_shows) ) {
                foreach($children_shows as $show_child) {
                    $child_contains_shows = get_term_meta($show_child->term_id, 'cat_contains_shows', true);
                    if($child_contains_shows) {
                        $sub_child_shows = get_terms( 'rvs_video_category', array('parent' => $show_child->term_id) );
                        if( ! empty($sub_child_shows) ) {
                            foreach($sub_child_shows as $sub_show_child) {
                                $sub_child_has_seasons = get_term_meta($sub_show_child->term_id, 'cat_has_seasons', true);
                                if($sub_child_has_seasons) {
                                    $child_link = get_term_link($sub_show_child->term_id);
                                    $child_thumbnail_image = vs_netflix_get_show_thumbnail($sub_show_child->term_id);
                                    $video_slides[] = array(
                                        'id'=> $sub_show_child->term_id,
                                        'title' => $sub_show_child->name,
                                        'link' => $child_link,
                                        'image' => $child_thumbnail_image,
                                        'description' => $sub_show_child->description,
                                        'type' => 'show',
                                        'new_tab' => 0
                                    );
                                }
                            }
                        }
                    }
                }
            } else {
                $video_args = array(
                    'post_type' => 'rvs_video',
                    'posts_per_page' => $videos_per_slide,
                    'tax_query' => array(
                          array(
                             'taxonomy' => 'rvs_video_category',
                             'field' => 'term_id',
                             'terms' => $child->term_id
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
            }
            if(!empty($video_list)) {
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

            if(!empty($video_slides)) {
                $item_count = count($video_slides);
                $title_category_url = '/'.$wpvs_genre_slug_settings['slug'].'/'.$child->slug;
                $title_category_link = home_url($title_category_url);
            ?>
            <div class="video-category slide-category slide-container page-video-category">
                <a href="<?php echo esc_url($title_category_link); ?>"><h3><?php echo $child->name; ?> <span class="dashicons dashicons-arrow-right-alt2"></span></h3></a>
                <div class="video-list-slider" data-items="<?php echo $item_count; ?>">
                    <?php foreach($video_slides as $slide) { ?>
                        <a class="video-slide" href="<?php echo $slide['link']; ?>" <?php if($slide['new_tab']) { echo 'target="_blank"'; } ?>>
                            <div class="video-slide-image border-box"><img src="<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>" /></div>
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
