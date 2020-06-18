<?php

function wpvs_update_video_category_home_hide() {
    $rvs_video_categories = get_terms('rvs_video_category', array('parent' => 0, 'hide_empty' => false));
    if( ! empty($rvs_video_categories) ) {
        foreach($rvs_video_categories as $video_category) {
            $child_video_cats = get_term_children( $video_category->term_id, 'rvs_video_category' );
            if( !empty($child_video_cats) ) {
                foreach($child_video_cats as $child_cat) {
                    update_term_meta($child_cat, 'video_cat_hide', 1);
                }
            }
        }
        update_option('wpvs-theme-updates-seen', 0);
    }
    
}
add_action('init', 'wpvs_update_video_category_home_hide');