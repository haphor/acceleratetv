function load_more_rvs_videos() {
    jQuery('#scroll-here').remove();
    if(jQuery('#video-list').length < 1) {
        jQuery('#video-list-loaded').append('<div id="video-list"></div>');
    }
    var load_video_type = jQuery('#video-list-loaded').data('type');
    
    jQuery.ajax({
        url: userajax.url,
        type: "POST",
        data: {
            'action': 'wpvs_load_user_videos_ajax_request',
            'purchase_type': load_video_type,
            'videos_per_page': videos_per_page,
        },
        success:function(response) {
            var no_more_videos = false;
            if(response != "none") {
                var more_videos = JSON.parse(response);
                var add_to_list = "";
                var video_counter = 0;
                jQuery.each(more_videos.videos, function(index, video) {
                    add_to_list += '<a class="video-item border-box" href="'+video.video_link+'"><div class="video-item-content"><div class="video-slide-image border-box"><img src="'+video.video_thumbnail+'" alt="'+video.video_title+'"/></div><div class="video-slide-details border-box"><h4>'+video.video_title+'</h4><p>'+video.video_excerpt+'</p></div>';
                    
                    if(video.download_link && video.download_link != "") {
                        add_to_list += '<label class="wpvs-video-download-link" data-download="'+video.download_link+'" download><span class="dashicons dashicons-download"></span></label>';
                    }
                    if(video.rental_time_left && video.rental_time_left != "") {
                        add_to_list += '<label class="rental-time-left border-box">'+video.rental_time_left+' '+userajax.hourstext+'</label>';
                    }
                    add_to_list += '</div>';
                    
                    if(userajax.dropdown) {
                        add_to_list += '<label class="show-vs-drop ease3" data-video="'+video.video_id+'" data-type="'+video.type+'"><span class="dashicons dashicons-arrow-down-alt2"></span></label>';
                    }
                    add_to_list += '</a>';
                    video_offset++;
                    video_counter++;
                });
                if(more_videos.offset) {
                    video_offset = more_videos.offset;
                }
                jQuery('#video-list').append(add_to_list);
                loaded_videos = false;
                if( more_videos.videos.length < videos_per_page) {
                    no_more_videos = true;
                }
                if(more_videos.added && more_videos.added.length > 0) {
                    jQuery.each(more_videos.added, function(index, term) {
                        if (jQuery.inArray(term, video_terms_added) < 0) {
                            video_terms_added.push(term);
                        }
                    });
                }
            }
            if(response == "none") {
                no_more_videos = true;
            }
            
            if(no_more_videos) {
                loaded_videos = true;
            }
            wpvs_create_grid_items();
        },
        error: function(response){
            
        }
    });
    
    jQuery(document).delegate('.video-item').click( function(e) {
        var video_item = jQuery(this);
        if ( jQuery(e.target).hasClass('wpvs-video-download-link') || jQuery(e.target).parent().hasClass('wpvs-video-download-link') ) {
            e.preventDefault();
            var download_button = video_item.find('.wpvs-video-download-link');
            var video_download_link = download_button.data('download');
            var download_url = decodeURIComponent(video_download_link);
            if(download_url != "") {
                window.location.href = download_url;
            }
        }
    });
}