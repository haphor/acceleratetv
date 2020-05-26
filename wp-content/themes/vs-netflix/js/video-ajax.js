var video_offset = 0;
var videos_per_page;
var loaded_videos = false;
var video_terms_added = [];
var wpvs_video_list_width;
jQuery(document).ready( function() {
    if(jQuery('#loading-video-list').length > 0) {
        wpvs_video_list_width = jQuery('#loading-video-list').width();
        if(wpvs_video_list_width < 768) {
             videos_per_page = 18;
        }
        if(wpvs_video_list_width >= 768) {
            videos_per_page = 33;
        }

        if(wpvs_video_list_width >= 1200) {
            videos_per_page = 44;
        }

        if(wpvs_video_list_width >= 1400) {
            videos_per_page = 60;
        }
        load_more_rvs_videos();
        jQuery(window).scroll(check_load_position);
    }
});
var current_window_width = jQuery(window).width();
jQuery(window).resize(wpvs_reset_grid_items);

function check_load_position() {
    if(jQuery('#scroll-here').length > 0) {
        var window_height = jQuery(window).height();
        var load_location = jQuery('#scroll-here').offset().top;
        var check_load_position = load_location - jQuery(window).scrollTop();
        if(check_load_position <= (window_height) && !loaded_videos) {
            loaded_videos = true;
            load_more_rvs_videos();
        }
    }
}

function wpvs_reset_grid_items() {
    if(current_window_width != jQuery(window).width()) {
        current_window_width = jQuery(window).width();
        jQuery('.vs-video-description-drop').remove();
        if(jQuery('#video-list-loaded').length > 0) {
            wpvs_video_list_width = jQuery('#video-list-loaded').width();
        } else {
            wpvs_video_list_width = jQuery(window).width();
        }
        
        var items_per_grid = loadvideosajax.count.mobile;
        if(wpvs_video_list_width >= 600) {
            items_per_grid = loadvideosajax.count.tablet;
        }
        if(wpvs_video_list_width >= 960) {
            items_per_grid = loadvideosajax.count.laptop;
        }

        if(wpvs_video_list_width >= 1200) {
            items_per_grid = loadvideosajax.count.desktop;
        }

        if(wpvs_video_list_width >= 1600) {
            items_per_grid = loadvideosajax.count.large;
        }

        jQuery('#video-list-loaded .video-item').unwrap();
        jQuery('#video-list-loaded').data('items-per-row', items_per_grid).attr('items-per-row', items_per_grid);
        var video_items = jQuery('#video-list-loaded .video-item');
        for(var i = 0; i < video_items.length; i+= parseInt(items_per_grid) ) {
          video_items.slice(i, i+items_per_grid).wrapAll('<div class="video-item-grid slide-category"></div>');
        }
        if(loadvideosajax.dropdown) {
            jQuery('#video-list-loaded .video-item-grid').after('<div class="vs-video-description-drop browse-drop border-box"><label class="wpvs-close-video-drop"><span class="dashicons dashicons-no-alt"></span></label><div class="drop-loading border-box"><label class="net-loader"></label></div></div>');
        }
    }
}

function wpvs_create_grid_items() {
    if(jQuery('#video-list-loaded').length > 0) {
        wpvs_video_list_width = jQuery('#video-list-loaded').width();
    } else {
        wpvs_video_list_width = jQuery(window).width();
    }
    var items_per_grid = loadvideosajax.count.mobile;
    if(wpvs_video_list_width >= 600) {
        items_per_grid = loadvideosajax.count.tablet;
    }
    if(wpvs_video_list_width >= 960) {
        items_per_grid = loadvideosajax.count.laptop;
    }
    if(wpvs_video_list_width >= 1200) {
        items_per_grid = loadvideosajax.count.desktop;
    }
    if(wpvs_video_list_width >= 1600) {
        items_per_grid = loadvideosajax.count.large;
    }
    var video_items = jQuery('#video-list .video-item');
    jQuery('#video-list-loaded').data('items-per-row', items_per_grid).attr('items-per-row', items_per_grid);
    for(var i = 0; i < video_items.length; i+= parseInt(items_per_grid) ) {
      video_items.slice(i, i+items_per_grid).wrapAll('<div class="video-item-grid slide-category"></div>');
    }
    if(loadvideosajax.dropdown) {
        jQuery('#video-list .video-item-grid').after('<div class="vs-video-description-drop browse-drop border-box"><label class="wpvs-close-video-drop"><span class="dashicons dashicons-no-alt"></span></label><div class="drop-loading border-box"><label class="net-loader"></label></div></div>');
    }
    wpvs_show_video_list();
}

function wpvs_show_video_list() {
     if(jQuery('#loading-video-list').length > 0) {
        jQuery('#loading-video-list').fadeOut('slow').remove();
        jQuery('#video-list-loaded').delay(600).fadeIn('slow');
     }
     jQuery('#video-list').contents().unwrap();
     jQuery('#video-list-loaded').append('<div id="scroll-here"></div>');
}
