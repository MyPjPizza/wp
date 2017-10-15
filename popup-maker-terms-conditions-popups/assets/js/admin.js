(function ($) {
    "use strict";
    $(document).ready(function () {
        if ($('body.post-type-popup form#post').length) {
            var enable_check = function () {
                    if (!$("#popup_terms_conditions_enabled").is(':checked')) {
                        $('.terms-conditions-enabled').hide();
                    } else {
                        $('.terms-conditions-enabled').show();
                    }
                },
                reset_cookie_key = function () {
                    $('#popup_terms_conditions_cookie_key').val((new Date().getTime()).toString(16));
                };

            $(document)
                .on('click', "#popup_terms_conditions_enabled", function () { enable_check(); })
                .on('click', ".popmake-reset-terms-conditions-cookie-key", function () { reset_cookie_key(); });

            enable_check();
            if ($('#popup_terms_conditions_cookie_key').val() === '') {
                reset_cookie_key();
            }
        }
    });
}(jQuery));