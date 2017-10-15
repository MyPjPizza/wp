(function ($, document, window) {
    "use strict";

    /**
     * Calculates the total scroll distance in pixels.
     *
     * @returns number
     */
    function get_actual_scroll_distance() {
        return $(document).innerHeight() - window.innerHeight;
    }

    /**
     * Calculates the current percentage of the page that has been scrolled.
     *
     * Returns a value from 0 to 1
     *
     * @returns number
     */
    function get_current_scroll_percentage() {
        return window.pageYOffset / get_actual_scroll_distance();
    }

    /**
     * Calculates the scroll add-age. This is a ratio of current scroll percentage against screen height.
     *
     * This is used so that when the scroll bar is at 0% no add-age is returned, when the scroll bar is
     * at 100% the return will be the full height of the screen.
     *
     * @returns number Pixels of adjustment needed for accurate scroll positioning.
     */
    function get_current_scroll_addage() {
        return window.innerHeight * get_current_scroll_percentage();
    }

    /**
     * Calculates & returns the current detector position. If location  is set then
     * the returned value will include an adjustment based on point used.
     *
     * @param point (bool) - Location of the detector.
     * @returns number detector_position - Returns the current detector position in px.
     */
    function get_current_detector_position(point) {
        var detector_position = window.pageYOffset;

        if (point !== undefined) {
            switch (point) {
            case 'floating':
                detector_position += get_current_scroll_addage();
                break;
            case 'bottom':
                detector_position += window.innerHeight;
                break;
            }
        }

        return detector_position;
    }

    $.extend($.fn.popmake.triggers, {
        scroll: function (settings) {
            var $popup = PUM.getPopup(this),
                $window = $(window),
                popupID = $popup.popmake('getSettings').id,
                eventID = 'scroll.pum-stp-' + popupID,
                trigger_point, trigger, manual_trigger, element_trigger, scroll_trigger_open, scroll_trigger_close;

            // Merge Defaults.
            settings = $.extend({
                trigger: 'distance',
                trigger_point: '',
                distance: 75,
                unit: '%',
                trigger_element: '',
                close_on_up: null
            }, settings);

            trigger_point = settings.trigger_point;
            manual_trigger = $("#scroll_pop_trigger-" + popupID + ", .pum-stp-trigger-" + popupID);
            element_trigger = $(settings.trigger_element);

            switch (settings.trigger) {
            case 'distance':

                switch (settings.unit) {
                case "px":
                    trigger = settings.distance;
                    break;
                case "%":
                    trigger = (settings.distance / 100) * $(document).innerHeight();
                    trigger_point = 'floating';
                    break;
                case "rem":
                    trigger = Number(getComputedStyle(document.body, "").fontSize.match(/(\d*(\.\d*)?)px/)[1]) * settings.distance;
                    break;
                }

                break;
            case 'manual':
                if (manual_trigger.length) {
                    trigger = manual_trigger.offset().top;
                }
                break;
            case 'element':
                if (element_trigger.length) {
                    trigger = element_trigger.eq(0).offset().top;
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

                    // Just before triggering if the popup is already open return.
                    if ($popup.hasClass('pum-open') || $popup.popmake('getContainer').hasClass('active')) {
                        $window.off(eventID);
                        return;
                    }

                    // If cookies exists return.
                    if ($popup.popmake('checkCookies', settings)) {
                        $window.off(eventID);
                        return;
                    }

                    // If current adjusted scroll position is more than the trigger.
                    if (get_current_detector_position(trigger_point) >= trigger) {

                        // Turn of scroll_trigger_open checking on page scroll.
                        $window.off(eventID);

                        // Assign last_open_trigger global value.
                        $.fn.popmake.last_open_trigger = 'Scroll Pop - Trigger: ' + settings.trigger;

                        // Open the popup.
                        $popup.popmake('open', function () {

                            // If close on up is enabled hook the scroll_trigger_close event to the scroll event.
                            if (settings.close_on_up) {
                                $window.on(eventID, scroll_trigger_close);
                            }

                            // Disable analytics tracking events so that they are only counted one time.
                            $popup.off('popmakeBeforeOpen.analytics');
                        });
                    }
                };

                /**
                 * Assign the scroll close trigger function. This will be called
                 * during scrolling to check if the popup should be closed.
                 */
                scroll_trigger_close = function () {

                    // If the popup is not open then return.
                    if (!$popup.hasClass('pum-open') && !$popup.popmake('getContainer').hasClass('active')) {
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
                        $popup.popmake('close');

                        // Disable analytics tracking events so that they are only counted one time.
                        $popup.off('popmakeBeforeClose.analytics');
                    }
                };

                // Hook the scroll_trigger_open event to the window scroll event.
                $window.on(eventID, scroll_trigger_open);
            }
        }
    });
}(jQuery, document, window));