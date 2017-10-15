(function () {
    "use strict";
    jQuery('.popmake').each(function () {
        jQuery(this)
            .on('popmakeSetupClose', function () {
                var $this = jQuery(this),
                    settings = $this.data('popmake'),
                    $close = jQuery('> .' + settings.close.attr.class, $this);

                if (settings.meta.close.disabled) {
                    $close.hide().off('click.popmake');
                }
            });
    });
}());