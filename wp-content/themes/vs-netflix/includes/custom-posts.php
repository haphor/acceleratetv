<?php 

add_action( 'add_meta_boxes', 'wpvs_theme_video_metabox_data' );

function wpvs_theme_video_metabox_data() {
    global $post;
    add_meta_box(
        'rogue_slider_section',
        __( 'Featured Area', 'vs-netflix' ),
        'rogue_slider_callback',
        'page',
        'side',
        'high'
    );
    
    add_meta_box(
        'rvs_video_homepage_options', 
        __( 'Video Options', 'vs-netflix' ), 
        'rvs_video_homepage_options', 
        'rvs_video', 
        'side', 'low'
    );
    
    add_meta_box(
        'rvs_video_thumbnail_image', 
        __( 'Thumbnail Image', 'vs-netflix' ), 
        'rvs_video_thumbnail_image', 
        'rvs_video', 
        'side'
    );
    
    add_meta_box(
        'rvs_video_template_option', 
        __( 'Video Page Layout', 'vs-netflix' ), 
        'rvs_video_template_option', 
        'rvs_video', 
        'side', 'high'
    );
    
    if( ! empty($post) ) {
        $editing_page_template = get_post_meta( $post->ID, '_wp_page_template', true );
        if( 'page_builder.php' == $editing_page_template || 'page_full-stretched.php' == $editing_page_template) {
            add_meta_box(
                'vs_display_options',
                __( 'Page Options', 'vs-netflix' ),
                'wpvs_page_builder_options_callback',
                array('page'),
                'side',
                'high'
            );
        }
    }
    
    // TRAILER META BOX
    
    add_meta_box('rvs_trailer_iframe', 'Trailer', 'rvs_trailer_meta_box', 'rvs_video', 'normal', 'high');
}

function rogue_slider_callback( $post ) {
    wp_nonce_field( 'rogue_slider_save', 'rogue_slider_save_nonce' );
    wp_enqueue_style('net-admin-video', get_template_directory_uri() . '/css/admin/net-admin.css');
    wp_enqueue_script('net-admin-video-js', get_template_directory_uri() . '/js/admin-video.js', array('jquery'), '', true );
    wp_localize_script( 'net-admin-video-js', 'rvsajax',
        array( 'url' => admin_url( 'admin-ajax.php' )));
    
    // GET HOME PAGE DATA
    
    $sliderId = get_post_meta( $post->ID, 'wpvs_featured_area_slider', true );
    $wpvs_page_featured_area_type = get_post_meta( $post->ID, 'wpvs_featured_area_slider_type', true );
    if( empty($wpvs_page_featured_area_type) ) {
        $wpvs_page_featured_area_type = "none";
    }
    $sliders = get_option('wpvs_slider_array');

    $wpvs_featured_shortcode = get_post_meta( $post->ID, 'wpvs_featured_shortcode', true );
    if( empty($wpvs_featured_shortcode) ) {
        $wpvs_featured_shortcode = "";
    }
    ?>
    <div class="inside">
        <ul class="categorychecklist form-no-clear">	
            <li><label class="selectit"><input type="radio" name="wpvs-slider-type" value="default" <?php checked('default', $wpvs_page_featured_area_type); ?>/> Slider</label></li>
            <li><label class="selectit"><input type="radio" name="wpvs-slider-type" value="shortcode" <?php checked('shortcode', $wpvs_page_featured_area_type); ?>/> Shortcode</label></li>
            <li><label class="selectit"><input type="radio" name="wpvs-slider-type" value="none" <?php checked('none', $wpvs_page_featured_area_type); ?>/> None</label></li>
        </ul>
    </div>
    <div id="wpvs-select-featured-slider" class="wpvs-select-featured-type <?=($wpvs_page_featured_area_type == "default") ? 'wpvs-show-featured-select' : ''?>">
        <label for="rogue_slider_select"><?php _e('Slider:', 'vs-netflix'); ?> </label>
        <select id="rogue_slider_select"  name="rogue_slider_select">
            <?php
                if( ! empty($sliders) ) {
                    foreach($sliders as $slider) {
                        echo '<option value="'.$slider['id'].'"' . selected( $slider['id'],$sliderId ) . ' >'.$slider['name'].'</option>';
                    }
                }
            ?>
        </select>
    </div>

    <div id="wpvs-set-featured-shortcode" class="wpvs-select-featured-type <?=($wpvs_page_featured_area_type == "shortcode") ? 'wpvs-show-featured-select' : ''?>">
        <label><?php _e('Shortcode:', 'vs-netflix'); ?> </label><br>
        <input type="text" name="wpvs-featured-shortcode" value="<?php echo htmlentities2($wpvs_featured_shortcode); ?>" placeholder="Paste shortcode..." />
    </div>

<?php }

function save_rogue_page_slider( $post_id ) {
    if(rogue_save_custom_data( $post_id, 'rogue_slider_save_nonce', 'rogue_slider_save' )) {
        if( isset($_POST['wpvs-slider-type']) ) {
            $new_slider_type = $_POST['wpvs-slider-type'];
            update_post_meta( $post_id, 'wpvs_featured_area_slider_type', $new_slider_type );
        }
        
        if( isset($_POST['rogue_slider_select']) ) {
            $newSliderId = $_POST['rogue_slider_select'];
            update_post_meta( $post_id, 'wpvs_featured_area_slider', $newSliderId );
        }
        
        if( isset($_POST['wpvs-featured-shortcode']) ) {
            $new_featured_shortcode = $_POST['wpvs-featured-shortcode'];
            update_post_meta( $post_id, 'wpvs_featured_shortcode', $new_featured_shortcode );
        }
    }
}
add_action( 'save_post', 'save_rogue_page_slider' );

