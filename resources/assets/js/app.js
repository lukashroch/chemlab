//require('./bootstrap');

$(document).ready(function () {

    /*
     * General / Common code shared across the app
     */
    var body = $('#body'),

        _token = $('meta[name="csrf-token"]').attr('content'),
        _sdfSearch = '';

    // Remove Alerts / Notifications
    $(body).on('click', 'a.close', function (e) {
        e.preventDefault();

        var alert = $(this).closest('div.alert');
        alert.slideUp(500);

        setTimeout(function () {
            alert.remove();
        }, 500);
    });

    $(body).on('click', 'a.delete, button.delete', function (e) {
        e.preventDefault();
        var button = $(this),
            response = button.data('response'),
            url = button.data('url') + '?' + $.param({response: response}),
            confirmMsg = button.data('confirm');

        if (button.data('action') === 'multi-delete') {
            var aId = [];
            var table = $('#data-table');

            if (table.hasClass('chemical') && button.data('url').includes('chemical-item')) {
                aId = table.DataTable().getSelected('item_id');
            }
            else {
                aId = table.DataTable().getSelected('id');
            }

            if (aId.length <= 0) {
                $(body).toggleAlert('warning', 'No items were selected', true);
                return false;
            }

            url += '&' + $.param({ids: aId});
            confirmMsg += aId.length;
        }

        if (!confirm(confirmMsg))
            return false;

        $.ajax({
            type: 'delete',
            url: url,
            headers: {'X-CSRF-Token': _token},
            success: function (data) {
                // TODO: remove this later on when whole delete system finished, just for debug
                if (response !== data.type && data.type !== 'error') {
                    console.log('Something went wrong! ... :' + data.type + ' .... ' + response + '.. :' + data.res);
                    return;
                }

                switch (data.type) {
                    case 'dt': {
                        $('#data-table').DataTable().draw();
                        body.toggleAlert(data.alert.type, data.alert.text, true);
                        break;
                    }
                    case 'chemical-item': {
                        button.closest('tr').remove();
                        break;
                    }
                    case 'redirect': {
                        window.location.replace(data.url);
                        break;
                    }
                    case 'error': {
                        body.toggleAlert(data.alert.type, data.alert.text, true);
                        $('html, body').animate({
                            scrollTop: 0
                        }, 600);
                        break;
                    }
                    default:
                        console.log('Something went wrong');
                        break;
                }
            }
        });
    });

    /*
     * General form check
     * 1) Trim text fields
     * 2) Check due classes and if any stop submit
     */
    $('form', body)
        .on('submit', function (e) {
            if ($(this).checkSubmit() === true)
                e.preventDefault();
        })
        .on('change', ':file', function () {
            var file = $(this).val().replace(/\\/g, '/').replace(/.*\//, '');
            $(this).attr('title', file);
            $(this).siblings('span').html(file);
        });

    /*
     * Attach search data to DataTable ajax request
     */
    $('#data-table').on('preXhr.dt', function (e, settings, data) {
        var panel = $('#panel-heading-search');
        data.search.string = $('input[name="s"]', panel).val();
        if ($(this).hasClass('chemical')) {
            data.search.store = [];
            $('select[name="store[]"] option:selected', panel).each(function () {
                data.search.store.push($(this).val());
            });
            data.search.attrs = [];
            var advanced = panel.find('#search-advanced');
            $('input[type=checkbox]', advanced).each(function () {
                data.search.attrs.push($(this).is(':checked') ? $(this).attr('name') : 'not-' + $(this).attr('name'));
            });
            $('input[type=text]', advanced).each(function () {
                data.search[$(this).attr('name')] = $(this).val();
            });
        }
        else if ($(this).hasClass('nmr')) {
            data.search.user = [];
            $('select[name="user[]"] option:selected', panel).each(function () {
                data.search.user.push($(this).val());
            });
        }
    });

    /*
     * Clear DataTable search input and reload DataTable
     */
    $('#panel-heading-search')
        .on('submit', 'form#form-search', function (e) {
            e.preventDefault();
            $('#data-table').DataTable().draw();
        })
        .on('click', 'button#search-clear', function (e) {
            e.preventDefault();
            _sdfSearch = '';

            var panel = $(e.delegateTarget);
            $('input[type=text]', panel).each(function () {
                $(this).val('');
            });

            var table = $('#data-table');
            if (table.hasClass('chemical')) {
                $('input[name="group"]').prop('checked', true);
                $('input[name="recent"]').prop('checked', false);
                $('select[name="store[]"]', panel).selectpicker('deselectAll');
            }
            table.DataTable().draw();
        });


    /*
     * Export buttons
     * prepare URLs for export buttons to make proper calls
     */
    $('#action-menu')
        .on('click', 'a.export', function () {
            var button = $(this),
                dt = $('#data-table').DataTable();

            if (dt.ajax.json().recordsTotal > 300) {
                alert('Select smaller data set of records (<300)');
                return false;
            }

            var params = dt.ajax.params();
            params.action = button.data('action');
            button.attr('href', button.data('url') + '?' + $.param(params));
        })
        .on('click', 'a.move', function (e) {
            if ($('#data-table').DataTable().getSelected('item_id').length <= 0) {
                e.preventDefault();
                $(body).toggleAlert('warning', 'No items were selected.', true);
                return false;
            }
        });

    /*
     * Auto complete vie typeahead and Bloodhound
     */
    var obj = $('input.typeahead');
    if (obj.length) {
        $.ajax({
            type: 'get',
            url: '/resource/autocomplete',
            headers: {'X-CSRF-Token': _token},
            data: {type: window.location.pathname.substring(1).split('/', 3)[0]},
            success: function (data) {
                var bh = new Bloodhound({
                    local: data,
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    datumTokenizer: Bloodhound.tokenizers.whitespace
                });

                obj.typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 3
                }, {
                    name: 's',
                    source: bh.ttAdapter(),
                    limit: 10
                });
            }
        });
    }

    /*
     * Roles & Permissions assignments
     */
    $('#assigned, #not-assigned').on('click', 'button', function (e) {
        var button = $(this),
            table = $(e.delegateTarget),
            tr = button.closest('tr');

        $.ajax({
            type: 'patch',
            url: table.data('url') + '/' + tr.data('id'),
            headers: {'X-CSRF-Token': _token},
            error: function (data) {
                body.toggleAlert('danger', data.responseJSON, true);
            }
        });

        if (table.attr('id') === 'assigned') {
            button.addClass('btn-success').removeClass('btn-danger');
            button.find('span').addClass('fa-common-badge-not-assigned').removeClass('fa-common-badge-assigned');
            $('#not-assigned').append(tr);
        }
        else {
            button.addClass('btn-danger').removeClass('btn-success');
            button.find('span').addClass('fa-common-badge-assigned').removeClass('fa-common-badge-not-assigned');
            $('#assigned').append(tr);
        }
    });

    /*
     * User Settings
     */
    $('#user-profile').on('change', 'select, :checkbox', function (e) {
        var el = $(this),
            type = $(this).attr('name'),
            value = (el[0].nodeName.toLocaleLowerCase() === 'select') ? el.val() : (el[0].checked ? 1 : 0);

        $.ajax({
            type: 'patch',
            url: $(e.delegateTarget).data('url'),
            headers: {'X-CSRF-Token': _token},
            data: {type: type, value: value},
            success: function () {
                if (type === 'lang')
                    location.reload();
            }
        });
    });

    /*
     * Chemicals
     */

    /*
     * Select stores based on Store Tree selection and submit to DataTable
     */
    $('#store-tree-modal').on('click', 'ul li a', function (e) {
        e.preventDefault();
        var modal = $(e.delegateTarget),
            stores = $(this).data('store-id');
        $('select[name="store[]"]').selectpicker('deselectAll').selectpicker('val', (typeof(stores) === 'string') ? stores.split(';') : stores);
        $('#data-table').DataTable().draw();
        modal.modal('hide');
    });

    /*
     * Show modal for Chemical items multi-move
     */
    $('#chemical-item-move-modal')
        .on('show.bs.modal', function () {
            $(this).find('.modal-body blockquote span').text($('#data-table').DataTable().getSelected('item_id').length);
        })
        .on('submit', 'form#move', function (e) {
            e.preventDefault();
            var modal = $(e.delegateTarget),
                dt = $('#data-table').DataTable(),
                id = dt.getSelected('item_id');

            if (id.length <= 0) {
                $('div.modal-body', modal).toggleAlert('warning', 'No items were selected', true);
                return false;
            }

            $.ajax({
                type: 'patch',
                url: $(this).attr('action'),
                data: {
                    store_id: $('select[name="store_id"] option:selected', modal).val(),
                    id: id
                },
                headers: {'X-CSRF-Token': _token},
                success: function (data) {
                    if (data.type === 'dt') {
                        dt.rows({selected: true}).invalidate().draw();
                        modal.modal('hide');
                        body.toggleAlert(data.alert.type, data.alert.text, true);
                    }
                },
                error: function (data) {
                    $('div.modal-body', modal).toggleAlert('danger', data.responseJSON, true);
                }
            });
        });

    // Check Brand Id availability
    $('#chemical-edit').on('change', '#brand_id, #catalog_id', function () {
        brandCheck();
    });


    // Data parsing from Sigma Aldrich / Cactus NCI
    $('#chemical-data-menu').on('click', 'a', function (e) {
        e.preventDefault();
        var type = $(this).attr('name');

        if (type === 'close')
            return;

        if (type === 'sigma-aldrich' || type === 'all-data') {
            var catalogId = $.trim($('#catalog_id').val());
            if (catalogId === '') {
                body.toggleAlert('warning', 'Fill valid vendor catalog ID!', true);
                return;
            }

            $('#chemical-data-icon').addClass('fa-spin');
            $.getJSON('/chemical/ajax/parse', {catalog_id: catalogId, callback: 'sigma-aldrich'/*type*/})
                .done(function (data) {
                    if (data.brand_id === 0) {
                        body.toggleAlert('danger', 'Chemical with entered vendor ID not found!', true);
                        return;
                    }

                    for (var key in data) {
                        if (!data.hasOwnProperty(key))
                            continue;

                        var el = $('#' + key);
                        if (!el.length)
                            continue;

                        switch (el[0].nodeName.toLowerCase()) {
                            case 'input':
                            case 'textarea':
                                if (data[key] !== '')
                                    el.val(data[key]);
                                break;
                            case 'select':
                                el.selectpicker('val', data[key]);
                                break;
                            default:
                                break;
                        }
                    }

                    brandCheck();
                })
                .always(function (data) {
                    if (type === 'all-data' && data.brand_id !== 0)
                        getAllCactusData(data.cas, data.name);
                    else
                        $('#chemical-data-icon').removeClass('fa-spin');
                });
        }
        else if (type === 'cactus-nci') {
            getAllCactusData();
        }
        else {
            getCactusData(type);
            if (type === 'sdf') {
                getCactusData('smiles');
                getCactusData('stdinchikey');
                getCactusData('stdinchi');
            }
        }
    });

    // Load chemical structure to the sketcher
    $('iframe#ketcher').on('load', function () {
        $(this).renderStructure('molecule', $('#sdf').val());
    });

    $('#chemical').on('click', 'a#toggle-tab-structure', function () {
        setTimeout(function () {
            $('iframe#ketcher').renderStructure('molecule', $('#sdf').val());
        }, 50);
    });

    // Show modal with various structure data
    $('#structure-data-modal').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget),
            modal = $(this);

        modal.find('.modal-title').text(button.html());
        modal.find('.modal-body code').html($('#' + button.data('structure')).val().replace(/\n/g, "<br>"));
    });

    $('#structure-sketcher-modal')
    // Show modal with chemical structure editor
        .on('shown.bs.modal', function () {
            var ketcher = $('iframe#ketcher').ketcher(),
                sdf = $('#sdf').val().sdf();

            if (sdf === false)
                return;

            ketcher.setMolecule(sdf);
        })
        // Submit chemical structure for saving to DB
        .on('click', '#structure-sketcher-submit', function (e) {
            e.preventDefault();
            var modal = $(e.delegateTarget),
                fKetcher = $('iframe#ketcher'),
                ketcher = fKetcher.ketcher(),
                smiles = ketcher.getSmiles(),
                sdf = ketcher.getMolfile();

            if (!smiles) {
                alert('Draw the structure before submitting the query!');
                return false;
            }

            fKetcher.renderStructure('molecule', sdf);
            $('#smiles').val(smiles);
            $('#sdf').val(sdf);

            modal.modal('hide');

            $.get('https://cactus.nci.nih.gov/chemical/structure', {
                string: smiles,
                representation: 'stdinchikey'
            })
                .done(function (inchikey) {
                    $('#inchikey').val(inchikey.replace('InChIKey=', ''));
                });
            $.get('https://cactus.nci.nih.gov/chemical/structure', {
                string: smiles,
                representation: 'stdinchi'
            })
                .done(function (inchi) {
                    $('#inchi').val(inchi.replace('InChI=', ''));
                })
        });


    $('#chemical-item-modal')
    // Show modal for Chemical Item create/edit actions
        .on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget),
                modal = $(this);

            $('input', modal).each(function () {
                var name = $(this).attr('name');
                $(this).val(button.data(name));

                if (name === 'amount') {
                    $(this).focus();
                }
            });

            if (button.data('id') === undefined) {
                $('select', modal).each(function () {
                    $(this).find('option:first-child').attr("selected", "selected");
                    $(this).selectpicker('render');

                    if ($(this).attr('name') === 'count') {
                        $(this).closest('div.input-group').removeClass('hidden-xs-up');
                    }
                });
            } else {
                $('select[name=count]', modal).closest('div.input-group').addClass('hidden-xs-up');
                $('select[name=store_id]', modal).selectpicker('val', button.data('store_id'));
                $('select[name=unit]', modal).selectpicker('val', button.data('unit'));
                $('select[name=owner_id]', modal).selectpicker('val', button.data('owner_id'));
            }

        })
        // Chemical Item store/update actions
        .on('submit', '#chemical-item-form', function (e) {
            e.preventDefault();
            var form = $(this),
                modal = $(e.delegateTarget),
                id = $('input[name=id]', form).val(),
                type = 'post',
                url = '/chemical-item';

            $('input[name=amount]').val().replace(',', '.');
            if (id !== '') {
                type = 'patch';
                url = '/chemical-item/' + id;
            }

            $.ajax({
                type: type,
                url: url,
                headers: {'X-CSRF-Token': _token},
                data: form.serialize(),
                success: function (data) {
                    if (id === '')
                        $('#chemical-items').find('tbody').prepend(data.str);
                    else
                        $('#chemical-items').find('tbody tr.' + id).replaceWith(data.str);

                    modal.modal('hide');
                },
                error: function (data) {
                    $('div.modal-body', modal).toggleAlert('danger', data.responseJSON, true);
                }
            });
        });

    $('#chemical-search-sketcher-modal')
        .on('shown.bs.modal', function () {
            $('iframe#ketcher').ketcher().setMolecule(_sdfSearch);
        })
        .on('click', '#chemical-search-sketcher-submit', function (e) {
            e.preventDefault();

            var ketcher = $('iframe#ketcher').ketcher(),
                smiles = ketcher.getSmiles();

            _sdfSearch = ketcher.getMolfile();

            if (!smiles) {
                alert('Draw the structure before submitting the query!');
                return false;
            }

            $('#chemical-search-sketcher-submit').find('span').addClass('fa-spin');
            $.get('https://cactus.nci.nih.gov/chemical/structure', {
                string: smiles,
                representation: 'stdinchikey'
            })
                .done(function (inchikey) {
                    $('input[name=inchikey]').val(inchikey.replace('InChIKey=', ''));
                    $('#chemical-search-sketcher-modal').modal('hide');
                })
                .fail(function () {
                    alert('Check the structure for errors!');
                })
                .always(function () {
                    $('#chemical-search-sketcher-submit').find('span').removeClass('fa-spin');
                });
        });
});

