<?php

$vs_show_login = get_option('show-vs-login', 0);
$vs_hide_front_menu = get_option('hide-primary-menu-on-front', 0);
$vs_hide_search = get_option('vs-hide-search', 0);
$vs_dropdown_details = get_option('vs-drop-down-details', 1);

// SINGLE VIDEO

$vs_access_layout = get_option('vs-access-layout', 'standard');
$vs_display_layout = get_option('vs-display-layout', 'standard');
$vs_show_recently_added = get_option('vs-show-recently-added', 1);

// VIDEO LISTINGS

$thumbnail_layout = get_option('thumbnail-layout', 'landscape');           
$videos_per_page = get_option('videos-per-page', '20');
$videos_per_slide = get_option('videos-per-slide', '10');
$video_pagination = get_option('video-pagination', 'lazy-load');

set_theme_mod( 'vs_menu_login', $vs_show_login);
set_theme_mod( 'vs_primary_menu_home', $vs_hide_front_menu);
set_theme_mod( 'vs_hide_search', $vs_hide_search);
set_theme_mod( 'vs_video_drop_details', $vs_dropdown_details);

set_theme_mod( 'vs_single_layout', $vs_display_layout);
set_theme_mod( 'vs_single_access_layout', $vs_access_layout);
set_theme_mod( 'vs_show_recently_added', $vs_show_recently_added);

set_theme_mod( 'vs_thumbnail_style', $thumbnail_layout);
set_theme_mod( 'vs_videos_per_page', $videos_per_page);
set_theme_mod( 'vs_videos_per_slider', $videos_per_slide);
set_theme_mod( 'vs_video_paginiation', $video_pagination);

unregister_setting( 'net-theme-options', 'show-vs-login' );
unregister_setting( 'net-theme-options', 'hide-primary-menu-on-front' );
unregister_setting( 'net-theme-options', 'vs-hide-search' );
unregister_setting( 'net-theme-options', 'vs-drop-down-details' );
unregister_setting( 'net-video-archive-options', 'thumbnail-layout' );
unregister_setting( 'net-video-archive-options', 'videos-per-page' );
unregister_setting( 'net-video-archive-options', 'videos-per-slide' );
unregister_setting( 'net-video-archive-options', 'video-pagination' );
unregister_setting( 'net-single-video-options', 'vs-access-layout' );
unregister_setting( 'net-single-video-options', 'vs-display-layout' );
unregister_setting( 'net-single-video-options', 'vs-show-recently-added');

delete_option('show-vs-login');
delete_option('hide-primary-menu-on-front');
delete_option('vs-hide-search');
delete_option('vs-drop-down-details');
delete_option('vs-access-layout');
delete_option('vs-display-layout');
delete_option('vs-show-recently-added');
delete_option('thumbnail-layout');           
delete_option('videos-per-page');
delete_option('videos-per-slide');
delete_option('video-pagination');