function rvs_video_homepage_options() {
    wp_nonce_field( 'rvs_home_page_options_save', 'rvs_home_page_options_save_nonce' );
    global $post;
    $post_categories = wp_get_post_terms( $post->ID, 'rvs_video_category', array( 'fields' => 'all', 'orderby' => 'term_id' ));
    $video_home_link = get_post_meta($post->ID, 'rvs_video_home_link', true);
    $video_custom_url = get_post_meta($post->ID, 'wpvs_video_custom_slide_link', true);
    $wpvs_open_video_in_new_tab = get_post_meta($post->ID, 'wpvs_open_video_in_new_tab', true);
    if(empty($video_home_link)) {
        $video_home_link = 'video';
    }
    if( empty($video_custom_url) ) {
        $video_custom_url = "";
    }
    if( $wpvs_open_video_in_new_tab == null ) {
        $wpvs_open_video_in_new_tab = 0;
    }
    $hide_on_home = get_post_meta($post->ID, 'rvs_hide_on_home', true);
    $hide_from_recently_added = get_post_meta($post->ID, 'wpvs_hide_from_recently_added', true);
?>
<h4><?php _e('Hide on homepage sliders', 'vs-netflix'); ?>:</h4>
<label class="selectit"><input type="checkbox" name="rvs_hide_on_home" value="1" <?php checked($hide_on_home, "1"); ?>/><?php _e('Hide on Homepage', 'vs-netflix'); ?></label><br>
<label class="selectit"><input type="checkbox" name="wpvs_hide_from_recently_added" value="1" <?php checked($hide_from_recently_added, "1"); ?>/><?php _e('Hide from Recently Added', 'vs-netflix'); ?></label>
<?php
    global $wpvs_genre_slug_settings; ?>
    <h4><?php _e('Slide Links to', 'vs-netflix'); ?>:</h4>
    <ul class="categorychecklist form-no-clear">
        <li><label class="selectit"><input type="radio" name="rvs_video_home_link" value="video" <?php checked('video', $video_home_link); ?>/><?php _e('Video Page', 'vs-netflix'); ?></label></li>
    <?php 
    if( ! empty($post_categories) ) { 
        foreach($post_categories as $vid_cat) { ?>
            <li><label class="selectit"><input type="radio" name="rvs_video_home_link" value="<?php echo $vid_cat->term_id; ?>" <?php checked($vid_cat->term_id, $video_home_link); ?>/><?php echo $vid_cat->name;?></label></li>
        <?php 
        } 
    } 
    ?>
        <li><label class="selectit"><input type="radio" name="rvs_video_home_link" value="customurl" <?php checked('customurl', $video_home_link); ?>/><?php _e('Custom URL', 'vs-netflix'); ?></label></li>
    </ul>
    <h4><?php _e('Custom URL', 'vs-netflix'); ?>:</h4>
    <input type="text" name="wpvs_video_custom_slide_link" value="<?php echo $video_custom_url; ?>" placeholder="/custom-url" /><br><br>
    <label class="selectit"><input type="checkbox" name="wpvs_open_video_in_new_tab" value="1" <?php checked(1, $wpvs_open_video_in_new_tab); ?> /><?php _e('Open in new tab', 'vs-netflix'); ?></label>
   <?php 
 }

function save_rvs_home_options( $post_id ) {
    if(rogue_save_custom_data( $post_id, 'rvs_home_page_options_save_nonce', 'rvs_home_page_options_save' )) {
        if(isset($_POST['rvs_hide_on_home'])) {
            update_post_meta( $post_id, 'rvs_hide_on_home', 1);
        } else {
            update_post_meta( $post_id, 'rvs_hide_on_home', 0);
        }
        
        if(isset($_POST['wpvs_hide_from_recently_added'])) {
            update_post_meta( $post_id, 'wpvs_hide_from_recently_added', 1);
        } else {
            update_post_meta( $post_id, 'wpvs_hide_from_recently_added', 0);
        }
        
        if( isset($_POST['rvs_video_home_link']) ) {
            $new_home_link = $_POST['rvs_video_home_link'];
            update_post_meta( $post_id, 'rvs_video_home_link', $new_home_link );
        } else {
            update_post_meta( $post_id, 'rvs_video_home_link', 'video');
        }
        
        if( isset($_POST['wpvs_video_custom_slide_link']) ) {
            update_post_meta( $post_id, 'wpvs_video_custom_slide_link', esc_attr($_POST['wpvs_video_custom_slide_link']));
        }
        if( isset($_POST['wpvs_open_video_in_new_tab']) ) {
            update_post_meta( $post_id, 'wpvs_open_video_in_new_tab', 1);
        } else {
            update_post_meta( $post_id, 'wpvs_open_video_in_new_tab', 0);
        }
    }
}
add_action( 'save_post', 'save_rvs_home_options' );

function wpvs_page_builder_options_callback( $post_id ) {
    wp_nonce_field( 'vs_top_spacing_save', 'vs_top_spacing_save_nonce' );
    global $post;
    $remove_top_spacing = get_post_meta($post->ID, '_vs_top_spacing', true);
    $wpvs_page_slider = get_post_meta( $post->ID, 'wpvs_featured_area_slider', true );
    $wpvs_page_featured_area_type = get_post_meta( $post->ID, 'wpvs_featured_area_slider_type', true );
?>
    <label class="selectit"><input type="checkbox" name="vs_top_spacing_hide" value="1" <?php checked($remove_top_spacing, "1"); ?>/><?php _e('Remove Top Header Spacing', 'vs-netflix'); ?></label>
<?php
    if(!empty($wpvs_page_slider) && ! empty($wpvs_page_slider)) { ?>
        <p><em>Does not apply with Slider active.</em></p>
<?php } 
}