function getAllCactusData(cas, name) {
    cas = (typeof(cas) === 'undefined') ? $('#cas').val() : cas;
    name = (typeof(name) === 'undefined') ? $('#name').val() : name;
    var delay = 1;

    if (cas === '') {
        if (name === '') {
            $('#body').toggleAlert('danger', 'Fill at least CAS or name of the chemical (both to increase the chance of getting requested data)', true);
            return;
        }
        else {
            delay = 1000;
            getCactusData('cas');
        }
    }

    setTimeout(function () {
        getCactusData('iupac_name');
        getCactusData('chemspider_id');
        getCactusData('mw');
        getCactusData('formula');
        getCactusData('sdf');
        getCactusData('smiles');
        getCactusData('stdinchikey');
        getCactusData('stdinchi');
    }, delay);
}

function getCactusData(type) {
    var cas = $('#cas').val().split(';')[0],
        name = $('#name').val().replace('(+)-', '').replace('(−)-', '').replace('(±)-', ''),
        skipCas = false;

    if (cas === '') {
        if (name === '') {
            $('#body').toggleAlert('warning', 'Fill at least CAS or name of the chemical (both to increase the chance of getting requested data)', true);
            return;
        }
        else
            skipCas = true;
    }

    var url = 'https://cactus.nci.nih.gov/chemical/structure';
    if (type === 'sdf')
        url += '?operator=remove_hydrogens';

    $('#chemical-data-icon').addClass('fa-spin');
    $.get(url, {string: skipCas ? name : cas, representation: type})
        .done(function (data) {
            fillCactusData(type, data);
            $('#chemical-data-icon').removeClass('fa-spin');
        })
        .fail(function () {
            if (skipCas)
                return;

            $.get(url, {string: name, representation: type})
                .done(function (data) {
                    fillCactusData(type, data);
                })
                .always(function () {
                    $('#chemical-data-icon').removeClass('fa-spin');
                });
        });
}

