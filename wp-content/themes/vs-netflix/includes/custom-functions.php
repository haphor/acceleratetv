<?php

function rvs_featured_youtube_url($url) {
    $pattern = 
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
    $result = preg_match($pattern, $url, $matches);
    if (false !== $result) {
        return $matches[1];
    }
    return false;
}

if( ! function_exists('vs_netflix_get_video_thumbnail')) {
function vs_netflix_get_video_thumbnail($post_id) {
    $wpvs_image_directory = get_template_directory_uri();
    $backup_thumb = $wpvs_image_directory .'/images/set-landscape.png';
    $thumbnail_layout = get_theme_mod('vs_thumbnail_style', 'landscape');
    
    if($thumbnail_layout == 'landscape') {
        $image_layout = 'video-thumbnail';
    }
    if($thumbnail_layout == 'portrait') {
        $image_layout = 'video-portrait';
        $backup_thumb = $wpvs_image_directory .'/images/set-portrait.png';
    }
    if($thumbnail_layout == 'custom') {
        $image_layout = 'wpvs-custom-thumbnail-size';
    }
    
    $video_thumbnail_id = get_post_meta($post_id, 'wpvs_thumbnail_image_id', true);
    if( ! empty($video_thumbnail_id) ) {
        $video_thumbnail = wp_get_attachment_image_src($video_thumbnail_id, $image_layout, true)[0];
    } else {
        $video_thumbnail = get_post_meta($post_id, 'rvs_thumbnail_image', true);
    }
    
    if(empty($video_thumbnail)) {
        if(has_post_thumbnail($post_id)) {
            $video_thumbnail_id = get_post_thumbnail_id($post_id);
            $video_thumbnail = wp_get_attachment_image_src($video_thumbnail_id, $image_layout, true)[0];
        } else {
            $video_thumbnails = get_post_meta($post_id, '_rvs_video_thumbnails', true);
            if(isset($video_thumbnails[3])) {
                $video_thumbnail = $video_thumbnails[3];
            }
            if( empty($video_thumbnail) && isset($video_thumbnails[2])) {
                $video_thumbnail = $video_thumbnails[2];
            }
        }
    }
    if(empty($video_thumbnail)) {
        $video_thumbnail = $backup_thumb;
    }
    return $video_thumbnail;
}
}

if( ! function_exists('vs_netflix_get_video_header_image')) {
function vs_netflix_get_video_header_image($post_id) {
    if(has_post_thumbnail($post_id)) {
        $featured_id = get_post_thumbnail_id($post_id);
        $video_image = wp_get_attachment_image_src($featured_id, 'vs-netflix-header', true)[0];
        if(empty($video_image)) {
            $video_image = wp_get_attachment_image_src($featured_id, 'full', true)[0];
        }
    } else {
        $video_image = get_post_meta($post_id, 'wpvs_featured_image', true);
        if( empty($video_image) ) {
            $vimeo_images = get_post_meta($post_id, '_rvs_video_thumbnails', true);
            if( ! empty($vimeo_images) ) {
                $check_index = 5;
                while($check_index > 2) {
                    if(isset($vimeo_images[$check_index])) {
                        $video_image = $vimeo_images[$check_index];
                        break;
                    } else {
                        $check_index--;
                    }
                }
            }
        }
    }
    if(empty($video_image)) {
        $video_image = get_template_directory_uri() . '/images/video-featured.jpg';
    }
    return $video_image;
}
}

