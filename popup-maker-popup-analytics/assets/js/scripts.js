/**
 * Popup Maker Popup Analytics v1.1
 */
(function ($, document, undefined) {
    "use strict";
    $.fn.popmake.conversion_trigger = null;
    function trackForms(popup) {
        var $this = $(popup),
            settings = $this.data('popmake'),
            $form = $('form', $this);

        if ($form.length && !$('[name="popmake_pa_conversion_check"]', $form).length) {
            if ($form.find('.gform_body').length || $form.hasClass('ninja-forms-form') || $form.hasClass('wpcf7-form')) {
                $form.addClass('popmake_pa');
                $form.append('<input type="hidden" name="_popmake_pa_conversion_check" value="' + settings.id + '"/>');
                $form.append('<input type="hidden" name="_popmake_pa_open_event_id" value=""/>');
                $form.bindFirst('submit', function () {
                    $('[name="_popmake_pa_open_event_id"]', $form).val($this.data('open-event-id'));
                    $.fn.popmake.conversion_trigger = $form.attr('id') || $.fn.popmake.utilities.getXPath($form);
                });
            }
        }
    }

    function trackConversion() {
        $(document).trigger('popmakeConversion');
    }

    if ($.fn.bindFirst === undefined) {
        $.fn.bindFirst = function (which, handler) {
            var $el = $(this),
                events,
                registered;

            $el.unbind(which, handler);
            $el.bind(which, handler);

            events = $._data($el[0]).events;
            registered = events[which];
            registered.unshift(registered.pop());

            events[which] = registered;
        };
    }

    if ($.fn.outerHtml === undefined) {
        $.fn.outerHtml = function () {
            var $el = $(this).clone(),
                $temp = $('<div/>').append($el);

            return $temp.html();
        };
    }

    $(document)
        .on('popmakeConversion', function () {
            var $this = $.fn.popmake.last_open_popup,
                ajaxData = {
                    'action' : 'popmake_pa', // Calls our wp_ajax_nopriv_popmake_pa
                    'popup_id' : $this.data('popmake').id,
                    'event_type' : 'conversion',
                    'open_event_id' : $this.data('open-event-id'),
                    'trigger' : $.fn.popmake.conversion_trigger,
                    '_ajax_nonce' : popmake_pa_nonce
                };

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                async: false,
                data: ajaxData
            });
        });

    $('.popmake')
        .on('popmakeInit', function () {
            var $this = $(this),
                settings = $this.data('popmake'),
                convert_on = settings.meta.convert_on;

            trackForms(this);

            if (convert_on !== undefined && convert_on !== '') {
                switch (convert_on) {
                case 'form_submit':
                    $this.find('form').filter(':not(.popmake_pa)').on('submit.popmake_pa', function () {
                        $.fn.popmake.conversion_trigger = $(this).attr('id') || 'Form Submit';
                        trackConversion();
                        $(this).off('submit.popmake_pa');
                    });
                    break;
                case 'button_click':
                    $this.find('button, .button, .btn').on('click', function () {
                        console.log($(this));
                        $.fn.popmake.conversion_trigger = $(this).attr('id') || 'Button Click';
                        trackConversion();
                    });
                    break;
                case 'link_click':
                    $this.find('a').on('click', function () {
                        $.fn.popmake.conversion_trigger = $(this).attr('id') || 'Link Click';
                        trackConversion();
                    });
                    break;
                }
            }

        })
        .on('popmakeBeforeOpen.analytics', function () {
            var $this = $(this),
                ajaxData = {
                    'action' : 'popmake_pa', // Calls our wp_ajax_nopriv_popmake_pa
                    'popup_id' : $this.data('popmake').id,
                    'event_type' : 'open',
                    'trigger' : null,
                    '_ajax_nonce' : popmake_pa_nonce
                },
                $last_trigger = null;

            try {
                $last_trigger = $($.fn.popmake.last_open_trigger);
            } catch (error) {
                $last_trigger = $();
            }

            if ($last_trigger.length) {
                ajaxData.trigger = $last_trigger.eq(0).outerHtml();
            } else if ($.fn.popmake.last_open_trigger !== null) {
                ajaxData.trigger = $.fn.popmake.last_open_trigger.toString();
            }

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: ajaxData,
                success: function (data) {
                    if (data.success && data.event_id > 0) {
                        $this.data('open-event-id', data.event_id);
                    } else {
                        $this.data('open-event-id', null);
                    }
                }
            });

            //  TODO experiment with $(window).on('beforeunload' over $window.on('unload'
            $(window).one('unload.popmake_pa', function () {
                ajaxData = {
                    'action' : 'popmake_pa', // Calls our wp_ajax_nopriv_popmake_pa
                    'popup_id' : $this.data('popmake').id,
                    'event_type' : 'close',
                    'open_event_id' : $this.data('open-event-id'),
                    'trigger' : 'Browser Closed',
                    '_ajax_nonce' : popmake_pa_nonce
                };

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    async: false,
                    data: ajaxData
                });
            });

        })
        .on('popmakeBeforeClose.analytics', function () {
            var $this = $(this),
                ajaxData = {
                    'action' : 'popmake_pa', // Calls our wp_ajax_nopriv_popmake_pa
                    'popup_id' : $this.data('popmake').id,
                    'event_type' : 'close',
                    'open_event_id' : $this.data('open-event-id'),
                    'trigger' : $.fn.popmake.last_close_trigger,
                    '_ajax_nonce' : popmake_pa_nonce
                };

            $(window).off('unload.popmake_pa');

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: ajaxData
            });
        });
}(jQuery, document));