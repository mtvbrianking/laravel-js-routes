## Laravel JS Routes.

[![Build Status](https://travis-ci.org/mtvbrianking/laravel-js-routes.svg?branch=master)](https://travis-ci.org/mtvbrianking/laravel-js-routes)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mtvbrianking/laravel-js-routes/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mtvbrianking/laravel-js-routes/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/mtvbrianking/laravel-js-routes/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mtvbrianking/laravel-js-routes/?branch=master)
[![StyleCI](https://github.styleci.io/repos/269003528/shield?branch=master)](https://github.styleci.io/repos/269003528)
[![Documentation](https://img.shields.io/badge/Documentation-Blue)](https://mtvbrianking.github.io/laravel-js-routes)

This minimalistic package will help you access exisiting PHP routes via JavaScript. 

### [Installation](https://packagist.org/packages/bmatovu/laravel-js-routes)

Install via Composer package manager:

```bash
composer require bmatovu/laravel-js-routes
```

### Setup

Set application URL in the environment file; `.env`.

```properties
APP_URL="http://localhost:8000"
```

Add application URL to base layout head meta; usually in `resources/views/layouts/app.blade.php`

```html
<meta name="app-url" content="{{ config('app.url') }}">
```

### Generate routes

```bash
php artisan js-routes:generate
```

Routes will be written to a json file: `resources/js/routes.json`

_You should `.gitignore` the above auto-generated file._

### Publish resources

Publish JavaScript router to `resources/js`

```bash
php artisan vendor:publish --provider="Bmatovu\JsRoutes\JsRoutesServiceProvider"
```

**Using Webpack | Laravel Mix**

Load JavaScript router; usually in `resources/js/app.js`

```js
window.route = require('./router.js').route;

console.log(route('login'));
```

**Using ViteJS**

```js
import { route } from './router.mjs';
window.route = route;

console.log(route('login'));
```

### Compile JS routes

```bash
npm run dev
```

### Usage

Sample Laravel (named) routes

```php
$int = '^\d+$';

Route::pattern('post', $int);
Route::pattern('comment', $int);

Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
    Route::get('/', 'PostController@index')->name('index');
    Route::get('/{post}/comments/{comment?}', 'PostController@comments')->name('comments');
    Route::delete('/{post}', 'PostController@destroy')->name('destroy');
});
```

In JavaScript; just get the route by name.

```javascript
axios.get(route('posts.index'));
// http://localhost:8000/posts

axios.get(route('posts.comments', {'post': post.id}));
// http://localhost:8000/posts/1/comments

axios.get(route('posts.comments', {'post': post.id, 'comment': comment.id}));
// http://localhost:8000/posts/1/comments/4

axios.get(route('posts.comments', {'post': post.id, 'comment': comment.id, 'page': 2, 'size': 10}));
// http://localhost:8000/posts/1/comments/4?page=2&size=10

axios.delete(route('posts.destroy', {'post': post.id}));
// http://localhost:8000/posts/1

axios.get(route('posts.index', {'published-at': '2020-09-23 16:42:12'}));
// http://localhost:8000/posts?published-at=2020-09-23%2016:42:12

axios.get(route('posts.index', {'with': ['author', 'comments']}));
// http://localhost:8000/posts?with=author,comments

axios.get(route('posts.index', {'with[0]': 'author', 'with[1]': 'comments'}));
// http://localhost:8000/posts?with[0]=author&with[1]=comments
```
