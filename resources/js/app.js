import Bloodhound from "bloodhound-js";

require('./bootstrap');

$(document).ready(function () {

    /*
     * General / Common code shared across the app
     */
    let page = $('#top'),
        _token = $('meta[name="csrf-token"]').attr('content'),
        _sdfSearch = '';

    /*
     * Highlight active nav links
     */
    let url = window.location;
    let root = "/";
    $('.nav li.nav-item a.nav-link', $('.sidebar')).filter(function () {
        let href = this.href;
        if (href.includes('#') && !href.split('#')[1].length)
            return false;

        let link = href.replace(url.origin, '');
        return link === root ? (url.pathname === link) : url.pathname.startsWith(link);
    }).addClass('active').closest('.has-treeview').addClass('menu-open');

    /*
     * Scroll to top functionality
     */
    window.onscroll = function () {
        if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
            $("#back-top").show();
        } else {
            $("#back-top").hide();
        }
    };

    $(page).on('click', 'button#back-top', function () {
        page.scrollTo(500);
    });

    /*
     * Handle view/edit actions
     */
    $('#actionToolbar', page)
        .on('click', '.action', function (e) {
            e.preventDefault();

            let button = $(this),
                action = button.data('action'),
                id = window.LaravelDataTables['data-table'].rows({selected: true}).data().pluck('id').toArray();

            if (id.length !== 1) {
                new Notify('notice', 'Select one item to view/edit.');
                return false;
            }

            if (action !== 'detail') {
                window.location.replace(window.location.href + '/' + id.join(';') + (action === 'edit' ? '/edit' : ''));
            }
        })
        .on('click', '.move', function (e) {
            if (window.LaravelDataTables['data-table'].getSelected('item_id').length <= 0) {
                e.preventDefault();
                new Notify('notice', 'No items were selected.');
                return false;
            }
        });

    /*
     * DataTable export buttons
     * prepare URLs for export buttons to make proper calls
     */
    $('#export-modal').on('click', 'a.export', function (e) {
        let button = $(this),
            dt = window.LaravelDataTables['data-table'];

        let params = dt.ajax.params();
        params.action = button.data('action');
        params.search.id = dt.rows({selected: true}).data().pluck('id').toArray();
        params.selected_cols = [];
        $('input[type="checkbox"]', $(e.delegateTarget)).each(function () {
            if ($(this).is(':checked'))
                params.selected_cols.push($(this).attr('name'));
        });
        if (!params.selected_cols.length) {
            alert('Select at least one column to export');
            e.preventDefault();
            return;
        }

        button.attr('href', button.data('url') + '?' + $.param(params));
    });

    $(page).on('click', 'a.delete, button.delete', function (e) {
        e.preventDefault();
        let button = $(this),
            response = button.data('response'),
            url = button.data('url') + '?' + $.param({response: response}),
            confirmMsg = button.data('confirm');

        if (button.data('action') === 'multi-delete') {
            let aId = [];
            let table = $('#data-table');

            if (table.hasClass('chemical') && button.data('url').includes('chemical-item')) {
                aId = table.DataTable().getSelected('item_id');
            } else {
                aId = table.DataTable().getSelected('id');
            }

            if (aId.length <= 0) {
                new Notify('notice', 'No items were selected');
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
                        window.LaravelDataTables['data-table'].draw();
                        new Notify(data.message.type, data.message.text);
                        break;
                    }
                    case 'chemical-item': {
                        button.closest('tr').remove();
                        new Notify(data.message.type, data.message.text);
                        break;
                    }
                    case 'redirect': {
                        window.location.replace(data.url);
                        break;
                    }
                    case 'error': {
                        new Notify(data.message.type, data.message.text);
                        page.scrollTo();
                        break;
                    }
                    default:
                        console.log('Something went wrong');
                        break;
                }
            },
            error: function (data) {
                new Notify('error', data.responseJSON.errors);
            }
        });
    });

    /*
     * General form check
     * 1) Trim text fields
     * 2) Check due classes and if any stop submit
     */
    $('form', page).on('change', ':file', function () {
        let file = $(this).val().replace(/\\/g, '/').replace(/.*\//, '');
        $(this).attr('title', file);
        $(this).siblings('span').html(file);
    });

    /*
     * Attach search data to DataTable ajax request
     */
    $('#data-table')
        .on('preXhr.dt', function (e, settings, data) {
            let panel = $('#datatable-header'),
                table = $(this);

            data.search.string = $('input[name="s"]', panel).val();

            $('select.selectpicker', panel).each(function () {
                let select = $(this);
                let name = select.attr('name').replace('[]', '');

                data.search[name] = {};
                $('option:selected', select).each(function () {
                    data.search[name][$(this).val()] = $(this).html();
                });
            });

            if (table.hasClass('chemical')) {
                data.search.attrs = [];
                let advanced = panel.find('#search-advanced');
                $('input[type=checkbox]', advanced).each(function () {
                    data.search.attrs.push($(this).is(':checked') ? $(this).attr('name') : 'not-' + $(this).attr('name'));
                });

                $('input[type=text]', advanced).each(function () {
                    data.search[$(this).attr('name')] = $(this).val();
                });
            }
        })
        .on('draw.dt', function () {
            let dt = $(this).DataTable(),
                $dtFilter = $("#dtFilter"),
                $dtCount = $("#dtCount"),
                str = '',
                search = dt.ajax.json().search ? dt.ajax.json().search : [];

            for (let key in search) {
                if (!search.hasOwnProperty(key) || key === 'value' || key === 'regex')
                    continue;

                if (typeof search[key] === 'string')
                    str += '<span class="badge badge-primary">' + search[key] + '</span>&nbsp;';
                else if (typeof search[key] === 'object') {
                    for (let objKey in search[key]) {
                        if (search[key].hasOwnProperty(objKey)) {
                            str += '<span class="badge badge-primary">' + search[key][objKey] + '</span>&nbsp;';
                        }
                    }
                }
            }

            $dtFilter.html(str !== '' ? str + '<span class="far fa-btn fa-lg fa-times-circle bg-warning rounded-circle search-clear ml-2" title="Remove filter"></span>' : 'none');
            $dtCount.html(dt.ajax.json().recordsTotal);
        });

    /*
     * Clear DataTable search input and reload DataTable
     */
    $('#datatable-header')
        .on('submit', 'form#form-search', function (e) {
            e.preventDefault();
            window.LaravelDataTables['data-table'].draw();
        })
        .on('click', '.search-clear', function (e) {
            e.preventDefault();
            _sdfSearch = '';

            $('form#form-search')[0].reset();
            let panel = $(e.delegateTarget);
            $('select', panel).each(function () {
                $(this).selectpicker('deselectAll');
            });

            let table = $('#data-table');
            if (table.hasClass('chemical')) {
                $('input[name="group"]').prop('checked', true);
            }
            table.DataTable().order(table.data('default-order').split('-'));
            table.DataTable().draw();
        });

    /*
     * Auto complete vie typeahead and Bloodhound
     */
    let obj = $('input.typeahead');
    if (obj.length) {
        $.ajax({
            type: 'get',
            url: '/resource/autocomplete',
            headers: {'X-CSRF-Token': _token},
            data: {type: window.location.pathname.substring(1).split('/', 3)[0]},
            success: function (data) {
                let bh = new Bloodhound({
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
     * Update user profile settings
     */
    $('#user-profile').on('change', 'select, :checkbox', function (e) {
        let el = $(this),
            key = el.attr('name');

        $.ajax({
            type: 'patch',
            url: $(e.delegateTarget).data('url'),
            headers: {'X-CSRF-Token': _token},
            data: {
                key: key,
                value: (el[0].nodeName.toLocaleLowerCase() === 'select') ? el.val() : (el.is(':checked') ? 1 : 0)
            },
            success: function (data) {
                if (key === 'lang')
                    location.reload();
                else
                    new Notify(data.message.type, data.message.text);
            }
        });
    });

    /*
     * Chemicals
     */

    /*
     * Show modal for Chemical items multi-move
     */
    $('#chemical-item-move-modal')
        .on('show.bs.modal', function () {
            $(this).find('.modal-body blockquote span').text(window.LaravelDataTables['data-table'].getSelected('item_id').length);
        })
        .on('submit', 'form#move', function (e) {
            e.preventDefault();
            let modal = $(e.delegateTarget),
                dt = window.LaravelDataTables['data-table'],
                id = dt.getSelected('item_id');

            if (id.length <= 0) {
                new Notify('notice', 'No items were selected');
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
                        new Notify(data.message.type, data.message.text);
                    }
                },
                error: function (data) {
                    new Notify('error', data.responseJSON.errors);
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
        let type = $(this).attr('name');

        if (type === 'close')
            return;

        if (type === 'sigma-aldrich' || type === 'all-data') {
            let catalogId = $.trim($('#catalog_id').val());
            if (catalogId === '') {
                new Notify('notice', 'Fill valid vendor catalog ID!');
                return;
            }

            //$('#chemical-data-icon').addClass('fa-spin');
            $('#spinner').show();
            $.getJSON('/chemical/ajax/parse', {catalog_id: catalogId, callback: 'sigma-aldrich'/*type*/})
                .done(function (data) {
                    if (data.brand_id === 0) {
                        new Notify('notice', 'Chemical with entered vendor ID not found!');
                        return;
                    }

                    for (let key in data) {
                        if (!data.hasOwnProperty(key))
                            continue;

                        let el = $('#' + key);
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
                        $('#spinner').hide();
                    //$('#chemical-data-icon').removeClass('fa-spin');
                });
        } else if (type === 'cactus-nci') {
            getAllCactusData();
        } else {
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

    $('#chemical')
        .on('click', 'a#toggle-tab-structure', function () {
            setTimeout(function () {
                $('iframe#ketcher').renderStructure('molecule', $('#sdf').val());
            }, 50);
        })
        .on('click', '#structure-data-open, #structure-sketcher-open', function (e) {
            e.preventDefault()
        });

    // Show modal with letious structure data
    $('#structure-data-modal').on('show.bs.modal', function (e) {
        let button = $(e.relatedTarget),
            modal = $(this);

        modal.find('.modal-body code').html($('#' + button.data('structure')).val().replace(/\n/g, "<br>"));
    });

    $('#structure-sketcher-modal')
    // Show modal with chemical structure editor
        .on('shown.bs.modal', function () {
            let ketcher = $('iframe#ketcher').ketcher(),
                sdf = toSdf($('#sdf').val());

            if (sdf === false)
                return;

            ketcher.setMolecule(sdf);
        })
        // Submit chemical structure for saving to DB
        .on('click', '#structure-sketcher-submit', function (e) {
            e.preventDefault();
            let modal = $(e.delegateTarget),
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
            let button = $(e.relatedTarget),
                modal = $(this);

            $('input', modal).each(function () {
                let name = $(this).attr('name');
                $(this).val(button.data(name));

                if (name === 'amount') {
                    $(this).focus();
                }
            });

            if (button.data('id') === undefined) {
                $('select', modal).each(function () {
                    $(this).find('option:first-child').attr('selected', 'selected');
                    $(this).selectpicker('render');

                    if ($(this).attr('name') === 'count') {
                        $(this).closest('div.col').removeClass('d-none').addClass('d-inline-flex');
                    }
                });
            } else {
                $('select[name=count]', modal).closest('div.col').removeClass('d-inline-flex').addClass('d-none');
                $('select[name=store_id]', modal).selectpicker('val', button.data('store_id'));
                $('select[name=unit]', modal).selectpicker('val', button.data('unit'));
                $('select[name=owner_id]', modal).selectpicker('val', button.data('owner_id') ? button.data('owner_id') : null);
            }

        })
        // Chemical Item store/update actions
        .on('submit', '#chemical-item-form', function (e) {
            e.preventDefault();
            let form = $(this),
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
                    new Notify('error', data.responseJSON.errors);
                }
            });
        });

    $('#chemical-search-sketcher-modal')
        .on('shown.bs.modal', function () {
            $('iframe#ketcher').ketcher().setMolecule(_sdfSearch);
        })
        .on('click', '#chemical-search-sketcher-submit', function (e) {
            e.preventDefault();

            let ketcher = $('iframe#ketcher').ketcher(),
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
    cas = (typeof (cas) === 'undefined') ? $('#cas').val() : cas;
    name = (typeof (name) === 'undefined') ? $('#name').val() : name;
    let delay = 1;

    if (cas === '') {
        if (name === '') {
            new Notify('notice', 'Fill at least CAS or name of the chemical (both to increase the chance of getting requested data)');
            return;
        } else {
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
    let cas = $('#cas').val().split(';')[0],
        name = $('#name').val().replace('(+)-', '').replace('(−)-', '').replace('(±)-', ''),
        skipCas = false;

    if (cas === '') {
        if (name === '') {
            new Notify('notice', 'Fill at least CAS or name of the chemical (both to increase the chance of getting requested data)');
            return;
        } else
            skipCas = true;
    }

    let url = 'https://cactus.nci.nih.gov/chemical/structure';
    if (type === 'sdf')
        url += '?operator=remove_hydrogens';

    //$('#chemical-data-icon').addClass('fa-spin');
    $('#spinner').show();
    $.get(url, {string: skipCas ? name : cas, representation: type})
        .done(function (data) {
            fillCactusData(type, data);
            $('#spinner').hide();
            //$('#chemical-data-icon').removeClass('fa-spin');
        })
        .fail(function () {
            if (skipCas)
                return;

            $.get(url, {string: name, representation: type})
                .done(function (data) {
                    fillCactusData(type, data);
                })
                .always(function () {
                    //$('#chemical-data-icon').removeClass('fa-spin');
                    $('#spinner').hide();
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
            let strip = (type === 'stdinchikey') ? 'InChIKey=' : 'InChI=';
            $('#' + type.replace('std', '')).val(data.replace(strip, ''));
            break;
        }
    }
}

function brandCheck() {
    let catalogId = $('#catalog_id'),
        brandId = $('#brand_id');

    if (catalogId.val() === '')
        return;

    $.get('/chemical/ajax/check-brand', {
        catalog_id: $.trim(catalogId.val()),
        brand_id: brandId.val(),
        except: $('#id').val()
    }).done(function (data) {
        if (data.msg !== 'valid') {
            new Notify('notice', data.msg, true);
        }
    }).fail(function (data) {
        new Notify('error', data.responseJSON.errors, true);
    });

}

(function ($) {
    $.fn.scrollTo = function (speed) {
        speed = (typeof speed === 'undefined') ? 1000 : speed;
        $('html, body').animate({
            scrollTop: this.offset().top
        }, speed);
    };

    $.fn.ketcher = function () {
        if (this[0] === 'undefined' || typeof (this[0]) === 'undefined')
            return false;

        if ('contentDocument' in this[0])
            return this[0].contentWindow.ketcher;
        else // IE7
            return document.frames[this.attr('id')].window.ketcher;
    };

    $.fn.renderStructure = function (id, data) {
        let object = $('#' + id);
        if (!object.length)
            return false;

        let ketcher = this.ketcher();
        let sdf = toSdf(data);

        if (!ketcher) {
            console.log('no ketcher');
            return false;
        }

        if (sdf === false) {
            console.log('no sdf data');
            return false;
        }

        // Remove previous svg render
        object.html("");

        ketcher.showMolfile(object[0], sdf, {
            bondLength: 20,
            autoScale: true,
            autoScaleMargin: 35,
            ignoreMouseEvents: true,
            atomColoring: true
        });
    };

    $.fn.dataTable.Api.register('getSelected()', function (field) {
        let id = [];
        if (field === 'id') {
            id = this.rows({selected: true}).data().pluck(field).toArray();
        } else {
            this.rows({selected: true}).data().each(function (data) {
                if (data[field] !== null)
                    $.merge(id, String(data[field]).split(';'));
            });
        }
        return id;
    });
}(jQuery));

function toSdf(sdf) {

    let aSdf = sdf.split('\n');
    if (aSdf.length < 4)
        return false;

    return aSdf[3].toUpperCase().indexOf('V2000') === -1 ? '\n' + sdf : sdf;
};
