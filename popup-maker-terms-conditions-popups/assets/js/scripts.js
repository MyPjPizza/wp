(function ($) {
    "use strict";
    $('.popmake')
        .on('popmakeInit', function () {
            var $this = $(this),
                settings = $this.data('popmake'),
                click_open = settings.meta.click_open,
                trigger_selector = '.popmake-' + settings.id + ', .popmake-' + settings.slug,
                terms_conditions = settings.meta.terms_conditions,
                noCookieCheck,
                box = $('.popmake-tcp-box', $this),
                input = $('.popmake-tcp-input', $this);

            if (click_open !== undefined && click_open.extra_selectors !== '') {
                trigger_selector += ', ' + click_open.extra_selectors;
            }

            /**
            * Check to see if Terms & Conditions is enabled or do nothing.
            */
            if (terms_conditions !== undefined) {

                /**
                * Function to check for existance of a cookie.
                */
                noCookieCheck = function () {
                    return $.pm_cookie("popmake-terms-conditions-" + settings.id + "-" + terms_conditions.cookie_key) === undefined;
                };

                /**
                * Set up cookie creation event.
                */
                $this.on('popmakeSetCookie.terms-conditions', function () {
                    if (terms_conditions.cookie_time !== '' && noCookieCheck()) {
                        $.pm_cookie(
                            "popmake-terms-conditions-" + settings.id + "-" + terms_conditions.cookie_key,
                            true,
                            terms_conditions.cookie_time,
                            terms_conditions.cookie_path
                        );
                    }
                });


                /**
                * If Popup Maker v1.3+ then prevent opening if cookie is already set.
                */
                if ($.fn.popmake.version >= 1.3) {

                    $(document).ready(function () {
                        if (!noCookieCheck()) {
                            $(document).off('click.popmakeOpen', trigger_selector);
                        }
                        $this.on('popmakeBeforeOpen', function () {
                            if (!noCookieCheck()) {
                                $this.addClass('preventOpen');
                            }
                        });
                    });

                }

                /**
                * If force agree is enabled, check for a cookie and trigger the popup to open immediately.
                */
                if (terms_conditions.force_agree && noCookieCheck()) {
                    $.fn.popmake.last_open_trigger = 'Force Terms & Conditions Popup ID-' + settings.id;
                    $this
                        .on('popmakeSetupClose', function () {
                            var $close = $('> .' + settings.close.attr.class, $this);
                            $close.hide().off('click.popmake');
                        })
                        .popmake('open');
                }

                /**
                * Set up checkbox and events.
                */
                input
                    .addClass('enabled')
                    .prop('checked', false)
                    .on('change', function () {
                        /**
                        * If checked set a cookie and close the popup.
                        */
                        if (input.is(':checked')) {
                            input.addClass('checked');
                            $this.trigger('popmakeSetCookie');
                            $this.fadeOut('slow', function () {
                                /**
                                * If Popup Maker v1.3+ then remove click open event for selected triggers.
                                */
                                $(document).off('click.popmakeOpen', trigger_selector);
                                $this
                                    .on('popmakeAfterClose', function () {
                                        /**
                                        * If Popup Maker v1.3+ then trigger new click event on originally clicked element.
                                        */
                                        if ($.fn.popmake.version >= 1.3) {
                                            $.fn.popmake.last_open_trigger.click();
                                        }
                                    })
                                    .popmake('close');
                            });
                        }
                    });

                /**
                * If force read is enabled, disable the checkbox until the user has scrolled to the end of the terms & conditions.
                */
                if (terms_conditions.force_read) {
                    input.prop('disabled', true).parents('.popmake-tcp-agree').removeClass('enabled').addClass('disabled');
                    box.on('scroll.read-check', function () {
                        if (box[0].scrollHeight - box.scrollTop() === box.innerHeight()) {
                            input.prop('disabled', false).parents('.popmake-tcp-agree').removeClass('disabled').addClass('enabled');
                            box.off('scroll.read-check');
                        }
                    });
                }

            }
        });

}(jQuery));