if( ! function_exists('rvs_get_video_details')) {
function rvs_get_video_details($post_id, $echo) {
    global $wpvs_genre_slug_settings;
    global $wpvs_actor_slug_settings;
    global $wpvs_director_slug_settings;
    $wpvs_video_review_ratings = get_theme_mod('wpvs_video_review_ratings', 0);
    $video_details = "";
    $tags = get_the_terms($post_id, 'rvs_video_tags');
    $genres = get_the_terms($post_id, 'rvs_video_category');
    
    $actor_term_args = array(
        'order' => 'ASC',
    );
    if( isset($wpvs_actor_slug_settings['ordering']) && $wpvs_actor_slug_settings['ordering'] == 'order' ) {
        $actor_term_args['meta_key'] = 'wpvs_display_order';
        $actor_term_args['orderby']  =  'meta_value_num';
    }
    $actors = wp_get_post_terms($post_id, 'rvs_actors', $actor_term_args);
    
    $director_term_args = array(
        'order' => 'ASC',
    );
    if( isset($wpvs_director_slug_settings['ordering']) && $wpvs_director_slug_settings['ordering'] == 'order' ) {
        $director_term_args['meta_key'] = 'wpvs_display_order';
        $director_term_args['orderby']  =  'meta_value_num';
    }
    $directors = wp_get_post_terms($post_id, 'rvs_directors', $director_term_args);
    
    if( $wpvs_video_review_ratings && comments_open($post_id) ) {
        $video_details .= '<div class="wpvs-video-average-rating">';
        $current_video_link = get_permalink($post_id) . '#comments';
        $video_average_rating = get_post_meta($post_id, 'wpvs_video_average_rating', true);
        if( ! empty($video_average_rating) ) {
            $video_review_args = array(
                'post_id' => $post_id,
                'fields' => 'ids',
                'status' => 'approve',
                'meta_query' => array(
                    array(
                        'key' => 'wpvs_video_rating',
                        'compare' => 'EXISTS'
                    )
                )
            );
            $video_reviews = get_comments($video_review_args);
            if( empty($video_reviews) ) {
                $count_video_ratings = 0;
            } else {
                $count_video_ratings = count($video_reviews);
            }
            for( $rating_a = 1; $rating_a <= 5; $rating_a++ ) {
                if( $rating_a <= $video_average_rating ) {
                    $video_details .= '<span class="dashicons dashicons-star-filled wpvs-video-rating-star-complete active"></span>';
                } else if($rating_a == ceil($video_average_rating) && fmod($video_average_rating, 1) != 0 ) {
                    $video_details .= '<span class="dashicons dashicons-star-half wpvs-video-rating-star-complete active"></span>';
                } else {
                    $video_details .= '<span class="dashicons dashicons-star-empty wpvs-video-rating-star-complete"></span>';
                }
            }
            $video_details .= '<label class="wpvs-video-rating-based">'.sprintf(__('based on <a class="wpvs-review-anchor" href="%s">%d reviews</a>', 'vs-netflix'), $current_video_link, $count_video_ratings).'</label></div>';
        } else {
            $video_details .= '<label class="wpvs-video-rating-based">'.sprintf(__('No reviews yet. <a class="wpvs-review-anchor" href="%s">Leave A Review</a>', 'vs-netflix'), $current_video_link).'</label></div>';
        }
    }
    
    if(!empty($actors)) {
        $video_details .= '<div id="wpvs-actor-info-section" class="rvs-info-section"><span class="dashicons dashicons-'.$wpvs_actor_slug_settings['icon'].'"></span>'.$wpvs_actor_slug_settings['name-plural'].': ';
        foreach($actors as $actor) {
            $video_details .= '<a href="'.get_site_url().'/'.$wpvs_actor_slug_settings['slug'].'/'.$actor->slug.'">'.$actor->name.'</a>';
            
            if ($actor != end($actors)) {
                $video_details .= ', ';
            }
        }
        $video_details .= '</div>';
    }

    if(!empty($directors)) {
        if(count($directors) > 1) {
            $directors_text = $wpvs_director_slug_settings['name-plural'];
        } else {
            $directors_text = $wpvs_director_slug_settings['name'];
        }
        $video_details .= '<div id="wpvs-director-info-section" class="rvs-info-section"><span class="dashicons dashicons-'.$wpvs_director_slug_settings['icon'].'"></span>'.$directors_text.': ';
        foreach($directors as $director) {
            $video_details .= '<a href="'.get_site_url().'/'.$wpvs_director_slug_settings['slug'].'/'.$director->slug.'">'.$director->name.'</a>';
            if ($director != end($directors)) {
                $video_details .= ', ';
            }
        }
        $video_details .= '</div>';
    }

    if(!empty($genres)) {
        $video_details .= '<div id="wpvs-genre-info-section" class="rvs-info-section"><span class="dashicons dashicons-'.$wpvs_genre_slug_settings['icon'].'"></span>'.$wpvs_genre_slug_settings['name-plural'].': ';
        foreach($genres as $genre) {
            $video_details .= '<a href="'.get_site_url().'/'.$wpvs_genre_slug_settings['slug'].'/'.$genre->slug.'">'.$genre->name.'</a>';
            
            if ($genre != end($genres)) {
                $video_details .= ', ';
            }
        }
        $video_details .= '</div>';
    }

    if(!empty($tags)) {
        $video_details .= '<div id="wpvs-tag-info-section" class="rvs-info-section"><span class="dashicons dashicons-tag"></span>';
        foreach($tags as $tag) {
            $video_details .= '<a href="'.get_site_url().'/video-tag/'.$tag->slug.'">'.$tag->name.'</a>';
            
            if ($tag != end($tags)) {
                $video_details .= ', ';
            }
        }
        $video_details .= '</div>';
    }

    if($echo) {
        echo $video_details;
    } else {
        return $video_details;
    }
}
}
if( ! function_exists('wpvs_theme_get_video_information')) {
function  wpvs_theme_get_video_information($post_id) {
    $video_information_string = "";
    $wpvs_video_information = get_post_meta($post_id, 'wpvs_video_information', true);
    $wpvs_video_length = get_post_meta($post_id, 'wpvs_video_length', true);
    
    if( empty($wpvs_video_information) && ! empty($wpvs_video_length) ) {
        $wpvs_video_hours = intval(gmdate("H", $wpvs_video_length));
        $wpvs_video_minutes = intval(gmdate("i", $wpvs_video_length));
        $wpvs_video_information = array(
            'length' => $wpvs_video_length,
            'hours' => $wpvs_video_hours,
            'minutes' => $wpvs_video_minutes,
            'date_released' => ""
        );
    } 
    
    if( ! empty($wpvs_video_information) ) {
        $video_information_string .= '<label class="wpvs-video-information-section">';

        if( isset($wpvs_video_information['date_released']) && ! empty($wpvs_video_information['date_released']) ) {
            $video_information_string .= '<span class="wpvs-video-release-date">'.$wpvs_video_information['date_released'].'</span>';
        }
        if( ( isset($wpvs_video_information['hours']) && ! empty($wpvs_video_information['hours']) ) || ( isset($wpvs_video_information['minutes']) && ! empty($wpvs_video_information['minutes']) ) ) {
            $video_information_string .= ' <span class="wpvs-video-length"><span class="dashicons dashicons-clock"></span>';
            if( isset($wpvs_video_information['hours']) && ! empty($wpvs_video_information['hours']) ) {
                $video_information_string .= $wpvs_video_information['hours'].'h ';
            }
            if( isset($wpvs_video_information['minutes']) && ! empty($wpvs_video_information['minutes']) ) {
                $video_information_string .= $wpvs_video_information['minutes'].'m';
            }
            $video_information_string .= '</span>';
        }
       $video_information_string .= '</label>';
    }
    return $video_information_string;
}
}

