// window._ = require('lodash');
//import '@babel/polyfill';

//import axios from 'axios';
//import Vue from 'vue';
import Notify from './utilities/Notify';

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    require('bootstrap-select');
    require('bootstrap-select/js/i18n/defaults-cs_CZ.js');
    require('datatables.net');
    require('datatables.net-bs4');
    require('datatables.net-select-bs4');
    require('admin-lte');
    require('typeahead.js');
    require('./bootstrap-treeview');
} catch (e) {}

//window.axios = axios;
//window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Notify = Notify;

const top = $('#top');
const token = document.head.querySelector('meta[name="csrf-token"]');

if (top && token) {
    window.app = {
        $page: top,
        token: token.content,
        lang: document.documentElement.lang.substr(0, 2),
    };
    //window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
