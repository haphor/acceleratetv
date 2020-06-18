<?php 
function wpvs_load_check_theme_admin_updates() {
    $wp_videos_current_version = get_option('wpv_vimeosync_current_version');
    if( ! empty($wp_videos_current_version) ) {
        $wp_videos_current_updates_version = intval(str_replace(".","",$wp_videos_current_version));
        if($wp_videos_current_updates_version < 254) {
            add_action( 'admin_notices', 'wp_videos_update_message_254' );
            function wp_videos_update_message_254() {
              echo '<div class="update-nag">';
              echo 'IMPORTANT: The WP Videos plugin needs an update. Please <a href="'.admin_url('plugins.php').'">upgrade to version 2.5.4</a>';
              echo '</div>';
            }
        }
    }
}
add_action( 'admin_init', 'wpvs_load_check_theme_admin_updates' );