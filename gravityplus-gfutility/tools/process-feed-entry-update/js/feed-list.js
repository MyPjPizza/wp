/**
 * Feed list toggle
 *
 * @since  2.3.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
jQuery(document).ready(function () {

    var entry_update_column_header = '<th scope="col" id="entry_update_process" class="manage-column column-entry_update_process">Process on Entry Update</th>';

    var feed_list_table = jQuery('#gform-settings').find('.wp-list-table');

    feed_list_table.find('thead').find('tr').find('th').filter(':last').after(entry_update_column_header);
    feed_list_table.find('tfoot').find('tr').find('th').filter(':last').after(entry_update_column_header);

    var feed_list = feed_list_table.find('tbody').find('tr');

    var addon_slug = jQuery("input[name='subview']").val();


    jQuery.each(feed_list, function () {

        var feed_id = jQuery(this).find('th.check-column input').val();

        var toggle = '<td></td>';

        jQuery.each(gfp_utility_feed_list.feeds, function () {

            if (this['id'] == feed_id) {

                if ('1' == this['process_on_entry_update']) {

                    toggle = '<img src="' + gfp_utility_feed_list.active_img + '" style="cursor: pointer;" alt="Active" title="Active" onclick="gaddon.toggleFeedEntryUpdateActive(this, \'' + addon_slug + '\', ' + feed_id + ');" onkeypress="gaddon.toggleFeedEntryUpdateActive(this, \'' + addon_slug + '\', ' + feed_id + ');"  />';

                }
                else {

                    toggle = '<img src="' + gfp_utility_feed_list.inactive_img + '" style="cursor: pointer;" alt="Inactive" title="Inactive" onclick="gaddon.toggleFeedEntryUpdateActive(this, \'' + addon_slug + '\', ' + feed_id + ');" onkeypress="gaddon.toggleFeedEntryUpdateActive(this, \'' + addon_slug + '\', ' + feed_id + ');"  />';

                }

            }

        });

        jQuery(this).find('td').filter(':last').after('<td>' + toggle + '</td>');

    });

});

/**
 * Taken from gaddon.toggleFeedActive
 *
 * @since 2.3.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param img
 * @param addon_slug
 * @param feed_id
 * @returns {boolean}
 */
window.gaddon.toggleFeedEntryUpdateActive = function (img, addon_slug, feed_id) {

    var is_active = img.src.indexOf('active1.png') >= 0 ? 0 : 1;

    if (is_active) {

        img.src = img.src.replace('active0.png', 'spinner.gif');

    }
    else {

        img.src = img.src.replace('active1.png', 'spinner.gif');

    }

    jQuery.post(ajaxurl, {
            action: 'gf_feed_entry_update_active',
            feed_id: feed_id,
            is_active: is_active
        },
        function (response) {

            if (true == response.success) {

                if (is_active) {

                    img.src = img.src.replace('spinner.gif', 'active1.png');

                    jQuery(img).attr('title', gf_vars.inactive).attr('alt', gf_vars.inactive);

                }
                else {

                    img.src = img.src.replace('spinner.gif', 'active0.png');

                    jQuery(img).attr('title', gf_vars.active).attr('alt', gf_vars.active);

                }

            }

        }
    );

    return true;
};