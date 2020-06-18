<?php
/**
 * Template hooks for My Account
 */
remove_action( 'masvideos_account_navigation', 'masvideos_account_navigation' );
add_action( 'vodi_content_top', 'vodi_myaccount_page_header', 1 );


add_action( 'masvideos_before_edit_video_form_fields', 'vodi_video_upload_instructions', 10 );