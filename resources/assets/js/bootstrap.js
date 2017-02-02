window._ = require('lodash');

window.$ = window.jQuery = require('jquery');
require('./vendor/jquery-ui');       // just a snippets for autocompletion
require('bootstrap-sass');
require('bootstrap-select');
require('datatables.net')();
require('datatables.net-bs')(window, $);
require('./bootstrap-treeview');            // Tweaked one



