var routes = require('./routes.json');

exports.route = function() {
    var args = Array.prototype.slice.call(arguments);
    var name = args.shift();

    if (routes[name] === undefined) {
        console.error('Unknown route ', name);
    } else {
        var appUrl = document.querySelector('meta[name="app-url"]').content;

        return appUrl + '/' + routes[name]
            .split('/')
            .map(s => s[0] == '{' ? args.shift() : s)
            .join('/');
    }
};
