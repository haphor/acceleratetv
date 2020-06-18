<?php

function wpvs_update_home_featured_area_v2() {
    $wpvs_sliders = get_option('slider_array');
    $wpvs_block_section = get_option('block_section');
    if( ! empty($wpvs_sliders) ) {
        update_option('wpvs_slider_array', $wpvs_sliders);
    }
    
    if( ! empty($wpvs_block_section)) {
		update_option('wpvs_block_section', $wpvs_block_section);
	}
    
    $front_page_id = get_option( 'page_on_front' );
    
    if( ! empty(get_post($front_page_id)) ) {
        $wpvs_theme_home_slider_type = get_option( 'wpvs_theme_home_slider_type', 'default' );
        if( empty($wpvs_theme_home_slider_type) || $wpvs_theme_home_slider_type == "default") {
            $current_slide_setting = get_post_meta( $front_page_id, '_rogue_slider', true );
            if( ! empty($current_slide_setting) ) {
                update_post_meta( $front_page_id, 'wpvs_featured_area_slider', $current_slide_setting);
                update_post_meta( $front_page_id, 'wpvs_featured_area_slider_type', 'default');
            }
        }
        
        if($wpvs_theme_home_slider_type == "featuredvideo") {
            $youtube_url = "";
            $youtube_id = "";
            $vimeo_url = "";
            $vimeo_id = "";
            $muted_setting = get_option('rvs-mute-home-video');
            if($muted_setting) {
                $muted_setting = 1;
            } else {
                $muted_setting = 0;
            }
            $featured_video_id = get_option('rvs-featured-home-video');
            
            if( ! empty( get_post($featured_video_id) ) ) {
                $featured_video = get_post($featured_video_id);
                $video_title = $featured_video->post_title;
                $video_description = $featured_video->post_excerpt;
                $video_link = get_permalink($featured_video_id);
                $video_type = get_post_meta($featured_video_id, '_rvs_trailer_type', true);
                if( $video_type == 'vimeo') {
                    $vimeo_id = get_post_meta($featured_video_id, 'rvs_trailer_vimeo_id', true);
                    if( ! empty($vimeo_id) ) {
                        $vimeo_url = 'https://player.vimeo.com/video/' . $vimeo_id;
                    } else {
                        $trailer_html = get_post_meta($featured_video_id, 'rvs_trailer_html', true);
                        $trailer_html_src = explode('src="', $trailer_html);
                        $trailer_html_src = explode('"', $trailer_html_src[1]);
                        $trailer_html_src = explode('video/', $trailer_html_src[0]);
                        $trailer_html_src = explode('?', $trailer_html_src[1]);
                        $vimeo_id = $trailer_html_src[0];
                        $vimeo_url = 'https://player.vimeo.com/video/' . $vimeo_id;
                    }

                }
                
                if( $video_type == 'youtube') {
                    $youtube_url = get_post_meta($featured_video_id, 'rvs_trailer_youtube_url', true);
                    parse_str( parse_url( $youtube_url, PHP_URL_QUERY ), $get_youtube_id );
                    if( isset($get_youtube_id['v'])) {
                         $youtube_id = $get_youtube_id['v'];
                    }
                }

                $wpvs_sliders = get_option('wpvs_slider_array');
                $wpvs_block_section = get_option('wpvs_block_section');
                
                if( empty($wpvs_sliders) ) {
                    $wpvs_sliders = array();
                }
                
                if( empty($wpvs_block_section) || $wpvs_block_section < 1 ) {
                    $wpvs_block_section = 1;
                }

                $new_slide = array(
                    'image' => '',
                    'image_alt' => '',
                    'title' => $video_title,
                    'description' => $video_description,
                    'link_text' => 'Watch Now',
                    'link' => $video_link,
                    'tab' => false,
                    'whole' => false,
                    'backgroundtype' => $video_type,
                    'videoid' => '',
                    'videourl' => '',
                    'youtubeurl' => $youtube_url,
                    'youtubeid' => $youtube_id,
                    'vimeourl' => $vimeo_url,
                    'vimeoid' => $vimeo_id,
                    'muted' => $muted_setting,
                );

                $newSlider = array(
                    'id' => $wpvs_block_section, 
                    'name' => 'Featured Video', 
                    'count'=> 1, 
                    'blocks' => array($new_slide)
                );

                array_push($wpvs_sliders, $newSlider);
                
                update_option('wpvs_slider_array', $wpvs_sliders);
                update_option('wpvs_block_section', $wpvs_block_section + 1 );
                update_post_meta( $front_page_id, 'wpvs_featured_area_slider', $wpvs_block_section);
            }
            update_post_meta( $front_page_id, 'wpvs_featured_area_slider_type', 'default');
        }
        
        if($wpvs_theme_home_slider_type == "shortcode") {
            update_post_meta( $front_page_id, 'wpvs_featured_area_slider_type', 'shortcode');
        }
        
        if($wpvs_theme_home_slider_type == "none") {
            update_post_meta( $front_page_id, 'wpvs_featured_area_slider_type', 'none');
        }
        
    }
    delete_option('rvs-featured-home-video');
    delete_option('rvs-mute-home-video');
    delete_option('wpvs_theme_home_slider_type');
    delete_option('block_section');
    delete_option('slider_array');
    
}
add_action('init', 'wpvs_update_home_featured_area_v2');