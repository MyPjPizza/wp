(function ($, document, undefined) {
    "use strict";

    if ($.fn.popmake.triggers.click_block === undefined) {

        $.fn.popmake.blocked_trigger = null;

        pum.hooks.addAction('pum.triggers.click_block.reclick', function () {
            $.fn.popmake.blocked_trigger.data('reclick', false);
            $.fn.popmake.blocked_trigger.get(0).click();
        });

        $.fn.popmake.triggers.click_block = function (settings) {
            var $popup = PUM.getPopup(this),
                popup_settings = $popup.popmake('getSettings'),
                trigger_selectors = [
                    '.popmake-' + popup_settings.id,
                    '.popmake-' + decodeURIComponent(popup_settings.slug),
                    'a[href$="#popmake-' + popup_settings.id + '"]'
                ],
                trigger_selector;


            if (settings.extra_selectors && settings.extra_selectors !== '') {
                trigger_selectors.push(settings.extra_selectors);
            }

            trigger_selectors = pum.hooks.applyFilters('pum.trigger.click_block.selectors', trigger_selectors, settings);

            trigger_selector = trigger_selectors.join(', ');

            $(trigger_selector)
                .addClass('pum-trigger')
                .css({cursor: "pointer"});

            $(document)
                .off('click.pumTrigger', trigger_selector)
                .on('click.pum.block_action', trigger_selector, function (event) {
                    var $this = $(this),
                        allowed = true;

                    // If trigger is inside of the popup that it opens, do nothing.
                    if ($popup.has($this).length > 0) {
                        return;
                    }

                    if (settings.requirements === undefined) {
                        return;
                    }

                    for (var key in settings.requirements) {
                        if (!pum.hooks.applyFilters('pum.trigger.click_block.allowed.' + key, true, settings, $popup)) {
                            allowed = false;
                        }
                    }

                    if (allowed) {
                        return true;
                    }

                    // If cookie exists or conditions fail return.
                    if (allowed || $popup.popmake('checkCookies', settings) || !$popup.popmake('checkConditions')) {
                        return;
                    }

                    event.stopPropagation();
                    event.preventDefault();

                    // Set the global last open trigger to the clicked element.
                    $.fn.popmake.last_open_trigger = $this;

                    $.fn.popmake.blocked_trigger = $this;

                    // Open the popup.
                    $popup.popmake('open');
                });
        };

        $(document).on('pumAfterClose', '.pum', function () {
            if ($.fn.popmake.blocked_trigger && $.fn.popmake.blocked_trigger.data('reclick')) {
                pum.hooks.doAction('pum.triggers.click_block.reclick');
            }

            $.fn.popmake.blocked_trigger = null;
        });
    }


}(jQuery, document));
(function ($) {
    "use strict";

    $.extend($.fn.popmake.cookies, {
        login_successful: function (settings) {
            var $popup = PUM.getPopup(this);
            $popup.find('.pum-alm-form')
                .on('login.success', function () {
                    $popup.popmake('setCookie', settings);
                });
        },
        registration_successful: function (settings) {
            var $popup = PUM.getPopup(this);
            $popup.find('.pum-alm-form')
                .on('registration.success', function () {
                    $popup.popmake('setCookie', settings);
                });
        }
    });

}(jQuery));
(function ($, document, undefined) {
    "use strict";

    var search = {
            login: 'a[href$="/wp-login.php"]',
            registration: 'a[href$="/wp-login.php?action=register"]',
            recovery: 'a[href$="/wp-login.php?action=lostpassword"]'
        },
        changeTo = function ($popup, which, speed) {
            var login = $popup.find('.pum-login-form-wrapper'),
                registration = $popup.find('.pum-registration-form-wrapper'),
                recovery = $popup.find('.pum-recovery-form-wrapper');

            speed = speed || 'fast';

            switch (which) {
            default:
            case 'login':
                login.slideDown(speed);
                registration.slideUp(speed);
                recovery.slideUp(speed);
                break;
            case 'registration':
                login.slideUp(speed);
                registration.slideDown(speed);
                recovery.slideUp(speed);
                break;
            case 'recovery':
                login.slideUp(speed);
                registration.slideUp(speed);
                recovery.slideDown(speed);
                break;
            }
        },
        switching = function (event) {
            var trigger = $(),
                $popup = PUM.getPopup(this),
                login = $popup.find('.pum-login-form-wrapper'),
                registration = $popup.find('.pum-registration-form-wrapper'),
                recovery = $popup.find('.pum-recovery-form-wrapper'),
                enabled = 0;

            try {
                trigger = $($.fn.popmake.last_open_trigger);
            } catch (Error) {
                console.log('1');
            }

            if (login.length) {
                enabled++;
            }

            if (registration.length) {
                enabled++;
            }

            if (recovery.length) {
                enabled++;
            }


            if (enabled > 1) {
                if (trigger.length && trigger.attr('href')) {
                    // If is registration link.
                    if (trigger.is('a[href$="/wp-login.php?action=register"]') || trigger.hasClass('popswitch-registration') || trigger.find('.popswitch-registration').length) {
                        changeTo($popup, 'registration', 0);
                    } else if (trigger.is('a[href$="/wp-login.php?action=lostpassword"]') || trigger.hasClass('popswitch-recovery') || trigger.find('.popswitch-recovery').length) {
                        changeTo($popup, 'recovery', 0);
                    } else {
                        changeTo($popup, 'login', 0);
                    }
                } else {
                    changeTo($popup, 'login', 0);
                }
            }
        };


    $('.pum').on('pumInit', function (event) {

        var $popup = PUM.getPopup(this),
            login = $popup.find('.pum-login-form-wrapper'),
            registration = $popup.find('.pum-registration-form-wrapper'),
            recovery = $popup.find('.pum-recovery-form-wrapper');

        if ($popup.find('.pum-alm-form').length) {

            if (login.length) {
                $popup.find(search.login).on('click', function (event) {
                    changeTo($popup, 'login', 'slow');
                    event.preventDefault();
                });
            }

            if (registration.length) {
                $popup.find(search.registration).on('click', function (event) {
                    changeTo($popup, 'registration', 'slow');
                    event.preventDefault();
                });
            }

            if (recovery.length) {
                $popup.find(search.recovery).on('click', function (event) {
                    changeTo($popup, 'recovery', 'slow');
                    event.preventDefault();
                });
            }

            $popup.on('pumBeforeOpen', switching);
        }
    });

    /**
     * Add additional chosen selectors to the click trigger array.
     *
     * @param trigger_selectors array
     * @param settings object of cookie settings
     */
    pum.hooks.addFilter('pum.trigger.click_open.selectors', function (trigger_selectors, settings, $popup) {

        var login_links = $.extend({
            login: false,
            registration: false,
            recovery: false
        }, settings.login_links);

        if (login_links.login) {
            trigger_selectors.push(search.login);
        }

        if (login_links.registration) {
            trigger_selectors.push(search.registration);
        }

        if (login_links.recovery) {
            trigger_selectors.push(search.recovery);
        }

        return trigger_selectors;
    });

    pum.hooks.addFilter('pum.trigger.click_block.allowed.login', function (allowed, settings, $popup) {
        return pum_alm_vars.is_logged_in;
    });

    pum.hooks.addAction('pum_alm.form.success', function (data, $form) {
        if (!$.fn.popmake.blocked_trigger) {
            return;
        }

        if (data.user !== undefined && data.user.ID > 0) {
            pum_alm_vars.is_logged_in = true;
        }

        $.fn.popmake.blocked_trigger.data('reclick', true);
    });

    $.extend($.fn.popmake.triggers, {
        force_login: function (settings) {
            var $popup = PUM.getPopup(this);

            // If user is logged in already return.
            if (pum_alm_vars.is_logged_in) {
                return;
            }

            // If the popup is already open return.
            if ($popup.hasClass('pum-open') || $popup.popmake('getContainer').hasClass('active')) {
                return;
            }

            // If cookie exists or conditions fail return.
            if ($popup.popmake('checkCookies', settings) || !$popup.popmake('checkConditions')) {
                return;
            }

            // Set the global last open trigger to the a text description of the trigger.
            $.fn.popmake.last_open_trigger = 'Forced Login';

            $popup.popmake('open');
        }
    });

}(jQuery, document));
var PUM_ALM;
(function ($, document, undefined) {
    "use strict";
    var $document = $(document),
        error_messages = pum_alm_vars.I10n.errors;

    if (typeof $.fn.pumSerializeObject !== 'function') {
        $.fn.pumSerializeObject = function () {
            var o = {},
                a = this.serializeArray();
            $.each(a, function () {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };
    }

    PUM_ALM = {
        validate: function (which, values, $form) {
            this.validation.form = $form;
            this.validation.values = values;
            this.validation.which = which;

            // Reset Errors from prior submissions.
            if (this.validation.errors.length) {
                this.validation.errors = [];
            }

            // Call validation function if it exists.
            if (typeof this.validation[which] === 'function') {
                this.validation[which](values, $form);
            } else {
                this.validation.errors.push(error_messages.invalid_form);
            }

            // Allow 3rd party customization to push additional errors.
            $document.trigger('pum_alm_' + which + '_validation', [this.validation]);
        },
        validation: {
            form: null,
            errors: [],
            login: function (values) {
                if (values.log === undefined || values.log === '') {
                    this.errors.push(error_messages.empty_login);
                }

                if (values.pwd === undefined || values.pwd === '') {
                    this.errors.push(error_messages.empty_password);
                }
            },
            registration: function (values) {
                /**
                 * Username Validation
                 */
                if (values.user_login === undefined || values.user_login === '') {
                    this.errors.push(error_messages.empty_username);
                }

                /**
                 * Email Validation
                 */
                if (values.user_email === undefined || values.user_email === '') {
                    this.errors.push(error_messages.empty_email);
                }

                if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(values.user_email)) {
                    this.errors.push(error_messages.invalid_email);
                }

                if (values.user_email2 !== undefined) {
                    if (values.user_email2 === '') {
                        this.errors.push(error_messages.empty_confirm_email);
                    } else if (values.user_email !== values.user_email2) {
                        this.errors.push(error_messages.mismatch_confirm_email);
                    }
                }

                /**
                 * Password Validation
                 */
                if (values.user_pass === undefined || values.user_pass === '') {
                    this.errors.push(error_messages.empty_password);
                }

                if (values.user_pass2 !== undefined) {
                    if (values.user_pass2 === '') {
                        this.errors.push(error_messages.empty_confirm_password);
                    } else if (values.user_pass !== values.user_pass2) {
                        this.errors.push(error_messages.mismatch_confirm_password);
                    }
                }

                if (values['g-recaptcha-response'] !== undefined) {
                    if (values['g-recaptcha-response'] === '') {
                        this.errors.push(error_messages.must_complete_recaptcha);
                    }
                }
            },
            recovery: function (values) {
                if (values.user_login === undefined || values.user_login === '') {
                    this.errors.push(error_messages.empty_login);
                }
            }
        },
        clear_messages: function ($form, hide) {
            var $messages = $form.find('.messages'),
                messages = $messages.find('.message');

            hide = hide || false;

            if ($messages.length) {
                messages.slideUp('fast', function () {
                    $(this).remove();

                    if (hide) {
                        $messages.hide();
                    }
                });

            }
        },
        add_message: function ($messages, message, type) {
            var $message = $('<p class="message">').html(message);

            type = type || 'success';

            $message.addClass(type);

            $messages.append($message);

            if ($messages.is(':visible')) {
                $message.hide().slideDown();
            }
        },
        add_messages: function ($form, messages, type) {
            var $messages = $form.find('.messages'),
                i = 0;

            if (!$messages.length) {
                $messages = $('<div class="messages">').hide();
                switch (pum_alm_vars.message_position) {
                case 'bottom':
                    $form.append($messages.addClass('bottom'));
                    break;
                case 'top':
                    $form.prepend($messages.addClass('top'));
                    break;
                }
            }

            type = type || 'success';
            messages = messages || [];

            for (; messages.length > i; i++) {
                this.add_message($messages, messages[i], type);
            }

            if ($messages.is(':hidden')) {
                $messages.slideDown();
            }
        },
        handler: function ($form, response) {
            var data = response.data || {},
                which = $form.attr('name') ? $form.attr('name').replace('pum-', '').replace('-form', '') : 'registration',
                $wrapper = $form.parent();

            if (data.form !== undefined) {
                $wrapper.find('form, #wppb_general_top_error_message').replaceWith(data.form);

                $form = $wrapper.find('form').eq(0);

                if ($wrapper.data('form_args')) {
                    $form.append($('<input type="hidden" name="_form_args" />').val($wrapper.data('form_args')));
                }

            }

            if (response.success) {
                if (data.message !== undefined && data.message !== '') {
                    PUM_ALM.add_messages($form, [data.message]);
                }

                $form.trigger(which + '.success', [data]);

                pum.hooks.doAction('pum_alm.' + which + '.success', data, $form);
                pum.hooks.doAction('pum_alm.form.success', data, $form);

                var redirect = function () {
                    if (data.redirect !== undefined && data.redirect) {
                        if (data.redirect !== '') {
                            window.location = data.redirect;
                        } else {
                            window.location.reload(true);
                        }
                    }
                };

                if ($wrapper.data('autoclose')) {
                    setTimeout(function () {
                        PUM.getPopup($wrapper).popmake('close', redirect);
                    }, $wrapper.data('autoclose-delay'));
                } else {
                    redirect();
                }
            } else {

                if (data.errors !== undefined && data.errors.length) {
                    PUM_ALM.display_errors($form, data.errors);
                }

                $form.trigger(which + '.errors');

                pum.hooks.doAction('pum_alm.' + which + '.errors', data, $form);
                pum.hooks.doAction('pum_alm.form.errors', data, $form);
            }
        },
        display_errors: function ($form, errors) {
            var error,
                i = 0;

            console.log(errors);

            errors = errors || this.validation.errors;

            PUM_ALM.add_messages($form, errors, 'error');

            for (; errors.length > i; i++) {
                error = errors[i];
            }
        },
        add_field_messages: function ($form) {
            // Some per field validation.
            if (results.field !== undefined) {
                var error_field = $('[name="' + results.field + '"]', $form) || null;
                if (error_field.length) {

                    $('html, body').animate({
                        scrollTop: error_field.offset().top - 100
                    }, 1000, function () {
                        error_field.addClass('error').focus();
                        message.insertAfter(error_field);
                    });

                }
            }
        }
    };


    $(document)
        .on('pumInit', '.pum', function () {
            var $popup = PUM.getPopup(this),
                $formWrapper = $popup.find('.pum-alm-form-wrapper');

            $formWrapper.each(function () {
                var $this = $(this),
                    $moveme = $this.find('[data-moveme]'),
                    $form = $this.find('form');

                if ($moveme.length && !$form.has($moveme).length) {
                    $this.data('form_args', $moveme.val());
                    $form.append($moveme);
                }
            });

        })
        .on('submit', '.pum-alm-form-wrapper form', function (event) {
            var $form = $(this),
                $popup = PUM.getPopup($form),
                $btn = $form.find('[type="submit"]'),
                $loading = $btn.find('.loader'),
                // If the form isn't named correctly its likely a registration form.
                which = $form.attr('name') ? $form.attr('name').replace('pum-', '').replace('-form', '') : 'registration',
                values = $form.pumSerializeObject(),
                data = $.extend({}, values, {
                    action: 'pum_alm_form',
                    which: which
                });

            if ($popup.length) {
                data.popup_id = $popup.popmake('getSettings').id;
            }

            event.preventDefault();

            if ($form.hasClass('pum-alm-form')) {
                PUM_ALM.clear_messages($form);

                // Validate form.
                PUM_ALM.validate(which, values, $form);
            } else {
                PUM_ALM.validation.errors = [];

            }

            // Check for validation errors.
            if (!PUM_ALM.validation.errors.length) {

                if (!$loading.length) {
                    $loading = $('<span class="loader"></span>');
                    if ($btn.attr('value') !== '') {
                        $loading.insertAfter($btn);
                    } else {
                        $btn.append($loading);
                    }
                }

                $btn.prop('disabled', true);
                $loading.show();

                $.ajax(
                    {
                        type: 'POST',
                        dataType: 'json',
                        url: ajaxurl,
                        data: data
                    })
                    .always(function () {
                        $btn.prop('disabled', false);
                        $loading.hide();
                    })
                    .done(function (response) {
                        PUM_ALM.handler($form, response);
                    })
                    .error(function (jqXHR, textStatus, errorThrown) {
                        alert(errors.unknown + ' ' + errorThrown);
                    });
            } else {
                PUM_ALM.display_errors($form);
            }
        });

}(jQuery, document));

/**
 $(document)
 .on('pum_alm_registration_validation', function (event, validation) {
        var $form = validation.form,
            values = validation.values;

        if (values.my_field_name === undefined || values.my_field_name == '') {
            validation.errors.push("My Custom Error Message");
        }
    });
 */
