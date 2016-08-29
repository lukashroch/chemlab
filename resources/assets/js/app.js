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
    $(main).on('click', 'a.delete, button.delete', function (event) {
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

    // Trim form text fields
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
                obj.catcomplete({delay: 300, minLength: 3, source: data.all});
            });
    }
    else {
        var path = window.location.pathname.substring(1).split('/', 3);
        if (path[0] == 'chemical' && path[1] == 'search') {
            $.getJSON('/ajax/autocomplete', {type: path[0]})
                .done(function (data) {
                    $('input[name=name]').autocomplete({delay: 300, minLength: 3, source: data.name});
                    $('input[name=cas]').autocomplete({delay: 300, minLength: 3, source: data.cas});
                    $('input[name=brand_no]').autocomplete({delay: 300, minLength: 3, source: data.brandId});
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
        var type = $(this).attr('name');

        if (type == 'close')
            return;

        if (type == 'sigmaAldrich' || type == 'all-data') {
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

                    $('#symbol').selectpicker('val', data.symbol);
                    $('#h').selectpicker('val', data.h);
                    $('#p').selectpicker('val', data.p);
                    if (data.signal_word != '')
                        $('#signal_word').val(data.signal_word);

                    brandCheck();
                })
                .always(function (data) {
                    if (type == 'all-data' && data.state == 'valid')
                        getAllCactusData(data.cas, data.name);
                    else
                        $('#chemical-data-icon').removeClass('fa-spin');
                });
        }
        else if (type == 'cactusNCI') {
            getAllCactusData();
        }
        else {
            getCactusData(type);
            if (type == 'sdf') {
                getCactusData('smiles');
                getCactusData('stdinchikey');
                getCactusData('stdinchi');
            }
        }
    });

    // Load chemical structure to the sketcher
    $('#structure-render').on('load', function () {
        $('#structure-render').renderStructure($('#sdf').val());
    });

    // Show modal with various structure data
    $('#structure-data-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('.modal-title').text(button.html());
        modal.find('.modal-body code').html($('#' + button.data('structure')).val().replace(/\n/g, "<br>"));
    });

    // Show modal with chemical structure editor
    $('#structure-sketcher-modal').on('shown.bs.modal', function () {
        var ketcher = $('#structure-sketcher').ketcher();
        ketcher.init();
        ketcher.setMolecule($('#sdf').val());
    });

    // Submit chemical structure for saving to DB
    $('#structure-sketcher-modal').on('click', '#structure-sketcher-submit', function (event) {
        event.preventDefault();

        var ketcher = $('#structure-sketcher').ketcher();
        var smiles = ketcher.getSmiles();
        var sdf = ketcher.getMolfile();

        if (smiles == '') {
            alert('Draw the structure before submitting the query!');
            return false;
        }

        $('#structure-render').renderStructure(sdf);
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

    // Show modal for Chemical Item create/edit actions
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

    // Chemical Item store/update actions
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

    // Reset search form fields
    $('#chemical-search').on('click', 'input[type=reset]', function (event) {
        event.preventDefault();

        $('input[type=text], input[type=date], select, input[type=hidden]').each(function () {
            $(this).val('');
        });

        $('#store_id').selectpicker('deselectAll');
        $.getJSON('/ajax/sdf', {action: 'cache-reset', trans: 'chemical.structure.draw'})
            .done(function (data) {
                $('#chemical-sketcher-open').text(data.trans);
            });
    });

    $('#chemical-search-sketcher-modal').on('shown.bs.modal', function () {
        var ketcher = $('#structure-sketcher').ketcher();
        ketcher.init();

        $.getJSON('/ajax/sdf', {action: 'cache-load'})
            .done(function (data) {
                ketcher.setMolecule(data.sdf);
            });
    });

    $('#chemical-search-sketcher-modal').on('click', '#chemical-search-sketcher-submit', function (event) {
        event.preventDefault();

        var ketcher = $('#structure-sketcher').ketcher();
        var smiles = ketcher.getSmiles();
        var sdf = ketcher.getMolfile();

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

function getAllCactusData(cas, name) {
    cas = (typeof(cas) === 'undefined') ? $('#cas').val() : cas;
    name = (typeof(name) === 'undefined') ? $('#name').val() : name;
    var delay = 1;

    if (cas == '') {
        if (name == '') {
            toggleAlert('Fill at least CAS or name of the chemical (both to increase the chance of getting requested data)', true);
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
    var cas = $('#cas').val().split(';')[0];
    var name = $('#name').val().replace('(+)-', '').replace('(−)-', '').replace('(±)-', '');
    var skipCas = false;
    if (cas == '') {
        if (name == '') {
            toggleAlert('Fill at least CAS or name of the chemical (both to increase the chance of getting requested data)', true);
            return;
        }
        else
            skipCas = true;
    }

    var url = 'https://cactus.nci.nih.gov/chemical/structure';
    if (type == 'sdf')
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
        case 'iupac_name':
        case 'mw':
        case 'formula':
        case 'smiles': {
            $('#' + type).val(data);
            break;
        }
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
            $('#structure-render').renderStructure(data);
            break;
        }
        case 'stdinchikey':
        case 'stdinchi': {
            var strip = (type == 'stdinchikey') ? 'InChIKey=' : 'InChI=';
            $('#' + type.replace('std', '')).val(data.replace(strip, ''));
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
        + str + '<a class=\"close pull-right common-alert-close\"><span class=\"fa fa-common-alert-close\" aria-hidden=\"true\" title=\"Close\"></span></a></div>';
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
            alert.slideUp(500).delay(500).remove();
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

(function ($) {

    $.fn.createAlert = function (text, type) {
        return $('<div class=\"alert alert-' + type + ' alert-dismissible alert-hidden\"><span class=\"fa fa-common-alert-danger\" aria-hidden=\"true\"></span> '
            + text + '<a class=\"close pull-right common-alert-close\"><span class=\"fa fa-common-alert-close\" aria-hidden=\"true\" title=\"Close\"></span></a></div>');
    };

    $.fn.toggleAlert = function (show) {
        if (show) {
            this.remove();
            $('div.page-header').after(str);
            $('div.alert').slideDown(500);
        }
        else {
            alert = $('div.alert');
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

    $.fn.renderStructure = function (data) {
        var ketcher = this.ketcher();
        if (!ketcher) {
            console.log('no ketcher');
            return;
        }

        ketcher.showMolfileOpts('molecule', data, 100, {
            'autoScale': true,
            'autoScaleMargin': 50,
            'ignoreMouseEvents': true,
            'atomColoring': true
        });
    };

}(jQuery));
