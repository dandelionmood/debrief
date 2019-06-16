## How to install Debrief?

**This guide covers the installation using the zip archive file.**

If you plan on developing or simply want more flexibility, go to [develop.md] to get all the informations you need to setup the project from scratch.

### Requirements

*Debrief* is based on Laravel 5.7, which means **PHP >7.1 is a must**. [You can find Laravel dependencies here.](https://laravel.com/docs/5.7/installation#server-requirements)

Of course, you can configure any relational DBMS supported by Laravel by updating your `.env` file accordingly.

### Installation

This guide will present the zip archive installation method, which is the most straightforward if you don't want to develop afterwards : everything you need has already been downloaded and compiled in the zip archive.

#### Setup document root

You obviously need to download the zip release file and unzip it on your server wherever you want to install Debrief.

You can find the latest stable release here : https://github.com/dandelionmood/debrief/releases 

As for any Laravel project, the document root to configure in you web server is actually in the `/public/` directory.

#### Create environment file

**The only thing you need to do is to create your own `.env` file, using `.env.example` as an example.** 

This file contains most notably your DBMS configuration.

Once it is initialized, you can generate a key for the application (for security purposes) : 

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