function fillCactusData(type, data) {
    // check to prevent inserting invalid data
    if (data.indexOf('<!DOCTYPE') !== -1)
        return;

    switch (type) {
        case 'mw':
        case 'formula':
        case 'smiles': {
            $('#' + type).val(data);
            break;
        }
        case 'iupac_name':
        case 'cas': {
            $('#' + type).val(data.split('\n').join(';'));
            break;
        }
        case 'chemspider_id': {
            $('#' + type.replace('_id', '')).val(data.split('\n').join(';'));
            break;
        }
        case 'sdf': {
            $('#' + type).val(data);
            $('iframe#ketcher').renderStructure('molecule', data);
            break;
        }
        case 'stdinchikey':
        case 'stdinchi': {
            var strip = (type === 'stdinchikey') ? 'InChIKey=' : 'InChI=';
            $('#' + type.replace('std', '')).val(data.replace(strip, ''));
            break;
        }
    }
}

function brandCheck() {
    var catalogId = $('#catalog_id'),
        brandId = $('#brand_id');

    if (catalogId.val() === '')
        return;

    $.get('/chemical/ajax/check-brand', {
        catalog_id: $.trim(catalogId.val()),
        brand_id: brandId.val(),
        except: $('#id').val()
    })
        .done(function (data) {
            var state = data.msg !== 'valid';
            $('#body').toggleAlert('danger', data, state);
            catalogId.closest("div.form-group").toggleClass('has-error', state);
            brandId.closest("div.form-group").toggleClass('has-error', state);
        });
}

