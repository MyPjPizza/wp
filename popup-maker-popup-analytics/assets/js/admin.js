(function () {
    "use strict";
    var PopMakePopupAnalyticsAdmin = {
        init: function () {
            if (jQuery('body.post-type-popup form#post').length) {
                PopMakePopupAnalyticsAdmin.initialize_popup_page();
            }
        },
        initialize_popup_page: function () {
            var analytic_open_override = function () {
                    if (jQuery("#popup_analytics_open_event_override").is(':checked')) {
                        jQuery('.analytics-open-overide-only').show();
                    } else {
                        jQuery('.analytics-open-overide-only').hide();
                    }
                },
                analytic_close_override = function () {
                    if (jQuery("#popup_analytics_close_event_override").is(':checked')) {
                        jQuery('.analytics-close-overide-only').show();
                    } else {
                        jQuery('.analytics-close-overide-only').hide();
                    }
                },
                analytic_conversion_override = function () {
                    if (jQuery("#popup_analytics_conversion_event_override").is(':checked')) {
                        jQuery('.analytics-conversion-overide-only').show();
                    } else {
                        jQuery('.analytics-conversion-overide-only').hide();
                    }
                };
            jQuery("#popup_analytics_open_event_override").on('change', function () {
                analytic_open_override();
            });
            jQuery("#popup_analytics_close_event_override").on('change', function () {
                analytic_close_override();
            });
            jQuery("#popup_analytics_conversion_event_override").on('change', function () {
                analytic_conversion_override();
            });
            analytic_open_override();
            analytic_close_override();
            analytic_conversion_override();
        }
    };
    jQuery(document).ready(function () {
        PopMakePopupAnalyticsAdmin.init();
    });

}());