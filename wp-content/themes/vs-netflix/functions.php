<?php

global $videos_per_page;
global $vs_netflix_current_version;
global $wpvs_current_user;
global $vs_dropdown_details;
global $wpvs_my_list_enabled;
global $wpvs_watch_now_text;
global $wpvs_profile_browsing;
global $wpvs_theme_google_tracking;
$wpvs_my_list_enabled = get_theme_mod('wpvs_my_list_enabled', 1);
$vs_dropdown_details = get_theme_mod('vs_video_drop_details', 1);
$wpvs_watch_now_text = get_theme_mod('wpvs_watch_now_text', __('Watch Now', 'vs-netflix'));
$wpvs_profile_browsing = get_theme_mod('wpvs_profile_browsing', 1);
$wpvs_theme_google_tracking = get_option('google-tracking');
if(is_user_logged_in()) {
    $wpvs_current_user = wp_get_current_user();
    require_once('includes/user-functions.php');
}
$videos_per_page = get_theme_mod('vs_videos_per_page', '20');
$vs_netflix_current_version = get_option('vs_netflix_current_version');

if (!defined('VS_NETFLIX_VERSION')) {
    define('VS_NETFLIX_VERSION', '4.4.0');
}

if(!defined('WPVS_THEME_BASE_DIR')) {
	define('WPVS_THEME_BASE_DIR', dirname(__FILE__));
}
require_once('includes/scripts.php');

// ADMIN SCRIPTS

function vs_netflix_register_admin_js() {
    global $vs_netflix_current_version;
    wp_register_script('rvs-thumbnail-upload', get_template_directory_uri( __FILE__ ) . '/js/admin/thumbnail-upload.js', array('jquery'), $vs_netflix_current_version);
    wp_register_script('wpvs-cat-thumbnails', get_template_directory_uri( __FILE__ ) . '/js/admin/cat-thumbnail.js', array('jquery'), $vs_netflix_current_version);
    wp_register_script('wpvs-upload-thumbnails', get_template_directory_uri( __FILE__ ) . '/js/admin/wpvs-thumbnails.js', array('jquery'), $vs_netflix_current_version);
    wp_enqueue_style( 'wpvs-genre-edits', get_template_directory_uri() . '/css/admin/category-edit.css','', $vs_netflix_current_version);
}
add_action( 'admin_enqueue_scripts', 'vs_netflix_register_admin_js' );

function wpvs_add_theme_support() {
    add_theme_support( 'menus' );
    add_theme_support('post-thumbnails');
    add_theme_support( 'html5', array( 'search-form' ) );
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'style-editor.css' );
    add_theme_support( 'dark-editor-style' );
    add_post_type_support( 'page', 'excerpt' );
    add_image_size('video-thumbnail', 640, 360, true);
    add_image_size('video-portrait', 380, 590, true);
    add_image_size('vs-netflix-header', 1920, 0, false);
    register_nav_menu( 'main', 'Main');
    register_nav_menu( 'footer', 'Footer');
    register_nav_menu( 'user', 'User Menu');
    $wpvs_thumbnail_layout = get_theme_mod('vs_thumbnail_style', 'landscape');
    if( $wpvs_thumbnail_layout == 'custom' ) {
        $wpvs_custom_thumbnail_width = get_theme_mod('wpvs_custom_thumbnail_size_width', '640');
        $wpvs_custom_thumbnail_height = get_theme_mod('wpvs_custom_thumbnail_size_height', '360');
        add_image_size('wpvs-custom-thumbnail-size', $wpvs_custom_thumbnail_width, $wpvs_custom_thumbnail_height, true);
    }
}
add_action('init', 'wpvs_add_theme_support');

function wpvs_theme_custom_image_sizes($sizes){
    $custom_sizes = array(
        'video-thumbnail' => __('Video Landscape', 'vs-netflix'),
        'video-portrait' => __('Video Portrait', 'vs-netflix'),
        'vs-netflix-header' => __('Featured Header', 'vs-netflix'),
        'wpvs-custom-thumbnail-size' => __('Custom Video Thumbnail', 'vs-netflix'),
    );
    return array_merge( $sizes, $custom_sizes );
}
add_filter('image_size_names_choose', 'wpvs_theme_custom_image_sizes');

