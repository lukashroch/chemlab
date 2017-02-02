const {mix} = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js').extract(['jquery', 'bootstrap-sass', 'bootstrap-select', 'datatables.net'])
    /*.combine([
        'resources/assets/js/vendor/jquery-ui.js',
        'resources/assets/js/vendor/bootstrap.js',
        'resources/assets/js/vendor/bootstrap-select.js',
        'resources/assets/js/vendor/datatables.js',
        'resources/assets/js/bootstrap-treeview.js'
    ], 'public/js/vendor.js')*/
    .sass('resources/assets/sass/app.scss', 'resources/assets/css')
    .combine([
        'resources/assets/css/jquery-ui.css',
        'resources/assets/css/datatables.css',
        'resources/assets/css/app.css'
    ], 'public/css/styles.css');
