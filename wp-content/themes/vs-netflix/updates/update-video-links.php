<?php

$all_video_args = array(
    'post_type' => 'rvs_video',
    'posts_per_page' => -1,
    'nopaging' => true,
    'fields' => 'ids'
);

$update_all_videos = get_posts($all_video_args);

if( ! empty($update_all_videos) ) {
    foreach($update_all_videos as $update_video_id) {
        update_post_meta(  $update_video_id, 'rvs_video_home_link', 'video');
    }
}
