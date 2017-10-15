/**
 * Process Feed
 */
var GFUtility_Process_Feed = {

    init: function () {

        var obj = this;

        obj.add_bulk_action_to_list();

        obj.add_modal();

        obj.handle_bulk_action();
    },

    add_bulk_action_to_list: function () {

        var obj = this;

        jQuery('#bulk_action, #bulk_action2, #bulk-action-selector-top, #bulk-action-selector-bottom').find('option[value=resend_notifications]').after(obj.process_feed_bulk_actions);
    },

    add_modal: function () {

        jQuery('#notifications_modal_container').after(process_feeds.modal_html);

    },

    handle_bulk_action: function () {

        jQuery('#doaction, #doaction2').click(function () {

            var action = jQuery(this).siblings('select').val();

            if (action == -1) {

                return;

            }

            var defaultModalOptions = '';
        
            var entryIds = getLeadIds();

            if (entryIds.length != 0 && 'process_feeds' == action) {

                resetProcessFeedsUI();

                tb_show(process_feeds.modal_caption, '#TB_inline?width=350&amp;inlineId=feeds_modal_container', '');

                return false;
            }

        });

    },

    process_feed_bulk_actions: function () {

        var html = '';

        jQuery(process_feeds.bulk_actions).each(function (key) {

            html += '<option value="' + process_feeds.bulk_actions[key].value + '">' + process_feeds.bulk_actions[key].label + '</option>';

        });

        return html;

    }

};

function BulkProcessFeeds() {

    var selectedFeeds = new Array();

    jQuery('.gform_feeds:checked').each(function () {

        selectedFeeds.push(jQuery(this).val());

    });

    var leadIds = getLeadIds();

    if (selectedFeeds.length <= 0) {

        displayMessage(process_feeds.no_feeds_selected, 'error', '#feeds_container');

        return;

    }

    jQuery('#feeds_please_wait_container').fadeIn();

    jQuery.post(ajaxurl, {
            action: 'gf_process_feeds',
            gf_process_feeds: process_feeds.nonce,
            feeds: jQuery.toJSON(selectedFeeds),
            leadIds: leadIds,
            formId: process_feeds.form_id
        },
        function (response) {

            jQuery('#feeds_please_wait_container').hide();

            if (true == response.success ) {

                var c = leadIds == 0 ? gformVars.countAllEntries : leadIds.length;

                displayMessage(process_feeds.success_message.replace('%s', c + ' ' + getPlural(c, process_feeds.entry_string, process_feeds.entries_string)), "updated", "#entry_list_form");

                closeModal(true);

            } else {

                displayMessage(response.data, 'error', '#feeds_container');

            }

        }
    );

}

function resetProcessFeedsUI() {

    jQuery('.gform_feeds').attr('checked', false);

    jQuery('#feeds_container').find('.message').hide();

}

(function ($) {

    $(document).ready(function () {

        GFUtility_Process_Feed.init();

    });

}(jQuery) );