if( ! function_exists('wpvs_add_user_menu')) {
function wpvs_add_user_menu( $items, $args ) {
    $wpvs_show_login = get_theme_mod('vs_menu_login', 0);
    if($wpvs_show_login && $args->theme_location == "main") {
        if(is_user_logged_in()) {
            ob_start();                      
            include(WPVS_THEME_BASE_DIR.'/user/user-menu.php');  
            $items .= ob_get_contents();  
            ob_end_clean();
        } else { 
            $wpvs_sign_in_text = get_theme_mod('vs_menu_login_text', 'Sign In');
            $wpvs_login_link = get_theme_mod('wpvs_login_link');
            if($wpvs_login_link != "default" && !empty(get_permalink($wpvs_login_link))) {
                $user_login_link = get_permalink($wpvs_login_link);
            } else {
                $user_login_link = wp_login_url();
            }
            $items .= '<li><a class="sign-in-link" href="' . $user_login_link . '"><span class="dashicons dashicons-admin-users"></span> ' . $wpvs_sign_in_text . '</a></li>';
        }
    }
    return $items;
}
}
add_filter( 'wp_nav_menu_items', 'wpvs_add_user_menu', 10, 2 );

// GET VIDEO HTML CODE
if( ! function_exists('wpvs_get_video_html_code')) {
function wpvs_get_video_html_code($post_id) {
    $video_html = array();
    $rvs_video_type = get_post_meta($post_id, '_rvs_video_type', true);
    if(empty($rvs_video_type)) {
        $rvs_video_type = "vimeo";
    }
    if($rvs_video_type == "wordpress") {
        $rvs_wordpress_code = get_post_meta($post_id, 'rvs_video_wordpress_code', true);
        if( ! empty($rvs_wordpress_code) ) {
             $video_html['video'] = do_shortcode($rvs_wordpress_code);
        }
    } 
    
    if($rvs_video_type == "shortcode") {
        $rvs_shortcode_video = get_post_meta($post_id, 'rvs_shortcode_video', true);
        $rvs_shortcode_video_check = get_post_meta($post_id, 'rvs_shortcode_video_check', true);
        if(! empty($rvs_shortcode_video_check) && shortcode_exists($rvs_shortcode_video_check)) {
            $video_html['video'] = do_shortcode($rvs_shortcode_video);
        } else {
            $video_html['video'] = '<div class="text-align-center">'. __('Something is wrong with this videos Shortcode', 'vs-netflix') . '</div>'; 
        }
    }
    
    if($rvs_video_type == "vimeo" || $rvs_video_type == "youtube") {
        $video_html['video'] = get_post_meta($post_id, 'rvs_video_post_vimeo_html', true);
    }
    
    if($rvs_video_type == "custom") {
        $video_html['video'] = get_post_meta($post_id, 'rvs_video_custom_code', true);
    }

    // GET TRAILER
    $rvs_trailer_enabled = get_post_meta($post_id, 'rvs_trailer_enabled', true); // Check if trailer is enabled
    if($rvs_trailer_enabled) {
        $rvs_trailer_type = get_post_meta($post_id, '_rvs_trailer_type', true);
        if(empty($rvs_trailer_type)) {
            $rvs_trailer_type = "vimeo";
        }
        if($rvs_trailer_type == "wordpress") {
            $rvs_trailer_wordpress_code = get_post_meta($post_id, 'rvs_trailer_wordpress_code', true);
            if( ! empty($rvs_trailer_wordpress_code) ) {
                 $video_html['trailer'] = do_shortcode($rvs_trailer_wordpress_code);
            }
        }
        if($rvs_trailer_type == "vimeo" || $rvs_trailer_type == "youtube") {
            $video_html['trailer'] = get_post_meta($post_id, 'rvs_trailer_html', true);
        }
        
        if($rvs_trailer_type == "custom") {
            $video_html['trailer'] = get_post_meta($post_id, 'rvs_trailer_custom_code', true);
        }
    }
    return $video_html;
}
}