function rvs_trailer_meta_box( $post_id ) {
    $wpvs_trailer_js_editor = wp_enqueue_code_editor( array( 'type' => 'text/javascript') );
    $wpvs_custom_trailer_html_editor = wp_enqueue_code_editor( array( 'type' => 'text/html') );
    wp_enqueue_style('net-admin-video-edit', get_template_directory_uri() . '/css/admin/video-edit.css');
    wp_enqueue_script( 'rvs-trailer-js', get_template_directory_uri() . '/js/trailer-video.js', array('jquery','wpvideos-video-post-js'), '', true);
    wp_localize_script( 'rvs-trailer-js', 'wpvstrailerpost', array( 'code_mirror_trailer_js' => wp_json_encode( $wpvs_trailer_js_editor ), 'code_mirror_trailer_html' => wp_json_encode( $wpvs_custom_trailer_html_editor )));
    wp_enqueue_script( 'rvs-trailer-upload', get_template_directory_uri() . '/js/admin/rvs-trailer-upload.js', array('jquery','wpvideos-video-upload'), '', true);
    wp_nonce_field( 'rvs_trailer_meta_save', 'rvs_trailer_meta_save_nonce' );
    
    global $post;
    $rvs_trailer_enabled = get_post_meta($post->ID, 'rvs_trailer_enabled', true);
    
    // GET TRAILER TYPE
    $rvs_trailer_type = get_post_meta($post->ID, '_rvs_trailer_type', true);
    if(empty($rvs_trailer_type)) {
        $rvs_trailer_type = "vimeo";
    }
    
    wp_add_inline_script('code-editor',
    sprintf(
            'jQuery( function() { wp.codeEditor.initialize( "wpvs-custom-trailer-js-code", %s ); } );',
            wp_json_encode( $wpvs_trailer_js_editor )
        )
    );
    wp_add_inline_script('code-editor',
    sprintf(
            'jQuery( function() { wp.codeEditor.initialize( "custom-trailer-code", %s ); } );',
            wp_json_encode( $wpvs_custom_trailer_html_editor )
        )
    );
    
    // WORDPRESS
    $rvs_trailer_wordpress_id = get_post_meta($post->ID, 'rvs_trailer_wordpress_id', true);
    $rvs_trailer_wordpress_code = get_post_meta($post->ID, 'rvs_trailer_wordpress_code', true);
    
    // VIMEO
    $trailer_vimeo_id = get_post_meta($post->ID, 'rvs_trailer_vimeo_id', true);
    $vimeo_trailer_url = get_post_meta($post->ID, 'wpvs_vimeo_trailer_url', true);
    if( empty($vimeo_trailer_url) ) {
        if( ! empty($trailer_vimeo_id) ) {
            $vimeo_trailer_url = 'https://vimeo.com/'.$trailer_vimeo_id;
        } else {
            $vimeo_trailer_url = "";
        }
    }
    
    // GET VIDEO HTML
    $rvs_trailer_html = get_post_meta($post->ID, 'rvs_trailer_html', true);
    
    // YOUTUBE
    $rvs_trailer_youtube_url = get_post_meta($post->ID, 'rvs_trailer_youtube_url', true);
    
    // CUSTOM
    $rvs_trailer_custom_code = get_post_meta($post->ID, 'rvs_trailer_custom_code', true);
    if( empty($rvs_trailer_custom_code) ) {
        $rvs_trailer_custom_code = "";
    }
    $wpvs_custom_trailer_js = get_post_meta($post->ID, 'wpvs_custom_trailer_js', true);
    if( empty($wpvs_custom_trailer_js) ) {
        $wpvs_custom_trailer_js = "";
    }

    ?>
    <div id="trailer-type" class="rvs-container rvs-box rvs-video-container border-box">
        <label class="rvs-label">Select Trailer Type:</label>
        <select id="select-trailer-type" name="select-trailer-type">
            <option value="vimeo" <?php selected("vimeo", $rvs_trailer_type); ?>>Vimeo</option>
            <option value="wordpress" <?php selected("wordpress", $rvs_trailer_type); ?>>WordPress</option>
            <option value="youtube" <?php selected("youtube", $rvs_trailer_type); ?>>YouTube</option>
            <option value="custom" <?php selected("custom", $rvs_trailer_type); ?>>Custom</option>
        
        </select>
        <div id="rvs-enabled-trailer">
            Show Trailer <input type="checkbox" name="rvs-trailer-enabled" id="rvs-trailer-enabled" value="1" <?php checked(1,$rvs_trailer_enabled); ?> />
        </div>
    </div>
    
    <!-- VIMEO -->
    <div id="trailer-vimeo-type-option" class="rvs-trailer-type-area <?=($rvs_trailer_type == 'vimeo') ? 'rvs-display-area' : '' ?>">
        <div class="text-align-right rvs-box rvs-video-container border-box">
            <a href="<?php echo admin_url('admin.php?page=rvs-video-design&tab=vimeo'); ?>" class="rvs-button" target="_blank">Edit Vimeo Player</a>
        </div> 
        <div class="rvs-container rvs-box rvs-video-container border-box">
        <table class="form-table">
            <tbody>
                <tr>
                <th scope="row"><label class="rvs-label">Enter Vimeo URL:</label></th>
                <td><input type="url" class="wpvs-input-url" name="vimeo-trailer-url" id="vimeo-trailer-url" class="regular-text" placeholder="Paste Vimeo link here..." value="<?php echo $vimeo_trailer_url; ?>" /></td>
                </tr>
            </tbody>
        </table> 
        <input type="hidden" name="rvs-trailer-vimeo-id" id="rvs-trailer-vimeo-id" value="<?php echo $trailer_vimeo_id; ?>" />
        </div>
    </div><!-- END VIMEO -->

    <!-- WORDPRESS -->
    <div id="trailer-wordpress-type-option" class="rvs-trailer-type-area <?=($rvs_trailer_type == 'wordpress') ? 'rvs-display-area' : '' ?>">
        <div class="text-align-right rvs-box rvs-video-container border-box">
            <label id="choose-wordpress-trailer" class="rvs-button">Choose Video</label>
        </div>
        <input type="hidden" value="<?php echo $rvs_trailer_wordpress_id; ?>" id="rvs-trailer-wordpress-id" name="rvs-trailer-wordpress-id" />
        <textarea name="rvs-trailer-wordpress-code" id="rvs-trailer-wordpress-code" class="rvs-hidden-code"><?php echo $rvs_trailer_wordpress_code; ?></textarea>
    </div><!-- END WORDPRESS -->
    
    <?php 
        $youtube_player_settings = get_option('rvs_youtube_player_settings');
        if(!empty($youtube_player_settings) && isset($youtube_player_settings['url'])) {
            $youtube_url_string = $youtube_player_settings['url'];
        } else {
            $youtube_url_string = "?enablejsapi=1";
        }
    ?>      

    <!-- YouTube -->
    <div id="trailer-youtube-type-option" class="rvs-trailer-type-area <?=($rvs_trailer_type == 'youtube') ? 'rvs-display-area' : '' ?> ">
        <div class="text-align-right rvs-container rvs-box rvs-video-container border-box">
            <a href="<?php echo admin_url('admin.php?page=rvs-video-design&tab=youtube'); ?>" class="rvs-button" target="_blank">Edit YouTube Player</a>
        </div>
        <div class="rvs-container rvs-box rvs-video-container border-box">
        <table class="form-table">
            <tbody>
                <tr>
                <th scope="row"><label class="rvs-label">Enter YouTube URL:</label></th>
                <td><input type="url" name="trailer-youtube-video-url" id="trailer-youtube-video-url" class="regular-text" placeholder="Paste YouTube link here..." value="<?php echo $rvs_trailer_youtube_url; ?>" /></td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" value="<?php echo $youtube_url_string; ?>" id="rvs-youtube-string" />
        </div>
    </div>

    <!-- Custom -->
    <div id="trailer-custom-type-option" class="rvs-trailer-type-area <?=($rvs_trailer_type == 'custom') ? 'rvs-display-area' : '' ?>">
        <div class="rvs-box rvs-video-container border-box">
            <table class="form-table">
                <tbody>
                    <tr>
                    <td>
                        <h4>Paste embed / iframe / html code:</h4>
                        <textarea name="custom-trailer-code" rows="5" cols="10" id="custom-trailer-code"><?php echo $rvs_trailer_custom_code; ?></textarea></td>
                    </tr>
                    <td>
                        <h4>Custom player javascript (optional):</h4>
                        <p class="description">Javascript code here should be video specific. If you need global JS / CSS files or code for all your custom player videos, add them on the <a href="<?php echo admin_url('admin.php?page=wpvs-custom-player-settings'); ?>" title="Custom Player Settings" >Custom Player</a> page.</p><br>
                        <textarea id="wpvs-custom-trailer-js-code" name="wpvs-custom-trailer-js-code" rows="5" cols="20" ><?php echo $wpvs_custom_trailer_js; ?></textarea>
                    </td>
                </tbody>
            </table>
        </div>
    </div>
    <div class="rvs-video-container border-box rvs-container rvs-box">
        <div id="rvs-trailer-video-holder" class="rvs-responsive-video">
            <h4><?php _e('Trailer Preview', 'vs-netflix'); ?></h4>
            <p>If you are using a <strong>Custom</strong> video player, you may need to Update / Save then refresh the page to see a preview.</p>
            <?php 
                if( $rvs_trailer_type == "wordpress" && ! empty($rvs_trailer_wordpress_code) ) {
                    echo do_shortcode($rvs_trailer_wordpress_code);
                }
                if($rvs_trailer_type == "custom" && ! empty($rvs_trailer_custom_code) ) {
                    echo $rvs_trailer_custom_code;
                }
                if( ($rvs_trailer_type == "vimeo" || $rvs_trailer_type == "youtube") && ! empty($rvs_trailer_html) ) {
                    echo $rvs_trailer_html;
                }
            ?>
        </div>
    </div>

    <textarea name="new-trailer-html" id="new-trailer-html" class="rvs-hidden-code"><?php echo $rvs_trailer_html; ?></textarea>
<?php }

