<?php

$all_pages_args = array(
    'post_type' => 'page',
    'posts_per_page' => -1,
    'nopaging' => true,
    'fields' => 'ids'
);

$update_all_pages = get_posts($all_pages_args);

if( ! empty($update_all_pages) ) {
    foreach($update_all_pages as $update_page_id) {
        $current_template = get_page_template_slug($update_page_id);
        if($current_template == 'page-account.php') {
            wpvs_update_netflix_pages_template($update_page_id, 'page_account.php');
        }
        if($current_template == 'page-full-stretched.php') {
            wpvs_update_netflix_pages_template($update_page_id, 'page_full-stretched.php');
        }
        if($current_template == 'page-builder.php') {
            wpvs_update_netflix_pages_template($update_page_id, 'page_builder.php');
        }
        if($current_template == 'page-full.php') {
            wpvs_update_netflix_pages_template($update_page_id, 'page_full.php');
        }
    }
}

function wpvs_update_netflix_pages_template($page_id, $new_template) {
    $update_page = array(
        'ID'           => $page_id,
        'page_template'   => $new_template
    );
    wp_update_post( $update_page );
}