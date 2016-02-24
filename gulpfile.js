var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss', 'resources/assets/css');

    mix.styles([
        'jquery-ui-1.11.4.css',
        'app.css'
    ], 'public/css/styles.css');

    mix.scripts([
        'jquery-2.2.0.min.js',
        'jquery-ui-1.11.4.min.js',
        'bootstrap.min.js',
        'app.js'
    ], 'public/js/scripts.js');

});
