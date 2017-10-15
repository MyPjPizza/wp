(function () {
    "use strict";
    var PopMakeAgeVerificationModalsAdmin = {
        init: function () {
            if (jQuery('body.post-type-popup form#post').length) {
                PopMakeAgeVerificationModalsAdmin.initialize_ageverification_page();
            }
        },
        initialize_ageverification_page: function () {
            var type_check = function () {
                    if (jQuery("#popup_age_verification_type").val() === 'birthdate') {
                        jQuery('.ageverification-enabled.birthdate-only').show();
                    } else {
                        jQuery('.ageverification-enabled.birthdate-only').hide();
                    }
                },
                enable_check = function () {
                    if (!jQuery("#popup_age_verification_enabled").is(':checked')) {
                        jQuery('.ageverification-enabled').hide();
                    } else {
                        jQuery('.ageverification-enabled').show();
                        type_check();
                    }
                };

            jQuery(document)
                .on('click', "#popup_age_verification_enabled", function () {
                    enable_check();
                })
                .on('change', "#popup_age_verification_type", function () {
                    type_check();
                });

            enable_check();
        }
    };
    jQuery(document).ready(function () {
        PopMakeAgeVerificationModalsAdmin.init();
    });
}());