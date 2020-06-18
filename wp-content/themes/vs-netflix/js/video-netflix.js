var video_shifted = false;
jQuery(document).ready( function() {
    vs_set_content_height();
    if( typeof(wpvs_vimeo_player) != 'undefined' && wpvs_vimeo_player != null ) {
        jQuery('#vs-video-back').click(function() {
            wpvs_vimeo_player.pause();
        });
        jQuery('#vs-play-video').click(function() {
            wpvs_vimeo_player.play();
        });
    }
    
    if( typeof(wpvs_vimeo_trailer_player) != 'undefined' && wpvs_vimeo_trailer_player != null ) {
        jQuery('#vs-video-back').click(function() {
            wpvs_vimeo_trailer_player.pause();
        });
        jQuery('#vs-play-trailer').click(function() {
            wpvs_vimeo_trailer_player.play();
        });
    }
    
    jQuery('#vs-video-back').click(function() {
        jQuery('.vs-full-screen-video').removeClass('show-full-screen-video');
        if(typeof(wpvs_count_down_interval) != 'undefined' && wpvs_count_down_interval) {
            clearInterval(wpvs_count_down_interval);
            jQuery('#wpvs-autoplay-countdown').hide();
            wpvs_load_video_count_down = wpvideosinfo.timer;
            jQuery('#wpvs-autoplay-count').text(wpvs_load_video_count_down);
        }
    });
    
    jQuery('#vs-play-video').click(function() {
        jQuery('#rvs-trailer-video').hide();
        jQuery('#rvs-main-video').show();
        jQuery('.vs-full-screen-video').addClass('show-full-screen-video');
    });
    
    jQuery('#vs-play-trailer').click(function() {
        jQuery('#rvs-main-video').hide();
        jQuery('#rvs-trailer-video').show();
        jQuery('.vs-full-screen-video').addClass('show-full-screen-video');
    });
   
    if( vsdetails.videotype == "youtube" ) {
        jQuery( document ).bind('wpvsYouTubePlayerReady', function() {
            if(typeof(wpvs_youtube_player) != 'undefined' && wpvs_youtube_player != null) {
                wpvs_youtube_player.addEventListener('onReady', 'onWPVSYouTubePlayerReady');
            }
        });

        jQuery('#vs-video-back').click(function() {
            if(typeof(wpvs_youtube_player) != 'undefined' && wpvs_youtube_player != null) {
                if(jQuery.isFunction(wpvs_youtube_player.pauseVideo)) {
                    wpvs_youtube_player.pauseVideo();
                }
            }
        });
        jQuery('#vs-play-video').click(function() {
            if(typeof(wpvs_youtube_player) != 'undefined' && wpvs_youtube_player != null) {
                if(jQuery.isFunction(wpvs_youtube_player.playVideo)) {
                    wpvs_youtube_player.playVideo();
                }
            }
        });
    }
    
    if( vsdetails.trailertype == "youtube" ) {
        jQuery( document ).bind('wpvsYouTubeTrailerPlayerReady', function() {
            if(typeof(wpvs_youtube_trailer_player) != 'undefined' && wpvs_youtube_trailer_player != null) {
                wpvs_youtube_trailer_player.addEventListener('onReady', 'onWPVSYouTubeTrailerPlayerReady');
            }
        });

        jQuery('#vs-video-back').click(function() {
            if(typeof(wpvs_youtube_trailer_player) != 'undefined' && wpvs_youtube_trailer_player != null) {
                if(jQuery.isFunction(wpvs_youtube_trailer_player.pauseVideo)) {
                    wpvs_youtube_trailer_player.pauseVideo();
                }
            }
        });
        jQuery('#vs-play-trailer').click(function() {
            if(typeof(wpvs_youtube_trailer_player) != 'undefined' && wpvs_youtube_trailer_player != null) {
                if(jQuery.isFunction(wpvs_youtube_trailer_player.playVideo)) {
                    wpvs_youtube_trailer_player.playVideo();
                }
            }
        });
    }
    
    if(vsdetails.videotype == "wordpress" && jQuery('#rvs-main-video .videoWrapper').length > 0) {
        var wpvs_main_video_element = jQuery('#rvs-main-video .videoWrapper video').first();
        if(typeof(wpvs_main_video_element) !== "undefined") {
            jQuery('#vs-play-video').click(function() {
                wpvs_main_video_element[0].play();
            });
            jQuery('#vs-video-back').click(function() {
                wpvs_main_video_element[0].pause();
            });
        }
    }
    
    if(vsdetails.trailertype == "wordpress" && jQuery('#rvs-trailer-video .videoWrapper').length > 0) {
        var wpvs_trailer_video_element = jQuery('#rvs-trailer-video .videoWrapper video').first();
        if(typeof(wpvs_trailer_video_element) !== "undefined") {
            jQuery('#vs-play-trailer').click(function() {
                wpvs_trailer_video_element[0].play();
            });
            jQuery('#vs-video-back').click(function() {
                wpvs_trailer_video_element[0].pause();
            });
        }
    }
});

function onWPVSYouTubePlayerReady(event) {
    jQuery('#vs-video-back').click(function() {
        event.target.pauseVideo();
    });
    jQuery('#vs-play-video').click(function() {
        event.target.playVideo();
    });
}

function onWPVSYouTubeTrailerPlayerReady(event) { 
    jQuery('#vs-video-back').click(function() {
        event.target.pauseVideo();
    });
    jQuery('#vs-play-trailer').click(function() {
        event.target.playVideo();
    });
}

jQuery(window).resize(vs_set_content_height);
function vs_set_content_height() {
    var video_image = jQuery('.vs-video-header img.video-image');
    var image_width = video_image.width();
    if(vsdetails.panning && !video_shifted) {
        if(image_width > jQuery(window).width()) {
            var change_interval = 80000;
            var image_difference = image_width - jQuery(window).width();
            if(jQuery(window).width() >= 960) {
                change_interval = 60000;
            }

            if(jQuery(window).width() >= 1200) {
                change_interval = 50000;
            }
            vs_shift_video_image(video_image, image_difference, change_interval);
        } else {
            vs_remove_shift_video_image(video_image);
        }
    }
}

function vs_shift_video_image(image, space, interval) {
    video_shifted = true;
    var set_timeout_int = interval / 2;
    image.css({
        'transform' : 'translateX(-'+space+'px) scale(1.2)',
        '-webkit-transform' : 'translateX(-'+space+'px) scale(1.2)',
        '-moz-transform' : 'translateX(-'+space+'px) scale(1.2)'
    });
    setTimeout(vs_remove_shift_video_image, set_timeout_int, image);
}

function vs_remove_shift_video_image(image) {
    image.css({
        'transform' : 'translateX(0) scale(1)',
        '-webkit-transform' : 'translateX(0) scale(1)',
        '-moz-transform' : 'translateX(-0) scale(1)'
    });
}