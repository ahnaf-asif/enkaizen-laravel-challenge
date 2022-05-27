window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,

    wsHost: "127.0.0.1",
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});
window.Echo.connector.pusher.connection.bind('connected', function () {
    window.axios.defaults.headers.common['X-Socket-Id'] = window.Echo.socketId();
});
