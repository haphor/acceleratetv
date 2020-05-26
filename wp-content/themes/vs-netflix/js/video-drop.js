jQuery(document).ready(function() {
    jQuery('body').delegate('.video-slide, .video-item', 'click', function(e) {
        if(jQuery(e.target).hasClass('show-vs-drop') || jQuery(e.target).parent().hasClass('show-vs-drop')) {
            e.preventDefault();
            jQuery(this).parent().addClass('active-slide');
            var drop_label = jQuery(this).find('.show-vs-drop');
            var video_id = drop_label.data('video');
            var slide_type = drop_label.data('type');
            var parent_slider = jQuery(this).parents('.slide-category');
            var displaybox = parent_slider.next('.vs-video-description-drop');
            if( ! displaybox.hasClass('open') ) {
                displaybox.addClass('open');
                displaybox.slideDown();
            }
            vs_drop_video_details(video_id, displaybox, slide_type);
        }
    });
    if( ! vsdrop.is_mobile ) {
        jQuery('body').delegate('.video-slide, .video-item','mouseenter', function(e) {
            if( ! jQuery(this).hasClass('active-slide')) {
                jQuery('.video-slide, .video-item').removeClass('active-slide');
                jQuery(this).addClass('active-slide');
                var parent_slider = jQuery(this).parents('.slide-category');
                var displaybox = parent_slider.next('.vs-video-description-drop');
                if(displaybox.hasClass('open')) {
                    var drop_label = jQuery(this).find('.show-vs-drop');
                    var video_id = drop_label.data('video');
                    var slide_type = drop_label.data('type');
                    vs_drop_video_details(video_id, displaybox, slide_type);
                }
            }
        });
    }

     jQuery('body').delegate('.wpvs-close-video-drop','click', function() {
         var parent_drop_down = jQuery(this).parent();
         parent_drop_down.slideUp().removeClass('open');
         var parent_slick_slider = parent_drop_down.prev('.slide-category');
         if( parent_slick_slider.hasClass('active-slide') ) {
             parent_slick_slider.removeClass('active-slide');
         } else {
             parent_slick_slider.find('.active-slide').removeClass('active-slide');
         }

    });

});

function vs_drop_video_details(videoid, displaybox, slide_type) {
    displaybox.find('.drop-display').removeClass('active');
    var drop_box_exists = displaybox.find('[data-drop-box="'+videoid+'"]');
    if(drop_box_exists.length > 0) {
        drop_box_exists.addClass('active');
    } else {
        displaybox.find('.drop-loading').show();
        jQuery.ajax({
            url: vsdrop.url,
            type: "POST",
            data: {
                'action': 'wpvs_get_video_drop_down_details',
                'videoid': videoid,
                'slide_type': slide_type
            },
            success:function(response) {
                if(response != "Missing video id" && response.length > 0) {
                    var videodetails = JSON.parse(response);
                    var video_title = videodetails.video_title;
                    var video_description = videodetails.video_description;
                    var video_details = videodetails.video_details;
                    var video_information = videodetails.video_information;
                    var video_link = videodetails.video_link;
                    if(vsdrop.fullscreen) {
                        if ( (video_link.indexOf("?") > -1) || (video_link.indexOf("?page_id") > -1) ) {
                            video_link += '&';
                        } else {
                            video_link += '?';
                        }
                        video_link += 'wpvsopen=1';
                    }
                    var video_image = videodetails.video_image;
                    var add_to_list_button = videodetails.added_to_list;
                    var new_drop_display = '<div class="drop-display active" style="background-image: url('+video_image+');" data-drop-box="'+videoid+'"><div class="vs-drop-details"><h3 class="drop-title">'+video_title+'</h3>'+video_information+'<p class="drop-description">'+video_description+'</p><div class="drop-info">'+video_details+'</div><a href="'+video_link+'" class="button vs-drop-button vs-drop-link wpvs-play-button">'+vsdrop.watchtext+' <span class="dashicons dashicons-controls-play"></span></a>'+add_to_list_button+'</div><a href="'+video_link+'" class="vs-drop-link vs-drop-play-button border-box"><span class="dashicons dashicons-controls-play"></span></a>';

                    if( videodetails.episodes.length > 0 ) {
                        new_drop_display += '<div class="video-category slide-category episode-slider">';
                        new_drop_display += '<h4>'+vsdrop.more_episodes+'</h4>';
                        new_drop_display += '<div class="video-list-slider episode-slider-list" data-items="'+videodetails.episodes.length+'">';
                        jQuery(videodetails.episodes).each( function(num, episode) {
                            new_drop_display += '<a class="video-slide" href="'+episode.episode_link+'">';
                            new_drop_display += '<div class="video-slide-image border-box"><img src="'+episode.episode_image+'" alt="'+episode.episode_title+'" /></div>';
                            new_drop_display += '<div class="video-slide-details border-box"><h4>'+episode.episode_title+'</h4></div></a>';
                        });
                        new_drop_display += '</div></div>';
                    }
                    new_drop_display += '</div>';
                    displaybox.find('.drop-loading').hide();
                    displaybox.append(new_drop_display);
                    var episode_slider = displaybox.find('.episode-slider-list');
                    if( episode_slider ) {
                        wpvs_load_inner_episode_slider(episode_slider);
                    }
                }

            },
            error: function(response){

            }
        });
    }
}