function save_vs_display_options( $post_id ) {
    if(rogue_save_custom_data( $post_id, 'vs_top_spacing_save_nonce', 'vs_top_spacing_save' )) {
        if(isset($_POST['vs_top_spacing_hide'])) {
            $vs_top_spacing = 1;
        } else {
            $vs_top_spacing = 0;
        }
        update_post_meta( $post_id, '_vs_top_spacing', $vs_top_spacing );
    }
}

add_action( 'save_post', 'save_vs_display_options' );

function save_rvs_trailer_video( $post_id ) {
    
    if(rogue_save_custom_data( $post_id, 'rvs_trailer_meta_save_nonce', 'rvs_trailer_meta_save' )) {
        
        // SAVE VIDEO HTML
        if ( isset( $_POST['new-trailer-html'] ) ) {
            $new_trailer_html = $_POST['new-trailer-html'];
            update_post_meta($post_id, 'rvs_trailer_html', $new_trailer_html);
        }
        
        // SAVE VIDEO TYPE
        if ( isset( $_POST['select-trailer-type'] ) ) {
            $save_trailer_type = $_POST['select-trailer-type'];
            update_post_meta( $post_id, '_rvs_trailer_type', $save_trailer_type);
        }
        
        // SAVE VIDEO TYPE
        if ( isset( $_POST['rvs-trailer-vimeo-id'] ) ) {
            $save_trailer_vimeo_id = $_POST['rvs-trailer-vimeo-id'];
            update_post_meta( $post_id, 'rvs_trailer_vimeo_id', $save_trailer_vimeo_id);
        }
        
        if ( isset( $_POST['vimeo-trailer-url'] ) ) {
            $new_vimeo_trailer_url = $_POST['vimeo-trailer-url'];
            update_post_meta($post_id, 'wpvs_vimeo_trailer_url', $new_vimeo_trailer_url);
        }
    
        if ( isset( $_POST['trailer-youtube-video-url'] ) ) {
            $new_trailer_youtube_url = $_POST['trailer-youtube-video-url'];
            update_post_meta($post_id, 'rvs_trailer_youtube_url', $new_trailer_youtube_url);
        }
        
        if ( isset( $_POST['custom-trailer-code'] ) ) {
            $new_trailer_custom_code = $_POST['custom-trailer-code'];
            update_post_meta($post_id, 'rvs_trailer_custom_code', $new_trailer_custom_code);
        }
        
        if ( isset( $_POST['wpvs-custom-trailer-js-code'] ) ) {
            $new_custom_trailer_js_code = $_POST['wpvs-custom-trailer-js-code'];
            update_post_meta($post_id, 'wpvs_custom_trailer_js', $new_custom_trailer_js_code);
        }
        
        if ( isset( $_POST['rvs-trailer-enabled'] ) ) {
            update_post_meta($post_id, 'rvs_trailer_enabled', true);
        } else {
            update_post_meta($post_id, 'rvs_trailer_enabled', false);
        }
        
        if ( isset( $_POST['rvs-trailer-wordpress-id'] ) ) {
            $new_wordpress_trailer_id = $_POST['rvs-trailer-wordpress-id'];
            update_post_meta($post_id, 'rvs_trailer_wordpress_id', $new_wordpress_trailer_id);
        }
        
        if ( isset( $_POST['rvs-trailer-wordpress-code'] ) ) {
            $new_wordpress_trailer_code = $_POST['rvs-trailer-wordpress-code'];
            update_post_meta($post_id, 'rvs_trailer_wordpress_code', $new_wordpress_trailer_code);
        }
        
    }
}

