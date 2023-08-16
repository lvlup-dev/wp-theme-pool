jQuery(document).ready(function($) {
    function renderMediaUploader(button) {
        var file_frame, image_data;
        if (undefined !== file_frame) {
            file_frame.open();
            return;
        }
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Sélectionnez ou téléchargez une image',
            button: {
                text: 'Sélectionner'
            },
            multiple: false
        });

        file_frame.on('select', function() {
            image_data = file_frame.state().get('selection').first().toJSON();
            $('#category_image').val(image_data.id);
            $('#category_image_wrapper').html('<img src="' + image_data.url + '" style="max-width:100%;" />');
        });

        file_frame.open();
    }

    $(document.body).on('click', '.custom_media_button', function(e) {
        e.preventDefault();
        renderMediaUploader($(this));
    });

    $(document.body).on('click', '.custom_media_remove', function(e) {
        e.preventDefault();
        $('#category_image').val('');
        $('#category_image_wrapper').html('');
    });
});
