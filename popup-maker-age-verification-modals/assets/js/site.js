(function ($, document, undefined) {
    "use strict";

    $.extend($.fn.popmake.cookies, {
        age_verified: function (settings) {
            var $popup = PUM.getPopup(this);
            $popup.find('.pum-age-form')
                .on('verification.success', function () {
                    $popup.popmake('setCookie', settings);
                });
        },
        age_verification_failed: function (settings) {
            var $popup = PUM.getPopup(this);
            $popup.find('.pum-age-form')
                .on('verification.failed', function () {
                    $popup.popmake('setCookie', settings);
                });
        },
        age_verification_lockout: function (settings) {
            var $popup = PUM.getPopup(this);
            $popup.find('.pum-age-form')
                .on('verification.lockout', function () {
                    $popup.popmake('setCookie', settings);
                });
        }
    });

}(jQuery, document));
(function ($, document, undefined) {
    "use strict";

    $.extend($.fn.popmake.triggers, {
        age_verification: function (settings) {
            var $popup = PUM.getPopup(this);

            // If the popup is already open return.
            if ($popup.hasClass('pum-open') || $popup.popmake('getContainer').hasClass('active')) {
                return;
            }

            // If cookie exists return.
            if ($popup.popmake('checkCookies', settings)) {
                return;
            }

            // Set the global last open trigger to the a text description of the trigger.
            $.fn.popmake.last_open_trigger = 'Age Verification';

            // Open the popup.
            $popup
                .on('pumBeforeOpen.age_verification', function () {
                    $popup.find('> .pum-close')
                        .hide()
                        .off('click.popmake click.pum');
                })
                .popmake('open', function () {
                    $popup.off('pumBeforeOpen.age_verification');
                });
        },
        failed_age_redirect: function (settings) {
            var $popup = PUM.getPopup(this),
                url = settings.redirect_url || '';

            // Sanity check for a valid url protocol.
            if (url !== '' && url.indexOf('http://') === -1) {
                url = "http://" + url;
            }

            // If cookie exists then user failed too many times and will be redirected.
            if ($popup.popmake('checkCookies', settings) && '' !== url) {
                window.location = url;
            }
        }
    });

}(jQuery, document));
(function ($, document, undefined) {
    "use strict";

    var I10n = pum_avm.I10n || {
            'trigger_labels': {
                'enter': 'Enter',
                'exit': 'Exit',
                'birthdate': 'Age Entered'
            },
            'errors': {
                'too_young': 'Sorry but you do not appear to be old enough.',
                'locked_out': 'Sorry but you have been locked out Please come back when you are old enough.',
                'invalid_date': 'Please enter a valid date.'
            }
        };

    function browserSupportsDateInput() {
        var input = document.createElement('input'),
            notADateValue = 'not-a-date';
        
        input.setAttribute('type','date');
        input.setAttribute('value', notADateValue);

        return (input.value !== notADateValue);
    }
    
    $(document)
        .on('click', '.pum-age-form[data-type="enterexit"] button', function (e) {
            var $button = $(this),
                $form = $button.parents('.pum-age-form'),
                $popup = PUM.getPopup($button),
                exit_url = $form.data('exiturl') || 'http://www.disney.com';

            e.preventDefault();

            if ($button.attr('name') === 'enter') {
                $form.trigger('verification.success');
                $.fn.popmake.last_close_trigger = I10n.trigger_labels.enter;
                $popup.popmake('close');
            }

            if (exit_url !== '' && exit_url.indexOf('http://') === -1) {
                exit_url = "http://" + exit_url;
            }

            if ($button.attr('name') === 'exit') {
                $form.trigger('verification.failed');
                $.fn.popmake.last_close_trigger = I10n.trigger_labels.exit;

                // TODO May need to unhook the window.unload functions in PUM Analytics.
                window.location = exit_url;
            }
        })
        // Placeholder for integration with AJAX Login Modals & Terms & Conditions.
        .on('submit', 'form.pum-form', function (e) {
            var $form = $(this),
                $ageForm = $form.find('.pum-age-form[data-type="birthdate"]');

            if ($ageForm.length) {
                //console.log($ageForm.serializeObject());
            }

        })
        .on('click', '.pum-age-form[data-type="birthdate"] button', function (e) {
            var $button = $(this),
                $form = $button.parents('.pum-age-form'),
                $popup = PUM.getPopup($button),
                $error = $form.find('p.pum-form-error'),
                required_age = $form.data('requiredage') || 21,
                age = new Date(),
                valid_age = new Date(),
                lockout = $form.data('lockout') || false,
                lockout_count = $form.data('lockoutcount') || 0,
                exit_url = $form.data('exiturl') || '',
                birthdate = $form.find('[name="birthdate"]').val(),
                month = $form.find('[name="birth_month"]').val(),
                day = $form.find('[name="birth_day"]').val(),
                year = $form.find('[name="birth_year"]').val();

            e.preventDefault();

            if (!$error.length) {
                $error = $('<p class="pum-form-error">').appendTo($form);
            }

            $error.hide();

            if (exit_url !== '' && exit_url.indexOf('http://') === -1) {
                exit_url = "http://" + exit_url;
            }

            // Get a valid timestamp for the required age.
            valid_age.setTime($.fn.popmake.utilities.strtotime('-' + required_age + ' years') * 1000);

            // Get the entered age.
            if (browserSupportsDateInput() && $form.hasClass('date-input-enabled')) {
                if (birthdate === '') {
                    $error.text(I10n.errors.invalid_date).show();
                    return;
                }
                age.setTime($.fn.popmake.utilities.strtotime(birthdate) * 1000);
            } else {
                if (year === '' || month === '' || day === '') {
                    $error.text(I10n.errors.invalid_date).show();
                    return;
                }
                age.setTime($.fn.popmake.utilities.strtotime(month+'-'+day+'-'+year) * 1000);
            }

            // If the age is older than required.
            if (age <= valid_age) {
                $form.trigger('verification.success');
                $.fn.popmake.last_close_trigger = I10n.trigger_labels.birthdate;
                $popup.popmake('close');
            } else {

                $form.trigger('verification.failed');

                lockout_count += 1;

                if (lockout) {

                    if (lockout_count < lockout) {
                        $form.data('lockoutcount', lockout_count);
                    } else {
                        $form.trigger('verification.lockout');

                        $form.find('button').prop('disabled', true);

                        $error.text(I10n.errors.locked_out).show();

                        if (exit_url !== '') {
                            window.location = exit_url;
                        }

                        return;
                    }
                } else {
                    if (exit_url !== '') {
                        window.location = exit_url;
                    }
                }

                $error.text(I10n.errors.too_young).show();

            }
        })
        .ready(function () {
            // If browser supports the input[type="date"] field then display them otherwise use 3 field fallback.
            if (browserSupportsDateInput()) {
                $('.pum-age-form[data-type="birthdate"]').each(function () {
                    var $this = $(this);

                    if ($this.find('input[type="date"]').length) {
                        $this.addClass('date-input-enabled').find(':input:hidden').prop('disabled', true);
                    }
                });
            }
        });

    $('.pum').on('pumAfterOpen', function () {
        var $this = $(this),
            $form = $this.find('.pum-age-form[data-type="birthdate"]');
        if ($form.length) {
            $form.find(':input:visible:first').focus();
        }
    });

}(jQuery, document));