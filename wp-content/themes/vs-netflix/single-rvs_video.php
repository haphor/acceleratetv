<?php get_header();
global $post;
$vs_display_layout = get_post_meta($post->ID, 'rvs_video_template', true);
if(empty($vs_display_layout) || $vs_display_layout == "default") {
    $vs_display_layout = get_theme_mod('vs_single_layout', 'standard');
}
if( $vs_display_layout == 'standard' || $vs_display_layout == 'youtube' ) {
    $wpvs_show_more_videos_below_standard = get_theme_mod('wpvs_show_more_videos_below_standard', 0);
}
global $widget_videos;
global $wpvs_current_user;
global $wpvs_my_list_enabled;
$video_html_code = wpvs_get_video_html_code($post->ID);
$rvs_trailer_enabled = get_post_meta($post->ID, 'rvs_trailer_enabled', true);
$wpvs_autoplay = get_option('rvs_video_autoplay', 0);
$wpvs_video_review_ratings = get_theme_mod('wpvs_video_review_ratings', 0);
$custom_content = "";
$show_video_content = false;
$wpvs_video_has_restriction = false;
$full_screen_access = false;
$no_access_preview = false;
$video_download_link = null;
$video_restricted_content = 'video';
$members_can_download = false;
$full_screen_content = '<div id="vs-full-screen-login" class="border-box">';
if( empty($wpvs_current_user) ) {
    $full_screen_content .= '<div id="vs-login-content">';
} else {
    $full_screen_content .= '<div id="vs-login-content" class="logged-in">';
    $users_continue_watching_list = get_user_meta($wpvs_current_user->ID, 'wpvs_users_continue_watching_list', true);
}
if( class_exists('WPVS_Customer') ) {
    $wpvs_customer = new WPVS_Customer($wpvs_current_user);
    $vs_access_layout = get_theme_mod('vs_single_access_layout', 'standard');
    $rvs_video_membership_list = get_post_meta( $post->ID, '_rvs_memberships', true ); // Get Memberships
    $video_onetime_price = get_post_meta( $post->ID, '_rvs_onetime_price', true ); // GET ONETIME PRICE
    $video_rental_price = get_post_meta( $post->ID, 'rvs_rental_price', true ); // GET RENTAL PRICE
    $wpvs_free_for_users = get_post_meta( $post->ID, '_rvs_membership_users_free', true );
    $video_download_link = get_post_meta( $post->ID, 'rvs_video_download_link', true );
    $video_restricted_content = get_post_meta($post->ID, 'wpvs_restricted_video_content', true);
    if( empty($video_restricted_content) ) {
        $video_restricted_content = 'video';
    }
    if( ! empty($video_download_link) ) {
        $members_can_download = get_post_meta( $post->ID, 'wpvs_members_can_download', true );
        if( $members_can_download ) {
            $wpvs_required_download_memberships = get_post_meta($post->ID, 'wpvs_required_download_memberships', true);
            if( ! empty($wpvs_required_download_memberships) && is_array($wpvs_required_download_memberships) && ! empty($wpvs_current_user) ) {
                $members_can_download = false;
                foreach($wpvs_required_download_memberships as $required_download_membership_id) {
                    if( ! empty($wpvs_customer->user) && $wpvs_customer->has_membership($required_download_membership_id) ) {
                        $members_can_download = true;
                        break;
                    }
                }
            }
        }

        $download_link_text = get_post_meta( $post->ID, 'wpvs_download_link_text', true );
        if( empty($download_link_text) ) {
            $download_link_text = __('Download', 'vimeosync');
        }
    }

    if(function_exists('wpvs_get_additional_payment_options')) {
        $wpvs_video_terms = wp_get_post_terms( $post->ID, 'rvs_video_category', array('fields' => 'id=>parent') );
        $wpvs_additional_payment_options = wpvs_get_additional_payment_options($wpvs_video_terms);
        $wpvs_additional_memberships = $wpvs_additional_payment_options['memberships'];
        $wpvs_additional_purchase_options = $wpvs_additional_payment_options['purchases'];
        $rvs_video_membership_list = array_merge($rvs_video_membership_list, $wpvs_additional_memberships);
    }

    if( ! empty($rvs_video_membership_list) || ! empty($video_onetime_price) || ! empty($video_rental_price) || $wpvs_free_for_users || ! empty($wpvs_additional_purchase_options) ) {
        $wpvs_video_has_restriction = true;
    }
    if ( is_user_logged_in() ) {
        if($wpvs_free_for_users || current_user_can( 'manage_options' )) {
            $show_video_content = true;
        }

        $has_membership = $wpvs_customer->has_access($rvs_video_membership_list, $post->ID);

        if($has_membership['has_access']) {
            $show_video_content = true;
        }

        if( ! $wpvs_video_has_restriction ) {
            $show_video_content = true;
        }

        if( ! $show_video_content) {
            $user_term_purchases = get_user_meta($wpvs_current_user->ID, 'rvs_user_term_purchases', true);
            if( ! empty($user_term_purchases) && ! empty($wpvs_additional_purchase_options) ) {
                foreach($user_term_purchases as $purchased_term) {
                    if( in_array($purchased_term, $wpvs_additional_purchase_options) ) {
                        $show_video_content = true;
                        break;
                    }
                }
            }
        }

        if(isset($_GET['vsp']) && $_GET['vsp'] == 'noaccess') {
            $show_video_content = false;
            $no_access_preview = true;
        }

        if(!$show_video_content) {

            if($vs_access_layout == "standard") {
                $custom_content .= '<div class="container row">';
                $custom_content .= rvs_memberships_content_payments($has_membership, $rvs_video_membership_list, $video_onetime_price, $video_rental_price, $wpvs_additional_purchase_options);
                $custom_content .= '</div>';
            } else {
                $full_screen_access = true;
                $full_screen_content .= rvs_memberships_content_payments($has_membership, $rvs_video_membership_list, $video_onetime_price, $video_rental_price, $wpvs_additional_purchase_options);
            }
        }

        if($show_video_content) {
            $custom_content .= $video_html_code['video'];
        }
    } else {
        if( ! $wpvs_video_has_restriction ) {
            $show_video_content = true;
            $custom_content .= $video_html_code['video'];
            $full_screen_access = false;
        } else {
            // STANDARD NO ACCESS CONTENT
            if($vs_access_layout == "standard") :
                $custom_content .= rvs_not_logged_in();
            else :
                $full_screen_access = true;
                $full_screen_content .= '<h3 class="text-align-center">' . __('This content is for members only', 'vs-netflix') . '</h3>';
                ob_start();
                include(get_template_directory().'/template/full-screen-access.php');
                $full_screen_content .= ob_get_contents();
                ob_end_clean();
            endif;
        }
    }
} else {
    $show_video_content = true;
    $custom_content .= $video_html_code['video'];
}
if($wpvs_my_list_enabled) {
    $add_to_my_list_button = wpvs_create_my_list_button($post->ID);
}

if($vs_display_layout == "youtube") :
    include(WPVS_THEME_BASE_DIR.'/template/single-video-youtube.php');
elseif($vs_display_layout == "netflix") :
    include(WPVS_THEME_BASE_DIR.'/template/single-video-netflix.php');
else :
    include(WPVS_THEME_BASE_DIR.'/template/single-video-standard.php');
endif;
?>