if( ! function_exists('vs_netflix_get_show_thumbnail')) {
function vs_netflix_get_show_thumbnail($term_id) {
    $thumbnail_layout = get_theme_mod('vs_thumbnail_style', 'landscape');
    $wpvs_image_directory = get_template_directory_uri();
    $backup_thumb = $wpvs_image_directory .'/images/set-landscape.png';
    if($thumbnail_layout == 'landscape') {
        $image_layout = 'video-thumbnail';
    } 
    if($thumbnail_layout == 'portrait') {
        $image_layout = 'video-portrait';

    }
    
    if($thumbnail_layout == 'custom') {
        $image_layout = 'wpvs-custom-thumbnail-size';
    }
    
    $cat_thumbnail_image_id = get_term_meta($term_id, 'wpvs_video_cat_attachment', true);
    if( ! empty($cat_thumbnail_image_id) ) {
        $cat_thumbnail_image = wp_get_attachment_image_src($cat_thumbnail_image_id, $image_layout, true)[0];
    } else {
        $cat_thumbnail_image =  get_term_meta($term_id, 'wpvs_video_cat_thumbnail', true);
    }
    
    if( empty($cat_thumbnail_image) ) {
        $cat_thumbnail_image = $backup_thumb;
    }
    return $cat_thumbnail_image;
}
}

