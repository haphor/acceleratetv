function load_more_rvs_videos() {
    jQuery('#scroll-here').remove();
    if(jQuery('#video-list').length < 1) {
        jQuery('#video-list-loaded').append('<div id="video-list"></div>');
    }
    
    jQuery.ajax({
        url: rvsajax.url,
        type: "POST",
        data: {
            'action': 'rvs_load_videos_ajax_request',
            'video_offset': video_offset,
            'video_cat': rvsajax.videocat,
            'term_type': rvsajax.termtype,
            'videos_per_page': videos_per_page,
            'videoid': rvsajax.videoid,
            'terms_added': video_terms_added
        },
        success:function(response) {
            var no_more_videos = false;
            if(response != "none") {
                var more_videos = JSON.parse(response);
                var add_to_list = "";
                var video_counter = 0;
                jQuery.each(more_videos.videos, function(index, video) {
                    var open_new_tab = (video.new_tab == 1) ? 'target="_blank"' : '';
                    add_to_list += '<a class="video-item border-box" href="'+video.video_link+'" '+open_new_tab+'><div class="video-item-content"><div class="video-slide-image border-box"><img src="'+video.video_thumbnail+'" alt="'+video.video_title+'"/></div><div class="video-slide-details border-box"><h4>'+video.video_title+'</h4><p>'+video.video_excerpt+'</p></div></div>';
                    if(rvsajax.dropdown) {
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
}