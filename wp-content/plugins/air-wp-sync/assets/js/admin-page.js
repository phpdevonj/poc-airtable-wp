function airWpSyncSettingsHandler() {
    const $ = jQuery;
    return {
        config: airWpSyncGetConfig(),
        bases: [],
        tables: [],
        current_object: undefined,
        views: function() {
            var views = [];
            var tableId = this.config.table;
            if (tableId) {
                var table = this.tables.find(function(table) {
                    return table.id == tableId;
                });
                if (table) {
                    views = table.views;
                }
            }
            return views;
        },
        fields: function() {
            var fields = [];
            var tableId = this.config.table;
            if (tableId) {
                var table = this.tables.find(function(table) {
                    return table.id == tableId;
                });
                if (table) {
                    fields = table.fields;
                }
            }
            return fields;
        },
        originalConfigJson: JSON.stringify(airWpSyncGetConfig()),
        loadingBases: false,
        loadingTables: false,
        serverValidation: {},
        localValidation: {},
        inputElements: [],
        validationNotice: null,
        nonce: document.getElementById('air-wp-sync-ajax-nonce').value,
        mappingOptions: {},
        init() {
            this.loadAirtableBases();

            this.$nextTick(() => this.updateErrorMessages());

            this.validationNotice = document.getElementById('airwpsync-validation-notice');

            // Validate form when publish button clicked
            var alpineContainer = document.getElementById('airwpsync-alpine-container');
            document.getElementById('publish').addEventListener('click', function(e) {
                var event = new CustomEvent('validate', { detail: {
                        originalEvent: e,
                    }});
                alpineContainer.dispatchEvent(event);
            });

            // Update mapping from React
            $(document).on('airwpsync/mapping-updated', function (e) {
                self.config = {
                    ...self.config,
                    mapping: e.detail
                };
            });
        },
        updateErrorMessages: function () {
            this.localValidation = {};
            this.inputElements = [...this.$el.querySelectorAll('[data-rules]')];
            this.inputElements.map((input) => {
                var name = input.dataset.name || input.name;
                var value = input.dataset.value;
                if (value === 'config.mapping') {
                    value = this.config.mapping;
                } else if (value) {
                    value = input.dataset.value.split('.').reduce((a, b) => a[b], this);
                } else {
                    value = input._x_model.get() || '';
                }
                var rules = input.dataset.rules;

                if (!this.localValidation[name]) {
                    this.localValidation[name] = {
                        errorMessages: [],
                        blurred: false,
                    }
                }

                this.localValidation[name].errorMessages = wp.hooks.applyFilters('airwpsync.getErrorMessages', [], value, rules, this);
            });
        },
        getErrorMessages: function(name) {
            return this.localValidation[name] && this.localValidation[name].blurred ? this.localValidation[name].errorMessages : [];
        },
        hasErrors: function(name) {
            return this.getErrorMessages(name).length > 0;
        },
        change: function (event) {
            this.updateErrorMessages();
            if (!this.localValidation[event.target.name]) {
                return false;
            }
            if (event.type === "focusout") {
                this.localValidation[event.target.name].blurred = true;
            }
        },
        submit: function(event) {
            var isValid = true;
            this.updateErrorMessages();
            this.refreshMetaboxMapping();
            this.inputElements.map((input) => {
                var name = input.dataset.name || input.name;
                this.localValidation[name].blurred = true;
            });
            for (var name in this.localValidation) {
                if (this.localValidation[name].errorMessages.length > 0) {
                    isValid = false;
                }
            }
            if (!isValid) {
                event.detail.originalEvent.preventDefault();
                this.validationNotice.style.display = 'block';
            }
        },
        getValidationCssClass(key) {
            var cssClass = '';
            if (this.serverValidation[key]) {
                if (this.serverValidation[key].valid === true) {
                    cssClass = 'dashicons-before dashicons-yes-alt';
                }
                if (this.serverValidation[key].valid === false) {
                    cssClass = 'dashicons-before dashicons-dismiss';
                }
            }
            return cssClass;
        },
        configHasChanged() {
            return JSON.stringify(this.config) !== this.originalConfigJson;
        },
        loadAirtableBases() {
            var self = this;
            if (this.config.api_key) {
                this.loadingBases = true;
                this.loadingTables = true;
                var data = {
                    'action': 'air_wp_sync_get_airtable_bases',
                    'nonce': this.nonce,
                    'apiKey': this.config.api_key,
                };
                jQuery.post(window.ajaxurl, data, function(response) {
                    if (response.success) {
                        self.bases = response.data.bases;

                        // Preselect first base and load tables
                        if (!self.config.app_id && self.bases.length > 0) {
                            self.config.app_id = self.bases[0].id;
                        }
                        // Mark api key as valid
                        self.serverValidation.apiKey = {
                            valid: true,
                            message: '',
                        };
                        // Now load tables from base
                        self.loadAirtableTables();
                    }
                    else {
                        // Mark api key as invalid
                        self.serverValidation.apiKey = {
                            valid: false,
                            message: response.data.error,
                        };
                        // Empty bases and tables
                        self.bases = [];
                        self.tables = [];
                    }
                    self.loadingBases = false;
                    self.loadingTables = false;
                });
            }
        },
        loadAirtableTables() {
            var self = this;
            if (this.config.api_key && this.config.app_id) {
                this.loadingTables = true;
                var data = {
                    'action': 'air_wp_sync_get_airtable_tables',
                    'nonce': this.nonce,
                    'apiKey': this.config.api_key,
                    'appId': this.config.app_id,
                    'options': JSON.stringify({
                        'enable_link_to_another_record': 'yes' === this.config.enable_link_to_another_record,
                    })
                };
                jQuery.post(window.ajaxurl, data, function(response) {
                    if (response.success) {
                        self.tables = response.data.tables;
                    }
                    else {
                        self.tables = [];
                    }
                    // check if config.table matches one of the tables
                    var currentTable = null;
                    if (self.config.table && self.tables.length > 0) {
                        var currentTable = self.tables.find(function(table) {
                            return table.id == self.config.table;
                        });
                    }
                    // Preselect first table if no match
                    if (!currentTable && self.tables.length > 0) {
                        self.config.table = self.tables[0].id;
                        self.config.view = null;
                        self.config.mapping = [];
                    }
                    else {
                        // Migrate from before meta API
                        self.config.mapping.forEach(function(mapping, i) {
                            if (self.fields().length > 0) {
                                self.fields().forEach(function(f) {
                                    if (f.name === mapping.airtable) {
                                        self.config.mapping[i].airtable = f.id;
                                    }
                                });
                            }
                        });

                    }
                    self.loadingTables = false;
                    self.checkFormulaFilter();
                    self.updateWordPressOptions();
                });
            }
        },
        onTableChange() {
            this.config.view = null;
            this.config.mapping = [];
            this.checkFormulaFilter();

            self.updateWordPressOptions();
        },
        checkFormulaFilter() {
            this.serverValidation.formulaFilter = {};

            self = this;
            if (this.config.api_key && this.config.app_id && this.config.table && this.config.formula_filter) {
                var data = {
                    'action': 'air_wp_sync_check_formula_filter',
                    'nonce': this.nonce,
                    'apiKey': this.config.api_key,
                    'appId': this.config.app_id,
                    'table': this.config.table,
                    'view': this.config.view,
                    'formulaFilter': this.config.formula_filter,
                };
                jQuery.post(window.ajaxurl, data, function(response) {
                    if (response.success) {
                        // Mark formula filter as invalid
                        self.serverValidation.formulaFilter = {
                            valid: true,
                        };
                    }
                    else {
                        // Mark formula filter as invalid
                        self.serverValidation.formulaFilter = {
                            valid: false,
                            message: response.data.error,
                        };
                    }
                });
            }
        },
        updateWordPressOptions() {
            this.updateErrorMessages();
            this.refreshMetaboxMapping();
        },
        refreshMetaboxMapping() {
            const self = this;
            if (!self.config.table) {
                $('#airwpsync-metabox-mapping').empty();
                return;
            }

            window.airWPSyncRenderMetaboxMapping({
                id: 'airwpsync-metabox-mapping',
                i18n: wp.i18n,
                mappingInit: [ ...self.config.mapping ],
                defaultMappingOptions: window.airWpSync[self.config.module].mappingOptions,
                isOptionAvailable(value) {
                    return wp.hooks.applyFilters('airwpsync.isOptionAvailable', true, value, self);
                },
                fields: self.fields(),
                config: {
                    post_type: self.config.post_type,
                    post_type_slug: self.config.post_type_slug,
                },
                localValidation: self.localValidation && self.localValidation['mapping'] ? self.localValidation['mapping'] : {
                    errorMessages: [],
                    blurred: false,
                }
            });
        },
        showNoticeHandler(noticeKey) {
            const self = this;
            return function () {
                self.config.notices[noticeKey] = true;
            }
        },
        hideNoticeHandler(noticeKey) {
            const self = this;
            return function () {
                self.config.notices[noticeKey] = false;
            }
        },
    }
}


