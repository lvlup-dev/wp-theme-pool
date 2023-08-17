jQuery(document).ready(function ($) {
    function ct_media_upload(button_class) {
        let _custom_media = true,
            _orig_send_attachment = wp.media.editor.send.attachment;

        $('body').on('click', button_class, function (e) {
            let button_id = '#' + $(this).attr('id');
            let send_attachment_bkp = wp.media.editor.send.attachment;
            let button = $(button_id);

            _custom_media = true;

            wp.media.editor.send.attachment = function (props, attachment) {
                if (_custom_media) {
                    $('#category_image').val(attachment.id);
                    $('#category_image_wrapper').html('<img class="custom_media_image" src="' + attachment.url + '" style="margin:0;padding:0;max-height:100px;float:none;" />');
                } else {
                    return _orig_send_attachment.apply(button_id, [props, attachment]);
                }
            };

            wp.media.editor.open(button);
            return false;
        });
    }

    ct_media_upload('.custom_media_button.button');
    $('body').on('click', '.custom_media_remove', function () {
        $('#category_image').val('');
        $('#category_image_wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
        return false;
    });
});
