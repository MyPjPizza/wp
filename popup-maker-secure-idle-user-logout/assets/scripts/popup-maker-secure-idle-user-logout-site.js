/**
 * Popup Maker Secure Idle User Logout v1.0
 */
(function () {
    "use strict";
    jQuery('.popmake').each(function () {
        jQuery(this)
            .on('popmakeInit', function () {
                var $this = jQuery(this),
                    settings = $this.data('popmake'),
                    secure_logout = settings.meta.secure_logout,
                    idle_time = 0,
                    warning_timer,
                    idle_timer,
                    countdown = $this.find('.popmake-logout-timer'),
                    time_left;

                function forceLogout() {
                    clearInterval(warning_timer);
                    jQuery.get(
                        ajaxurl,
                        {
                            action: 'popmake_siul_logout'
                        },
                        function (data) {
                            location.reload();
                        },
                        'text'
                    );
                }
                function triggerWarning() {
                    countdown.text(secure_logout.warning_timer);
                    clearInterval(idle_timer);
                    clearInterval(warning_timer);
                    warning_timer = setInterval(function () {
                        time_left = (parseInt(countdown.text(), 10) || 0) - 1;
                        if (time_left <= 0) {
                            forceLogout();
                        }
                        countdown.text(time_left);
                    }, 1000);

                    jQuery.fn.popmake.last_open_trigger = 'Secure Idle User Logout ID - ' + settings.id;
                    $this.popmake('open');
                }
                function timerIncrement() {
                    idle_time += 1;
                    if (idle_time >= secure_logout.force_logout_after) {
                        triggerWarning();
                    }
                }
                function startIdleTimer() {
                    clearInterval(idle_timer);
                    idle_timer = setInterval(timerIncrement, 60000); // 1 minute
                }
                function clearWarning() {
                    clearInterval(warning_timer);
                    idle_time = 0;
                    startIdleTimer();
                }

                if (secure_logout !== undefined) {

                    startIdleTimer();
                    jQuery(document).on('keypress mousemove', function () {
                        if (!$this.hasClass('active')) {
                            clearWarning();
                        }
                    });
                    $this.on('popmakeAfterClose', function () {
                        clearWarning();
                    });

                }
            });
    });
}());