add_action( 'save_post', 'save_rvs_trailer_video' );
function rvs_video_thumbnail_image( $post_id ) {
    global $post;
    $thumbnail_layout = get_theme_mod('vs_thumbnail_style', 'landscape');
    $recommended_thumbnail_size = '640px by 360px';
    if($thumbnail_layout == 'landscape') {
        $image_layout = 'video-thumbnail';
    }
    if($thumbnail_layout == 'portrait') {
        $image_layout = 'video-portrait';
        $recommended_thumbnail_size = '380px by 590px';
    }
    if($thumbnail_layout == 'custom') {
        $wpvs_custom_thumbnail_width = get_theme_mod('wpvs_custom_thumbnail_size_width', '640');
        $wpvs_custom_thumbnail_height = get_theme_mod('wpvs_custom_thumbnail_size_height', '360');
        $image_layout = 'wpvs-custom-thumbnail-size';
        $recommended_thumbnail_size = $wpvs_custom_thumbnail_width.'px by '.$wpvs_custom_thumbnail_height.'px';
    }
    
    wp_enqueue_script('rvs-thumbnail-upload');
    wp_enqueue_media();
    wp_localize_script( 'rvs-thumbnail-upload', 'rvs', array( 'thumbnail' => $image_layout));
    wp_nonce_field( 'rvs_thumbnail_image_save', 'rvs_thumbnail_image_save_nonce' );
    $video_thumbnail_image = get_post_meta($post->ID, 'rvs_thumbnail_image', true);
    if( empty($video_thumbnail_image) ) {
        $video_thumbnail_image = "";
    }
    $video_thumbnail_image_id = get_post_meta($post->ID, 'wpvs_thumbnail_image_id', true);
    if( empty($video_thumbnail_image_id) ) {
        $video_thumbnail_image_id = "";
    }
?>
<p>The thumbnail image is used for video sliders and video browsing pages.</p>
<p>Allows you to set a different Featured Image for the video page. Recommended if using the <a href="<?php echo admin_url('customize.php'); ?>">Netflix video page layout</a>.</p>
<p>You can customize your thumbnail size under <strong>Video Browsing</strong> in the <a href="<?php echo admin_url('customize.php'); ?>"><?php _e('Customizer', 'vs-netflix'); ?></a> area.</p>
<p><strong>Recommend size:</strong> <em><?php echo $recommended_thumbnail_size; ?></em></p>
<input type="hidden" name="rvs_thumbnail_image" id="rvs_thumbnail_image" value="<?php echo $video_thumbnail_image; ?>"/>
<input type="hidden" name="wpvs_thumbnail_image_id" id="wpvs_thumbnail_image_id" value="<?php echo $video_thumbnail_image_id; ?>"/>
<div id="rvs-thumbnail-image-container">
    <?php if(!empty($video_thumbnail_image)) : ?>
        <img id="rvs-set-thumbnail-image" src="<?php echo $video_thumbnail_image; ?>" />
    <?php endif; ?>
</div>
<label id="rvs-select-thumbnail" class="button button-primary">Select Image</label>
<label id="rvs-remove-thumbnail" class="button button-primary">Remove</label>
<?php }

function save_rvs_thumbnail_image( $post_id ) {
    if(rogue_save_custom_data( $post_id, 'rvs_thumbnail_image_save_nonce', 'rvs_thumbnail_image_save' )) {
        if(isset($_POST['rvs_thumbnail_image'])) {
            $new_thumbnail_image = $_POST['rvs_thumbnail_image'];
            update_post_meta( $post_id, 'rvs_thumbnail_image', $new_thumbnail_image );
        }
        
        if(isset($_POST['wpvs_thumbnail_image_id'])) {
            $new_thumbnail_image_id = $_POST['wpvs_thumbnail_image_id'];
            update_post_meta( $post_id, 'wpvs_thumbnail_image_id', $new_thumbnail_image_id );
        }
    }
}
add_action( 'save_post', 'save_rvs_thumbnail_image' );

// CUSTOM VIDEO TEMPLATE

function rvs_video_template_option( $post_id ) {
    global $post;
    wp_nonce_field( 'rvs_video_template_save', 'rvs_video_template_save_nonce' );
    $rvs_video_template = get_post_meta($post->ID, 'rvs_video_template', true);
    if(empty($rvs_video_template)) {
        $rvs_video_template = "default";
    }
?>
<p>Use a specific video page layout.</p><p><strong>Use Default</strong> uses <a href="<?php echo admin_url('customize.php?autofocus[section]=vs_single_video'); ?>" target="_blank">Single Video</a> setting.</p>
<select name="rvs_video_template">
    <option value="default" <?php selected($rvs_video_template, "default"); ?>>Use Default</option>
    <option value="standard" <?php selected($rvs_video_template, "standard"); ?>>Standard</option>
    <option value="netflix" <?php selected($rvs_video_template, "netflix"); ?>>Netflix</option>
    <option value="youtube" <?php selected($rvs_video_template, "youtube"); ?>>YouTube</option>
</select>
<?php }

function save_rvs_video_template_option( $post_id ) {
    if(rogue_save_custom_data( $post_id, 'rvs_video_template_save_nonce', 'rvs_video_template_save' )) {
        if(isset($_POST['rvs_video_template'])) {
            $new_rvs_video_template = $_POST['rvs_video_template'];
            update_post_meta( $post_id, 'rvs_video_template', $new_rvs_video_template );
        }
    }
}
add_action( 'save_post', 'save_rvs_video_template_option' );

// Video Category Order Fields

