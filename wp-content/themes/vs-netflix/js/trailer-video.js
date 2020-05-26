var wpvs_trailer_code_mirror_editor;
var wpvs_trailer_code_js_mirror_editor;
jQuery(document).ready( function() {
    
    if( jQuery('#custom-trailer-code').parent().find('.CodeMirror').length > 0) {
        wpvs_trailer_code_mirror_editor = jQuery('#custom-trailer-code').parent().find('.CodeMirror')[0].CodeMirror;
    }
    
    if( jQuery('#wpvs-custom-trailer-js-code').parent().find('.CodeMirror').length > 0) {
        wpvs_trailer_code_js_mirror_editor = jQuery('#wpvs-custom-trailer-js-code').parent().find('.CodeMirror')[0].CodeMirror;
    }
    
    jQuery('#select-trailer-type').change( function() {
        var trailer_type = jQuery(this).val();
        jQuery('.rvs-trailer-type-area').removeClass('rvs-display-area');
        if(trailer_type == "vimeo") {
            jQuery('#trailer-vimeo-type-option').addClass('rvs-display-area');
            if(jQuery('#rvs-trailer-vimeo-id').val() !== "") {
                var vimeo_id = jQuery('#rvs-trailer-vimeo-id').val();
                wpvs_set_vimeo_trailer_iframe(vimeo_id);
            }
        }
        
        if(trailer_type == "wordpress") {
            jQuery('#trailer-wordpress-type-option').addClass('rvs-display-area');
        }
        
        if(trailer_type == "youtube") {
            jQuery('#trailer-youtube-type-option').addClass('rvs-display-area');
            var set_trailer_url = jQuery('#trailer-youtube-video-url').val();
            if(set_trailer_url != "") {
                rvs_set_youtube_trailer(set_trailer_url);
            }
        }
        
        if(trailer_type == "custom") {
            jQuery('#trailer-custom-type-option').addClass('rvs-display-area');
            var custom_trailer_code = jQuery('textarea#custom-trailer-code');
            var set_iframe_code = custom_trailer_code.val();
            if(set_iframe_code != "") {
                jQuery('#rvs-trailer-video-holder').html(set_iframe_code);
                jQuery('#new-trailer-html').val(set_iframe_code);
            }
            if(custom_trailer_code.parent().find('.CodeMirror').length <= 0) {
                wp.codeEditor.initialize( "custom-trailer-code", jQuery.parseJSON(wpvstrailerpost.code_mirror_trailer_html) );
                wp.codeEditor.initialize( "wpvs-custom-trailer-js-code", jQuery.parseJSON(wpvstrailerpost.code_mirror_trailer_js) );
                wpvs_trailer_code_mirror_editor = custom_trailer_code.parent().find('.CodeMirror')[0].CodeMirror;
                wpvs_trailer_code_js_mirror_editor = jQuery('#wpvs-custom-trailer-js-code').parent().find('.CodeMirror')[0].CodeMirror;
            }
        }
    });
    
    if(jQuery('#select-trailer-type').val() == 'youtube' && jQuery('#trailer-youtube-video-url').val() != "" && jQuery('#new-trailer-html').val() == "") {
        var youtube_link = jQuery('#trailer-youtube-video-url').val();
        var u_youtube_link = youtube_link.split("&")[0];
        jQuery(this).val(u_youtube_link);
        if(u_youtube_link != "") {
            rvs_set_youtube_trailer(u_youtube_link);
        }
    }
    
    jQuery('input#vimeo-trailer-url').keyup(function() {
        var vimeo_url = jQuery(this).val();
        var vimeo_id = wpvs_get_vimeo_url_id(vimeo_url);
        if(vimeo_id != "error") {
            wpvs_set_vimeo_trailer_iframe(vimeo_id);
        }
    });
    
    jQuery('input#trailer-youtube-video-url').keyup(function() {
        var youtube_link = jQuery(this).val();
        var u_youtube_link = youtube_link.split("&")[0];
        jQuery(this).val(u_youtube_link);
        if(u_youtube_link != "") {
            rvs_set_youtube_trailer(u_youtube_link);
        }
    });
    
    wpvs_create_trailer_code_mirror_events();
    
    setTimeout(function() {
        wpvs_refresh_code_mirror_trailer_editors();
    },500);

});

function wpvs_create_trailer_code_mirror_events() {
    if( typeof(wpvs_trailer_code_mirror_editor) != 'undefined' ) {
        wpvs_trailer_code_mirror_editor.on('change', function() {
            var custom_trailer_html = wpvs_trailer_code_mirror_editor.getValue();
            jQuery('#rvs-trailer-video-holder').html(custom_trailer_html);
            jQuery('#custom-trailer-code').val(custom_trailer_html);
            jQuery('#new-trailer-html').val(custom_trailer_html);
            
        });
    }
    
    if( typeof(wpvs_trailer_code_js_mirror_editor) != 'undefined' ) {
        wpvs_trailer_code_js_mirror_editor.on('change', function() {
            var custom_trailer_js = wpvs_trailer_code_js_mirror_editor.getValue();
            jQuery('#wpvs-custom-trailer-js-code').html(custom_trailer_js);
        });
    }
}


function wpvs_refresh_code_mirror_trailer_editors() {
    if( typeof(wpvs_trailer_code_mirror_editor) != 'undefined' ) {
        wpvs_trailer_code_mirror_editor.refresh();
    }
    if( typeof(wpvs_trailer_code_js_mirror_editor) != 'undefined' ) {
        wpvs_trailer_code_js_mirror_editor.refresh();
    }
}


function wpvs_set_vimeo_trailer_iframe(vimeo_id) {
    var player_settings = jQuery('#rvs-vimeo-player-settings').val();
    var vimeo_iframe = 'https://player.vimeo.com/video/' + vimeo_id + player_settings;
    var set_vimeo_iframe = '<iframe class="wpvs-vimeo-trailer-player" src="' + vimeo_iframe + '" width="1280" height="720" frameborder="0" title="title" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" allow="autoplay"></iframe>';
    jQuery('#rvs-trailer-video-holder').html(set_vimeo_iframe);
    jQuery('#new-trailer-html').val(set_vimeo_iframe);
    jQuery('#rvs-trailer-vimeo-id').val(vimeo_id);
}

function rvs_set_youtube_trailer(youtube_url) {
    var youtube_style = jQuery('#rvs-youtube-string').val();
    var new_youtube = wpvs_get_youtube_id(youtube_url);
    if(new_youtube != "error") {
        new_youtube += youtube_style;
        var youtube_html = '<iframe class="wpvs-youtube-trailer-player" width="560" height="315" src="//www.youtube.com/embed/' 
        + new_youtube + '" frameborder="0" allowfullscreen="" allow="autoplay"></iframe>';
        jQuery('#rvs-trailer-video-holder').html(youtube_html).show();
        jQuery('#new-trailer-html').val(youtube_html).html(youtube_html);
    }
}