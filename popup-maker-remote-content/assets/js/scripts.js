/**
 * Popup Maker: Remote Content v1.0.0
 */
(function ($) {
    "use strict";

    if ($.expr[':'].external === undefined) {
        $.expr[':'].external = function (obj) {
            return obj && obj.href && !obj.href.match(/^mailto:/)
                && (obj.hostname != document.location.hostname);
        };
    }

    if ($.expr[':'].internal === undefined && $.expr[':'].external !== undefined) {
        $.expr[':'].internal = function (obj) {
            return $(obj).is(':not(:external)');
        };
    }

    $.fn.popmake.rc_user_args = {};

    $('.popmake.remote-content')
        .on('popmakeInit', function () {
            var $this = $(this),
                settings = $this.data('popmake'),
                remote_content = settings.meta.remote_content,
                $content = $('.popmake-content', $this),
                calcs = {};

            $.fn.popmake.rc_user_args[settings.id] = {};

            calcs.top = (parseInt($('.popmake-title', $this).css('line-height')) + parseInt($this.css('padding-top'))) + 'px';
            calcs.maxHeight = 'calc(100% - ' + (parseInt(calcs.top) + parseInt($this.css('padding-bottom'))) + 'px)';
            calcs.maxWidth = 'calc(100% - ' + (parseInt($this.css('padding-left')) + parseInt($this.css('padding-right'))) + 'px)';

            $content
                .addClass('popmake-remote-content')
                .css({
                    left: $this.css('padding-left'),
                    top: calcs.top,
                    maxWidth: calcs.maxWidth,
                    maxHeight: calcs.maxHeight
                });

            if (remote_content.type === 'iframe' && !$('#popmake-remote-content-iframe', $content).length) {
                $content.append('<iframe src="" id="popmake-remote-content-iframe">');
            }

        })
        .on('popmakeBeforeOpen', function () {
            var $this = $(this),
                settings = $this.data('popmake'),
                remote_content = settings.meta.remote_content,
                $content = $('.popmake-remote-content', $this),
                $loading_icon = $('.popmake-loader', $content);

            if (!$loading_icon.length) {
                $loading_icon = $('<div class="popmake-loader">').appendTo($this);
            }

            $loading_icon.addClass(remote_content.loading_icon).fadeIn(0);

            $content.fadeOut(0);
        })
        .on('popmakeAfterOpen', function () {
            var $this = $(this),
                settings = $this.data('popmake'),
                remote_content = settings.meta.remote_content,
                $content = $('.popmake-remote-content', $this),
                trigger = $($.fn.popmake.last_open_trigger),
                $iframe = $('#popmake-remote-content-iframe', $content),
                $loading_icon = $('.popmake-loader', $this),
                ajax_data = {};

            switch (remote_content.type) {
                case 'loadselector':
                    if (trigger.attr('href') !== '') {
                        $content
                            .load(trigger.attr('href') + ' ' + remote_content.css_selector, function (response, status) {
                                $loading_icon.fadeOut('slow');
                                $content.fadeIn('slow');
                            });
                    }
                    break;
                case 'iframe':
                    if (trigger.attr('href') !== '') {
                        $iframe
                            .off('load.popmake_rc')
                            .on('load.popmake_rc', function () {
                                $content.fadeIn('slow');
                                $loading_icon.fadeOut('slow');
                            })
                            .prop('src', trigger.attr('href'));
                    }
                    break;
                case 'ajax':
                    $this.trigger('popmakeRcBeforeAjax');
                    ajax_data = $.extend({}, {
                        action: 'popmake_rc',
                        popup_id: settings.id
                    }, $.fn.popmake.rc_user_args[settings.id]);
                    $.ajax({
                        method: "POST",
                        dataType: 'json',
                        url: ajaxurl,
                        data: ajax_data
                    })
                        .done(function (response) {
                            $content
                                .html(response.content)
                                .fadeIn('slow');
                            $loading_icon.fadeOut('slow');
                        });
                    break;
            }
        });
}(jQuery));