/* import PNotify from 'pnotify/dist/es/PNotify.js';
import PNotifyButtons from 'pnotify/dist/es/PNotifyButtons.js'; */

var PNotify = require('pnotify/dist/umd/PNotify');
var PNotifyButtons = require('pnotify/dist/umd/PNotifyButtons');

PNotify.defaults.styling = 'bootstrap4';
PNotify.defaults.icons = 'fontawesome5';
PNotify.defaults.delay = 10000;

class Notify {
    constructor(type, data, trusted = false) {
        if (typeof data === 'object') {
            for (let key in data) {
                if (!data.hasOwnProperty(key)) continue;

                new PNotify({
                    target: document.body,
                    data: {
                        text: data[key],
                        type: type,
                        textTrusted: trusted
                    },
                });
            }
        } else if (typeof data === 'string') {
            new PNotify({
                target: document.body,
                data: {
                    text: data,
                    type: type,
                    textTrusted: trusted
                },
            });
        }
    }
}

export default Notify;
