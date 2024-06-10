// Extract table from Airtable with Token
var MyAjax = {
    ajaxurl: MyScriptData.ajaxurl,
    nonce: MyScriptData.nonce
};

function fetchAirtableTables(appId) {

    jQuery.ajax({
        url: MyAjax.ajaxurl,
        type: 'POST',
        data: {
            action: 'fetch_airtable_tables',
            app_id: appId,
            security: MyAjax.nonce
        },
        success: function (response) {
            var tables;

            if (typeof response === 'string') {
                tables = JSON.parse(response);
            } else {
                tables = response;
            }

            var tableSelect = jQuery('#wpc-wpcf7-airtable-table-id-selected');
            tableSelect.children('option:not(:first)').remove();

            jQuery.each(tables, function (index, value) {
                tableSelect.append(jQuery('<option>', {
                    value: index,
                    text: value.name
                }));
            });

            var prevSelectedTable = MyScriptData.table_selected;
            if (prevSelectedTable && tableSelect.find('option[value="' + prevSelectedTable + '"]').length) {
                tableSelect.val(prevSelectedTable);
            } else {
                tableSelect.val('-1'); // Set to the "Choose a table" option
            }
        }

    });
}

jQuery(document).ready(function ($) {
    // Extract app id and table from Airtable URL with key api
    var lookUpField = $('#wpc-wpcf7-airtable-table-lookup');
    var showError = function (message) {
        lookUpField.next('.error,.notice-success').remove();
        lookUpField.after($('<div class="error"></div>').text(message));
    };
    lookUpField.change(function () {
        var url = $(this).val();
        var base = 'https://airtable.com/';
        if (url.indexOf(base) !== 0) {
            showError(wp.i18n.__('Invalid Airtable URL', 'add-on-cf7-for-airtable'));
            return;
        }
        url = url.replace(base, '');
        var urlParts = url.split('/');
        if (urlParts.length === 0 || urlParts.length < 2) {
            showError(wp.i18n.__('Invalid Airtable URL', 'add-on-cf7-for-airtable'));
            return;
        }
        lookUpField.next('.error,.notice-success').remove();
        lookUpField.after($('<div class="notice notice-success"></div>').text(
            wp.i18n.__('Table found.', 'add-on-cf7-for-airtable')
        ));
        $('#wpc-wpcf7-airtable-app-id-selected').val(urlParts[0]);
        $('#wpc-wpcf7-airtable-table-selected').val(urlParts[1]);

    });

    // Hide / show field based on wpc-wpcf7-airtable-enabled value
    $('#wpc-wpcf7-airtable-enabled').change(function () {
        if ($(this).prop('checked')) {
            $('#wpc-wpcf7-airtable-setup-table, #wpc-wpcf7-airtable-fields-table').removeClass('is-disabled');
        } else {
            $('#wpc-wpcf7-airtable-setup-table, #wpc-wpcf7-airtable-fields-table').addClass('is-disabled');
        }
    })

    
    fetchAirtableTables(jQuery('#wpc-wpcf7-airtable-app-id-selected').val());

    function checkAndToggleErrorMessage() {
        var selectedAppId = $('#wpc-wpcf7-airtable-app-id-selected').val();
        var selectedTableId = $('#wpc-wpcf7-airtable-table-id-selected').val();

        if (selectedAppId !== "" && selectedTableId !== "" && selectedTableId !== "-1") {
            $('.notice-error').show();
        } else {
            $('.notice-error').hide();
        }
    }

    $('#wpc-wpcf7-airtable-app-id-selected, #wpc-wpcf7-airtable-table-id-selected').change(checkAndToggleErrorMessage);

    checkAndToggleErrorMessage();
    
    
    $('.airtable-field-select').change(function () {
        var selectedValue = $(this).val();
        updateSelectOptions(selectedValue);
    });

    function updateSelectOptions(selectedValue) {
        $('.airtable-field-select option').prop('disabled', false);

        $('.airtable-field-select').each(function () {
            var currentValue = $(this).val();
            if (currentValue) {
                $('.airtable-field-select').not(this).find('option[value=' + currentValue + ']').prop('disabled', true);
            }
        });
    }

    updateSelectOptions();
});