## Laravel Package Boilerplate.

[![Build Status](https://travis-ci.org/mtvbrianking/laravel-js-routes.svg?branch=master)](https://travis-ci.org/mtvbrianking/laravel-js-routes)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mtvbrianking/laravel-js-routes/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mtvbrianking/laravel-js-routes/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/mtvbrianking/laravel-js-routes/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mtvbrianking/laravel-js-routes/?branch=master)
[![StyleCI](https://github.styleci.io/repos/269003528/shield?branch=master)](https://github.styleci.io/repos/269003528)
[![Documentation](https://img.shields.io/badge/Documentation-Blue)](https://mtvbrianking.github.io/laravel-js-routes)

### [Installation](https://packagist.org/packages/bmatovu/laravel-js-routes)

Install via Composer package manager:

```bash
composer require bmatovu/laravel-js-routes
```

### Setup

Set application URL in the environment file.

```
APP_URL="http://localhost:8000"
```

Add application url to base layout head meta.

This will make it available to Javascript

```html
<meta name="app-url" content="{{ config('app.url') }}">
```

### Generate routes

```bash
php artisan js-routes:generate
```

Routes will be written to a json file

### Publish resources

Publish Javascript router.

```bash
php artisan vendor:publish --provider="Bmatovu\JsRoutes\JsRoutesServiceProvider" --tag="resources"
```

Load Javascript router.

```js
var router = require('./router.js');

window.route = router.route;
```

### Complie JS routes

```bash
npm run dev
```

### Usage

In you routes file; `web.php` make sure to use named routes.

```php
Route::get()->name('');
```

In Javascript; just get the route by name.

```js
ajax: {
    type: 'GET',
    url: route('users.index')
}

ajax: {
    type: 'DELETE',
    url: route('users.delete', user.id)
}
```
