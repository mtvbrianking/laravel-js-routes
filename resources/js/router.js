var routes = require('./routes.json');

var appUrl = document.head.querySelector('meta[name="app-url"]').content;

if (!String.prototype.endsWith) {
    String.prototype.endsWith = function(search, this_len) {
        if (this_len === undefined || this_len > this.length) {
            this_len = this.length;
        }
        return this.substring(this_len - search.length, this_len) === search;
    };
}

exports.route = function(name, params) {
    if (routes[name] === undefined) {
        console.error('Unknown route ', name);
        return false;
    }

    if (params === null || typeof params !== 'object') {
        return appUrl + '/' + routes[name];
    }

    var path = routes[name]
        .split('/')
        .map(function (part) {
            if (part === null) {
                return '';
            }

            if (part[0] != '{') {
                return part;
            }

            var param = part.match(/[^{\}]+/g)[0];

            if (param.endsWith('?')) {
                param = param.slice(0, -1);
            }

            var value = params['' + param];

            delete params['' + param];

            return value;
        })
        .join('/')
        .replace(/\/+$/g, '');

    var query = Object.keys(params)
        .map(function (key) {
            return key + '=' + params[key];
        })
        .join('&');

    return query ? appUrl + '/' + path + '?' + encodeURI(query) : appUrl + '/' + path;
}