function net_custom_excerpt_length( $length ) {
    return 35;
}
add_filter( 'excerpt_length', 'net_custom_excerpt_length', 999 );

if ( ! isset( $content_width ) ) {
	$content_width = 1920;
}

// CREATING WIDGETS
function create_widget($widget_name, $widget_id, $widget_description) {
	register_sidebar(array(
		'name' => __( $widget_name, 'vs-netflix'),
		'id' => $widget_id,
		'description' => __( $widget_description, 'vs-netflix' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h5>',
		'after_title' => '</h5>'
	));
}

// Create widgets in the footer
create_widget("Left Footer", "footer_left", "Displays in the left of the footer");
create_widget("Middle Footer", "footer_middle", "Displays in the middle of the footer");
create_widget("Right Footer", "footer_right", "Displays in the right of the footer");
create_widget("Video Sidebar", "video_right", "Displays in the right of the video pages.");

// Create page sidebar
register_sidebar(array(
    'name' => __( 'Page Sidebar', 'vs-netflix' ),
    'id' => 'page_right',
    'description' => __( 'Displays on the right side of page', 'vs-netflix' ),
    'before_widget' => ' ',
    'after_widget' => ' ',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
));

register_sidebar(array(
    'name' => __( 'Blog Sidebar', 'vs-netflix' ),
    'id' => 'blog_right',
    'description' => __( 'Displays on the right side of blog posts and blog page.', 'vs-netflix' ),
    'before_widget' => ' ',
    'after_widget' => ' ',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
));

require_once('includes/walkers.php');

// THEME SETTINGS PAGE

add_action( 'admin_menu', 'register_net_theme_menu' );
add_action( 'admin_init', 'register_net_theme_settings' );

function register_net_theme_menu() {
    add_theme_page( 'Theme Options', 'Theme Options', 'manage_options', 'net-theme-settings', 'net_theme_settings_init', 5);
    add_submenu_page( null, 'Google Tracking', 'Google Tracking', 'manage_options', 'net-google-tracking', 'net_google_tracking' );
    add_submenu_page( null, 'Social Media', 'Social Media', 'manage_options', 'net-social-options', 'net_social_options' );
    add_submenu_page( null, 'Shortcodes', 'Shortcodes', 'manage_options', 'net-shortcodes', 'net_shortcodes' );
    add_submenu_page( null, 'Updates', 'Updates', 'manage_options', 'wpvs-theme-updates', 'wpvs_theme_updates' );
}

function register_net_theme_settings() {
    register_setting( 'net-theme-tracking', 'google-tracking' );
    register_setting( 'net-social-options', 'social-media-links' );
}

if( !function_exists('net_theme_settings_init')) {
    function net_theme_settings_init() {
        wp_enqueue_style('net-admin', get_template_directory_uri() . '/css/admin/net-admin.css');
        require_once('includes/theme-settings.php');
    }
}

if( !function_exists('net_google_tracking')) {
    function net_google_tracking() {
        wp_enqueue_style('net-admin', get_template_directory_uri() . '/css/admin/net-admin.css');
        require_once('includes/theme-google-tracking.php');
    }
}

if( !function_exists('net_social_options')) {
    function net_social_options() {
        wp_enqueue_style('net-admin', get_template_directory_uri() . '/css/admin/net-admin.css');
        require_once('includes/theme-social-settings.php');
    }
}

if( !function_exists('net_shortcodes')) {
    function net_shortcodes() {
        wp_enqueue_style('net-admin', get_template_directory_uri() . '/css/admin/net-admin.css');
        require_once('includes/theme-shortcodes.php');
    }
}

if( !function_exists('wpvs_theme_updates')) {
    function wpvs_theme_updates() {
        wp_enqueue_style('net-admin', get_template_directory_uri() . '/css/admin/net-admin.css');
        require_once('includes/admin/run-updates.php');
    }
}

require_once('includes/dynamic-slider.php');
require_once('includes/custom-posts.php');
require_once('includes/customize.php');
require_once('includes/custom-ajax.php');
require_once('includes/custom-functions.php');
require_once('includes/shortcodes.php');
require_once('includes/theme-widgets.php');
require_once('includes/backup-functions.php');
require_once('includes/review-functions.php');
require_once('includes/wpvs-theme-rest.php');

if(is_admin()) {
    require_once('includes/admin/dynamic-slider-admin.php');
    require_once('includes/admin/wpvs-product-checks.php');
}

function wpvs_load_theme_things() {
    global $vs_netflix_current_version;
    update_option('vs_netflix_active', true);
    load_theme_textdomain( 'vs-netflix', get_template_directory().'/languages/' );
    if(VS_NETFLIX_VERSION !== $vs_netflix_current_version) {
        run_vs_netflix_update();
    }
}
add_action( 'after_setup_theme', 'wpvs_load_theme_things' );

function netflix_is_active_setting ($oldtheme_name, $oldtheme) {
    if (version_compare(PHP_VERSION, '5.5') < 0) {
        // Info message: Theme not activated
        add_action( 'admin_notices', 'vs_netflix_not_activated' );
        function vs_netflix_not_activated() {
          echo '<div class="update-nag">';
          _e( 'VS Netflix Theme not activated: You need to upgrade your PHP Version to at least 5.5.', 'vs-netflix' );
          echo '</div>';
        }
        switch_theme( $oldtheme->stylesheet );
        return false;
    }
    update_option('vs_netflix_active', true);
    if( empty(get_option('wpvs_my_list_page') ) ) {
        $wpvs_my_list_page_args = array(
          'post_type' => 'page',
          'post_title'    => 'My List',
          'post_content' => '[rvs_user_my_list]',
          'post_status'   => 'publish'
        );
        $new_user_my_list_page = wp_insert_post( $wpvs_my_list_page_args );
        if($new_user_my_list_page) {
            update_option('wpvs_my_list_page', $new_user_my_list_page);
        }
    }
}
add_action('after_switch_theme', 'netflix_is_active_setting', 10, 2);

function netflix_is_disabled_setting () {
    update_option('vs_netflix_active', false);
}
add_action('switch_theme', 'netflix_is_disabled_setting');
function run_vs_netflix_update() {
    global $vs_netflix_current_version;
    $needs_update = false;
    if(!empty($vs_netflix_current_version)) {
        $current_version_number = intval(str_replace(".","",$vs_netflix_current_version));
        if($current_version_number < 239) {
            delete_option( 'vs-netflix_license_key_status' );
        }

        if($current_version_number < 260) {
            require_once('updates/update-theme-settings.php');
        }

        if($current_version_number < 281) {
            require_once('updates/update-video-categories.php');
        }
        if($current_version_number < 314) {
            require_once('updates/update-featured-area.php');
        }

        if($current_version_number < 321) {
            require_once('updates/update-theme-pages.php');
        }

        if($current_version_number < 323) {
            require_once('updates/update-video-links.php');
        }

        if($current_version_number < 361) {
            require_once('updates/update-thumbnail-images.php');
        }
    }

    update_option('vs_netflix_current_version', '4.4.0');
}
if(is_admin()){
    require_once(WPVS_THEME_BASE_DIR.'/updates/wpvs-theme-filters.php');
    require_once(WPVS_THEME_BASE_DIR.'/updates/plugin-update-checker.php');
    $vs_netflix_updates = Puc_v4_Factory::buildUpdateChecker(
        'https://www.wpvideosubscriptions.com/updates/?action=get_metadata&slug=vs-netflix',
        __FILE__,
        'vs-netflix'
    );
    $vs_netflix_updates->addQueryArgFilter('wpvs_filter_update_checks');
    if(strpos($_SERVER['REQUEST_URI'], 'update-core.php') || strpos($_SERVER['REQUEST_URI'], 'themes.php')) {
        $vs_netflix_updates->checkForUpdates();
    }
    require_once(WPVS_THEME_BASE_DIR.'/updates/version-checks.php');
}
