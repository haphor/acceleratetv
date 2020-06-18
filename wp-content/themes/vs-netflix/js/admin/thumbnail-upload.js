jQuery(document).ready(function() {
    var frame;
    jQuery('#rvs-remove-thumbnail').click(function() {
        jQuery('#rvs_thumbnail_image').val('');
        jQuery('#rvs-thumbnail-image-container').html('');
        jQuery('#wpvs_thumbnail_image_id').val('');
    });
    jQuery('#rvs-select-thumbnail').click( function( event ){

        event.preventDefault();

        // If the media frame already exists, reopen it.
        if ( frame ) {
          frame.open();
          return;
        }
        
        var target_field = jQuery('#rvs_thumbnail_image');
        var image_url;
        // Create the media frame.
        frame = wp.media({
            title: 'Choose An Image',
            button: {
            text: 'Select',
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });

        // When an image is selected, run a callback.
        frame.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            attachment = frame.state().get('selection').first().toJSON();
            if(typeof attachment.sizes[rvs.thumbnail] != "undefined") {
                image_url = attachment.sizes[rvs.thumbnail].url;
            } else {
                image_url = attachment.url;
            }
            target_field.val(image_url);
            
            if(jQuery('#rvs-set-thumbnail-image').length > 0) {
                jQuery('#rvs-set-thumbnail-image').attr('src', image_url)
            } else {
                var img_html = '<img id="rvs-set-thumbnail-image" src="'+image_url+'" />';
                jQuery('#rvs-thumbnail-image-container').html(img_html);
            }
            jQuery('#wpvs_thumbnail_image_id').val(attachment.id);
        });

        // Finally, open the modal
        frame.open();
    });
});