(function ($) {

    $.fn.checkSubmit = function () {
        var stopSubmit = false;

        $('input[type="text"]', $(this)).each(function () {
            var el = $(this);
            if (el.attr('type') === 'text')
                el.val($.trim(el.val()));

            if (el.hasClass('due')) {
                el.closest("div.form-group").removeClass('has-error');
                if (!el.val()) {
                    stopSubmit = true;
                    el.closest("div.form-group").addClass('has-error');
                }
            }
        });

        return stopSubmit;
    };

    $.fn.formatAlert = function (type, text) {
        return $('<div class=\"alert alert-' + type + ' alert-dismissible alert-hidden\"><span class=\"fa fa-common-alert-danger\" aria-hidden=\"true\"></span> '
            + text + '<a class=\"close float-right common-alert-close\"><span class=\"fa fa-common-alert-close\" aria-hidden=\"true\" title=\"Close\"></span></a></div>');
    };

    $.fn.toggleAlert = function (type, data, show) {
        var alert = '',
            el = $(this);

        if (show) {
            $('div.alert', el).remove();

            if (typeof(data) === 'object') {
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        alert = el.formatAlert(type, data[key]);
                        this.prepend(alert);
                        alert.slideDown(500);
                    }
                }
            } else if (typeof(data) === 'string') {
                alert = el.formatAlert(type, data);
                this.prepend(alert);
                alert.slideDown(500);
            }
        }
        else {
            alert = $('div.alert', el);
            if (alert.is(":visible")) {
                alert.slideUp(500).delay(500).remove();
            }
        }
    };

    $.fn.ketcher = function () {
        if (this[0] === 'undefined' || typeof(this[0]) === 'undefined')
            return false;

        if ('contentDocument' in this[0])
            return this[0].contentWindow.ketcher;
        else // IE7
            return document.frames[this.attr('id')].window.ketcher;
    };

    $.fn.renderStructure = function (id, data) {
        var object = $('#' + id);
        if (!object.length)
            return false;

        var ketcher = this.ketcher();
        var sdf = data.sdf();

        if (!ketcher || sdf === false) {
            console.log('no ketcher or sdf data');
            return false;
        }

        ketcher.showMolfile(object[0], data.sdf(), {
            bondLength: 20,
            autoScale: true,
            autoScaleMargin: 35,
            ignoreMouseEvents: true,
            atomColoring: true
        });
    };

    $.fn.dataTable.Api.register('getSelected()', function (field) {
        var id = [];
        if (field === 'id') {
            id = this.rows({selected: true}).data().pluck(field).toArray();
        }
        else {
            this.rows({selected: true}).data().each(function (data) {
                $.merge(id, data[field].split(';'));
            });
        }
        return id;
    });
}(jQuery));

String.prototype.sdf = function () {

    if (!this)
        return false;

    var aSdf = this.split('\n');
    if (aSdf.length < 4)
        return false;

    return aSdf[3].toUpperCase().indexOf('V2000') === -1 ? '\n' + this : this;
};
