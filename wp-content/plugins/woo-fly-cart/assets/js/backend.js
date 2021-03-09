'use strict';

(function($) {
  $(document).ready(function() {
    $('.woofc_color_picker').wpColorPicker();

    woofc_icon_show();

    $(document).on('change', '#woofc_count_icon', function() {
      woofc_icon_show();
    });

    // choose background image
    var woofc_file_frame;

    $(document).
        on('click touch', '#woofc_upload_image_button', function(event) {
          event.preventDefault();

          // If the media frame already exists, reopen it.
          if (woofc_file_frame) {
            // Open frame
            woofc_file_frame.open();
            return;
          }

          // Create the media frame.
          woofc_file_frame = wp.media.frames.woofc_file_frame = wp.media({
            title: 'Select a image to upload',
            button: {
              text: 'Use this image',
            },
            multiple: false,	// Set to true to allow multiple files to be selected
          });

          // When an image is selected, run a callback.
          woofc_file_frame.on('select', function() {
            // We set multiple to false so only get one image from the uploader
            var attachment = woofc_file_frame.state().
                get('selection').
                first().
                toJSON();

            // Do something with attachment.id and/or attachment.url here
            if ($('#woofc_image_preview img').length) {
              $('#woofc_image_preview img').attr('src', attachment.url);
            } else {
              $('#woofc_image_preview').
                  html('<img src="' + attachment.url + '"/>');
            }
            $('#woofc_image_attachment_url').val(attachment.id);
          });

          // Finally, open the modal
          woofc_file_frame.open();
        });
  });

  function woofc_icon_show() {
    var woofc_icon = $('#woofc_count_icon').find(':selected').attr('value');

    $('#woofc_count_icon_view').html('<i class="' + woofc_icon + '"></i>');
  }
})(jQuery);