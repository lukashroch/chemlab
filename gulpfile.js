var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss', 'resources/assets/css');

    mix.styles([
        'jquery-ui-1.12.0.css',
        'app.css'
    ], 'public/css/styles.css');

    mix.scripts([
        'jquery-3.1.0.js',
        'jquery-ui-1.12.0.js',
        'bootstrap.js',
        'bootstrap-select.js',
        'bootstrap-treeview.js',
        'app.js'
    ], 'public/js/scripts.js');

    /*// Ketcher Render JS library
    mix.scripts([
        'raphael.js',
        'util/common.js',
        'util/vec2.js',
        'util/set.js',
        'util/map.js',
        'util/pool.js',
        'chem/element.js',
        'chem/sgroup.js',
        'chem/struct.js',
        'chem/struct_valence.js',
        'chem/molfile.js',
        'prototype-min.js',
        'chem/dfs.js',
        'chem/smiles.js',
        'rnd/visel.js',
        'rnd/restruct.js',
        'rnd/restruct_rendering.js',
        'rnd/render.js',
        'ketcher.js'
    ], 'public/vendor/ketcher/ketcher_render.min.js', 'public/vendor/ketcher');

    // Ketcher Editor JS library
    mix.scripts([
        'prototype-min.js',
        'raphael.js',
        'base64.js',
        'third_party/keymaster.js',
        'util/common.js',
        'util/vec2.js',
        'util/set.js',
        'util/map.js',
        'util/pool.js',
        'chem/element.js',
        'chem/struct.js',
        'chem/molfile.js',
        'chem/sgroup.js',
        'chem/struct_valence.js',
        'chem/dfs.js',
        'chem/cis_trans.js',
        'chem/stereocenters.js',
        'chem/smiles.js',
        'chem/inchi.js',
        'rnd/visel.js',
        'rnd/restruct.js',
        'rnd/restruct_rendering.js',
        'rnd/render.js',
        'rnd/templates.js',
        'rnd/editor.js',
        'rnd/elem_table.js',
        'rnd/rgroup_table.js',
        'ui/ui.js',
        'ui/actions.js',
        'reaxys/reaxys.js',
        'ketcher.js'
    ], 'public/vendor/ketcher/ketcher.min.js', 'public/vendor/ketcher');*/

});