function rvs_video_category_add_new_meta_field() {
    wp_enqueue_media();
    wp_enqueue_script('wpvs-cat-thumbnails');
    $placeholder_image = get_template_directory_uri() .'/images/placeholder.png';
    $thumbnail_layout = get_theme_mod('vs_thumbnail_style', 'landscape');
    $recommended_thumbnail_size = '640px by 360px';
    if($thumbnail_layout == 'portrait') {
        $recommended_thumbnail_size = '380px by 590px';
    }
    if($thumbnail_layout == 'custom') {
        $wpvs_custom_thumbnail_width = get_theme_mod('wpvs_custom_thumbnail_size_width', '640');
        $wpvs_custom_thumbnail_height = get_theme_mod('wpvs_custom_thumbnail_size_height', '360');
        $image_layout = 'wpvs-custom-thumbnail-size';
        $recommended_thumbnail_size = $wpvs_custom_thumbnail_width.'px by '.$wpvs_custom_thumbnail_height.'px';
    }
	?>
    <h3>TV Show Settings (Optional)</h3>
    <div class="wpvs-cat-option rvs-border-box wpvs-contains-tv-shows">
        <div class="wpvs-cat-details">
		  <label for="cat_contains_shows"><?php _e( 'Contains TV Shows', 'vs-netflix' ); ?></label>
            <p><?php _e( 'Lists TV Shows. Is this a main category for shows (TV Action, TV Comedy, etc)','vs-netflix' ); ?></p>
        </div>
        <div class="wpvs-cat-input">
		  <input type="checkbox" name="cat_contains_shows" id="cat_contains_shows" value="1">
        </div>
	</div>
    <div class="wpvs-cat-option rvs-border-box wpvs-is-tv-show">
        <div class="wpvs-cat-details">
		  <label for="cat_has_seasons"><?php _e( 'Series / TV Show (Has Seasons)', 'vs-netflix' ); ?></label>
            <p><?php _e( 'Is this a TV Show with Seasons and Episodes?','vs-netflix' ); ?>.</p>
            <?php _e( 'Leave this <strong>unchecked</strong> if:','vs-netflix' ); ?>
            <ul class="wpvs-edit-list">
                <li><strong>Contains TV Shows</strong> is already checked</li> 
                <li>This is a <strong>Movie Genre</strong></li>
                <li>This is a <strong>Season</strong></li>
            </ul>
        </div>
        <div class="wpvs-cat-input">
		  <input type="checkbox" name="cat_has_seasons" id="cat_has_seasons" value="1">
        </div>
	</div>
    <div class="wpvs-cat-option rvs-border-box wpvs-is-tv-show">
        <div class="wpvs-cat-images rvs-border-box">
            <p><strong><?php _e( 'TV Show Thumbnail Size','vs-netflix' ); ?>:</strong> <em><?php echo $recommended_thumbnail_size; ?></em></p>
            <div class="wpvs-cat-image-details">
                <div class="wpvs-cat-image-preview">
                    <img class="wpvs-select-thumbnail update-video-cat-attachment" id="wpvs-landscape-preview" src="<?php echo $placeholder_image ?>" data-size="thumbnail"/>
                    <label class="wpvs-cat-thumb-icon"><span class="dashicons dashicons-plus-alt"></span></label>
                    <input class="wpvs-set-thumbnail" type="hidden" name="wpvs_video_cat_thumbnail" id="wpvs_video_cat_thumbnail" value="">
                    <input type="hidden" name="wpvs_video_cat_attachment" id="wpvs_video_cat_attachment" value="">
                </div>
            </div>
            <p><?php _e( 'If this is a TV Show, upload a thumbnail image','vs-netflix' ); ?>. You can customize your thumbnail size under <strong>Video Browsing</strong> in the <a href="<?php echo admin_url('customize.php'); ?>"><?php _e('Customizer', 'vs-netflix'); ?></a> area.</p>
        </div>
    </div>
    <h3><?php _e('Subcategories Order', 'vs-netflix'); ?></h3>
	<div class="wpvs-cat-option rvs-border-box">
        <select name="wpvs_sub_cat_order">
            <option value="title"><?php _e('Title (Default)', 'vs-netflix'); ?></option>
            <option value="id"><?php _e('ID (Creation Date)', 'vs-netflix'); ?></option>
        </select>
        <p><?php _e( 'How subcategories should be ordered','vs-netflix' ); ?></p>
	</div>
    <h3>Homepage Settings</h3>
	<div class="wpvs-cat-option rvs-border-box">
        <div class="wpvs-cat-details">
		  <label for="video_cat_order"><?php _e( 'Homepage Order', 'vs-netflix' ); ?></label>
            <p><?php _e( 'Order of appearance on home page','vs-netflix' ); ?></p>
        </div>
        <div class="wpvs-cat-input">
		  <input class="small-text" type="number" min="0" max="99999" name="video_cat_order" id="video_cat_order" value="0">
        </div>
		
	</div>
    <div class="wpvs-cat-option rvs-border-box">
        <div class="wpvs-cat-details">
		      <label for="video_cat_hide"><?php _e( 'Hide on Homepage', 'vs-netflix' ); ?></label>
            <p><?php _e( 'Hide this category on home page sliders','vs-netflix' ); ?></p>
        </div>
        <div class="wpvs-cat-input">
		  <input type="checkbox" name="video_cat_hide" id="video_cat_hide" value="1">
        </div>
	</div>
<?php
}
add_action( 'rvs_video_category_add_form_fields', 'rvs_video_category_add_new_meta_field', 10, 2 );

