## How to develop Debrief?

### Requirements

*Debrief* is based on Laravel 6, which means **PHP >7.2 is a must**. [You can find Laravel dependencies here.](https://laravel.com/docs/6.x/#server-requirements)

You're gonna need [`composer`](https://getcomposer.org/download/) to install the project dependencies.

Of course, you can configure any relational DBMS supported by Laravel by updating your `.env` file accordingly.

If you want to customize the CSS theme, you might also want to install `nodejs` / `npm`, but that is only really mandatory if you want to develop on the JS and CSS side of things.

### Basic stuff

You obviously need to clone this repository first wherever you want to install it. As for any Laravel project, the document root to configure in you web server is actually in the `/public/` directory.

First things first, you have to install the project dependencies that are indicated in the [Composer.json file](composer.json).

```bash
$ composer install
```

Then, you need to create your `.env` file, using `.env.example` as an example. This file contains most notably your DBMS configuration.

Once it is initialized, you can generate a key for the application (for security purposes): 

```bash
$ php artisan key:generate
```

Then, create a link between `/storage/app/public/` and `/public/` so that the images and the uploaded files can be accessed from the web.

```bash
$ php artisan storage:link
```

The basics are now covered, let's carry on.

### Assets compilation

You need to compile JS and CSS files using Mix, a library provided by Laravel to help with the development of Javascript and SASS in a Laravel environment. [See the documentation to learn the in and outs](https://laravel.com/docs/6.x/mix).

First you need to create the translation files :

```bash
$ php artisan js-localization:export
```

Then, the main operation you need to do to get started is to compile JS and CSS in development mode (non minified) :

```bash
$ npm run development
```

### Database initialization

We need to initialize your database using the provided migration files : they contain everything that is needed.

```bash
$ php artisan migrate
```

If everything went fine, your DB is now properly setup.

You still don't have a user to connect to : we're going to add it by running a last script.

```bash
$ php artisan app:init
```

Give an email, a password and voilà! You should now be able to connect to your new account.

## Run the test suite

There are already a few unit tests in place, you can run them using PHPUnit: 

```bash
pierre@pierre-maison:~/Sources/debrief$ vendor/bin/phpunit 
PHPUnit 7.5.20 by Sebastian Bergmann and contributors.

........                                                            8 / 8 (100%)

Time: 635 ms, Memory: 108.00 MB

OK (8 tests, 87 assertions)
```

You can find the tests in the `tests/` directory at the root of the project.

## Adding new functionality

Don't hesitate to reach me beforehand if you want to add a new feature to Debrief.

Once you're done, you can give me access to your contributing via a pull request on Github. 

Standards that apply are fairly common: 

- [PSR-1 code formatting](https://www.php-fig.org/psr/psr-1/) ;
- the presence of unit tests is **strongly** encouraged where that makes sense.

### Themes

Though Debrief ships with a number of themes, you can easily tweak them and add your own.

Although you can add your own complex stylesheet, theming is made really easy **using Slack-style colors declarations**.

The operation is actually split in three parts:

1. create your theme (or modify an existing one) in `resources/assets/sass/theme-*.scss`;
2. then, add the theme declaration to the `webpack.mix.js` file at the root to have it compiled;
3. to make it available to the app, declare it in `config/app.php` at the `themes` index as well.

For example, here is what `theme-benext.scss` looks like :

````sass
// 
// Benext theme
// 
$mix-theme-colors: '#E3E6EA,#EDEFF1,#D1571C,#FFFFFF,#1DB3C5,#333232,#48B8AD,#D3561A';
@import "theme/common";
````

Themes colors are analyzed by SASS and used throughout the application.

You can find more of these strings here, for instance: https://slackthemes.net/#/aubergine