(function () {
    "use strict";
    var PopMakeSecureIdleUserLogoutAdmin = {
        init: function () {
            if (jQuery('body.post-type-popup form#post').length) {
                PopMakeSecureIdleUserLogoutAdmin.initialize_securelogout_page();
            }
        },
        initialize_securelogout_page: function () {
            var enable_check = function () {
                    if (!jQuery("#popup_secure_logout_enabled").is(':checked')) {
                        jQuery('.securelogout-enabled').hide();
                    } else {
                        jQuery('.securelogout-enabled').show();
                    }
                };

            jQuery(document)
                .on('click', "#popup_secure_logout_enabled", function () {
                    enable_check();
                });

            enable_check();
        }
    };
    jQuery(document).ready(function () {
        PopMakeSecureIdleUserLogoutAdmin.init();
    });
}());