function airWpSyncGetConfig() {
    var config = window.airwpsyncImporterData || {};
    if (!config.hasOwnProperty('mapping')) {
        config.mapping = [];
    }

    if (!config.hasOwnProperty('scheduled_sync')) {
        config.scheduled_sync = {
            type: 'manual',
            recurrence: '',
        };
    }

    for (let i=0;i<config.mapping.length;i++) {
        if (!config.mapping[i].hasOwnProperty('options')) {
            config.mapping[i].options = {};
        }
    }

    if (!config.hasOwnProperty('notices')) {
        config.notices = {};
    }

    // Set default "enable_link_to_another_record" option value.
    if (!config.hasOwnProperty('enable_link_to_another_record')) {
        config.enable_link_to_another_record = 'no';
    } else if ('yes' === config.enable_link_to_another_record && !config.notices.hasOwnProperty('link-to-another-record-warning')) {
        // Show warning if it has not been shown yet.
        config.notices['link-to-another-record-warning'] = true;
    }

    return config;
}

(function($) {
    var $nonceField;
    var $importButton;
    var $cancelButton;
    var $feedback;
    var $infos;
    var originalConfigJson;
    var timeout;

    function init() {
        $nonceField = $('#air-wp-sync-trigger-update-nonce');
        $importButton = $('#airwpsync-import-button');
        $cancelButton = $('#airwpsync-cancel-button');
        $feedback = $('#airwpsync-import-feedback');
        $infos = $('#airwpsync-import-stats');

        originalConfigJson = JSON.stringify(airWpSyncGetConfig());

        $importButton.on('click', function() {
            var importerId = $(this).data('importer');
            triggerUpdate(importerId);
        });

        $cancelButton.on('click', function() {
            var importerId = $importButton.data('importer');
            cancelImport(importerId);
        });

        if ($importButton.hasClass('loading')) {
            $importButton.attr('disabled', 'disabled');
            var importerId = $importButton.data('importer');
            getProgress(importerId);
        }

        $(window).on('beforeunload', beforeUnload);

        $('#delete-action').on('click', function() {
            $(window).off('beforeunload', beforeUnload);
            return wp.hooks.applyFilters('airwpsync.deleteConnection', true, this);
        });

        $('#post').on('submit', function() {
            $(window).off('beforeunload', beforeUnload);
        });
    }

    function triggerUpdate(importerId) {
        clearTimeout(timeout);
        $importButton.addClass('loading').attr('disabled', 'disabled');
        $feedback.html(window.airWpSyncL10n.startingUpdate || 'In progress...').show();
        var data = {
            'action': 'air_wp_sync_trigger_update',
            'nonce': $nonceField.val(),
            'importer': importerId,
        };
        $.post(window.ajaxurl, data, function(response) {
            $feedback.html(response.data.feedback);
            if (response.success) {
                getProgress(importerId);
            }
            else {
                $importButton.removeClass('loading').removeAttr('disabled');
                $infos.html(response.data.infosHtml);
                timeout = setTimeout(function() {
                    $feedback.fadeOut();
                }, 6000);
            }
        }).fail(function() {
            $importButton.removeClass('loading').removeAttr('disabled');
        });
    }

    function cancelImport(importerId) {
        clearTimeout(timeout);
        $importButton.removeClass('loading').removeAttr('disabled');
        $cancelButton.addClass('loading').attr('disabled', 'disabled');
        $feedback.html(window.airWpSyncL10n.canceling || 'Canceling...').show();
        var data = {
            'action': 'air_wp_sync_cancel_import',
            'nonce': $nonceField.val(),
            'importer': importerId,
        };
        $.post(window.ajaxurl, data, function(response) {
            $feedback.html(response.data.feedback);
            $cancelButton.removeClass('loading').removeAttr('disabled').hide();
            $infos.html(response.data.infosHtml);
            timeout = setTimeout(function() {
                $feedback.fadeOut();
            }, 6000);
        }).fail(function() {
            $cancelButton.removeClass('loading').removeAttr('disabled');
        });
    }

    function getProgress(importerId) {
        if (!$importButton.hasClass('loading')) {
            return;
        }
        $cancelButton.show();
        var data = {
            'action': 'air_wp_sync_get_progress',
            'nonce': $nonceField.val(),
            'importer': importerId,
        };
        $.post(window.ajaxurl, data, function(response) {
            $feedback.html(response.data.feedback);
            if (response.data.infosHtml || !response.success) {
                $importButton.removeClass('loading').removeAttr('disabled');
                $cancelButton.removeClass('loading').removeAttr('disabled').hide();
                $infos.html(response.data.infosHtml);
                timeout = setTimeout(function() {
                    $feedback.fadeOut();
                }, 6000);
            }
            else {
                setTimeout(function() {
                    getProgress(importerId);
                }, 3000);
            }

        }).fail(function() {
            $importButton.removeClass('loading').removeAttr('disabled');
        });
    }

    function beforeUnload() {
        if ( originalConfigJson !== $('[name="content"]').val() ) {
            return "You have unsaved changes.";
        }
    }
  
    $(init);
})(jQuery);

