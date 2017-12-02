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
        'resources/assets/js/vendor/bootstrap-select.js',
        'resources/assets/js/vendor/datatables.js',
        'node_modules/typeahead.js/dist/typeahead.jquery.js',
        'node_modules/typeahead.js/dist/bloodhound.js',
        'resources/assets/js/bootstrap-treeview.js',
        'resources/assets/js/app.js'
    ], 'public/js/scripts.js')
    .sass('resources/assets/sass/app.scss', 'public/css/styles.css');

if (mix.inProduction) {
    mix.version();
}