function wpvs_create_my_list_button($video_id) {
    global $wpvs_current_user;
    $trans_my_list = __('My List', 'vs-netflix');
    $button_text = '<span class="dashicons dashicons-plus"></span>'.$trans_my_list;
    $add_to_list_button = array('id' => $video_id, 'type' => 'video', 'html' => $button_text, 'add' => true);
    if($wpvs_current_user) {
        
        // CHECK VIDEO TYPE
        $current_video_categories = wp_get_post_terms($video_id, 'rvs_video_category', array( 'fields' => 'all'));

        if( ! empty($current_video_categories) ) {
            foreach($current_video_categories as $video_category) {
                if($video_category->parent) {
                    $cat_has_seasons = get_term_meta($video_category->parent, 'cat_has_seasons', true);
                    if($cat_has_seasons) {
                        $add_to_list_button['type'] = "show";
                        $add_to_list_button['id'] = $video_category->parent;
                        break;
                    }
                }
            }
        }
        
        // CHECK USER VIDEO LIST
        $users_video_list = get_user_meta($wpvs_current_user->ID, 'wpvs-user-video-list', true);
        if( ! empty($users_video_list) ) {
            foreach($users_video_list as $video_list_item) {
                if($video_list_item['id'] == $add_to_list_button['id']) {
                    $add_to_list_button['html'] = '<span class="dashicons dashicons-yes"></span>'.$trans_my_list;
                    $add_to_list_button['add'] = false;
                }
            }
        }
    } 
    return $add_to_list_button;
}

if( ! function_exists('wpvs_get_video_link')) {
    function wpvs_get_video_link($video_id) {
        $video_link = get_permalink($video_id);
        $video_link_setting = get_post_meta($video_id, 'rvs_video_home_link', true);
        $video_custom_url = get_post_meta($video_id, 'wpvs_video_custom_slide_link', true);
        switch($video_link_setting) {
            case 'video':
            break;
            case 'customurl':
                $video_link = get_post_meta($video_id, 'wpvs_video_custom_slide_link', true);
            break;
            default:
                if( ! empty($video_link_setting) && $video_link_setting != 'video' ) {
                    if( ! is_wp_error( get_term_link(intval($video_link_setting), 'rvs_video_category') ) ) {
                        $video_link = get_term_link(intval($video_link_setting), 'rvs_video_category');
                    }
                }
        }
        
        $wpvs_open_videos_in_full_screen = get_theme_mod('wpvs_open_in_full_screen', 0);
        if( $wpvs_open_videos_in_full_screen && $video_link_setting != 'customurl' ) {
            if(strpos($video_link, '?page_id') || strpos($video_link, '?')) {
                $video_link .= '&';
            } else {
                $video_link .= '?';
            }
            $video_link .= 'wpvsopen=1';
        }
        return $video_link;
    }
}

if( ! function_exists('wpvs_generate_thumbnail_link')) {
    function wpvs_generate_thumbnail_link($url) {
        $wpvs_open_videos_in_full_screen = get_theme_mod('wpvs_open_in_full_screen', 0);
        if( $wpvs_open_videos_in_full_screen ) {
            if(strpos($url, '?page_id') || strpos($url, '?')) {
                $url .= '&';
            } else {
                $url .= '?';
            }
            $url .= 'wpvsopen=1';
        }
        return $url;
    }
}

function wpvs_generate_term_slide_thumbnails($video_category) {
    $video_slides = array();
    $contains_shows = get_term_meta($video_category->term_id, 'cat_contains_shows', true);
    $children_shows = get_terms( 'rvs_video_category', array('parent' => $video_category->term_id) );
    if($contains_shows) {
        $children_cats = get_terms( 'rvs_video_category', array('parent' => $video_category->term_id) );
        if( ! empty($children_cats) ) {
            foreach($children_cats as $child) {
                $child_has_seasons = get_term_meta($child->term_id, 'cat_has_seasons', true);
                if($child_has_seasons) {
                    $child_link = get_term_link($child->term_id);
                    $child_thumbnail_image = vs_netflix_get_show_thumbnail($child->term_id);
                    $video_slides[] = array(
                        'id'=> $child->term_id, 
                        'title' => $child->name, 
                        'link' => $child_link, 
                        'image' => $child_thumbnail_image, 
                        'description' => $child->description, 
                        'type' => 'show',
                        'new_tab' => 0
                    );
                }
            }
        }
    }

    if( ! $contains_shows && ! empty($children_shows) ) {
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
    }
    return $video_slides;
}

