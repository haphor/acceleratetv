<?php

function wpvs_update_video_category_thumbnails() {
    $rvs_video_categories = get_terms('rvs_video_category', array('hide_empty' => false));
    if( ! empty($rvs_video_categories) ) {
        foreach($rvs_video_categories as $video_category) {
            $cat_thumb_landscape = get_term_meta($video_category->term_id, 'video_cat_landscape', true);
            $cat_thumb_portrait = get_term_meta($video_category->term_id, 'video_cat_portrait', true);
            $cat_thumb_attachment = get_term_meta($video_category->term_id, 'video_cat_attachment', true);
            $cat_attachment_id = null;
            if( ! empty($cat_thumb_landscape) ) {
                $cat_attachment_id = wpvs_get_thumbnail_attachment_id($cat_thumb_landscape);
                update_term_meta($video_category->term_id, 'wpvs_video_cat_thumbnail', $cat_thumb_landscape);
            }
            
            if( ! empty($cat_thumb_portrait) ) {
                if( empty($cat_attachment_id) ) {
                    $cat_attachment_id = wpvs_get_thumbnail_attachment_id($cat_thumb_portrait);
                }
            }
            
            if( ! empty($cat_thumb_attachment) && empty($cat_attachment_id) ) {
                $cat_attachment_id = $cat_thumb_attachment;
            }
            
            if( ! empty($cat_attachment_id) ) {
                update_term_meta($video_category->term_id, 'wpvs_video_cat_attachment', $cat_attachment_id);
            }
            delete_term_meta($video_category->term_id, 'video_cat_portrait', true);
            delete_term_meta($video_category->term_id, 'video_cat_attachment', true);
        }
    }
}
add_action('init', 'wpvs_update_video_category_thumbnails');

function wpvs_update_videos_thumbnail_ids() {
    $all_video_args = array(
        'post_type' => 'rvs_video',
        'posts_per_page' => -1,
        'nopaging' => true,
        'fields' => 'ids'
    );

    $update_all_videos = get_posts($all_video_args);

    if( ! empty($update_all_videos) ) {
        foreach($update_all_videos as $update_video_id) {
            $new_thumbnail_id = null;
            $video_thumbnail = get_post_meta($update_video_id, 'rvs_thumbnail_image', true);
            if( ! empty($video_thumbnail) ) {
                $new_thumbnail_id = wpvs_get_thumbnail_attachment_id( $video_thumbnail );
            } 
            
            if( ! empty($new_thumbnail_id) ) {
                update_post_meta($update_video_id, 'wpvs_thumbnail_image_id', $new_thumbnail_id);
            }
        }
    }
}
add_action('init', 'wpvs_update_videos_thumbnail_ids');

function wpvs_get_thumbnail_attachment_id( $url ) {
	$attachment_id = 0;
	$dir = wp_upload_dir();
	if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) {
		$file = basename( $url );
		$query_args = array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'fields'      => 'ids',
			'meta_query'  => array(
				array(
					'value'   => $file,
					'compare' => 'LIKE',
					'key'     => '_wp_attachment_metadata',
				),
			)
		);
		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			foreach ( $query->posts as $post_id ) {
				$meta = wp_get_attachment_metadata( $post_id );
				$original_file       = basename( $meta['file'] );
				$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
				if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
					$attachment_id = $post_id;
					break;
				}
			}
		}
	}
	return $attachment_id;
}