(function($) {
    function init() {
        $(document).tooltip({
            items: '.airwpsync-tooltip',
            tooltipClass: 'arrow-bottom',
            content: function() {
                return $(this).attr('aria-label');
            },
            position: {
                my: 'center bottom',
                at: 'center-3 top-11',
            },
            open: function (event, ui) {
                self = this;
                if (typeof (event.originalEvent) === 'undefined') {
                    return false;
                }
    
                var $id = ui.tooltip.attr('id');
                $('div.ui-tooltip').not('#' + $id).remove();
            },
            close: function (event, ui) {
                ui.tooltip.hover(function () {
                    $(this).stop(true).fadeTo(400, 1);
                },
                function () {
                    $(this).fadeOut('500', function() {
                        $(this).remove();
                    });
                });
            }
        });
    }
  
    $(init);
})(jQuery);


/**
 * Validation: required field rule
 */
wp.hooks.addFilter('airwpsync.getErrorMessages', 'wpconnect/airwpsync/errors/required', function(messages, value, rules) {
    if (rules.indexOf('required') > -1 && value.length === 0) {
        messages.push('This fields is required');
    }
    return messages;
});

/**
 * Validation: mappingRequired field rule
 */
wp.hooks.addFilter('airwpsync.getErrorMessages', 'wpconnect/airwpsync/errors/mappingRequired', function(messages, value, rules) {
    if (rules.indexOf('mappingRequired') > -1 && value.length > 0) {
        const oneFieldIsEmpty = value.reduce(function (result, mapping) {
            if ('' === mapping.wordpress) {
                result = true;
            }
            return result;
        }, false);
        if (oneFieldIsEmpty) {
            messages.push('Please select an option in the "Import As" column for all mappings');
        }

        const oneCustomFieldEmpty = value.reduce(function (result, mapping) {
            if (mapping.wordpress && mapping.wordpress.split('::')[1] === 'custom_field' && mapping.options && (!mapping.options.name || mapping.options.name === '')) {
                result = true;
            }
            return result;
        }, false);
        if (oneCustomFieldEmpty) {
            messages.push('"Custom Field" fields can\'t be empty.');
        }
    }
    return messages;
});
