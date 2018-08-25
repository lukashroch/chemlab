let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.scripts(
    [
        'node_modules/jquery/dist/jquery.js',
        'node_modules/popper.js/dist/umd/popper.js',
        'node_modules/bootstrap/dist/js/bootstrap.js',
        'node_modules/bootstrap-select/js/bootstrap-select.js',
        'node_modules/bootstrap-select/js/i18n/defaults-cs_CZ.js',
        'node_modules/admin-lte/dist/js/adminlte.js',
        'node_modules/pnotify/dist/iife/PNotify.js',
        'node_modules/pnotify/dist/iife/PNotifyButtons.js',
        'node_modules/typeahead.js/dist/typeahead.jquery.js',
        'node_modules/typeahead.js/dist/bloodhound.js',
        'resources/js/vendor/datatables.js',
        'resources/js/bootstrap-treeview.js',
        'resources/js/app.js'
    ], 'public/js/scripts.js')
    .sass('resources/scss/app.scss', 'public/css/styles.css');

if (mix.inProduction) {
    mix.version();
}
