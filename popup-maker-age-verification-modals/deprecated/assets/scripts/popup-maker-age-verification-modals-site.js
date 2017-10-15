(function () {
    "use strict";
    jQuery('.popmake').each(function () {
        jQuery(this)
            .on('popmakeInit', function () {
                var $this = jQuery(this),
                    settings = $this.data('popmake'),
                    age_verification = settings.meta.age_verification,
                    cookie,
                    setCookie,
                    $age_month,
                    $age_day,
                    $age_year,
                    valid_age_date;

                if (age_verification !== undefined) {
                    $this.on('popmakeSetupClose', function () {
                        var $close = jQuery('> .' + settings.close.attr.class, $this);
                        $close.hide().off('click.popmake');
                    });
                    jQuery.cookie_json = true;
                    // Age Verification Modals Popup
                    cookie = jQuery.cookie("popmake-ageverification-" + settings.id);

                    setCookie = function () {
                        if (age_verification.cookie_time !== '') {
                            var cookieDate = new Date();
                            cookieDate.setTime(jQuery.fn.popmake.utilities.strtotime("+" + age_verification.cookie_time) * 1000);
                            jQuery.cookie("popmake-ageverification-" + settings.id, {opened: true, expires: cookieDate}, {
                                expires: cookieDate,
                                path: age_verification.cookie_path
                            });
                        }
                    };
                    if (cookie === undefined) {
                        if (age_verification.exiturl !== '' && age_verification.exiturl.indexOf('http://') === -1) {
                            age_verification.exiturl = "http://" + age_verification.exiturl;
                        }


                        jQuery.fn.popmake.last_open_trigger = 'Age Verification Modals ID - ' + settings.id;
                        $this.popmake('open');

                        switch (age_verification.type) {
                        case "enterexit":
                            jQuery('.age-enter', $this).click(function () {
                                setCookie();

                                jQuery.fn.popmake.last_close_trigger = 'Enter Clicked';
                                $this.popmake('close');
                            });
                            jQuery('.age-exit', $this).click(function () {
                                window.location = age_verification.exiturl !== '' ? age_verification.exiturl : "http://www.disney.com";
                            });
                            break;
                        case "birthdate":
                            $age_month = jQuery('.age-verify-month', $this);
                            $age_day = jQuery('.age-verify-day', $this);
                            $age_year = jQuery('.age-verify-year', $this);

                            valid_age_date = new Date();
                            valid_age_date.setTime(jQuery.fn.popmake.utilities.strtotime('-' + age_verification.required_age + ' years') * 1000);

                            jQuery('.age-verify button', $this).click(function () {
                                var entered_age_date = new Date(),
                                    error;
                                entered_age_date.setTime(jQuery.fn.popmake.utilities.strtotime($age_month.val() + '-' + $age_day.val() + '-' + $age_year.val()) * 1000);
                                if (valid_age_date >= entered_age_date) {
                                    setCookie();
                                    jQuery.fn.popmake.last_close_trigger = 'Age Entered';
                                    $this.popmake('close');
                                } else {
                                    if (age_verification.exiturl !== '') {
                                        window.location = age_verification.exiturl;
                                    } else {
                                        error = jQuery('p.age-error', $this);
                                        if (!error.length) {
                                            error = jQuery('<p class="age-error">').appendTo(jQuery('.popmake-content', $this));
                                        }
                                        error
                                            .text('Sorry but you do not appear to be old enough')
                                            .attr('style', jQuery('.popmake-content', $this).attr('style'))
                                            .css({textAlign: 'center'});
                                    }
                                }
                            });
                            break;
                        }
                    }
                }
            });
    });
}());