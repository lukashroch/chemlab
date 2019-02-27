//window._ = require('lodash');
window.Popper = require('popper.js').default;

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    require('bootstrap-select');
    require('bootstrap-select/js/i18n/defaults-cs_CZ.js');
    require('datatables.net');
    require('datatables.net-bs4');
    require('datatables.net-select-bs4');

    //require('./vendor/typeahead.jquery');
    //require('./vendor/bloodhound');
    //require('./bootstrap-treeview');
} catch (e) {
}

import axios from 'axios';
import Vue from 'vue';
import Notify from './utilities/Notify';
import Form from './utilities/Form';

//window.axios = axios;
//window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Vue = Vue;
window.Notify = Notify;

function App(page, token, lang) {
    this.$page = page;
    this.token = token;
    this.lang = lang;
}

const top = document.getElementById('top');
const token = document.head.querySelector('meta[name="csrf-token"]');
const lang = document.documentElement.lang.substr(0, 2);

window.app = new App($(top), token.content, lang);

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