function rvs_video_category_edit_meta_field($term) {
    wp_enqueue_media();
    wp_enqueue_script('wpvs-cat-thumbnails');
	$term_order = get_term_meta($term->term_id, 'video_cat_order', true);
    $hide_cat = get_term_meta($term->term_id, 'video_cat_hide', true);
    $contains_shows = get_term_meta($term->term_id, 'cat_contains_shows', true);
    $cat_has_seasons = get_term_meta($term->term_id, 'cat_has_seasons', true);
    $cat_thumb_landscape = get_term_meta($term->term_id, 'wpvs_video_cat_thumbnail', true);
    $order_sub_categories = get_term_meta($term->term_id, 'wpvs_sub_cat_order', true);
    if( empty($cat_thumb_landscape) ) {
        $cat_thumb_landscape = get_template_directory_uri() .'/images/placeholder.png';
    }
    $wpvs_video_cat_attachment = get_term_meta($term->term_id, 'wpvs_video_cat_attachment', true);
    $video_cat_slideshow = get_term_meta($term->term_id, 'video_cat_slideshow', true);
    if( empty($video_cat_slideshow) ) {
        $video_cat_slideshow = 0;
    }
    $wpvs_slidshows = get_option('wpvs_slider_array');
    
    $thumbnail_layout = get_theme_mod('vs_thumbnail_style', 'landscape');
    $recommended_thumbnail_size = '640px by 360px';
    if($thumbnail_layout == 'portrait') {
        $recommended_thumbnail_size = '380px by 590px';
    }
    if($thumbnail_layout == 'custom') {
        $wpvs_custom_thumbnail_width = get_theme_mod('wpvs_custom_thumbnail_size_width', '640');
        $wpvs_custom_thumbnail_height = get_theme_mod('wpvs_custom_thumbnail_size_height', '360');
        $image_layout = 'wpvs-custom-thumbnail-size';
        $recommended_thumbnail_size = $wpvs_custom_thumbnail_width.'px by '.$wpvs_custom_thumbnail_height.'px';
    }
    if( empty($order_sub_categories) ) {
        $order_sub_categories = 'title';
    }
    ?>

    <tr class="wpvs-contains-tv-shows">
        <th scope="row" valign="top"><label for="video_cat_order"><?php _e( 'Contains TV Shows', 'vs-netflix' ); ?></label></th>
            <td>
                <input type="checkbox" min="0" name="cat_contains_shows" id="cat_contains_shows" value="1" <?php checked(1,$contains_shows); ?>>
                <?php _e( 'Lists TV Shows. Is this a main category for shows (TV Action, TV Comedy, etc)','vs-netflix' ); ?>
            </td>
        </tr>
	<tr>
    <tr class="wpvs-is-tv-show">
        <th scope="row" valign="top"><label for="video_cat_order"><?php _e( 'Series / TV Show (Has Seasons)', 'vs-netflix' ); ?></label></th>
            <td>
                <input type="checkbox" min="0" name="cat_has_seasons" id="cat_has_seasons" value="1" <?php checked(1,$cat_has_seasons); ?>>
                <?php _e( 'Leave this <strong>unchecked</strong> if:','vs-netflix' ); ?>
                <ul class="wpvs-edit-list">
                    <li><strong>Contains TV Shows</strong> is already checked</li> 
                    <li>This is a <strong>Movie Genre</strong></li>
                    <li>This is a <strong>Season</strong></li>
                </ul>
            </td>
        </tr>
	<tr>
    <tr>
        <th scope="row" valign="top"><label><?php _e( 'TV Show Thumbnail Image', 'vs-netflix' ); ?> (<?php echo $recommended_thumbnail_size; ?>)</label></th>
		<td>
        <div id="wpvs-cat-images" class="wpvs-cat-images rvs-border-box wpvs-is-tv-show">
            <div class="wpvs-cat-image-details">
                <div class="wpvs-cat-image-preview">
                    <img class="wpvs-select-thumbnail update-video-cat-attachment" id="wpvs-landscape-preview" src="<?php echo $cat_thumb_landscape ?>" data-size="thumbnail"/>
                    <label class="wpvs-cat-thumb-icon"><span class="dashicons dashicons-plus-alt"></span></label>
                    <input class="wpvs-set-thumbnail" type="hidden" name="wpvs_video_cat_thumbnail" id="wpvs_video_cat_thumbnail" value="<?php echo $cat_thumb_landscape ?>">
                    <input type="hidden" name="wpvs_video_cat_attachment" id="wpvs_video_cat_attachment" value="<?php echo $wpvs_video_cat_attachment ?>">
                </div>
            </div>
            <p>You can customize your thumbnail size under <strong>Video Browsing</strong> in the <a href="<?php echo admin_url('customize.php'); ?>"><?php _e('Customizer', 'vs-netflix'); ?></a> area.</p>
        </div>
        </td>
	</tr>
    <tr>
	<th scope="row" valign="top"><label for="wpvs_sub_cat_order"><?php _e( 'Subcategories Order', 'vs-netflix' ); ?></label></th>
		<td>
            <select name="wpvs_sub_cat_order">
                <option value="title" <?php selected('title', $order_sub_categories); ?>><?php _e('Title (Default)', 'vs-netflix'); ?></option>
                <option value="id" <?php selected('id', $order_sub_categories); ?>><?php _e('ID (Creation Date)', 'vs-netflix'); ?></option>
            </select>
		</td>
	</tr>
    <tr>
	<th scope="row" valign="top"><label for="video_cat_order"><?php _e( 'Homepage Order', 'vs-netflix' ); ?></label></th>
		<td>
			<input class="small-text" type="number" min="0" max="99999" name="video_cat_order" id="video_cat_order" value="<?php echo $term_order; ?>">
			<?php _e( 'Order of appearance on home page','vs-netflix' ); ?>
		</td>
	</tr>
    <tr>
	<th scope="row" valign="top"><label for="video_cat_hide"><?php _e( 'Hide on Homepage', 'vs-netflix' ); ?></label></th>
		<td>
			<input type="checkbox" name="video_cat_hide" id="video_cat_hide" value="1" <?php checked(1,$hide_cat); ?>>
			<?php _e( 'Hide this category on home page sliders','vs-netflix' ); ?>
		</td>
	</tr>
    <tr>
    <th scope="row" valign="top"><label><?php _e( 'Featured Slider', 'vs-netflix' ); ?></label></th>
		<td>
            <select id="wpvs_cat_slideshow"  name="wpvs_cat_slideshow">
			<?php
                if( ! empty($wpvs_slidshows) ) {
                    foreach($wpvs_slidshows as $slideshow) {
                        echo '<option value="'.$slideshow['id'].'"' . selected( $slideshow['id'], $video_cat_slideshow ) . ' >'.$slideshow['name'].'</option>';
                    }
                }
            ?>
                <option value="0" <?php selected( 0, $video_cat_slideshow ); ?>>None</option>
            </select>
		</td>
	</tr>
<?php

}
add_action( 'rvs_video_category_edit_form_fields', 'rvs_video_category_edit_meta_field', 10, 2 );

function wpvs_theme_save_taxanomy_custom_meta( $term_id ) {
	if ( isset( $_POST['video_cat_order'] ) ) {
		$new_video_order = $_POST['video_cat_order'];
        if($new_video_order == "") {
            $new_video_order = "0";
        }
		update_term_meta($term_id, 'video_cat_order', $new_video_order);
	}
    if ( isset( $_POST['video_cat_hide'] ) ) {
		update_term_meta($term_id, 'video_cat_hide', $_POST['video_cat_hide']);
	} else {
        update_term_meta($term_id, 'video_cat_hide', 0);
    }
    if ( isset( $_POST['cat_contains_shows'] ) ) {
		update_term_meta($term_id, 'cat_contains_shows', $_POST['cat_contains_shows']);
	} else {
        update_term_meta($term_id, 'cat_contains_shows', 0);
    }
    if ( isset( $_POST['cat_has_seasons'] ) ) {
		update_term_meta($term_id, 'cat_has_seasons', $_POST['cat_has_seasons']);
	} else {
        update_term_meta($term_id, 'cat_has_seasons', 0);
    }
    
    // CATEGORY THUMBNAILS
    if ( isset( $_POST['wpvs_video_cat_attachment'] ) && !empty($_POST['wpvs_video_cat_attachment']) ) {
        update_term_meta($term_id, 'wpvs_video_cat_attachment', $_POST['wpvs_video_cat_attachment']);
	}
    if ( isset( $_POST['wpvs_video_cat_thumbnail'] ) ) {
		update_term_meta($term_id, 'wpvs_video_cat_thumbnail', $_POST['wpvs_video_cat_thumbnail']);
	}
    if ( isset( $_POST['wpvs_cat_slideshow'] ) ) {
		update_term_meta($term_id, 'video_cat_slideshow', $_POST['wpvs_cat_slideshow']);
	}
    if ( isset( $_POST['wpvs_sub_cat_order'] ) ) {
		update_term_meta($term_id, 'wpvs_sub_cat_order', $_POST['wpvs_sub_cat_order']);
	} 
}  
add_action( 'edited_rvs_video_category', 'wpvs_theme_save_taxanomy_custom_meta', 10, 2 );  
add_action( 'create_rvs_video_category', 'wpvs_theme_save_taxanomy_custom_meta', 10, 2 );

