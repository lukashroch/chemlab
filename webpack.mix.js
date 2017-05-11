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
        'resources/assets/js/vendor/jquery-3.2.1.js',
        'resources/assets/js/vendor/bootstrap.js',
        'resources/assets/js/vendor/bootstrap-select.js',
        'resources/assets/js/vendor/datatables.js',
        'resources/assets/js/vendor/typeahead.jquery.js',
        'resources/assets/js/vendor/bloodhound.js',
        'resources/assets/js/bootstrap-treeview.js',
        'resources/assets/js/app.js'
    ], 'public/js/scripts.js')
    .sass('resources/assets/sass/app.scss', 'public/css/styles.css');

if (mix.config.inProduction) {
    mix.version();
}
