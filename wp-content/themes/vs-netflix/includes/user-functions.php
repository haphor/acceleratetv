<?php 
add_action( 'wp_ajax_wpvs_add_video_to_user_list', 'wpvs_add_video_to_user_list' );
function wpvs_add_video_to_user_list() {
    if(is_user_logged_in() ) {
        if( isset($_POST['video_id']) && ! empty($_POST['video_id']) ) {
            global $wpvs_current_user;
            $video_id = $_POST['video_id'];
            $video_type = $_POST['video_type'];
            $video_exists = false;
            $users_video_list = get_user_meta($wpvs_current_user->ID, 'wpvs-user-video-list', true);
            if( empty($users_video_list) ) {
                $users_video_list = array();
            } else {
                foreach($users_video_list as $video_list_item) {
                    if($video_list_item['id'] == $video_id) {
                        $video_exists = true;
                        break;
                    }
                }
            }
            
            if($_POST['add_video']) {
                if(!$video_exists) {
                    $new_item = array('id' => $video_id, 'type' => $video_type);
                    $users_video_list[] = $new_item;
                }
            } else {
                if( ! empty($users_video_list) ) {
                    foreach($users_video_list as $key => $video_list_item) {
                        if($video_list_item['id'] == $video_id) {
                            unset($users_video_list[$key]);
                            break;
                        }
                    }
                }
            }
            update_user_meta($wpvs_current_user->ID, 'wpvs-user-video-list', $users_video_list);
        } else {
            wpvs_exit_ajax_request("Missing a video.", 404);
            exit;
        }
    } else {
        wpvs_exit_ajax_request("You must be logged in.", 400);
        exit;
    }
    wp_die();
}

function wpvs_added_to_user_list($video_id) {
    global $wpvs_current_user;
    $added_to_users_list = false;
    $users_video_list = get_user_meta($wpvs_current_user->ID, 'wpvs-user-video-list', true);
    if( ! empty($users_video_list) ) {
        foreach($users_video_list as $video_list_item) {
            if($video_list_item['id'] == $video_id) {
                $added_to_users_list = true;
                break;
            }
        }
    }
    return $added_to_users_list;
}

add_action( 'wp_ajax_wpvs_load_user_videos_ajax_request', 'wpvs_load_user_videos_ajax_request' );

function wpvs_load_user_videos_ajax_request() {
    if( is_user_logged_in() ) {
        global $wpvs_current_user;
        if ( isset($_POST['purchase_type']) && ! empty($_POST['purchase_type']) ) {
            $offset = $_POST['video_offset'];
            $purchase_type = $_POST['purchase_type'];
            $videos_per_page =  $_POST['videos_per_page'];
            $slides_array = array();

            if($purchase_type == 'purchases') {
                $user_purchases = rvs_get_user_purchases($wpvs_current_user->ID);
                foreach($user_purchases as $purchase) {
                    $video_download_link = "";
                    $video_id = $purchase['id'];
                    $video_title = get_the_title($video_id);
                    $video_link = get_the_permalink($video_id);
                    $video_thumbnail = vs_netflix_get_video_thumbnail($video_id);
                    $video_excerpt = get_the_excerpt($video_id);
                    $video_download_link = get_post_meta( $video_id, 'rvs_video_download_link', true );
                    $slides_array[] = array('video_id' => $video_id, 'video_title' => $video_title, 'video_excerpt' => $video_excerpt, 'video_thumbnail' => $video_thumbnail, 'video_link' => $video_link, 'type' => 'video', 'download_link' => $video_download_link);
                }
                
                $user_term_purchases = wpvs_get_user_term_purchases($wpvs_current_user->ID);
                if( ! empty($user_term_purchases) ) {
                    foreach($user_term_purchases as $purchase) {
                        $term_id = intval($purchase['id']);
                        $wpvs_term = $purchase['term'];
                        $wpvs_term_link = get_term_link($term_id, 'rvs_video_category');
                        $wpvs_term_title = $wpvs_term->name;
                        $show_thumbnail_image = vs_netflix_get_show_thumbnail($term_id);
                        if( ! empty($wpvs_term->parent) ) {
                            $wpvs_parent_term = get_term(intval($wpvs_term->parent), 'rvs_video_category' );
                            if( ! empty($wpvs_parent_term) && ! is_wp_error($wpvs_parent_term) ) {
                                $wpvs_term_title .= ' ('.$wpvs_parent_term->name.')';
                            }
                        }
                        $slides_array[] = array('video_id' => $term_id, 'video_title' => $wpvs_term_title, 'video_excerpt' => $wpvs_term->description, 'video_thumbnail' => $show_thumbnail_image, 'video_link' => $wpvs_term_link, 'type' => 'show');
                    }
                }
            }
            
            if($purchase_type == 'rentals') {
                $user_rentals = rvs_get_user_rentals($wpvs_current_user->ID);
                if(!empty($user_rentals)) {
                    foreach($user_rentals as $rental) {
                        $hour_diff = "";
                        $video_id = $rental['id'];
                        $video = $rental['video'];
                        $rental_expires = $rental['expires'];
                        if($rental_expires > time()) {
                            $hour_diff = round(($rental_expires - time())/3600, 0);
                        }
                        $video_title = $video->post_title; 
                        $video_link = get_permalink($video_id); 
                        $video_thumbnail = vs_netflix_get_video_thumbnail($video_id);
                        $video_excerpt = get_the_excerpt($video_id);
                        $slides_array[] = array('video_id' => $video_id, 'video_title' => $video_title, 'video_excerpt' => $video_excerpt, 'video_thumbnail' => $video_thumbnail, 'video_link' => $video_link, 'type' => 'video', 'rental_time_left' => $hour_diff);
                    }
                }
            }
            
            if($purchase_type == 'mylist') {
                $users_video_list = get_user_meta($wpvs_current_user->ID, 'wpvs-user-video-list', true);
                if(!empty($users_video_list)) {
                    foreach($users_video_list as $saved_video) {
                        if($saved_video['type'] == 'video') {
                            $video_id = $saved_video['id'];
                            $video_title = get_the_title($video_id); 
                            $video_link = get_permalink($video_id); 
                            $video_thumbnail = vs_netflix_get_video_thumbnail($video_id);
                            $video_excerpt = get_the_excerpt($video_id);
                            $slides_array[] = array('video_id' => $video_id, 'video_title' => $video_title, 'video_excerpt' => $video_excerpt, 'video_thumbnail' => $video_thumbnail, 'video_link' => $video_link, 'type' => 'video');
                        } else {
                            $term_id = intval($saved_video['id']);
                            $wpvs_term = get_term($term_id, 'rvs_video_category');
                            $wpvs_term_title = $wpvs_term->name; 
                            $wpvs_term_link =  get_term_link($term_id);
                            $show_thumbnail_image = vs_netflix_get_show_thumbnail($term_id);
                            if( ! empty($wpvs_term->parent) ) {
                                $wpvs_parent_term = get_term(intval($wpvs_term->parent), 'rvs_video_category' );
                                if( ! empty($wpvs_parent_term) && ! is_wp_error($wpvs_parent_term) ) {
                                    $wpvs_term_title .= ' ('.$wpvs_parent_term->name.')';
                                }
                            }
                            $slides_array[] = array('video_id' => $term_id, 'video_title' => $wpvs_term_title, 'video_excerpt' => $wpvs_term->description, 'video_thumbnail' => $show_thumbnail_image, 'video_link' => $wpvs_term_link, 'type' => 'show');
                        }
                    }
                }
            }
            
            if( ! empty($slides_array) ) {
                echo json_encode(array('videos' => $slides_array, 'added' => $wpvs_ajax_terms_added));
            } else {
                echo "none";
            }
        } else {
            status_header(404);
            echo "none";
            exit;
        }
    } else {
        wpvs_exit_ajax_request("You must be logged in.", 400);
        exit;
    }
    
    wp_die();
}

