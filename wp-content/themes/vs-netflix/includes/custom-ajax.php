<?php
add_action( 'wp_ajax_rvs_load_videos_ajax_request', 'rvs_load_videos_ajax_request' );
add_action( 'wp_ajax_nopriv_rvs_load_videos_ajax_request', 'rvs_load_videos_ajax_request' );

function rvs_load_videos_ajax_request() {
    if ( isset($_POST['video_offset']) ) {
        $offset = $_POST['video_offset'];
        $term_type = $_POST['term_type'];
        $videos_per_page =  $_POST['videos_per_page'];
        $slides_array = array();
        $additional_offset = false;
        if($term_type != "none" && isset($_POST['video_cat']) && !empty($_POST['video_cat'])) {
            $video_tax = $_POST['video_cat'];
            if($term_type == "category") {
                $contains_shows = get_term_meta($video_tax, 'cat_contains_shows', true);
                $cat_has_seasons = get_term_meta($video_tax, 'cat_has_seasons', true);
                if($contains_shows) {
                    $children_shows = get_terms( 'rvs_video_category', array('parent' => $video_tax) );
                    if(!empty($children_shows)) : foreach($children_shows as $show) :
                        $show_has_seasons = get_term_meta($show->term_id, 'cat_has_seasons', true);
                        if($show_has_seasons) :
                            $show_link = get_term_link($show->term_id);
                            $show_thumbnail_image = vs_netflix_get_show_thumbnail($show->term_id);
                            $slides_array[] = array(
                                'video_id' => $show->term_id,
                                'video_title' => $show->name,
                                'video_excerpt' => $show->description,
                                'video_thumbnail' => $show_thumbnail_image,
                                'video_link' => $show_link,
                                'type' => 'show'
                            );
                        else :
                            $sub_shows = get_terms( 'rvs_video_category', array('parent' => $show->term_id) );
                            if( ! empty($sub_shows) ) :
                                foreach($sub_shows as $sub_show) :
                                    $show_link = get_term_link($sub_show->term_id);
                                    $show_thumbnail_image = vs_netflix_get_show_thumbnail($sub_show->term_id);
                                    $slides_array[] = array('video_id' => $sub_show->term_id, 'video_title' => $sub_show->name, 'video_excerpt' => $sub_show->description, 'video_thumbnail' => $show_thumbnail_image, 'video_link' => $show_link, 'type' => 'show');
                                endforeach;
                            endif;
                        endif;
                    endforeach; endif;
                } else {
                    $children_categories = get_terms( 'rvs_video_category', array('parent' => $video_tax) );
                    if(!empty($children_categories)) {
                        foreach($children_categories as $child_video_cat) {
                            $child_contains_shows = get_term_meta($child_video_cat->term_id, 'cat_contains_shows', true);
                            if($child_contains_shows) {
                                $children_shows = get_terms( 'rvs_video_category', array('parent' => $child_video_cat->term_id) );
                                if(!empty($children_shows)) {
                                    foreach($children_shows as $show) {
                                        $show_has_seasons = get_term_meta($show->term_id, 'cat_has_seasons', true);
                                        if($show_has_seasons) {
                                            $show_link = get_term_link($show->term_id);
                                            $show_thumbnail_image = vs_netflix_get_show_thumbnail($show->term_id);
                                            $slides_array[] = array('video_id' => $show->term_id, 'video_title' => $show->name, 'video_excerpt' => $show->description, 'video_thumbnail' => $show_thumbnail_image, 'video_link' => $show_link, 'type' => 'show');
                                        } else {
                                            $sub_shows = get_terms( 'rvs_video_category', array('parent' => $show->term_id) );
                                            if( ! empty($sub_shows) ) {
                                                foreach($sub_shows as $sub_show) {
                                                    $show_link = get_term_link($sub_show->term_id);
                                                    $show_thumbnail_image = vs_netflix_get_show_thumbnail($sub_show->term_id);
                                                    $slides_array[] = array('video_id' => $sub_show->term_id, 'video_title' => $sub_show->name, 'video_excerpt' => $sub_show->description, 'video_thumbnail' => $show_thumbnail_image, 'video_link' => $show_link, 'type' => 'show');
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if( isset($_POST['videoid']) && ! empty($_POST['videoid']) ) {
                    $video_id = $_POST['videoid'];
                    $video_terms_array = array($video_tax);
                    $all_terms_found = false;
                    $current_video_tax = get_term($video_tax, 'rvs_video_category');
                    while( !$all_terms_found ) {
                        if( ! empty($current_video_tax->parent) ) {
                            $current_video_tax = get_term($current_video_tax->parent, 'rvs_video_category');
                            $video_terms_array[] = $current_video_tax->term_id;
                        } else {
                            $all_terms_found = true;
                        }
                    }
                    $video_args = array(
                        'post_type' => 'rvs_video',
                        'posts_per_page' => $videos_per_page,
                        'post__not_in' => array($video_id),
                        'offset' => $offset,
                        'fields' => 'ids',
                        'tax_query' => array(
                              array(
                                 'taxonomy' => 'rvs_video_category',
                                 'field' => 'term_id',
                                 'terms' => $video_terms_array
                            )
                        ),
                    );

                }

                if( empty($slides_array) && empty($video_args) ) {
                    $video_args = array(
                        'post_type' => 'rvs_video',
                        'posts_per_page' => $videos_per_page,
                        'offset' => $offset,
                        'fields' => 'ids',
                        'tax_query' => array(
                              array(
                                 'taxonomy' => 'rvs_video_category',
                                 'field' => 'term_id',
                                 'terms' => $video_tax
                            )
                        )
                    );
                }
            }

            if($term_type == "tag") {
                $video_args = array(
                    'post_type' => 'rvs_video',
                    'posts_per_page' => $videos_per_page,
                    'offset' => $offset,
                    'fields' => 'ids',
                    'tax_query' => array(
                          array(
                             'taxonomy' => 'rvs_video_tags',
                             'field' => 'term_id',
                             'terms' => $video_tax
                        )
                    )
                );
            }

            if($term_type == "actor") {
                $video_args = array(
                    'post_type' => 'rvs_video',
                    'posts_per_page' => $videos_per_page,
                    'offset' => $offset,
                    'fields' => 'ids',
                    'tax_query' => array(
                          array(
                             'taxonomy' => 'rvs_actors',
                             'field' => 'term_id',
                             'terms' => $video_tax
                        )
                    )
                );
            }

            if($term_type == "director") {
                $video_args = array(
                    'post_type' => 'rvs_video',
                    'posts_per_page' => $videos_per_page,
                    'offset' => $offset,
                    'fields' => 'ids',
                    'tax_query' => array(
                          array(
                             'taxonomy' => 'rvs_directors',
                             'field' => 'term_id',
                             'terms' => $video_tax
                        )
                    )
                );
            }

        } else {
            $video_args = array(
                'post_type' => 'rvs_video',
                'posts_per_page' => $videos_per_page,
                'offset' => $offset,
                'fields' => 'ids',
            );
        }
        $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
        $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
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

        if( empty($slides_array) ) {
            $wpvs_ajax_terms_added = array();
            if( isset($_POST['terms_added']) && ! empty($_POST['terms_added']) ) {
                foreach($_POST['terms_added'] as $remove_term) {
                    $wpvs_ajax_terms_added[] = intval($remove_term);
                }
                $video_args['tax_query'] = array(
                    'taxonomy' => 'rvs_video_category',
                    'field'    => 'term_id',
                    'terms' => $wpvs_ajax_terms_added,
                    'operator' => 'NOT IN'
                );
            }

            $video_list = get_posts($video_args);
            if(!empty($video_list)) {
                foreach($video_list as $video_id) {
                    $add_this_video = true;
                    if($term_type == "none") {
                        $this_video_categories = wp_get_post_terms($video_id, 'rvs_video_category', array( 'fields' => 'all'));
                        if( ! empty($this_video_categories) ) {
                            foreach($this_video_categories as $video_category) {
                                if($video_category->parent) {
                                    if( ! in_array($video_category->parent, $wpvs_ajax_terms_added) ) {
                                        $this_cat_has_seasons = get_term_meta($video_category->parent, 'cat_has_seasons', true);
                                        if($this_cat_has_seasons) {
                                            $show_term = get_term($video_category->parent, 'rvs_video_category');
                                            $show_link = get_term_link($show_term->term_id);
                                            $show_thumbnail_image = vs_netflix_get_show_thumbnail($show_term->term_id);
                                            $slides_array[] = array('video_id' => $show_term->term_id, 'video_title' => $show_term->name, 'video_excerpt' => $show_term->description, 'video_thumbnail' => $show_thumbnail_image, 'video_link' => $show_link, 'type' => 'show');
                                            $wpvs_ajax_terms_added[] = intval($show_term->term_id);
                                            $add_this_video = false;
                                        }
                                    } else {
                                        $add_this_video = false;
                                    }
                                }
                            }
                        }
                    }
                    if($add_this_video) {
                        $video_title = get_the_title($video_id);
                        $video_link = get_the_permalink($video_id);
                        $video_link = wpvs_generate_thumbnail_link($video_link);
                        $video_thumbnail = vs_netflix_get_video_thumbnail($video_id);
                        $open_in_new_tab = get_post_meta($video_id, 'wpvs_open_video_in_new_tab', true);
                        $video_excerpt = get_the_excerpt($video_id);
                        $slides_array[] = array(
                            'video_id' => $video_id,
                            'video_title' => $video_title,
                            'video_excerpt' => $video_excerpt, 
                            'video_thumbnail' => $video_thumbnail,
                            'video_link' => $video_link,
                            'type' => 'video',
                            'new_tab' => $open_in_new_tab
                        );
                    }
                }
                if( $term_type == "none" && count($slides_array) < $videos_per_page ) {
                    $add_offset = $offset + $videos_per_page;
                    $more_videos_count = intval($videos_per_page) - count($slides_array);
                    while($more_videos_count > 0) {
                        $more_videos_found = wpvs_get_additional_videos($add_offset, $more_videos_count, $wpvs_ajax_terms_added);
                        $merge_more_videos = $more_videos_found['videos'];
                        $add_offset = $more_videos_found['new_offset'];
                        $additional_offset = $add_offset;
                        $more_videos_count = $more_videos_found['need'];
                        if(! empty($more_videos_found['terms']) ) {
                            foreach($more_videos_found['terms'] as $add_term) {
                                if( ! in_array($add_term, $wpvs_ajax_terms_added) ) {
                                    $wpvs_ajax_terms_added[] = $add_term;
                                }
                            }
                        }
                        if( ! empty($merge_more_videos) ) {
                            $slides_array = array_merge($slides_array, $merge_more_videos);
                        } else {
                            if($prev_offset == $add_offset) {
                                break;
                            }
                        }

                        $prev_offset = $add_offset;

                        if( empty($more_videos_count) ) {
                            break;
                        }
                    }
                }
            }
        }

        if( ! empty($slides_array) ) {
            echo json_encode(array('videos' => $slides_array, 'offset' => $additional_offset, 'added' => $wpvs_ajax_terms_added));
        } else {
            echo "none";
        }
    } else {
        status_header(404);
        echo "none";
    }

    wp_die();
}

add_action( 'wp_ajax_rvs_search_videos', 'rvs_search_videos' );
add_action( 'wp_ajax_nopriv_rvs_search_videos', 'rvs_search_videos' );

function wpvs_get_additional_videos($offset, $videos_per_page, $wpvs_terms_added) {
    $more_videos_needed = $videos_per_page;
    $additional_video_array = array();
    $add_video_args = array(
        'post_type' => 'rvs_video',
        'posts_per_page' => $videos_per_page,
        'offset' => $offset,
        'fields' => 'ids',
    );

    $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
    $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
    if( $rvs_video_order_settings == 'random' ) {
        $add_video_args['orderby'] = 'rand';
        $add_video_args['order'] = 'ASC';
    }
    if($rvs_video_order_settings == 'videoorder') {
        $add_video_args['meta_key'] = 'rvs_video_post_order';
        $add_video_args['orderby'] = 'meta_value_num';
        $add_video_args['order'] = $rvs_video_order_direction;
    }
    if( $rvs_video_order_settings == 'alpha' ) {
        $add_video_args['orderby'] = 'title';
        $add_video_args['order'] = $rvs_video_order_direction;
    }
    if( ! empty($wpvs_terms_added) ) {
        $add_video_args['tax_query'] = array(
            'taxonomy' => 'rvs_video_category',
            'field'    => 'term_id',
            'terms' => $wpvs_terms_added,
            'operator' => 'NOT IN'
        );
    }

    $additional_video_list = get_posts($add_video_args);

    if(!empty($additional_video_list)) {
        foreach($additional_video_list as $video_id) {
            $add_this_video = true;
            $this_video_categories = wp_get_post_terms($video_id, 'rvs_video_category', array( 'fields' => 'all'));
            if( ! empty($this_video_categories) ) {

                foreach($this_video_categories as $video_category) {
                    if($video_category->parent) {
                        if( ! in_array($video_category->parent, $wpvs_terms_added) ) {
                            $this_cat_has_seasons = get_term_meta($video_category->parent, 'cat_has_seasons', true);
                            if($this_cat_has_seasons) {
                                $show_term = get_term($video_category->parent, 'rvs_video_category');
                                $show_link = get_term_link($show_term->term_id);
                                $show_thumbnail_image = vs_netflix_get_show_thumbnail($show_term->term_id);
                                $additional_video_array[] = array('video_id' => $show_term->term_id, 'video_title' => $show_term->name, 'video_excerpt' => $show_term->description, 'video_thumbnail' => $show_thumbnail_image, 'video_link' => $show_link, 'type' => 'show');
                                $wpvs_terms_added[] = intval($show_term->term_id);
                                $add_this_video = false;
                                $more_videos_needed--;
                            }
                        } else {
                            $add_this_video = false;
                        }
                    }
                }
            }
            if($add_this_video) {
                $video_title = get_the_title($video_id);
                $video_link = get_the_permalink($video_id);
                $video_link = wpvs_generate_thumbnail_link($video_link);
                $video_thumbnail = vs_netflix_get_video_thumbnail($video_id);
                $open_in_new_tab = get_post_meta($video_id, 'wpvs_open_video_in_new_tab', true);
                $video_excerpt = get_the_excerpt($video_id);
                $additional_video_array[] = array(
                    'video_id' => $video_id,
                    'video_title' => $video_title,
                    'video_excerpt' => $video_excerpt,
                    'video_thumbnail' => $video_thumbnail,
                    'video_link' => $video_link,
                    'type' => 'video',
                    'new_tab' => $open_in_new_tab
                );
                $more_videos_needed--;
            }
            $offset++;
        }
    }

    if($more_videos_needed <= 0) {
        $more_videos_needed = 0;
    }
    return array('videos' => $additional_video_array, 'new_offset' => $offset, 'need' => $more_videos_needed, 'terms' =>  $wpvs_terms_added);

}

function rvs_search_videos() {
    if(isset($_POST['search_term']) && !empty($_POST['search_term'])) {
        global $wpvs_genre_slug_settings;
        global $wpvs_actor_slug_settings;
        global $wpvs_director_slug_settings;
        $match_term = $_POST['search_term'];
        $found_videos = array();
        $found_genres = array();
        $found_actors = array();
        $found_tags = array();
        $include_actors = array();
        $include_directors = array();
        $include_tags = array();
        $excluded_found_videos = array();
        $found_directors = array();
        $wpvs_profile_backup = get_template_directory_uri() .'/images/profile.png';
        $video_genres = get_terms(array(
            'taxonomy' => 'rvs_video_category',
            'hide_empty' => true
        ));

        $video_actors = get_terms(array(
            'taxonomy' => 'rvs_actors',
            'hide_empty' => false
        ));

        $video_directors = get_terms(array(
            'taxonomy' => 'rvs_directors',
            'hide_empty' => false
        ));

        $video_tags = get_terms(array(
            'taxonomy' => 'rvs_video_tags',
            'hide_empty' => false
        ));

        if(!empty($video_genres)) {
            foreach( $video_genres as $genre) {
                if(stripos($genre->name, $match_term) !== false) {
                    $genre_link = '/'.$wpvs_genre_slug_settings['slug'].'/'. $genre->slug;
                    $found_genres[] = array('genre_link' => $genre_link, 'genre_title' => $genre->name);
                }
            }
        }

        if(!empty($video_actors)) {
            foreach($video_actors as $actor) {
                if(stripos($actor->name, $match_term) !== false) {
                    $profile_image = get_term_meta($actor->term_id, 'wpvs_actor_profile', true);
                    if( empty($profile_image) ) {
                        $profile_image = $wpvs_profile_backup;
                    }
                    $imdb_link = get_term_meta($actor->term_id, 'wpvs_actor_imdb_link', true);
                    $actor_link = '/'.$wpvs_actor_slug_settings['slug'].'/'. $actor->slug;
                    $found_actors[] = array('actor_link' => $actor_link, 'actor_title' => $actor->name, 'actor_image' => $profile_image);
                    $include_actors[] = $actor->term_id;
                }
            }
        }

        if(!empty($video_directors)) {
            foreach($video_directors as $director) {
                if(stripos($director->name, $match_term) !== false) {
                    $profile_image = get_term_meta($director->term_id, 'wpvs_actor_profile', true);
                    if( empty($profile_image) ) {
                        $profile_image = $wpvs_profile_backup;
                    }
                    $director_link = '/'.$wpvs_director_slug_settings['slug'].'/'. $director->slug;
                    $found_directors[] = array('director_link' => $director_link, 'director_title' => $director->name, 'director_image' => $profile_image);
                    $include_directors[] = $director->term_id;
                }
            }
        }

        if(!empty($video_tags)) {
            foreach( $video_tags as $video_tag) {
                if(stripos($video_tag->name, $match_term) !== false) {
                    $tag_link = '/video-tag/'. $video_tag->slug;
                    $found_tags[] = array('tag_link' => $tag_link, 'tag_title' => $video_tag->name);
                    $include_tags[] = $video_tag->term_id;
                }
            }
        }

        $video_args = array(
            'post_type' => 'rvs_video',
            'posts_per_page' => -1,
            'nopaging' => true,
            'fields' => 'ids',
            's' => $match_term
        );

        $video_list = get_posts($video_args);

        if(!empty($video_list)) {
            foreach($video_list as $video_id) {
                $video_title = get_the_title($video_id);
                $video_link = get_the_permalink($video_id);
                $video_link = wpvs_generate_thumbnail_link($video_link);
                $video_excerpt = get_the_excerpt($video_id);
                $open_in_new_tab = get_post_meta($video_id, 'wpvs_open_video_in_new_tab', true);
                $video_thumbnail = vs_netflix_get_video_thumbnail($video_id);
                $found_videos[] = array(
                    'video_id' => $video_id,
                    'video_link' => $video_link,
                    'video_title' => $video_title,
                    'video_excerpt' => $video_excerpt,
                    'video_thumbnail' => $video_thumbnail,
                    'type' => 'video',
                    'new_tab' => $open_in_new_tab
                );
                $excluded_found_videos[] = $video_id;
            }
        }

        if( ! empty($include_actors) || ! empty($include_directors) || ! empty($include_tags) ) {
            $term_video_args = array(
                'post_type' => 'rvs_video',
                'posts_per_page' => -1,
                'nopaging' => true,
                'fields' => 'ids',
                'post__not_in' => $excluded_found_videos
            );

            $video_list = get_posts($video_args);
            $term_video_args['tax_query'] = array( 'relation' => 'OR' );

            if( ! empty($include_actors) ) {
                $term_video_args['tax_query'][] = array(
                    'taxonomy' => 'rvs_actors',
                    'field'    => 'term_id',
                    'terms'    => $include_actors,
                );
            }
            if( ! empty($include_directors) ) {
                $term_video_args['tax_query'][] = array(
                    'taxonomy' => 'rvs_directors',
                    'field'    => 'term_id',
                    'terms'    =>$include_directors,
                );
            }
            if( ! empty($include_tags) ) {
                $term_video_args['tax_query'][] = array(
                    'taxonomy' => 'rvs_video_tags',
                    'field'    => 'term_id',
                    'terms'    => $include_tags,
                );
            }
            $term_video_list = get_posts($term_video_args);

            if(!empty($term_video_list)) {
                foreach($term_video_list as $video_id) {
                    $video_title = get_the_title($video_id);
                    $video_link = get_the_permalink($video_id);
                    $video_link = wpvs_generate_thumbnail_link($video_link);
                    $video_excerpt = get_the_excerpt($video_id);
                    $open_in_new_tab = get_post_meta($video_id, 'wpvs_open_video_in_new_tab', true);
                    $video_thumbnail = vs_netflix_get_video_thumbnail($video_id);
                    $found_videos[] = array(
                        'video_id' => $video_id,
                        'video_link' => $video_link,
                        'video_title' => $video_title,
                        'video_excerpt' => $video_excerpt,
                        'video_thumbnail' => $video_thumbnail,
                        'type' => 'video',
                        'new_tab' => $open_in_new_tab
                    );
                }
            }
        }

        $found_results = array('videos' => $found_videos, 'genres' => $found_genres, 'actors' => $found_actors, 'directors' => $found_directors, 'tags' => $found_tags);
        echo json_encode($found_results);

    } else {
        _e('Please enter a search term', 'vs-netflix');
    }
    wp_die();
}

add_action( 'wp_ajax_wpvs_get_video_drop_down_details', 'wpvs_get_video_drop_down_details' );
add_action( 'wp_ajax_nopriv_wpvs_get_video_drop_down_details', 'wpvs_get_video_drop_down_details' );

function wpvs_get_video_drop_down_details() {
    if ( isset($_POST['videoid']) && !empty($_POST['videoid']) ) {
        if ( isset($_POST['slide_type']) && !empty($_POST['slide_type']) ) {
            $slide_type = $_POST['slide_type'];
        } else {
            $slide_type = "video";
        }
        global $wpvs_current_user;
        global $wpvs_my_list_enabled;
        $show_episodes = array();
        if($wpvs_my_list_enabled) {
            $list_video_id = $_POST['videoid'];
            $list_slide_type = $slide_type;
            $this_video_categories = wp_get_post_terms($list_video_id, 'rvs_video_category', array( 'fields' => 'all'));
            if( ! empty($this_video_categories) ) {
                foreach($this_video_categories as $video_category) {
                    if($video_category->parent) {
                        $this_cat_has_seasons = get_term_meta($video_category->parent, 'cat_has_seasons', true);
                        if($this_cat_has_seasons) {
                            $list_video_id = $video_category->parent;
                            $list_slide_type = "show";
                        }

                    }
                }
            }

            $added_to_list_html = '<label class="button wpvs-add-to-list" data-videoid="'.$list_video_id.'" data-videotype="'.$list_slide_type.'"><span class="dashicons dashicons-plus"></span>'.__('My List', 'vs-netflix').'</label>';
            if($wpvs_current_user && wpvs_added_to_user_list($list_video_id)) {
                $added_to_list_html = '<label class="button wpvs-add-to-list remove" data-videoid="'.$list_video_id.'" data-videotype="'.$list_slide_type.'"><span class="dashicons dashicons-yes"></span>'.__('My List', 'vs-netflix').'</label>';
            }
        } else {
            $added_to_list_html = "";
        }

        if($slide_type == "video") {
            $video = get_post($_POST['videoid']);
            $title = $video->post_title;
            $video_description = $video->post_excerpt;
            if(empty($video_description)) {
                $video_description = wp_strip_all_tags( $video->post_content, true );
            }
            $video_link = get_permalink($video->ID);
            $video_image = vs_netflix_get_video_header_image($video->ID);
            $get_video = $video->ID;
        }

        if($slide_type == "show") {
            $show = get_term($_POST['videoid'], 'rvs_video_category');
            $title = $show->name;
            $video_description = $show->description;
            $video_cat_attachment = get_term_meta($show->term_id, 'video_cat_attachment', true);
            $video_image = wp_get_attachment_url($video_cat_attachment);
            $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
            $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
            $video_args = array(
                'post_type' => 'rvs_video',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'tax_query' => array(
                      array(
                         'taxonomy' => 'rvs_video_category',
                         'field' => 'term_id',
                         'terms' => $show->term_id
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
            $show_videos = get_posts($video_args);
            if( !empty($show_videos) ) {
                $get_video = $show_videos[0];
                $video_link = get_permalink($get_video);
                unset($show_videos[0]);
                if( ! empty($show_videos) ) {
                    foreach($show_videos as $episode_id) {
                        $episode_info = array(
                            'episode_title' => get_the_title($episode_id),
                            'episode_link' => get_permalink($episode_id),
                            'episode_image' => vs_netflix_get_video_thumbnail($episode_id)
                        );
                        $show_episodes[] = $episode_info;
                    }

                }
            }
        }

        if( empty($video_image) && ! empty($get_video) ) {
            $video_image = vs_netflix_get_video_header_image($get_video);
        }

        if( empty($video_description) && ! empty($get_video) ) {
            $video = get_post($get_video);
            $video_description = $video->post_excerpt;
            if(empty($video_description)) {
                $video_description = wp_strip_all_tags( $video->post_content, true );
            }
        }

        $video_description = wp_trim_words($video_description, 50);
        $video_details = rvs_get_video_details($get_video, false);
        $video_information = wpvs_theme_get_video_information($get_video);

        $return_video = array('video_title' => $title, 'video_description' => $video_description, 'video_details' => $video_details, 'video_information' => $video_information, 'video_link' => $video_link, 'video_image' => $video_image, 'added_to_list' => $added_to_list_html, 'episodes' => $show_episodes);
        echo json_encode($return_video);

    } else {
        echo "Missing video id";
    }
    wp_die();
}

function wpvs_exit_ajax_request($request_message, $error_code) {
    if( empty($error_code) ) {
        $error_code = 400;
    }
    status_header($error_code);
    echo $request_message;
    exit;
}
