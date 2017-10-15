(function ($) {
    "use strict";
    var $window = $(window),
        $document = $(document);

    /**
     * Calculates the total scroll distance in pixels.
     *
     * @returns scroll_distance (int) Total scroll distance in px.
     */
    function get_actual_scroll_distance() {
        return $document.innerHeight() - $window.height();
    }

    /**
     * Calculates the current percentage of the page that has been scrolled.
     *
     * @returns scroll_percentage (float) Returns a value from 0 to 1.
     */
    function get_current_scroll_percentage() {
        return $window.scrollTop() / get_actual_scroll_distance();
    }

    /**
     * Calculates the scroll addage. This is a ratio of current scroll percentage against screen height.
     *
     * This is used so that when the scroll bar is at 0% no addage is returned, when the scroll bar is
     * at 100% the return will be the full height of the screen.
     *
     * @returns scroll_addage (int) Pixels of adjustment needed for accurate scroll positioning.
     */
    function get_current_scroll_addage() {
        return $window.height() * get_current_scroll_percentage();
    }

    /**
     * Calculates & returns the current detector position. If location  is set then
     * the returned value will include an adjustment based on point used.
     *
     * @param point (bool) - Location of the detector.
     * @returns detector_position (int) - Returns the current detector position in px.
     */
    function get_current_detector_position(point) {
        var detector_position = $window.scrollTop();

        if (point !== undefined) {
            switch (point) {
                case 'floating':
                    detector_position += get_current_scroll_addage();
                    break;
                case 'bottom':
                    detector_position += $window.height();
                    break;
            }
        }

        return detector_position;
    }

    $('.popmake.scroll-triggered')
        .on('popmakeInit', function () {
            var $this = $(this),
                eventID = 'scroll.popmake_scroll_triggered-' + settings.id,
                trigger_point = scroll_triggered.trigger_point,
                trigger, scroll_trigger_open, scroll_trigger_close;

            if (scroll_triggered !== undefined) {

                $this
                    .on('popmakeSetCookie.scroll-triggered', function (event) {
                        if (scroll_triggered.cookie_time !== '' && !hasCookie()) {
                            $.pm_cookie(
                                cookieKey,
                                true,
                                scroll_triggered.cookie_time,
                                scroll_triggered.cookie_path
                            );
                        }
                    })
                    .on('popmakeAfterOpen', function () {
                        if (scroll_triggered.cookie_trigger === 'open') {
                            $this.trigger('popmakeSetCookie.scroll-triggered');
                        }
                    })
                    .on('popmakeBeforeClose', function () {
                        if (scroll_triggered.cookie_trigger === 'close') {
                            $this.trigger('popmakeSetCookie.scroll-triggered');
                        }
                    });

                switch (scroll_triggered.trigger) {
                case 'distance':

                    switch (scroll_triggered.unit) {
                    case "px":
                        trigger = scroll_triggered.distance;
                        break;
                    case "%":
                        trigger = (scroll_triggered.distance / 100) * $document.innerHeight();
                        trigger_point = 'floating';
                        break;
                    case "rem":
                        trigger = Number(getComputedStyle(document.body, "").fontSize.match(/(\d*(\.\d*)?)px/)[1]) * scroll_triggered.distance;
                        break;
                    }

                    break;
                case 'manual':
                    if ($("#scroll_pop_trigger-" + settings.id).length) {
                        trigger = $("#scroll_pop_trigger-" + settings.id).offset().top;
                    }
                    break;
                case 'element':
                    if ($(scroll_triggered.trigger_element).length) {
                        trigger = $(scroll_triggered.trigger_element).eq(0).offset().top;
                    }
                    break;
                }

                if (trigger) {

                    if (trigger >= get_actual_scroll_distance() && (!trigger_point || trigger_point === undefined)) {
                        trigger_point = 'bottom';
                    }

                    /**
                     * Assign the scroll open trigger function. This will be called
                     * during scrolling to check if the popup should be triggered.
                     */
                    scroll_trigger_open = function () {
                        // If the popup is already open, or has an active cookie already then return.
                        if (hasCookie() || $this.hasClass('active')) {
                            $window.off(eventID);
                            return;
                        }

                        // If current adjusted scroll position is more than the trigger.
                        if (get_current_detector_position(trigger_point) >= trigger) {

                            // Turn of scroll_trigger_open checking on page scroll.
                            $window.off(eventID);

                            // Assign last_open_trigger global value.
                            $.fn.popmake.last_open_trigger = 'Scroll Pop ID-' + settings.id;

                            // Open the popup.
                            $this.popmake('open', function () {

                                // If close on up is enabled hook the scroll_trigger_close event to the scroll event.
                                if (scroll_triggered.close_on_up) {
                                    $window.on(eventID, scroll_trigger_close);
                                }

                                // Disable analytics tracking events so that they are only counted one time.
                                $this.off('popmakeBeforeOpen.analytics');
                            });
                        }
                    };

                    /**
                     * Assign the scroll close trigger function. This will be called
                     * during scrolling to check if the popup should be closed.
                     */
                    scroll_trigger_close = function () {
                        // If the popup is not open then return.
                        if (!$this.hasClass('active')) {
                            $window.off(eventID);
                            return;
                        }

                        // If current adjusted scroll position is less than the trigger.
                        if (get_current_detector_position(trigger_point) < trigger) {

                            // Turn of scroll_trigger_close checking on page scroll.
                            $window.off(eventID);

                            // Hook the scroll_trigger_open event to the window scroll event.
                            $window.on(eventID, scroll_trigger_open);

                            // Assign last_close_trigger global value.
                            $.fn.popmake.last_close_trigger = 'Scroll Up';

                            // Close the popup.
                            $this.popmake('close');
                            $this.off('popmakeBeforeClose.analytics');
                        }
                    };

                    // Hook the scroll_trigger_open event to the window scroll event.
                    $window.on(eventID, scroll_trigger_open);
                }
            }
        });

}(jQuery));