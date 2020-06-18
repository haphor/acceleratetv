<?php
function rogue_theme_customizer( $wp_customize ) {
    global $wpvs_actor_slug_settings;
    global $wpvs_director_slug_settings;
    $wp_customize->add_setting( 'rogue_company_logo', array(
        'sanitize_callback' => 'sanitize_rogue_logo'
        ) 
    );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'main_logo', array(
        'label'    => __( 'Logo', 'vs-netflix' ),
        'section'  => 'title_tagline',
        'settings' => 'rogue_company_logo',
        ) 
    ) );
    
    $wp_customize->add_setting( 'wpvs_desktop_logo_height', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'vs_netflix_sanitize_number',
        'default' => 50,
        ) 
    );
    
    $wp_customize->add_control( 'wpvs_desktop_logo_height', array(
      'type' => 'number',
      'section' => 'title_tagline', // Add a default or your own section
      'label' => __( 'Desktop Logo Height (px)', 'vs-netflix' ),
      'description' => __( 'Set the height of your logo on tablets and desktops.', 'vs-netflix' ),
    ) );
    
    $wp_customize->add_setting( 'wpvs_company_mobile_logo', array(
        'sanitize_callback' => 'sanitize_rogue_logo'
        ) 
    );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mobile_logo', array(
        'label'    => __( 'Mobile Logo', 'vs-netflix' ),
        'section'  => 'title_tagline',
        'settings' => 'wpvs_company_mobile_logo',
        ) 
    ) );
    
    $wp_customize->add_setting( 'wpvs_mobile_logo_height', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'vs_netflix_sanitize_number',
        'default' => 40,
        ) 
    );
    
    $wp_customize->add_control( 'wpvs_mobile_logo_height', array(
      'type' => 'number',
      'section' => 'title_tagline', // Add a default or your own section
      'label' => __( 'Mobile Logo Height (px)', 'vs-netflix' ),
      'description' => __( 'Set the height of your logo on mobile devices.', 'vs-netflix' ),
    ) );

    $wp_customize->add_setting( 'wpvs_signin_logo_height', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'vs_netflix_sanitize_number',
        'default' => 150,
        ) 
    );
    
    $wp_customize->add_control( 'wpvs_signin_logo_height', array(
      'type' => 'number',
      'section' => 'title_tagline', // Add a default or your own section
      'label' => __( 'Login Logo Height (px)', 'vs-netflix' ),
      'description' => __( 'Set the height of your logo on the Login screen.', 'vs-netflix' ),
    ) );
    
    // ==== Primary Colours ====
    
    $wp_customize->add_setting( 'style_color', array(
        'default'     => 'dark',
        'transport'   => 'refresh'
    ) );
    
    $wp_customize->add_control( 'theme_style', array(
        'label'        => __( 'Theme Style', 'vs-netflix' ),
        'type' => 'select',
        'choices'  => array('dark' => 'Dark','light' => 'Light'),
        'section'    => 'colors',
        'settings'   => 'style_color',
    ) );
    
    $wp_customize->add_setting( 'accent_color', array(
        'default'     => '#E50914',
        'transport'   => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color'
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'Accent Color', array(
        'label'        => __( 'Accent Color', 'vs-netflix' ),
        'section'    => 'colors',
        'settings'   => 'accent_color',
    ) ) );
    
    /* == HEADER SECTION == */

    $wp_customize->add_section( 'vs_header', array(
      'title' => __( 'Header', 'vs-netflix' ),
      'description' => __( 'Header area customization.', 'vs-netflix' ),
      'priority' => 40,
      'capability' => 'edit_theme_options'
    ) );
    
    $wp_customize->add_setting( 'vs_search_placeholder', array(
      'capability' => 'edit_theme_options',
      'default' => 'Enter search...',
      'sanitize_callback' => 'sanitize_text_field',  
    ) );
    
    $wp_customize->add_control('vs_search_placeholder', array(
      'label' => __( 'Search placeholder text', 'vs-netflix' ),
      'type' => 'text',
      'description' => __( 'Placeholder text for the search input', 'vs-netflix' ),
      'section' => 'vs_header'
    ) );
    
    $wp_customize->add_setting( 'vs_menu_login', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0 
    ));
    
    $wp_customize->add_control('vs_menu_login', array(
        'label' => __( 'Show Sign In / User Menu', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'vs_header'
    ));
    
    $wp_customize->add_setting( 'vs_menu_login_text', array(
      'capability' => 'edit_theme_options',
      'default' => 'Sign In',
      'sanitize_callback' => 'sanitize_text_field',  
    ) );
    
    $wp_customize->add_control('vs_menu_login_text', array(
      'label' => __( 'Sign In button text', 'vs-netflix' ),
      'type' => 'text',
      'section' => 'vs_header'
    ) );
    
    $wpvs_my_list_page_id = get_option('wpvs_my_list_page');
    
    if( empty($wpvs_my_list_page_id) && empty(get_post($wpvs_my_list_page_id)) ) {
        $wpvs_select_my_list_pages = array();
        $wpvs_my_list_page_default = '0';
    } else {
        $wpvs_select_my_list_pages = array($wpvs_my_list_page_id => get_the_title($wpvs_my_list_page_id));
        $wpvs_my_list_page_default = $wpvs_my_list_page_id;
    }
    
    $wpvs_my_list_page_args = array(
        'post_type' => 'page',
        'post_status' => 'publish',
        'exclude' => $wpvs_my_list_page_id
    );
    
    $wpvs_my_list_other_pages = get_pages($wpvs_my_list_page_args);
    $sign_in_page_options = array('default' => 'Default Login Page');
    
    if( ! empty($wpvs_my_list_other_pages) ) {
        foreach($wpvs_my_list_other_pages as $site_page) {
            $sign_in_page_options["$site_page->ID"] = $site_page->post_title;
        }
    }
    
    $wp_customize->add_setting( 'wpvs_login_link' , array(
        'default'     => 'default',
        'transport'   => 'refresh'
    ) );
    
    $wp_customize->add_control( 'wpvs_login_link', array(
        'label'        => __( 'Sign In Link', 'vs-netflix' ),
        'type' => 'select',
        'choices'  => $sign_in_page_options,
        'description' => __( 'Where the Sign In button takes users to login.', 'vs-netflix' ),
        'section'    => 'vs_header'
    ) );
    
   if ( has_nav_menu( 'user' ) ) {
        $theme_locations = get_nav_menu_locations();
        $menu_obj = get_term( $theme_locations['user'], 'nav_menu' );
        $user_menu_name = $menu_obj->name;
    } else {
        $user_menu_name = '(No User Menu created)'; 
    }
    
    $user_menu_options = array('default' => 'Default', 'user' => $user_menu_name);
    
    $wp_customize->add_setting( 'wpvs_user_menu' , array(
        'default'     => 'default',
        'transport'   => 'refresh'
    ) );
    
    $wp_customize->add_control( 'wpvs_user_menu', array(
        'label'        => __( 'User Menu', 'vs-netflix' ),
        'type' => 'select',
        'choices'  => $user_menu_options,
        'description' => 'Default or custom menu for the User drop down menu. To use a custom menu, please <a href="'.admin_url('nav-menus.php?action=edit&menu=0').'">create a new menu</a> with the Display location set to <strong>User Menu</strong>.',
        'section'    => 'vs_header'
    ) );
    
    $wp_customize->add_setting( 'vs_user_menu_link_first', array(
      'capability' => 'edit_theme_options',
      'default' => 'Account',
      'sanitize_callback' => 'sanitize_text_field',  
    ) );
    
    $wp_customize->add_control('vs_user_menu_link_first', array(
      'label' => __( 'User Menu Link Texts', 'vs-netflix' ),
      'type' => 'text',
      'description' => __( 'User Menu text links in order (Default Menu only)', 'vs-netflix' ),
      'section' => 'vs_header'
    ) );
    
    $wpvs_check_my_list_enabled = get_theme_mod('wpvs_my_list_enabled', 1);
    
    if($wpvs_check_my_list_enabled) {
        $wp_customize->add_setting( 'wpvs_user_menu_list_link', array(
          'capability' => 'edit_theme_options',
          'default' => 'My List',
          'sanitize_callback' => 'sanitize_text_field',  
        ) );

        $wp_customize->add_control('wpvs_user_menu_list_link', array(
          'type' => 'text',
          'section' => 'vs_header'
        ) );
    }
    
    $wp_customize->add_setting( 'vs_user_menu_link_second', array(
      'capability' => 'edit_theme_options',
      'default' => 'Rentals',
      'sanitize_callback' => 'sanitize_text_field',  
    ) );
    
    $wp_customize->add_control('vs_user_menu_link_second', array(
      'type' => 'text',
      'section' => 'vs_header'
    ) );
    
    $wp_customize->add_setting( 'vs_user_menu_link_third', array(
      'capability' => 'edit_theme_options',
      'default' => 'Purchases',
      'sanitize_callback' => 'sanitize_text_field',  
    ) );
    
    $wp_customize->add_control('vs_user_menu_link_third', array(
      'type' => 'text',
      'section' => 'vs_header'
    ) );

    $wp_customize->add_setting( 'vs_user_menu_link_fourth', array(
      'capability' => 'edit_theme_options',
      'default' => 'Logout',
      'sanitize_callback' => 'sanitize_text_field',  
    ) );
    
    $wp_customize->add_control('vs_user_menu_link_fourth', array(
      'type' => 'text',
      'section' => 'vs_header'
    ) );
    
    $wp_customize->add_setting( 'vs_primary_menu_home', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0  
    ));
    
    $wp_customize->add_control('vs_primary_menu_home', array(
        'label' => __( 'Hide primary menu on home page', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'vs_header'
    ));
    
    $wp_customize->add_setting( 'vs_hide_search', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0  
    ));
    
    $wp_customize->add_control('vs_hide_search', array(
        'label' => __( 'Hide search', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'vs_header'
    ));
    
    /* == TYPOGRAPHY == */
    
    $all_google_fonts = wpvs_load_google_fonts_in_customizer();

    $wp_customize->add_section( 'wpvs_typography_settings', array(
      'title' => __( 'Typography', 'vs-netflix' ),
      'description' => __( 'Customize your website fonts. <a href="https://fonts.google.com/" target="_blank">Browse Fonts</a>', 'vs-netflix' ),
      'priority' => 41,
      'capability' => 'edit_theme_options'
    ) );
    
    $wp_customize->add_setting( 'wpvs_disable_font_output', array(
      'capability' => 'edit_theme_options',
      'transport'   => 'refresh',
      'default' => 0, 
    ) );
    
    $wp_customize->add_control('wpvs_disable_font_output', array(
      'label' => __( 'Disable Fonts', 'vs-netflix' ),
      'type' => 'checkbox',
      'description' => __( 'Disable fonts from loading', 'vs-netflix' ),
      'section' => 'wpvs_typography_settings',
    ) );
    
    $wp_customize->add_setting( 'wpvs_body_font', array(
      'capability' => 'edit_theme_options',
      'transport'   => 'refresh',
      'default' => 'Open Sans', 
    ) );
    
    $wp_customize->add_control('wpvs_body_font', array(
      'label' => __( 'Primary Font', 'vs-netflix' ),
      'type' => 'select',
      'description' => __( 'Main content font (body, p, a, ul, etc)', 'vs-netflix' ),
      'section' => 'wpvs_typography_settings',
      'choices' => $all_google_fonts
    ) );
    
    $wp_customize->add_setting( 'wpvs_heading_font', array(
      'capability' => 'edit_theme_options',
      'transport'   => 'refresh',
      'default' => 'Open Sans',
    ) );
    
    $wp_customize->add_control('wpvs_heading_font', array(
      'label' => __( 'Headings Font', 'vs-netflix' ),
      'type' => 'select',
      'description' => __( 'H1, H2, H3, H4, H5 and H6', 'vs-netflix' ),
      'section' => 'wpvs_typography_settings',
      'choices' => $all_google_fonts
    ) );
    
    /* == Featured Area Home Page == */

    $wp_customize->add_section( 'vs_slider', array(
      'title' => __( 'Featured Area Sliders', 'vs-netflix' ),
      'description' => __( 'Home page slider customization.', 'vs-netflix' ),
      'priority' => 42,
      'capability' => 'edit_theme_options'
    ) );
    
    $wp_customize->add_setting( 'vs_slide_speed', array(
        'capability' => 'edit_theme_options',
        'default' => '4000',
        'sanitize_callback' => 'netflix_sanitize_select',
    ) );
    
    $wp_customize->add_control('vs_slide_speed', array(
        'label' => __( 'Slide Speed', 'vs-netflix' ),
        'type' => 'select',
        'description' => __( 'Change the home page featured slides speed', 'vs-netflix' ),
        'section' => 'vs_slider',
        'choices' => array(
            '0'    => __( 'Disable Automatic Sliding', 'vs-netflix'),
            '1000' => __( '1 Second', 'vs-netflix' ),
            '1500' => __( '1.5 Seconds', 'vs-netflix' ),
            '2000' => __( '2 Seconds', 'vs-netflix' ),
            '2500' => __( '3.5 Seconds', 'vs-netflix' ),
            '3000' => __( '3 Seconds', 'vs-netflix' ),
            '3500' => __( '3.5 Seconds', 'vs-netflix' ),
            '4000' => __( '4 Seconds', 'vs-netflix' ),
            '4500' => __( '4.5 Seconds', 'vs-netflix' ),
            '5000' => __( '5 Seconds', 'vs-netflix' ),
            '5500' => __( '5.5 Seconds', 'vs-netflix' ),
            '6000' => __( '6 Seconds', 'vs-netflix' ),
            '6500' => __( '6.5 Seconds', 'vs-netflix' ),
            '7000' => __( '7 Seconds', 'vs-netflix' ),
            '7500' => __( '7.5 Seconds', 'vs-netflix' ),
            '8000' => __( '8 Seconds', 'vs-netflix' ),
            '8500' => __( '8.5 Seconds', 'vs-netflix' ),
            '9000' => __( '9 Seconds', 'vs-netflix' ),
            '9500' => __( '9.5 Seconds', 'vs-netflix' ),
            '10000' => __( '10 Seconds', 'vs-netflix' ),
        )
    ) );
    
    $wp_customize->add_setting( 'vs_slide_gradient', array(
      'capability' => 'edit_theme_options',
      'default' => '8',
      'sanitize_callback' => 'netflix_sanitize_select',  
    ) );
    
    $wp_customize->add_control('vs_slide_gradient', array(
        'label' => __( 'Slide Gradient Overlay', 'vs-netflix' ),
        'type' => 'select',
        'description' => __( 'Change the featured area slides overlay intensity', 'vs-netflix' ),
        'section' => 'vs_slider',
        'choices' => array(
            '0' => __( 'No overlay', 'vs-netflix' ),
            '1' => __( '0.1', 'vs-netflix' ),
            '2' => __( '0.2', 'vs-netflix' ),
            '3' => __( '0.3', 'vs-netflix' ),
            '4' => __( '0.4', 'vs-netflix' ),
            '5' => __( '0.5', 'vs-netflix' ),
            '6' => __( '0.6', 'vs-netflix' ),
            '7' => __( '0.7', 'vs-netflix' ),
            '8' => __( '0.8', 'vs-netflix' ),
            '9' => __( '0.9', 'vs-netflix' )
        )
    ) );
    
    $wp_customize->add_setting( 'vs_slide_content_blend', array(
      'capability' => 'edit_theme_options',
      'default' => '0',
      'sanitize_callback' => 'netflix_sanitize_select',  
    ) );
    
    $wp_customize->add_control('vs_slide_content_blend', array(
        'label' => __( 'Slide Content Blend', 'vs-netflix' ),
        'type' => 'select',
        'description' => __( 'Enable / Disable the content blend overlay at the bottom of slides.', 'vs-netflix' ),
        'section' => 'vs_slider',
        'choices' => array(
            '0' => __( 'Disabled', 'vs-netflix' ),
            '1' => __( 'Enabled', 'vs-netflix' )
        )
    ) );
    
    /* == NETFLIX SLIDERS == */

    $wp_customize->add_section( 'vs_video_sliders', array(
      'title' => __( 'Video Sliders', 'vs-netflix' ),
      'description' => __( 'Horizontal video navigation.', 'vs-netflix' ),
      'priority' => 43,
      'capability' => 'edit_theme_options'
    ) );
    
    $wp_customize->add_setting( 'vs_videos_per_slider', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 10,
        'sanitize_callback' => 'vs_netflix_sanitize_number'
    ));
    
    $wp_customize->add_control('vs_videos_per_slider', array(
        'label' => __( 'Videos per slider', 'vs-netflix' ),
        'type' => 'number',
        'section' => 'vs_video_sliders',
        'description' => __( 'How many videos to load in horizontal browsing sliders', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_visible_slide_count_large', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 6,
        'sanitize_callback' => 'vs_netflix_sanitize_number'
    ));
    
    $wp_customize->add_control('wpvs_visible_slide_count_large', array(
        'label' => __( 'Visible Thumbnails (Large Screens)', 'vs-netflix' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 10
          ),
        'section' => 'vs_video_sliders',
        'description' => __( 'How many thumbnails are visible on large screens (1600px or more)', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_visible_slide_count_desktop', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 5,
        'sanitize_callback' => 'vs_netflix_sanitize_number'
    ));
    
    $wp_customize->add_control('wpvs_visible_slide_count_desktop', array(
        'label' => __( 'Visible Thumbnails (Desktop)', 'vs-netflix' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 9
          ),
        'section' => 'vs_video_sliders',
        'description' => __( 'How many thumbnails are visible on desktop screens (1200px - 1600px)', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_visible_slide_count_laptop', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 4,
        'sanitize_callback' => 'vs_netflix_sanitize_number'
    ));
    
    $wp_customize->add_control('wpvs_visible_slide_count_laptop', array(
        'label' => __( 'Visible Thumbnails (Laptop)', 'vs-netflix' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 8
          ),
        'section' => 'vs_video_sliders',
        'description' => __( 'How many thumbnails are visible on laptop screens (960px - 1200px)', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_visible_slide_count_tablet', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 3,
        'sanitize_callback' => 'vs_netflix_sanitize_number'
    ));
    
    $wp_customize->add_control('wpvs_visible_slide_count_tablet', array(
        'label' => __( 'Visible Thumbnails (Tablet)', 'vs-netflix' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 7
          ),
        'section' => 'vs_video_sliders',
        'description' => __( 'How many thumbnails are visible on tablet screens (600px - 960px)', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_visible_slide_count_mobile', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 2,
        'sanitize_callback' => 'vs_netflix_sanitize_number'
    ));
    
    $wp_customize->add_control('wpvs_visible_slide_count_mobile', array(
        'label' => __( 'Visible Thumbnails (Mobile)', 'vs-netflix' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 6
          ),
        'section' => 'vs_video_sliders',
        'description' => __( 'How many thumbnails are visible on mobile screens (600px or smaller)', 'vs-netflix' )
    ));
    
    
     /* == VIDEO LISTINGS (ARCHIVES) == */

    $wp_customize->add_section( 'vs_video_listings', array(
      'title' => __( 'Video Browsing', 'vs-netflix' ),
      'description' => __( 'Default video browsing pages settings', 'vs-netflix' ),
      'priority' => 44,
      'capability' => 'edit_theme_options'
    ) );
    
    $wp_customize->add_setting( 'wpvs_browsing_layout', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'grid',
        'sanitize_callback' => 'netflix_sanitize_select'
    ));
    
    $wp_customize->add_control('wpvs_browsing_layout', array(
        'label' => __( 'Browsing Layout', 'vs-netflix' ),
        'type' => 'select',
        'choices' => array(
            'grid' => __( 'Grid', 'vs-netflix' ),
            'sliders' => __( 'Sliders', 'vs-netflix' )
        ),
        'section' => 'vs_video_listings',
        'description' => __( 'Video browsing pages layout.', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_grid_count_large', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 6,
        'sanitize_callback' => 'vs_netflix_sanitize_number'
    ));
    
    $wp_customize->add_control('wpvs_grid_count_large', array(
        'label' => __( 'Visible Thumbnails (Large)', 'vs-netflix' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 10
          ),
        'section' => 'vs_video_listings',
        'description' => __( 'How many thumbnails per row on large screens (1600px or larger)', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_grid_count_desktop', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 5,
        'sanitize_callback' => 'vs_netflix_sanitize_number'
    ));
    
    $wp_customize->add_control('wpvs_grid_count_desktop', array(
        'label' => __( 'Visible Thumbnails (Desktop)', 'vs-netflix' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 9
          ),
        'section' => 'vs_video_listings',
        'description' => __( 'How many thumbnails per row on desktop screens (1200px - 1600px)', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_grid_count_laptop', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 4,
        'sanitize_callback' => 'vs_netflix_sanitize_number'
    ));
    
    $wp_customize->add_control('wpvs_grid_count_laptop', array(
        'label' => __( 'Visible Thumbnails (Laptop)', 'vs-netflix' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 8
          ),
        'section' => 'vs_video_listings',
        'description' => __( 'How many thumbnails per row on laptop screens (960px - 1200px)', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_grid_count_tablet', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 3,
        'sanitize_callback' => 'vs_netflix_sanitize_number'
    ));
    
    $wp_customize->add_control('wpvs_grid_count_tablet', array(
        'label' => __( 'Visible Thumbnails (Tablet)', 'vs-netflix' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 7
          ),
        'section' => 'vs_video_listings',
        'description' => __( 'How many thumbnails per row on tablet screens (600px - 960px)', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_grid_count_mobile', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 2,
        'sanitize_callback' => 'vs_netflix_sanitize_number'
    ));
    
    $wp_customize->add_control('wpvs_grid_count_mobile', array(
        'label' => __( 'Visible Thumbnails (Mobile)', 'vs-netflix' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 6
          ),
        'section' => 'vs_video_listings',
        'description' => __( 'How many thumbnails per row on mobile screens (600px or smaller)', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'vs_video_drop_details', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));
    
    $wp_customize->add_control('vs_video_drop_details', array(
        'label' => __( 'Drop Down Video Details', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'vs_video_listings',
        'description' => __( 'Display video details below video slides and rows.', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'vs_video_slide_hover_effect', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));
    
    $wp_customize->add_control('vs_video_slide_hover_effect', array(
        'label' => __( 'Video Thumbnail Hover Effect', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'vs_video_listings',
        'description' => __( 'Expand video thumbnails on hover. <em>(Larger screen sizes only)</em>', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_video_slide_info_position', array(
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'default' => 'overlay',
        'sanitize_callback' => 'netflix_sanitize_select'
    ));
    
    $wp_customize->add_control('wpvs_video_slide_info_position', array(
        'label' => __( 'Video Thumbnail Info Position', 'vs-netflix' ),
        'type' => 'select',
        'choices' => array(
            'overlay' => __( 'Overlay', 'vs-netflix' ),
            'below' => __( 'Below', 'vs-netflix' )
        ),
        'section' => 'vs_video_listings',
        'description' => __( 'Display video information over top or below thumbnail images.', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'vs_thumbnail_style', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'landscape',
        'sanitize_callback' => 'netflix_sanitize_select'
    ));
    
    $wp_customize->add_control('vs_thumbnail_style', array(
        'label' => __( 'Video thumbnail style', 'vs-netflix' ),
        'type' => 'select',
        'choices' => array(
            'landscape' => __( 'Landscape (640px by 360px)', 'vs-netflix' ),
            'portrait' => __( 'Portrait (380px by 590px)', 'vs-netflix' ),
            'custom' => __( 'Custom Size', 'vs-netflix' )
        ),
        'section' => 'vs_video_listings',
        'description' => __( 'Video thumbnail image style. If you use a <strong>Custom Size</strong>, any time you change your custom width or height, you will need to <a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">regenerate your thumbnail images</a>.', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_custom_thumbnail_size_width', array(
      'capability' => 'edit_theme_options',
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field',  
    ) );
    
    $wp_customize->add_control('wpvs_custom_thumbnail_size_width', array(
      'type' => 'number',
      'input_attrs' => array(
        'min' => 100,
        'max' => 1920
      ),
      'description' => __( 'Custom thumbnail size width', 'vs-netflix' ),
      'section' => 'vs_video_listings'
    ) );
    
    $wp_customize->add_setting( 'wpvs_custom_thumbnail_size_height', array(
      'capability' => 'edit_theme_options',
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field',  
    ) );
    
    $wp_customize->add_control('wpvs_custom_thumbnail_size_height', array(
      'type' => 'number',
      'input_attrs' => array(
        'min' => 100,
        'max' => 1920
      ),
      'description' => __( 'Custom thumbnail size height', 'vs-netflix' ),
      'section' => 'vs_video_listings'
    ) );
    
    $wp_customize->add_setting( 'wpvs_slide_mobile_display', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));
    
    $wp_customize->add_control('wpvs_slide_mobile_display', array(
        'label' => __( 'Mobile Device Display', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'vs_video_listings',
        'description' => __( 'Always show titles and arrows on mobile devices.', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_profile_browsing', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));
    
    $wp_customize->add_control('wpvs_profile_browsing', array(
        'label' => __('Enable', 'vs-netflix') . ' ' . $wpvs_actor_slug_settings['name'] . ' / ' . $wpvs_director_slug_settings['name'] . ' ' . __('Profiles', 'vs-netflix'),
        'type' => 'checkbox',
        'section' => 'vs_video_listings',
        'description' => __( 'Display profile photos and details.', 'vs-netflix' )
    ));
    
    /* == SINGLE VIDEO PAGE == */

    $wp_customize->add_section( 'vs_single_video', array(
      'title' => __( 'Video Page Settings', 'vs-netflix' ),
      'description' => __( 'Default video page settings', 'vs-netflix' ),
      'priority' => 45,
      'capability' => 'edit_theme_options'
    ) );
    
    $wp_customize->add_setting( 'vs_single_layout', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'standard',
        'sanitize_callback' => 'netflix_sanitize_select'
    ));
    
    $wp_customize->add_control('vs_single_layout', array(
        'label' => __( 'Layout', 'vs-netflix' ),
        'type' => 'select',
        'choices' => array(
            'standard' => __( 'Standard', 'vs-netflix' ),
            'netflix' => __( 'Netflix', 'vs-netflix' ),
            'youtube' => __( 'YouTube', 'vs-netflix' )
        ),
        'section' => 'vs_single_video',
        'description' => __( 'Default video page layout.', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_show_related_videos', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));
    
    $wp_customize->add_control('wpvs_show_related_videos', array(
        'label' => __( 'Show Related Videos', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'vs_single_video',
        'description' => __( 'Display related videos below Netflix layout.', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_show_more_videos_below_standard', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));
    
    $wp_customize->add_control('wpvs_show_more_videos_below_standard', array(
        'label' => __( 'Show More Videos Below Content', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'vs_single_video',
        'description' => __( 'Display additional videos below Standard and YouTube layout.', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_related_videos_count', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'vs_netflix_sanitize_number',
        'default' => 7
    ));
    
    $wp_customize->add_control('wpvs_related_videos_count', array(
        'label' => __( '# of Related videos', 'vs-netflix' ),
        'type' => 'number',
        'section' => 'vs_single_video',
        'description' => __( 'The number of related videos to display.', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'vs_show_recently_added', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));
    
    $wp_customize->add_control('vs_show_recently_added', array(
        'label' => __( 'Show Recently Added Videos', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'vs_single_video',
        'description' => __( 'Display recently added videos below Netflix layout.', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_recently_added_count', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'vs_netflix_sanitize_number',
        'default' => 7
    ));
    
    $wp_customize->add_control('wpvs_recently_added_count', array(
        'label' => __( '# of Recently added videos', 'vs-netflix' ),
        'type' => 'number',
        'section' => 'vs_single_video',
        'description' => __( 'The number of recently added videos to display.', 'vs-netflix' )
    ));
    
    
    $wp_customize->add_setting( 'vs_moving_background', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));
    
    $wp_customize->add_control('vs_moving_background', array(
        'label' => __( 'Enable shifting video background', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'vs_single_video',
        'description' => __( 'When the screen size is smaller than the video featured image, the image will slowly pan across the screen. (Preview on mobile device below)', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_full_screen_video', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));
    
    $wp_customize->add_control('wpvs_full_screen_video', array(
        'label' => __( 'Full Screen Video', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'vs_single_video',
        'description' => __( 'Video players are full width of the screen when played. (Netflix video layout only)', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_open_in_full_screen', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));
    
    $wp_customize->add_control('wpvs_open_in_full_screen', array(
        'label' => __( 'Open In Full Screen', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'vs_single_video',
        'description' => __( 'Open videos in full screen on when thumbnail is pressed. (Netflix video layout only)', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'vs_single_access_layout', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'standard',
        'sanitize_callback' => 'netflix_sanitize_select'
    ));
    
    $wp_customize->add_control('vs_single_access_layout', array(
        'label' => __( 'Video Access Style', 'vs-netflix' ),
        'type' => 'select',
        'choices' => array(
            'standard' => __( 'Standard', 'vs-netflix' ),
            'fullwidth' => __( 'Full Screen', 'vs-netflix' )
        ),
        'section' => 'vs_single_video',
        'description' => __( '(<a href="https://www.wpvideosubscriptions.com/video-memberships/" target="_blank">WP Video Memberships</a> only) How the video page displays for users without access. If you are using the Netflix layout above, we recommend using Standard for this.', 'vs-netflix' )
    ));
    
    /* == VIDEO REVIEWS == */

    $wp_customize->add_section( 'wpvs_video_reviews', array(
      'title' => __( 'Video Reviews', 'vs-netflix' ),
      'description' => __( 'Video reviews and ratings. (Reviews use default WordPress comments)', 'vs-netflix' ),
      'priority' => 46,
      'capability' => 'edit_theme_options'
    ) );
    
    $wp_customize->add_setting( 'wpvs_video_review_ratings', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));
    
    $wp_customize->add_control('wpvs_video_review_ratings', array(
        'label' => __( 'Enable 5 Star Ratings', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'wpvs_video_reviews',
        'description' => __( 'Enable / Disable 5 star ratings for videos.', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_star_review_color' , array(
        'default'     => '#ffd700',
        'transport'   => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color'
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'Stars Color', array(
        'label'        => __( 'Star Ratings Color', 'vs-netflix' ),
        'section'    => 'wpvs_video_reviews',
        'settings'   => 'wpvs_star_review_color',
    ) ) );
    
    $wp_customize->add_setting( 'wpvs_video_review_show_author', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));
    
    $wp_customize->add_control('wpvs_video_review_show_author', array(
        'label' => __( 'Display Review Author', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'wpvs_video_reviews',
        'description' => __( 'Show / Hide review authors photo and username', 'vs-netflix' )
    ));
    
    /* == MY LIST == */

    $wp_customize->add_section( 'wpvs_my_list_settings', array(
      'title' => __( 'My List', 'vs-netflix' ),
      'description' => __( 'My List settings', 'vs-netflix' ),
      'priority' => 47,
      'capability' => 'edit_theme_options'
    ) );
    
    $wp_customize->add_setting( 'wpvs_my_list_enabled', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));
    
    $wp_customize->add_control('wpvs_my_list_enabled', array(
        'label' => __( 'Enabled', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'wpvs_my_list_settings',
        'description' => __( 'Turn on / off the My List feature. Allows users to save videos to their list.', 'vs-netflix' )
    ));
    
    
    if( ! empty($wpvs_my_list_other_pages) ) {
        foreach($wpvs_my_list_other_pages as $site_page) {
            $wpvs_select_my_list_pages["$site_page->ID"] = $site_page->post_title;
        }
    }
    
    $wp_customize->add_setting( 'wpvs_my_list_page' , array(
        'default'     => $wpvs_my_list_page_default,
        'transport'   => 'refresh'
    ) );
    
    $wp_customize->add_control( 'wpvs_my_list_page', array(
        'label'        => __( 'My List Page', 'vs-netflix' ),
        'type' => 'select',
        'choices'  => $wpvs_select_my_list_pages,
        'description' => __( 'The page that users My List videos will display. <em>Include <strong>[rvs_user_my_list]</strong> shortcode on page</em>', 'vs-netflix' ),
        'section'    => 'wpvs_my_list_settings'
    ) );
    
    $wp_customize->add_setting( 'wpvs_my_list_show_on_home' , array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ) );
    
    $wp_customize->add_control( 'wpvs_my_list_show_on_home', array(
        'label'        => __( 'Show on Homepage', 'vs-netflix' ),
        'type' => 'checkbox',
        'description' => __( 'Displays logged in users saved videos on the home page.', 'vs-netflix' ),
        'section'    => 'wpvs_my_list_settings'
    ) );
    
    $wp_customize->add_setting( 'wpvs_my_list_home_title', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => __( 'My List', 'vs-netflix' ),
        ) 
    );
    
    $wp_customize->add_control( 'wpvs_my_list_home_title', array(
      'type' => 'text',
      'input_attrs' => array(
          'placeholder' => __( 'My List', 'vs-netflix' ),
      ),
      'section' => 'wpvs_my_list_settings',
      'label' => __( 'Homepage My List Title', 'vs-netflix' ),
      'description' => __( 'Change the title above the homepage My List slider.', 'vs-netflix' ),
    ) );
    
    
    /* == BUTTONS == */

    $wp_customize->add_section( 'wpvs_button_options', array(
      'title' => __( 'Buttons', 'vs-netflix' ),
      'description' => __( 'Buttons Settings: For more customization, use the <a href="/wp-admin/customize.php?autofocus[section]=advanced_custom">Advanced</a> area.', 'vs-netflix' ),
      'priority' => 48,
      'capability' => 'edit_theme_options'
    ) );
    
    $wp_customize->add_setting( 'wpvs_button_style', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'solid',
        'sanitize_callback' => 'netflix_sanitize_select'
    ));
    
    $wp_customize->add_control('wpvs_button_style', array(
        'label' => __( 'Button Style', 'vs-netflix' ),
        'type' => 'select',
        'choices' => array(
            'solid' => __( 'Solid', 'vs-netflix' ),
            'hollow' => __( 'Hollow', 'vs-netflix' )
        ),
        'section' => 'wpvs_button_options',
        'description' => __( 'Changes the appearance of buttons.', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_button_radius', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => '',
        ) 
    );
    
    $wp_customize->add_control( 'wpvs_button_radius', array(
      'type' => 'text',
      'input_attrs' => array(
          'placeholder' => __( '5px', 'vs-netflix' ),
      ),
      'section' => 'wpvs_button_options',
      'label' => __( 'Button Border Radius', 'vs-netflix' ),
      'description' => __( 'Change the border radius of buttons', 'vs-netflix' ),
    ) );
    
    $wp_customize->add_setting( 'wpvs_button_padding_top_bottom', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => '6px',
        ) 
    );
    
    $wp_customize->add_control( 'wpvs_button_padding_top_bottom', array(
      'type' => 'text',
      'input_attrs' => array(
          'placeholder' => __( '6px', 'vs-netflix' ),
      ),
      'section' => 'wpvs_button_options',
      'label' => __( 'Button Padding (Top/Bottom)', 'vs-netflix' ),
      'description' => __( 'Change the top and bottom padding of buttons', 'vs-netflix' ),
    ) );
    
    $wp_customize->add_setting( 'wpvs_button_padding_left_right', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => '12px',
        ) 
    );
    
    $wp_customize->add_control( 'wpvs_button_padding_left_right', array(
      'type' => 'text',
      'input_attrs' => array(
          'placeholder' => __( '12px', 'vs-netflix' ),
      ),
      'section' => 'wpvs_button_options',
      'label' => __( 'Button Padding (Left/Right)', 'vs-netflix' ),
      'description' => __( 'Change the left and right padding of buttons', 'vs-netflix' ),
    ) );
    
    $wp_customize->add_setting( 'wpvs_play_button', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'play-icon',
        'sanitize_callback' => 'netflix_sanitize_select'
    ));
    
    $wp_customize->add_control('wpvs_play_button', array(
        'label' => __( 'Play Buttons', 'vs-netflix' ),
        'type' => 'select',
        'choices' => array(
            'play-icon' => __( 'Large Play Icon', 'vs-netflix' ),
            'standard' => __( 'Standard', 'vs-netflix' )
        ),
        'section' => 'wpvs_button_options',
        'description' => __( 'Displays on Netflix video pages and the drop down browsing section.', 'vs-netflix' )
    ));
    
    $wp_customize->add_setting( 'wpvs_watch_now_text', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'Watch Now'
    ));
    
    $wp_customize->add_control('wpvs_watch_now_text', array(
        'label' => __( 'Button text for drop down video details', 'vs-netflix' ),
        'type' => 'text',
        'section' => 'wpvs_button_options'
    ));
    
    
     /* == LOGIN PAGE == */

    $wp_customize->add_section( 'wpvs_custom_login_settings', array(
      'title' => __( 'Login Page', 'vs-netflix' ),
      'description' => __( 'Customize your themes Login page', 'vs-netflix' ),
      'priority' => 49,
      'capability' => 'edit_theme_options'
    ) );
    
    $wp_customize->add_setting( 'wpvs_theme_login_background', array(
        'sanitize_callback' => 'sanitize_rogue_logo'
        ) 
    );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'body_background_image', array(
        'label'    => __( 'Background Image', 'vs-netflix' ),
        'section'  => 'wpvs_custom_login_settings',
        'settings' => 'wpvs_theme_login_background',
        ) 
    ) );
    
    $wp_customize->add_setting( 'wpvs_hide_login_register_link', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0 
    ));
    
    $wp_customize->add_control('wpvs_hide_login_register_link', array(
        'label' => __( 'Hide Register Link', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'wpvs_custom_login_settings'
    ));
    
    /* ==== ADVANCED ==== */

    $wp_customize->add_section( 'advanced_custom', array(
      'title' => __( 'Advanced', 'vs-netflix' ),
      'description' => __( 'Add custom CSS and JS.', 'vs-netflix' ),
      'priority' => 160,
      'capability' => 'edit_theme_options'
    ) );
    
    $wp_customize->add_setting( 'wpvs_load_gutenberg_css', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1 
    ) );
    
    $wp_customize->add_control('wpvs_load_gutenberg_css', array(
        'label' => __( 'Load Theme Gutenberg CSS', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'advanced_custom'
    ));

    $wp_customize->add_setting( 'custom_css', array(
      'type' => 'theme_mod', // or 'option'
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
      'sanitize_callback' => 'sanitize_custom_netflix_css'
    ) );
    
    $wp_customize->add_setting( 'custom_js', array(
      'type' => 'theme_mod', // or 'option'
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
      'sanitize_callback' => 'sanitize_custom_netflix_js'
    ) );
    
    if( class_exists('WP_Customize_Code_Editor_Control') ) {
    
        $wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'custom_css', array(
              'label' => __( 'Custom Theme CSS', 'vs-netflix' ),
              'code_type' => 'css',
              'description' => __( 'Do not include "style" tags.', 'vs-netflix' ),
                'settings' => 'custom_css',
              'section' => 'advanced_custom'
            )
        ) );

        $wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'custom_js', array(
              'label' => __( 'Custom Theme JS', 'vs-netflix' ),
              'code_type' => 'javascript',
              'description' => __( 'Do not include "script" tags.', 'vs-netflix' ),
                'settings' => 'custom_js',
              'section' => 'advanced_custom'
            )
        ) );
    }
    
    $wp_customize->add_setting( 'wpvs_show_recently_added', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0 
    ));
    
    $wp_customize->add_control('wpvs_show_recently_added', array(
        'label' => __( 'Show Recently Added Videos', 'vs-netflix' ),
        'type' => 'checkbox',
        'section' => 'static_front_page'
    ));

}
add_action( 'customize_register', 'rogue_theme_customizer' );

function wpvs_save_theme_global_settings() {
    update_option('wpvs_my_list_page', get_theme_mod('wpvs_my_list_page'));
}
add_action( 'customize_save_after', 'wpvs_save_theme_global_settings' );

/* ==== CUSTOM THEME OUTPUT ==== */

function rogue_customize_css() {
    $theme_accent_colour = get_theme_mod('accent_color', '#E50914');
    $slider_overlay = get_theme_mod('vs_slide_gradient', '8');
    $slider_overlay = floatval($slider_overlay*0.1);
    $video_slide_content_blend = get_theme_mod('vs_slide_content_blend', '0');
    $colour_style = get_theme_mod('style_color', 'dark');
    $wpvs_button_style = get_theme_mod('wpvs_button_style', 'solid');
    $wpvs_button_radius = get_theme_mod('wpvs_button_radius', 0);
    $wpvs_button_padding_top_bottom = get_theme_mod('wpvs_button_padding_top_bottom', '6px');
    $wpvs_button_padding_left_right = get_theme_mod('wpvs_button_padding_left_right', '12px');
    $wpvs_button_font_size = get_theme_mod('wpvs_button_font_size', '12px');
    $play_button_setting = get_theme_mod( 'wpvs_play_button', 'play-icon');
    $wpvs_full_screen_video = get_theme_mod( 'wpvs_full_screen_video', 0);
    $wpvs_star_ratings_color = get_theme_mod('wpvs_star_review_color', '#ffd700');
    $wpvs_disable_font_loading = get_theme_mod('wpvs_disable_font_output', 0);
    $wpvs_headings_font = get_theme_mod('wpvs_heading_font', 'Open Sans');
    $wpvs_body_font = get_theme_mod('wpvs_body_font', 'Open Sans');
    $wpvs_mobile_logo_height = get_theme_mod('wpvs_mobile_logo_height', '40');
    $wpvs_desktop_logo_height = get_theme_mod('wpvs_desktop_logo_height', '50');
    $wpvs_mobile_page_margin = intval($wpvs_mobile_logo_height) + 40;
    $wpvs_desktop_page_margin = intval($wpvs_desktop_logo_height) + 50;
    $wpvs_grid_large_item_count = get_theme_mod('wpvs_grid_count_large', '6');
    $wpvs_grid_desktop_item_count = get_theme_mod('wpvs_grid_count_desktop', '5');
    $wpvs_grid_laptop_item_count = get_theme_mod('wpvs_grid_count_laptop', '4');
    $wpvs_grid_tablet_item_count = get_theme_mod('wpvs_grid_count_tablet', '3');
    $wpvs_grid_mobile_item_count = get_theme_mod('wpvs_grid_count_mobile', '2');
    $wpvs_grid_large_width = wpvs_get_css_width_percentage( $wpvs_grid_large_item_count) ;
    $wpvs_grid_desktop_width = wpvs_get_css_width_percentage( $wpvs_grid_desktop_item_count );
    $wpvs_grid_laptop_width = wpvs_get_css_width_percentage( $wpvs_grid_laptop_item_count );
    $wpvs_grid_tablet_width = wpvs_get_css_width_percentage( $wpvs_grid_tablet_item_count );
    $wpvs_grid_mobile_width = wpvs_get_css_width_percentage( $wpvs_grid_mobile_item_count );
    $wpvs_slide_info_position = get_option('wpvs_video_slide_info_position', 'overlay');
    ?>
     <style type="text/css">
         /* COLOURS */

a, header#header nav#desktop ul li:hover > a, header#header nav#desktop ul li:hover > .menuArrow, footer a:hover, #sidebar ul li a:hover, #vs-video-back .dashicons, .vs-video-details h1, #wpvs-updating-box .wpvs-loading-text, header#header #logo #site-title, header#header nav#desktop ul.sub-menu li a:hover, h2.sliderTitle, .vs-text-color, .vs-tax-result:hover, #vs-open-search:hover, #close-wpvs-search:hover, .vs-drop-play-button:hover > .dashicons, h3.drop-title, .show-vs-drop:hover, .socialmedia a:hover, .wpvs-menu-item:hover, .wpvs-menu-item.active, a.sub-video-cat:hover, a.sub-video-cat.active, a.wpvs-purchase-term-link:hover, .rvs-access-tab:hover

{ color: <?php echo $theme_accent_colour; ?>; }

.wpvs-video-rating-star.dashicons:hover, .wpvs-video-rating-star.dashicons.active, .wpvs-video-rating-star.dashicons.setactive, .wpvs-video-rating-star-complete.dashicons.active, a.wpvs-review-anchor {color: <?php echo $wpvs_star_ratings_color ?>;}

/* BACKGROUNDS */

nav#mobile a:hover, .navigation span.current, .navigation a:hover, #searchform input[type="submit"], #wpvs-updating-box .loadingCircle, .loadingCircle, .net-loader, .net-loader:before, nav#mobile a.sign-in-link, header#header nav#desktop ul li a.sign-in-link, #single-netflix-video-container .mejs-controls .mejs-time-rail .mejs-time-current, label.rental-time-left, .wpvs-full-screen-display #wpvs-cancel-next-video:hover, .button, .wp-block-button .wp-block-button__link, .rvs-button, .rvs-membership-item .rvs-button, .rvs-area .rvs-button, .rvs-primary-button, a.rvs-primary-button, .wpvs-cw-progress-bar, label#menuOpen:hover > span, label#menuOpen:hover > span:before, label#menuOpen:hover > span:after

{ background: <?php echo $theme_accent_colour ?>; }
         
/* BUTTONS */
.button, .wp-block-button .wp-block-button__link, .rvs-button, .rvs-membership-item .rvs-button, .rvs-area .rvs-button, .rvs-primary-button, a.rvs-primary-button {
    border-radius: <?php echo $wpvs_button_radius; ?>;
    padding: <?php echo $wpvs_button_padding_top_bottom; ?> <?php echo $wpvs_button_padding_left_right; ?>; 
}
         
<?php if($wpvs_button_style == 'hollow') { ?>
.button, .wp-block-button .wp-block-button__link, .rvs-button, .rvs-membership-item .rvs-button, .rvs-area .rvs-button, .rvs-primary-button, a.rvs-primary-button {
    border: 1px solid <?php echo $theme_accent_colour; ?>;
    background:none;
}
<?php } ?>

.net-loader {
background: -moz-linear-gradient(left, <?php echo $theme_accent_colour ?> 10%, rgba(255, 255, 255, 0) 42%);
background: -webkit-linear-gradient(left, <?php echo $theme_accent_colour ?> 10%, rgba(255, 255, 255, 0) 42%);
background: -o-linear-gradient(left, <?php echo $theme_accent_colour ?> 10%, rgba(255, 255, 255, 0) 42%);
background: -ms-linear-gradient(left, <?php echo $theme_accent_colour ?> 10%, rgba(255, 255, 255, 0) 42%);
background: linear-gradient(to right, <?php echo $theme_accent_colour ?> 10%, rgba(255, 255, 255, 0) 42%);
}
<?php if( ! $wpvs_disable_font_loading ) { ?>
h1, h2, h3, h4, h5, h6 {
font-family: <?php echo $wpvs_headings_font; ?>, 'Helvetica Neue', Helvetica, Arial, sans-serif;
}

body, header#header #logo #site-title {
font-family: <?php echo $wpvs_body_font; ?>, 'Helvetica Neue', Helvetica, Arial, sans-serif;
}
<?php } ?>

.video-item {
width: <?php echo $wpvs_grid_mobile_width; ?>;
}

header#header #logo a img {
    height: <?php echo $wpvs_mobile_logo_height; ?>px;
}

.category-top { 
    top: <?php echo $wpvs_mobile_page_margin; ?>px;
}
         
.category-top.hug-header { 
    top: <?php echo $wpvs_mobile_logo_height; ?>px;
}

.video-page-container, .page-container {
    margin: <?php echo $wpvs_mobile_page_margin; ?>px 0 0;
}
<?php if( ! empty($wpvs_slide_info_position) && $wpvs_slide_info_position == 'below' ) { ?>
         
 .slide-category {
     margin-bottom: 100px;
 }
      
 .video-slide, .video-item, .video-item-content, .slick-list {
     overflow: visible;
 }
         
.video-slide-details {
    background: none;
    opacity: 1;
    bottom: -95%;
}
         
.video-slide-details p {
    margin: 0;
}
         
 #video-list-loaded .vs-video-description-drop.open, .vs-video-description-drop.open {
     margin-top: -100px;
 }
         
 .show-vs-drop {
    background: -moz-linear-gradient(top, rgba(0,0,0,0) 0%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.8) 100%);
    background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.8) 100%);
    background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.8) 100%);
 }
         
.episode-slider .video-slide-details {
    height: 40px;
    bottom: -40px;
}
         
<?php if( $colour_style == 'dark' ) { ?>
.video-slide:hover > .video-slide-details, .video-item:hover > .video-item-content .video-slide-details {
    background: #141414;
}       
<?php } else { ?>
.video-slide:hover > .video-slide-details, .video-item:hover > .video-item-content .video-slide-details {
    background: #fafafa;
} 
 .video-slide-details h4, .video-slide-details p {
     color: #141414;
     text-shadow: none;
 }
<?php } } else { ?>
.episode-slider .video-slide-details {
    height: auto;
}
<?php } ?>
         
@media screen and (min-width: 768px) {
header#header #logo a img {
    height: <?php echo $wpvs_desktop_logo_height; ?>px;
}
.category-top { 
    top: <?php echo $wpvs_desktop_page_margin; ?>px;
}
    
.category-top.hug-header { 
    top: <?php echo $wpvs_desktop_logo_height; ?>px;
}

.video-page-container, .page-container {
    margin: <?php echo $wpvs_desktop_page_margin; ?>px 0 0;
} 
}

@media screen and (min-width: 600px) {
.video-item {
width: <?php echo $wpvs_grid_tablet_width; ?>;
}
}

@media screen and (min-width: 960px) {
.video-item {
width: <?php echo $wpvs_grid_laptop_width; ?>;
}
    
<?php if( ! empty($wpvs_slide_info_position) && $wpvs_slide_info_position == 'below' ) { ?> 
.slide-category {
    margin-bottom: 50px;
}
.video-slide-details {
    bottom: -70px;
    height: 70px;
}
#video-list-loaded .vs-video-description-drop.open, .vs-video-description-drop.open {
    margin-top: -90px;
}    
<?php } ?>
}

@media screen and (min-width: 1200px) {
.video-item {
width: <?php echo $wpvs_grid_desktop_width; ?>;
}
}

@media screen and (min-width: 1600px) {
.video-item {
width: <?php echo $wpvs_grid_large_width; ?>;
}
}

#video-list-loaded[items-per-row="<?php echo $wpvs_grid_mobile_item_count; ?>"] .video-item {
width: <?php echo $wpvs_grid_mobile_width; ?>; 
}

#video-list-loaded[items-per-row="<?php echo $wpvs_grid_tablet_item_count; ?>"] .video-item {
width: <?php echo $wpvs_grid_tablet_width; ?>; 
}

#video-list-loaded[items-per-row="<?php echo $wpvs_grid_laptop_item_count; ?>"] .video-item {
width: <?php echo $wpvs_grid_laptop_width; ?>; 
}

#video-list-loaded[items-per-row="<?php echo $wpvs_grid_desktop_item_count; ?>"] .video-item {
width: <?php echo $wpvs_grid_desktop_width; ?>; 
}

#video-list-loaded[items-per-row="<?php echo $wpvs_grid_large_item_count; ?>"] .video-item {
width: <?php echo $wpvs_grid_large_width; ?>; 
}

<?php if($slider_overlay != 0) {
if($colour_style == "light") { ?>
li.wpvs-image-flex-slide:before, .wpvs-video-flex-container:before {
background: -moz-linear-gradient(left,  rgba(255,255,255,<?php echo $slider_overlay; ?>) 0%, rgba(255,255,255,0.1) 100%);
background: -webkit-linear-gradient(left,  rgba(255,255,255,<?php echo $slider_overlay; ?>) 0%,rgba(255,255,255,0.1) 100%); 
background: linear-gradient(to right,  rgba(255,255,255,<?php echo $slider_overlay; ?>) 0%,rgba(255,255,255,0.1) 100%);
}
<?php } else { ?>
li.wpvs-image-flex-slide:before, .wpvs-video-flex-container:before {
background: -moz-linear-gradient(left,  rgba(0,0,0,<?php echo $slider_overlay; ?>) 0%, rgba(0,0,0,0.1) 100%);
background: -webkit-linear-gradient(left,  rgba(0,0,0,<?php echo $slider_overlay; ?>) 0%,rgba(0,0,0,0.1) 100%); 
background: linear-gradient(to right,  rgba(0,0,0,<?php echo $slider_overlay; ?>) 0%,rgba(0,0,0,0.1) 100%);
}
<?php } } ?>

<?php if($video_slide_content_blend) {
if($colour_style == "light") { ?>
li.wpvs-featured-slide:after, .wpvs-video-flex-container:after {
background: -moz-linear-gradient(bottom, rgba(250,250,250,<?php echo $video_slide_content_blend; ?>) 0%, rgba(255,255,255,0) 100%);
background: -webkit-linear-gradient(bottom, rgba(250,250,250,<?php echo $video_slide_content_blend; ?>) 0%,rgba(255,255,255,0) 100%); 
background: linear-gradient(to top, rgba(250,250,250,<?php echo $video_slide_content_blend; ?>) 0%,rgba(255,255,255,0) 100%);
}
<?php } else { ?>
li.wpvs-featured-slide:after, .wpvs-video-flex-container:after {
background: -moz-linear-gradient(bottom, rgba(20, 20, 20,<?php echo $video_slide_content_blend; ?>) 0%, rgba(0,0,0,0) 100%);
background: -webkit-linear-gradient(bottom, rgba(20, 20, 20,<?php echo $video_slide_content_blend; ?>) 0%,rgba(0,0,0,0) 100%); 
background: linear-gradient(to top, rgba(20, 20, 20,<?php echo $video_slide_content_blend; ?>) 0%,rgba(0,0,0,0) 100%);
}
<?php } } ?>

/* BUTTONS */

<?php if($play_button_setting == 'play-icon') { ?>
.vs-drop-button {
display: none;
}
<?php } else { ?>
.drop-display .vs-drop-play-button {
display: none;
}
<?php } if($wpvs_full_screen_video) { ?>

.wpvs-full-screen-login {
position: absolute;
top: 100px;
left: 0;
overflow-y: scroll;
}

.wpvs-full-screen-display #single-netflix-video-container {
padding: 0;
}

.wpvs-full-screen-display #single-netflix-video-container, .wpvs-full-screen-display, .wpvs-full-screen-display #single-netflix-video-container #rvs-main-video, .wpvs-full-screen-display #single-netflix-video-container #rvs-trailer-video{
height: 100%;
}

.wpvs-full-screen-display #single-netflix-video-container #rvs-main-video .videoWrapper, .wpvs-full-screen-display #single-netflix-video-container #rvs-trailer-video .videoWrapper {
max-width: none;
max-height: none;
height: 100%;
width: auto;
}

<?php } ?>

/* WP Video Memberships */

.wpvs-loading-text {
color: <?php echo $theme_accent_colour; ?>
}

<?php echo get_theme_mod('custom_css'); ?>

     </style>
<?php }
add_action( 'wp_head', 'rogue_customize_css');

function sanitize_rogue_logo( $input ) {
 
    /* default output */
    $output = '';
 
    /* check file type */
    $filetype = wp_check_filetype( $input );
    $mime_type = $filetype['type'];
 
    /* only mime type "image" allowed */
    if ( strpos( $mime_type, 'image' ) !== false ) {
        $output = $input;
    }
    return $output;
}

function sanitize_custom_netflix_css( $input ) {
    return $input;
}

function sanitize_custom_netflix_js( $input ) {
    return $input;
}

function netflix_sanitize_select( $input, $setting ) {
  // Ensure input is a slug.
  $input = sanitize_key( $input );

  // Get list of choices from the control associated with the setting.
  $choices = $setting->manager->get_control( $setting->id )->choices;

  // If the input is a valid key, return it; otherwise, return the default.
  return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function vs_netflix_sanitize_number( $number, $setting ) {
  // Ensure $number is an absolute integer (whole number, zero or greater).
  $number = absint( $number );

  // If the input is an absolute integer, return it; otherwise, return the default
  return ( $number ? $number : $setting->default );
}

function wpvs_customized_login() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/css/style-login.css" />';
    $theme_logo = esc_url( get_theme_mod( 'rogue_company_logo' ) );
    $wpvs_theme_login_background = esc_url( get_theme_mod( 'wpvs_theme_login_background' ) );
    $theme_logo_height = get_theme_mod( 'wpvs_signin_logo_height', '150');
    $accent_colour = get_theme_mod('accent_color', '#E50914');
    $colour_style = get_theme_mod('style_color', 'dark');
    $wpvs_hide_login_register_link = get_theme_mod('wpvs_hide_login_register_link', 0);
    if($colour_style == "dark") {
        $background_color = '#141414';
        $box_color = "#232323";
        $text_color = "#eeeeee";
        $input_background = "#1c1c1c";
        $input_border = "#353535";
    } else {
        $background_color = '#fafafa';
        $box_color = "#ffffff";
        $text_color = "#141414";
        $input_background = "#fafafa";
        $input_border = "#eeeeee";
    }
?>
     <style type="text/css">
        body {
            background: <?php echo $background_color; ?>;
            <?php if( ! empty($wpvs_theme_login_background) )  { ?>
            background-image: url(<?php echo $wpvs_theme_login_background; ?>);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            <?php } ?>
        }
        <?php if( !empty($theme_logo)) { ?>
            #login h1 a, .login h1 a {
                content:"<?php echo $theme_logo; ?>";
                background-image: url(<?php echo $theme_logo; ?>);
                background-size: auto <?php echo $theme_logo_height .'px'; ?>;
                width: 100%;
                height: <?php echo $theme_logo_height .'px'; ?>;
            }
        <?php } else { ?>
            #login h1 a {
                background-image:none;
                text-indent: 0;
                color: <?php echo $accent_colour; ?> !important;
                font-size: 36px;
                height: auto;
                width: auto;
            }
         <?php } ?>
         
         #login h1 a:hover {
             color: <?php echo $accent_colour; ?> !important;
         }
        .wp-core-ui .button-primary {
            background: <?php echo $accent_colour; ?>;
            border: 2px solid <?php echo $accent_colour; ?>;
        }
        .wp-core-ui .button-primary:hover, .wp-core-ui .button-primary:active, .wp-core-ui .button-primary:focus {
            background: <?php echo $accent_colour; ?>;
            border: 2px solid <?php echo $accent_colour; ?>;
        }

        .login form, .login #login_error, .login .message {
            background: <?php echo $box_color; ?>
        }
         
         .login .message {
            color: <?php echo $text_color; ?>
        }

        .login #login_error, .login .message {
            border-left: 4px solid <?php echo $accent_colour; ?>;
        }
         
         .login #backtoblog a:hover, .login #nav a:hover {
             color: <?php echo $accent_colour; ?>;
         }

        input[type="text"], input[type="email"], input[type="password"] {
            border: 1px solid <?php echo $input_border; ?> !important;
            color: <?php echo $text_color; ?> !important;
            background: <?php echo $input_background; ?> !important;
        }
         
        <?php if($wpvs_hide_login_register_link && get_option( 'users_can_register' ) ) { ?>
         p#nav a:first-of-type {
             display: none;
         }
         <?php } ?>

     </style>
<?php }
add_action( 'login_head', 'wpvs_customized_login' );

function wpvs_load_google_fonts_in_customizer() {
    $wpvs_current_customizer_time = current_time('timestamp', 1);
    $check_fonts_time = get_option('wpvs_get_google_fonts_time');
    $wpvs_custom_theme_fonts = get_option('wpvs_theme_google_fonts', array());
    if( empty($wpvs_custom_theme_fonts) || empty($check_fonts_time) || ($check_fonts_time <= $wpvs_current_customizer_time) ) {
        $new_google_fonts = array();
        $google_fonts_url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyANmsmvTqxtTZc-VZuh1fgyYlH3I_AWmZU";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $google_fonts_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $google_fonts = curl_exec($ch);
        curl_close($ch);
        $json_fonts = json_decode($google_fonts);
        $font_items = $json_fonts->items;
        if( ! empty($font_items) ) {
            foreach($font_items as $font) {
                $new_google_fonts[$font->family] = $font->family;
            }
        }
        if( ! empty($new_google_fonts) ) {
            $new_google_fonts = array_unique($new_google_fonts);
            update_option('wpvs_theme_google_fonts', $new_google_fonts);
            $wpvs_custom_theme_fonts = $new_google_fonts;
            $check_fonts_time = strtotime('+1 day', $wpvs_current_customizer_time );
            update_option('wpvs_get_google_fonts_time', $check_fonts_time);
        }
    }
    return $wpvs_custom_theme_fonts;
}

function wpvs_customized_login_link() {
	return home_url();
}
add_filter('login_headerurl','wpvs_customized_login_link');

function wpvs_customized_login_title() {
    return get_bloginfo('name', 'raw');
}
add_filter( 'login_headertext', 'wpvs_customized_login_title' );

function wpvs_get_css_width_percentage($value) {
    $css_percentage = '50%';
    if($value == 10) {
        $css_percentage = '10%';
    }
    if($value == 9) {
        $css_percentage = '11.11%';
    }
    if($value == 8) {
        $css_percentage = '12.5%';
    }
    if($value == 7) {
        $css_percentage = '14.28%';
    }
    if($value == 6) {
        $css_percentage = '16.66%';
    }
    if($value == 5) {
        $css_percentage = '20%';
    }
    if($value == 4) {
        $css_percentage = '25%';
    }
    if($value == 3) {
        $css_percentage = '33.33%';
    }
    if($value == 2) {
        $css_percentage = '50%';
    }
    if($value == 1) {
        $css_percentage = '100%';
    }
    return $css_percentage;
}