function wpvs_actors_add_new_meta_field() {
    wp_enqueue_media();
    wp_enqueue_script('wpvs-upload-thumbnails');
	$profile_image = get_template_directory_uri() .'/images/profile.png';
	?>
    <div class="form-field term-slug-wrap">
        <label><?php _e( 'Profile Image', 'vs-netflix' ); ?></label>
        <div class="wpvs-cat-image-preview">
        <img class="wpvs-select-thumbnail update-video-cat-attachment" id="wpvs-landscape-preview" src="<?php echo $profile_image ?>" data-size="thumbnail"/>
        <label class="wpvs-cat-thumb-icon"><span class="dashicons dashicons-plus-alt"></span></label>
        <input class="wpvs-set-thumbnail" type="hidden" name="wpvs_actor_profile_photo" id="wpvs_actor_profile_photo" value="">
        <input class="wpvs-thumbnail-attachment" type="hidden" name="wpvs_actor_photo_attachment" id="wpvs_actor_photo_attachment" value="">
        </div>
        <p class="description"><?php _e('Recommended size', 'vs-netflix'); ?> (150px by 150px)</p>
    </div>

    <div class="form-field term-slug-wrap">
        <label><?php _e( 'Profile Link (IMDb)', 'vs-netflix' ); ?></label>
        <input type="url" name="wpvs_actor_imdb_link" value="" />
        <p><?php _e('Link to a profile such as on IMDb', 'vs-netflix'); ?></p>
    </div>

<?php
}
add_action( 'rvs_actors_add_form_fields', 'wpvs_actors_add_new_meta_field', 10, 2 );
add_action( 'rvs_directors_add_form_fields', 'wpvs_actors_add_new_meta_field', 10, 2 );

function wpvs_actors_edit_meta_field($term) {
    wp_enqueue_media();
    wp_enqueue_script('wpvs-upload-thumbnails');
	$profile_image = get_term_meta($term->term_id, 'wpvs_actor_profile', true);
    if( empty($profile_image) ) {
        $profile_image = get_template_directory_uri() .'/images/profile.png';
    }
    $profile_image_attachment = get_term_meta($term->term_id, 'wpvs_actor_profile_attachment', true);
    if( empty($profile_image_attachment) ) {
        $profile_image_attachment = "";
    }
    $imdb_link = get_term_meta($term->term_id, 'wpvs_actor_imdb_link', true);
    if( empty($imdb_link) ) {
        $imdb_link = "";
    }
    ?>
    <tr class="form-field term-slug-wrap">
        <th scope="row" valign="top"><label><?php _e( 'Profile Image', 'vs-netflix' ); ?></label></th>
        <td>
        <div class="wpvs-cat-image-preview">
        <img class="wpvs-select-thumbnail update-video-cat-attachment" id="wpvs-landscape-preview" src="<?php echo $profile_image ?>" data-size="thumbnail"/>
        <label class="wpvs-cat-thumb-icon"><span class="dashicons dashicons-plus-alt"></span></label>
        <input class="wpvs-set-thumbnail" type="hidden" name="wpvs_actor_profile_photo" id="wpvs_actor_profile_photo" value="<?php echo $profile_image ?>">
        <input class="wpvs-thumbnail-attachment" type="hidden" name="wpvs_actor_photo_attachment" id="wpvs_actor_photo_attachment" value="<?php echo $profile_image_attachment; ?>">
        </div>
        <p class="description"><?php _e('Recommended size', 'vs-netflix'); ?> (150px by 150px)</p>
        </td>
    </tr>
    <tr class="form-field">
	<th scope="row" valign="top"><label><?php _e( 'Profile Link (IMDb)', 'vs-netflix' ); ?></label></th>
		<td>
			<input type="url" name="wpvs_actor_imdb_link" value="<?php echo $imdb_link; ?>" size="40"/>
			<p class="description"><?php _e('Link to a profile such as on IMDb', 'vs-netflix'); ?></p>
		</td>
	</tr>
<?php

}
add_action( 'rvs_actors_edit_form_fields', 'wpvs_actors_edit_meta_field', 10, 2 );
add_action( 'rvs_directors_edit_form_fields', 'wpvs_actors_edit_meta_field', 10, 2 );

function wpvs_theme_save_actors_custom_meta( $term_id ) {
    // CATEGORY THUMBNAILS
    if ( isset( $_POST['wpvs_actor_profile_photo'] ) && !empty($_POST['wpvs_actor_profile_photo']) ) {
        update_term_meta($term_id, 'wpvs_actor_profile', $_POST['wpvs_actor_profile_photo']);
	}
    if ( isset( $_POST['wpvs_actor_photo_attachment'] ) ) {
		update_term_meta($term_id, 'wpvs_actor_profile_attachment', $_POST['wpvs_actor_photo_attachment']);
	}
    if ( isset( $_POST['wpvs_actor_imdb_link'] ) ) {
		update_term_meta($term_id, 'wpvs_actor_imdb_link', $_POST['wpvs_actor_imdb_link']);
	}
    
}  
add_action( 'edited_rvs_actors', 'wpvs_theme_save_actors_custom_meta', 10, 2 );  
add_action( 'create_rvs_actors', 'wpvs_theme_save_actors_custom_meta', 10, 2 );
add_action( 'edited_rvs_directors', 'wpvs_theme_save_actors_custom_meta', 10, 2 );  
add_action( 'create_rvs_directors', 'wpvs_theme_save_actors_custom_meta', 10, 2 );

function rogue_save_custom_data( $post_id, $save_nonce, $save_nonce_name ) {
    if ( ! isset( $_POST[$save_nonce] ) ) {
        return false;
    }
    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST[$save_nonce], $save_nonce_name ) ) {
        return false;
    }
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return false;
    }
    if ( wp_is_post_revision( $post_id ) )
        return false;
    // Check the user's permissions.
    
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return false;
    }
    
    return true;
}