add_action( 'wp_ajax_wpvs_add_video_continue_watching_list', 'wpvs_add_video_continue_watching_list' );
function wpvs_add_video_continue_watching_list() {
    if(is_user_logged_in() ) {
        if( isset($_POST['video_id']) && ! empty($_POST['video_id']) && isset($_POST['video_current_time']) && isset($_POST['video_length']) && ! empty($_POST['video_length']) ) {
            global $wpvs_current_user;
            $video_id = $_POST['video_id'];
            $video_current_time = $_POST['video_current_time'];
            $video_length = $_POST['video_length'];
            $percent_complete = bcdiv($video_current_time, $video_length, 2);
            $percent_complete = $percent_complete * 100;
            $video_updated = false;
            $users_continue_watching_list = get_user_meta($wpvs_current_user->ID, 'wpvs_users_continue_watching_list', true);
            
            // CREATE NEW VIDEO TRACKING ARRAY
            $new_video_tracking = array(
                'id' => $video_id,
                'current_time' => $video_current_time, // in seconds
                'length' => $video_length, // in seconds
                'percent_complete' => $percent_complete,
                'last_updated' => current_time('timestamp'),
            );
            if( empty($users_continue_watching_list) ) {
                $users_continue_watching_list = array();
            } else {
                foreach($users_continue_watching_list as $key => $video_list_item) {
                    if($video_list_item['id'] == $video_id) {
                        $users_continue_watching_list[$key] = $new_video_tracking;
                        $video_updated = true;
                        break;
                    }
                }
            }
           
            if( ! $video_updated ) {
                $users_continue_watching_list[] = $new_video_tracking;
            }

            update_user_meta($wpvs_current_user->ID, 'wpvs_users_continue_watching_list', $users_continue_watching_list);
        } else {
            wpvs_exit_ajax_request("Missing a video.", 404);
            exit;
        }
    } else {
        wpvs_exit_ajax_request("You must be logged in.", 400);
        exit;
    }
    wp_die();
}

add_action( 'wp_ajax_wpvs_remove_video_continue_watching_list', 'wpvs_remove_video_continue_watching_list' );
function wpvs_remove_video_continue_watching_list() {
    if(is_user_logged_in() ) {
        if( isset($_POST['video_id']) && ! empty($_POST['video_id']) ) {
            global $wpvs_current_user;
            $video_id = $_POST['video_id'];
            $users_continue_watching_list = get_user_meta($wpvs_current_user->ID, 'wpvs_users_continue_watching_list', true);

            if( ! empty($users_continue_watching_list) ) {
                foreach($users_continue_watching_list as $key => $video_list_item) {
                    if($video_list_item['id'] == $video_id) {
                        unset($users_continue_watching_list[$key]);
                        break;
                    }
                }
                update_user_meta($wpvs_current_user->ID, 'wpvs_users_continue_watching_list', $users_continue_watching_list);
            }
        } else {
            wpvs_exit_ajax_request("Missing a video.", 404);
            exit;
        }
    } else {
        wpvs_exit_ajax_request("You must be logged in.", 400);
        exit;
    }
    wp_die();
}