function wpvs_generate_video_slide_thumbnail($video_category) {
    $video_slide_details = array();
    $category_has_seasons = get_term_meta($video_category->term_id, 'cat_has_seasons', true);
    if($category_has_seasons) {
        $child_link = get_term_link($video_category->term_id);
        $child_thumbnail_image = vs_netflix_get_show_thumbnail($video_category->term_id);
        $video_slide_details = array(
            'id'=> $video_category->term_id, 
            'title' => $video_category->name, 
            'link' => $child_link, 
            'image' => $child_thumbnail_image, 
            'description' => $video_category->description, 
            'type' => 'show',
            'new_tab' => 0
        );
    }

    if( empty($video_slide_details) && ! empty($video_category->parent) ) {
        $parent_has_seasons = get_term_meta($video_category->parent, 'cat_has_seasons', true);
        if($parent_has_seasons) {
            $parent_category = get_term($video_category->parent, 'rvs_video_category');
            $child_link = get_term_link($parent_category->term_id);
            $child_thumbnail_image = vs_netflix_get_show_thumbnail($parent_category->term_id);
            $video_slide_details = array(
                'id'=> $parent_category->term_id, 
                'title' => $parent_category->name, 
                'link' => $child_link, 
                'image' => $child_thumbnail_image, 
                'description' => $parent_category->description, 
                'type' => 'show',
                'new_tab' => 0
            );
        }
    } 
    return $video_slide_details;
}

function wpvs_create_netflix_slider_from_videos($video_list, $title, $title_link, $wpvs_parameters) {
    global $vs_dropdown_details;
    $wpvs_slider_content = "";
    $wpvs_clean_layout = false;
    $video_slides = array();
    
    if( isset($wpvs_parameters['style']) && $wpvs_parameters['style'] == "clean" ) {
        $wpvs_clean_layout = true;
    }
    
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
        if( ! empty($video_slides) ) {
            $recent_item_count = count($video_slides);
            $wpvs_slider_content .= '<div class="video-category slide-category slide-container';
            if( $wpvs_clean_layout ) {
                $wpvs_slider_content .= ' slide-shortcode';
            }
            $wpvs_slider_content .= '">';
            
            if( ! empty($title_link) ) {
                $wpvs_slider_content .= '<a href="'.$title_link.'">';
            }
            $wpvs_slider_content .= '<h3>';
            $wpvs_slider_content .= $title;
            if( ! empty($title_link) ) {
                $wpvs_slider_content .= ' <span class="dashicons dashicons-arrow-right-alt2"></span>';
            }
            $wpvs_slider_content .= '</h3>';
            if( ! empty($title_link) ) {
                $wpvs_slider_content .= '</a>';
            }
            
            $wpvs_slider_content .= '<div class="video-list-slider" data-items="'.$recent_item_count.'">';
            foreach($video_slides as $slide) {
                $wpvs_slider_content .= '<a class="video-slide" href="'.$slide['link'].'"';
                
                if( $slide['new_tab'] ) {
                    $wpvs_slider_content .= ' target="_blank" ';
                }
                
                $wpvs_slider_content .= '>';
                
                $wpvs_slider_content .= '<div class="video-slide-image border-box"><img src="'.$slide['image'].'" alt="'.$slide['title'].'" /></div>';
                $wpvs_slider_content .= '<div class="video-slide-details border-box">';
                $wpvs_slider_content .= '<h4>'.$slide['title'].'</h4>';
                $wpvs_slider_content .= '<p class="slide-text">'.$slide['description'].'</p></div>';
                if($vs_dropdown_details) :
                    $wpvs_slider_content .= '<label class="show-vs-drop ease3" data-video="'.$slide['id'].'" data-type="'.$slide['type'].'"><span class="dashicons dashicons-arrow-down-alt2"></span></label>';
                endif;
                $wpvs_slider_content .= '</a>';
            }
            $wpvs_slider_content .= '</div></div>';
            if($vs_dropdown_details) {
                $wpvs_slider_content .= '<div class="vs-video-description-drop border-box';
                if( $wpvs_clean_layout ) {
                    $wpvs_slider_content .= ' wpvs-shortcode-drop';
                }
                $wpvs_slider_content .= '"><label class="wpvs-close-video-drop"><span class="dashicons dashicons-no-alt"></span></label><div class="drop-loading border-box"><label class="net-loader"></label></div></div>';
            } 
        }
    }
    return $wpvs_slider_content;
}
