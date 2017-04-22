const elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;

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
        'jquery-ui.css',
        'datatables.css',
        'app.css'
    ], 'public/css/styles.css');

    mix.scripts([
        'vendor/jquery-3.2.1.js',
        'vendor/jquery-ui.js',
        'vendor/bootstrap.js',
        'vendor/bootstrap-select.js',
        'vendor/datatables.js',
        'bootstrap-treeview.js',
        'app.js'
    ], 'public/js/scripts.js');

    /*mix.webpack(
        'app.js', 'public/js/scripts.js');*/

});
