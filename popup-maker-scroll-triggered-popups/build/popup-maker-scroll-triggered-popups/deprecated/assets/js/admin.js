(function ($) {
    "use strict";
    $(document).ready(function () {
        if ($('body.post-type-popup form#post').length) {
            var trigger_check = function () {
                    $('.scroll-triggered-enabled.distance-only').hide();
                    $('.scroll-triggered-enabled.element-only').hide();

                    switch ($("#popup_scroll_triggered_trigger").val()) {
                    case 'distance':
                        $('.scroll-triggered-enabled.distance-only').show();
                        break;
                    case 'element':
                        $('.scroll-triggered-enabled.element-only').show();
                        break;
                    }
                },
                enable_check = function () {
                    if (!$("#popup_scroll_triggered_enabled").is(':checked')) {
                        $('.scroll-triggered-enabled').hide();
                    } else {
                        $('.scroll-triggered-enabled').show();
                        trigger_check();
                    }
                },
                reset_cookie_key = function () {
                    $('#popup_scroll_triggered_cookie_key').val((new Date().getTime()).toString(16));
                };

            $(document)
                .on('click', "#popup_scroll_triggered_enabled", function () { enable_check(); })
                .on('change', "#popup_scroll_triggered_trigger", function () { trigger_check(); })
                .on('click', ".popmake-reset-scroll-triggered-cookie-key", function () { reset_cookie_key(); });

            enable_check();
            if ($('#popup_scroll_triggered_cookie_key').val() === '') {
                reset_cookie_key();
            }
        }
    });
}(jQuery));