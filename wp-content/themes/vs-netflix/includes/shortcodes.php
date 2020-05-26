<?php
function vs_netflix_category_shortcode( $atts ) {
    global $vs_dropdown_details;
    global $wpvs_genre_slug_settings;
    $wpvs_video_category_content = "";
    $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
    $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
    $get_video_category = shortcode_atts( array(
        'cat' => '0',
        'count' => 'all',
        'style' => null
    ), $atts );

    $video_category = get_term($get_video_category['cat'], 'rvs_video_category');
    $videos_per_slide = $get_video_category['count'];
    if($videos_per_slide == "all") {
        $videos_per_slide = -1;
    }

    $video_args = array(
        'post_type' => 'rvs_video',
        'posts_per_page' => $videos_per_slide,
        'tax_query' => array(
              array(
                 'taxonomy' => 'rvs_video_category',
                 'field' => 'term_id',
                 'terms' => $video_category->term_id
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
        $category_link = '/'.$wpvs_genre_slug_settings['slug'].'/'.$video_category->slug;
        $wpvs_video_category_content .= wpvs_create_netflix_slider_from_videos($video_list, $video_category->name, $category_link, $get_video_category);
    }
    return $wpvs_video_category_content;
}
add_shortcode( 'netflix-category', 'vs_netflix_category_shortcode' );

function vs_netflix_categories_shortcode( $atts ) {
    global $vs_dropdown_details;
    global $wpvs_genre_slug_settings;
    $wpvs_clean_layout = false;
    $wpvs_video_categories_content = "";
    $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
    $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
    $theme_videos_per_slide = get_theme_mod('vs_videos_per_slider', '10');
    $get_per_slide = shortcode_atts( array(
        'perslide' => $theme_videos_per_slide,
        'style' => null
    ), $atts );

    if( isset($get_per_slide['style']) && $get_per_slide['style'] == "clean" ) {
        $wpvs_clean_layout = true;
    }

    if( isset($get_per_slide['perslide']) && ! empty($get_per_slide['perslide']) ) {
        $videos_per_slide = $get_per_slide['perslide'];
        if($videos_per_slide == "all") {
            $videos_per_slide = -1;
        }
    }

    $video_categories = get_terms(array(
        'taxonomy' => 'rvs_video_category',
        'parent' => 0,
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
        foreach($video_categories as $video_category) {
            $video_slides = array();
            $video_list = array();
            $contains_shows = get_term_meta($video_category->term_id, 'cat_contains_shows', true);
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

            } else {
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
                $wpvs_video_categories_content .= '<div class="video-category slide-category slide-container';
                if( $wpvs_clean_layout ) {
                    $wpvs_video_categories_content .= ' slide-shortcode';
                }
                $wpvs_video_categories_content .= '">';
                $wpvs_video_categories_content .= '<a href="/'.$wpvs_genre_slug_settings['slug'].'/'.$video_category->slug.'"><h3>'.$video_category->name.' <span class="dashicons dashicons-arrow-right-alt2"></span></h3></a>';
                $wpvs_video_categories_content .= '<div class="video-list-slider" data-items="'.$item_count.'">';
                foreach($video_slides as $slide) {
                    $wpvs_video_categories_content .= '<a class="video-slide" href="'.$slide['link'].'"';
                    if( $slide['new_tab'] ) {
                        $wpvs_video_categories_content .= ' target="_blank" ';
                    }
                    $wpvs_video_categories_content .= '>';
                    $wpvs_video_categories_content .= '<div class="video-slide-image border-box"><img src="'.$slide['image'].'" alt="'.$slide['title'].'" /></div>';
                    $wpvs_video_categories_content .= '<div class="video-slide-details border-box">';
                    $wpvs_video_categories_content .= '<h4>'.$slide['title'].'</h4>';
                    $wpvs_video_categories_content .= '<p class="slide-text">'.$slide['description'].'</p>';
                    $wpvs_video_categories_content .= '</div>';
                    if($vs_dropdown_details) {
                        $wpvs_video_categories_content .= '<label class="show-vs-drop ease3" data-video="'.$slide['id'].'" data-type="'.$slide['type'].'"><span class="dashicons dashicons-arrow-down-alt2"></span></label>';
                    }
                    $wpvs_video_categories_content .= '</a>';
                }
                $wpvs_video_categories_content .= '</div></div>';
                if($vs_dropdown_details) {
                    $wpvs_video_categories_content .= '<div class="vs-video-description-drop border-box';
                    if( $wpvs_clean_layout ) {
                        $wpvs_video_categories_content .= ' wpvs-shortcode-drop';
                    }
                    $wpvs_video_categories_content .= '"><label class="wpvs-close-video-drop"><span class="dashicons dashicons-no-alt"></span></label><div class="drop-loading border-box"><label class="net-loader"></label></div></div>';
                }
            }
        }
    }
    return $wpvs_video_categories_content;
}
add_shortcode( 'netflix-categories', 'vs_netflix_categories_shortcode' );

// ADD SHORTCODES TO COLUMNS

function rvs_video_category_columns( $columns )
{
	$columns['video_shortcode'] = __('Shortcode', 'vs-netflix');

	return $columns;
}
add_filter('manage_edit-rvs_video_category_columns' , 'rvs_video_category_columns');

function rvs_video_category_columns_content( $content, $column_name, $term_id )
{
    if ( 'video_shortcode' == $column_name ) {
        $content = '[netflix-category cat="'.$term_id.'" count="6"]';
    }
	return $content;
}
add_filter( 'manage_rvs_video_category_custom_column', 'rvs_video_category_columns_content', 10, 3 );

function rvs_netflix_user_rentals( $atts ) {
    $wpvs_user_rentals_content = "";
    if(is_user_logged_in()) {
        $wpvs_atts = shortcode_atts( array(
            'show_customer_menu' => '0'
        ), $atts );
        global $wpvs_current_user;
        global $vs_dropdown_details;
        global $wpvs_watch_now_text;
        $remove_video_list_padding = false;
        $wpvs_grid_count_variables = array(
            'large'   => get_theme_mod('wpvs_grid_count_large', 6),
            'desktop' => get_theme_mod('wpvs_grid_count_desktop', 5),
            'laptop'  => get_theme_mod('wpvs_grid_count_laptop', 4),
            'tablet'  => get_theme_mod('wpvs_grid_count_tablet', 3),
            'mobile'  => get_theme_mod('wpvs_grid_count_mobile', 2)
        );
        if( ! wp_script_is( 'user-videos-ajax-js', 'enqueued' ) ) {
            wp_enqueue_script( 'user-videos-ajax-js');
        }
        wp_localize_script( 'user-videos-ajax-js', 'userajax',
            array( 'userid' =>$wpvs_current_user->ID, 'url' => admin_url( 'admin-ajax.php' ), 'watchtext' =>  $wpvs_watch_now_text, 'dropdown' => $vs_dropdown_details, 'hourstext' =>  __('hours left', 'vs-netflix')) );
        if( ! wp_script_is( 'video-ajax-js', 'enqueued' ) ) {
            wp_enqueue_script( 'video-ajax-js');
        }
        wp_localize_script( 'video-ajax-js', 'loadvideosajax', array( 'dropdown' => $vs_dropdown_details, 'count' => $wpvs_grid_count_variables ) );
        $rvs_account_sub_menu = get_option('rvs_account_sub_menu', 1);
        if( $rvs_account_sub_menu && function_exists('wpvs_generate_customer_menu') && $wpvs_atts['show_customer_menu'] ) {
            $wpvs_user_rentals_content .= wpvs_generate_customer_menu("rentals");
            $remove_video_list_padding = true;
        }
        rvs_check_rentals_purchases($wpvs_current_user->ID);
        $user_rentals = rvs_get_user_rentals($wpvs_current_user->ID);
        if( empty($user_rentals) ) {
            global $wpvs_video_slug_settings;
            $videos_link = home_url('/'.$wpvs_video_slug_settings['slug']);
            $wpvs_user_rentals_content .= '<h4>'.__('You have not rented any videos', 'vs-netflix').'</h4>';
            $wpvs_user_rentals_content .= '<a class="rvs-button rvs-primary-button" href="'.$videos_link.'">'.__('Browse videos', 'vs-netflix').'</a>';
        } else {
            $wpvs_user_rentals_content .= '<div class="video-list';
            if( $remove_video_list_padding ) {
                $wpvs_user_rentals_content .= ' account-video-list';
            }
            $wpvs_user_rentals_content .= '"><div id="loading-video-list" class="drop-loading border-box"><label class="net-loader"></label></div><div id="video-list-loaded" data-type="rentals"><div id="video-list"></div></div></div>';
        }
    }
    return $wpvs_user_rentals_content;
}

function rvs_netflix_user_purchases( $atts ) {
    $wpvs_user_purchases_content = "";
    if(is_user_logged_in()) {
        $wpvs_atts = shortcode_atts( array(
            'show_customer_menu' => '0'
        ), $atts );
        global $wpvs_current_user;
        global $vs_dropdown_details;
        global $wpvs_watch_now_text;
        $remove_video_list_padding = false;
        $wpvs_grid_count_variables = array(
            'large'   => get_theme_mod('wpvs_grid_count_large', 6),
            'desktop' => get_theme_mod('wpvs_grid_count_desktop', 5),
            'laptop'  => get_theme_mod('wpvs_grid_count_laptop', 4),
            'tablet'  => get_theme_mod('wpvs_grid_count_tablet', 3),
            'mobile'  => get_theme_mod('wpvs_grid_count_mobile', 2)
        );
        if( ! wp_script_is( 'user-videos-ajax-js', 'enqueued' ) ) {
            wp_enqueue_script( 'user-videos-ajax-js');
        }
        wp_localize_script( 'user-videos-ajax-js', 'userajax',
            array( 'userid' =>$wpvs_current_user->ID, 'url' => admin_url( 'admin-ajax.php' ), 'watchtext' =>  $wpvs_watch_now_text, 'dropdown' => $vs_dropdown_details, 'hourstext' =>  __('hours left', 'vs-netflix')) );
        if( ! wp_script_is( 'video-ajax-js', 'enqueued' ) ) {
            wp_enqueue_script( 'video-ajax-js');
        }
        wp_localize_script( 'video-ajax-js', 'loadvideosajax', array( 'dropdown' => $vs_dropdown_details, 'count' => $wpvs_grid_count_variables ) );
        $rvs_account_sub_menu = get_option('rvs_account_sub_menu', 1);
        if( $rvs_account_sub_menu && function_exists('wpvs_generate_customer_menu') && $wpvs_atts['show_customer_menu'] ) {
            $wpvs_user_purchases_content .= wpvs_generate_customer_menu("purchases");
            $remove_video_list_padding = true;
        }
        rvs_check_rentals_purchases($wpvs_current_user->ID);
        $user_purchases = rvs_get_user_purchases($wpvs_current_user->ID);
        $user_term_purchases = wpvs_get_user_term_purchases($wpvs_current_user->ID);
        if( empty($user_purchases) && empty($user_term_purchases) ) {
            global $wpvs_video_slug_settings;
            $videos_link = home_url('/'.$wpvs_video_slug_settings['slug']);
            $wpvs_user_purchases_content .= '<h4>'.__('You have not purchased any videos', 'vs-netflix').'</h4>';
            $wpvs_user_purchases_content .= '<a class="rvs-button rvs-primary-button" href="'.$videos_link.'">'.__('Browse videos', 'vs-netflix').'</a>';
        } else {
            $wpvs_user_purchases_content .= '<div class="video-list';
            if( $remove_video_list_padding ) {
                $wpvs_user_purchases_content .= ' account-video-list';
            }
            $wpvs_user_purchases_content .= '"><div id="loading-video-list" class="drop-loading border-box"><label class="net-loader"></label></div><div id="video-list-loaded" data-type="purchases"><div id="video-list"></div></div></div>';
        }
    }
    return $wpvs_user_purchases_content;
}

function wpvs_users_saved_video_list( $atts ) {
    $wpvs_user_my_list_content = "";
    if(is_user_logged_in()) {
        $wpvs_atts = shortcode_atts( array(
            'show_customer_menu' => '0'
        ), $atts );
        global $wpvs_my_list_enabled;
        global $wpvs_current_user;
        global $vs_dropdown_details;
        global $wpvs_watch_now_text;
        $remove_video_list_padding = false;
        $wpvs_grid_count_variables = array(
            'large'   => get_theme_mod('wpvs_grid_count_large', 6),
            'desktop' => get_theme_mod('wpvs_grid_count_desktop', 5),
            'laptop'  => get_theme_mod('wpvs_grid_count_laptop', 4),
            'tablet'  => get_theme_mod('wpvs_grid_count_tablet', 3),
            'mobile'  => get_theme_mod('wpvs_grid_count_mobile', 2)
        );
        if( ! wp_script_is( 'user-videos-ajax-js', 'enqueued' ) ) {
            wp_enqueue_script( 'user-videos-ajax-js');
        }
        wp_localize_script( 'user-videos-ajax-js', 'userajax',
                array( 'userid' =>$wpvs_current_user->ID, 'url' => admin_url( 'admin-ajax.php' ), 'watchtext' =>  $wpvs_watch_now_text, 'dropdown' => $vs_dropdown_details, 'hourstext' =>  __('hours left', 'vs-netflix')) );
        if( ! wp_script_is( 'video-ajax-js', 'enqueued' ) ) {
            wp_enqueue_script( 'video-ajax-js');
        }
        wp_localize_script( 'video-ajax-js', 'loadvideosajax', array( 'dropdown' => $vs_dropdown_details, 'count' => $wpvs_grid_count_variables ) );
        $rvs_account_sub_menu = get_option('rvs_account_sub_menu', 1);
        if( $rvs_account_sub_menu && function_exists('wpvs_generate_customer_menu') && $wpvs_atts['show_customer_menu'] ) {
            $wpvs_user_my_list_content .= wpvs_generate_customer_menu("mylist");
            $remove_video_list_padding = true;
        }
        if($wpvs_my_list_enabled) {
            $users_video_list = get_user_meta($wpvs_current_user->ID, 'wpvs-user-video-list', true);
            if( ! empty($users_video_list) ) {
                $wpvs_user_my_list_content .= '<div class="video-list';
                if( $remove_video_list_padding ) {
                    $wpvs_user_my_list_content .= ' account-video-list';
                }
                $wpvs_user_my_list_content .= '"><div id="loading-video-list" class="drop-loading border-box"><label class="net-loader"></label></div><div id="video-list-loaded" data-type="mylist"><div id="video-list"></div></div></div>';
            } else {
                global $wpvs_video_slug_settings;
                $videos_link = home_url('/'.$wpvs_video_slug_settings['slug']);
                $wpvs_user_my_list_content .= '<h4>'.__('You have not added any videos to your list.', 'vs-netflix').'</h4>';
                $wpvs_user_my_list_content .= '<a class="rvs-button rvs-primary-button" href="'.$videos_link.'">'.__('Browse videos', 'vs-netflix').'</a>';
            }
        } else {
            $wpvs_user_my_list_content .= '<p>'.__('The site administrator has disabled the My List feature.', 'vs-netflix').'</p>';
        }
    }
    return $wpvs_user_my_list_content;
}

function wpvs_recently_added_videos_shortcode( $atts ) {
    $videos_per_slide = get_theme_mod('vs_videos_per_slider', '10');
    $wpvs_parameters = shortcode_atts( array(
        'perslide' => $videos_per_slide,
        'style' => null
    ), $atts );

    if( isset($wpvs_parameters['perslide']) && ! empty($wpvs_parameters['perslide']) ) {
        $videos_per_slide = $wpvs_parameters['perslide'];
        if($videos_per_slide == "all") {
            $videos_per_slide = -1;
        }
    }

    $wpvs_recently_added_content = "";
    $recent_video_slides = array();
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
        $wpvs_recently_added_content .= wpvs_create_netflix_slider_from_videos($recently_added_video_list, __('Recently Added', 'vs-netflix'), null, $wpvs_parameters);
    }
    return $wpvs_recently_added_content;
}

add_shortcode('rvs_user_rentals', 'rvs_netflix_user_rentals');
add_shortcode('rvs_user_purchases', 'rvs_netflix_user_purchases');
add_shortcode('rvs_user_my_list', 'wpvs_users_saved_video_list');
add_shortcode('wpvs_display_recently_added', 'wpvs_recently_added_videos_shortcode');
