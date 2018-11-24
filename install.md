## How to install Debrief?

### Requirements

*Debrief* is based on Laravel 5.7, which means **PHP >7.1 is a must**. You're gonna need [`composer`](https://getcomposer.org/download/) to install the project dependencies.

Of course, you can configure any relational DBMS supported by Laravel by updating your `.env` file accordingly.

If you want to customize the CSS theme, you might also want to install `nodejs` / `npm`, but that is only really mandatory if you want to develop.

### Basic stuff

You obviously need to clone this repository first wherever you want to install it. As for any Laravel project, the document root to configure in you web server is actually in the `/public/` directory.

First things first, you have to install the project dependencies that are indicated in the [Composer.json file](composer.json).

```bash
$ composer install --no-dev
```

Then, you need to configure your `.env` file, using `.env.example` as an example. This file contains most notably your DBMS configuration.

Once it is initialized, you can generate a key for the application : 

```bash
$ php artisan key:generate
```

Then, create a link between `/storage/app/public/` and `/public/` so that the images and the uploaded files can be accessed from the web.

```bash
$ php artisan storage:link
```

The basics are now covered, let's carry on.

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