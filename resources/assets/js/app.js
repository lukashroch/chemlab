$(document).ready(function () {
    /*$.ajaxSetup({
     headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
     crossDomain: true
     });*/

    //////////// GENERAL ///////////
    $('form').on('submit', function (event) {
        var stopSubmit = stopSubmitForm();
        var form = $(this);

        // trim text fields
        $("form input[type=text]").each(function () {
            $(this).val($.trim($(this).val()));
        });

        // Additional checks
        if (stopSubmit == false) {
            // Save structure on form submit
            if (form.attr('id') == "chemical-form") {
                $('#sdf').val(ketcherExport('sketcher', 'mol'));
                $('#smiles').val(ketcherExport('sketcher', 'smiles'));
            }
        }
        if (stopSubmit)
            event.preventDefault();
    });

    // Remove button/method
    $('a.remove').on('click', function (event) {
        event.preventDefault();

        if (!confirm($(this).data('confirm')))
            return false;

        var action = $(this).data('action');
        var parent = $(this).parent();
        $.ajax({
            type: 'delete',
            url: action,
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            crossDomain: true,
            /*data: '_token=' + token,*/
            success: function (data) {
                if (data.state == "deleted") {
                    window.location.replace(data.redirect);
                }
                else {
                    $('div.page-header').after(data.flash);
                    $('div.alert').slideDown(500);
                }
            }
        });
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

    // Remove notification
    $('#main').on('click', 'a.common-alert-close', function () {
        var flashmsg = $(this).closest('div.alert');
        flashmsg.slideUp(500);
        setTimeout(function () {
            flashmsg.remove();
        }, 500);
    });

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

    // Settings
    $('#user-profile-settings').on('change', 'select', function (event) {
        var type = $(this).attr('name');
        /*$.post('/ajax/user/settings', {type: type, value: $(this).val()})
         .done(function () {
         if (type == 'lang')
         location.reload();
         });*/

        $.ajax({
            type: 'post',
            url: '/ajax/user/settings',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            crossDomain: true,
            data: {type: type, value: $(this).val()},
            success: function (data) {
                if (type == 'lang')
                    location.reload();
            }
        });
    });

    ////////// CHEMICALS //////////

    // Check Brand Id availability
    $('#chemical-edit').on('change', '#brand_id, #brand_no', function (event) {
        brandCheck();
    });

    // Data parsing
    $('#chemical-data-menu').on('click', 'a', function (event) {
        event.preventDefault();
        var dataType = $(this).attr('name');

        if (dataType == 'close')
            return;

        if (dataType == 'sigmaAldrich' || dataType == 'all-data') {
            if ($('#brand_no').val() == '') {
                toggleAlert('Fill valid Sigma Aldrich Brand ID!', true);
                return;
            }

            $('#chemical-data-icon').addClass('fa-spin');
            $.getJSON('/ajax/sigma', {brand_no: $.trim($('#brand_no').val())})
                .done(function (data) {
                    if (data.state != 'valid') {
                        toggleAlert('Chemical with entered Sigma ID not found!', true);
                        return;
                    }

                    $('#brand_id').val(data.brand_id).attr('selected', true);
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

    // Add / Update / Delete chemical items
    $('#chemical-items').on('click', 'button', function (event) {
        event.preventDefault();
        var object = $(this);
        var action = object.attr('name');
        var id = object.attr('id');

        var amount = $.trim($('#amount-' + id).val()).replace(',', '.');
        if (action != 'chemical-item-delete' && (!$.isNumeric(amount) || amount <= 0)) {
            alert('Amount should be number greater than zero!');
            return;
        }

        $.getJSON("/ajax/chemical-item", {
                action: action,
                id: id,
                chemical_id: $("#id").val(),
                store_id: $("#store-" + id).val(),
                amount: amount,
                unit: $("#unit-" + id).val(),
                count: $("#count-" + id).val()
            })
            .done(function (data) {
                if (data.state != "valid") {
                    alert('Something went wrong. Please try again');
                    return;
                }

                if (action == "chemical-item-save") {
                    var savedIcon = $("<span class=\"fa fa-chemical-item-saved\" aria-hidden=\"true\" title=\"Chemical saved\" alt=\"Chemical saved\"></span>");
                    var returnIcon = $("<span class=\"fa fa-chemical-item-save\" aria-hidden=\"true\" title=\"Save\" alt=\"Save\"></span>");
                    object.html(savedIcon);
                    setTimeout(function () {
                        object.html(returnIcon);
                    }, 4000);
                }
                else if (action == "chemical-item-delete")
                    $('tr.' + id).remove();
                else if (action == "chemical-item-add") {
                    $('tr.chemical-item-add').before(data.msg);
                    $('#amount-add').val('');
                }
            });
    });

    // Load chemical structure to the sketcher
    $('#structure-render').load(function () {
        /*if ($(location).attr('pathname') == '/chemical/search' || $('#id').val() == '')
         return;*/

        loadToSketcher('structure-render', $('#sdf').val());
    });

    $('#structure-data-modal').on('shown.bs.modal', function (event) {
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

        $('#chemical-search-sketcher-submit span').addClass('fa-spin');
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
                $('#chemical-search-sketcher-submit span').removeClass('fa-spin');
            });
    });
});

function getAllCactusData() {
    if ($('#name').val() == '' && $('#cas').val() == '') {
        toggleAlert('Fill at least CAS or name of the chemical (both to increase the chance of getting requested data)', true);
        return;
    }

    if ($('#cas').val() == '' && $('#name').val() != '')
        getCactusData('cas');

    if ($('#cas').val() != '' || $('#name').val() != '') {
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

function toggleAlert(string, show) {
    string = '<div class=\"alert alert-danger alert-dismissible alert-hidden\"><span class=\"fa fa-common-alert-danger\" aria-hidden=\"true\"></span> ' + string + '<a class=\"close pull-right common-alert-close\" href=\"#\"><span class=\"fa fa-common-alert-close\" aria-hidden=\"true\" title=\"Close\" alt=\"Close\"></span></a></div>';

    if (show) {
        $('div.alert').remove();
        $('div.page-header').after(string);
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
