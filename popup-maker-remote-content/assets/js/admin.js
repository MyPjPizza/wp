(function ($) {
    "use strict";
    $(document).ready(function () {
        if ($('body.post-type-popup form#post').length) {
            var type_check = function () {
                    var val = $("#popup_remote_content_type").val();
                    $('.remote-content-enabled').filter('.only-ajax,.only-loadselector').hide();
                    if (val === 'ajax') {
                        $('.remote-content-enabled.only-ajax').show();
                    }
                    if (val === 'loadselector') {
                        $('.remote-content-enabled.only-loadselector').show();
                    }
                },
                enable_check = function () {
                    if (!$("#popup_remote_content_enabled").is(':checked')) {
                        $('.remote-content-enabled').hide();
                    } else {
                        $('.remote-content-enabled').show();
                        type_check();
                    }
                };

            $(document)
                .on('click', "#popup_remote_content_enabled", enable_check)
                .on('change', "#popup_remote_content_type", type_check);

            enable_check();
        }
    });
}(jQuery));