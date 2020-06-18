<?php
function wpvs_filter_update_checks($queryArgs) {
    $wpvs_themes = get_option('rvs-theme-access');
    if(!empty($wpvs_themes) && in_array('vs-netflix', $wpvs_themes)) {
        $queryArgs['has_rvs_access'] = true;
        $queryArgs['site'] = home_url();
    }
    return $queryArgs;
}

function wpvs_this_theme_is_active() {
    global $rvs_user_has_access;
    $theme_is_active = false;
    $wpvs_owned_themes = get_option('wpvs-owned-themes');
    if( ! empty($wpvs_owned_themes) && in_array('vs-netflix', $wpvs_owned_themes) ) {
        $theme_is_active = true;
    }
    if($rvs_user_has_access) {
        $theme_is_active = true;
    }
    return $theme_is_active;
}