$(document).ready(function () {
    
    //////////// GENERAL ///////////
    var main = $('#main');


    // Remove Alerts / Notifications
    $(main).on('click', 'a.close', function (event) {
        event.preventDefault();

        var alert = $(this).closest('div.alert');
        alert.slideUp(500);

        setTimeout(function () {
            alert.remove();
        }, 500);
    });

    // Remove Button Method
    $(main).on('click', 'a.delete', function (event) {
        event.preventDefault();

        if (!confirm($(this).data('confirm')))
            return false;

        $.ajax({
            type: 'delete',
            url: $(this).data('action'),
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                if (data.state == true) {
                    window.location.replace(data.url);
                }
                else {
                    $('div.page-header').after(formatAlert(data.alert.type, data.alert.str));
                    $('div.alert').slideDown(500);
                }
            }
        });
    });

    // trim text fields
    $('form').on('submit', function (event) {
        var form = $(this);

        $("form input[type=text]").each(function () {
            $(this).val($.trim($(this).val()));
        });

        if (stopSubmitForm() == true)
            event.preventDefault();
    });

    // Clickable table rows of lists
    $('tr.clickable td:not(.text-center)').click(function (event) {
        if (event.target.nodeName != 'A') {
            event.preventDefault();
            window.location.href = $(this).parents('tr').data('href');
        }
    });

    // Auto Complete
    $.widget("custom.catcomplete", $.ui.autocomplete, {
        _create: function () {
            this._super();
            this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
        },
        _renderMenu: function (ul, items) {
            var that = this,
                currentCategory = "";
            $.each(items, function (index, item) {
                var li;
                if (item.category != currentCategory) {
                    ul.append("<li class='ui-autocomplete-category'>" + item.category + "</li>");
                    currentCategory = item.category;
                }
                li = that._renderItemData(ul, item);
                if (item.category) {
                    li.attr("aria-label", item.category + " : " + item.label);
                }
            });
        }
    });

    // Autocomplete search fields
    var obj = $('input[name=search]');
    if (obj.attr('name') == 'search') {
        $.getJSON('/ajax/autocomplete', {type: window.location.pathname.substring(1).split('/', 3)[0]})
            .done(function (data) {
                obj.catcomplete({delay: 300, minLength: 3, source: data});
            });
    }
    else {
        var path = window.location.pathname.substring(1).split('/', 3);
        if (path[0] == 'chemical' && path[1] == 'search') {
            if (window.location.hash && window.location.hash.substring(1) == 'sketcherPop')
                setTimeout(function () {
                    $('#chemical-search-sketcher-modal').modal('show');
                }, 50);

            $.getJSON('/ajax/autocomplete', {type: 'chemical-name'})
                .done(function (data) {
                    $('input[name=name]').autocomplete({delay: 300, minLength: 3, source: data});
                });
            $.getJSON('/ajax/autocomplete', {type: 'chemical-cas'})
                .done(function (data) {
                    $('input[name=cas]').autocomplete({delay: 300, minLength: 3, source: data});
                });
            $.getJSON('/ajax/autocomplete', {type: 'chemical-brandid'})
                .done(function (data) {
                    $('input[name=brand_id]').autocomplete({delay: 300, minLength: 3, source: data});
                });
        }
    }

    //////////// ROLES ///////////
    $('#perms-assigned a').not('.disabled').draggable({
        appendTo: 'body',
        revert: 'invalid',
        containment: 'document',
        helper: 'clone',
        cursor: 'move'
    });

    $('#perms-not-assigned a').not('.disabled').draggable({
        appendTo: 'body',
        revert: 'invalid',
        containment: 'document',
        helper: 'clone',
        cursor: 'move'
    });

    $('#role-edit-perms-assigned').droppable({
        accept: '#perms-not-assigned a',
        activeClass: 'ui-state-highlight',
        drop: function (event, ui) {
            $.getJSON('/ajax/perm/attach', {id: $('input[name=id]').val(), perm: ui.draggable.attr('id')});
            $('#perms-assigned').append(ui.draggable);
        }
    });

    $('#role-edit-perms-not-assigned').droppable({
        accept: '#perms-assigned a',
        activeClass: 'ui-state-highlight',
        drop: function (event, ui) {
            $.getJSON('/ajax/perm/detach', {id: $('input[name=id]').val(), perm: ui.draggable.attr('id')});
            $('#perms-not-assigned').append(ui.draggable);
        }
    });

    //////////// USERS ///////////
    $('#roles-assigned a').not('.disabled').draggable({
        appendTo: 'body',
        revert: 'invalid',
        containment: 'document',
        helper: 'clone',
        cursor: 'move'
    });

    $('#roles-not-assigned a').not('.disabled').draggable({
        appendTo: 'body',
        revert: 'invalid',
        containment: 'document',
        helper: 'clone',
        cursor: 'move'
    });

    $('#user-edit-roles-assigned').droppable({
        accept: '#roles-not-assigned a',
        activeClass: 'ui-state-highlight',
        drop: function (event, ui) {
            $.getJSON('/ajax/role/attach', {id: $('input[name=id]').val(), role: ui.draggable.attr('id')});
            $('#roles-assigned').append(ui.draggable);
        }
    });

    $('#user-edit-roles-not-assigned').droppable({
        accept: '#roles-assigned a',
        activeClass: 'ui-state-highlight',
        drop: function (event, ui) {
            $.getJSON('/ajax/role/detach', {id: $('input[name=id]').val(), role: ui.draggable.attr('id')});
            $('#roles-not-assigned').append(ui.draggable);
        }
    });

    // User settings
    $('#user-profile-settings').on('change', 'select', function (event) {
        var type = $(this).attr('name');

        $.ajax({
            type: 'post',
            url: '/ajax/user/settings',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data: {type: type, value: $(this).val()},
            success: function () {
                if (type == 'lang')
                    location.reload();
            }
        });
    });

    ////////// CHEMICALS //////////

    // Check Brand Id availability
    $('#chemical-edit').on('change', '#brand_id, #brand_no', function () {
        brandCheck();
    });

    // Data parsing from Sigma Aldrich / Cactus NCI
    $('#chemical-data-menu').on('click', 'a', function (event) {
        event.preventDefault();
        var dataType = $(this).attr('name');

        if (dataType == 'close')
            return;

        if (dataType == 'sigmaAldrich' || dataType == 'all-data') {
            var brandNo = $.trim($('#brand_no').val());
            if (brandNo == '') {
                toggleAlert('Fill valid Sigma Aldrich Brand ID!', true);
                return;
            }

            $('#chemical-data-icon').addClass('fa-spin');
            $.getJSON('/ajax/sigma', {brand_no: brandNo})
                .done(function (data) {
                    if (data.state != 'valid') {
                        toggleAlert('Chemical with entered Sigma ID not found!', true);
                        return;
                    }

                    //$('#brand_id').val(data.brand_id).attr('selected', 'selected');
                    $('#brand_id').selectpicker('val', data.brand_id);
                    if (data.name != '')
                        $('#name').val(data.name);
                    if (data.synonym != '')
                        $('#synonym').val(data.synonym);
                    if (data.cas != '')
                        $('#cas').val(data.cas);
                    if (data.pubchem != '')
                        $('#pubchem').val(data.pubchem);
                    if (data.description != '')
                        $('#description').val(data.description);

                    brandCheck();
                })
                .always(function (data) {
                    if (dataType == 'all-data' && data.state == 'valid')
                        getAllCactusData();
                    else
                        $('#chemical-data-icon').removeClass('fa-spin');
                });
        }
        else if (dataType == 'cactusNCI') {
            getAllCactusData();
        }
        else {
            getCactusData(dataType);
            if (dataType == 'sdf') {
                getCactusData('smiles');
                getCactusData('stdinchikey');
                getCactusData('stdinchi');
            }
        }
    });

    // Load chemical structure to the sketcher
    $('#structure-render').load(function () {
        loadToSketcher('structure-render', $('#sdf').val());
    });

    $('#structure-data-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('.modal-title').text(button.html());
        modal.find('.modal-body code').html($('#' + button.data('structure')).val().replace(/\n/g, "<br>"));
    });

    $('#structure-sketcher-modal').on('shown.bs.modal', function (event) {
        var ketcher = getKetcher('structure-sketcher');
        if (!ketcher)
            return;

        ketcher.init();
        ketcher.setMolecule($('#sdf').val());
    });

    $('#structure-sketcher-modal').on('click', '#structure-sketcher-submit', function (event) {
        event.preventDefault();
        var smiles = ketcherExport('structure-sketcher', 'smiles');
        var sdf = ketcherExport('structure-sketcher', 'mol');

        if (smiles == '') {
            alert('Draw the structure before submitting the query!');
            return false;
        }

        loadToSketcher('structure-render', sdf);
        $('#smiles').val(smiles);
        $('#sdf').val(sdf);

        $('#structure-sketcher-modal').modal('hide');

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


    // Chemical Item Create/Edit Modal
    $('#chemical-item-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);

        $('input', modal).each(function () {
            var name = $(this).attr('name');
            $(this, modal).val(button.data(name));
            if (name == 'amount')
                $(this).focus();
        });

        if (button.data('id') == null) {
            $('select', modal).each(function () {
                $(this).find('option:first-child').attr("selected", "selected");
                $(this).selectpicker('render');

                if ($(this).attr('name') == 'count') {
                    $(this).closest('div.input-group').removeClass('hidden');
                }
            });
        } else {
            $('select[name=count]', modal).closest('div.input-group').addClass('hidden');
            $('select[name=store_id]', modal).selectpicker('val', button.data('store_id'));
            $('select[name=unit]', modal).selectpicker('val', button.data('unit'));
        }

    });

    // Chemical Item Store/Update
    $('#chemical-item-modal').on('click', '#chemical-item-save', function (event) {
        event.preventDefault();
        var form = $('#chemical-item-form');
        var button = $(this);
        var id = $('input[name=id]', form).val();
        $('input[name=amount]').val().replace(',', '.');
        var type = 'post';
        var url = '/chemical/item';
        if (id != '') {
            type = 'patch';
            url = '/chemical/item/' + id;
        }

        $.ajax({
            type: type,
            url: url,
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data: form.serialize(),
            success: function (data) {
                if (id == '')
                    $('#chemical-items').find('tbody').prepend(data.str);
                else
                    $('#chemical-items').find('tbody tr.' + id).replaceWith(data.str);

                $('#chemical-item-modal').modal('hide');
            },
            error: function (data) {
                var errors = '';
                for (key in data.responseJSON) {
                    errors += formatAlert('danger', data.responseJSON[key]);
                }
                $('div.modal-body').prepend(errors);
                $('div.alert').slideDown(500);
            }
        });
    });

    // Chemical Item Delete
    $('#chemical-items').on('click', '#chemical-item-delete', function (event) {
        event.preventDefault();
        var button = $(this);

        if (!confirm(button.data('confirm')))
            return false;

        $.ajax({
            type: 'delete',
            url: '/chemical/item/' + button.data('id'),
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            success: function () {
                button.closest('tr').remove();
            }
        });
    });

    /************************
     **** CHEMICAL SEARCH ****
     ************************/

        // Update store list on department change
    $('#chemical-search').on('change', '#department', function () {
        $.getJSON('/ajax/storelist', {department: $('#department').val()})
            .done(function (data) {
                $('#store').empty().append(data);
            });
    });

    // Reset search form fields
    $('#chemical-search').on('click', 'input[type=reset]', function (event) {
        event.preventDefault();

        $('input[type=text], input[type=date], select, input[type=hidden]').each(function () {
            $(this).val('');
        });

        $('#department').trigger('change');
        $.getJSON('/ajax/sdf', {action: 'cache-reset', trans: 'chemical.structure.draw'})
            .done(function (data) {
                $('#chemical-sketcher-open').text(data.trans);
            });
    });

    $('#chemical-search-sketcher-modal').on('shown.bs.modal', function (event) {
        var ketcher = getKetcher('structure-sketcher');
        if (!ketcher)
            return;

        ketcher.init();
        $.getJSON('/ajax/sdf', {action: 'cache-load'})
            .done(function (data) {
                ketcher.setMolecule(data.sdf);
            });
    });

    $('#chemical-search-sketcher-modal').on('click', '#chemical-search-sketcher-submit', function (event) {
        event.preventDefault();
        var smiles = ketcherExport('structure-sketcher', 'smiles');
        var sdf = ketcherExport('structure-sketcher', 'mol');

        if (smiles == '') {
            alert('Draw the structure before submitting the query!');
            return false;
        }

        $('#chemical-search-sketcher-submit').find('span').addClass('fa-spin');
        $.get('https://cactus.nci.nih.gov/chemical/structure', {
                string: smiles,
                representation: 'stdinchikey'
            })
            .done(function (inchikey) {
                inchikey = inchikey.replace('InChIKey=', '');
                $.getJSON('/ajax/sdf', {
                        action: 'cache-save',
                        sdf: sdf,
                        inchikey: inchikey,
                        trans: 'chemical.structure.edit'
                    })
                    .done(function (data) {
                        $('#chemical-search-sketcher-open').text(data.trans);
                    });

                $('input[name=inchikey]').val(inchikey);
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

function getAllCactusData() {
    var name = $('#name').val();
    var cas = $('#cas').val();

    if (cas == '' && name == '') {
        toggleAlert('Fill at least CAS or name of the chemical (both to increase the chance of getting requested data)', true);
        return;
    }

    if (cas == '' && name != '')
        getCactusData('cas');

    if (cas != '' || name != '') {
        getCactusData('iupac_name');
        getCactusData('chemspider_id');
        getCactusData('mw');
        getCactusData('formula');
        getCactusData('sdf');
        getCactusData('smiles');
        getCactusData('stdinchikey');
        getCactusData('stdinchi');
    }
}

function getCactusData(dataType) {
    var cas = $('#cas').val().split(';')[0];
    var name = $('#name').val().replace(' ', '%20').replace('(+)-', '').replace('(−)-', '').replace('(±)-', '');
    if (cas == '' && name == '') {
        toggleAlert('Fill at least CAS or name of the chemical (both to increase the chance of getting requested data)', true);
        return;
    }

    var url = dataType == 'sdf' ? 'https://cactus.nci.nih.gov/chemical/structure?operator=remove_hydrogens' : 'https://cactus.nci.nih.gov/chemical/structure';
    $('#chemical-data-icon').addClass('fa-spin');
    $.get(url, {string: cas, representation: dataType})
        .done(function (data) {
            fillCactusData(dataType, data);
            $('#chemical-data-icon').removeClass('fa-spin');
        })
        .fail(function () {
            $.get(url, {string: name, representation: dataType})
                .done(function (data) {
                    fillCactusData(dataType, data);
                })
                .always(function () {
                    $('#chemical-data-icon').removeClass('fa-spin');
                });
        });
}

function fillCactusData(dataType, data) {
    // check to prevent inserting invalid data
    if (data.indexOf('<!DOCTYPE') !== -1)
        return;

    switch (dataType) {
        case 'iupac_name':
        case 'mw':
        case 'formula':
        case 'smiles':
        {
            $('#' + dataType).val(data);
            break;
        }
        case 'cas':
        {
            $('#' + dataType).val(data.split('\n').join(';'));
            break;
        }
        case 'chemspider_id':
        {
            $('#' + dataType.replace('_id', '')).val(data.split('\n').join(';'));
            break;
        }
        case 'sdf':
        {
            $('#' + dataType).val(data);
            loadToSketcher('structure-render', data);
            break;
        }
        case 'stdinchikey':
        case 'stdinchi':
        {
            var strip = dataType == 'stdinchikey' ? 'InChIKey=' : 'InChI=';
            $('#' + dataType.replace('std', '')).val(data.replace(strip, ''));
            break;
        }
    }
}

function brandCheck() {
    var brandNo = $('#brand_no');
    var brandId = $('#brand_id');

    if (brandNo.val() == '')
        return;

    $.get('/ajax/brand', {id: $('#id').val(), brand_no: brandNo.val(), brand_id: brandId.val()})
        .done(function (data) {
            var state = data != 'valid';
            toggleAlert(data, state);
            brandNo.closest("div.form-group").toggleClass('has-error', state);
            brandId.closest("div.form-group").toggleClass('has-error', state);
        });
}

function formatAlert(type, str) {
    return '<div class=\"alert alert-' + type + ' alert-dismissible alert-hidden\"><span class=\"fa fa-common-alert-danger\" aria-hidden=\"true\"></span> '
        + str + '<a class=\"close pull-right common-alert-close\"><span class=\"fa fa-common-alert-close\" aria-hidden=\"true\" title=\"Close\" alt=\"Close\"></span></a></div>';
}

function toggleAlert(str, show) {
    str = formatAlert('danger', str);

    if (show) {
        $('div.alert').remove();
        $('div.page-header').after(str);
        $('div.alert').slideDown(500);
    }
    else {
        alert = $('div.alert');
        if (alert.is(":visible")) {
            alert.slideUp(500);
            setTimeout(function () {
                alert.remove();
            }, 500);
        }
    }
}

function stopSubmitForm() {
    var stopSubmit = false;
    $('input.due').each(function () {
        $(this).closest("div.form-group").removeClass('has-error');
        if (!$(this).val()) {
            stopSubmit = true;
            $(this).closest("div.form-group").addClass('has-error');
        }
    });
    return stopSubmit;
}

function loadToSketcher(id, data) {
    switch (id) {
        case 'structure-sketcher':
            ketcherImport(id, data);
            break;
        case 'structure-render':
            win = document.getElementById(id).contentWindow || document.frames[id];
            win.renderStrucuture(data);
            break;
    }
}

function getKetcher(id) {
    var ketcherFrame = document.getElementById(id);

    if ('contentDocument' in ketcherFrame)
        return ketcherFrame.contentWindow.ketcher;
    else // IE7
        return document.frames[id].window.ketcher;
}

function ketcherImport(id, data) {
    var ketcher = getKetcher(id);
    if (ketcher)
        ketcher.setMolecule(data);
}

function ketcherExport(id, format) {
    var ketcher = getKetcher(id);
    if (ketcher)
        return format == 'mol' ? ketcher.getMolfile() : ketcher.getSmiles();
    else
        return '';
}
