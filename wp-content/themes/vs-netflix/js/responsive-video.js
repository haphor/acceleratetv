jQuery(document).ready( function() {
    jQuery('.page-container iframe[src*="youtube.com"], .vs-container iframe[src*="youtube.com"], #main-home iframe[src*="youtube.com"], .page-container iframe[src*="vimeo.com"], .vs-container iframe[src*="vimeo.com"], #main-home iframe[src*="vimeo.com"]').each( function() {
        var this_video_element = jQuery(this);
        if( this_video_element.parent('.wp-block-embed__wrapper').length < 1) {
            this_video_element.wrap('<div class="videoWrapper"></div>');
        }
    });
    
    jQuery('.page-container object, .vs-container object, #main-home object, .page-container video, .vs-container video, #main-home video, .page-container embed, .vs-container embed, #main-home embed').each( function() {
        var this_video_element = jQuery(this);
        if( this_video_element.parent('.wp-block-embed__wrapper').length < 1) {
            this_video_element.wrap('<div class="videoWrapper"></div>');
        }
    });
});